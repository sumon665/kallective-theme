( function( $ ) {
    $('#searchInp').on('input keyup', function(){
        var term = $(this).val();
        if(!term) {
            $('.goods-search').removeClass('_search-has-value');
            $('.goods-search__suggest').slideUp();
        }
        if(term.length < 3) return false;
        $.ajax({
            url : wc_add_to_cart_params.ajax_url, 
            type: 'POST', 
            data: {
                'action' : 'kallective_ajax_search', 
                'term' : term
            },
            beforeSend: function() { 
            },
            success: function(result) { 
                if(result){
                    $('.goods-search-suggest li').html(result);
                    $('.goods-search__suggest').slideDown();
                }
            }
        });
    });

    $('.filters-sidebar-list__link input').on('change', function(){
        $('[name="price_min"], [name="price_max"]').each(function(){
            if($(this).val() == $(this).data('default')) $(this).remove();
        });
        $('#filterForm').submit();
    });

    $('.goods-search').on('submit', function(e){
        if($('.filters-sidebar').length){
            e.preventDefault();
            $('#filterForm').find('[name="s"]').val($('#searchInp').val());
            $('#filterForm').submit();
        }
    });


    $('.cancelFilter').on('click', function(){
        var value = $(this).data('value');
        $('.filters-sidebar-list__link input[value="' + value + '"]').click();
    });
}( jQuery ) );