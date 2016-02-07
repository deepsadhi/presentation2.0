<?php

namespace App;

// Reference: http://monkeylogic.com/whole-file-encryptiondecryption-with-php/
class Password
{
	private $_file;
	private $_opts;
	private $_passphrase;

	public function __construct()
	{
		$this->_file        = APP_PATH.'/config/passwd';
		$this->_passphrase = '#meight8';

		$this->_crypto();
	}

	private function _crypto() {
		$iv   = substr(md5("\x1B\x3C\x58".$this->_passphrase, true), 0, 8);
		$key  = substr(md5("\x2D\xFC\xD8".$this->_passphrase, true) .
		               md5("\x2D\xFC\xD9".$this->_passphrase, true), 0, 24);

		$this->_opts = array('iv'=>$iv, 'key'=>$key);
	}

	public function write($secret)
	{
		// TODO: check file and permissions
		$fp = fopen($this->_file, 'wb');

		stream_filter_append($fp, 'mcrypt.tripledes',
		                     STREAM_FILTER_WRITE, $this->_opts);

		// TODO: check file and permissions
		fwrite($fp, $secret);

		fclose($fp);

	}

	public function read()
	{
		// TODO: check file and permissions
		$fp = fopen($this->_file, 'rb');

		stream_filter_append($fp, 'mdecrypt.tripledes',
		                     STREAM_FILTER_READ, $this->_opts);

		return stream_get_contents($fp);
	}


}