<?php

namespace App;

use App\Database;
use App\Session;

class User
{
	/**
	 * Database connection
	 *
	 * @var PDO object
	 */
	protected static $db;

	/**
	 * Create database connection
	 */
	public static function connectDatabase()
	{
		self::$db = new Database;
	}

	/**
	 * Hash password
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	protected static function hashPassword($password)
	{
	    if (defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH)
	    {
	        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
	        return crypt($password, $salt);
	    }
	}

	/**
	 * Verify user entered password match with correct password
	 *
	 * @param  string $hashedPassword    User actual password
	 * @param  string $enterdPassword  User entered password
	 *
	 * @return bool                    Both password match or not
	 */
	protected static function verifyPassword($hashedPassword, $password)
	{
		return crypt($password, $hashedPassword) == $hashedPassword;
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
		self::connectDatabase();

		$data = [['type' => 'STR', 'key' => 'username', 'value' => $username]];

		if (self::$db->query('users', $data))
		{
			if (self::$db->rowCount > 0)
			{
				$hashedPassword = self::$db->result['password'];
				if (self::verifyPassword($hashedPassword, $password) === true)
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
		self::connectDatabase();

		$password = self::hashPassword($password);
		$data     = [['type' => 'STR', 'key' => 'username', 'value' => $username],
				     ['type' => 'STR', 'key' => 'password', 'value' => $password]];

		return self::$db->update('users', $data, 1);
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
	 * @return bool User session exists or not
	 */
	public static function authenticate()
	{
		return isset($_SESSION['user']);
	}

	/**
	 * Get username of registered session user
	 *
	 * @return string|null Username of registered session user
	 */
	public static function getUserName()
	{
		return (isset($_SESSION['user'])) ? $_SESSION['user'] : null;
	}

}


