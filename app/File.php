<?php

namespace App;

use App\Session;

class File
{
	/**
	 * Store path of file or directory
	 *
	 * @var string
	 */
	private $_path;

	/**
	 * Store extensions of files to be listed
	 *
	 * @var array
	 */
	private $_extensions;

	/**
	 * Store list of files in path
	 *
	 * @var array
	 */

	public $files = [];
	/**
	 * Store error messages
	 *
	 * @var array
	 */
	public $error = [];

	/**
	 * Set path of file or directory
	 *
	 * @param string $path       Path of file or directory
	 * @param array  $extensions Supported file type extensions
	 */
	public function __construct($path, $extensions)
	{
		$this->_path            = $path;
		$this->_extensions      = $extensions;
		$this->error['error']   = false;
		$this->error['message'] = '';
	}


	/**
	 * List directory contents of the path
	 *
	 * @return array List of all files of the path
	 */
	public function ls()
	{
		$files     = [];
		$directory = opendir($this->_path);

		if ($directory)
		{
			while (false !== ($filename = readdir($directory)))
			{
				if((preg_match('/^[a-zA-Z0-9_]*.'.$this->_extensions.'$/i',
				               $filename) == true))
				{
					$fn      = $this->_path . '/' . $filename;
					$files[] = ['name' => $filename,
								'size' => $this->_formatSize(filesize($fn)),
								'date' => date("M d, Y h:i A", filemtime($fn))
							   ];
				}
			}
		}
		else
		{
			$this->error['error']   = true;
			$this->error['message'] = 'Directory "'.$this->_path.'" cannot be '.
									  'accessed. Please give execute '.
									  'permission.';
		}

		$this->files = $files;
	}

	/**
	 * Format bytes to human readable file size
	 *
	 * @param  int    $bytes File size
	 * @return string        File size in human readable
	 */
    private function _formatSize($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

}
