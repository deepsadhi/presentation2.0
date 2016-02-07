<?php

header('Content-type: text/json; charset: UTF-8');

require_once '../../bootstrap/bootstrap.php';

use App\Slide;

$file        = $_GET['file'];
$slideNumber = $_GET['slide'];

$s = new Slide(APP_PATH.'/markdown/'.$file);
echo $s->renderForAjax($slideNumber);