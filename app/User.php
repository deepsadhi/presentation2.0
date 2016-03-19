<?php

namespace App;

use App\Database;


class User
{
	/**
	 * Database connection
	 *
	 * @var PDO object
	 */
	protected static $db;


	/**
	 * Establish database connection
	 */
	public static function connectDatabase()
	{
		self::$db = new Database;
	}

	/**
	 * Hash password using Blowfish
	 *
	 * @param  string $password Plain password
	 * @return string           Hashed password
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
	 * Verify plain password matches with hashed password
	 *
	 * @param  string $hashedPassword Hashed password
	 * @param  string $password       Plain password
	 * @return string                 Plain password and hashed password
	 *                                matches or not
	 */
	protected static function verifyPassword($hashedPassword, $password)
	{
		return crypt($password, $hashedPassword) == $hashedPassword;
	}

	/**
	 * Check entered username and password is valid or not
	 * Fetch username and password from database
	 * Register session if authentication is valid
	 *
	 * @param  string  $username Entered username
	 * @param  string  $password Entered password
	 * @return boolean           Authentication valid or not
	 */
	public static function login($username, $password)
	{
		self::connectDatabase();

		$data = [['type' => 'STR', 'key' => 'username', 'value' => $username]];

		if (self::$db->query('users', $data, 1) === true)
		{
			if (self::$db->getRowCount() == 1)
			{
				$result         = self::$db->getRows();
				$result         = array_shift($result);
				$hashedPassword = $result['password'];
				if (self::verifyPassword($hashedPassword, $password) === true)
				{
					$_SESSION['user'] = $username;
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Change username and password
	 *
	 * @param  string  $username New username
	 * @param  string  $password New password
	 * @return boolean           Username and password change successful or not
	 */
	public static function updateUsernameAndPassword($username, $password)
	{
		self::connectDatabase();

		$password = self::hashPassword($password);
		$data     = [['type' => 'STR', 'key' => 'username', 'value' => $username],
				     ['type' => 'STR', 'key' => 'password', 'value' => $password]];

		return  self::$db->update('users', $data, 1);
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
	 * @return boolean User session exists or not
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
