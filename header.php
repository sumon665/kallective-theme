<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kallective
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div class="site-wrap">
	<header class="header">
      <div class="header-top-section">
        <div class="wrapper">
          <div class="header-top">
            <a href="mailto:hello@thekallective.com" class="header-top__email">hello@thekallective.com</a>
            <?php if(function_exists('wc_memberships_get_user_active_memberships')) $user_memberships = wc_memberships_get_user_active_memberships();?>
            <?php if(count($user_memberships)) :?>
            <div class="header-membership active"><?php echo __('You\'re a member', 'kallective');?></div>
            <?php else : ?>
            <a href="/memberships/" class="header-membership"><?php echo __('Join Now to Access Savings', 'kallective');?></a>
            <?php endif;?>
            <div class="header-top-lang">
              USD
            </div>
          </div>
        </div>
      </div>
      <div class="header-btm-section">
        <div class="wrapper">
          <div class="header-btm">
            <div class="header-btm-left">
              <span class="header-btm-left-menu-toggle hidden-desktop"></span>
              <?php wp_nav_menu( [
                'theme_location'  => 'header',
                'menu'            => '', 
                'container'       => false, 
                'container_class' => '', 
                'container_id'    => '',
                'menu_class'      => 'header-btm-left-menu', 
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => '',
              ] ); ?>
              <div class="menu-modal visible-desktop">   
                <i class="menu-modal-overlay"></i>                 
                <div class="menu-modal-content">
                  <div class="wrapper">
                    <div class="menu">
                      <?php $args = array(
                        'taxonomy' => 'product_cat',
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'parent' => 0,
                      );
                      $categories = get_categories($args);
                      usort($categories, function($a, $b){
                        return get_field("order", $a) - get_field("order", $b);
                      });
                      ?>
                      <?php foreach($categories as $cat) : ?>
					            <?php if(!get_field('shm', $cat)) continue; ?>
                      <div class="menu-category">
                        <div class="menu-category__img">
                          <?php $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); ?>
                          <?php if($thumbnail_id) :?>
                          <img src="<?php echo wp_get_attachment_image_url($thumbnail_id, 'large');?>">
                          <?php else : ?>
                          <i class="product-tile-img-placeholder"></i>
                          <?php endif;?>
                        </div>
                        <p class="menu-category__title"><?php echo $cat->category_description;?></p>
                        <?php $link = get_category_link($cat->cat_ID);?>
                        <?php $subcats = get_field('subcats', $cat);?>
                        <div class="menu-category__list">
                          <ul class="menu-list">
                            <?php foreach($subcats as $sub_cat) : ?>
                            <?php $cat_class = '';?>
                            <?php if(get_queried_object()->term_id && get_queried_object()->term_id == $sub_cat->term_id) $cat_class = 'active'; ?>
                            <li><a href="<?php echo get_category_link($sub_cat->term_id);?>" class="menu-list__link <?php echo $cat_class;?>"><?php echo $sub_cat->name;?></a></li>
                            <?php endforeach;?>
                            <li><a href="<?php echo $link;?>" class="menu-list__link _shop-all"><?php echo __('Shop all', 'kallective');?></a></li>
                          </ul>
                        </div>
                      </div>
                      <?php endforeach;?>
                      <div class="menu-category _special">
                        <div class="product-tile special-tile">
                          <a href="/new-arrivals/" class="product-tile-top">
                            <span class="product-tile__img">
                              <img src="https://oneteam.com.ua/files/product-photos/ee6255.jpg" alt="">
                            </span>
                            <span class="product-tile-special-txt">
                              <?php echo __('New arrivals', 'kallective');?>
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <a href="/" class="header-btm-logo">
              <img src="<?php echo get_template_directory_uri( ); ?>/img/icons/logo.svg" width="236" height="32" alt="The Kallective">
            </a>
            <div class="header-btm-right">
              <ul class="header-btm-right-menu">
              <li>
                  <?php if ( is_user_logged_in() ): ?>
                  <?php $current_user = wp_get_current_user(); ?>
                  <?php $current_first_name = $current_user->first_name;
                    $current_last_name  = $current_user->last_name;
                    $display_name = trim($current_first_name . " " . $current_last_name);
                    if(!$display_name) $display_name = $current_user->user_nicename;
                  ?>
                  <a href="/my-account/" class="_loggedin">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>                      
                    <span class="_user-name"><?php echo $display_name;?></span>
                  </a>
                  <?php else: ?>
                  <span class="open-modal" data-modal="#login-modal">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>  
                    <span class="_user-name hidden-mobile">Log In</span>                    
                  </span>
                  <?php endif;?>
                </li>
                <li class="favorites-popover-menu-item">
                <?php 
                $fav_ids = get_field('favourites', get_current_user_id());
                $fav = array_diff(explode(";", $fav_ids), ['']);
                ?>
                <span class="open-favorites-popover">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M20.84 4.60987C20.3292 4.09888 19.7228 3.69352 19.0554 3.41696C18.3879 3.14039 17.6725 2.99805 16.95 2.99805C16.2275 2.99805 15.5121 3.14039 14.8446 3.41696C14.1772 3.69352 13.5708 4.09888 13.06 4.60987L12 5.66987L10.94 4.60987C9.9083 3.57818 8.50903 2.99858 7.05 2.99858C5.59096 2.99858 4.19169 3.57818 3.16 4.60987C2.1283 5.64156 1.54871 7.04084 1.54871 8.49987C1.54871 9.95891 2.1283 11.3582 3.16 12.3899L4.22 13.4499L12 21.2299L19.78 13.4499L20.84 12.3899C21.351 11.8791 21.7563 11.2727 22.0329 10.6052C22.3095 9.93777 22.4518 9.22236 22.4518 8.49987C22.4518 7.77738 22.3095 7.06198 22.0329 6.39452C21.7563 5.72706 21.351 5.12063 20.84 4.60987V4.60987Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="_count <?php echo !count($fav) ? "hidden" : "";?>"><?php echo count($fav);?></span>
                  </span>
                  <?php get_template_part( 'template-parts/modal', 'favourites' ); ?>
                </li>
                <li>
                  <span class="open-cart-panel">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>                      
                    <span class="_count header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
	</header>
  <div class="page-content"> <!-- page-content start -->