<?php

namespace App;

use \Exception;

class Form
{
	public $form = [];

	protected function upload($file, $fileName=null)
	{
		if ($fileName === null)
		{
			$fileName = $this->_getFileName($file->getClientFilename());
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
		$input 					   = $this->trimWhiteSpace($input);
		$input['title']            = preg_replace('/[^a-z0-9_]/i',
		                                          '',
		                                          $input['title']);

		$fileName                  = $this->input['title'].'.md';
		$this->form['input_value'] = $this->input;

		$msg = !$edit ? 'created' : 'updated';

		try
		{
			if (empty($this->input['title']))
			{
				$this->form['invalid_input'] = 'title';
				throw new Exception('Please enter title of presentation.');
			}

			if (!$edit)
			{
				if (file_exists($path.$fileName))
				{
					$this->form['invalid_input'] = 'title';
					throw new Exception('Presentation filename with title already exists.');
				}
			}

			if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
			{
				if ($this->upload($this->path, $fileName) === true)
				{
					$this->flash['error']   = false;
					$this->flash['message'] = 'Presentation '.$msg.' successfully.';
					return true;
				}
				else
				{
					$this->form['invalid_input'] = 'file';
					throw new Exception('Error! while uploading file.');
				}
			}
			else
			{
				if (empty($this->input['content']))
				{
					$this->form['invalid_input'] = 'content';
					throw new Exception('Please enter presentation contents.');
				}

				if (file_put_contents($path.$fileName,
				                      $this->input['content']) === true)
				{
					$this->flash['error']   = false;
   				    $this->flash['message'] = 'Presentation '.$msg.' successfully.';
					return true;
				}
				else
				{
					$this->form['invalid_input'] = 'content';
					throw new Exception('Error! while writing contents to file.');
				}
			}
		}
		catch (Exception $e)
		{
			$this->flash['error']   = true;
			$this->flash['message'] = $e->getMessage();
			return false;
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
		$input                     = $this->trimWhiteSpace($input);
		$this->form['input_value'] = $input;

		try
		{
			if (empty($input['old_password']))
			{
				$this->['invalid_input']['old_password'] = true;
				throw new Exception('Please enter your old password.');
			}

			if (strlen($this->input['new_username']) < 3 &&
			    strlen($this->input['new_username']) > 12)
			{
				$this->input['invalid']['new_username'] = true;
				throw new Exception('Username should of length between 3-12');
			}

			if (preg_replace('/[^a-z0-9_.]/i', '', $this->input['new_username'])
			    != $this->input['new_username'])
			{
				$this->input['invalid']['new_username'] = true;
				throw new Exception('Username support only alpha numeric character with . and _');
			}

			if (strlen($this->input['new_password']) < 6 &&
			    strlen($this->input['new_password']) > 12)
			{
				$this->input['invalid']['new_password'] = true;
				throw new Exception('Password should of length between 6-12');
			}


		}
		catch (Exception $e)
		{
			$this->input['error']   = true;
			$this->input['message'] = $e->getMessage();
			return false;
		}
	}



	protected function _getFileName($fileName)
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
