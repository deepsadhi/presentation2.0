
<?php
// Routes

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

$app->group('/admin', function () {
	$this->get('/', function ($request, $response) {
		return $this->view->render($response, 'login.twig', [
			'csrf_name'  => $request->getAttribute('csrf_name'),
			'csrf_value' => $request->getAttribute('csrf_value'),
		]);
	})->setName('admin');

	$this->post('/', function ($request, $response) {

	});
});

$app->get('/', function ($request, $response) {
	return $this->view->render($response, 'index.twig');
});


