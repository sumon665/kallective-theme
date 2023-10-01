// @prepros-prepend owl.carousel.min.js

$(function () {
  // related products slider start  
  $('.related-products').addClass('owl-carousel').owlCarousel({
    loop:true,
    autoWidth:true,
    nav:true,
    center:false,
    items:1,
    responsive : {
      0 : {
        margin: 24,
      },
      768 : {
        margin: 40,
      },
  }
  });
  // related products slider end
});