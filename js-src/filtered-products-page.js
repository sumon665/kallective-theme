// @prepros-prepend common.js
// @prepros-prepend goods-grid.js
// @prepros-prepend ion.rangeSlider.min.js

$(function () {
  // collapsible filter block start
  $(document).on('click', '.collapsible-filter-block .filters-sidebar-block__title', function () {
    $(this)
      .toggleClass('_collapsed')
      .next('.filters-sidebar-block__body').stop(true, true)
      .slideToggle(300);
  });
  // collapsible filter block end

  $('.slider-range').each(function () {
    $(this).ionRangeSlider({
      type: 'double',
      min: $(this).attr('data-min'),
      max: $(this).attr('data-max'),
      hide_from_to: true,
      hide_min_max: true,
      onChange: function (data) {
        $('.filters-sidebar-price__from').val(data.from).trigger('change');
        $('.filters-sidebar-price__to').val(data.to).trigger('change');
      }
    });
  });

  // filters sidebar modal
  var isPerformingAnimation = false,
  $filtersSidebarModal = $('.filters-sidebar-modal');
  function openFiltersSidebarModal() {
    if (!isPerformingAnimation) {
      utils.lockBodyScroll();
      $('body').addClass('filters-sidebar-opened');
      setTimeout(function () {
        $filtersSidebarModal.addClass('_animate');
      }, 10);
    }
  };
  function closeFiltersSidebarModal() {
    if (!isPerformingAnimation) {
      isPerformingAnimation = true;
      utils.unlockBodyScroll();
      $filtersSidebarModal.removeClass('_animate');
      setTimeout(function () {
        $('body').removeClass('filters-sidebar-opened');   
        isPerformingAnimation  = false;
      }, 320);
    }
  };
  $('.open-filters-sidebar').on('click', openFiltersSidebarModal);
  $filtersSidebarModal.on('click', function (e) {
    if (e.target === $filtersSidebarModal[0]) {
      closeFiltersSidebarModal();
    }
  });
  $(document).on('click', '.filters-sidebar-modal__close', closeFiltersSidebarModal);
});