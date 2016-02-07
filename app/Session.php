<?php

namespace App;

class Session
{
	public function __construct()
	{
		if(session_id() == ''){
		    session_start();
		}

		if(!isset($_SESSION['token'])){
		    $_SESSION['token'] = md5(uniqid(mt_rand(), true));
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

}