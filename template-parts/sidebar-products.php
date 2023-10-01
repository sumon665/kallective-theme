<?php 
require get_template_directory() . '/inc/filter-definitions.php';
$current = $wp_query->get_queried_object();
$cat_filters = $filters_to_show[$current->name] ? $filters_to_show[$current->name] : [];
$categs = [$current->slug];
if(isset($_GET['categ'])){
	$categs = [];
	foreach($_GET['categ'] as $q){
		$term = get_term_by('name', $q, 'product_cat');
		if($term->slug){
			$categs[] = $term->slug;
		}
	}
}
$args = array(
    'category'  => $categs,
	'limit' => -1
);

$filters = [];
$prices = [
    'min' => '',
    'max' => '',
];
foreach( wc_get_products($args) as $product ){
    foreach( $product->get_attributes() as $attr_name => $attr ){
		if(empty($cat_filters) || in_array(wc_attribute_label( $attr_name ), $cat_filters) || $attr_name == 'pa_brand' || $attr_name == 'pa_color'){
			foreach( $attr->get_terms() as $term ){
				if($filters[$attr_name][$term->term_id]){
					$filters[$attr_name][$term->term_id]['cnt'] ++;
				} else{
					$filters[$attr_name][$term->term_id] = [
						'value' => $term->name,
						'cnt' => 1
					];
				}
				if(isset($_GET[$attr_name]) && in_array($term->name, $_GET[$attr_name])){
					$filters[$attr_name][$term->term_id]['checked'] = 'checked';
				}
			}
		}
    }
    if($product->is_type( 'variable' )){
        $min_price_for_display = $product->get_variation_price('min', true);
        $max_price_for_display = $product->get_variation_price('max', true);
        if(!$prices['min'] || $prices['min'] > $min_price_for_display) $prices['min'] = $min_price_for_display;
        if(!$prices['max'] || $prices['max'] < $max_price_for_display) $prices['max'] = $max_price_for_display;
    } else if($product->is_type( 'simple' )){
        $price = $product->get_regular_price();
        $sale = $product->get_sale_price();
        $cur_price = $sale > 0 ? $sale : $price;
        if(!$prices['min'] || $prices['min'] > $cur_price) $prices['min'] = $cur_price;
        if(!$prices['max'] || $prices['max'] < $cur_price) $prices['max'] = $cur_price;
    }
}
usort($filters['pa_size'], 'sort_sizes');
$prices['current_min'] = isset($_GET['price_min']) ? $_GET['price_min'] : $prices['min'];
$prices['current_max'] = isset($_GET['price_max']) ? $_GET['price_max'] : $prices['max'];
?>
<form class="filters-sidebar-modal" id="filterForm">
    <input type="hidden" name="orderby" id="" value="<?php echo isset($_GET['orderby']) ? $_GET['orderby'] : 'menu_order';?>">
    <input type="hidden" name="s" value="<?php echo get_search_query() ?>">
    <input type="hidden" name="post_type" value="product">
    <div class="filters-sidebar-modal-content">
        <div class="filters-sidebar-modal-content__header hidden-desktop">
            <button type="button" class="filters-sidebar-modal__reset" onclick="location.href = location.pathname;"><?php echo __('Reset', 'kallective');?></button>
            <?php echo __('Filters', 'kallective');?>
            <span class="filters-sidebar-modal__close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 6L18 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>                        
            </span>
        </div>
        <div class="filters-sidebar-modal-content__body">
            <div class="filters-sidebar">
            <?php $args = array(
                'taxonomy' => 'product_cat',
                'orderby' => 'name',
                'order' => 'ASC',
                'parent' => $current->term_id,
                'hide_empty'   => 0,
            ); ?>
            <?php $categories = get_categories($args); ?>
            <?php if(count($categories)):?>
            <div class="filters-sidebar-block">
                <div class="filters-sidebar-block__title <?php if(isset($_GET['categ'])) echo '_has-selected-items';?>"><span><?php echo __('Categories', 'kallective');?></span></div>
                <div class="filters-sidebar-block__body">
                <ul class="filters-sidebar-list">
                    
                    <?php foreach($categories as &$cat) : ?>
                    <li>
                        <a href="javascript:;" class="filters-sidebar-list__link">
                            <label class="control-checkbox">
                            <input type="checkbox" name="categ[]" value="<?php echo $cat->name;?>" 
                            <?php if(isset($_GET['categ']) && in_array($cat->name, $_GET['categ'])) echo 'checked';?>>
                            <i class="control-checkbox__icon">
                                <i class="_checked"></i>
                                <i class="_unchecked"></i>
                            </i>
                            <span class="control-checkbox__label">
                            <?php echo $cat->name;?> (<?php echo $cat->count;?>)
                            </span>
                            </label>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
                </div>
            </div>
            <?php endif;?>
            <?php if(isset($filters['pa_brand']) && count($filters['pa_brand'])):?>
            <div class="filters-sidebar-block collapsible-filter-block">
                <div class="filters-sidebar-block__title <?php if(isset($_GET['pa_brand'])) echo '_has-selected-items';?>"><span><?php echo __('Brands', 'kallective');?></span></div>
                <div class="filters-sidebar-block__body">
                <ul class="filters-sidebar-list">
                    <?php foreach($filters['pa_brand'] as $brand):?>
                    <li>
                    <a href="javascript:;" class="filters-sidebar-list__link">
                        <label class="control-checkbox">
                        <input type="checkbox" name="pa_brand[]" value="<?php echo $brand['value'];?>" <?php echo $brand['checked'];?>>
                        <i class="control-checkbox__icon">
                            <i class="_checked"></i>
                            <i class="_unchecked"></i>
                        </i>
                        <span class="control-checkbox__label">
                            <?php echo $brand['value'];?>(<?php echo $brand['cnt'];?>)
                        </span>
                        </label>
                    </a>
                    </li>
                    <?php endforeach;?>
                    <?php if(count($filters['pa_brand']) > 8):?>
                    <li>
                    <a href="" class="filters-sidebar-list__link _show-all">Show all</a>
                    </li>
                    <?php endif;?>
                </ul>
                </div>
            </div>
            <?php unset($filters['pa_brand']);?>
            <?php endif;?>
            <?php if($prices['min'] && $prices['max'] && $prices['min'] != $prices['max']):?>
            <div class="filters-sidebar-block collapsible-filter-block">
                <div class="filters-sidebar-block__title"><span><?php echo __('Price', 'kallective');?></span></div>
                <div class="filters-sidebar-block__body">
                <div class="filters-sidebar-price">
                    <div class="filters-sidebar-price__input">
                    <div class="control-input">
                        <input type="text" name="price_min" class="filters-sidebar-price__from" value="<?php echo $prices['current_min'];?>">
                    </div>
                    </div>
                    <p class="filters-sidebar-price__divider">—</p>
                    <div class="filters-sidebar-price__input">
                    <div class="control-input">
                        <input type="text" name="price_max" class="filters-sidebar-price__to" value="<?php echo $prices['current_max'];?>">
                    </div>
                    </div>
                    <div class="filters-sidebar-price__btn">
                    <button class="btn-secondary-outline filters-sidebar-price__apply">OK</button>
                    </div>
                </div>
                <div class="control-slider-range">
                    <input class="slider-range"  
                    data-min="<?php echo $prices['min'];?>" data-max="<?php echo $prices['max'];?>"
                    data-from="<?php echo $prices['current_min'];?>" data-to="<?php echo $prices['current_max'];?>">
                </div>
                </div>
            </div>
            <?php endif;?>
            <?php foreach($filters as $k => $values):?>
            <div class="filters-sidebar-block collapsible-filter-block">
                <div class="filters-sidebar-block__title <?php if(isset($_GET[$k])) echo '_has-selected-items';?>"><span><?php echo wc_attribute_label( $k );?></span></div>
                <div class="filters-sidebar-block__body">
                <ul class="filters-sidebar-list">
                    <?php $i = 1;?> 
                    <?php foreach($values as $v):?>
                    <li <?php if($i > 8 && $v['checked'] !== 'checked') echo 'style="display:none;"' ?>>
                    <a href="javascript:;" class="filters-sidebar-list__link">
                        <label class="control-checkbox">
                        <input type="checkbox" name="<?php echo $k;?>[]" value="<?php echo $v['value'];?>" <?php echo $v['checked'];?>>
                        <i class="control-checkbox__icon">
                            <i class="_checked"></i>
                            <i class="_unchecked"></i>
                        </i>
                        <span class="control-checkbox__label">
                            <?php 
                            $text_val = $v['value'];
                            if($v['value'] == 'Y') $text_val = "Yes";
                            if($v['value'] == 'N') $text_val = "No";
                            echo $text_val;
                            ?>
                        </span>
                        </label>
                    </a>
                    </li>
                    <?php $i ++;?>
                    <?php endforeach;?>
                    <?php if(count($values) > 8):?>
                    <li>
                    <a href="javascript:;" class="filters-sidebar-list__link _show-all"><?php echo __('Show all', 'kallective');?></a>
                    </li>
                    <?php endif;?>
                </ul>
                </div>
            </div>
            <?php endforeach;?>
            </div>
        </div>
        <div class="filters-sidebar-modal-content__footer hidden-desktop">
            <button type="button" class="btn-primary filters-sidebar-modal__apply"><?php echo __('Show items', 'kallective');?></button>
        </div>
    </div>                
</form>