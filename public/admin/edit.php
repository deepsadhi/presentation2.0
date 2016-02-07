<?php

require_once '../../bootstrap/bootstrap.php';

use App\Form;
use App\Session;

if (!isset($_GET['file']) || empty($_GET['file']))
{
  $s = new Session;
  $s->setMessage('warning', 'Please select a slide');
  header('Location: home.php');
  exit;
}
else
{
  $f = new Form;
  $f->edit($_GET['file']);
}

if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])
{
  $f->procede();
}


?>

<?php require 'header.php'; ?>

    <div class="container">

        <br>
      <?php if (isset($f->errorMessage)): ?>
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="bs-component">
                <div class="alert alert-danger">
                  <p><?php echo $f->errorMessage; ?></p>
                </div>
              <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div></div>
            </div>
          </div>
        </div>
       <?php endif; ?>

      <div class="container-fluid">
        <div class="row">

					<div class="col-lg-12">
            <div class="well bs-component">
              <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
		          	<input type="hidden" value="<?php echo $_SESSION['token']; ?>" name="token">
                <fieldset>
                  <div class="form-group <?php echo $f->errorTitle;?>">
                    <label class="col-lg-2 control-label">Title</label>
                    <div class="col-lg-10">
                      <input type="text" value="<?php echo $f->title; ?>" name="title" id="inputEmail" class="form-control">
                    </div>
                  </div>
                  <div class="form-group <?php echo $f->errorFile; ?>">
                    <label class="col-lg-2 control-label">Upload markdown file</label>
                    <div class="col-lg-10">
                      <input type="file" name="file">

                    </div>
                  </div>
									<div class="form-group <?php echo $f->errorContent; ?>">
                    <label class="col-lg-2 control-label" for="textArea">OR, Write slide content</label>
                    <div class="col-lg-10">
                      <textarea id="textArea" name="content" rows="6" class="form-control"><?php echo $f->content; ?> </textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div></div>
          </div>

        </div>
      </div>
    </div>

<?php require 'footer.php'; ?>