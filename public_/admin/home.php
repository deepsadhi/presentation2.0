	<?php

	require_once '../../bootstrap/bootstrap.php';

	use App\Presentation;
	use App\File;

	$f = new File(APP_PATH.'/markdown');



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
		                <?php $i=0; foreach($f->lists('md|markdown') as $f): ?>
		                  <tr>
		                  	<td><?php echo ++$i; ?>
		                    <td><a href="show.php?file=<?php echo $f['name']; ?>"><?php echo $f['name']; ?></a></td>
		                    <td><?php echo $f['size']; ?></td>
		                    <td><?php echo $f['date']; ?></td>
		                    <td>
		                    	<a href="edit.php?file=<?php echo $f['name']; ?>" class="btn btn-primary btn-xs">edit</a>
		                    	<a href="delete.php?file=<?php echo $f['name']; ?>" class="btn btn-danger btn-xs">delete</a>
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

