<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use App\Notifications\ProjectSubmittedNotification;
use App\Models\User;
use App\Models\TblProjet;
use Illuminate\Http\Request;

class SoumissionController extends Controller
{
    public function submitProject(Request $request)
{
    $project = TblProjet::find($request->project_id);

    if (!$project) {
        return response()->json(['message' => 'Projet introuvable.'], 404);
    }

    // Vérifiez que le projet a au moins un document avant de le soumettre
    if ($project->documents()->count() < 1) {
        return response()->json(['message' => 'Le projet doit avoir au moins un document pour être soumis.'], 400);
    }

    $project->soumis = true;
    $project->status = 'Pending';
    $project->save();

    // Envoyer une notification à tous les administrateurs
    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new ProjectSubmittedNotification($project));
    }

    return response()->json(['message' => 'Projet soumis avec succès.']);
}
}
