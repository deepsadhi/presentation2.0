<?php

namespace App;

use App\User;
use App\Slide;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Controller
{
    /**
     * Store Twig view
     *
     * @var Twig object
     */
	protected $view;

    /**
     * Store Slim flash messages
     *
     * @var Messages object
     */
    protected $flash;

    /**
     * Store Slim app container
     *
     * @var App container object
     */
    protected $container;


    /**
     * Initialize controller
     *
     * @param object $container App container object
     */
	public function __construct($container)
	{
        $this->view     = $container['view'];
        $this->flash    = $container['flash'];
        $this->settings = $container['settings'];
	}

    /**
     * Home page
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function home(Request $request, Response $response)
    {
        return $this->view->render($response, 'home.twig');
    }

    /**
     * Login page
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function login(Request $request, Response $response)
    {
    	$form = ['message'    => 'Enter username and password.',
    	         'alert_type' => 'info'];

		return $this->view->render($response, 'admin/login.twig', [
		    'form' 		 => $form,
			'csrf_name'  => $request->getAttribute('csrf_name'),
			'csrf_value' => $request->getAttribute('csrf_value'),
		]);
    }

    /**
     * Authenticate login
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
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

    		return $this->view->render($response, 'admin/login.twig', [
    			'form'       => $form,
    			'csrf_name'  => $request->getAttribute('csrf_name'),
    			'csrf_value' => $request->getAttribute('csrf_value'),
    		]);
    	}
    }

    /**
     * List of presentations
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function admin(Request $request, Response $response)
    {
        $data  = [];
        $files = [];
        $path  = $this->settings['presentation']['presentation'];
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

        return $this->view->render($response, 'admin/admin.twig', $data);
    }

    /**
     * Create presentation
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function create(Request $request, Response $response)
    {
        $path = $this->settings['presentation']['presentation'];
        $form = new Form($path);

        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger'];
        }
        else
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'info'];
        }

        return $this->view->render($response, 'admin/create.twig', [
            'form'        => $form,
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
            'active_page' => 'create',
        ]);
    }

    /**
     * Store presentation
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function store(Request $request, Response $response)
    {
        $path  = $this->settings['presentation']['presentation'];
        $form  = new Form($path);
        $file  = $request->getUploadedFiles()['file'];
        $input = $request->getParsedBody();

        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger'];
        }
        else
        {
            if ($form->store($input, $file) === true)
            {
                $this->flash->addMessage('message',$form->getForm()['message']);
                $this->flash->addMessage('alert_type', 'success');

                return $response->withRedirect('/admin/');
            }
        }

        $form               = $form->getForm();
        $form['alert_type'] = 'danger';
        return $this->view->render($response, 'admin/create.twig', [
            'form'        => $form,
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
            'active_page' => 'create',
        ]);
    }

    /**
     * Show presentation
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function show(Request $request, Response $response, Array $args)
    {
        $path     = $this->settings['presentation']['presentation'];
        $fileName = substr_replace($args['file'], '.', -3, 1);
        $filePath = $path . $fileName;

        $file = new File($filePath);
        if ($file->load() === false)
        {
            $flash = ['message'    => 'Error while loading file "'.
                                      $fileName.'".',
                      'alert_type' => 'danger'];
            $this->flash->addMessage('message', $flash['message']);
            $this->flash->addMessage('alert_type', $flash['alert_type']);

            return $response->withRedirect('/admin/');
        }

        return $this->view->render($response, 'admin/show.twig');
    }

    /**
     * Presentation slide as json
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  Array    $args
     * @return Response
     */
    public function json(Request $request, Response $response, Array $args)
    {
        $path        = $this->settings['presentation']['presentation'];
        $fileName    = substr_replace($args['file'], '.', -3, 1);
        $filePath    = $path . $fileName;
        $slideNumber = (int) preg_replace('/\D/', '', $args['slide']);
        $file        = new File($filePath);
        $data        = [];

        if ($file->load() === true)
        {
            $slide = new Slide($filePath);

            $data['error'] = false;
            $data['slide'] = $slide->renderForAjax($slideNumber);
        }
        else
        {
            $data['error']   = true;
            $data['message'] = 'Could not load presentation file.';
        }

        return $response->withJson($data);
    }

    /**
     * Edit presentation
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  Array    $args
     * @return Response
     */
    public function edit(Request $request, Response $response, Array $args)
    {
        $path     = $this->settings['presentation']['presentation'];
        $fileName = substr_replace($args['file'], '.', -3, 1);
        $filePath = $path . $fileName;

        $form = new Form($filePath);
        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger'];
        }
        else
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'info'];
        }

        $file = new File($filePath);
        if ($file->load() === false)
        {
            $this->flash->addMessage('message',
                                     'Error while loading file "' .
                                     $fileName . '".');
            $this->flash->addMessage('alert_type', 'danger');

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

        return $this->view->render($response, 'admin/edit.twig', $data);
    }

    /**
     * Update presentation
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  Array    $args
     * @return Response
     */
    public function update(Request $request, Response $response, Array $args)
    {
        $path     = $this->settings['presentation']['presentation'];
        $fileName = substr_replace($args['file'], '.', -3, 1);
        $file     = $path . $fileName;
        $form     = new Form($file);
        $input    = $request->getParsedBody();

        if ($form->getForm()['error'] === true)
        {
            $form = ['message'    => $form->getForm()['message'],
                     'alert_type' => 'danger'];
        }
        else
        {
            if ($form->update($input) === true)
            {
                $this->flash->addMessage('message',
                                         'Presentation updated successfully.');
                $this->flash->addMessage('alert_type', 'success');

                return $response->withRedirect('/admin/');
            }
        }

        $form               = $form->getForm();
        $form['alert_type'] = 'danger';
        return $this->view->render($response, 'admin/edit.twig', [
            'form'        => $form,
            'file_name'   => $args['file'],
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
        ]);

    }

    /**
     * List of media files
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function media(Request $request, Response $response)
    {
        $data  = [];
        $files = [];
        $path  = $this->settings['presentation']['media'];
        $file  = new File($path, '/', 'png|jpg|jpeg|bmp|gif|svg');

        if ($_POST)
        {
            $form    = new Form($path);
            $inpFile = $request->getUploadedFiles()['file'];

            if ($form->uploadMedia($inpFile) === true)
            {
                $data['flash'] = ['message'   => 'Media uploaded successfully.',
                                  'alert_type'=> 'success'];
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

        return $this->view->render($response, 'admin/media.twig', $data);
    }

    /**
     * Delete media or presentation file
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
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

        if ($path == 'presentation')
        {
            return $response->withRedirect('/admin/');
        }
        else if ($path == 'media')
        {
            return $response->withRedirect('/admin/media');
        }
    }

    /**
     * Edit username and password
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function editSettings(Request $request, Response $response)
    {
        $form = ['message'     => 'Enter details.',
                 'input_value' => ['new_username' => User::getUserName()],
                 'alert_type'  => 'info'];

        return $this->view->render($response, 'admin/settings.twig', [
            'form'        => $form,
            'csrf_name'   => $request->getAttribute('csrf_name'),
            'csrf_value'  => $request->getAttribute('csrf_value'),
            'active_page' => 'settings',
        ]);
    }

    /**
     * Update usernamde and password
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function updateSettings(Request $request, Response $response)
    {
        $input = $request->getParsedBody();
        $form = new Form;

        if ($form->updateUsernameAndPassword($input) === true)
        {
            $this->flash->addMessage('message', $form->flash['message']);
            $this->flash->addMessage('alert_type', 'success');

            return $response->withRedirect('/admin/');
        }
        else
        {
            $form               = $form->getForm();
            $form['alert_type'] = 'danger';

            return $this->view->render($response, 'admin/settings.twig', [
                'form'        => $form,
                'csrf_name'   => $request->getAttribute('csrf_name'),
                'csrf_value'  => $request->getAttribute('csrf_value'),
                'active_page' => 'settings',
            ]);
        }
    }
}
