<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kallective
 */

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
<section class="privacy-terms-section">
	<?php the_content(); ?>
</section>