<?php
/*
Template Name: Static Form Page
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
    <div class="contact-section">
          <div class="contact-form-section request-form-section">
            <?php the_content();?>
          </div>
        </div>
</div>
<?php
get_footer();
