<?php

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
$container['view'] = function ($container) use ($app) {
    $settings = $container->get('settings')['renderer'];
    $view = new Twig(
        $settings['template_path'],
        [
        	// 'cache' => $settings['cache_path']
        ]
    );
    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $theme = $app->getContainer()->get('settings')['theme']['name'];
    $view->getEnvironment()->addGlobal('theme', $theme);

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
