<?php

require_once '../../bootstrap/bootstrap.php';

use App\Session;

if (isset($_GET['file']))
{
	$fn    = $_GET['file'];
	$file  = APP_PATH.'/markdown/'.$fn.
	$file_ = APP_PATH.'/public/media/'.$fn;

	if (file_exists($file) || file_exists($file_))
	{
		$s = new Session;
		$s->setMessage('warning', "<b>{$fn}</b> deleted successfully");

		if (isset($_GET['g']))
		{
			unlink($file_);
			header('Location: media.php');
		}
		else
		{
			unlink($file);
			header('Location: home.php');
		}

		exit;
	}
}