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
        try{
            $user = User::create([
                'nom_user' => $request->nom_user,
                'email' => $request->email,
                'tel_user' => $request->tel_user,
                'tbl_filiere_id' => $request->tbl_filiere_id,
                'password' => $request->password,
            ]);

            $token = Str::random(64);

            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            Mail::send('emails.confirmation_code_plain', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
            });
            return response()->json($user, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
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

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        if(!is_null($verifyUser) ){

            $user = $verifyUser->user;
            if(is_null($user->email_verified_at)) {
                $verifyUser->user->email_verified_at = now();
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login";
            } else {
                $message = "Your e-mail is already verified. You can now login";
            }
            return view('confirmation_message',compact('message'));
        }
    }

}
