$(document).ready(function(){
  $("delete-post").hover(
    function () {
      $(this).removeClass('disabled');
    },
    function () {
      $(this).addClass('disabled');
    }
    );
});

console.log("working")
