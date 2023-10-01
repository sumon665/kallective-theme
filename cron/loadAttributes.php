<?php 
ini_set("max_execution_time", 300);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/../wp-blog-header.php';

$paged = get_option('attributes_paged');

$products = wc_get_products([
    'status' => 'publish',
    'limit' => 10,
    'paginate' => true,
    'page' => $paged,
    'category' => array( 'technology' ),
]);
$paged ++;
if($products->max_num_pages <= $paged || $products->total == 0){
	$paged = 0;
}
update_option('attributes_paged', $paged);
file_put_contents(__DIR__ . '/atts-log.txt', "Attributes update start" . PHP_EOL, FILE_APPEND);
foreach($products->products as $product){
    $pn = myUrlEncode(get_field('pn', $product->get_id( )));
    $brand = myUrlEncode(get_field('manufacturer', $product->get_id( )));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://live.icecat.biz/api/?UserName=ekklezi&Language=en&Brand={$brand}&ProductCode={$pn}&Content=all");
    $res = curl_exec($ch);
    curl_close($ch);
    if($res){
        $res = json_decode($res);
        file_put_contents(__DIR__ . '/atts-log.txt', $product->get_name() . " attributes update " . PHP_EOL, FILE_APPEND);
        $attributes = [];
        foreach($res->data->FeaturesGroups as $group){
            foreach($group->Features as $feature){
                $name = $feature->Feature->Name->Value;
                $value = $feature->Value;
                
                $measure = $feature->Feature->Measure->Signs->_;
                if($measure) $value .= " " . $measure;
                $attributes[$name] = array_diff(explode(",", $value), [""]);
                
            }
        }
        $parent_term = term_exists( 'Technologies', 'product_cat' ); // вернет массив, если таксономия существует
        $parent_term_id = $parent_term['term_id'];
        $term_info = term_exists( $res->data->GeneralInfo->Category->Name->Value, 'product_cat' );
        if ( ! $term_info ) {
            $term_info = wp_insert_term( $res->data->GeneralInfo->Category->Name->Value, 'product_cat', array(
                'description' => '',
                'parent'      => $parent_term_id,
                'slug'        => '',
            ) );
        }
        wp_set_object_terms($product->get_id( ), $res->data->GeneralInfo->Category->Name->Value, 'product_cat', true);
        $product_attributes = array();
        foreach( $attributes as $key => $terms ){
            
            $taxonomy = wc_attribute_taxonomy_name($key); // The taxonomy slug
            $attr_label = ucfirst($key); // attribute label name
            $attr_name = ( wc_sanitize_taxonomy_name($key)); // attribute slug

            // NEW Attributes: Register and save them
            if( ! taxonomy_exists( $taxonomy ) ){
                $res = save_product_attribute_from_name( $attr_name, $attr_label );
            }
            
            $product_attributes[$taxonomy] = array (
                'name'         => $taxonomy,
                'value'        => '',
                'position'     => '',
                'is_visible'   => 1,
                'is_variation' => 0,
                'is_taxonomy'  => 1
            );
            $r = wp_set_object_terms( $product->get_id( ), $terms, $taxonomy, true );
        }
        update_post_meta( $product->get_id( ), '_product_attributes', $product_attributes );
    }
}

function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

function save_product_attribute_from_name( $name, $label='', $set=true ){
    if( ! function_exists ('get_attribute_id_from_name') ) return;

    global $wpdb;

    $label = $label == '' ? ucfirst($name) : $label;
    $attribute_id = get_attribute_id_from_name( $name );

    if( empty($attribute_id) ){
        $attribute_id = NULL;
    } else {
        $set = false;
    }
    $args = array(
        'id'      => $attribute_id,
        'name'    => $label,
        'slug'   => $name,
        'type'    => 'select',
        'order_by' => 'menu_order',
    );
    return wc_create_attribute($args);

    if( empty($attribute_id) ) {
        $wpdb->insert(  "{$wpdb->prefix}woocommerce_attribute_taxonomies", $args );
        set_transient( 'wc_attribute_taxonomies', false );
    }

    if( $set ){
        $attributes = wc_get_attribute_taxonomies();
        $args['attribute_id'] = get_attribute_id_from_name( $name );
        $attributes[] = (object) $args;
        set_transient( 'wc_attribute_taxonomies', $attributes );
    } else {
        return;
    }
}

function get_attribute_id_from_name( $name ){
    global $wpdb;
    $attribute_id = $wpdb->get_col("SELECT attribute_id
    FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
    WHERE attribute_name LIKE '$name'");
    return reset($attribute_id);
}