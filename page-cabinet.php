<?php
/*
Template Name: Cabinet
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
    <?php the_content(); ?>
    <?php if(is_user_logged_in()): ?>
    <?php get_template_part( 'template-parts/section', 'related', ['type' => 'visited'] ); ?>
    <?php endif;?>
    </div>
<?php
get_footer();