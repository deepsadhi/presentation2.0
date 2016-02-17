<?php

namespace App;

class Session
{
	/**
	 * Start session
	 */
	public function __construct()
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
	public static function setUserID($userId)
	{
		$_SESSION['user_id'] = $userId;
	}

	/**
	 * Get user who is logged in
	 *
	 * @return string|null User whose session is running
	 */
	public static function getUser()
	{
		if (isset($_SESSION['user_id']))
		{

			return $_SESSION['user_id'];
		}
		else
		{
			return null;
		}
	}


	/**
	 * Set message and message alert type to session
	 * To exchange message between pages
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
	 *
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
	 * Get value of CSRF token
	 *
	 * @return string CSRF token value
	 */
	public static function getCsrfToken()
	{
		if (!isset($_SESSION['csrf_token']))
		{
		    $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
		}

		return $_SESSION['csrf_token'];
	}

	/**
	 * Destroy CSRF token
	 */
	public static function destroyCsrfToken()
	{
		$_SESSION['token'] = null;
		unset($_SESSION['token']);
	}

}