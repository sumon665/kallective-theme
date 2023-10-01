$(function () {
  // desktop menu
  var $menuModal = $('.menu-modal'),
  $menuModalContent = $('.menu-modal-content');
  $('.menu-toggle').on('mouseenter', function () {
    if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
      $menuModal.addClass('_visible-menu');
      $(this).addClass('_highlight');
    }
  }).on('mouseleave', function (e) {
    if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
      var toEl = e.relatedTarget|| e.toElement;
      if (toEl !== $menuModal[0]) {
        $menuModal.removeClass('_visible-menu');
        $(this).removeClass('_highlight');
      }
    }
  });
  $menuModalContent.on('mouseleave', function () {
    if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
      $menuModal.removeClass('_visible-menu');
      $('.menu-toggle').removeClass('_highlight');
    }
  });

  // mobile menu
  var activeLevel = 0, dataCategoryId = 0;
  function buildMobileMenuMarkup() {
    var $mobileMenuModal = $('<div class="mobile-menu-modal hidden-desktop"/>'),
      $mobileMenu = $('<div class="mobile-menu"/>'),
      $mobileMenuWrap = $('<div class="mobile-menu-wrap"/>'),
      $mobileMenuClose = $('<span class="mobile-menu-modal__close"/>');

    // level 1
    var _$menu = $('.header-btm-left-menu').clone();
    _$menu.find('.hidden-desktop').first().addClass('_divider');
    _$menu.children('li').each(function () {
      var $a = $(this).children('a');
      $a.attr('data-parent-name', $a.text());

      var $subMenu = $(this).children('.sub-menu');
      if ($subMenu.length) {
        $subMenu.remove();
      }
    });
    $mobileMenuWrap.append(getMobileMenuLevelMarkup(
      '<a href="/" class="mobile-menu-logo" />',
      {
        $content: _$menu.children()
      },
      0
    ));    

    // level 2 (categories labels)
    var $level2Content = '';
    $('.menu-category__title').each(function (index) { 
      $level2Content += '<li><span class="_has-submenu" data-category-id="' + getMenuIndex(index) + '" data-parent-name="Shop">' + $(this).text() + '</span></li>';  
    });
    $mobileMenuWrap.append(getMobileMenuLevelMarkup(
      '<span class="mobile-menu-step-back">Main menu</span>',
      {
        category: 'Shop',
        parentName: 'Shop',
        $content: $($level2Content)
      },
      1
    ));

    // level 3 (categories)
    $('.menu-category:not(._special)').each(function (index) {
      $mobileMenuWrap.append(getMobileMenuLevelMarkup(
        '<span class="mobile-menu-step-back">Shop</span>',
        {
          category: $(this).find('.menu-category__title').text(),
          $content: $(this).find('.menu-list').children().not(':last').clone(),
          categoryId: getMenuIndex(index),
          parentName: 'Shop', 
        },
        2
      ));
    });

    dataCategoryId++;

    // level 2 (simple submenu)
    $('.menu-item-has-children').each(function () { 
      $mobileMenuWrap.append(getMobileMenuLevelMarkup(
        '<span class="mobile-menu-step-back">Main menu</span>',
        {
          category: $(this).children('a').text(),
          $content: $(this).find('.sub-menu').children().clone(),
          parentName: $(this).children('a').text(),
        },
        1
      ));
      dataCategoryId++;
    });

    $mobileMenuClose.html('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 6L18 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> ')
    
    $mobileMenuWrap.append($mobileMenuClose);

    $mobileMenuModal.append($mobileMenu.append($mobileMenuWrap));

    $('body').append($mobileMenuModal);
  }

  function getMenuIndex(index) {
    return ('' + dataCategoryId) + index;
  }

  function getMobileMenuLevelMarkup(headerContent, body, level) {
    var $step = $('<div class="mobile-menu-step"/>').attr('data-level', level),
      $stepHeader = $('<div class="mobile-menu-step__header"/>'),
      $stepBody = $('<div class="mobile-menu-step__body"/>');

    var $body = body.$content.wrapAll('<ul class="mobile-menu-list" />').parent();

    $stepHeader.html(headerContent);
    $stepBody.html($body);

    if (body.categoryId !== undefined) {
      $step.attr('data-category-id', body.categoryId)
    }

    if (body.parentName !== undefined) {
      $step.attr('data-parent-name', body.parentName)
    }

    if (body.category) {
      $stepBody.prepend('<div class="mobile-menu-step-category">' + body.category + '</div>')
    }

    $step.append($stepHeader, $stepBody);

    return $step;
  }

  function goToNextStep($target) {
    activeLevel++;
    var $active = $('.mobile-menu-step._visible'),
    parentName = $target.attr('data-parent-name'),
    index = $target.attr('data-category-id'),
    $next;

    if (index !== undefined) {
      $next = $('.mobile-menu-step[data-category-id="' + index + '"][data-parent-name="' + parentName + '"]');
    } else {
      $next = $('.mobile-menu-step[data-parent-name="' + parentName + '"]:not([data-category-id])');
    }

    $active.addClass('_left').removeClass('_visible');
    $next.removeClass('_right').addClass('_visible');
  }

  function goToPrevStep() {
    activeLevel--;
    var $active = $('.mobile-menu-step._visible'),
    parentName = $active.attr('data-parent-name'),
    $prev;

    if (activeLevel === 0) {
      $prev = $('.mobile-menu-step[data-level="0"]');
    } else {
      $prev = $('.mobile-menu-step[data-level="' + activeLevel + '"][data-parent-name="' + parentName + '"]');
    }

    $active.addClass('_right').removeClass('_visible');
    $prev.removeClass('_left').addClass('_visible');
  }

  function bindMobileMenu() {
    $(document).on('click', '._has-submenu', function (e) {
      if (window.innerWidth >= DESKTOP_MIN_WIDTH) {
        return;
      }
      e.preventDefault();
      var $target = $(this);
      if ($(this).is('li')) {
        $target = $(this).children('a');
      }
      goToNextStep($target);
    });
    $(document).on('click', '.mobile-menu-step-back', goToPrevStep);
  }

  function highlightMenuLevels() {
    // clear highlight
    $('.mobile-menu-step', '.mobile-menu-modal').removeClass('_left _visible _right');
    $('._highlight', '.mobile-menu-modal').removeClass('_highlight');


    var $activeItem = $('a.active', '.mobile-menu-modal'),
      $activeItemParent = $activeItem.closest('.mobile-menu-step'), 
      categoryId = $activeItemParent.attr('data-category-id'),
      parentName = $activeItemParent.attr('data-parent-name');

    activeLevel = +$activeItemParent.attr('data-level');

    $activeItemParent.addClass('_visible');

    if (activeLevel === 2) {
      $('.mobile-menu-step[data-level="2"]:first').prevAll().addClass('_left');
      $('.mobile-menu-step[data-level="2"]').addClass('_right');
      $('.mobile-menu-step:not([data-parent-name="' + parentName + '"])').addClass('_right');
    } else {
      $activeItemParent.prevAll().addClass('_left');
      $activeItemParent.nextAll().addClass('_right');
      $('.mobile-menu-step:not([data-parent-name="' + parentName + '"]):not([data-level="0"])').addClass('_right').removeClass('_left');
    }

    if (categoryId !== undefined) {
      $('[data-category-id="' + categoryId + '"]', '.mobile-menu-modal').addClass('_highlight');
    }

    if (activeLevel !== 0) {
      $('[data-level="0"]').find('._has-submenu a[data-parent-name="' + $activeItemParent.attr('data-parent-name') + '"]', '.mobile-menu-modal').addClass('_highlight');
    }
  }

  buildMobileMenuMarkup();
  bindMobileMenu();  
  highlightMenuLevels();

  // mobile menu modal
  var isPerformingAnimation = false,
  $mobileMenuModal = $('.mobile-menu-modal');
  function openMobileMenuModal() {
    if (!isPerformingAnimation) {
      utils.lockBodyScroll();
      $('body').addClass('mobile-menu-opened');
      setTimeout(function () {
        $mobileMenuModal.addClass('_animate');
      }, 10);
    }
  };
  function closeMobileMenuModal() {
    if (!isPerformingAnimation) {
      isPerformingAnimation = true;
      utils.unlockBodyScroll();
      $mobileMenuModal.removeClass('_animate');
      setTimeout(function () {
        $('body').removeClass('mobile-menu-opened');   
        isPerformingAnimation  = false;
        highlightMenuLevels();
      }, 320);
    }
  };
  $('.header-btm-left-menu-toggle').on('click', openMobileMenuModal);
  $mobileMenuModal.on('click', function (e) {
    if (e.target === $mobileMenuModal[0]) {
      closeMobileMenuModal();
    }
  });
  $(document).on('click', '.mobile-menu-modal__close', closeMobileMenuModal);
  
});