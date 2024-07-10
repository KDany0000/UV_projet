<?php

namespace App\Http\Controllers\Usecases;

use Illuminate\Http\Request;
use App\Models\TblProjet;
use App\Http\Controllers\Controller;
use App\Models\TblCategorie;
use App\Models\TblDocument;
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

        // Search Categories
        $categoryResults = TblCategorie::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'tbl_categories',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'should' => [
                                [
                                    'match' => [
                                        'nom_cat' => [
                                            'query' => $query,
                                            'fuzziness' => 'AUTO',
                                        ],
                                    ],
                                ],
                                [
                                    'prefix' => [
                                        'nom_cat' => [
                                            'value' => $query,
                                        ],
                                    ],
                                ],
                                [
                                    'match' => [
                                        'descript_cat' => [
                                            'query' => $query,
                                            'fuzziness' => 'AUTO',
                                        ],
                                    ],
                                ],
                                [
                                    'prefix' => [
                                        'descript_cat' => [
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

        $results['projets'] = $projectResults;
        $results['categories'] = $categoryResults;

        return response()->json($results);
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

        $results = TblDocument::search($query, function ($client, $body) use ($query) {
            $params = [
                'index' => 'tbl_documents',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'should' => [
                                [
                                    'match' => [
                                        'nom_doc' => [
                                            'query' => $query,
                                            'fuzziness' => 'AUTO',
                                        ],
                                    ],
                                ],
                                [
                                    'prefix' => [
                                        'nom_doc' => [
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

            $response = $client->search($params);

            // Convertir la réponse en tableau
            $responseArray = $response->asArray();

            return $responseArray;
        })->get();

        return response()->json($results);
    }
}
