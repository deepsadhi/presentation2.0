<?php

namespace App;

use App\Database;
use App\Session;

class User
{
	/**
	 * Database connection
	 * @var PDO object
	 */
	private $_db;

	/**
	 * Create database connection
	 */
	public function __construct()
	{
		$this->_db = new Database;
	}

	/**
	 * Verify user entered password match with correct password
	 * @param  string $actualPassword  User actual password
	 * @param  string $enterdPassword  User entered password
	 * @return bool                    Both password match or not
	 */
	private function _verifyPassword($actualPassword, $enterdPassword)
	{
		if ($actualPassword == $enterdPassword)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function authenticate($username, $password)
	{
		$data = array('type'  => 'STR',
		              'key'   => 'username',
		              'value' => $username);

		if ($this->_db->getValueOf('users', $data))
		{
			if ($this->_db->rowCount > 0)
			{
				$actualPassword = $this->_db->result['password'];
				if ($this->_verifyPassword($actualPassword, $password) === true)
				{
					$session = new Session;
					$session->startSession($username);

					return true;
				}
			}
		}

		return false;
	}

	public function authenticatePassword($password)
	{
		$p      = new Password;
		$secret = trim($p->read());
		$secret = explode('::||::', $secret);

		if ($password == $secret[1])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function changePssword($password)
	{
		$p = new Password;

		$p->write($password);
	}

	public function changeSecret($secret)
	{
		$p = new Password;

		$p->write($secret);
	}

	public function getUsername()
	{
		$p      = new Password;
		$secret = trim($p->read());
		$secret = explode('::||::', $secret);

		return $secret[0];
	}
}


