<?php

namespace App;

class Session
{
	$tokenName;

	public function __construct()
	{
		if(session_id() == ''){
			session_save_path('/tmp');
		    session_start();
		}



		$sf = $_SERVER['SCRIPT_FILENAME'];
		$sf = explode(DIRECTORY_SEPARATOR, $sf);
		if (end($sf) != 'index.php')
		{
			if(!isset($_SESSION['login']) ||
			   (isset($_SESSION['login']) && $_SESSION['login'] != true))
			{
			    header("Location: index.php");
			    exit;
			}
		}
		else if (end($sf) == 'index.php')
		{
			if (isset($_SESSION['login']) && $_SESSION['login'] == true)
			{
				header('Location: home.php');
				exit;
			}
		}
	}

	public function setMessage($alert, $message)
	{
		$_SESSION['message'] = array('alert' => $alert, 'message' => $message);
	}

	public function getMessage()
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
		return $message;
	}

	public function isMessage()
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

	public function startSession($username)
	{
		$_SESSION['login'] = true;
		$_SESSION['username'] = $username;
	}

	public function setCsrfToken()
	{
		$this->tokenName = 'token';

		if (!isset($_SESSION[$this->tokenName]))
		{
		    $_SESSION[$this->tokenName] = md5(uniqid(mt_rand(), true));
		}
	}

	public function getCsrfToken()
	{
		return $_SESSION[$this->tokenName];
	}

	public function getTokenName()
	{
		return $this->tokenName;
	}

}