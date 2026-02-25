<?php

return [
    'api' => [
        'title' => 'Menzili Backend API',
    ],

    'routes' => [
        'api' => 'api/documentation',
    ],

    'paths' => [
        'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
        'docs_json' => 'api-docs.json',
        'docs_yaml' => 'api-docs.yaml',
        'base_path' => env('L5_SWAGGER_BASE_PATH', '/api'),
        'annotations' => base_path('app/Http/Controllers'),
    ],

    'info' => [
        'description' => 'Menzili Backend REST API',
    ],

    'servers' => [
        [
            'url' => env('APP_URL', 'http://localhost:8000'),
            'description' => 'Development Server',
        ],
    ],
];
