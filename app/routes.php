<?php

use App\User;
use App\File;
use Slim\Csrf\Guard;

// Home page for viewers
$app->get('/', function ($request, $response) {
	return $this->view->render($response, 'index.twig');
})->setName('home');

// Login page
$app->get('/login', function ($request, $response) {
	return $this->view->render($response, 'login.twig', [
		'csrf_name'  => $request->getAttribute('csrf_name'),
		'csrf_value' => $request->getAttribute('csrf_value'),
	]);
})->add(new Guard)->setName('login');

// Login authentication
$app->post('/login', function ($request, $response) {
	$username = $request->getParsedBody()['username'];
	$password = $request->getParsedBody()['password'];

	if (User::login($username, $password) === true)
	{
		return $response->withRedirect('admin/');
	}
	else
	{
		return $this->view->render($response, 'login.twig', [
			'error'      => true,
			'username' 	 => $username,
			'csrf_name'  => $request->getAttribute('csrf_name'),
			'csrf_value' => $request->getAttribute('csrf_value'),
		]);
	}
});

// Admin pages for presenter
$app->group('/admin', function () use ($app) {
	// List of presentation files
	$this->get('/', function ($request, $response) use ($app) {
		$path  = $app->getContainer()->get('settings')['presentation']['files'];
		$file  = new File($path, 'md|markdown');
		$file->ls();

		return $this->view->render($response, 'home.twig', [
		    'files'      => $file->files,
		    'error' 	 => $file->error,
		    'csrf_name'  => $request->getAttribute('csrf_name'),
		    'csrf_value' => $request->getAttribute('csrf_value'),
		    'activePage' => 'home',
        ]);
	})->setName('admin')->add(new Guard);

	$this->delete('/file/{filename}', function($request, $response, $args) {
		var_dump($args);
	});
})->add(function ($request, $response, $next) {
	if (User::authenticate() === false)
	{
		$response = $response->withRedirect('/login');
	}
    $response = $next($request, $response);

	return $response;
});


// Logout page
$app->get('/logout', function($request, $response) {
	User::logout();
	return $response->withRedirect('login');
})->setName('logout');
