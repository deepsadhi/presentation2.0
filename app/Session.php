<?php

namespace App;

class Session
{
	/**
	 * Form input field name for token
	 *
	 * @var [type]
	 */
	public static $tokenName;

	/**
	 * Start session
	 */
	public static function __construct()
	{
		if(session_id() == ''){
			session_save_path('/tmp');
		    session_start();
		}
	}

	/**
	 * Set session user
	 *
	 * @param string $user User for whom session needs to be registered
	 */
	public static function setUser($user)
	{
		$_SESSION['user'] = $user;
	}

	/**
	 * Get user who is logged in
	 *
	 * @return string|null User whose session is running
	 */
	public static function getUser()
	{
		if (isset($_SESSION['user']))
		{

			return $_SESSION['user'];
		}
		else
		{
			return null;
		}
	}


	/**
	 * Set message and message alert type to session. To exchange message
	 * between pages
	 *
	 * @param string $alert   Message alert type
	 * @param string $message Message to be stored
	 */
	public static function setMessage($alert, $message)
	{
		$_SESSION['message'] = array('alert' => $alert, 'message' => $message);
	}

	/**
	 * Get session message
	 * @return array|null Message stored in session
	 */
	public static function getMessage()
	{
		if (issset($_SESSION['message']))
		{
			$message = $_SESSION['message'];
			unset($_SESSION['message']);
			return $message;
		}
		else
		{
			return null;
		}
	}

	/**
	 * Check session has message or not
	 *
	 * @return boolean There was message or not
	 */
	public static function hasMessage()
	{
		if (isset($_SESSION['message']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Generate CSRF value and set to session
	 */
	public function setCsrfToken()
	{
		self::$tokenName = 'token';

		if (!isset($_SESSION[self::$tokenName]))
		{
		    $_SESSION[self::$tokenName] = md5(uniqid(mt_rand(), true));
		}
	}

	/**
	 * Get value of CSRF token
	 *
	 * @return string|null CSRF token value
	 */
	public function getCsrfToken()
	{
		if (isset($_SESSION[self::$tokenName))
		{
			return $_SESSION[self::$tokenName];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Get name of CSRF token input field
	 *
	 * @return string Name of token input field
	 */
	public function getTokenName()
	{
		return self::$tokenName;
	}

}