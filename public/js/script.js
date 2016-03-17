$("#reconnect").hide();

(function() {
var conn = new WebSocket('ws://'+location.hostname+':8080');

conn.onopen = function(e) {
    $("#broadcast").removeClass("label-default");
    $("#broadcast").addClass("label-success");
    $("#broadcast").text("On-line");
    $("#reconnect").hide();
};

conn.onmessage = function(e) {
  msg = JSON.parse(e.data);
  $("#container").html(msg.slide);
};

conn.onclose = function(e) {
    $("#broadcast").removeClass("label-success");
    $("#broadcast").addClass("label-default");
    $("#broadcast").text("Off-line");
    $("#reconnect").show();
};

})();
