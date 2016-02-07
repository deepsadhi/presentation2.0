<?php

require_once '../../bootstrap/bootstrap.php';

use App\Form;

$f = new Form;
$f->initProfile();

if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])
{
  $f->changeSecret();
}


?>

<?php require 'header.php'; ?>

    <div class="container">

        <br><br>
      <?php if (isset($f->errorMessage)): ?>
        <div class="container-fluid">
          <div class="col-lg-3"></div>
          <div class="row">
            <div class="col-lg-6">
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

          <div class="col-lg-3">
          </div>
          <div class="col-lg-6">
            <div class="well bs-component">
              <form class="form-horizontal"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" value="<?php echo $_SESSION['token']; ?>" name="token">
                <fieldset>
                  <div class="form-group <?php echo $f->errorOldPass;?>">
                    <label class="col-lg-3 control-label">Old Password</label>
                    <div class="col-lg-8">
                      <input type="password" value="" name="oldpass" id="inputEmail" class="form-control">
                    </div>
                  </div>
                  <div class="form-group <?php echo $f->errorNewUser;?>">
                    <label class="col-lg-3 control-label">New Username</label>
                    <div class="col-lg-8">
                      <input type="text" value="<?php echo $f->user; ?>" name="newuser" id="inputEmail" class="form-control">
                    </div>
                  </div>
                  <div class="form-group <?php echo $f->errorNewPass;?>">
                    <label class="col-lg-3 control-label">New Password</label>
                    <div class="col-lg-8">
                      <input type="password" value="" name="newpass" id="inputEmail" class="form-control">
                    </div>
                  </div>


                  <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-3">
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