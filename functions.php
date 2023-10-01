<?php
/**
 * kallective functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kallective
 */

if ( ! defined( '_S_VERSION' ) ) {
// Replace the version number of the theme on each release.
define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'kallective_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kallective_setup() {
/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	* If you're building a theme based on kallective, use a find and replace
	* to change 'kallective' to the name of your theme in all the template files.
	*/
load_theme_textdomain( 'kallective', get_template_directory() . '/languages' );

// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );

/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
add_theme_support( 'title-tag' );

/*
	* Enable support for Post Thumbnails on posts and pages.
	*
	* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	*/
add_theme_support( 'post-thumbnails' );

register_nav_menus(
	array(
		'header' => esc_html__( 'Primary', 'kallective' ),
		'footer-help' => esc_html__( 'Help', 'kallective' ),
		'footer-about' => esc_html__( 'About', 'kallective' ),
		'footer-business' => esc_html__( 'Business', 'kallective' ),
	)
);

/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
add_theme_support(
	'html5',
	array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	)
);

// Set up the WordPress core custom background feature.
add_theme_support(
	'custom-background',
	apply_filters(
		'kallective_custom_background_args',
		array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)
	)
);

// Add theme support for selective refresh for widgets.
add_theme_support( 'customize-selective-refresh-widgets' );

/**
 * Add support for core custom logo.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
add_theme_support(
	'custom-logo',
	array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	)
);
}
endif;
add_action( 'after_setup_theme', 'kallective_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kallective_content_width() {
$GLOBALS['content_width'] = apply_filters( 'kallective_content_width', 640 );
}
add_action( 'after_setup_theme', 'kallective_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kallective_widgets_init() {
register_sidebar(
array(
	'name'          => esc_html__( 'Sidebar', 'kallective' ),
	'id'            => 'sidebar-1',
	'description'   => esc_html__( 'Add widgets here.', 'kallective' ),
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>',
)
);
}
add_action( 'widgets_init', 'kallective_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kallective_scripts() {
	global $post;
	wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri()."/css/owl.carousel.min.css", array(), _S_VERSION );
	wp_enqueue_style( 'slick-css', get_template_directory_uri()."/css/slick.1.9.0.min.css", array(), _S_VERSION );
	if(is_product() || is_page('career')) wp_enqueue_style( 'select2-css', get_template_directory_uri()."/css/select2.min.css", array(), _S_VERSION );
	wp_enqueue_style( 'fotorama-css', get_template_directory_uri()."/css/fotorama.4.6.4.css", array(), _S_VERSION );
	wp_enqueue_style( 'ion', get_template_directory_uri()."/css/ion.rangeSlider.min.css", array(), _S_VERSION );
	wp_enqueue_style( 'style', get_template_directory_uri()."/css/style.css", array(), _S_VERSION );
	wp_enqueue_style( 'kallective-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_deregister_script('jquery-core');
	wp_deregister_script('jquery');
	wp_register_script( 'jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, null, true );
	wp_register_script( 'jquery', false, array('jquery-core'), null, true );
	wp_enqueue_script( 'jquery' );
	/*
	wp_enqueue_script('slick', get_template_directory_uri() . "/js/slick.min.js", ['jquery'], _S_VERSION, true);
	wp_enqueue_script('magnific', get_template_directory_uri()."/js/magnific/dist/jquery.magnific-popup.min.js", ['jquery'], _S_VERSION, true);
	wp_enqueue_script('scroll', get_template_directory_uri() . "/js/onepage-scroll-master/jquery.onepage-scroll.min.js", ['jquery'], _S_VERSION, true);
	wp_enqueue_script('scripts', get_template_directory_uri() . "/js/scripts.js", ['jquery', 'scroll', 'slick', 'magnific'], _S_VERSION, true);
	*/
	if(is_front_page()){
		wp_enqueue_script('home', get_template_directory_uri() . "/js/home-page-bundle.js",['jquery'], _S_VERSION, true);
	} elseif(is_page('about')){
		wp_enqueue_script('about', get_template_directory_uri() . "/js/about-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_page('career')){
		wp_enqueue_script('career', get_template_directory_uri() . "/js/career-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_post_type_archive('faq')){
		wp_enqueue_script('faq', get_template_directory_uri() . "/js/faq-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_page('cart') || is_page('checkout')){
		wp_enqueue_script('cart', get_template_directory_uri() . "/js/cart-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_product() || is_singular('kampaign')){
		$_product = is_product() ? wc_get_product( $post->ID ) : false;
		if( $_product && $_product->is_type( 'lottery' ) ) {
			wp_enqueue_script('lottery', get_template_directory_uri() . "/js/raffle-page-bundle.js", ['jquery'], _S_VERSION, true);
		} else {
			wp_enqueue_script('product', get_template_directory_uri() . "/js/product-page-bundle.js", ['jquery'], _S_VERSION, true);
		}
		
	} else if(is_page_template('page-cabinet.php')){
		wp_enqueue_script('product', get_template_directory_uri() . "/js/cabinet-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_page_template('page-track_order.php')){
		wp_enqueue_script('track', get_template_directory_uri() . "/js/track-order-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_page_template('page-raffles.php') || is_page_template('page-challenges.php') || is_page_template('page-campaigns.php') ){
		wp_enqueue_script('challenge', get_template_directory_uri() . "/js/challenges-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_page('sales')){
		wp_enqueue_script('sales', get_template_directory_uri() . "/js/sale-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else if(is_product_category() || is_search()){
		wp_enqueue_script('products', get_template_directory_uri() . "/js/filtered-products-page-bundle.js", ['jquery'], _S_VERSION, true);
	} else{
		wp_enqueue_script('simple', get_template_directory_uri() . "/js/simple-page-bundle.js", ['jquery'], _S_VERSION, true);
	}
	wp_enqueue_script( 'bodycommerce-add-to-cart-ajax', get_template_directory_uri() . '/js/add-to-cart-ajax.js', ['jquery'], '', true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', ['jquery'], '', true );
	wp_enqueue_script( 'ajax_search', get_template_directory_uri() . '/js/ajax-search.js', ['jquery'], '', true );
	wp_localize_script('ajax', 'ajaxUrl', 
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);
}
add_action( 'wp_enqueue_scripts', 'kallective_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
require get_template_directory() . '/inc/jetpack.php';
}

require get_template_directory() . '/inc/faqs.php';
require get_template_directory() . '/inc/woo-account-nav.php';
require get_template_directory() . '/inc/woo-checkout-functions.php';
require get_template_directory() . '/inc/woo-ajax.php';
require get_template_directory() . '/inc/user-functions.php';
require get_template_directory() . '/inc/wp-ajax.php';
require get_template_directory() . '/inc/woocommerce-waitlist.php';

add_filter( 'upload_mimes', 'svg_upload_allow' );

# Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';

	return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

	// WP 5.1 +
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	else
		$dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );

	// mime тип был обнулен, поправим его
	// а также проверим право пользователя
	if( $dosvg ){

		// разрешим
		if( current_user_can('manage_options') ){

			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		// запретим
		else {
			$data['ext'] = $type_and_ext['type'] = false;
		}

	}

	return $data;
}

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
	if ( !$query->is_main_query() ) return;
	if(isset($_GET['category'])){
		$query->set('cat', intval($_GET['category']));
		return $query;
	}
}

add_action( 'wpcf7_mail_sent', 'kallective_wpcf7_mail_sent_function' ); 
function kallective_wpcf7_mail_sent_function( $contact_form ) {
	$title = $contact_form->title;
	$coupon_code = '';
	$args = [];
    $submission = WPCF7_Submission::get_instance();  
    if ( $submission ) {
        $posted_data = $submission->get_posted_data();
	}  
	if($title == 'Join The List') {
		$email = strtolower($posted_data['coupon-email']);
		$coupon_code = generateRandomString(); // Code
		$amount = '10'; // Amount
		$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product

		$coupon = array(
			'post_title' => $coupon_code,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type' => 'shop_coupon'
		);

		$new_coupon_id = wp_insert_post( $coupon );

		// Add meta
		update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
		update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
		update_post_meta( $new_coupon_id, 'individual_use', 'no' );
		update_post_meta( $new_coupon_id, 'product_ids', '' );
		update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
		update_post_meta( $new_coupon_id, 'usage_limit', 1 );
		update_post_meta( $new_coupon_id, 'expiry_date', '' );
		update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
		update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
		update_post_meta( $new_coupon_id, 'customer_email', $email );

		$subject = 'Your Coupon Code from Kallective';
		$template = 'emails/customer-coupon-email.php';
		$args['coupon'] = $coupon_code;
	} else {
		$subject = 'Thanks for your request';
		$template = 'emails/customer-contact-email.php';
		$email = strtolower($posted_data['your-email']);
	}
	kallective_send_mail($email, $subject, $template, $args);
}

function kallective_send_mail($to, $subject, $template, $args = []){
	$mailer = WC()->mailer();
	$recipient = $to;
	$def_args = array(
		'email_heading' => $subject,
		'sent_to_admin' => false,
		'plain_text'    => false,
		'email'         => $mailer,
	);
	$args = array_merge($def_args, $args);
	$content = wc_get_template_html( $template, $args);
	$headers = "Content-Type: text/html\r\n";
	$mailer->send( $recipient, $subject, $content, $headers );
}

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

add_filter( 'wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2 );
  
function custom_email_confirmation_validation_filter( $result, $tag ) {
  if ( 'coupon-email' == $tag->name ) {
	$your_email = isset( $_POST['coupon-email'] ) ? trim( $_POST['coupon-email'] ) : '';
	$coupons = get_posts(array(
		'post_type'   => 'shop_coupon',
		'meta_key'    => 'customer_email',
		'meta_value'  =>  $your_email
	));
    if ( count($coupons) ) {
      $result->invalidate( $tag, "This email is already used" );
    }
  }
  return $result;
}

add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );
function add_menu_link_class( $atts, $item, $args ) {
	if (in_array('current-menu-item', $item->classes)) {
		$atts['class'] = 'active';
	}
	return $atts;
}

function handle_custom_query_var( $query, $query_vars ) {
	if ( isset($query_vars['nyp']) ) {
		if($query_vars['nyp'] == 'yes'){
			$query['meta_query'][] = array(
				'key' => '_nyp',
				'value' => esc_attr( $query_vars['nyp'] ),
			);
		} else {
			$posts = wc_get_products(['nyp' => 'yes']);
			$exclude = [];
			foreach($posts as $post){
				$exclude[] = $post->get_id();
			}
			$query['post__not_in'] = $exclude;
		}
	}
	if( isset($query_vars['ordby']) && $query_vars['ordby'] == 'shwi'){
		$query['meta_query'][] = array(
			'relation' => 'OR',
			array(
				'key' => 'shwi',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key' => 'shwi',
				'compare' => 'EXISTS',
			),
		);
		$query['orderby'] = array(
			'meta_value' => 'DESC',
			'date' => 'DESC',
		);
	}
	return $query;
}
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_var', 10, 2 );

function woocommerce_pre_get_posts( $query ) {
	
	if (!is_admin() && $query->is_main_query() ) {
		// Exclude Name Your Price
		if( $query->get('product_cat')){
			$meta_args = array(
				array(
					'relation' => 'OR',
					array(
						'key' => '_nyp',
						'compare' => 'NOT EXISTS'
					),
					array(
						'key' => '_nyp',
						'compare' => '!=',
						'value' => 'yes',
					),
				),
			);
			//Set filter params
			$GLOBALS['has_filters'] = false;
			if(isset($_GET)){
				$_GET = wc_clean($_GET);
				foreach($_GET as $k=>$val){
					if($k != 'categ' && $k != 'price_min' && $k != 'price_max' && $k != 'orderby' && $k != 's' && $k != 'post_type'){
						$tax_args[] = array(
							'taxonomy' => $k,
							'field' => 'name',
							'terms' => $val,
							'compare' => 'IN',
						);
						$GLOBALS['has_filters'] = true;
					}
				}
				if($_GET['categ']){
					$tax_args[] = array(
						'taxonomy' => 'product_cat',
						'field' => 'name',
						'terms' => $_GET['categ'],
					);
				}
				$meta_args[] = array(
					'meta_key'  => '_price',
					'value'     => array( $_GET['price_min'], $_GET['price_max'] ),
					'compare'   => 'BETWEEN',
					'type'      => 'NUMERIC'
				);
				$query->set( 'tax_query', $tax_args );
			}
			$query->set( 'meta_query', $meta_args ); 
		}
	}
}
add_action( 'pre_get_posts', 'woocommerce_pre_get_posts', 20 );

//Exclude Product FAQS from archive
function faqs_pre_get_postst($query){
	if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'faq' )) {
		$tax_args[] = array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => 'products-faqs',
			'operator' => 'NOT IN',
		);
		$query->set( 'tax_query', $tax_args );
	}
}
add_action( 'pre_get_posts', 'faqs_pre_get_postst', 20 );

add_filter('wc_nyp_price_input_attributes', 'kallective_nyp_paceholder');
function kallective_nyp_paceholder($defs){
	$defs['placeholder'] = "My price is ($)";
	return $defs;
}

add_filter('wp_nav_menu_objects', 'nav_items_callback');
function nav_items_callback( $items ){
	foreach( $items as $k => $item ){
		if(is_sale_day() && $item->ID == 180) {
			unset($items[$k]);
		}
		if(!is_sale_day() && $item->ID == 193) {
			unset($items[$k]);
		}
	}
	return $items;
}

function is_sale_day(){
	$is_sale_day = false;

	$day_of_month = date("d");
	$day_of_week = date("l");
	if($day_of_month == 1 && $day_of_week == 'Sunday'){
		$is_sale_day = true;
	}
	$month = date("F");
	$last_saturday = date("d-m-Y", strtotime("last saturday of {$month}"));
	$last_sunday = date("d-m-Y", strtotime("last sunday of {$month}"));
	if(date('d-m-Y') == $last_saturday || date('d-m-Y') == $last_sunday){
		$is_sale_day = true;
	}
	return $is_sale_day;
}

function kallective_body_class($classes) {
	if(is_page_template('page-cabinet.php') && !is_user_logged_in()){
		$classes[] = 'page-login';
	}
    return $classes;
}

add_filter('body_class', 'kallective_body_class');

function kallective_product_price($product){
	if(WC_Name_Your_Price_Helpers::is_nyp($product)){
		$price = WC_Name_Your_Price_Helpers::get_maximum_price($product);
		if($price) echo "<span>$$price</span>";
	} else if($product->is_type( 'variable' )){
		$min_price_for_display = number_format($product->get_variation_price('min', true),2);
		$max_price_for_display = number_format($product->get_variation_price('max', true),2);
		if($max_price_for_display > 0){
			echo $min_price_for_display == $max_price_for_display ? "$ $max_price_for_display" : "$ $min_price_for_display - $ $max_price_for_display";
		}
	} else if($product->is_type( 'simple' ) || $product->is_type( 'subscription' )){
		$price = number_format($product->get_regular_price(), 2);
		$sale = number_format($product->get_sale_price(), 2);
		if($sale > 0){
			echo "$ $sale<span>$ $price</span>";
		} else if($price > 0){
			echo "$ $price";
		}
	}
}

add_filter( 'woocommerce_product_get_image', 'kallective_filter_get_image', 10, 6 );
function kallective_filter_get_image( $image, $that, $size, $attr, $placeholder, $image2 ){
	if(!$that->get_image_id()){
		$postfix = '';
		if($size == 'woocommerce_thumbnail'){
			$postfix = ' _small';
		}
		return '<i class="product-tile-img-placeholder ' . $postfix . '"></i>';
	}
	return $image;
}

add_filter( 'manage_edit-product_columns', 'show_product_order',15 );
function show_product_order($columns){
   $columns['partnumber'] = __( 'Part Number'); 
   return $columns;
}

add_action( 'manage_product_posts_custom_column', 'product_column_pn', 10, 2 );
function product_column_pn( $column, $postid ) {
    if ( $column == 'partnumber' ) {
        echo get_field( 'pn', $postid );
    }
}

function my_custom_product_filters( $post_type ) {
	
	$opt1 = '';
	$opt2 = '';
	
	if( isset( $_GET['my_filter'] ) ) {
		switch( $_GET['my_filter'] ) {
			case '1':
			$opt1 = ' selected';
			break;

			case '2':
			$opt2 = ' selected';
			break;
		}
	}
	
	if( $post_type == 'product' ) {
		echo '<select name="my_filter">';
			echo '<option value>Show all value types</option>';
			echo '<option value="1" ' . $opt1 . '>With images</option>';
			echo '<option value="2" ' . $opt2 . '>Without images</option>';
		echo '</select>';
	}
}
	
add_action( 'restrict_manage_posts', 'my_custom_product_filters' );

function apply_my_custom_product_filters( $query ) {
	global $pagenow;

	if ( $query->is_admin && $pagenow == 'edit.php' && isset( $_GET['my_filter'] ) && $_GET['my_filter'] != '' && $_GET['post_type'] == 'product' ) {
	  $meta_key_query = array(
		array(
		  'key' => '_thumbnail_id',
		  'compare' => $_GET['my_filter'] == 1 ? 'EXISTS' : 'NOT EXISTS'
		)
	  );
	  $query->set( 'meta_query', $meta_key_query );
	}
}
	
add_action( 'pre_get_posts', 'apply_my_custom_product_filters' );

function delete_product($id, $force = FALSE){
    $product = wc_get_product($id);

    if(empty($product))
        return new WP_Error(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $id));

    // If we're forcing, then delete permanently.
    if ($force)
    {
        if ($product->is_type('variable'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->delete(true);
            }
        }
        elseif ($product->is_type('grouped'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    }
    else
    {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result)
    {
        return new WP_Error(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($id))
    {
        wc_delete_product_transients($parent_id);
    }
    return true;
}

function redirect_to_checkout_product_ids( $url, $adding_to_cart ) {
	if ( WC_Subscriptions_Product::is_subscription($adding_to_cart) || kallective_is_waitlist_access($adding_to_cart) ){
		$url = wc_get_cart_url();
	}
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'redirect_to_checkout_product_ids', 10, 2 );

function membership_to_remove( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
	$monthly = get_page_by_title('Monthly membership', OBJECT, 'product');
	$yearly = get_page_by_title('Yearly membership', OBJECT, 'product');
	$compare = [$monthly->ID, $yearly->ID];

    $key = array_search($product_id, $compare);

    if ( $key !== false ) {
		unset($compare[$key]);
		$need_to_del = implode("", $compare);
        $product_cart_id = WC()->cart->generate_cart_id( $need_to_del );
        $item_key = WC()->cart->find_product_in_cart( $product_cart_id );
        if ( $item_key ) {
            WC()->cart->remove_cart_item( $item_key );
        }
    }
}
add_action( 'woocommerce_add_to_cart', 'membership_to_remove', 10, 6 );

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}

add_filter( 'woocommerce_terms_is_checked_default', 'set_checked_wc_terms', 10 );
function set_checked_wc_terms( $terms_is_checked ) {   
	return true;   
}

add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_name_args' );
function custom_woocommerce_get_catalog_ordering_name_args( $args ) {
	$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	if ( 'name' == $orderby_value ) {
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
		$args['meta_key'] = '';
	}
	if ( 'name-desc' == $orderby_value ) {
		$args['orderby'] = 'title';
		$args['order'] = 'DESC';
		$args['meta_key'] = '';
	}
	return $args;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_name_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_name_orderby', 1 );
function custom_woocommerce_catalog_name_orderby( $sortby ) {
	$sortby['name'] = 'Name (A-Z)';
	$sortby['name-desc'] = 'Name (Z-A)';
	return $sortby;
}

add_action( 'save_post', 'save_product_meta', 10, 2 );
function save_product_meta($post_id, $post){;
	if ( $post->post_type != 'product' ) return;
	if(!get_field("shwi", $post_id)) update_field("shwi", "0", $post_id);
}

add_action( 'wp', 'kallective_write_visited' );
function kallective_write_visited(){
	global $post;
	if(!is_user_logged_in( )) return;
	if(is_singular('product')){
		$user = wp_get_current_user();
		$visited = array_diff(explode(";", get_field('visited_products', $user->ID)), ['']);
		if(array_search($post->ID, $visited) === false){
			$visited[] = $post->ID;
			update_field('visited_products', implode(";", $visited), $user->ID);
		}
	}
}

function sort_sizes($a, $b){
	$sizes = array(
		"XXS" => 1,
		"XS" => 2,
		"S" => 3,
		"M" => 4,
		"L" => 5,
		"XL" => 6,
		"XXL" => 7,
		"3XL" => 8,
		"XXXL" => 9
	);
	if(is_array($a)){
		$asize = $sizes[$a['value']] ? $sizes[$a['value']] : $a['value'];
		$bsize = $sizes[$b['value']] ? $sizes[$b['value']] : $b['value'];
	} else {
		$asize = $sizes[$a->name] ? $sizes[$a->name] : $a->name;
		$bsize = $sizes[$b->name] ? $sizes[$b->name] : $b->name;
	}

	if ($asize == $bsize) {
		return 0;
	}
	return ($asize > $bsize) ? 1 : -1;
}

add_filter( 'woocommerce_get_product_terms', 'filter_size', 10, 4 );
function filter_size( $_wc_get_cached_product_terms, $product_id, $taxonomy, $args ){
	if($taxonomy == 'pa_size'){
		usort($_wc_get_cached_product_terms, "sort_sizes");
	}
	return $_wc_get_cached_product_terms;
}

add_filter('single_template', function($single){
	global $post;
	$located = locate_template( "single-{$post->post_type}.php"  );
	if(!empty($located)){
		return $located;
	}
	return $single;
}, 10);