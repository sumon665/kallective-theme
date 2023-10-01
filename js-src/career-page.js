// @prepros-prepend common.js
// @prepros-prepend select2.min.js

$(function () {
  // custom select start
  $('.control-select select').each(function () {
    $(this).select2({
      minimumResultsForSearch: -1,
      width: '100%',
      placeholder: $(this).attr('data-placeholder')
    });
  });
  // custom select end

  // toggle filters start
  var $filtersToggle = $('.career-filters-toggle'),
      $filtersMenu = $('.career-filters__body'),
      isOpened = false;
  function closeFilters() {
    $filtersToggle.removeClass('_opened').find('span').text('Show');
    $filtersMenu.stop(true, true).slideUp(300);
    isOpened = false;
  }
  $filtersToggle.on('click', function () {
    if (isOpened) {
      closeFilters();
    } else {
      $filtersToggle.addClass('_opened').find('span').text('Hide');
      $filtersMenu.stop(true, true).slideDown(300);
      isOpened = true;
    }    
  });
  $(document).on('click', function(event) { 
    var $target = $(event.target);
    if (window.innerWidth >= DESKTOP_MIN_WIDTH || $target.closest($filtersToggle).length) {
      return;
    }
    if(!$target.closest($filtersMenu).length) {
      closeFilters();
    }
  });
  // toggle filters end
});