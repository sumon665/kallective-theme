// @prepros-prepend common.js
// @prepros-prepend jquery.validate.min.js
// @prepros-prepend related-products-slider.js
// @prepros-prepend select2.min.js
// @prepros-prepend fotorama.4.6.4.js
// @prepros-prepend jquery.zoom.min.js

$.validator.addMethod(
  'customemail',
  function(value, element) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      value
    );
  },
  'Incorrect email'
);

$(function () {
  // tabs start
  var  $tabsHeaderWrap = $('.tabs-header'),
    $tabsMenu = $tabsHeaderWrap.find('.tabs-header-list'),
    $tabsToggle = $tabsHeaderWrap.find('.tabs-header__toggle');

  $('.tabs-header-list__item').click(function() {
    closeTabsMenu();
    if ($(this).hasClass('active')) {
      return;
    }

    var id = $(this).attr('data-tab'),
        $content = $('.tabs-content__item[data-tab="'+ id +'"]');
    
    $('.tabs-header-list__item.active').removeClass('active');
    $(this).addClass('active');
    
    $('.tabs-content__item.active').removeClass('active');
    $content.addClass('active');

    $tabsToggle.text($(this).text());
  });

  function closeTabsMenu() {
    $tabsHeaderWrap.removeClass('_opened');
    $tabsMenu.removeAttr('style');
  }

  $tabsToggle.on('click', function () {
    if (window.innerWidth >= TABLET_MIN_WIDTH) {
      return;
    }
    
    if ($tabsHeaderWrap.hasClass('_opened')) {      
      closeTabsMenu();
    } else {
      $tabsHeaderWrap.addClass('_opened');
      var $menuItems = $tabsMenu.find('li'),
        height = 0;
  
      $menuItems.each(function () {
        height += $(this).outerHeight(true);
      });
  
      $tabsMenu.css('height', height); 
    }  
  });

  $(document).on('click', function(event) { 
    if (window.innerWidth >= TABLET_MIN_WIDTH) {
      return;
    }
    var $target = $(event.target);
    if(!$target.closest($tabsHeaderWrap).length) {
      closeTabsMenu();
    }
  });
  // tabs end  

  // review form start
  var $reviewForm = $('#product-review-form'), $reviewFormBtn = $('#product-review-form-submit'), validator;
  
  validator = $reviewForm.validate({
    rules: {
      rating: 'required',
      review: 'required',
    },
    errorPlacement: function(error, element) {
      $(element).closest('[class*="control-"').append(error);
    },
    submitHandler: function(form, e) {
      e.preventDefault();
      utils.disableFormBtn($reviewFormBtn);

      var data = $(form).serializeArray();

      data.push({
        name: 'action',
        value: actionsMap.add_review
      });

      $.post(ajax.url, data)
        .done(function() {
          utils.closeModal($reviewForm.closest('.modal'));
          resetRefiewForm();
        })
        .fail(function(error) {
          alert(error)
        }).always(function () {
          utils.enableFormBtn($reviewFormBtn);
        });
    }
  });

  function resetRefiewForm() {
    $reviewForm[0].reset();
    validator.resetForm();
  }

  $(document).on('modal.closed', function (e) {
    if (e.message === 'review-modal') {
      resetRefiewForm();
    }
  });
  // review form end

  // custom select start
  $('.control-select select:not(.selectInit)').select2({
    minimumResultsForSearch: -1,
    width: '100%'
  });
  // custom select end

  // gallery start
  // $('.product-gallery-preview-slider').slick({
  //   slidesToShow: 1,
  //   slidesToScroll: 1,
  //   arrows: false,
  //   fade: true,
  //   asNavFor: '.product-gallery-nav-slider'
  // });
  // $('.product-gallery-nav-slider').slick({
  //   asNavFor: '.product-gallery-preview-slider',
  //   arrows: false,
  //   focusOnSelect: true,
  //   variableWidth: true,
  //   slidesToScroll: 4,
  //   slidesToShow: 4,
  //   responsive: [
  //     {
  //       breakpoint: 1232,
  //       settings: {
  //         slidesToScroll: 7,
  //         slidesToShow: 7,
  //       }
  //     },
  //     {
  //       breakpoint: 1104,
  //       settings: {
  //         slidesToScroll: 6,
  //         slidesToShow: 6,
  //       }
  //     },
  //     {
  //       breakpoint: 992,
  //       settings: {
  //         slidesToScroll: 5,
  //         slidesToShow: 5,
  //       }
  //     },
  //     {
  //       breakpoint: 880,
  //       settings: {
  //         slidesToScroll: 4,
  //         slidesToShow: 4,
  //       }
  //     },
  //     {
  //       breakpoint: 768,
  //       settings: {
  //         slidesToScroll: 7,
  //         slidesToShow: 7,
  //       }
  //     },
  //     {
  //       breakpoint: 640,
  //       settings: {
  //         slidesToScroll: 6,
  //         slidesToShow: 6,
  //       }
  //     },
  //     {
  //       breakpoint: 560,
  //       settings: {
  //         slidesToScroll: 5,
  //         slidesToShow: 5,
  //       }
  //     },
  //     {
  //       breakpoint: 480,
  //       settings: {
  //         slidesToScroll: 4,
  //         slidesToShow: 4,
  //       }
  //     },
  //     {
  //       breakpoint: 400,
  //       settings: {
  //         slidesToScroll: 3,
  //         slidesToShow: 3,
  //       }
  //     },
  //     {
  //       breakpoint: 320,
  //       settings: {
  //         slidesToScroll: 2,
  //         slidesToShow: 2,
  //       }
  //     },
  //   ]
  // });
  function initImageZoom() {
    if(window.innerWidth <= TABLET_MIN_WIDTH) return;
    $('.fotorama__stage__frame').each(function () {
      var $img = $(this).find('img');
      if ($img.length === 1 && !$(this).hasClass('_zoom-loaded')) {
        $(this).addClass('_zoom-loaded').zoom();
      }
    });
  }
  var $fotoramaDiv = $('.product-gallery').fotorama({
    arrows: false,
    width: '100%',
    maxheight: 560,
    shadows: false,
    nav: false,
    thumbmargin: 8,
    thumbborderwidth: 1,
    click: false,
    navwidth: '100%',
    transition:  'crossfade'
  })
  .on('fotorama:load', function () {
    initImageZoom();
  });
  var fotorama = $fotoramaDiv.data('fotorama');
  function setFotoramaThumbsSize() {
    var options = fotorama.options;
    if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
      if(options.thumbwidth !== 128) {
        fotorama.setOptions({
          thumbwidth: 128,
          thumbheight: 128,
        });
      }
    } else if (window.innerWidth >= TABLET_MIN_WIDTH && window.innerWidth < DESKTOP_MIN_WIDTH) {
      if(options.thumbwidth !== 104) {
        fotorama.setOptions({
          thumbwidth: 104,
          thumbheight: 104,
        });
      }
    } else if (window.innerWidth < TABLET_MIN_WIDTH) {
      if(options.thumbwidth !== 72) {
        fotorama.setOptions({
          thumbwidth: 72,
          thumbheight: 72,
        });
      }
    }
  }
  setFotoramaThumbsSize();
  fotorama.setOptions({
    nav: 'thumbs'
  });
  $(window).on('resize', setFotoramaThumbsSize);
  // gallery end

  // size guide start
  var  $sizeGuideHeaderWrap = $('.size-guide-content-header'),
    $sizeGuideMenu = $sizeGuideHeaderWrap.find('.size-guide-content-header-menu'),
    $sizeGuideToggle = $sizeGuideHeaderWrap.find('.size-guide-content-header__toggle');

  $('.size-guide-content-header-menu__item').click(function() {
    closeSizeGuideMenu();
    if ($(this).hasClass('active') || window.innerWidth >= DESKTOP_MIN_WIDTH) {
      return;
    }

    var id = $(this).attr('data-menu'),
        $content = $('.size-guide-content-body__item[data-menu="'+ id +'"]');
    
    $('.size-guide-content-header-menu__item.active').removeClass('active');
    $(this).addClass('active');
    
    $('.size-guide-content-body__item.active').removeClass('active');
    $content.addClass('active');

    $sizeGuideToggle.text($(this).text());
  });

  function closeSizeGuideMenu() {
    $sizeGuideHeaderWrap.removeClass('_opened');
    $sizeGuideMenu.removeAttr('style');
  }

  $sizeGuideToggle.on('click', function () {
    if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
      return;
    }
    
    if ($sizeGuideHeaderWrap.hasClass('_opened')) {      
      closeSizeGuideMenu();
    } else {
      $sizeGuideHeaderWrap.addClass('_opened');
      var $menuItems = $sizeGuideMenu.find('.size-guide-content-header-menu__item'),
        height = 0;
  
      $menuItems.each(function () {
        height += $(this).outerHeight(true);
      });
  
      $sizeGuideMenu.css('height', height); 
    }  
  });

  $(document).on('click', function(event) { 
    if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
      return;
    }
    var $target = $(event.target);
    if(!$target.closest($sizeGuideHeaderWrap).length) {
      closeSizeGuideMenu();
    }
  });
  // size guide end

  // additional info table start
  var $additionalInfoTable = $('.woocommerce-product-attributes'),
    $additionalInfoTableWrap = $('.woocommerce-product-attributes-wrap'),
    isAdditionalInfoTableCropped;
  function toggleCroppedClass(isFirstCall) {
    if ($additionalInfoTableWrap.hasClass('_visible')) {
      return;
    }
    if ($additionalInfoTable.height() > $additionalInfoTableWrap.height()) {
      $additionalInfoTableWrap.addClass('_cropped');
      if (isFirstCall === true) {
        isAdditionalInfoTableCropped = true;
      }
    } else {
      $additionalInfoTableWrap.removeClass('_cropped');
    }
  }
  toggleCroppedClass(true);
  $(window).on('resize', toggleCroppedClass);
  $(document).on('click', '.woocommerce-product-attributes-toggle__btn', function() {
    $additionalInfoTableWrap.toggleClass('_visible');
    $(this).find('span').text(isAdditionalInfoTableCropped ? 'less' : 'more');
    isAdditionalInfoTableCropped = !isAdditionalInfoTableCropped;
  });
  // additional info table end
});