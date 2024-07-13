<?php

namespace App\Http\Controllers\Usecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblCategorie;
use App\Models\TblProjet;

class APIAcceuilController extends Controller
{
    public function index()
    {
        // Récupérer toutes les catégories avec le nombre de projets approuvés associés
        $categories = TblCategorie::withCount(['projets' => function($query) {
            $query->where('status', 'Approved');
        }])->get();
    
        // Retourner les résultats en JSON
        return response()->json($categories);
    }
    

    public function listerProjets()
    {
        $projets = TblProjet::with(['categorie', 'user'])->get();

        $resultats = $projets->map(function($projet) {
            return [
                'id' => $projet->id,
                'titre_projet' => $projet->titre_projet,
                'descript_projet' => $projet->descript_projet,
                'image' => $projet->image,
                'nom_categorie' => $projet->categorie->nom_cat,
                'nom_utilisateur' => $projet->user->nom_user,
                'created_at' => $projet->created_at,
                'updated_at' => $projet->updated_at,
            ];
        });

        return response()->json($resultats);
    }

    public function listerProjetsParDate()
    {
        $projets = TblProjet::with(['categorie', 'user'])
                            ->where('status', 'Approved')
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        $resultats = $projets->map(function($projet) {
            return [
                'id' => $projet->id,
                'titre_projet' => $projet->titre_projet,
                'descript_projet' => $projet->descript_projet,
                'image' => $projet->image,
                'nom_categorie' => $projet->categorie->nom_cat,
                'nom_utilisateur' => $projet->user->nom_user,
                'created_at' => $projet->created_at,
                'updated_at' => $projet->updated_at,
            ];
        });
    
        return response()->json($resultats);
    }
    
}
