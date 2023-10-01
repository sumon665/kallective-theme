<?php
/*
Template Name: Event Process
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
        <?php $how_items = get_field('event_process');?>
        <?php if($how_items):?>
            <div class="hiw-content">
                <?php foreach($how_items as $h_item):?>
                    <div class="hiw-content-item" style="flex: auto;">
                        <h2><?php echo $h_item['title'];?></h2>
                        <br>
                        <p><?php echo $h_item['description'];?></p>
                        <br></br>
                        <div class="hiw-content-item__image" style="text-align: center;">
                            <img src="<?php echo $h_item['image']['url'];?>" width="350" height="450" alt="<?php echo $h_item['image']['title'];?>"/>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
    <?php
    get_footer();