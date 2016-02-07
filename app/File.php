<?php

namespace App;

use App\Session;

class File
{
	private $_path;

	public function __construct($path)
	{
		$this->_path = $path;
	}

	public function lists($ext)
	{
		$files = array();
		$dir   = opendir($this->_path);

		if ($dir)
		{
			while (false !== ($filename = readdir($dir)))
			{
				if((preg_match('/^[a-zA-Z0-9_]*.'.$ext.'$/i',$filename) == true))
				{
					$fn = $this->_path.'/'.$filename;
					$files[] = ['name' => $filename,
								'size' => $this->_formatSize(filesize($fn)),
								'date' => date("M d, Y h:i A", filemtime($fn))
							   ];
				}
			}

			return $files;
		}
		else
		{
			$s = new Session;
			$s->setMessage('warning', "Cannot read <b>{$this->_path}</b>. ".
			               			  'Give execute permission');
		}
	}

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
