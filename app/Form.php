<?php

namespace App;

use \Exception;

class Form
{
	protected $path;
	protected $form = [];

	public function __construct($path)
	{
		$this->path 		 = $path;
		$this->form['error'] = false;

		if (is_writable($path) === false)
		{
			$this->form['error']   = true;
			$this->form['message'] = realpath($this->path).' is not writable. '.
									 'Give write permissions.';
		}
		else
		{
			$this->form['message'] = 'Enter details.';
		}
	}

	public function getForm()
	{
		return $this->form;
	}

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

	public function store($input, $file)
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

	public function update($input)
	{
		$input['content']          = trim($input['content']);
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

	protected function trimWhiteSpace(Array $input)
	{
		foreach ($input as $key => $value)
		{
			$input[$key] = trim($value);
		}

		return $input;
	}

	public function updateUserPass(Array $input)
	{
		$input['new_username']                     = tirm($input['new_username']);
		$this->form['input_value']['new_username'] = $input['new_username'];

		if (empty($input['old_password']))
		{
			$this->form['error']                         = true;
			$this->form['invalid_input']['old_password'] = true;
			$this->form['input_message']['old_password'] = 'Enter old password.';
		}

		if (strlen($input['new_username']) < 3 &&
		    strlen($input['new_username']) > 12)
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
			$this->form['input_message']['new_username'] = 'Username supports only alpha numeric character with _';
		}

		if (strlen($input['new_password']) < 6 &&
		    strlen($input['new_password']) > 12)
		{
			$this->form['error']                         = true;
			$this->form['invalid_input']['new_password'] = true;
			$this->form['input_message']['new_password'] = 'Password should of length 6-12.';
		}

		if ($this->form['error'] === true)
		{
			$this->form['message'] = 'Some fields are invalid.';
			return false;
		}
		{
		}

	}


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






