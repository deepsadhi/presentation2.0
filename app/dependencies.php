<?php

/**
 * Presentation2.0
 *
 * @link      https://github.com/deepsadhi/presentation2.0
 * @license   https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE
 *            (GPLv3)
 */

use App\Controller;
use Slim\Views\Twig;
use Slim\Flash\Messages;
use Slim\Views\TwigExtension;


// Get app container
$container = $app->getContainer();

// Register flash message on container
$container['flash'] = function () {
    return new Messages();
};

// Register twig view on container
$container['view'] = function ($container) {
    $settings = $container->get('settings')['renderer'];

    $view = new Twig(
        $settings['template_path'],
        [
        	'cache' => $settings['cache_path']
        ]
    );
    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $theme = $container->get('settings')['theme']['name'];
    $view->getEnvironment()->addGlobal('theme', $theme);

    if ($_SERVER['SERVER_PORT'] == '443')
    {
        $assetPath= 'https://' . $_SERVER['HTTP_HOST'];
    }
    else
    {
        $assetPath= 'http://' . $_SERVER['HTTP_HOST'];
    }
    $view->getEnvironment()->addGlobal('asset_path', $assetPath);


    if ($container['flash']->getMessages())
    {
        $flash = ['message'    => $container['flash']
                                    ->getMessages()['message'][0],
                  'alert_type' => $container['flash']
                                    ->getMessages()['alert_type'][0],
                 ];

        $view->getEnvironment()->addGlobal('flash', $flash);
    }

    return $view;
};

// Register controller on container
$container[Controller::class] = function ($container) {
    return new Controller($container);
};
