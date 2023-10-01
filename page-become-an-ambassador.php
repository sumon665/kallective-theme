<?php
/*
Template Name: Become an Ambassador
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
    <div class="ambassador-section">
        <h1 class="ambassador-section__title"><?php the_title();?></h1>
        <div class="ambassador-content">
        <div class="ambassador-content__txt">
            <?php the_content();?>
            <ul class="ambassador-share">
            <li>
                <a href="https://www.facebook.com/sharer.php?u=<?php echo get_the_permalink();?>" class="_facebook-share" target="_blank">Share via Facebook</a>
            </li>
            <li>
                <a href="https://twitter.com/share?url=<?php echo get_the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>" class="_twitter-share" target="_blank">Share via Twitter</a>
            </li>
            </ul>
        </div>
        <div class="ambassador-content__img">
            <img src="<?php echo get_template_directory_uri();?>/img/icons/logo-symbol.svg" width="352" height="352" alt="The Kallective">
        </div>
        </div>
    </div>
</div>
<?php
get_footer();