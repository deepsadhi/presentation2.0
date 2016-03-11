<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\User;

class Controller
{
	protected $view;
    protected $flash;
    protected $container;


	public function __construct($container)
	{
        $this->view     = $container['view'];
        $this->flash    = $container['flash'];
        $this->settings = $container['settings'];
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
        $path  = $this->settings['presentation']['markdown'];
        $file  = new File($path, 'md|markdown');

        if ($file->ls() === false)
        {
            $msg   = 'Could not access '.realpath($path).'. Give execute '.
                     'permissions';
            $files = [];
            $this->flash->addMessage('message', $msg);
            $this->flash->addMessage('alert_type', 'danger');
        }
        else
        {
            $files = $file->ls();
        }

        $data = [
            'files'       => $files,
            'active_page' => 'home',
        ];

        return $this->view->render($response, 'admin.twig', $data);
    }

}
