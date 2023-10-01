$(function () {
  // category filter start
  var  $categoryFilter = $('.goods-filters-categories'),
    $categoryFilterMenu = $categoryFilter.find('.goods-filters-categories__list'),
    $categoryFilterToggle = $categoryFilter.find('.goods-filters-categories__toggle');

  function closeCategoryFilter() {
    $categoryFilter.removeClass('_opened');
    $categoryFilterMenu.removeAttr('style');
  }

  $categoryFilterToggle.on('click', function () {
    if (window.innerWidth > DESKTOP_MIN_WIDTH) {
      return;
    }
    
    if ($categoryFilter.hasClass('_opened')) {      
      closeCategoryFilter();
    } else {
      $categoryFilter.addClass('_opened');
      var $menuItems = $categoryFilterMenu.find('li'),
        height = 0;
  
      $menuItems.each(function () {
        height += $(this).outerHeight(true);
      });
  
      $categoryFilterMenu.css('height', height); 
    }  
  });

  $categoryFilterMenu.find('a').on('click', function (e) {
    e.preventDefault();
    closeCategoryFilter();
    if($(this).hasClass('active')) {
      return;
    }
    
    $categoryFilterMenu.find('.active').removeClass('active');    
    $(this).addClass('active');
    $categoryFilterToggle.text($(this).text());
  });

  $(document).on('click', function(event) { 
    var $target = $(event.target);
    if(!$target.closest($categoryFilter).length) {
      closeCategoryFilter();
    }
  });
  // category filter end

  // search start
  var $search = $('.goods-search');
  function openSearch() {
    $search.addClass('_search-opened');
    setSearchMobileWidth();
  };
  function closeSearch() {
    $search.removeClass('_search-opened');
    setSearchMobileWidth();
  };
  function setSearchMobileWidth() {
    if (window.innerWidth < TABLET_MIN_WIDTH) {
      if ($search.hasClass('_search-opened')) {
        $search.find('.goods-search__inner').css('width', $('.goods-filters').outerWidth());
        return;
      }
    }
    $search.find('.goods-search__inner').removeAttr('style');
  }
  $(document).on('click', '.goods-search__open', openSearch);
  $(document).on('click', '.goods-search__close', closeSearch);

  $(window).on('load resize', setSearchMobileWidth);
  
  $(document).on('click', function(event) { 
    var $target = $(event.target);
    if(!$target.closest($search).length) {
      $('.goods-search__suggest').hide();
    }
  });

  $(document).on('input', '.goods-search__input input', function (e) {
    if (e.target.value && e.target.value.trim() !== '') {
      $search.addClass('_search-has-value');
    } else {
      $search.removeClass('_search-has-value');
    }
  });
  $(document).on('click', '.goods-search__clear', function () {
    $('.goods-search__input input').val('').focus().trigger('input');
  });
  // search end

  // sort by start
  function closeSortByDropdown() {
    $('.goods-sort-by__dd').removeClass('_opened');
  }
  $(document).on('click', '.goods-sort-by__btn', function () {
    $('.goods-sort-by__dd').toggleClass('_opened');
  });
  $(document).on('click', '.goods-sort-by__dd-header .modal-header__close, .goods-sort-by__dd-overlay',  closeSortByDropdown);
  $(document).on('click', function(event) { 
    if (window.innerWidth < TABLET_MIN_WIDTH) {
      return;
    }
    var $target = $(event.target);
    if(!$target.closest($('.goods-sort-by')).length) {
      closeSortByDropdown();
    }
  });
  // sort by end

  //special tiles slider start
  var $specialTilesSlider = $('.special-tiles-slider'),
    specialTilesSlick;

  if (!$specialTilesSlider.length) {
    return;
  }

  var specialTilesSlickSettings = {
    arrows: false,
    infinite: false,
    adaptiveHeight: true,
    mobileFirst: true,
    responsive: [
      {
        breakpoint: 1231,
        settings: 'unslick'
      }
    ]
  };

  function initSpecialTilesSlick() {
    return specialTilesSlick = $specialTilesSlider.slick(specialTilesSlickSettings);
  }

  specialTilesSlick = initSpecialTilesSlick();
      
  $(window).on('resize', function() {
    if (window.innerWidth < DESKTOP_MIN_WIDTH && !specialTilesSlick.hasClass('slick-initialized')) {
      initSpecialTilesSlick();
    }
  });
  //special tiles slider end
});