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

        // Monolog settings
        // 'logger' => [
        //     'name' => 'slim-app',
        //     'path' => __DIR__ . '/../logs/app.log',
        // ],

        // Sqlite database to store credentials
        'sqlite' => [
            'filename' => 'app.db',
        ],

    ],
];
