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
		return $response->withRedirect('/admin/');
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
		$path  = $app->getContainer()->get('settings')['presentation']['markdown'];
		$file  = new File($path, 'md|markdown');
		$file->ls();

		$data = [
		    'files'      => $file->files,
		    'error' 	 => $file->flash,
		    'csrf_name'  => $request->getAttribute('csrf_name'),
		    'csrf_value' => $request->getAttribute('csrf_value'),
		    'activePage' => 'home',
        ];

		if ($this->flash->getMessages())
		{
			$data['flash']            = [];
			$data['flash']['error']   = $this->flash->getMessages()['error'][0];
			$data['flash']['message'] = $this->flash->getMessages()['message'][0];
		}

		return $this->view->render($response, 'home.twig', $data);
	})->setName('admin')->add(new Guard);

	$this->delete('/file', function($request, $response) use ($app) {
		$path     = $request->getParsedBody()['path'];
		$realPath = $app->getContainer()->get('settings')['presentation'][$path];
		$filePath = $realPath . $request->getParsedBody()['file'];

		$file = new File($filePath);
		$file->delete();

		$this->flash->addMessage('error', $file->flash['error']);
		$this->flash->addMessage('message', $file->flash['message']);
		return $response->withRedirect('/admin/');
	})->setName('file');
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
