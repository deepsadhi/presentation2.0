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

    /**
     * Home page
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
    public function home(Request $request, Response $response)
    {
        return $this->view->render($response, 'home.twig');
    }

    /**
     * Login page
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
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

    /**
     * Authenticate login
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
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

    /**
     * List of presentations
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
    public function admin(Request $request, Response $response)
    {
        $data  = [];
        $files = [];
        $path  = $this->settings['presentation']['markdown'];
        $file  = new File($path, '/^[a-zA-Z0-9_]*.', 'md|markdown');

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

    /**
     * Create presentation
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
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

    /**
     * Store presentation
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
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
            if ($form->store($input, $file) === true)
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

    /**
     * Edit presentation
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  Array    $args     [description]
     * @return [type]             [description]
     */
    public function edit(Request $request, Response $response, Array $args)
    {
        $path     = $this->settings['presentation']['markdown'];
        $fileName = substr_replace($args['file'], '.', -3, 1);
        $file     = $path . $fileName;

        $form = new Form($file);
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

        $file = new File($file);
        if ($file->load() === false)
        {
            $flash = ['message'    => 'Error while loading file "'.
                                      realpath($fileName).'".',
                      'alert_type' => 'success'
                     ];
            $this->flash->addMessage('flash', $flash);

            return $response->withRedirect('/admin/');
        }
        else
        {
            $form['input_value']['content'] = $file->getContents();
        }

        $data = ['form'       => $form,
                 'file_name'  => $args['file'],
                 'csrf_name'  => $request->getAttribute('csrf_name'),
                 'csrf_value' => $request->getAttribute('csrf_value'),
                ];

        return $this->view->render($response, 'edit.twig', $data);
    }

    /**
     * Update presentation
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  Array    $args     [description]
     * @return [type]             [description]
     */
    public function update(Request $request, Response $response, Array $args)
    {
        $path     = $this->settings['presentation']['markdown'];
        $fileName = substr_replace($args['file'], '.', -3, 1);
        $file     = $path . $fileName;
        $form     = new Form($file);
        $input    = $request->getParsedBody();

        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger',
                    ];
        }
        else
        {
            if ($form->update($input) === true)
            {
                $flash = ['message'    => 'Presentation updated successfully.',
                          'alert_type' => 'success'
                         ];
                $this->flash->addMessage('flash', $flash);

                return $response->withRedirect('/admin/');
            }
        }

        $form               = $form->getForm();
        $form['alert_type'] = 'danger';
        return $this->view->render($response, 'edit.twig', [
            'form'        => $form,
            'file_name'   => $args['file'],
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
        ]);

    }

    /**
     * List of media files
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
    public function media(Request $request, Response $response)
    {
        $data  = [];
        $files = [];
        $path  = $this->settings['presentation']['media'];
        $file  = new File($path, '/', 'png|jpg|jpeg|bmp|gif');

        if ($_POST)
        {
            $form    = new Form($path);
            $inpFile = $request->getUploadedFiles()['file'];

            if ($form->uploadMedia($inpFile) === true)
            {
                $data['flash'] = ['message'    => 'Media uploaded successfully.',
                                  'alert_type' => 'success'];
            }
            else
            {
                $data['flash'] = ['message' => 'Error! while uploading media.',
                                  'alert_type' => 'danger'];
            }
        }

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
        $data['csrf_name']   = $request->getAttribute('csrf_name');
        $data['csrf_value']  = $request->getAttribute('csrf_value');
        $data['active_page'] = 'media';


        return $this->view->render($response, 'media.twig', $data);
    }

    /**
     * Delete media or presentation file
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
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
