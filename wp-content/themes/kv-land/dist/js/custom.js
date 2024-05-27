jQuery(document).ready(function () {
  Animatio();
});
function Animatio() {
  AOS.init({
    disable: "mobile",
    duration: 1200,
    delay: 300,
  });
}

$(".overlay").click(function(){ 
  $(".overlay").fadeOut();
  $(".p-tv").fadeOut();
  $(".popup-tv-khoan-vay").fadeOut();
  $(".menu").removeClass("active-menu");
});

$(".close-popup").click(function(){ 
  $(".overlay").fadeOut();
  $(".popup-tv-khoan-vay").fadeOut();
  $(".p-tv").fadeOut();
});

$(".btn-tv").click(function(){
  $(".p-tv").fadeIn();
  $(".overlay").fadeIn();
});

// $(".timeline .child").click(function () {
//   $(".timeline .child").removeClass("active");
//   $(this).addClass("active");
//   $(this).prevAll().addClass("active");
// });
// $(".timeline .child:first").trigger("click");

$(".menu-mobie").click(function(){
  $(".menu").addClass("active-menu");
  $(".overlay").fadeIn();
})
$(".close-menu").click(function(){
  $(".menu").removeClass("active-menu");
  $(".overlay").fadeOut();
})
$(window).scroll(function(){
  var pixel = $(window).scrollTop();
  if(pixel > 100){
    $('.header-wrapper').addClass('fixed-menu');
  } else {
    $('.header-wrapper').removeClass('fixed-menu');
  }
});