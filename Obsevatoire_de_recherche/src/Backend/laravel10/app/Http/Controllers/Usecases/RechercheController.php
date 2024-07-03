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
    public function searchProjects(Request $request)
    {
        $query = $request->input('query');

        $results = TblProjet::search($query, function ($client, $body) use ($query) {
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

            $response = $client->search($params);

            // Convertir la réponse en tableau
            $responseArray = $response->asArray();

            return $responseArray;
        })->get();

        return response()->json($results);
    }


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


    public function searchCategories(Request $request)
    {
        $query = $request->input('query');

        $results = TblCategorie::search($query, function ($client, $body) use ($query) {
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

            $response = $client->search($params);

            // Convertir la réponse en tableau
            $responseArray = $response->asArray();

            return $responseArray;
        })->get();

        return response()->json($results);
    }
}
