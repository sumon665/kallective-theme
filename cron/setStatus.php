<?php 
ini_set("max_execution_time", 300);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/../wp-blog-header.php';

$paged = get_option('statuses_paged');

$products = wc_get_products([
    'limit' => 100,
    'paginate' => true,
    'page' => $paged,
    'status' => 'draft',
]);
$paged ++;
if($products->max_num_pages <= $paged || $products->total == 0){
	$paged = 0;
}
update_option('statuses_paged', $paged);
foreach($products->products as $product){
    $thumb = get_post_thumbnail_id( $product->get_id( ) );
    $img = wp_get_attachment_image_url($thumb); 
    $name = $product->get_name();
    $name = str_replace(['_', "-"], "", $name);
    if($img){
        $price = '';
    	$product->set_name($name);
        $product->set_status('publish');
        if($product->is_type( 'simple' )){
            $price = $product->get_regular_price();
        } else if($product->is_type( 'variable' )){
            $price = $product->get_variation_price('min', true);
        }
        if($price > 300){
            update_field("new_arrivals", "1", $product->get_id( ));
        }
        update_field("shwi", "0", $product->get_id( ));
        $product->save();
    } else{
        print_r($name . " deleted");
    }
}
if($products->max_num_pages != $paged){
    $paged ++;
    echo '<a href="/icebiz/setStatus.php">Next</a>';
}