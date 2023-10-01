jQuery( function( $ ) {

    $(".single_add_to_cart_button").addClass("ajax_add_to_cart");

    $( ".post-type-archive-product" ).on( "click", ".quantity input", function() {
        return false;
    });

    $( ".archive" ).on( "change input", ".quantity .qty", function() {
        var add_to_cart_button = $( this ).parents( ".product" ).find( ".add_to_cart_button" );
        // For AJAX add-to-cart actions
        add_to_cart_button.data( "quantity", $( this ).val() );
        // For non-AJAX add-to-cart actions
        add_to_cart_button.attr( "href", "?add-to-cart=" + add_to_cart_button.attr( "data-product_id" ) + "&quantity=" + $( this ).val() );
    });

    $(".input-text.qty.text").bind('keyup mouseup', function () {
        var value = $(this).val();
        $(".product_quantity").val(value)
    });

    if ( typeof wc_add_to_cart_params === 'undefined' )
        return false;

    $( document ).on( 'click', '.ajax_add_to_cart', function(e) {
        e.preventDefault();
        var $thisbutton = $(this);          
        var $variation_form = $( this ).closest( '.variations_form' );
        var var_id = $variation_form.find( 'input[name=variation_id]' ).val();
        $( '.ajaxerrors' ).remove();
        var item = {},
            check = true;
            variations = $variation_form.find( 'select[name^=attribute]' );
            if ( !variations.length) {
                variations = $variation_form.find( '[name^=attribute]:checked' );
            }
            if ( !variations.length) {
                variations = $variation_form.find( 'input[name^=attribute]' );
            }
        variations.each( function() {
            var $this = $( this ),
                attributeName = $this.attr( 'name' ),
                attributevalue = $this.val(),
                index,
                attributeTaxName;
                $this.removeClass( 'error' );
            if ( attributevalue.length === 0 ) {
                index = attributeName.lastIndexOf( '_' );
                attributeTaxName = attributeName.substring( index + 1 );
                $this
                    .addClass( 'required error' )
                    .before( '<div class="ajaxerrors"><p>Please select ' + attributeTaxName + '</p></div>' )
                check = false;
            } else {
                item[attributeName] = attributevalue;
            }
        } );
        if ( !check ) {
            return false;
        }

        if ( $thisbutton.is( '.ajax_add_to_cart' ) ) {
            $thisbutton.removeClass( 'added' );
            $thisbutton.addClass( '_loading' );
            var data;
            if ($( this ).parents(".variations_form")[0]){
                var product_id = $variation_form.find('input[name=product_id]').val();
                var quantity = $variation_form.find( 'input[name=quantity]' ).val();
                data = {
                    action: 'bodycommerce_ajax_add_to_cart_woo',
                    product_id: product_id,
                    quantity: quantity,
                    variation_id: var_id,
                    variation: item
                };
            } else {
                var product_id = $(this).parent().find(".product_id").val();
                var quantity = $(this).parent().find(".qty").val();
                data = {
                    action: 'bodycommerce_ajax_add_to_cart_woo_single',
                    product_id: product_id,
                    quantity: quantity
                };
            }
            if($('.nyp-input').length){
                $('.nyp').trigger( 'wc-nyp-update');
                if($('.nyp').hasClass('nyp-error')){
                    $thisbutton.removeClass( '_loading' );
                    return false;
                }
                data['nyp'] = $(this).closest('form').find("[name=nyp]").val();
                data['update-price'] = $(this).closest('form').find("[name=update_price]").val();
                data['_nypnonce'] = $(this).closest('form').find("[name=_nypnonce]").val();
                console.log(data);
            }
            
            $( 'body' ).trigger( 'adding_to_cart', [ $thisbutton, data ] );
            $.post( wc_add_to_cart_params.ajax_url, data, function( response ) {
                
                if ( ! response )
                    return;
                if(response) {
                    try {
                        response = JSON.parse(response);
                    } catch(e) {
                        //
                    }
                }
                var this_page = window.location.toString();
                this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );
                if ( response.error && response.product_url ) {
                    window.location = response.product_url;
                    return;
                }
                if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
                    window.location = wc_add_to_cart_params.cart_url;
                    return;
                } else {
                    $thisbutton.removeClass( '_loading' );
                    var fragments = response.fragments;
                    var cart_hash = response.cart_hash;
                    if ( fragments ) {
                        $.each( fragments, function( key ) {
                            $( key ).addClass( 'updating' );
                        });
                    }
                    $thisbutton.addClass( 'added' );
                    if ( fragments ) {
                        $.each( fragments, function( key, value ) {
                            $( key ).replaceWith( value );
                        });
                    }
                    /*$( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();
                    $( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) &gt; *', function() {
                    $( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();
                    $( document.body ).trigger( 'cart_page_refreshed' );
                    });
                    $( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) &gt; *', function() {
                        $( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
                    });*/
                }
            });
            return false;
        } else {
            return true;
        }
    });

    $('body').on('change ', '.woocommerce-mini-cart-item input', function(){
        var qty = $(this).val();
        var item = $(this).closest('.woocommerce-mini-cart-item');
        updateQty($(this).data('key'), qty, item);
    });

    $('.woocommerce-cart').on('change', 'input.qty', function(){
		setTimeout(function(){
            $("[name='update_cart']").trigger("click");
        }, 100);
	});

    function updateQty(key,qty, item){
        item.addClass('_processing');
        if($('body').hasClass('woocommerce-cart')){
            $('#quantity_' + key).val(qty).change();
        } else {
            url = wc_cart_fragments_params.ajax_url;
            data = {
                "cart_item_key":key,
                "cart_item_qty":qty,
                'action': 'update_cart_quantity'
            };
            
            jQuery.post( url, data ) .done(function( response ) {
                response = JSON.parse(response);
                item.find('.mini-cart_validation').remove();
                if(response.result == 'error'){
                    item.removeClass('_processing').addClass('_invalid');
                    item.append('<p class="mini-cart_validation">' + response.message + '</p>');
                    item.find('input').val(response.qty);
                } else {
                    updateCartFragment();
                }
                
            });
        }
    }
        
    function updateCartFragment() {
        $fragment_refresh = {
            url: woocommerce_params.ajax_url,
            type: 'POST',
            data: { action: 'woocommerce_get_refreshed_fragments' },
            success: function( data ) {
                if ( data && data.fragments ) {          
                    jQuery.each( data.fragments, function( key, value ) {
                        jQuery(key).replaceWith(value);
                    });
                    sessionStorage.setItem( "wc_fragments", JSON.stringify( data.fragments ) );
                    sessionStorage.setItem( "wc_cart_hash", data.cart_hash );               
                    jQuery('body').trigger( 'wc_fragments_refreshed' );
                }
            }
        };
        jQuery.ajax( $fragment_refresh );  
    }
});