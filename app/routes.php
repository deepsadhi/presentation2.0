<?php
// Routes

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

$app->get('/login', function ($request, $response) {
	return $this->view->render($response, 'login.twig', [
		'csrf_name'  => $request->getAttribute('csrf_name'),
		'csrf_value' => $request->getAttribute('csrf_value'),
	]);
})->add(new \Slim\Csrf\Guard)->setName('login');

$app->post('/login', function ($request, $response) {
	$user     = new \App\User;
	$username = $request->getParsedBody()['username'];
	$password = $request->getParsedBody()['password'];

	if ($user->authenticate($username, $password) === true)
	{
		$_SESSION['user'] = $username;
		$response->withRedirect('admin');
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

})->setName('auth');

$app->group('/admin', function () {
	$this->get('/', function ($request, $response) {

	})->setName('admin');
});
// ->add(function ($request, $response, $next) {
//     $response->getBody()->write('It is now ');
//     $response = $next($request, $response);
//     $response->getBody()->write('. Enjoy!');
//     $response = $response->withRedirect('/admin/');
//     return $response;
// });

$app->get('/', function ($request, $response) {
	return $this->view->render($response, 'index.twig');
})->setName('home');


