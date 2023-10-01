( function( $ ) {
  $('body').on('click', '.toggleFav', function(e){
    e.preventDefault();
    if($(this).hasClass('noAuth')){
      return false;
    }
    
    var data = {
      action: 'sweetcode_toggle_favourites',
      good_id: $(this).data('id')
    };
    $('.product-tile[data-id="' + $(this).data('id') + '"]').toggleClass('_favorite');
    if($('.details.toggleFav[data-id="' + $(this).data('id') + '"]').length) {
      $('.details.toggleFav[data-id="' + $(this).data('id') + '"]').toggleClass('_favorite');
    }
    if($(this).hasClass('cabinet-favorites-item__btns-remove')){
      $(this).closest('li').remove();
      if(!$('.cabinet-favorites-item').length) {
		  $('.cabinet-favorites').remove();
		  $('.cabinet-favorites-empty').show();
	  }
    }
    $.post( wc_add_to_cart_params.ajax_url, data, function( response ) {
      var res = $(response),
          cnt = $(response).find('.favorites-popover-item').length;
      $('.favorites-popover').html($('<div>').append(res.clone()).html());
      $('.open-favorites-popover ._count').text(cnt).toggleClass('hidden', !cnt);

    });
  });

  $('body').on('click', '.noAuth', function(e){
	  e.preventDefault();
    $('[data-modal="#login-modal"]').click();
    $('[data-form="signin"]').attr('action', '');
  });

  $(document).on('change', '.cart-delivery-payment input[name="payment_method"]', function(){
    $('.payment_box').not('.payment_method_' + $(this).data('id')).addClass('hidden');
    $('.payment_method_' + $(this).data('id')).removeClass('hidden');
  });
  
  $(document).on('change', '.cart-delivery-payment input[name="wc-stripe-payment-token"]', function(){
    if ($(this).val() === 'new' && $(this).is(':checked')) {
      $('._cvc-hint').show();
    } else {
      $('._cvc-hint').hide();
    }
  });

  function submitCouponForm(coupon) {
    $('.cart-promocode-form').addClass('_loading');
    $('#coupon_code').val(coupon);
    $('.woocommerce-form-coupon').submit();
  }

  $(document).on('keydown', '#promoInp', function(e){
    if (e.keyCode == 13) {
      e.preventDefault();
      var val = $(this).val();
      if (val.length && val.trim() !== ''){
        submitCouponForm(val);
      }
    }
  });

  $(document).on('input', '#promoInp', function (e) {
    if (e.target.value && e.target.value.trim() !== '') {
      $('#cart-promocode-form').addClass('_promo-has-value');
    } else {
      $('#cart-promocode-form').removeClass('_promo-has-value');
    }
  });

  $(document).on('click', '#promoApply', function(e){
    submitCouponForm($('#promoInp').val());
  });

  if ($('.cart-summary-row._coupon').length) {
    $('.cart-summary').addClass('_has-coupon');
    $('#promoInp').val($('.woocommerce-remove-coupon').data('coupon'));
    $('#cart-promocode-form').addClass('_success').show();
  } else {
    $('#cart-promocode-form').show();
  }

  $(document).on('ajaxSuccess', function(e, xhr, settings){
    if(settings.url == "/?wc-ajax=apply_coupon"){
      if(xhr.responseText.indexOf('success') !== -1){
        $('#promoInp').blur();
        $('#cart-promocode-form').addClass('_success').removeClass('_error _loading _promo-has-value');
        $('.cart-summary').addClass('_has-coupon');
      } else{
        $('#cart-promocode-form').addClass('_error').removeClass('_success _loading');
      }
    } else if(settings.url == "/?wc-ajax=remove_coupon"){
      if(xhr.status === 200){
        $('#promoInp').val('').trigger('change');
        $('#cart-promocode-form').removeClass('_success _error _loading').show();
        $('.cart-summary').removeClass('_has-coupon');
      }
    }
  });
  
  // Place order btn - set loader markup
  function setLoaderMarkupToPlaceOrderBtn() {
    var html = $('<span class="btn-label">' + $('#place_order').text() + '</span><span class="icon icon-spinner"></span>')
    $('.cart-delivery-place-order').html(html);
  }
  setLoaderMarkupToPlaceOrderBtn();
  $(document).on('payment_method_selected', setLoaderMarkupToPlaceOrderBtn);

  // Place order btn - add loader 
  $(document).on('click', '.cart-delivery-place-order', function () {
    $('.cart-delivery-place-order').addClass('_loading');
  });

  // Place order btn - remove loader 
  $(document).on('checkout_error', function() {
    $('.cart-delivery-place-order').removeClass('_loading');
  });
  
  $(document).on('wc_variation_form.wvs', '.variations_form:not(.wvs-loaded)', function (event) {
    setVariationPrice();
    $('.product-details-option-row').each(function(){
      if($(this).data('id') !== 'pa_color'){
        $('#' + $(this).data('id')).select2({
          width:"100%",
          minimumResultsForSearch: -1,
          placeholder: 'Choose an option'
		    });
      }
    });
  });
  $( ".single_variation_wrap" ).on( "show_variation", function ( event, variation ) {
    var imgSrc = variation.image.full_src;
    var imagesArr = $('.product-gallery').data('images');
    var fotorama = $('.product-gallery').data('fotorama');
    fotorama.show(imagesArr.indexOf(imgSrc));
    setVariationPrice();
  });

  
  $('body').on('click', '.removeRecommend', function(e){
    e.preventDefault();
    var data = {
      action: 'kallective_remove_recommend',
      good_id: $(this).data('id')
    };
    $(this).closest('li').remove();
    $.post( wc_add_to_cart_params.ajax_url, data, function( response ) {
    });
  });

  $('body').on('submit', '.wpcf7-form', function(){
    $(this).find('button').addClass('_loading');
  });

  document.addEventListener( 'wpcf7mailsent', function( event ) {
    if(event.detail.contactFormId == "158"){ 
      $('.footer-subscribe').addClass('_success');
    } else {
      $(event.target).find('.contact-form_footer').append('<div class="contact-form_sent">Thank you for your message. It has been sent.</div>');
    }
    $('.wpcf7-form button').removeClass('_loading');
  }, false );
  document.addEventListener( 'wpcf7invalid', function( event ) {
     $('.wpcf7-form button').removeClass('_loading');
  }, false );

  $('.nyp').addClass('control-input');
  $('#product-review').removeAttr('novalidate');

  $('.goods-filters-categories__list a').on('click', function(){
    location.href = $(this).attr('href');
  });

  initAjaxPagination();

  $('.applyVacancy').on('click', function(){
    var title = $(this).data('title');
    $(".career-contact-section [name='your-message']").val("I am very interested in the vacancy of " + title);
    $('html, body').animate({
      scrollTop: $(".career-contact-section").offset().top - 100
    }, 700);

  });

  $('.cancelSubModal').on('click', function(){
    $('.cancelSubConfirm').data('url', $(this).data('url'));
  });

  $('.cancelSubConfirm').on('click', function(){
    var cancelUrl = $(this).data('url');
    $(this).addClass('_loading');
    $.ajax({
      url: cancelUrl,
      success: function(res){
        $('#subStage1').hide();
        $('#subStage2').slideDown();
      }
    });
  });

  $(document).on('click', '.remove_from_cart', function(e){
    e.preventDefault();
    $(this).closest('.cart-good__ctrs').find('.qty').val(0).trigger('change');
  });

  $('.account-form__link').on('click', function(e){
    e.preventDefault();
    var form = $(this).data('form');
    var titleText = form == 'register' ? 'Sign Up' : 'Sign In';
    $('.account-form').hide();
    $('.account-form[data-form="' + form + '"]').show();
    $('.account-form-title').text(titleText);
  });

  $('._show-all').on('click', function(){
    $(this).closest('ul').find('li').slideDown();
    $(this).remove();
   });

   $('.goods-sort-by-list__item').on('click', function(){
    $('.goods-sort-by-list__item').removeClass('active');
    $(this).addClass('active');
    $('#filterForm [name="orderby"]').val($(this).data('sort'));
    $('#filterForm').submit();
   });

   $('.goods-search__open').on('click', function(){
    $('#searchInp').focus();
   });

   if(!$('.menu-modal .active').length && !$('.header-btm-left-menu .active').length){
    $('.header-btm-left-menu a').first().addClass('active');
   }

   $('body').on('click', '.removeWaitlist', function(e){
    e.preventDefault();
    var data = {
      action: 'kallective_remove_waitlist',
      good_id: $(this).data('id')
    };
    $(this).closest('li').remove();
    $.post( wc_add_to_cart_params.ajax_url, data, function( response ) {
      if(!$('.removeWaitlist').length) location.reload();
    });
  });
	
  $('body').on('click','.active.kampaign-modal-cancel, .actionBox-buttons button',function(){
	 if($(this).data('target') == 'login-panel') location.href = "/my-account/";
  });
  
}( jQuery ) );

function setVariationPrice(){
  var price = $('.woocommerce-variation-price bdi').last().text();
  if(price) $('.product-details__price').text(price);
}

function initAjaxPagination(){
  if(!$('.pagination-section').length) return false;

  appendPaginationLoader();

  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    var page = $(this).attr('href');
    $('.goods-grid').addClass('_processing');
    appendPaginationLoader();
    $.ajax({
      url: page
    }).done(function(responce) {
      $('.goods-grid').html($(responce).find('.goods-grid').html()).removeClass('_processing');
      $('.pagination-section').html($(responce).find('.pagination-section').html());
    });
  });

  $(document).on('click', '.pagination-section .btn-secondary-outline', function(){
    if($('a.page-numbers.active').length){
      $('a.page-numbers.active').parent().next().find('a').trigger('click');
    } else{
      $('a.page-numbers.next').trigger('click');
    } 
    
  });
}

function appendPaginationLoader() {
  $('.goods-grid').append('<i class="goods-grid__loader" />');
}

function parseUrl(url) {
  if(!url) url = location.href;
  var question = url.indexOf("?");
  var hash = url.indexOf("#");
  if(hash==-1 && question==-1) return {};
  if(hash==-1) hash = url.length;
  var query = question==-1 || hash==question+1 ? url.substring(hash) : 
  url.substring(question+1,hash);
  var result = {};
  query.split("&").forEach(function(part) {
    if(!part) return;
    part = part.split("+").join(" "); // replace every + with space, regexp-free version
    var eq = part.indexOf("=");
    var key = eq>-1 ? part.substr(0,eq) : part;
    var val = eq>-1 ? decodeURIComponent(part.substr(eq+1)) : "";
    var from = key.indexOf("[");
    if(from==-1) result[decodeURIComponent(key)] = val;
    else {
      var to = key.indexOf("]",from);
      var index = decodeURIComponent(key.substring(from+1,to));
      key = decodeURIComponent(key.substring(0,from));
      if(!result[key]) result[key] = [];
      if(!index) result[key].push(val);
      else result[key][index] = val;
    }
  });
  return result;
}