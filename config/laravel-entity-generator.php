<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel Entity Generator Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the Laravel Entity Generator
    | package. You can customize these settings according to your needs.
    |
    */

    // Default namespace for generated services
    'service_namespace' => 'App\\Services',

    // Default namespace for generated controllers
    'controller_namespace' => 'App\\Http\\Controllers',

    // Default namespace for generated models
    'model_namespace' => 'App\\Models',

    // Default namespace for generated requests
    'request_namespace' => 'App\\Http\\Requests',

    // Default namespace for generated resources
    'resource_namespace' => 'App\\Http\\Resources',

    // Whether to generate repository pattern files (future feature)
    'generate_repository' => false,

    // Whether to generate tests (future feature)
    'generate_tests' => false,

    // Custom stub paths (if you want to override default stubs)
    'stub_paths' => [
        'controller' => null, // null = use package default
        'service' => null,    // null = use package default
    ],

    // File permissions for generated directories
    'directory_permissions' => 0755,

    // Whether to add API resource routes automatically (future feature)
    'auto_generate_routes' => false,
];
