<?php
/*
Template Name: Credits page
*/

get_header();
?>
<div class="wrapper">
    <div class="breadcrumbs-section">
        <?php woocommerce_breadcrumb([
            'wrap_before' => '<ul class="breadcrumbs">',
            'before' => '<li class="breadcrumbs__item">',
            'wrap_after' => '</ul>',
            'after' => '</li>',
            'delimiter' => ''
        ]); ?>
    </div>
    <div class="purchase-credits-section">
        <h1 class="purchase-credits-section__title"><?php echo __('Become a member', 'kallective');?></h1>
        <div class="purchase-credits-header">
            <?php the_content();?>
        </div>
        <ul class="purchase-credits-list">
        <li class="_refer">
            <div class="purchase-credits-refer">
            <span class="purchase-credits-refer__badge">REFER A FRIEND</span>
            <h2 class="purchase-credits-refer__title">Become an Impact+ Ambassador and get free Campaign Credits.</h2>
            <p class="purchase-credits-refer__desc">By helping us share our mission, you can unlock exclusive access to amazing Giveaways all while supporting organizations and causes that matter most to you.</p>
            <div class="purchase-credits-refer__link">
                <a href="/become-an-ambassador/" class="btn-primary">
                Become an Ambassador
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                    <path d="M7 5.215L8.1776 4L14 10L8.1776 16L7 14.785L11.6411 10L7 5.215Z" fill="#F9F9F9"/>
                    </g>
                    <defs>
                    <clipPath id="clip0">
                    <rect width="20" height="20" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>                    
                </a>
            </div>
            </div>
        </li>   
        <?php 
        $products = wc_get_products([
            'status' => 'publish',
            'limit' => 12,
            'category' => array( 'fsww-wallet-credit' ),
        ]);  
        ?>       
        <?php foreach($products as $product):?>
        <?php $product_class = strtolower(explode(" ", $product->get_name())[0]);?>
        <li class="_<?php echo $product_class;?>">
            <div class="purchase-credits-item">
            <div class="purchase-credits-item__header">
                <h3><?php echo $product->get_name();?></h3>
                <p><?php echo $product->get_short_description();?></p>
            </div>
            <p class="purchase-credits-item__price"><?php kallective_product_price($product);?></p>
            <p class="purchase-credits-item__donated"><?php echo get_field('donated', $product->get_id());?></p>
            <p class="purchase-credits-item__desc"><?php echo $product->get_description();?></p>
            <div class="purchase-credits-item__link">
                <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                    <input type="hidden" name="type" value="sub">
                    <input type="hidden" name="quantity" value="1" class="qty"> 
                    <input type="hidden" name="product_id" class="product_id" value="<?php echo $product->get_id();?>">
                    <button type="submit" class="btn-primary product-details__actions-cart ajax_add_to_cart" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>">
                        <span class="btn-label"><?php echo __('Get Started', 'kallective');?></span>
                        <span class="icon icon-spinner"></span>
                    </button>
                    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                </form>
            </div>
            </div>
        </li>
        <?php endforeach;?>            
        </ul>
    </div>
</div>
<?php
get_footer();