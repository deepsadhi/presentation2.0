<?php

require_once '../../bootstrap/bootstrap.php';

use App\Slide;
use App\File;

if (!isset($_GET['file']) || empty($_GET['file']))
{
  $s = new Session;
  $s->setMessage('warning', 'Please select a slide');
  header('Location: home.php');
  exit;
}

$fileName    = $_GET['file'];

if (!file_exists(APP_PATH.'/markdown/'.$fileName))
{
  $s = new Session;
  $s->setMessage('warning', 'Please select a slide');
  header('Location: home.php');
  exit;
}

$slideNumber = isset($_GET['slide']) ? $_GET['slide'] : 0;

$s = new Slide(APP_PATH.'/markdown/'.$fileName);


?>


<?php require 'presenter.header.php'; ?>

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



    <script src="../js/vendor/jquery-1.js"></script>
    <script src="../js/vendor/jquery.mobile.custom.min.js"></script>
		<script type="text/javascript">
      active = false;
      $("#next").attr("disabled", true);
      $("#prev").attr("disabled", true);
      (function(){
            $("#reconnect").hide();
            $("#stop").hide();
            var conn = new WebSocket('ws://'+location.hostname+':8080');


          conn.onopen = function(e) {

            msg = {'presenter' : 'true' };
            msg = JSON.stringify(msg);
            conn.send(msg);

            $("#broadcast").removeClass("label-default");
            $("#broadcast").addClass("label-danger");
            $("#broadcast").text("Live");
            $("#reconnect").hide();
          };

        conn.onmessage = function(e) {
          msg = JSON.parse(e.data);
          $("#slide").html(msg.slide);

          if (msg.prev === 'undefined')
          {
            $("#prev").attr("disabled", true);
          }
          else
          {
            $("#prev").attr("disabled", msg.prev);
          }


          if (msg.prev === 'undefined')
          {
            $("#next").attr("disabled", true);
          }
          else
          {
            $("#next").attr("disabled", msg.next);
          }
        };

          conn.onclose = function(e) {
            $("#broadcast").removeClass("label-danger");
            $("#broadcast").addClass("label-default");
            $("#broadcast").text("Off-line");
            $("#reconnect").show();

        	};



          $("#start").click(function() {
            active = true;

              $("#container").html("<div id=\"slide\"></div>");
              msg = {'filename' : '<?php echo $fileName; ?>'};
              msg = JSON.stringify(msg);
              conn.send(msg);

              $("#start").hide();
              $("#stop").show();
          });

          $("#stop").click(function () {
            msg = {'action' :  'stop'};
            msg = JSON.stringify(msg);
            conn.send(msg);

            $("#stop").hide();
            $("#start").show();
            active = false;
            loadSlide();
          });

          $("#prev").click(function (){


            if (active)
            {
              msg = {'action' :  'prev'};
              msg = JSON.stringify(msg);
              conn.send(msg);
            }
            else
            {

              if (slideNumber > 0)
              {
                slideNumber--;
                loadSlide();
              }
            }
          });


          $("#next").click(function (){
            if (active)
            {
              msg = {'action' :  'next'};
              msg = JSON.stringify(msg);
              conn.send(msg);
            }
            else
            {
              if (slideNumber < slideCount)
              {
                slideNumber++;
                loadSlide();
              }
            }

          });

      })();
      slideNumber = 0;
      slideCount = 0;


      function loadSlide()
      {
      $.getJSON("json.php?"+location.href.split("?")[1]+"&slide="+slideNumber)
        .done(function(data ) {
          $("#container").html(data.slide);
          $("#prev").attr("disabled", data.prev);
          $("#next").attr("disabled", data.next);
          slideCount = data.count;
        })
        .fail(function(jqXHR, textStatus) {
          $("#container").html("<h1>Could not load slide :(</h1> <br> <h3>"+textStatus+"</h3>");
        });
      }

      loadSlide();

      $(document).keydown(function(e) {
          switch(e.which) {
              case 37: // left
              {
                $("#prev").trigger("click");

                break;
              }


              case 39: // right
              {
                $("#next").trigger("click");

                break;
              }

              default: return; // exit this handler for other keys
          }
          e.preventDefault(); // prevent the default action (scroll / move caret)
      });

      $(function(){
        // Bind the swipeleftHandler callback function to the swipe event on div.box
        $( "#container" ).on( "swipeleft", swipeleftHandler );

        // Callback function references the event target and adds the 'swipeleft' class to it
        function swipeleftHandler( event ){
          $("#next").trigger("click");
        }

          // Bind the swiperightHandler callback function to the swipe event on div.box
        $( "#container" ).on( "swiperight", swiperightHandler );

        // Callback function references the event target and adds the 'swiperight' class to it
        function swiperightHandler( event ){
          $("#prev").trigger("click");
        }
      });


		</script>

<?php require 'footer.php'; ?>