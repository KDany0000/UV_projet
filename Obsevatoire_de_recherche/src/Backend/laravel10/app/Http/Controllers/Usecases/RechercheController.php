<?php

namespace App\Http\Controllers\Usecases;

use Illuminate\Http\Request;
use App\Models\TblProjet;
use App\Http\Controllers\Controller;
use App\Models\TblCategorie;
use App\Models\TblDocument;
use App\Models\TblCollaborateur;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class RechercheController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/usecases/search",
     *     summary="Rechercher des projets et des catégories",
     *     tags={"Recherche"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Texte de recherche pour les projets et les catégories"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des projets et des catégories correspondants",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="projets", type="array", @OA\Items(ref="#/components/schemas/TblProjet")),
     *             @OA\Property(property="categories", type="array", @OA\Items(ref="#/components/schemas/TblCategorie"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requête invalide"
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = collect();

        // Recherche des catégories avec Elasticsearch via Scout
        $categoryResults = TblCategorie::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'tbl_categories',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['nom_cat^3', 'nom_cat.ngram'],
                            'fuzziness' => 'AUTO',
                            'prefix_length' => 1,
                            'operator' => 'and'
                        ],
                    ],
                ],
            ];

            return $client->search($params)->asArray();
        })->get();

        // Charger les projets associés à chaque catégorie
        foreach ($categoryResults as $category) {
            $category->load(['projets.user.filiere', 'projets.niveau']);
        }

        // Formater les résultats des catégories avec les détails des projets
        $formattedCategories = $categoryResults->flatMap(function ($category) {
            return $category->projets->filter(function ($project) {
                return $project->status === 'Approved'; // Filtrer les projets approuvés
            })->map(function ($project) {
                return [
                    'titre_projet' => $project->titre_projet,
                    'nom_categorie' => $project->categorie->nom_cat,
                    'nom_utilisateur' => $project->user->nom_user,
                    'filiere' => optional($project->user->filiere)->nom_fil,
                    'niveau' => optional($project->niveau)->code_niv,
                    'description' => $project->descript_projet,
                    'image' => $project->image,
                    'date_creation' => $project->created_at->format('Y-m-d'),
                ];
            });
        });

        // Recherche des projets avec Elasticsearch via Scout
        $projectResults = TblProjet::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'tbl_projets',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['titre_projet^3', 'titre_projet.ngram'],
                            'fuzziness' => 'AUTO',
                            'prefix_length' => 1,
                            'operator' => 'and'
                        ],
                    ],
                ],
            ];

            return $client->search($params)->asArray();
        })->get();

        // Filtrer et formater les résultats des projets approuvés
        $formattedProjects = $projectResults->filter(function ($project) {
            return $project->status === 'Approved'; // Filtrer les projets approuvés
        })->map(function ($project) {
            return [
                'titre_projet' => $project->titre_projet,
                'nom_categorie' => $project->categorie->nom_cat,
                'nom_utilisateur' => $project->user->nom_user,
                'filiere' => optional($project->user->filiere)->nom_fil,
                'niveau' => optional($project->niveau)->code_niv,
                'description' => $project->descript_projet,
                'image' => $project->image,
                'date_creation' => $project->created_at->format('Y-m-d'),
            ];
        });

        // Recherche des collaborateurs avec Elasticsearch via Scout
        $collaboratorResults = TblCollaborateur::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'tbl_collaborateurs',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['nom_collab^3', 'nom_collab.ngram'],
                            'fuzziness' => 'AUTO',
                            'prefix_length' => 1,
                            'operator' => 'and'
                        ],
                    ],
                ],
            ];

            return $client->search($params)->asArray();
        })->get();

        // Formater les résultats des collaborateurs
        $formattedCollaborators = $collaboratorResults->flatMap(function ($collaborator) {
            return $collaborator->projets->filter(function ($project) {
                return $project->status === 'Approved'; // Filtrer les projets approuvés
            })->map(function ($project) use ($collaborator) {
                return [
                    'titre_projet' => $project->titre_projet,
                    'nom_categorie' => $project->categorie->nom_cat,
                    'nom_utilisateur' => $project->user->nom_user,
                    'nom_collaborateur' => $collaborator->nom_collab,
                    'filiere' => optional($project->user->filiere)->nom_fil,
                    'niveau' => optional($project->niveau)->code_niv,
                    'description' => $project->descript_projet,
                    'image' => $project->image,
                    'date_creation' => $project->created_at->format('Y-m-d'),
                ];
            });
        });

        // Recherche des utilisateurs avec Elasticsearch via Scout
        $userResults = User::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'users',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['nom_user^3', 'nom_user.ngram'],
                            'fuzziness' => 'AUTO',
                            'prefix_length' => 1,
                            'operator' => 'and'
                        ],
                    ],
                ],
            ];

            return $client->search($params)->asArray();
        })->get();

        // Formater les résultats des utilisateurs
        $formattedUsers = $userResults->flatMap(function ($user) {
            return $user->projets->filter(function ($project) {
                return $project->status === 'Approved'; // Filtrer les projets approuvés
            })->map(function ($project) use ($user) {
                return [
                    'titre_projet' => $project->titre_projet,
                    'nom_categorie' => $project->categorie->nom_cat,
                    'nom_utilisateur' => $user->nom_user,
                    'filiere' => optional($user->filiere)->nom_fil,
                    'niveau' => optional($project->niveau)->code_niv,
                    'description' => $project->descript_projet,
                    'image' => $project->image,
                    'date_creation' => $project->created_at->format('Y-m-d'),
                ];
            });
        });

        // Combiner les résultats des catégories, projets, collaborateurs et utilisateurs
        $results = $formattedCategories->merge($formattedProjects)
                                       ->merge($formattedCollaborators)
                                       ->merge($formattedUsers);

        // Filtrer les doublons
        $uniqueResults = $results->unique('titre_projet')->values();

        // Retourner les résultats au format JSON
        return response()->json(['results' => $uniqueResults]);
    }


public function searchCategories(Request $request)
{
    $query = $request->input('query');

    // Recherche des catégories avec Elasticsearch via Scout
    $categoryResults = TblCategorie::search($query, function ($client, $body) use ($query) {
        $params = [
            'index' => 'tbl_categories',
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['nom_cat^3', 'nom_cat.ngram'],
                        'fuzziness' => 'AUTO',
                        'prefix_length' => 1,
                        'operator' => 'and'
                    ],
                ],
            ],
        ];

        return $client->search($params)->asArray();
    })->get();

    // Charger le nombre de projets associés à chaque catégorie
    $formattedCategories = $categoryResults->map(function ($category) {
        $projectCount = $category->projets()->count();
        return [
            'nom_cat' => $category->nom_cat,
            'descript_cat' => $category->descript_cat,
            'icone' => $category->icone,
            'projets_count' => $projectCount,
        ];
    });

    // Retourner les résultats au format JSON
    return response()->json(['results' => $formattedCategories]);
}









    /**
     * @OA\Get(
     *     path="/api/usecases/search/Documents",
     *     summary="Rechercher des documents",
     *     tags={"Recherche"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Texte de recherche pour les documents"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des documents correspondants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TblDocument")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requête invalide"
     *     )
     * )
     */
    public function searchDocuments(Request $request)
    {
        $query = $request->input('query');

        // Recherche des documents avec Elasticsearch via Scout
        $documentResults = TblDocument::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'tbl_documents',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['nom_doc^3', 'nom_doc.ngram'],
                            'fuzziness' => 'AUTO',
                            'prefix_length' => 1,
                            'operator' => 'and'
                        ],
                    ],
                ],
            ];

            return $client->search($params)->asArray();
        })->get();

        // Formater les résultats des documents
        $formattedDocuments = $documentResults->map(function ($document) {
            return [
                'nom_document' => $document->nom_doc,
                'description' => $document->description,
                'path' => $document->path,
                'date_creation' => $document->created_at->format('Y-m-d'),
                'projet_associe' => optional($document->projet)->titre_projet,
                'auteur' => optional($document->user)->name,
            ];
        });

        // Retourner les résultats au format JSON
        return response()->json(['results' => $formattedDocuments]);
    }




    public function search2(Request $request)
{
    $query = $request->input('query');
    $results = [];

    // Search Projects
    $projectResults = TblProjet::search($query, function ($client, $body) use ($query) {
        $params = [
            'index' => 'tbl_projets',
            'body'  => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => [
                                    'titre_projet' => [
                                        'query' => $query,
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                            [
                                'match' => [
                                    'descript_projet' => [
                                        'query' => $query,
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                            [
                                'prefix' => [
                                    'titre_projet' => [
                                        'value' => $query,
                                    ],
                                ],
                            ],
                            [
                                'prefix' => [
                                    'descript_projet' => [
                                        'value' => $query,
                                    ],
                                ],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
            ],
        ];

        return $client->search($params)->asArray();
    })->get();

    $projects = $projectResults->map(function ($project) {
        return [
            'id' => $project->id,
            'titre_projet' => $project->titre_projet,
            'nom_categorie' => $project->categorie->nom_cat,
            'filiere' => $project->user->filiere->nom_fil,
            'niveau' => $project->niveau->code_niv,
            'description' => $project->descript_projet,
            'image' =>  $project->image,
            'date_creation' => $project->created_at->format('Y-m-d'),
            // Ajoutez d'autres propriétés nécessaires
        ];
    });

    $results['projets'] = $projects;

    return response()->json($results);
}

}
