<?php
// DIC configuration

use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
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

    return $view;
};

// Register flash message on container
$container['flash'] = function () {
	return new Messages();
};
