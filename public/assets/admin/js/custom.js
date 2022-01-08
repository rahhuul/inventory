$(document).ready(function(){
    $('.startmining').click(function() {
      $('.startmining').show();
    });
});

$("#accept_btn").click(function(){
    $("#window_accept").hide();
})



function openNav() {
  document.getElementById("mySidepanel").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}