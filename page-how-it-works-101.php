<?php
/*
Template Name: How it Works 101
*/

get_header();
?>
<div class="wrapper">
    <div class="breadcrumbs-section">
        <?php woocommerce_breadcrumb([
            'wrap_before' => '<ul class="breadcrumbs">',
            'before' => '<li class="breadcrumbs__item">',
            'wrap_after' => '</ul>',
            'after' => '</li>',
            'delimiter' => ''
        ]); ?>
    </div>
    <div class="hiw-section">
        <p class="hiw-top"><?php echo __('How it Works', 'kallective');?></p>
        <div class="hiw-header">
            <?php the_content();?>
        </div>
	</div>
    </div>
    <?php
    get_footer();