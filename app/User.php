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
	private static $_db;

	/**
	 * Create database connection
	 */
	public static function connectDb()
	{
		self::$_db = new Database;
	}

	/**
	 * Verify user entered password match with correct password
	 *
	 * @param  string $actualPassword  User actual password
	 * @param  string $enterdPassword  User entered password
	 *
	 * @return bool                    Both password match or not
	 */
	private static function _verifyPassword($actualPassword, $enterdPassword)
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


	/**
	 * Check entered username and password is valid or not
	 * Fetch username and password from database
	 * Register if authentication is valid
	 *
	 * @param  string $username Entered username
	 * @param  string $password Entered password
	 * @return bool             Authentication was valid or not
	 */
	public static function login($username, $password)
	{
		self::connectDb();

		$data = ['type' => 'STR', 'key' => 'username', 'value' => $username];

		if (self::$_db->getValueOf('users', $data))
		{
			if (self::$_db->rowCount > 0)
			{
				$actualPassword = self::$_db->result['password'];
				if (self::_verifyPassword($actualPassword, $password) === true)
				{
					$_SESSION['user'] = $username;
					return true;
				}
			}
		}

		return false;
	}

	public static function changeUserPass($username, $password)
	{
		$data = [['type' => 'STR', 'key' => 'username', 'value' => $username],
				 ['type' => 'STR', 'key' => 'password', 'value' => $password]
				];

		if (self::$_db->changeUserPass('users', $data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Destroy session of user
	 */
	public static function logout()
	{
		session_destroy();
		unset($_SESSION);
		session_regenerate_id(true);
	}


	/**
	 * Check user is logged in or not
	 *
	 * @return bool User session existed or not
	 */
	public static function authenticate()
	{
		if (!isset($_SESSION['user']))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public static function getUserName()
	{
		return (isset($_SESSION['user'])) ? $_SESSION['user'] : null;
	}

}


