<?php

/**
 * Presentation2.0
 *
 * @link      https://github.com/deepsadhi/presentation2.0
 * @license   https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE
 *            (GPLv3)
 */

namespace App;


/**
 * A File class
 *
 * Access and manage files
 * Get contents of file
 *
 * @package Presentation2.0
 */
class File
{
	/**
	 * Store path of file or directory
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Store file extensions in regex format
	 *
	 * @var string
	 */
	protected $extensions;

	/**
	 * Store list of files
	 *
	 * @var array
	 */
	protected $files = [];

	/**
	 * Store contents of a file
	 *
	 * @var string
	 */
	protected $contents;

	/**
	 * Store message
	 *
	 * @var string
	 */
	protected $message;


	/**
	 * Set path of file or directory
	 *
	 * @param string $path       Path of file or directory
	 * @param string $regex 	 Regex to limit file listing
	 * @param array  $extensions Supported file extensions in regex format
	 */
	public function __construct($path, $regex='', $extensions='')
	{
		$this->path       = $path;
		$this->regex 	  = $regex;
		$this->extensions = $extensions;
	}

	/**
	 * List directory files
	 * Limit the files matching with regex pattern and file extensions
	 *
	 * @return boolean Directory file listing successful or not
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

	/**
	 * Get list of files after performing ls in a directory
	 *
	 * @return array List of files of directory
	 */
	public function getFiles()
	{
		return $this->files;
	}

	/**
	 * Get message file operation message
	 *
	 * @return string File operation message
	 */
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

	/**
	 * Delete a file
	 *
	 * @return boll Deleting file successful or not
	 */
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

	/**
	 * Load contents of a file
	 *
	 * @return boolean Loading file contents success or not
	 */
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

	/**
	 * Get contents of a file
	 *
	 * @return string Contents of file
	 */
	public function getContents()
	{
		return $this->contents;
	}
}
