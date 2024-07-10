<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectView;
use App\Models\TblProjet;

class ProjectViewController extends Controller
{
    public function addView($id, Request $request)
    {
        $ipAddress = $request->ip();

        // Vérifier si la vue existe déjà
        $viewExists = ProjectView::where('tbl_projet_id', $id)->where('ip_address', $ipAddress)->exists();

        if ($viewExists) {
            return response()->json(['message' => 'You have already viewed this project.'], 200);
        }

        // Ajouter une nouvelle vue
        ProjectView::create([
            'tbl_projet_id' => $id,
            'ip_address' => $ipAddress,
        ]);

        // Incrémenter le compteur de vues du projet
        $project = TblProjet::findOrFail($id);
        $project->increment('views');

        return response()->json([
            'message' => 'View added successfully',
            'views' => $project->views,
        ]);
    }
}
