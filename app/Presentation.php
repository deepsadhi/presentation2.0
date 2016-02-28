<?php

namespace App;

class Presentation
{
	private $_presentationDir;

	public function __construct()
	{
		$this->_presentationDir = APP_PATH.'/markdown';
	}

	public function files()
	{
		$files = array();
		$dh    = opendir($this->_presentationDir);

		if($dh){
			while (false !== ($filename = readdir($dh)))
			{
				if ((preg_match('/^[a-zA-Z0-9_]*.md$/',$filename) == true))
				{
					$fn = $this->_presentationDir.'/'.$filename;
					$files[] = ['name' => $filename,
								'size' => filesize($fn),
								'date' => date("M d, Y h:i A", filemtime($fn))
							   ];
				}
			}

			return $files;
		}else{
			die('cannot list markdown fies');
		}
	}

}
