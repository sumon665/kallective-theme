// @prepros-prepend common.js
// @prepros-prepend related-products-slider.js

$(function () {
  // nav start
  var  $nav = $('.faq-nav'),
    $navList = $nav.find('.faq-nav__list'),
    $navToggle = $nav.find('.faq-nav__toggle');

  function closeNav() {
    $nav.removeClass('_opened');
    $navList.removeAttr('style');
  }

  $navToggle.on('click', function () {
    if (window.innerWidth > DESKTOP_MIN_WIDTH) {
      return;
    }
    
    if ($nav.hasClass('_opened')) {      
      closeNav();
    } else {
      $nav.addClass('_opened');
      var $menuItems = $navList.find('li'),
        height = 0;
  
      $menuItems.each(function () {
        height += $(this).outerHeight(true);
      });
  
      $navList.css('height', height); 
    }  
  });

  // $navList.find('a').on('click', function (e) {
  //   e.preventDefault();
  //   closeNav();
  //   if($(this).hasClass('active')) {
  //     return;
  //   }
    
  //   $navList.find('.active').removeClass('active');    
  //   $(this).addClass('active');
  //   $navToggle.html($(this).html());
  // });

  $(document).on('click', function(event) { 
    var $target = $(event.target);
    if(!$target.closest($nav).length) {
      closeNav();
    }
  });
  // nav end
});