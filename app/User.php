<?php

namespace App;

class User
{
	// public function authenticate($username, $password)
	// {
	// 	$p    = new Password;
	// 	$user = 'admin';

	// 	if ($username == $user && $password == trim($p->read()))
	// 	{
	// 		$_SESSION['login'] = true;
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	public function authenticate($username, $password)
	{
		$p      = new Password;
		$secret = trim($p->read());
		$secret = explode('::||::', $secret);

		if ($username == $secret[0] && $password == $secret[1])
		{
			$_SESSION['login'] = true;
			return true;
		}
		else
		{
			return false;
		}
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


