<?php global $wp_query;
?>
<div class="filters-selected visible-desktop">            
    <p class="filters-selected__label"><?php echo $wp_query->found_posts;?> <?php echo __('Items choosen', 'kallective');?></p>
    <ul class="filters-selected-list">
        <li class="filters-selected__clear btn-secondary-outline" onclick="location.href = location.pathname;">
        <span><?php echo __('Clear filters', 'kallective');?></span>
        </li>
        <?php foreach($_GET as $k=>$v):?>
            <?php if(is_array($v)):?>
            <?php foreach($v as $value):?>
                <li class="filters-selected-item">
                <?php echo $value;?><i class="icon icon-cross cancelFilter" data-key="<?php echo $k;?>" data-value="<?php echo $value;?>"></i>
                </li>
            <?php endforeach;?>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
</div>