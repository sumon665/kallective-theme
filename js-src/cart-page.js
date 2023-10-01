// @prepros-prepend common.js
// @prepros-prepend related-products-slider.js
// @prepros-prepend select2.min.js

$(function () {
  // custom select start
  $('.control-select select').select2({
    minimumResultsForSearch: -1,
    width: '100%'
  });
  // custom select end

  // cart steps start
  // function goToStep(step) {
  //   $('.cart-layout-nav__item.active').removeClass('active');
  //   $('.cart-step.active').removeClass('active');
  //   $('.cart-layout-nav__item[data-step="' + step + '"]').addClass('active');
  //   $('.cart-step[data-step="' + step + '"]').addClass('active');
  //   $('.cart-layout-sticky').attr('data-step-active', step);
  // }

  // $('.cart-layout-nav__item').on('click', function () {
  //   var step = $(this).attr('data-step');
  //   if (+step !== 1 || $(this).hasClass('active')) {
  //     return;
  //   }
  //   goToStep(step);
  // });

  // $('.cart-checkout').on('click', function () {
  //   goToStep(2);
  // });
  // cart steps end

  // dropdown start
  $(document).on('click', '.cart-summary-dropdown-toggle', function () {
    if($(this).hasClass('active')) {
      $(this).find('span').text('Show');
    } else {
      $(this).find('span').text('Hide');
    }
    $(this).toggleClass('active');
    $('.cart-summary-dropdown').toggleClass('_opened');
  })
  // dropdown end

  // sticky checkout btn start
  var $stickyCheckoutBtn = $('.cart-sticky-checkout'),
    $anchor = $('.cart-layout-sticky');

  if (!$stickyCheckoutBtn.length) {
    return;
  }

  function toggleStickyCheckout() {
    var offset = $anchor.offset().top - $(window).scrollTop() - window.innerHeight;
    if (offset < 50) {
      $stickyCheckoutBtn.removeClass('_visible');
    } else {
      $stickyCheckoutBtn.addClass('_visible');
    }
  }
  $(window).on('load scroll resize', toggleStickyCheckout);
  // sticky checkout btn end
});