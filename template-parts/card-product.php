<?php global $product; 
    $fav_ids = get_field('favourites', get_current_user_id());
    $fav = array_diff(explode(";", $fav_ids), ['']);
    $product_type = WC_Product_Factory::get_product_type(get_the_ID()); 
?>
<div class="product-tile <?php if(in_array(get_the_ID(), $fav)) echo "_favorite";?>" data-id="<?php echo get_the_ID();?>">
    <a href="<?php echo get_permalink();?>" class="product-tile-top">
        <span class="product-tile__img">
            <?php echo $product->get_image('large');?>
        </span>
        <span class="product-tile-favorite toggleFav <?php if(!is_user_logged_in()) echo 'noAuth'; ?> " data-id="<?php echo get_the_ID();?>">
        <i class="product-tile-favorite__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.84 4.60987C20.3292 4.09888 19.7228 3.69352 19.0554 3.41696C18.3879 3.14039 17.6725 2.99805 16.95 2.99805C16.2275 2.99805 15.5121 3.14039 14.8446 3.41696C14.1772 3.69352 13.5708 4.09888 13.06 4.60987L12 5.66987L10.94 4.60987C9.9083 3.57818 8.50903 2.99858 7.05 2.99858C5.59096 2.99858 4.19169 3.57818 3.16 4.60987C2.1283 5.64156 1.54871 7.04084 1.54871 8.49987C1.54871 9.95891 2.1283 11.3582 3.16 12.3899L4.22 13.4499L12 21.2299L19.78 13.4499L20.84 12.3899C21.351 11.8791 21.7563 11.2727 22.0329 10.6052C22.3095 9.93777 22.4518 9.22236 22.4518 8.49987C22.4518 7.77738 22.3095 7.06198 22.0329 6.39452C21.7563 5.72706 21.351 5.12063 20.84 4.60987V4.60987Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>                      
        </i>
        <span class="product-tile-favorite__tooltip"><?php echo __('Add to favorites', 'kallective');?></span>
        </span>
    </a>
    <div class="product-tile-info">
        <div class="product-tile__category"><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?></div>
        <a href="<?php echo get_permalink();?>" class="product-tile__name"><?php the_title();?></a>
        <div class="product-tile__price">
        <?php kallective_product_price($product);?>
        </div>
        <div class="product-tile__add">
            <form action="<?php echo $product->get_permalink();?>">
                <button type="submit" class="btn-primary-outline cabinet-favorites-item__btns-cart">
                    <span class="btn-label"><?php echo __('Learn more', 'kallective');?></span>
                    <span class="icon icon-spinner"></span>
                </button>
            </form>
        </div>
    </div>
</div>