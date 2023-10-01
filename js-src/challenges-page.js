// @prepros-prepend common.js
// @prepros-prepend related-products-slider.js
// @prepros-prepend jquery.countdown.min.js
// @prepros-prepend scrollbooster.min.js

$(function () {
  $('.challenges-item').each(function () {
    var countdown = $(this).attr('data-countdown');
    if (!countdown) {
      return;
    }
    $(this).countdown(countdown).on('update.countdown', function(event) {
      $(this).find('.challenges-item-timer').html(event.strftime(
        '<div class="challenges-item-timer__col">' + 
          '<span class="challenges-item-timer__value">%-D</span>' + 
          '<span class="challenges-item-timer__label">day%!d</span>' +
        '</div>' +
        '<div class="challenges-item-timer__col">' + 
          '<span class="challenges-item-timer__value">%H</span>' + 
          '<span class="challenges-item-timer__label">hour%!H</span>' + 
        '</div>' +
        '<div class="challenges-item-timer__col">' + 
          '<span class="challenges-item-timer__value">%M</span>' + 
          '<span class="challenges-item-timer__label">min</span>' + 
        '</div>' +
        '<div class="challenges-item-timer__col">' + 
          '<span class="challenges-item-timer__value">%S</span>' + 
          '<span class="challenges-item-timer__label">sec</span>' + 
        '</div>'
      ));
    });
  });

  new ScrollBooster({
    viewport: document.querySelector('.challenges-list-wrap'),
    content: document.querySelector('.challenges-list'),
    scrollMode: 'transform', // use CSS 'transform' property
    direction: 'horizontal', // allow only horizontal scrolling
    emulateScroll: true, // scroll on wheel events
  });
});