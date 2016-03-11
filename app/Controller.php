<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\User;

class Controller
{
	protected $view;

	public function __construct($container)
	{
		$this->view = $container['view'];
	}

    public function home(Request $request, Response $response)
    {
        return $this->view->render($response, 'home.twig');
    }

    public function login(Request $request, Response $response)
    {
    	$form = ['message'    => 'Enter username and password.',
    	         'alert_type' => 'info',
    	        ];

		return $this->view->render($response, 'login.twig', [
		    'form' 		 => $form,
			'csrf_name'  => $request->getAttribute('csrf_name'),
			'csrf_value' => $request->getAttribute('csrf_value'),
		]);
    }

    public function authenticate(Request $request, Response $response)
    {
    	$username = $request->getParsedBody()['username'];
    	$password = $request->getParsedBody()['password'];

    	if (User::login($username, $password) === true)
    	{
    		return $response->withRedirect('/admin/');
    	}
    	else
    	{
    		$form = ['error'       => true,
    				 'message'     => 'Invalid! username/password combination.',
    				 'alert_type'  => 'danger',
    				 'input_value' => ['username' => $username],
    				];

    		return $this->view->render($response, 'login.twig', [
    			'form'       => $form,
    			'csrf_name'  => $request->getAttribute('csrf_name'),
    			'csrf_value' => $request->getAttribute('csrf_value'),
    		]);
    	}
    }

    public function admin(Request $request, Response $response)
    {
        // List of presentation files
            $path  = $app->getContainer()->get('settings')['presentation']['markdown'];
            $file  = new File($path, 'md|markdown');
            $file->ls();
            $data = [
                'files'      => $file->files,
                'error'      => $file->flash,
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
            return $this->view->render($response, 'admin.twig', $data);
    }

}
