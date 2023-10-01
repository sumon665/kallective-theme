var utils = window.utils || {};
var pageScrollTop;

utils.lockBodyScroll = function() {
  var scrollWidth = window.innerWidth - document.documentElement.clientWidth;
  if (window.pageYOffset) {
    pageScrollTop = window.pageYOffset;

    $('.site-wrap').css({
      top: -pageScrollTop
    });
  }

  utils.isBodyScrollLocked = true;

  $('body').css({
    position: 'fixed'
  });

  $('body').css('padding-right', scrollWidth + 'px');
  $('.header').css('padding-right', scrollWidth + 'px');
};

utils.unlockBodyScroll = function() {
  $(' body').css({
    position: ''
  });

  $('.site-wrap').css({
    top: ''
  });

  $('body').css('padding-right', '');
  $('.header').css('padding-right', '');

  if (utils.isBodyScrollLocked) {
    window.scrollTo(0, pageScrollTop);
  }
  window.setTimeout(function() {
    pageScrollTop = null;
  }, 0);

  utils.isBodyScrollLocked = false;
};

utils.closeModal = function($modal) {
  utils.unlockBodyScroll();
  $modal.hide();
  $.event.trigger({
    type: 'modal.closed',
    message: $modal.attr('id'),
  });
}

utils.openModal = function($modal) {
  utils.lockBodyScroll();
  $modal.show();
  $.event.trigger({
    type: 'modal.opened',
    message: $modal.attr('id'),
  });
}

utils.disableFormBtn = function($el, addLoading) {
  $el.prop('disabled', true);
  if(addLoading) {
    $el.addClass('_loading');
  }
}

utils.enableFormBtn = function($el) {
  $el.prop('disabled', false).removeClass('_loading');
}

utils.isBodyScrollLocked = false;
