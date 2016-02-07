<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Presentation2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/vendor/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <span class="label label-danger pull-right" id="broadcast">Live</span>
            <a href="javascript:window.location.reload()" class="btn btn-primary btn-xs pull-right" id="reconnect">Reconnect</a>
          </div>
        </div>
      </div>

      <div class="continer-fluid">
        <div class="row">
          <div class="col-lg-12" id="container">
          </div>
        </div>
      </div>
    </div>


    <script src="js/vendor/jquery-1.js"></script>
    <!-- // <script src="js/vendor/bootstrap.js"></script> -->
    <!-- // <script src="js/custom.js"></script> -->
    <script type="text/javascript">
      (function(){
        $("#reconnect").hide();

        var conn = new WebSocket('ws://'+location.hostname+':8080');

        conn.onopen = function(e) {
            $("#broadcast").removeClass("label-default");
            $("#broadcast").addClass("label-danger");
            $("#broadcast").text("Live");
            $("#reconnect").hide();
        };

        conn.onmessage = function(e) {
          msg = JSON.parse(e.data);
          $("#container").html(msg.slide);
        };

        conn.onclose = function(e) {
            $("#broadcast").removeClass("label-danger");
            $("#broadcast").addClass("label-default");
            $("#broadcast").text("Off-line");
            $("#reconnect").show();
        };

      })();
  	</script>


<?php require 'admin/footer.php'; ?>
