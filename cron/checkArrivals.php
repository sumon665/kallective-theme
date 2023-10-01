<?php 
ini_set("max_execution_time", 300);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/../wp-blog-header.php';

$products = wc_get_products([
    'limit' => -1,
    'meta_key'	=> 'new_arrivals',
    'meta_value'	=> 1,
]);

foreach($products as $product){
    $interval = (strtotime('now') - strtotime(get_post_time('Y-m-d H:i:s', false, $product->get_id()))) / 86400;
    if($interval > 14){
        update_field("new_arrivals", "0", $product->get_id( ));
    }
}