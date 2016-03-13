<?php

namespace App;

class File
{
	/**
	 * Store path of file or directory
	 *
	 * @var string
	 */
	protected $path;

	protected $extensions;

	protected $files = [];

	protected $contents;

	protected $message;

	/**
	 * Set path of file or directory
	 *
	 * @param string $path       Path of file or directory
	 * @param array  $extensions Supported file type extensions
	 */
	public function __construct($path, $regex='', $extensions='')
	{
		$this->path       = $path;
		$this->regex 	  = $regex;
		$this->extensions = $extensions;
	}


	/**
	 * List directory contents of the path
	 *
	 * @return array List of all files of the path
	 */
	public function ls()
	{
		$directory = opendir($this->path);

		if ($directory)
		{
			while (false !== ($fileName = readdir($directory)))
			{
				if((preg_match($this->regex . $this->extensions.'$/i',
				               $fileName) == true))
				{
					$fn      = $this->path . '/' . $fileName;
					$this->files[] = ['name'  => $fileName,
									  'name_' => substr_replace($fileName,
									                            '_',
									                            -3,
									                            1),
								      'size'  => $this->formatSize(filesize($fn)),
								      'date'  => date("M d, Y h:i A",
								                     filemtime($fn))
							  		 ];
				}
			}
			return true;
		}
		else
		{
			$this->message = 'Could not access '.realpath($this->path).'. '.
							      'Give execute permissions.';
			return false;
		}
	}

	public function getFiles()
	{
		return $this->files;
	}

	public function getMessage()
	{
		return $this->message;
	}


	/**
	 * Format bytes to human readable file size
	 *
	 * @param  int    $bytes File size
	 * @return string        File size in human readable
	 */
    protected function formatSize($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        else if ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        else if ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        else if ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        else if ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

	public function delete()
	{
		$fileName = explode('/', $this->path);
		$fileName = end($fileName);

		if (file_exists($this->path))
		{
			if (unlink($this->path))
			{
				$this->message = 'File '.$fileName.' deleted successfully.';
				return true;
			}
		}

		$this->message = 'Error! while deleting file "'.$fileName.'". Check '.
						 'file and directory permissions.';
		return false;
	}

	public function load()
	{
		if (file_exists($this->path))
		{
			$this->contents = file_get_contents($this->path);
			return true;
		}
		else
		{
			$fileName      = explode('/', $this->path);
			$fileName      = end($fileName);
			$this->message = 'Error! loading file '.$fileName.'.';
			return false;
		}
	}

	public function getContents()
	{
		return $this->contents;
	}
}
