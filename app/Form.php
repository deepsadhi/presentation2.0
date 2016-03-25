<?php

/**
 * Presentation2.0
 *
 * @link      https://github.com/deepsadhi/presentation2.0
 * @license   https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE
 *            (GPLv3)
 */

namespace App;

use App\User;
use \Exception;


/**
 * A Form class
 *
 * Controls all forms of the app
 *
 * @package Presentation2.0
 */
class Form
{
	/**
	 * Path of file or directory
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Store form details
	 * error, message, input_value, input_message
	 *
	 * @var array
	 */
	protected $form = [];


	/**
	 * Initialize form
	 *
	 * @param string $path Path for file or directory
	 */
	public function __construct($path=null)
	{
		$this->form['error']   = false;
		$this->form['message'] = 'Enter details.';

		if ($path !== null && is_writable($path) === false)
		{
			$this->path 		   = $path;
			$this->form['error']   = true;
			$this->form['message'] = realpath($this->path).' is not writable. '.
									 'Give write permissions.';
		}
		else if ($path !== null && is_writable($path) === true)
		{
			$this->path = $path;
		}
	}

	/**
	 * Get form values
	 * @return array Form values
	 */
	public function getForm()
	{
		return $this->form;
	}

	/**
	 * Check filename exists at path or not
	 * If it exists change the filename by prefixing filename with file number
	 *
	 * @param  string $fileName Filename of the file
	 * @return sring            New filename of the file
	 */
	protected function getFileName($fileName)
	{
		$i = 1;
		while (1)
		{
			if (!(file_exists($this->path . $fileName)))
			{
				return $fileName;
			}

			$fileName = $i . '_' . $fileName;
			$i++;
		}
	}

	/**
	 * Upload file
	 *
	 * @param  object  $file     Slim fileUpload object
	 * @param  string  $fileName Filename to be renamed after uploading
	 * @return boolean           File upload successful or not
	 */
	protected function upload($file, $fileName = null)
	{
		if ($fileName === null)
		{
			$fileName = $this->getFileName($file->getClientFilename());
		}

		if ($file->getError() === UPLOAD_ERR_OK)
		{
		    $file->moveTo($this->path . $fileName);
			return true;
		}

		return false;
	}

	/**
	 * Create a markdown file and store presentation contents
	 *
	 * @param  array   $input Input values
	 * @param  object  $file  Sim fileUpload object
	 * @return boolean        Presentation creation successful or note
	 */
	public function store(Array $input, $file)
	{
		$input['title'] 		   = trim($input['title']);
		$fileName                  = $input['title'].'.md';
		$this->form['input_value'] = $input;

		if (empty($input['title']))
		{
			$this->form['error']                  = true;
			$this->form['invalid_input']['title'] = true;
			$this->form['input_message']['title'] = 'Enter title of presentation.';
		}

		if (preg_replace('/[^a-z0-9_]/i', '', $input['title'])
		    != $input['title'])
		{
			$this->form['error']                  = true;
			$this->form['invalid_input']['title'] = true;
			$this->form['input_message']['title'] = 'Title supports only alpha numeric character with underscore(_).';
		}

		if (file_exists($this->path . $fileName))
		{
			$this->form['error']                  = true;
			$this->form['invalid_input']['title'] = true;
			$this->form['input_message']['title'] = 'Presentation with title filename already exists.';
		}

		if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
		{
			$extension = end(explode('.', $file->getClientFilename()));

			if ($extension != 'md')
			{
				$this->form['error'] = true;
			}
		}
		else
		{
			$this->form['error']                 = true;
			$this->form['invalid_input']['file'] = true;
			$this->form['input_message']['file'] = 'Select a valid markdown file with extension ".md".';
		}

		if ($this->form['error'] === false &&
		    isset($_FILES['file']) && $_FILES['file']['size'] != 0)
		{
			if ($this->upload($file, $fileName) === true)
			{
				$this->form['error']   = false;
				$this->form['message'] = 'Presentation created successfully.';
				return true;
			}
		}

		$this->form['error']                 = true;
		$this->form['message']               = 'Error! while uploading file.';
		$this->form['invalid_input']['file'] = true;
		$this->form['input_message']['file'] = 'Select a valid markdown file with extension ".md".';

		return false;

	}

	/**
	 * Update presentation contents of markdown file
	 *
	 * @param  array $input Input values
	 * @return booll        Update presentation contents successful or not
	 */
	public function update(Array $input)
	{
		$input['content']          = trim($input['content']);
		$input['content'] 		   = str_replace("\r\n", PHP_EOL, $input['content']);
		$input['content'] 		   = str_replace("\n", PHP_EOL, $input['content']);
		$this->form['input_value'] = $input;

		if (empty($input['content']))
		{
			$this->form['error']                    = true;
			$this->form['invalid_input']['content'] = true;
			$this->form['input_message']['content'] = 'Enter contents for presentation.';
		}

		if ($this->form['error'] === false &&
		    file_put_contents($this->path, $input['content']) > 0)
		{
			$this->form['message'] = 'Presentation updated successfully.';
			return true;
		}

		$this->form['error']   = true;
		$this->form['message'] = 'Error! while updating presentation file.';
		return false;
	}

	/**
	 * Update username and password
	 *
	 * @param  Array   $input Input values
	 * @return boolean        Update username password successful or not
	 */
	public function updateUsernameAndPassword(Array $input)
	{
		$input['new_username']     = trim($input['new_username']);
		$this->form['input_value'] = $input;

		if (empty($input['old_password']))
		{
			$this->form['error']                         = true;
			$this->form['invalid_input']['old_password'] = true;
			$this->form['input_message']['old_password'] = 'Enter old password.';
		}

		if (empty($input['new_username']) ||
		    (strlen($input['new_username']) < 3 &&
		     strlen($input['new_username']) > 12))
		{
			$this->form['error']                         = true;
			$this->form['invalid_input']['new_username'] = true;
			$this->form['input_message']['new_username'] = 'New username should be of length 3-12.';
		}

		if (preg_replace('/[^a-z0-9_]/i', '', $input['new_username'])
		    != $input['new_username'])
		{
			$this->form['error']                         = true;
			$this->form['invalid_input']['new_username'] = true;
			$this->form['input_message']['new_username'] = 'Username supports only alpha numeric character with underscore(_).';
		}

		if (empty($input['new_password']) ||
		    (strlen($input['new_password']) < 6 &&
		     strlen($input['new_password']) > 20))
		{
			$this->form['error']                         = true;
			$this->form['invalid_input']['new_password'] = true;
			$this->form['input_message']['new_password'] = 'Password should of length 6-20.';
		}

		if ($this->form['error'] === true)
		{
			$this->form['message'] = 'Some fields are invalid.';
			return false;
		}
		else
		{
			$username = User::getUserName();
			if (User::login($username, $input['old_password']) === false)
			{
				$this->form['invalid_input']['old_password'] = true;
				$this->form['input_message']['old_password'] = 'Enter correct old password.';
				$this->form['message'] = 'Invalid old password.';
				return false;
			}

			if (User::updateUsernameAndPassword($input['new_username'], $input['new_password']))
			{
				$this->form['message'] = 'Username and password changed successfully.';
				return true;
			}
		}
	}

	/**
	 * Upload media files
	 *
	 * @param  object  $file Slim fileUpload object
	 * @return boolean       Media file upload successful or not
	 */
	public function uploadMedia($file)
	{
		if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
		{
			if ($this->upload($file) === true)
			{
				return true;
			}
		}

		return false;
	}

}






