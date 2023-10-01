// @prepros-prepend common.js
// @prepros-prepend related-products-slider.js
// @prepros-prepend select2.min.js

$(function () {
  // nav start
  var  $nav = $('.cabinet-nav'),
    $navList = $nav.find('.cabinet-nav__list'),
    $navToggle = $nav.find('.cabinet-nav__toggle');

  $navToggle.text($('li.is-active a', $navList).text()).addClass('_initialized');

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
  //   $navToggle.text($(this).text());
  // });

  $(document).on('click', function(event) { 
    var $target = $(event.target);
    if(!$target.closest($nav).length) {
      closeNav();
    }
  });
  // nav end

  // custom select start
  $('.control-select select').each(function () {
    $(this).select2({
      minimumResultsForSearch: -1,
      width: '100%',
      placeholder: $(this).attr('data-placeholder'),
      dropdownCssClass: $(this).attr('data-class'),
    });
  });
  // custom select end
});