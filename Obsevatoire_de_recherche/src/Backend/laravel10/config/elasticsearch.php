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
                    ],
                    'descript_projet' => [
                        'type' => 'text',
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
                    ],
                    'resume' => [
                        'type' => 'text',
                    ],
                ],
            ],
            'tbl_categories' => [
                'properties' => [
                    'id' => [
                        'type' => 'keyword',
                    ],
                    'nom_categorie' => [
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'settings' => [
            'default' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
            ],
        ],
    ],
];
