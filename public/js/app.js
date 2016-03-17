$("#confirm-delete").on("show.bs.modal", function(e) {
    $(this).find(".btn-ok").attr("file", $(e.relatedTarget).data("file"));
    $("#name").html($(this).find(".btn-ok").attr("file"));

    $(this).find(".btn-ok").attr("file", $(e.relatedTarget).data("file"));
    $("#file").val($(this).find(".btn-ok").attr("file"));

    $(this).find(".btn-ok").attr("path", $(e.relatedTarget).data("path"));
    $("#path").val($(this).find(".btn-ok").attr("path"));
});

active = false;
$("#next").attr("disabled", true);
$("#prev").attr("disabled", true);

(function() {
    $("#reconnect").hide();
    $("#stop").hide();
    var conn = new WebSocket("ws://" + location.hostname + ":8080");


    conn.onopen = function(e) {
        msg = {
            "presenter": "true"
        };
        msg = JSON.stringify(msg);
        conn.send(msg);

        $("#broadcast").removeClass("label-default");
        $("#broadcast").addClass("label-success");
        $("#broadcast").text("On-line");
        $("#reconnect").hide();
    };

    conn.onmessage = function(e) {
        msg = JSON.parse(e.data);
        $("#slide").html(msg.slide);

        if (msg.prev === "undefined") {
            $("#prev").attr("disabled", true);
        } else {
            $("#prev").attr("disabled", msg.prev);
        }


        if (msg.prev === "undefined") {
            $("#next").attr("disabled", true);
        } else {
            $("#next").attr("disabled", msg.next);
        }
    };

    conn.onclose = function(e) {
        $("#broadcast").removeClass("label-success");
        $("#broadcast").addClass("label-default");
        $("#broadcast").text("Off-line");
        $("#reconnect").show();

    };



    $("#start").click(function() {
        active = true;

        url      = location.href;
        path     = url.split("/");
        fileName = path[5];
        fileName = fileName.slice(0, -3) + ".md";

        $("#container").html("<div id=\"slide\"></div>");
        msg = {
            "filename": fileName
        };
        msg = JSON.stringify(msg);
        conn.send(msg);

        $("#start").hide();
        $("#stop").show();
    });

    $("#stop").click(function() {
        msg = {
            "action": "stop"
        };
        msg = JSON.stringify(msg);
        conn.send(msg);

        $("#stop").hide();
        $("#start").show();
        active = false;
        loadSlide();
    });

    $("#prev").click(function() {


        if (active) {
            msg = {
                "action": "prev"
            };
            msg = JSON.stringify(msg);
            conn.send(msg);
        } else {

            if (slideNumber > 0) {
                slideNumber--;
                loadSlide();
            }
        }
    });


    $("#next").click(function() {
        if (active) {
            msg = {
                "action": "next"
            };
            msg = JSON.stringify(msg);
            conn.send(msg);
        } else {
            if (slideNumber < slideCount) {
                slideNumber++;
                loadSlide();
            }
        }

    });

})();






$(document).keydown(function(e) {
    switch (e.which) {
        // Left key
        case 37:
        {
            $("#prev").trigger("click");
            break;
        }
        // Right key
        case 39:
        {
            $("#next").trigger("click");
            break;
        }
        default:
        {
            // exit this handler for other keys
            return;
        }
    }

    // Prevent the default action (scroll / move caret)
    e.preventDefault();
});

$(function() {
    // Bind the swipeleftHandler callback function to the swipe event on div.box
    $("#container").on("swipeleft", swipeleftHandler);

    // Callback function references the event target and adds the "swipeleft" class to it
    function swipeleftHandler(event) {
        $("#next").trigger("click");
    }

    // Bind the swiperightHandler callback function to the swipe event on div.box
    $("#container").on("swiperight", swiperightHandler);

    // Callback function references the event target and adds the "swiperight" class to it
    function swiperightHandler(event) {
        $("#prev").trigger("click");
    }
});

slideCount  = 0;
slideNumber = 0;

function loadSlide() {
    url = location.href;
    url = url.replace("show", "slide");
    url = url + "/" + slideNumber;
    $.getJSON(url)
        .done(function(data) {
            if (data.error == false)
            {
                slideCount = data.slide.count;

                $("#container").html(data.slide.slide);
                $("#prev").attr("disabled", data.slide.prev);
                $("#next").attr("disabled", data.slide.next);
            }
            else
            {
                $("#container").html("<h1>Error! on parsing file :(</h1><br>");
            }
        })
        .fail(function(jqXHR, textStatus) {
            $("#container").html("<h1>Could not load slide :(</h1> <br> <h3>" +
                textStatus + "</h3>");
        });
}

$(document).ready(function() {
    loadSlide();
});

