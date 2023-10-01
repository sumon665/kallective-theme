// @prepros-prepend common.js
// @prepros-prepend jquery.countdown.min.js
// @prepros-prepend scrollbooster.min.js

$(function () {
  //tabs start
  $('.tabs-header-list__item').click(function() {
    if ($(this).hasClass('active')) {
      return;
    }

    var id = $(this).attr('data-tab'),
        $content = $('.tabs-content__item[data-tab="'+ id +'"]');
    
    $('.tabs-header-list__item.active').removeClass('active');
    $(this).addClass('active');
    
    $('.tabs-content__item.active').removeClass('active');
    $content.addClass('active');
  });
  //tabs end

  // progress start
  function setProgressTextWidth () {
    $('.raffle-progress__txt').css('width', $('.raffle-progress').width());
  }
  $(window).on('load resize', setProgressTextWidth);
  // progress end

  // related raffles start
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
  // related raffles end

  // timer start
  var countdown = $('.raffle-details-timer').attr('data-countdown');
  if (!countdown) {
    return;
  }
  $('.raffle-details-timer').countdown(countdown).on('update.countdown', function(event) {
    $(this).html(event.strftime(
      '<div class="raffle-details-timer__col">' + 
        '<span class="raffle-details-timer__value">%-D</span>' + 
        '<span class="raffle-details-timer__label">day%!d</span>' +
      '</div>' +
      '<div class="raffle-details-timer__col">' + 
        '<span class="raffle-details-timer__value">%H</span>' + 
        '<span class="raffle-details-timer__label">hour%!H</span>' + 
      '</div>' +
      '<div class="raffle-details-timer__col">' + 
        '<span class="raffle-details-timer__value">%M</span>' + 
        '<span class="raffle-details-timer__label">min</span>' + 
      '</div>' +
      '<div class="raffle-details-timer__col">' + 
        '<span class="raffle-details-timer__value">%S</span>' + 
        '<span class="raffle-details-timer__label">sec</span>' + 
      '</div>'
    ));
  });
  // timer end
  
});