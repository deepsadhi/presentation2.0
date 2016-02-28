<?php

use App\User;
use App\File;
use Slim\Csrf\Guard;
use App\Form;

// Home page for viewers
$app->get('/', function ($request, $response) {
	return $this->view->render($response, 'home.twig');
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

		return $this->view->render($response, 'index.twig', $data);
	})->setName('admin')->add(new Guard);

	// List of media file for presentations
	$this->get('/media', function ($request, $response) use ($app) {
		$path  = $app->getContainer()->get('settings')['presentation']['media'];
		$file  = new File($path, 'png|jpg|jpeg|bmp|gif');
		$file->ls();

		$data = [
		    'files'      => $file->files,
		    'error' 	 => $file->flash,
		    'csrf_name'  => $request->getAttribute('csrf_name'),
		    'csrf_value' => $request->getAttribute('csrf_value'),
		    'activePage' => 'media',
        ];

		if ($this->flash->getMessages())
		{
			$data['flash']            = [];
			$data['flash']['error']   = $this->flash->getMessages()['error'][0];
			$data['flash']['message'] = $this->flash->getMessages()['message'][0];
		}

		return $this->view->render($response, 'index.twig', $data);
	})->setName('media')->add(new Guard);

	// Form to to create presentation file
	$this->get('/create',  function ($request, $response) {
		return $this->view->render($response, 'create.twig', [
			'activePage' => 'create',
 			'message'    => 'Enter details to create presentation.',
			'csrf_name'  => $request->getAttribute('csrf_name'),
			'csrf_value' => $request->getAttribute('csrf_value'),
		]);
	})->setName('create')->add(new Guard);

	// Form to to create presentation file
	$this->get('/{file}/edit',  function ($request, $response, $args) use ($app) {
		$path     = $app->getContainer()->get('settings')['presentation']['markdown'];
		$fileName = $path.$args['file'].'.md';

		$data = [
				'activePage' => 'create',
	 			'message'    => 'Enter details to create presentation.',
				'csrf_name'  => $request->getAttribute('csrf_name'),
				'csrf_value' => $request->getAttribute('csrf_value'),
				];

		$file = new File($fileName);
		if ($file->load() == true)
		{
			$data['input'] = ['title' => $args['title'], 'content' => $file->contents];

		}
		else
		{
			return $response->withRedirect('/admin/');
		}

		return $this->view->render($response, 'create.twig', $data);
	})->setName('edit')->add(new Guard);

	// Store presentation content in a file
	$this->post('/create', function ($request, $response) use ($app) {
		$input = $request->getParsedBody();
		$file  = $request->getUploadedFiles()['file'];
		$path  = $app->getContainer()->get('settings')['presentation']['markdown'];

		$form = new Form;
		if ($form->createOrUpdate($input, $file, $path) == true)
		{
			$this->flash->addMessage('error', $form->flash['error']);
			$this->flash->addMessage('message', $form->flash['message']);

			return $response->withRedirect('/admin/');
		}
		else
		{
			return $this->view->render($response, 'create.twig', [
				'error' 	 => $form->flash,
				'input' 	 => $form->input,
				'csrf_name'  => $request->getAttribute('csrf_name'),
				'csrf_value' => $request->getAttribute('csrf_value'),
				'activePage' => 'create',
			]);
		}
	});


	$this->delete('/file', function($request, $response) use ($app) {
		$path     = $request->getParsedBody()['path'];
		$realPath = $app->getContainer()->get('settings')['presentation'][$path];
		$filePath = $realPath . $request->getParsedBody()['file'];

		$file = new File($filePath);
		$file->delete();

		$this->flash->addMessage('error', $file->flash['error']);
		$this->flash->addMessage('message', $file->flash['message']);

		if ($path == 'markdown')
		{
			return $response->withRedirect('/admin/');
		}
		else if ($path == 'media')
		{
			return $response->withRedirect('/admin/media');
		}
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
