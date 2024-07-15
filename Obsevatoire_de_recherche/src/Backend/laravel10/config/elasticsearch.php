<?php

return [
    'host' => env('ELASTICSEARCH_HOST'),
    'user' => env('ELASTICSEARCH_USER'),
    'password' => env('ELASTICSEARCH_PASSWORD'),
    'cloud_id' => env('ELASTICSEARCH_CLOUD_ID'),
    'api_key' => env('ELASTICSEARCH_API_KEY'),
    'queue' => [
        'timeout' => env('SCOUT_QUEUE_TIMEOUT'),
    ],
    'indices' => [
        'mappings' => [
            'tbl_projets' => [
                'properties' => [
                    'id' => [
                        'type' => 'keyword',
                    ],
                    'titre_projet' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'standard',
                    ],
                    'descript_projet' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'standard',
                    ],
                    'categorie' => [
                        'type' => 'nested',
                        'properties' => [
                            'nom_cat' => [
                                'type' => 'text',
                                'analyzer' => 'edge_ngram_analyzer',
                                'search_analyzer' => 'standard',
                            ],
                        ],
                    ],
                ],
            ],
            'tbl_documents' => [
                'properties' => [
                    'id' => [
                        'type' => 'keyword',
                    ],
                    'nom_doc' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'standard',
                    ],
                    'resume' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'standard',
                    ],
                ],
            ],
            'tbl_categories' => [
                'properties' => [
                    'id' => [
                        'type' => 'keyword',
                    ],
                    'nom_cat' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'standard',
                    ],
                ],
            ],
        ],
        'settings' => [
            'default' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
                'analysis' => [
                    'filter' => [
                        'edge_ngram_filter' => [
                            'type' => 'edge_ngram',
                            'min_gram' => 1,
                            'max_gram' => 20,
                        ],
                    ],
                    'analyzer' => [
                        'edge_ngram_analyzer' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => [
                                'lowercase',
                                'edge_ngram_filter',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
