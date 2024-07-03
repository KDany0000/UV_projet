<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        // Valider la requête pour s'assurer qu'un fichier est présent
        $request->validate([
            'file' => 'required|file',
            'path' => 'required|string',
        ]);


        // Récupérer le fichier et le chemin
        $file = $request->file('file');
        $path = 'public/' . $request->input('path');

        // Générer un nom de fichier unique pour éviter les conflits
        $fileName = $file->getClientOriginalName();

        // Sauvegarder le fichier dans le chemin spécifié
        $finalPath = $file->storeAs($path, $fileName);

        // Récupérer l'URL publique du fichier
        $publicUrl = Storage::url($finalPath);

        // Retourner l'URL publique du fichier sous forme de JSON
        return response()->json(['url' => $publicUrl], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function deleteFile(Request $request)
    {
        // Valider la requête pour s'assurer que le chemin du fichier est fourni
        $request->validate([
            'path' => 'required|string',
        ]);

        // Récupérer le chemin du fichier à partir de la requête
        $path = 'public/' . $request->input('path');


        // Supprimer le fichier du système de fichiers
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['message' => 'File deleted successfully.']);
        } else {
            return response()->json(['message' => 'File not found.'], 404);
        }
    }
}
