<?php 
if($args['type'] == 'visited'){
    $visited = explode(";", get_field('visited_products', get_current_user_id()));
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    foreach($items as $item){
        $id = $item['product_id'];
        $k = array_search($id, $visited);
        if($k !== false){
            unset($visited[$k]);
        }
    }
    $heading = 'Continue Shopping';
    $related = wc_get_products(['include' => $visited, 'limit' => '30', 'orderby' => 'rand']);
} else {
    $heading = 'Related Products';
    $related = wc_get_products(['featured'=>true]);
}
?>
<?php if(count($related) > 2):?>
<div class="related-products-section">
    <h4 class="related-products-section__title"><?php echo $heading;?></h4>
    <div class="related-products">
    <?php foreach($related as $featured_product):  
        $post_object = get_post($featured_product->get_id());
        setup_postdata($GLOBALS['post'] =& $post_object);
        ?>
        <div class="related-products__item">
            <?php get_template_part('template-parts/card', 'product'); ?>
        </div>
    <?php endforeach;
    wp_reset_postdata();
    ?>
    </div>
</div>
<?php endif;?>