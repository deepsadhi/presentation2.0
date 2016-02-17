<?php

require_once '../../bootstrap/bootstrap.php';


use App\User;
use App\Form;

$form = new Form('login');

if (isset($_POST[$form->tokenName]))
{
    if ($form->validate())
    {
        $user = new User;
        if ($user->authenticate($form->inputValue['username'],
                                $form->inputValue['password']) === true
            )
        {
            header('Location: home.php');
            exit;
        }
    }
}


// use App\User;
// use App\Session;

// $msg   = 'Log In!';
// $user  ='';
// $error = '';

// if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])
// {
// 	$user  = isset($_POST['username']) ? $_POST['username'] : null;
// 	$pass  = isset($_POST['password']) ? $_POST['password'] : null;
// 	$error = 'has-error';

// 	$u = new User;
// 	if ($u->authenticate($user, $pass) == true)
// 	{
// 		header('Location: home.php');
// 		exit();
// 	}
// 	else
// 	{
// 		$msg = 'Incorrect Username/Password';
// 	}
// }
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
    <title>Presentation2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/vendor/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/main.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

		<div class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="http://bctians.com/presentation2.0">Presentation2.0</a>
		    </div>
		  </div>
		</div>

    <div class="container">


      <div class="container-fluid">
        <div class="row">
					<div class="bs-docs-section">
					<div class="col-lg-3">
					</div>
					<div class="col-lg-6">
            <div class="well bs-component">
              <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		          	<input type="hidden" value="<?php echo $form->tokenValue; ?>" name="<?php echo $form->tokenName; ?>">
                <fieldset>
                  <legend></legend>
                  <div class="form-group">
                    <label class="col-lg-3 control-label" for="inputEmail">Username</label>
                    <div class="col-lg-8">
                      <input type="text" value="<?php if (isset($form->inputFilterValue['username'])) echo $form->inputFilterValue['username']; ?>" name="username"  id="inputEmail" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label" for="inputPassword">Password</label>
                    <div class="col-lg-8">
                      <input type="password" name="password"  id="inputPassword" class="form-control">

                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-3">
                      <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div></div>
          </div>
        </div>
        </div>
      </div>
    </div>

<?php require 'footer.php'; ?>

