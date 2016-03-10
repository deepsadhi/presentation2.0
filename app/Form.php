<?php

namespace App;

use \Exception;

class Form
{
	public $form = [];

	public function __construct()
	{
		$this->form['error'] = false;
	}

	protected function upload($file, $fileName=null)
	{
		if ($fileName === null)
		{
			$fileName = $this->getFileName($file->getClientFilename());
		}

		if ($file->getError() === UPLOAD_ERR_OK)
		{
		    $file->moveTo($path . $fileName);
			return true;
		}

		return false;
	}

	public function createOrUpdate($input, $file, $path, $edit = false)
	{
		$input['title'] 		   = trim($input['title']);
		$input['title']            = preg_replace('/[^a-z0-9_]/i',
		                                          '',
		                                          $input['title']);
		$input['content'] 		   = tirm($input['content']);

		$fileName                  = $input['title'].'.md';
		$this->form['input_value'] = $input;

		$msg = !$edit ? 'created' : 'updated';

		if (empty($input['title']))
		{
			$this->form['error']                  = true;
			$this->form['invalid_input']['title'] = true;
			$this->form['input_message']['title'] = 'Please enter title of presentation.';
		}

		if (!$edit)
		{
			if (file_exists($path . $fileName))
			{
				$this->form['error']                  = true;
				$this->form['invalid_input']['title'] = true;
				$this->form['input_message']['title'] = 'Presentation filename of title already exists.';
			}
		}

		if ($this->form['error'] === false &&
		    isset($_FILES['file']) && $_FILES['file']['size'] != 0)
		{
			if ($this->upload($this->path, $fileName) === true)
			{
				$this->form['message'] = 'Presentation '.$msg.' successfully.';
				return true;
			}
			else
			{
				$this->form['error']                 = true;
				$this->form['message'] 				 = 'Error! while uploading file'];
				$this->form['input_message']['file'] = '';
			}
		}
		else if($this->form['error'] === false)
		{
			if (empty($input['content']))
			{
				$this->form['error']                    = true;
				$this->form['invalid_input']['content'] = true;
				$this->form['input_message']['content'] = 'Enter contents for presentation.';
			}

			if (file_put_contents($path.$fileName,
			                      $input['content']) === true)
			{
				$this->form['message'] = 'Presentation '.$msg.' successfully.';
				return true;
			}
			else
			{
				$this->form['error']                 = true;
				$this->form['message'] 				 = 'Error! while creating presentation file'];
				$this->form['input_message']['file'] = '';
			}
		}

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
			$this->form['message'] = 'Some fields are invalid.'
			return false;
		}
		{
		}

	}



	protected function getFileName($fileName)
	{
		$i = 1;

		while (1)
		{
			if (!(file_exists($this->path . $fileName))
			{
				return $fileName;
			}

			$fileName = $i . '_' . $fileName;
			$i++;
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





}
