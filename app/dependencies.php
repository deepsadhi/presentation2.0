<?php
// DIC configuration

use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use App\HomeController;

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) use ($app) {
    $settings = $container->get('settings')['renderer'];
    $view = new Twig(
        $settings['template_path'],
        [
        	// 'cache' => $settings['cache_path']
            'my_name' => 'deepak'
        ]
    );
    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $theme = $app->getContainer()->get('settings')['theme']['name'];
    $view->getEnvironment()->addGlobal('theme', $theme);

    return $view;
};

$container['HomeController'] = function ($container) {
    return new HomeController();
};

// Register flash message on container
$container['flash'] = function () {
	return new Messages();
};
