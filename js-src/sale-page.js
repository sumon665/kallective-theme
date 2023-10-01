// @prepros-prepend common.js
// @prepros-prepend goods-grid.js

$(function () {
  var $collapsibleContent = $('.sale-content-collapsible'),
  $collapsibleContentBtn = $('.sale-content-collapsible-btn'),
    isOpened = false;
  function getContentHeight() {
    var height = 0;
    $collapsibleContent.children().each(function () {
      height += $(this).outerHeight(true);
    });
    return height;
  }
  function hideContent() {
    isOpened = false;
    $collapsibleContent.removeClass('_opened').removeAttr('style');
    $collapsibleContentBtn.find('span').text('Show more');
  }
  function showContent() {
    isOpened = true;
    $collapsibleContent.addClass('_opened').css('max-height', getContentHeight());
    $collapsibleContentBtn.find('span').text('Hide');
  }
  $collapsibleContentBtn.on('click', function () {    
    if (window.innerWidth < TABLET_MIN_WIDTH && isOpened) {      
      hideContent();
    } else {
      showContent();
    }
  });

  $(window).on('load resize', function () {
    if(window.innerWidth < TABLET_MIN_WIDTH) {
      if (isOpened) {
        showContent();
      }
    } 
    // else {
    //   hideContent();
    // }
  });
});