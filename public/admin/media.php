<?php

require_once '../../bootstrap/bootstrap.php';

use App\File;
use App\Form;


$f = new File(APP_PATH.'/public/media');

$form = new Form;

if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])
{
  $form->upload();
}


?>

<?php require 'header.php'; ?>



		<div class="container">

		<br>
		<?php if ($s->isMessage()): $msg = $s->getMessage(); ?>
		  <div class="container-fluid">
		    <div class="row">
		      <div class="col-lg-12">
		        <div class="bs-component">
		          <div class="alert alert-<?php echo $msg['alert']; ?>">
		            <p><?php echo $msg['message']; ?></p>
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
		               <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		 		          	<input type="hidden" value="<?php echo $_SESSION['token']; ?>" name="token">
		                 <fieldset>

		                   <div class="form-group <?php echo $f->errorFile; ?>">
		                     <label class="col-lg-6 control-label">Upload image file (png, gif, bmp, jpg)</label>
		                     <div class="col-lg-2">
		                       <input type="file" name="file">
		                      </div>
		                     <div class="col-lg-2">
		                       <button class="btn btn-primary btn-sm" type="submit">Upload</button>

		                     </div>
		                   </div>

		                 </fieldset>
		               </form>
		             <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div></div>
		           </div>

		         </div>
		        </div>

			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
	              <table class="table table-striped table-hover ">
	                <thead>
	                  <tr>
	                    <th>#</th>
	                    <th>File name</th>
	                    <th>File size</th>
	                    <th>Modified on</th>
	                    <th>Action</th>
	                  </tr>
	                </thead>
	                <tbody>
	                <?php $i=0; foreach($f->lists('png|jpg|bmp|gif') as $f): ?>
	                  <tr>
	                  	<td><?php echo ++$i; ?>
	                    <td><a target="_blank"
	                    href="<?php echo str_replace('admin/media.php', "media/{$f['name']}", $_SERVER['PHP_SELF']); ?>"><?php echo $f['name']; ?></a></td>
	                    <td><?php echo $f['size']; ?></td>
	                    <td><?php echo $f['date']; ?></td>
	                    <td>

	                    	<a href="delete.php?file=<?php echo $f['name']; ?>&g=m" class="btn btn-danger btn-xs">delete</a>
	                    </td>
	                  </tr>
	                <?php endforeach; ?>
	                </tbody>
	              </table>
	            <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div></div><!-- /example -->
		    </div>
		  </div>
		</div>

<?php require 'footer.php'; ?>

