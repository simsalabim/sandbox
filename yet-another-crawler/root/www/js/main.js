/**
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

$(document).ready(function() {
  var action = "/index/search";
  $("#submit").click(function(){
    $("#indicator .spin").show();
    var params = $('#search').serialize();
    $.post(action, params, function(data) {
      $("#updater").html(data);
      $("#indicator .spin").hide();
    });
    return false;
  });
});

