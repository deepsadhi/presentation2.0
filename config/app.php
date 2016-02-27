<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path'    => __DIR__ . '/../cache/',
        ],

        // Theme settings
        'theme' => [
            'default' => 'bootswatch/paper',
        ],

        // Sqlite database to store credentials
        'sqlite' => [
            'filename' => 'app.db',
        ],

        'presentation' => [
            'media'     => PUBLIC_PATH . '/media/',
            'markdown'  => __DIR__ . '/../markdown/',
        ],

    ],
];
