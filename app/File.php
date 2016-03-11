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

	/**
	 * Store extensions of files to be listed
	 *
	 * @var array
	 */
	protected $extensions;

	/**
	 * Store list of files in path
	 *
	 * @var array
	 */

	public $files = [];

	/**
	 * Store error and success messages
	 *
	 * @var array
	 */
	public $flash = [];

	public $contents;

	/**
	 * Set path of file or directory
	 *
	 * @param string $path       Path of file or directory
	 * @param array  $extensions Supported file type extensions
	 */
	public function __construct($path, $extensions='')
	{
		$this->path            = $path;
		$this->extensions      = $extensions;
		$this->flash['error']   = false;
		$this->flash['message'] = '';
	}


	/**
	 * List directory contents of the path
	 *
	 * @return array List of all files of the path
	 */
	public function ls()
	{
		$files     = [];
		$directory = opendir($this->path);

		if ($directory)
		{
			while (false !== ($filename = readdir($directory)))
			{
				if((preg_match('/^[a-zA-Z0-9_]*.'.$this->extensions.'$/i',
				               $filename) == true))
				{
					$fn      = $this->path . '/' . $filename;
					$files[] = ['name' => $filename,
								'size' => $this->formatSize(filesize($fn)),
								'date' => date("M d, Y h:i A", filemtime($fn))
							   ];
				}
			}

			return $files;
		}
		else
		{
			return false;
		}
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
		$filename = explode('/', $this->path);
		$filename = end($filename);

		if (file_exists($this->path))
		{
			if (unlink($this->path))
			{
				$this->flash['error']   = false;
				$this->flash['message'] = 'File '.$filename.' deleted successfully.';
				return true;
			}
		}

		$this->flash['error']   = true;
		$this->flash['message'] = 'Error! while deleting file "'.$filename.'". '.
								  'Check file and directory permissions.';
		return false;
	}

	public function load()
	{
		if (file_exists($this->path))
		{
			$this->contents = file_get_contents($this->path);
			$this->flash['error'] = 'false';
			return true;
		}
		else
		{
			$fileName = explode('/', $this->path);
			$fileName = end($fileName);

			$this->flash['error'] = true;
			$this->flash['message'] = 'Error! loading file '.$fileName.'.';
			return false;
		}
	}
}
