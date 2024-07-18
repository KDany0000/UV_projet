<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use App\Models\TblProjet;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ProjectStatusChangeNotification;

use Illuminate\Http\Request;

class ProjectStatusController extends Controller
{

    public function approvePendingProject($projectId)
    {
        $project = TblProjet::find($projectId);

        if ($project && ($project->status === 'Pending' || $project->status === 'Rejected')) {
            $project->status = 'Approved';
            $project->save();

            // Envoi de la notification à l'utilisateur
            $message = "Votre projet \"{$project->titre_projet}\" a été approuvé.";
            $project->user->notify(new ProjectStatusChangeNotification($project, 'Approved', $message));

            return response()->json(['message' => 'Projet approuvé avec succès.']);
        }

        return response()->json(['message' => 'Projet introuvable ou déjà approuvé/rejeté.'], 404);
    }

    public function rejectPendingProject($projectId)
    {
        $project = TblProjet::find($projectId);

        if ($project && ($project->status === 'Pending' || $project->status === 'Approved')) {
            $project->status = 'Rejected';
            $project->save();

            // Envoi de la notification à l'utilisateur
            $message = "Votre projet \"{$project->titre_projet}\" a été rejeté.";
            $project->user->notify(new ProjectStatusChangeNotification($project, 'Rejected', $message));

            return response()->json(['message' => 'Projet rejeté avec succès.']);
        }

        return response()->json(['message' => 'Projet introuvable ou déjà approuvé/rejeté.'], 404);
    }

    public function rejectApprovedProject($projectId)
    {
        $project = TblProjet::find($projectId);

        if ($project && $project->status === 'Approved') {
            $project->status = 'Rejected';
            $project->save();

            // Envoi de la notification à l'utilisateur
            $message = "Votre projet \"{$project->titre_projet}\" a été rejeté après approbation.";
            $project->user->notify(new ProjectStatusChangeNotification($project, 'Rejected', $message));

            return response()->json(['message' => 'Projet rejeté avec succès.']);
        }

        return response()->json(['message' => 'Projet introuvable ou déjà en attente/rejeté.'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        // Valider la requête
        $request->validate([
            'status' => ['required', 'in:Not Submit,Pending,Approved,Rejected'],
        ]);

        // Trouver le projet par ID
        $project = TblProjet::findOrFail($id);

        // Mettre à jour le statut
        $project->status = $request->input('status');
        $project->save();

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'Statut du projet mis à jour avec succès',
            'project' => $project
        ], 200);
    }


}
