<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationCodeMail;
use App\Utils\ErrorManager;
use Exception;
use Illuminate\Support\Str;
class Authcontroller extends Controller
{
    //methode d'inscription

    public function inscription(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nom_user' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:8',
        'tel_user' => 'required|string|min:9|unique:users,tel_user',
        'tbl_filiere_id' => 'required|exists:tbl_filieres,id'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Enregistrez les informations de l'utilisateur dans la session avant la vérification de l'e-mail
    $request->session()->put('user_data', $request->only(['nom_user', 'email', 'tel_user', 'password', 'tbl_filiere_id']));

    // Envoyez le code de vérification à l'utilisateur
    return $this->sendVerificationCode($request->email);
}


    public function sendVerificationCode($email)
    {
        $verificationCode = Str::random(6); // Générer un code de vérification de 6 caractères

        // Enregistrez le code de vérification dans la session de l'utilisateur
        session()->put('verification_code', $verificationCode);

        // Envoyer l'e-mail avec le code de vérification
        Mail::raw("Votre code de vérification est : $verificationCode", function ($message) use ($email) {
            $message->to($email)->subject('Code de vérification');
        });

        return response()->json(['message' => 'Code de vérification envoyé par e-mail']);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|min:6|max:6',
        ]);

        // Récupérez le code de vérification de la session de l'utilisateur
        $verificationCode = $request->session()->get('verification_code');

        if (!$verificationCode) {
            return response()->json(['message' => 'Code de vérification expiré ou non trouvé'], 404);
        }

        // Comparez le code soumis par l'utilisateur avec celui stocké en session
        if ($request->code !== $verificationCode) {
            return response()->json(['message' => 'Code de vérification incorrect'], 400);
        }

        // Récupérez les informations de l'utilisateur de la session
        $userData = $request->session()->get('user_data');

        if (!$userData) {
            return response()->json(['message' => 'Les informations de l\'utilisateur ne sont pas trouvées'], 400);
        }

        // Créez l'utilisateur dans la base de données
        $user = User::create([
            'nom_user' => $userData['nom_user'],
            'email' => $userData['email'],
            'tel_user' => $userData['tel_user'],
            'tbl_filiere_id' => $userData['tbl_filiere_id'],
            'password' => bcrypt($userData['password']), // N'oubliez pas de hacher le mot de passe
        ]);

        // Nettoyez les informations de la session après la création de l'utilisateur
        $request->session()->forget(['verification_code', 'user_data']);

        return response()->json(['message' => 'Adresse e-mail vérifiée avec succès et utilisateur créé', 'user' => $user], 201);
    }



   // methode de connexion
    public function connexion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>"Access non autorise"],401);
        }

        $user = User::where('email', $request->email)->first();
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Access autorisé',
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
        ], 200);
    }



    public function deconnexion()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        if($user instanceOf User){
            $user->tokens()->delete();
            Auth::logout();
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        }else{
            return response()->json(['message' => 'Aucun utilisateur connecte'], 500);
        }
    }

}
