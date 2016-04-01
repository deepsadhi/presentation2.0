<?php

/**
 * Presentation2.0
 *
 * @link      https://github.com/deepsadhi/presentation2.0
 * @license   https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE
 *            (GPLv3)
 */

/**
 * Register app routes
 */

require __DIR__ . '/../vendor/autoload.php';

use Slim\App;

// Start session
$sessionPath = __DIR__ . '/../session';
session_save_path($sessionPath);
session_cache_limiter(false);
session_start();

// Initialize the app
$settings = require __DIR__ . '/../config/app.php';
$app = new App($settings);

// Set timezone
date_default_timezone_set($settings['settings']['timezone']);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Return app
return $app;
