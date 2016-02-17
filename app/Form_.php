<?php

namespace App;

use App\Session;
use App\User;

class Form
{
	public $title;
	public $content;
	public $errorFile;
	public $errorTitle;
	public $errorContent;
	public $errorMessage;
	public $errorNewPass;
	public $errorOldPass;
	public $errorNewUser;

	public $user;

	public function __construct()
	{
		$this->errorFile    = '';
		$this->errorTitle   = '';
		$this->errorContent = '';
		$this->errorMessage = null;
	}

	public function initProfile()
	{
		$u = new User;
		$this->user = $u->getUsername();
	}

	public function init()
	{
		$this->title   = '';
		$this->content = '';
	}

	public function edit($fn)
	{
		if (!file_exists(APP_PATH.'/markdown/'.$fn))
		{
			$s = new Session;
			$s->setMessage('warning', 'Sorry! slide does not exist');
		}

		$this->title = str_replace('.md', '', $fn);
		$this->content = file_get_contents(APP_PATH.'/markdown/'.$fn);
	}

	public function procede()
	{
		$s = new Session;

		if (isset($_GET['file']))
		{
			$msg = 'updated';
		}
		else
		{
			$msg = 'created';
		}

		try
		{
			$this->content = isset($_POST['content']) ? $_POST['content'] : '';

			if (!isset($_POST['title']) || empty($_POST['title']))
			{
				$this->errorTitle = 'has-error';
				throw new \Exception('Please enter tile');
			}
			$this->title = preg_replace('/[^a-z0-9._-]/i', '', $_POST['title']);

			$fn  = APP_PATH.'/markdown/'.$this->title.'.md';

			if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
			{
				$allowedExts = array('md', 'markdown');
				$temp        = explode(".", $_FILES['file']["name"]);
				$extension   = strtolower(end($temp));

				if (in_array($extension, $allowedExts))
				{
				   	if ($_FILES['file']["error"] > 0)
				   	{
				        $this->errorFile = 'has-error';
				        throw new \Exception('Error! while uploading file');
				   	}
				   	else if(move_uploaded_file($_FILES["file"]["tmp_name"],$fn))
				   	{
					    $s->setMessage('success',
					        "Slide <b>{$this->title}.md</b> {$msg} successfully");
					    header('Location: home.php');
					    exit();
				   }
				}
				else
				{
			        $this->errorFile = 'has-error';
			        throw new \Exception('Error! while uploading file');
				}
			}
			else
			{
				if (strlen($_POST['content']) <= 10)
				{
					$this->errorContent = 'has-error';
					throw new \Exception('Please enter some more content');
				}
				$this->content = $_POST['content'];

				if (file_put_contents($fn, $_POST['content']))
				{
					$s->setMessage('success',
					    "Slide <b>{$this->title}.md</b> {$msg} successfully");
					header('Location: home.php');
					exit();
				}
				else
				{
					$this->errorContent = 'has-error';
					throw new \Exception('Markdown file only supported. '.
					                     'Please upload markdown file');
				}

			}
		}
		catch (\Exception $e)
		{
			$this->errorMessage = $e->getMessage();
		}

	}

	public function upload()
	{
		try
		{
			$s = new Session;

			if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
			{
				$fn  = APP_PATH.'/public/media/'.$_FILES['file']['name'];
				$allowedExts = array('jpg', 'png', 'bmp', 'gif');
				$temp        = explode(".", $_FILES['file']["name"]);
				$extension   = strtolower(end($temp));

				if (in_array($extension, $allowedExts))
				{
				   	if ($_FILES['file']["error"] > 0)
				   	{
				        $this->errorFile = 'has-error';
				        throw new \Exception('Error! while uploading  file');
				   	}
				   	else if(move_uploaded_file($_FILES["file"]["tmp_name"],$fn))
				   	{
					    $s->setMessage('success', "Image uploaded successfully");
				   }
				}
				else
				{
			        $this->errorFile = 'has-error';
			        throw new \Exception('Image upload only supported. '.
			                             'Please choose a image file');
				}
			}
		}
		catch (\Exception $e)
		{
			$s->setMessage('danger', $e->getMessage());
		}
	}

	public function changeSecret()
	{
		$s = new Session;
		$u = new User;

		try
		{
			$this->user = isset($_POST['newuser']) ? $_POST['newuser'] : '';

			if (isset($_POST['oldpass']) && empty($_POST['oldpass']))
			{
				$this->errorOldPass = 'has-error';
				throw new \Exception('Please enter old password');
			}
			else
			{
				if (!$u->authenticatePassword($_POST['oldpass']))
				{
					$this->errorOldPass = 'has-error';
					throw new \Exception('Invalid! old password');
				}
			}

			if (isset($_POST['newuser']) && empty($_POST['newuser']))
			{
				$this->errorNewUser = 'has-error';
				throw new \Exception('Please enter new username');
			}

			if (isset($_POST['newpass']) && empty($_POST['newpass']))
			{
				$this->errorNewPass = 'has-error';
				throw new \Exception('Please enter new password');
			}

			$secret = $_POST['newuser'].'::||::'.$_POST['newpass'];
			$u->changeSecret($secret);

			$s->setMessage('success', 'Password changed successfully');
			header('Location: home.php');
			exit;

		}
		catch (\Exception $e)
		{
			$this->errorMessage = $e->getMessage();
		}
	}

}