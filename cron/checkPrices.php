<?php 
ini_set("max_execution_time", 300);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/../wp-blog-header.php';

$paged = get_option('prices_paged');

$products = wc_get_products([
    'limit' => 10000,
    'paginate' => true,
    'page' => $paged,
    'category' => array( 'technology' ),
]);
$paged ++;
if($products->max_num_pages <= $paged || $products->total == 0){
	$paged = 0;
}
update_option('prices_paged', $paged);
foreach($products->products as $product){
    $price = '';
    $price_wrong = false;
    if($product->is_type( 'simple' )){
        $price = $product->get_regular_price();
    } else if($product->is_type( 'variable' )){
        $price = $product->get_variation_price('min', true);
    }
    $categories = wp_get_post_terms($product->get_id(),'product_cat');
    foreach($categories as $cat){
        if($cat->name == 'Notebooks'){
            if($price < 300) $price_wrong = true;
        }
        if($cat->name == 'PCs/Workstations'){
            if($price < 300) $price_wrong = true;
        }
        if($cat->name == 'Tablets'){
            if($price < 200) $price_wrong = true;
        }
        if($cat->name == 'TVs'){
            if($price < 300) $price_wrong = true;
        }
    }
    if($price_wrong) {
        file_put_contents(__DIR__ . '/log.txt', "Price for product " . $product->get_name() . " is wrong!"  . PHP_EOL, FILE_APPEND);
        $product->set_status('draft');
        $product->save();
    }
}
