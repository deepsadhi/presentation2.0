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
        $data  = [];
        $files = [];
        $path  = $this->settings['presentation']['markdown'];
        $file  = new File($path, 'md|markdown');

        if ($file->ls() === false)
        {
            $data['flash'] = ['message'    => $file->getMessage(),
                              'alert_type' => 'danger'];
        }
        else
        {
            $files = $file->getFiles();
        }

        $data['files']       = $files;
        $data['active_page'] = 'home';

        return $this->view->render($response, 'admin.twig', $data);
    }

    public function create(Request $request, Response $response)
    {
        $path = $this->settings['presentation']['markdown'];
        $form = new Form($path);

        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger',
                    ];
        }
        else
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'info',
                    ];
        }

        return $this->view->render($response, 'create.twig', [
            'form'        => $form,
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
            'active_page' => 'create',
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $path  = $this->settings['presentation']['markdown'];
        $form  = new Form($path);
        $file  = $request->getUploadedFiles()['file'];
        $input = $request->getParsedBody();

        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger',
                    ];
        }
        else
        {
            if ($form->create($input, $file, $path) === true)
            {
                $flash = ['message'    => 'Presentation created successfully.',
                          'alert_type' => 'success'
                         ];
                $this->flash->addMessage('flash', $flash);

                return $response->withRedirect('/admin/');
            }
        }

        $form               = $form->getForm();
        $form['alert_type'] = 'danger';
        return $this->view->render($response, 'create.twig', [
            'form'        => $form,
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
            'active_page' => 'create',
        ]);
    }

    public function edit(Request $request, Response $response, Array $args)
    {
        $path     = $this->settings['presentation']['markdown'];
        $fileName = $path . substr_replace($args['file'], '_', '.', -3, 1);

        $file = new File($fileName);
        if ($file->load() === true)
        {
            $data['input'] = ['title'   => $args['title'],
                              'content' => $file->getContents()
                             ];

        }
        else
        {
            $flash = ['message'    => 'Error while loading file "'.
                                      realpath($fileName).'".',
                      'alert_type' => 'success'
                     ];
            $this->flash->addMessage('flash', $flash);

            return $response->withRedirect('/admin/');
        }

        $data = ['content'    => $file->getContents(),
                 'message'    => 'Enter details to update presentation.',
                 'csrf_name'  => $request->getAttribute('csrf_name'),
                 'csrf_value' => $request->getAttribute('csrf_value'),
                ];

        return $this->view->render($response, 'edit.twig', $data);
    }

    public function delete(Request $request, Response $response)
    {
        $path     = $request->getParsedBody()['path'];
        $realPath = $this->settings['presentation'][$path];
        $filePath = $realPath . $request->getParsedBody()['file'];

        $file      = new File($filePath);
        $res       = $file->delete();
        $alertType = ($res === true) ? 'success' : 'danger';

        $this->flash->addMessage('message', $file->getMessage());
        $this->flash->addMessage('alert_type', $alertType);

        if ($path == 'markdown')
        {
            return $response->withRedirect('/admin/');
        }
        else if ($path == 'media')
        {
            return $response->withRedirect('/admin/media');
        }
    }

}
