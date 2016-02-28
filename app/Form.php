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
		$this->input['title']    = preg_replace('/[^a-z0-9._-]/i', '', $this->input['title']);
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


}
