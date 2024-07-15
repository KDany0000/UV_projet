<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;



class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/usecases/auth/inscription",
     *     summary="Inscription de l'utilisateur",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom_user", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="tbl_filiere_id", type="integer", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Code de vérification envoyé par e-mail"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function inscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_user' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'tbl_filiere_id' => 'required|exists:tbl_filieres,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Enregistrez les informations de l'utilisateur dans la session avant la vérification de l'e-mail
        $request->session()->put('user_data', $request->only(['nom_user', 'email', 'password', 'tbl_filiere_id']));

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

    /**
     * @OA\Post(
     *     path="/api/usecases/auth/verify",
     *     summary="Vérification du code",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="code", type="string", example="ABC123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Adresse e-mail vérifiée avec succès et utilisateur créé"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Code de vérification incorrect"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Code de vérification expiré ou non trouvé"
     *     )
     * )
     */
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
            'tbl_filiere_id' => $userData['tbl_filiere_id'],
            'password' => bcrypt($userData['password']), // N'oubliez pas de hacher le mot de passe
        ]);

        // Nettoyez les informations de la session après la création de l'utilisateur
        $request->session()->forget(['verification_code', 'user_data']);

        return response()->json(['message' => 'Adresse e-mail vérifiée avec succès et utilisateur créé', 'user' => $user], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/usecases/auth/connexion",
     *     summary="Connexion de l'utilisateur",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Access autorisé",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Access autorisé"),
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erreur de validation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Access non autorisé"
     *     )
     * )
     */
    public function connexion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => "Access non autorisé"], 401);
        }

        $user = User::where('email', $request->email)->first();
        $username = $user->nom_user;
        $role = $user->role;
        $projets = $user->projets()->with('niveau', 'categorie')->get(['titre_projet', 'descript_projet', 'type', 'views', 'status' ,'image', 'tbl_niveau_id', 'tbl_categorie_id', 'created_at']);

        $projets = $projets->map(function($projet) {
            return [
                'titre' => $projet->titre_projet,
                'description' => $projet->descript_projet,
                'type' => $projet->type,
                'views' => $projet->views,
                'image' => $projet->image,
                'status' => $projet->status,
                'niveau' => $projet->niveau->code_niv, 
                'categorie' => $projet->categorie->nom_cat,
                'created_at' => $projet->created_at, 
            ];
        });

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Access autorisé',
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'username' => $username,
            'role' => $role,
            'projets' => $projets,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="api/auth/deconnexion",
     *     summary="Déconnexion de l'utilisateur",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Aucun utilisateur connecté"
     *     )
     * )
     */
    public function deconnexion()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        if ($user instanceof User) {
            $user->tokens()->delete();
            Auth::logout();
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        } else {
            return response()->json(['message' => 'Aucun utilisateur connecté'], 500);
        }
    }
}
