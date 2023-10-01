<?php 
ini_set("max_execution_time", 300);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
require_once '/home/jmcxofmy/public_html/dev/wp-blog-header.php';

$paged = get_option('updater_paged');

$products = wc_get_products([
    'limit' => 500,
    'paginate' => true,
    'page' => $paged,
]);
$paged ++;
if($products->max_num_pages <= $paged || $products->total == 0){
	$paged = 0;
}
update_option('updater_paged', $paged);
foreach($products->products as $product){
	if(!get_field("shwi", $product->get_id())) update_field("shwi", 0, $product->get_id());
}
if($products->max_num_pages != $paged){
    echo '<a href="/wp-content/themes/kallective/inc/updater.php">Next</a>';
	echo '<script>setTimeout(function(){location.href="/wp-content/themes/kallective/inc/updater.php"}, 500)</script>';
}