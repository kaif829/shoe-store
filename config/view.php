<?php

return [
    'paths' => [
        resource_path('views'),
    ],

    // Do NOT use realpath() here — it returns false if folder is empty,
    // causing "Please provide a valid cache path" error.
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),
];
