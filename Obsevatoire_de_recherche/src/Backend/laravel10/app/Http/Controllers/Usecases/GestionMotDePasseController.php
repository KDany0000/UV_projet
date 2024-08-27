<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GestionMotDePasseController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/usecases/password/sendVerificationCode",
     *     summary="Envoyer un code de vérification pour réinitialisation du mot de passe",
     *     tags={"Gestion des mots de passe"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Code de vérification envoyé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="We have sent your verification code!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation échouée",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The email field is required.")
     *         )
     *     )
     * )
     */
    public function sendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Generate a 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Store the verification code and email in the database with an expiration time
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $verificationCode,
                'created_at' => Carbon::now()
            ]
        );

        // Send the verification code via email
        Mail::raw('Your password reset verification code is ' . $verificationCode, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset Verification Code');
        });

        return response()->json(['message' => 'We have sent your verification code!']);
    }

    /**
     * @OA\Post(
     *     path="/api/usecases/password/verifyCode",
     *     summary="Vérifier le code de vérification pour réinitialisation du mot de passe",
     *     tags={"Gestion des mots de passe"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur"),
     *             @OA\Property(property="verification_code", type="string", description="Code de vérification")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Code de vérification valide",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The verification code is valid.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Code de vérification invalide ou expiré",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The verification code is invalid or has expired.")
     *         )
     *     )
     * )
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required',
        ]);

        // Retrieve the record from the database
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->verification_code)
            ->first();

        // Check if the verification code is valid and not expired (e.g., 60 minutes)
        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['message' => 'The verification code is invalid or has expired.'], 422);
        }

        return response()->json(['message' => 'The verification code is valid.']);
    }

    /**
     * @OA\Post(
     *     path="/api/usecases/password/resetpassword",
     *     summary="Réinitialiser le mot de passe avec le code de vérification",
     *     tags={"Gestion des mots de passe"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur"),
     *             @OA\Property(property="password", type="string", format="password", description="Nouveau mot de passe", minLength=8),
     *             @OA\Property(property="password_confirmation", type="string", format="password", description="Confirmation du nouveau mot de passe", minLength=8),
     *             @OA\Property(property="verification_code", type="string", description="Code de vérification")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mot de passe réinitialisé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password has been reset successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation échouée",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The email field is required.")
     *         )
     *     )
     * )
     */
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
            'verification_code' => 'required',
        ]);

        try {
            // Retrieve the record from the database
            $passwordReset = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('token', $request->verification_code)
                ->first();

            // Check if the verification code is valid and not expired (e.g., 60 minutes)
            if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
                throw new \Exception('The verification code is invalid or has expired.');
            }

            // Reset the password
            $user = \App\Models\User::where('email', $request->email)->first();
            if (!$user) {
                throw new \Exception('No user found with this email address.');
            }

            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the password reset record
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Password has been reset successfully.']);
        } catch (\Exception $e) {
            // Return a 422 Unprocessable Entity response with the error message
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

}
