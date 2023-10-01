<?php
/*
Template Name: How
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
        <p class="hiw-top"><?php echo __('Giveaways for those who give back.', 'kallective');?></p>
        <div class="hiw-header">
        <?php the_content();?>
        </div>
        <?php $how_items = get_field('how');?>
        <?php if($how_items):?>
        <ul class="hiw-content">
            <?php foreach($how_items as $h_item):?>
            <li class="hiw-content-item">
                <div class="hiw-content-item__icon">
                    <img src="<?php echo $h_item['icon']['url'];?>" width="100" height="100" alt="<?php echo $h_item['icon']['title'];?>">
                </div>
                <h2><?php echo $h_item['title'];?></h2>
                <p><?php echo $h_item['description'];?></p>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
</div>
<?php
get_footer();