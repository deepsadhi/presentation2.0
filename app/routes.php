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

	// Form to update username and password
	$this->get('/settings', Controller::class.':editUserPass')
		 ->setName('settings')->add(new Guard);

	// Update username and password
	$this->put('/settings', Controller::class.':updateUserPass');

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
