// @prepros-prepend  utils.js
// @prepros-prepend  menu.js

var DESKTOP_MIN_WIDTH = 1232;
var TABLET_MIN_WIDTH = 768;

var actionsMap = {
  add_review: 'add_review',
};

$.fn.inputFilter = function(inputFilter) {
  return this.on('input keydown keyup mousedown mouseup select contextmenu drop', function() {
    if (inputFilter(this.value)) {
      this.oldValue = this.value.replace(/^0+/, '');
      this.oldSelectionStart = this.selectionStart;
      this.oldSelectionEnd = this.selectionEnd;
      this.value = this.value.replace(/^0+/, '');
    } else if (this.hasOwnProperty('oldValue')) {
      this.value = this.oldValue.replace(/^0+/, '');
      this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
    } else {
      this.value = '';
    }
  });
};

$(function () {
  // footer menu start
  function closeFooterMenu() {
    $('.footer-top-menu-col__title').removeClass('_opened');
    $('.footer-top-menu').removeAttr('style');
  }

  $('.footer-top-menu-col__title').on('click', function () {
    if (window.innerWidth > DESKTOP_MIN_WIDTH) {
      return;
    }

    var isOpenedMenuCLicked = false;
    
    if ($(this).hasClass('_opened')) {      
      isOpenedMenuCLicked = true;
    }
    closeFooterMenu();
    if (isOpenedMenuCLicked) {
      return;
    }

    $(this).addClass('_opened');
    var $menu = $(this).next('.footer-top-menu'),
      $menuItems = $menu.find('li'),
      height = 0;

    $menuItems.each(function () {
      height += $(this).outerHeight(true);
    });

    $menu.css('height', height);    
  });
  // footer menu end

  // footer subscribe start
  // var $footerSubscribeForm = $('#footer-subscribe-form'),
  //   $footerSubscribeFormBtn = $footerSubscribeForm.find('#footer-subscribe-form-submit');

  // $footerSubscribeForm.validate({
  //   rules : {
  //     email: {
  //       required: true,
  //       customemail: true
  //     },
  //   },
  //   submitHandler: function(form, e) {
  //     e.preventDefault();
  //     utils.disableFormBtn($footerSubscribeFormBtn, true);

  //     $.post('subscribeformurl', $(form).serializeArray())
  //       .done(function() {
  //         $('.footer-subscribe').addClass('_success');
  //       })
  //       .fail(function(error) {
  //         alert(error)
  //       }).always(function () {
  //         utils.enableFormBtn($footerSubscribeFormBtn);
  //       });
  //   }
  // });
  // footer subscribe end

  // cart panel start
  var isPerformingFormAnimation = false,
    $cartPanelModal = $('.cart-panel-modal'),
    isCheckCartView = false;
  function openCartPanelModal(addCheckCartViewClass) {
    isCheckCartView = addCheckCartViewClass;
    if (!isPerformingFormAnimation) {
      utils.lockBodyScroll();
      $('body').addClass('cart-panel-opened ' + (isCheckCartView ? 'cart-sidebar-check-cart-view' : ''));
      setTimeout(function () {
        $cartPanelModal.addClass('_animate');
      }, 10);
    }
  };
  function closeCartPanelModal() {
    if (!isPerformingFormAnimation) {
      isPerformingFormAnimation = true;
      utils.unlockBodyScroll();
      $cartPanelModal.removeClass('_animate');
      setTimeout(function () {
        $('body').removeClass('cart-panel-opened ' + (isCheckCartView ? 'cart-sidebar-check-cart-view' : ''));   
        isPerformingFormAnimation  = false;
        isCheckCartView = false;
      }, 320);
    }
  };
  $('.open-cart-panel').on('click', function (e) {
    e.preventDefault();
    openCartPanelModal($(e.target).attr('data-check-cart-view'));
  });
  $cartPanelModal.on('click', function (e) {
    if (e.target === $cartPanelModal[0]) {
      closeCartPanelModal();
    }
  });
  $(document).on('click', '.cart-panel-modal__close', closeCartPanelModal);
  $(document).on('click', '.cart-panel-empty__link', function (e) {
    if (document.location.pathname === '/'){
      e.preventDefault();
    }
    closeCartPanelModal();
  });
  // cart panel end

  // input number start
  $('.control-number input').inputFilter(function(value) {
    return /^\d*$/.test(value); 
  });
  $(document).on('click', '.control-number__btn', function () {
    var $input = $(this).parent().find('input');
    if ($(this).hasClass('_inc')) {
      $input.val(parseInt($input.val()) + 1).trigger('change');
    } else if ($input.val() > 1) {
      $input.val(parseInt($input.val()) - 1).trigger('change');
    }
  });
  // input number end

  // modal start
  $('.open-modal').on('click', function() {
    utils.openModal($($(this).attr('data-modal')));
  });
  $('.close-modal').on('click', function() {
    utils.closeModal($(this).closest('.modal'));    
  });
  // modal end

  // favorites popover start
  var $favoritesPopover = $('.favorites-popover');
  function openFavoritesPopover() {
    if (window.innerWidth < TABLET_MIN_WIDTH) {
      utils.lockBodyScroll();
    } else {
      utils.unlockBodyScroll();
    }
    $favoritesPopover.toggleClass('_visible');
  }
  function closeFavoritesPopover() {
    if ($favoritesPopover.hasClass('_visible')) {
      utils.unlockBodyScroll();
      $favoritesPopover.removeClass('_visible');
    }
  }
  $('.open-favorites-popover').on('click', openFavoritesPopover);
  $(document).on('click', '.close-favorites-popover', closeFavoritesPopover);

  $(document).on('click', function(event) { 
    var $target = $(event.target);
    if(!$target.closest($('.favorites-popover-menu-item')).length) {
      closeFavoritesPopover();
    }
  });
  // favorites popover end

  // login modal start
  $loginModalTitle = $('#login-modal-title');
  $('.login-form__link').on('click', function () {
    var formName = $(this).attr('data-form'),
     $form = $('.login-form[data-form="' + formName + '"]');

    $('.login-form').hide();
    $loginModalTitle.text($form.attr('data-title'));
    $form.show();
  });
  $('.login-form__link[data-form="signin"]').trigger('click');
  $(document).on('modal.closed', function (e) {
    if (e.message === 'login-modal') {
      $('.login-form__link[data-form="signin"]').trigger('click');
    }
  });
  $(document).on('click', '#login-modal', function (e) {
    if (e.target === $(this)[0]) {
      utils.closeModal($(this));
    }
  });
  // login modal end

  // faq accordion start
  $('.accordion-item').on('click', function () {
    $(this).toggleClass('_opened').find('.accordion-item__body').stop(true, true).slideToggle();
  });
  // faq accordion end

  // sticky header start
  var $header = $('.header'), 
    $headerTopSection = $('.header-top-section'),
    $desktopMenu = $('.menu-modal');
    
  function setStickyHeader() {
    if (utils.isBodyScrollLocked) {
      return;
    }
    var scrollTop = $(window).scrollTop(),
      offset = $headerTopSection.outerHeight(true);

    if (scrollTop > 0) {
      if (scrollTop > offset) {
        $header.css('margin-top', -offset);
        $desktopMenu.css('margin-top', -offset);
      } else {
        $header.css('margin-top', -scrollTop);
        $desktopMenu.css('margin-top', -scrollTop);
      }        
    } else if (scrollTop === 0) {
      $header.css('margin-top', 0);
      $desktopMenu.css('margin-top', 0);
    }
  }
  $(window).on('load resize scroll', setStickyHeader);
  // sticky header end
});