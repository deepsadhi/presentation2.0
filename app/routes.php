<?php

/**
 * Presentation2.0
 *
 * @link      https://github.com/deepsadhi/presentation2.0
 * @license   https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE
 *            (GPLv3)
 */
use App\User;
use App\Controller;
use Slim\Csrf\Guard;


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

	// Show and broadcast presentation
	$this->get('/presentation/{file}/show', Controller::class.':show')
		 ->setName('show');

	// Get presentation slide in json format
	$this->get('/presentation/{file}/slide/{slide}', Controller::class.':json')
		->setName('json');

	// Form to to create presentation file
	$this->get('/presentation/create', Controller::class.':create')
	     ->setName('create')->add(new Guard);

	// Store presentation content in a file
	$this->post('/presentation/create', Controller::class.':store');

	// Form to to edit presentation file
	$this->get('/presentation/{file}/edit', Controller::class.':edit')
	     ->setName('edit')->add(new Guard);

	// Form to update presentation file
	$this->put('/presentation/{file}/edit', Controller::class.':update');

	// Delete media or presentation file
	$this->delete('/file', Controller::class.':delete')
		 ->setName('file');

	// List of media file
	$this->get('/media', Controller::class.':media')
		->setName('media')->add(new Guard);

	// Upload media file
	$this->post('/media', Controller::class.':media');

	// Form to update settings
	$this->get('/settings', Controller::class.':editSettings')
		 ->setName('settings')->add(new Guard);

	// Update settings
	$this->put('/settings', Controller::class.':updateSettings');

})->add(function ($request, $response, $next) {
	// Check user session exists or not
	if (User::authenticate() === false)
	{
		$response = $response->withRedirect('/login');
	}
    $response = $next($request, $response);

	return $response;
});

// Logout
$app->get('/logout', function($request, $response) {
	User::logout();

	return $response->withRedirect('/login');
})->setName('logout');
