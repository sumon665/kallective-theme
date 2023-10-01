<?php 

ini_set("max_execution_time", 300);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/../wp-blog-header.php';

$paged = get_option('images_paged');

$products = wc_get_products([
    'limit' => 5,
    'paginate' => true,
    'page' => $paged,
    'status' => 'draft',
    'category' => array( 'technology' ),
]);
$paged ++;
if($products->max_num_pages <= $paged || $products->total == 0){
	$paged = 0;
}
update_option('images_paged', $paged);
foreach($products->products as $product){
    $thumb = get_post_thumbnail_id( $product->get_id( ) );
    $attach_id_array = get_post_meta($product->get_id( ),'_product_image_gallery', true);
    if($thumb || $attach_id_array || get_field( 'paid_icecat', $product->get_id( ) )) continue;
    $pn = myUrlEncode(get_field('pn', $product->get_id( )));
    $brand = myUrlEncode(get_field('manufacturer', $product->get_id( )));
    file_put_contents(__DIR__ . '/log.txt', $brand . " " . $pn . PHP_EOL, FILE_APPEND);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://live.icecat.biz/api/?UserName=ekklezi&Language=en&Brand={$brand}&ProductCode={$pn}&Content=Gallery");
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($res);
    if($res->msg == 'OK'){
        foreach($res->data->Gallery as $k=>$image){
            if($image->IsMain == 'Y'){
                attach_product_thumbnail($product->get_id( ), $image->Pic, 0);
            } else {
                attach_product_thumbnail($product->get_id( ), $image->Pic, 1);
            }
        }
        $log = "Images for " . $brand . " " . $pn . " updated";
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
    } else if($res->statusCode == 9){
    	$log = "Images for " . $brand . " " . $pn . " can be updated with paid icecat";
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
    	update_field('paid_icecat', 1, $product->get_id( ));
    }
}
if($products->max_num_pages != $paged){
    $paged ++;
    echo '<a href="/icebiz/loadImages.php">Next</a>';
}

function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

/**
 * Attach images to product (feature/ gallery)
 */
function attach_product_thumbnail($post_id, $url, $flag){
    /*
        * If allow_url_fopen is enable in php.ini then use this
        */
    //$image_url = $url;
    //$url_array = explode('/',$url);
    //$image_name = $url_array[count($url_array)-1];
    //$image_data = file_get_contents($image_url); // Get image data
    /*
    * If allow_url_fopen is not enable in php.ini then use this
    */

    $image_url = $url;
    $url_array = explode('/',$url);
    $image_name = $url_array[count($url_array)-1];

    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $image_url);

    // // Getting binary data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

    $image_data = curl_exec($ch);
    curl_close($ch);

    $upload_dir = wp_upload_dir(); // Set upload folder
    $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); //    Generate unique name
    $filename = basename( $unique_file_name ); // Create image file name

    // Check folder permission and define file location
    if( wp_mkdir_p( $upload_dir['path'] ) ) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }
    // Create the image file on the server
    file_put_contents( $file, $image_data );

    // Check image file type
    $wp_filetype = wp_check_filetype( $filename, null );

    // Set attachment data
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name( $filename ),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    // Create the attachment
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

    // Include image.php
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Define attachment metadata
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

    // Assign metadata to attachment
    wp_update_attachment_metadata( $attach_id, $attach_data );

    // asign to feature image
    if( $flag == 0){
        // And finally assign featured image to post
        set_post_thumbnail( $post_id, $attach_id );
    }

    // assign to the product gallery
    if( $flag == 1 ){
        // Add gallery image to product
        $attach_id_array = get_post_meta($post_id,'_product_image_gallery', true);
        $attach_id_array .= ','.$attach_id;
        update_post_meta($post_id,'_product_image_gallery',$attach_id_array);
    }

}