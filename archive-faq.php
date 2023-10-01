<?php
get_header();
$categories = get_categories( [
    'taxonomy'     => 'category',
    'type'         => 'faq',
    'child_of'     => 0,
    'parent'       => '',
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => 1,
    'hierarchical' => 1,
    'exclude'      => '',
    'include'      => '',
    'number'       => 0,
    'pad_counts'   => false,
] );
$active = []; 
if(isset($_GET['category']))
    foreach($categories as $c){
        if($c->term_id == $_GET['category']) $active = $c;
    }
?>
<div class="wrapper">
    <div class="breadcrumbs-section">
        <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
            <a href="/" class="breadcrumbs__link"><?php echo __('Main page', 'kallective');?></a>
        </li>
        <li class="breadcrumbs__item">
            <span class="breadcrumbs__current"><?php echo __('FAQ’s', 'kallective');?></span>
        </li>
        </ul>
    </div>
    <div class="faq-layout">
        <div class="faq-layout__menu">
        <div class="faq-subtitle">
            <?php echo __('FAQ’s', 'kallective');?>
        </div>  
        <div class="faq-nav-wrap">
            <div class="faq-nav">
                <div class="faq-nav__toggle hidden-desktop"><?php echo $active ? $active->name : __('FAQ Topics', 'kallective');?></div>
                <ul class="faq-nav__list">
                    <?php foreach($categories as $cat): ?>
                    <?php if($cat->slug == 'products-faqs') continue; ?>
                    <li>
                    <a href="?category=<?php echo $cat->term_id;?>" class="<?php if($active->slug == $cat->slug) echo "active";?>">
                        <?php echo get_field('cat_image', 'category_' . $cat->term_id);?>                                        
                        <?php echo $cat->name;?>
                    </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>          
        </div>
        <div class="faq-layout__content">
        <?php if($active): ?>
        <h1 class="faq-layout__content-title visible-desktop"><?php echo $active->name;?></h1>
        <?php else: ?>
        <h1 class="faq-layout__content-title visible-desktop"><?php echo __('FAQ’s', 'kallective');?></h1>
        <?php endif;?>
        <div class="faq-page-accordion-list">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) :
				the_post(); ?>
                <div class="faq-accordion accordion-item">
                    <div class="faq-accordion__header accordion-item__header"><?php the_title();?></div>
                    <div class="faq-accordion__body accordion-item__body">
                        <?php the_content();?>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php endif;?>
        </div>
        <!-- 
        <div>
            <button class="btn-secondary-outline load-more-answers">Load more answers</button>
        </div>
         -->
        </div>
    </div>
</div>
<?php
get_footer();