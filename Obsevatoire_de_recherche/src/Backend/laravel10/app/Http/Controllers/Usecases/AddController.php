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
        // Validation des entrées
        $validatedData = $request->validate([
            'nom_collab' => 'required|string|max:255|unique:tbl_collaborateurs', // Enforce unique collaborator name
            'email_collab' => 'required|email|unique:tbl_collaborateurs', // Enforce unique collaborator email
            'role_collaborateur' => 'required|string|in:administrateur,editeur,consultant',
        ]);

        // Récupération du projet
        $projet = TblProjet::findOrFail($id);

        // Vérifier si l'utilisateur actuel est le propriétaire du projet
        if ($projet->user_id != auth()->user()->id) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à ajouter des collaborateurs à ce projet',
            ], 403);
        }

        // Créer un nouvel enregistrement dans la table tbl_collaborateurs
        $collaborateur = TblCollaborateur::create([
            'nom_collab' => $validatedData['nom_collab'],
            'email_collab' => $validatedData['email_collab'],
        ]);
        // Associer le collaborateur au projet
        $collaborateurProjet = new TblProjetCollaborateur([
            'tbl_projet_id' => $projet->id,
            'user_id' => $collaborateur->id, // Use collaborator ID from tbl_collaborateurs table
            'role' => $validatedData['role_collaborateur'],
        ]);
        $collaborateurProjet->save();

        // Envoyer un email de notification au collaborateur (optionnel)
        // ... (same as before)

        return response()->json([
            'message' => 'Collaborateur ajouté avec succès',
        ], 201);
    }

}
