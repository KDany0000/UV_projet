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

        // Incrémenter le compteur de vues du projet
        $project = TblProjet::findOrFail($id);
        $project->increment('views');

        return response()->json([
            'message' => 'View added successfully',
            'views' => $project->views,
        ]);
    }

}
