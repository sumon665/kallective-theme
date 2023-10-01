<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
global $wp_query;
$current = $wp_query->get_queried_object();
get_header( 'shop' );
?>
<div class="wrapper">
<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action( 'woocommerce_before_main_content' );

?>
	<div class="breadcrumbs-section">
		<?php woocommerce_breadcrumb([
			'wrap_before' => '<ul class="breadcrumbs">',
			'before' => '<li class="breadcrumbs__item">',
			'wrap_after' => '</ul>',
			'after' => '</li>',
			'delimiter' => ''
		]); ?>
	</div>
</div>
<section class="goods-section">
	<div class="wrapper">
		<h1 class="goods-section__title">
		<?php 
			if(is_search()) {
				echo "Search results for '" . get_search_query() . "'";
			} else {
				echo $current->name;
			}
		?>
		</h1>
		<?php $children = get_term_children( $current->term_id, 'product_cat' ); ?>
		<?php if(!count($children)) {
			get_template_part('template-parts/searchbar', 'products'); 
			if(isset($_GET) && !empty($_GET) && !is_search()){
				get_template_part('template-parts/filterbar', 'products');
			}
		}?>
		<div class="goods-content <?php if(count($children)) echo '_only-categories-filter';?>">
			<?php if(count($children)) get_template_part('template-parts/searchbar', 'products'); ?>
            <div class="goods-content__filters">
			  <?php if(count($children) || !$current->term_id) : ?>
			  <form class="filters-sidebar-modal" id="filterForm">
    			<input type="hidden" name="orderby" id="" value="<?php echo isset($_GET['orderby']) ? $_GET['orderby'] : 'menu_order';?>">
				<input type="hidden" name="s" value="<?php echo get_search_query() ?>">
				<input type="hidden" name="post_type" value="product">
			  </form>
              <div class="filters-sidebar-sticky">
                <div class="filters-sidebar-block">
                  <div class="filters-sidebar-block__title"><span><?php echo __( 'Categories', 'woocommerce' );?></span></div>
                  <div class="filters-sidebar-block__body">
                    <ul class="filters-sidebar-list">
					  <?php $args = array(
						'taxonomy' => 'product_cat',
						'orderby' => 'name',
						'order' => 'ASC',
						'parent' => $current->term_id ? $current->term_id : 0,
						'hide_empty'   => 0,
						);
					  $categories = get_categories($args); ?>
					  <?php foreach($categories as $cat) : ?>
						<?php if(get_field('hidden', $cat)) continue; ?>
						<?php $query = new WP_Query( array(
							'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'id',
									'terms' => $cat->cat_ID,
								),
							),
							'nopaging' => true,
							'fields' => 'ids',
							) );
						if($query->post_count > 0):?>
						<li><a href="<?php echo get_category_link($cat->cat_ID);?>" class="filters-sidebar-list__link"><?php echo $cat->name;?> (<?php echo $query->post_count;?>)</a></li>
						<?php endif;?>
					  <?php endforeach;?>
                    </ul>
                  </div>
                </div>
			  </div>
			  <?php else: ?>
			  <?php get_template_part( 'template-parts/sidebar', 'products', [] );?>
			  <?php endif; ?>
            </div>
			<div class="goods-content__grid">
			<?php
			if ( woocommerce_product_loop() ) {
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				echo '<ul class="goods-grid">';

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action( 'woocommerce_shop_loop' );
						echo '<li class="goods-grid-item">';
						get_template_part('template-parts/card', 'product');
						echo '</li>';
					}
				}

				echo "</ul>";

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			} else { ?>
				<div class="goods-content__grid-empty">
					<h3><?php echo __( 'There are no items found', 'woocommerce' );?></h3>
					<p> <?php echo __( 'Unfortunately, there are no products in our catalog that match the selected filters.', 'woocommerce' );?><br/>
					Try to change or <span onclick="location.href = location.pathname;">clear the filters</span>, and you will definitely find products.</p>
				<div>
      		<?php }
			/**
			 * Hook: woocommerce_after_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
			?>
			</div>
		</div>
	</div>
</section>
<?php
get_footer( 'shop' );
