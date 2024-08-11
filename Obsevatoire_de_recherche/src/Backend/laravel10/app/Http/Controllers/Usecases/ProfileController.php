<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Services\FileUploadService;

class ProfileController extends Controller
{

    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function show()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom_user' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'tbl_filiere_id' => 'required|exists:tbl_filieres,id'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return response()->json(['message' => 'Profil mis à jour avec succès.', 'user' => $user], 200);
    }

    public function updateProfileImage(Request $request)
{
    // Valider le fichier image
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Récupérer l'utilisateur authentifié
    $user = Auth::user();

    // Gérer l'image précédente si elle existe (par exemple, la supprimer)
    if ($user->profile_image) {
        $this->fileUploadService->deleteFile($user->profile_image);
    }

    // Télécharger la nouvelle image
    $path = $this->fileUploadService->uploadFile($request->file('image'), 'public/profile_images');

    // Mettre à jour le chemin de l'image dans le profil de l'utilisateur
    $user->profile_image = $path;
    $user->save();

    // Retourner une réponse avec succès
    return response()->json(['message' => 'Image de profil mise à jour avec succès!', 'image_path' => $path], 200);
}
}

