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
        // Récupérer toutes les catégories avec le nombre de projets approuvés associés, et charger les relations nécessaires
        $categories = TblCategorie::with(['projets' => function($query) {
            $query->where('status', 'Approved')->with(['niveau', 'user.filiere.faculte']);
        }])->withCount(['projets' => function($query) {
            $query->where('soumis', true)->where('status', 'Approved');
        }])->get();

        // Formater les résultats pour inclure les détails des projets approuvés
        $formattedCategories = $categories->map(function ($category) {
            return [
                'nom_cat' => $category->nom_cat,
                'descript_cat' => $category->descript_cat,
                'icone'=>$category->icone,
                'projets_count' => $category->projets_count,
                'details' => $category->projets->map(function ($project) {
                    return [
                        'filiere' => optional($project->user->filiere)->nom_fil,
                        'faculte' => optional($project->user->filiere->faculte)->nom_fac,
                        'niveau' => optional($project->niveau)->code_niv,
                    ];
                })
            ];
        });

        // Retourner les résultats en JSON
        return response()->json($formattedCategories);
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
        $projets = TblProjet::with(['categorie', 'user','niveau'])
                            ->where('status', 'Approved')
                            ->where('soumis', true)
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
                'email' => $projet->user->email,
                'filiere'=>$projet->user->filiere->nom_fil,
                'niveau'=>$projet->niveau->code_niv,
                'type' => $projet->type,
                'views' => $projet->views,
                'created_at' => $projet->created_at,
                'updated_at' => $projet->updated_at,
            ];
        });

        return response()->json($resultats);
    }

}
