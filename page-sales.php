<?php
/*
Template Name: Sales
*/

get_header();
?>
<div class="sale-content-section">
    <div class="wrapper">
        <div class="sale-content">
        <h1 class="sale-content__title"><?php the_title();?></h1>
        <div class="sale-content__desc">
            <div class="sale-content-collapsible">
            <?php the_content();?>
            </div>
            <div class="sale-content-collapsible-btn visible-mobile">
            <b><?php echo esc_html__('<span>Show</span>&nbsp;more information', 'kallective'); ?></b>
            </div>
        </div>
        </div>
    </div>
</div>
<section class="goods-section">
    <div class="wrapper">
        <?php $paged = (get_query_var('page')) ? absint(get_query_var('page')) : 1;
          $products = wc_get_products([
            'post_status' => 'published',
            'paginate' => true,
            'page' => $paged,
            'limit' => 12,
            'nyp' => 'yes'
          ]); ?>
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
          <?php if ( $products->max_num_pages > 1 ) : ?>
          <div class="pagination-section">
            <button type="button" class="btn-secondary-outline"><?php echo __('Load more items', 'kallective');?></button>
            <?php if (function_exists("kallective_paginate_links")) {
                echo kallective_paginate_links( [
                    'type' => 'list',
                    'current' => max( 1, get_query_var( 'page' ) ),
                    'total'   => $products->max_num_pages,
                ] );
            } ?>
          </div>
         <?php endif;?>
    </div>
</section>
<?php
get_footer();