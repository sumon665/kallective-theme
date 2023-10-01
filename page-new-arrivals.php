<?php
/*
Template Name: New Arrivals
*/

get_header();
?>
    <div class="arrivals-content-section">
        <div class="wrapper">
            <div class="arrivals-content">
            <h1 class="arrivals-content__title"><?php echo __('New arrivals', 'kallective');?></h1>
            </div>
        </div>
    </div>
    <section class="goods-section">
        <div class="wrapper">
            <?php 
            $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
            $products = wc_get_products([
                'status' => 'publish',
                'paginate' => true,
                'page' => $paged,
                'limit' => 12,
                'meta_key'	=> 'new_arrivals',
                'meta_value'	=> 1,
            ]); 
            ?>
            <ul class="goods-grid">
            <?php foreach($products->products as $product):  
                $post_object = get_post($product->get_id());
                setup_postdata($GLOBALS['post'] =& $post_object);
                ?>
                <li class="goods-grid-item">
                    <?php get_template_part('template-parts/card', 'product'); ?>
                </li>
            <?php endforeach;
            wp_reset_postdata();
            ?>
            </ul>
            <?php if($products->max_num_pages > 1) : ?>
            <div class="pagination-section">
            <?php if($products->max_num_pages > $paged) : ?>
            <button type="button" class="btn-secondary-outline"><?php echo __('Load more items', 'kallective');?></button>
            <?php endif;?>
            <?php if (function_exists("kallective_paginate_links")) {
                echo kallective_paginate_links( [
                    'type' => 'list',
                    'current' => max( 1, $paged ),
                    'total'   => $products->max_num_pages,
                ] );
            } ?>
            </div>
            <?php endif;?>
        </div>
    </section>
<?php
get_footer();