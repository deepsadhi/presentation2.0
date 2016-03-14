<?php

use App\File;
use Slim\Csrf\Guard;
use App\Form;
use App\Controller;
use App\User;

// Home page
$app->get('/', Controller::class.':home');

// Login page
$app->get('/login', Controller::class.':login')
	->add(new Guard)->setName('login');

// Login authentication
$app->post('/login', Controller::class.':authenticate');

// Admin pages for presenter
$app->group('/admin', function () use ($app) {

	// List of presentation files
	$this->get('/', Controller::class.':admin')
	     ->setName('admin')->add(new Guard);

	// Form to to create presentation file
	$this->get('/presentation/create', Controller::class.':create')
	     ->setName('create')->add(new Guard);

	// Store presentation content in a file
	$this->post('/presentation/create', Controller::class.':store');

	// Form to to create presentation file
	$this->get('/presentation/{file}/edit', Controller::class.':edit')
	     ->setName('edit')->add(new Guard);

	// Form to update presentation file
	$this->put('/presentation/{file}/edit', Controller::class.':update');

	// Delete media or presentation file
	$this->delete('/file', Controller::class.':delete')
		 ->setName('file');

	// List of media file for presentations
	$this->get('/media', Controller::class.':media')
		->setName('media')->add(new Guard);

	// Upload media file
	$this->post('/media', Controller::class.':media');

	$this->get('/settings', function($request, $response) {
		return $this->view->render($response, 'settings.twig', [
			'input'      => ['value' => ['new_username' => User::getUserName()]],
			'message'    => 'Enter details.',
			'csrf_name'  => $request->getAttribute('csrf_name'),
			'csrf_value' => $request->getAttribute('csrf_value'),
			'activePage' => 'settings',
		]);
	})->setName('settings')->add(new Guard);

	$this->put('/settings', function ($request, $response) {
		$input = $request->getParsedBody();
		$form = new Form;

		if ($form->updateUserPass($input) == true)
		{
			$this->flash->addMessage('error', $form->flash['error']);
			$this->flash->addMessage('message', $form->flash['message']);

			return $response->withRedirect('/admin/');
		}
		else
		{
			return $this->view->render($response, 'settings.twig', [
				'input' 	 => $form->input,
				'csrf_name'  => $request->getAttribute('csrf_name'),
				'csrf_value' => $request->getAttribute('csrf_value'),
				'activePage' => 'settings',
			]);
		}
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
	return $response->withRedirect('/login');
})->setName('logout');
