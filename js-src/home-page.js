// @prepros-prepend common.js
// @prepros-prepend goods-grid.js
// @prepros-prepend slick.1.9.0.min.js

$(function () {
  var $slick = $('.home-slider'),
    sliderAutoplaySpeed = 5000,
    $dotsSvg;

  $slick.on('init', function (e, slick) {
    $dotsSvg = slick.$dots.find('svg');
    animateCircle(slick.currentSlide);
  });

  $slick.slick({
    arrows: false,
    autoplay: true,
    autoplaySpeed: sliderAutoplaySpeed,
    pauseOnHover: false,
    adaptiveHeight: true,
    dots: true,
    customPaging : function(slider, i) {
      return '<span>' + 
        '<svg data-pager-slider="' + i + '" viewBox="0 0 24 24" width="24" height="24" version="1.1"xmlns="http://www.w3.org/2000/svg">' + 
          '<circle cx="12" cy="12" r="11" stroke-width="1" fill="none"/>' +
        '</svg>' +
      '</span>';
    },
  }).on('beforeChange', function () {
    resetCircleAnimation();
  }).on('afterChange', function (e, slick) {
    animateCircle(slick.currentSlide);
  });

  function animateCircle(index) {
    var $svg = $('[data-pager-slider="' + index + '"]'),
      $circle = $svg.find('circle'),
      radius = $circle.attr('r'),
      circumference = 2 * Math.PI * radius;

    $circle.stop(true, true).css({
      'stroke-dasharray': ''+ (circumference - ((1 * circumference) / 100)),
      'stroke-dashoffset': ''+ (circumference - ((1 * circumference) / 100)),
    });

    $svg.show();
      
    $circle.animate({
      'stroke-dashoffset': 0
    }, sliderAutoplaySpeed, 'linear', function () {
      $svg.hide()
    });      
  }

  function resetCircleAnimation() {
    $dotsSvg.hide();
  }  
});