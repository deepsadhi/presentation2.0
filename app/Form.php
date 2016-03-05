<?php

namespace App;

use \Exception;

class Form
{
	public $flash = [];

	public $input = [];

	public function createOrUpdate($input, $file, $path, $edit = false)
	{
		$this->input['title']    = trim($input['title']);
		$this->input['title']    = preg_replace('/[^a-z0-9_]/i', '', $this->input['title']);
		$this->input['content']  = trim($input['content']);
		$fileName = $this->input['title'].'.md';

		$msg = !$edit ? 'created' : 'updated';

		try
		{
			if (empty($this->input['title']))
			{
				$this->flash['input'] = 'title';
				throw new Exception('Please enter title of presentation.');
			}

			if (!$edit)
			{
				if (file_exists($path.$fileName))
				{
					$this->flash['input'] = 'title';
					throw new Exception('Presentation title with filename already exists.');
				}
			}

			if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
			{
				if ($file->getError() === UPLOAD_ERR_OK)
				{
				    $file->moveTo($path.$fileName);
					$this->flash['error']   = false;
					$this->flash['message'] = 'Presentation '.$msg.' successfully.';
					return true;
				}
				else
				{
					$this->flash['input'] = 'file';
					throw new Exception('Error! while uploading file.');
				}
			}
			else
			{
				if (empty($this->input['content']))
				{
					$this->flash['input'] = 'content';
					throw new Exception('Please enter some presentation contents.');
				}

				if (file_put_contents($path.$fileName, $this->input['content']) == true)
				{
					$this->flash['error']   = false;
   				    $this->flash['message'] = 'Presentation '.$msg.' successfully.';
					return true;
				}
				else
				{
					$this->flash['input'] = 'content';
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

	private function _trimWhiteSpace(Array $input)
	{
		foreach ($input as $key => $value)
		{
			$input[$key] = trim($value);
		}
		return $input;
	}

	public function updateUserPass(Array $input)
	{
		$this->input['value'] = $this->_trimWhiteSpace($input);

		try
		{
			if (empty($this->input['value']['old_password']))
			{
				$this->input['invalid']['old_password'] = true;
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

	private function _upload($file, $fileName=null)
	{
		if ($fileName == null)
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

	private function _getFileName($fileName)
	{
		$i           = 1;
		$tmpFileName = $fileName;

		while (1)
		{
			if (!(file_exists($this->path . $fileName))
			{
				return $fileName;
			}

			$tmpFileName = $i . $fileName;
			$i++;
		}
	}

	public function uploadMedia($file)
	{
		if (isset($_FILES['file']) && $_FILES['file']['size'] != 0)
		{
			if ($this->_upload($file) === true)
			{
				return true;
			}
		}

		return false;
	}

}





}
