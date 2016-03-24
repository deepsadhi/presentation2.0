<?php

return [
    'settings' => [
        // Display errors
        'displayErrorDetails' => false,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path'    => __DIR__ . '/../cache/',
        ],

        // Theme settings
        'theme' => [
            'name' => 'bootswatch/paper',
        ],

        // Sqlite database to store credentials
        'sqlite' => [
            'filename' => 'app.db',
        ],

        // Directory to store presentation and media files
        'presentation' => [
            'media'         => @PUBLIC_PATH . '/media/',
            'presentation'  => __DIR__ . '/../presentation/',
        ],
    ],
];
