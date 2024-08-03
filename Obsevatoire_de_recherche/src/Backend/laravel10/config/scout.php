<?php

return [
    'driver' => env('SCOUT_DRIVER', 'elasticsearch'),
    'prefix' => env('SCOUT_PREFIX', ''),
    'queue' => env('SCOUT_QUEUE', false),
    'after_commit' => false,
    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],
    'soft_delete' => false,
    'identify' => env('SCOUT_IDENTIFY', false),
    'elasticsearch' => [
        'indices' => [
            'projets' => [
                'index' => env('ELASTICSEARCH_INDEX_PROJETS', 'tbl_projets'),
                'refresh_documents' => env('SCOUT_ELASTICSEARCH_REFRESH', false),
            ],
            'documents' => [
                'index' => env('ELASTICSEARCH_INDEX_DOCUMENTS', 'tbl_documents'),
                'refresh_documents' => env('SCOUT_ELASTICSEARCH_REFRESH', false),
            ],
            'categories' => [
                'index' => env('ELASTICSEARCH_INDEX_CATEGORIES', 'tbl_categories'),
                'refresh_documents' => env('SCOUT_ELASTICSEARCH_REFRESH', false),
            ],
            'users' => [
                'index' => env('ELASTICSEARCH_INDEX_USERS', 'users'),
                'refresh_documents' => env('SCOUT_ELASTICSEARCH_REFRESH', false),
            ],
            'collaborateurs' => [
                'index' => env('ELASTICSEARCH_INDEX_COLLABORATEURS', 'collaborateurs'),
                'refresh_documents' => env('SCOUT_ELASTICSEARCH_REFRESH', false),
            ],
        ],
    ],
];
