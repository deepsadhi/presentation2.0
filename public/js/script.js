// Hide reconnect button
$("#reconnect").hide();

(function() {
    // Create Web Socket connection on port 8080
    var conn = new WebSocket('ws://'+location.hostname+':8080');

    // Web Socket connection open
    conn.onopen = function(e) {
        $("#broadcast").removeClass("label-default");
        $("#broadcast").addClass("label-success");
        $("#broadcast").text("On-line");
        $("#reconnect").hide();
    };

    // Message ie slide content received on Web Socket connection
    conn.onmessage = function(e) {
      msg = JSON.parse(e.data);
      $("#container").html(msg.slide);
    };

    // Web Socket connection is closed
    conn.onclose = function(e) {
        $("#broadcast").removeClass("label-success");
        $("#broadcast").addClass("label-default");
        $("#broadcast").text("Off-line");
        $("#reconnect").show();
    };

})();
