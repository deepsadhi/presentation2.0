// Fire on Bootstrap modal load
$("#confirm-delete").on("show.bs.modal", function(e) {
    $(this).find(".btn-ok").attr("file", $(e.relatedTarget).data("file"));
    $("#name").html($(this).find(".btn-ok").attr("file"));

    $(this).find(".btn-ok").attr("file", $(e.relatedTarget).data("file"));
    $("#file").val($(this).find(".btn-ok").attr("file"));

    $(this).find(".btn-ok").attr("path", $(e.relatedTarget).data("path"));
    $("#path").val($(this).find(".btn-ok").attr("path"));
});

// Initialize slide count and slide number
slideCount  = 0;
slideNumber = 0;

// Load presentation slide to DIV container
function loadSlide() {
    // Set presentation broadcast to false
    active = false;

    // Get url and attach slide number to it
    url = location.href;
    url = url.replace("show", "slide");
    url = url + "/" + slideNumber;

    // Make Ajax request
    $.getJSON(url)
    .done(function(data) {
        if (data.error == false)
        {
            // Set slide count
            slideCount = data.slide.count;

            // Load slide content to DIV container
            $("#container").html(data.slide.slide);
            $("#prev").attr("disabled", data.slide.prev);
            $("#next").attr("disabled", data.slide.next);
        }
        else
        {
            // Error on parsing presentation file
            $("#container").html("<h1>Error! on parsing file :(</h1><br>");
        }
    })
    .fail(function(jqXHR, textStatus) {
        // Error on making Ajax request
        $("#container").html("<h1>Could not load slide :(</h1> <br> <h3>" +
            textStatus + "</h3>");
    });
}

(function() {
    // Set presentation broadcast to false
    active = false;

    // Disable next and previous button
    $("#next").attr("disabled", true);
    $("#prev").attr("disabled", true);

    // Hide Reconnect and Stop button
    $("#reconnect").hide();
    $("#stop").hide();

    // Create Web Socket connection on port 8080
    var conn = new WebSocket("ws://" + location.hostname + ":8080");

    // Web Socket connection open
    conn.onopen = function(e) {
        // Register Web Socket connection as presenter
        msg = {
            "presenter": "true"
        };
        msg = JSON.stringify(msg);
        conn.send(msg);

        // If presentation is not broadcast load slides without Web Socket conn
        if (active == false)
        {
            loadSlide();
        }

        // Web Socket connection is successfully established
        // Display a "On-line" label
        $("#broadcast").removeClass("label-default");
        $("#broadcast").addClass("label-success");
        $("#broadcast").text("On-line");
        $("#reconnect").hide();
    };

    // Message received on Web Socket connection
    conn.onmessage = function(e) {
        // Load broad casted presentation slide to DIV container
        msg = JSON.parse(e.data);
        $("#container").html(msg.slide);

        // Set Previous button
        if (msg.prev === "undefined") {
            $("#prev").attr("disabled", true);
        } else {
            $("#prev").attr("disabled", msg.prev);
        }

        // Set Next button
        if (msg.prev === "undefined") {
            $("#next").attr("disabled", true);
        } else {
            $("#next").attr("disabled", msg.next);
        }

        // If presentation is stopped by presenter hide Stop button and show
        // Start button
        // Also load default slide
        if (msg.action !== "undefined" && msg.action == 'stop')
        {
            $("#stop").hide();
            $("#start").show();

            loadSlide();
        }
    };

    // Web Socket connection is closed
    conn.onclose = function(e) {
        $("#broadcast").removeClass("label-success");
        $("#broadcast").addClass("label-default");
        $("#broadcast").text("Off-line");
        $("#reconnect").show();
    };

    // Click on Start button
    $("#start").click(function() {
        // Presentation is broadcast started
        // Viewer can see presentation in real time
        active = true;

        // Error message for failure of Web Socket connection
        errorMsg = "<h1>Couldn't establish Web Socket connection :(</h1><br>\
                    <h3>Check Presentation 2.0 Web Socket Daemon status.<h3><br>\
                   ";
        $("#container").html(errorMsg);

        // Extract presentation filename from URL
        url      = location.href;
        path     = url.split("/");
        fileName = path[5];
        fileName = fileName.slice(0, -3) + ".md";

        // Send presentation filename to Presentation 2.0 Daemon
        msg = {
            "filename": fileName
        };
        msg = JSON.stringify(msg);
        conn.send(msg);

        // Hide Start button and show Stop button
        $("#start").hide();
        $("#stop").show();
    });

    // Click on stop button
    $("#stop").click(function() {
        // Send signal to Presentation 2.0 Daemon to stop broadcast of
        // presentation
        msg = {
            "action": "stop"
        };
        msg = JSON.stringify(msg);
        conn.send(msg);

        // Hide Stop button show Start button
        $("#stop").hide();
        $("#start").show();

        // Broadcast of presentation is is not active
        active = false;
        loadSlide();
    });

    // Click on Prev button
    $("#prev").click(function() {
        if (active) {
            // If presentation is in broadcast mode send "Prev" signal to
            // Presentation 2.0 Daemon
            msg = {
                "action": "prev"
            };
            msg = JSON.stringify(msg);
            conn.send(msg);
        } else {
            // If presentation is not in broadcast mode send "Prev" make Ajax
            // request
            if (slideNumber > 0) {
                slideNumber--;
                loadSlide();
            }
        }
    });

    $("#next").click(function() {
        if (active) {
            // If presentation is in broadcast mode send "Next" signal to
            // Presentation 2.0 Daemon
            msg = {
                "action": "next"
            };
            msg = JSON.stringify(msg);
            conn.send(msg);
        } else {
            // If presentation is not in broadcast mode send "Next" make Ajax
            // request
            if (slideNumber < slideCount) {
                slideNumber++;
                loadSlide();
            }
        }
    });

})();

// Bind presentation Next and Previous controls with Left and Right key
$(document).keydown(function(e) {
    switch (e.which) {
        // Left key
        case 37: {
            $("#prev").trigger("click");
            break;
        }
        // Right key
        case 39: {
            $("#next").trigger("click");
            break;
        }
        default: {
            // exit this handler for other keys
            return;
        }
    }

    // Prevent the default action (scroll / move caret)
    e.preventDefault();
});

// Bind presentation Next and Previous controls with swipe left and swipe right
$(function() {
    // Bind the swipeleftHandler
    $("#container").on("swipeleft", swipeleftHandler);

    // Callback function references the event target
    function swipeleftHandler(event) {
        $("#next").trigger("click");
    }

    // Bind the swiperightHandler
    $("#container").on("swiperight", swiperightHandler);

    // Callback function references the event target
    function swiperightHandler(event) {
        $("#prev").trigger("click");
    }
});

// Load slide after web page loads
$(document).ready(function () {
    loadSlide();
});
