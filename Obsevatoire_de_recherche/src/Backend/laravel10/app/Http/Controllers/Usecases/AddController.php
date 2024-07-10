<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblProjet;
use App\Models\TblDocument;

class AddController extends Controller
{
    public function ajouterDocument(Request $request, $id)
    {
        // Validation des entrées
        $validatedData = $request->validate([
            'nom_doc' => 'required|string|max:255',
            'lien_doc' => 'required',
            'type_doc' => 'required|string|in:PDF,WORD,POWEPOINT',
            'resume' => 'required|string',
        ]);

        // Récupération du projet
        $projet = TblProjet::findOrFail($id);

        // Récupération de l'utilisateur associé au projet
        $user = $projet->user;

        // Création du document
        $document = new TblDocument([
            'nom_doc' => $validatedData['nom_doc'],
            'lien_doc' => $validatedData['lien_doc'],
            'type_doc' => $validatedData['type_doc'],
            'resume' => $validatedData['resume'],
           'user_id' => $user ? $user->id : null, // Utilisateur associé au projet
           'tbl_projet_id' => $projet->id, // Associe le document au projet
        ]);

        // Associe le document au projet
        $document->save();

        return response()->json([
            'message' => 'Document ajouté avec succès',
            'document' => $document,
        ], 201);
    }

    public function ajouterCollaborateur(Request $request, $id)
    {

        // fais ta methode ici en suivant l'exemple precedent et en adaptant juste en fonction des collaborateur
    }

}
