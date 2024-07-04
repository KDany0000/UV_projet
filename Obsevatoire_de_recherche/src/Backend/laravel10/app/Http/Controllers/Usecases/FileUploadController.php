<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileUploadController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/usecases/upload",
     *     summary="Télécharger un fichier",
     *     tags={"Fichiers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="file", type="string", format="binary", description="Fichier à télécharger"),
     *                 @OA\Property(property="path", type="string", description="Chemin où le fichier sera stocké")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL publique du fichier téléchargé",
     *         @OA\JsonContent(
     *             @OA\Property(property="url", type="string", example="http://example.com/storage/public/path/to/file.txt")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation échouée"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/usecases/upload/delete",
     *     summary="Supprimer un fichier",
     *     tags={"Fichiers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="path", type="string", description="Chemin du fichier à supprimer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fichier supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="File deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fichier non trouvé"
     *     )
     * )
     */
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
