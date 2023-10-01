<?php $current = $wp_query->get_queried_object();?>
<?php global $has_filters;?>
<div class="goods-filters">
    <div class="goods-filters__left">
        <div class="goods-filters-categories-wrap">
        <div class="goods-filters-categories">
            <div class="goods-filters-categories__toggle hidden-desktop">
                <?php if(is_front_page()){
                    echo "All items";
                } else if($current->taxonomy == 'product_cat' && !$current->parent){
                    echo $current->name;
                } else if($current->taxonomy == 'product_cat' && $current->parent){
                    $parent = get_term($current->parent, 'product_cat');
                    echo $parent->name;
                } ?>
            </div>
            <ul class="goods-filters-categories__list">
            <li><a href="/" class="<?php if(is_front_page()) echo 'active';?>">All items</a></li>
            <?php 
            $args = array(
                'taxonomy' => 'product_cat',
                'orderby' => 'name',
                'order' => 'ASC',
                'parent' => 0,
                'exclude' => '15'
                );
            $categories = get_categories($args);
            usort($categories, function($a, $b){
              return get_field("order", $a) - get_field("order", $b);
            });
            ?>
            <?php foreach($categories as $cat) : ?>
                <?php if($cat->name == 'unisez' || $cat->name == 'Memberships' || $cat->name == 'WooCommerce Wallet Credit' || $cat->name == 'Accessories') continue;?>
                <?php $class = ($cat->cat_ID == $current->term_id || (isset($parent) && $cat->cat_ID == $parent->term_id)) ? "active" : ""; ?>
                <li><a href="<?php echo get_category_link($cat->cat_ID);?>" class="<?php echo $class;?>"><?php echo $cat->name;?></a></li>
            <?php endforeach;?>
            </ul>
        </div>
        </div>
    </div>
    <div class="goods-filters__right">
      <?php if(!is_front_page()):?>
      <?php $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : ""; ?>
      <div class="goods-sort-by">
        <span class="goods-sort-by__btn hidden-mobile <?php if(!empty($orderby) && $orderby != 'menu_order') echo '_has_active-filter';?>">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 9.00019H17L15.4 10.2002C15.2949 10.279 15.2064 10.3777 15.1395 10.4907C15.0726 10.6037 15.0286 10.7288 15.0101 10.8588C14.9915 10.9888 14.9987 11.1212 15.0313 11.2484C15.0639 11.3756 15.1212 11.4951 15.2 11.6002C15.2931 11.7244 15.4139 11.8252 15.5528 11.8946C15.6916 11.964 15.8448 12.0002 16 12.0002C16.2164 12.0002 16.4269 11.93 16.6 11.8002L20.6 8.80019C20.7223 8.70686 20.8214 8.58658 20.8897 8.44869C20.9579 8.3108 20.9934 8.15903 20.9934 8.00519C20.9934 7.85134 20.9579 7.69957 20.8897 7.56169C20.8214 7.4238 20.7223 7.30351 20.6 7.21019L16.74 4.21019C16.5305 4.04708 16.2647 3.97389 16.0013 4.0067C15.7378 4.03952 15.4981 4.17567 15.335 4.38519C15.1719 4.59471 15.0987 4.86044 15.1315 5.12393C15.1643 5.38742 15.3005 5.62708 15.51 5.79019L17.08 7.00019H4C3.73478 7.00019 3.48043 7.10555 3.29289 7.29308C3.10536 7.48062 3 7.73497 3 8.00019C3 8.26541 3.10536 8.51976 3.29289 8.7073C3.48043 8.89483 3.73478 9.00019 4 9.00019Z" fill="#1D3557"/>
            <path d="M20.0012 16H7.0012L8.6012 14.8C8.81338 14.6409 8.95365 14.404 8.99115 14.1414C9.02866 13.8789 8.96033 13.6122 8.8012 13.4C8.64207 13.1878 8.40518 13.0476 8.14262 13.0101C7.88007 12.9725 7.61338 13.0409 7.4012 13.2L3.4012 16.2C3.2789 16.2933 3.17977 16.4136 3.11154 16.5515C3.04331 16.6894 3.00781 16.8412 3.00781 16.995C3.00781 17.1488 3.04331 17.3006 3.11154 17.4385C3.17977 17.5764 3.2789 17.6967 3.4012 17.79L7.2612 20.79C7.43575 20.9255 7.65025 20.9993 7.8712 21C8.02392 20.9996 8.17453 20.9643 8.31147 20.8967C8.44841 20.8291 8.56805 20.731 8.6612 20.61C8.82359 20.4015 8.89687 20.1373 8.86502 19.8749C8.83316 19.6126 8.69877 19.3735 8.4912 19.21L6.9212 18H20.0012C20.2664 18 20.5208 17.8946 20.7083 17.7071C20.8958 17.5196 21.0012 17.2652 21.0012 17C21.0012 16.7348 20.8958 16.4804 20.7083 16.2929C20.5208 16.1054 20.2664 16 20.0012 16Z" fill="#1D3557"/>
          </svg>
          <span>Sort by</span>                
        </span>        
        <div class="goods-sort-by__dd">
          <div class="goods-sort-by__dd-header modal-header visible-mobile">
            <span>Sort by</span>
            <span class="modal-header__close"></span>
          </div>
          <ul class="goods-sort-by-list">
            <li class="goods-sort-by-list__item <?php if($orderby == 'price-desc') echo 'active';?>" data-sort="price-desc" >Price (High to Low)</li>
            <li class="goods-sort-by-list__item <?php if($orderby == 'price') echo 'active';?>" data-sort="price">Price (Low to High)</li>
            <li class="goods-sort-by-list__item <?php if($orderby == 'name') echo 'active';?>" data-sort="name">By Name (A to Z)</li>
            <li class="goods-sort-by-list__item <?php if($orderby == 'name-desc') echo 'active';?>" data-sort="name-desc">By Name (Z to A)</li>
          </ul>
        </div>
        <i class="goods-sort-by__dd-overlay visible-mobile"></i>
      </div>
      <?php endif;?>
      <span class="open-filters-sidebar hidden-desktop hidden-mobile <?php if($has_filters) echo '_has_active-filter';?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>  
        <span>Filters</span>                
      </span>
    <form class="goods-search" action="">
        <input type="hidden" name="post_type" value="product">
        <div class="goods-search__inner">
            <span class="goods-search__open">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M20.9999 21.0004L16.6499 16.6504" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                      
            <span class="hidden-mobile">Search</span>
            </span>
            <span class="goods-search__close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M6 6L18 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                      
            </span>
            <span class="goods-search__clear">Clear</span>
            <div class="goods-search__input control-input">
            <input type="text" name="s" id="searchInp" value="<?php echo get_search_query() ?>" placeholder="Search products" autocomplete="off">
            </div>
            <div class="goods-search__suggest" style="display:none;">
            <ul class="goods-search-suggest">
                <li>
                
                </li>
            </ul>
            </div>
        </div>
        </form>
    </div>
    <div class="goods-filters__mobile visible-mobile">
      <?php if(!is_front_page()):?>
      <span class="goods-sort-by__btn <?php if(!empty($orderby) && $orderby != 'menu_order') echo '_has_active-filter';?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 9.00019H17L15.4 10.2002C15.2949 10.279 15.2064 10.3777 15.1395 10.4907C15.0726 10.6037 15.0286 10.7288 15.0101 10.8588C14.9915 10.9888 14.9987 11.1212 15.0313 11.2484C15.0639 11.3756 15.1212 11.4951 15.2 11.6002C15.2931 11.7244 15.4139 11.8252 15.5528 11.8946C15.6916 11.964 15.8448 12.0002 16 12.0002C16.2164 12.0002 16.4269 11.93 16.6 11.8002L20.6 8.80019C20.7223 8.70686 20.8214 8.58658 20.8897 8.44869C20.9579 8.3108 20.9934 8.15903 20.9934 8.00519C20.9934 7.85134 20.9579 7.69957 20.8897 7.56169C20.8214 7.4238 20.7223 7.30351 20.6 7.21019L16.74 4.21019C16.5305 4.04708 16.2647 3.97389 16.0013 4.0067C15.7378 4.03952 15.4981 4.17567 15.335 4.38519C15.1719 4.59471 15.0987 4.86044 15.1315 5.12393C15.1643 5.38742 15.3005 5.62708 15.51 5.79019L17.08 7.00019H4C3.73478 7.00019 3.48043 7.10555 3.29289 7.29308C3.10536 7.48062 3 7.73497 3 8.00019C3 8.26541 3.10536 8.51976 3.29289 8.7073C3.48043 8.89483 3.73478 9.00019 4 9.00019Z" fill="#1D3557"/>
          <path d="M20.0012 16H7.0012L8.6012 14.8C8.81338 14.6409 8.95365 14.404 8.99115 14.1414C9.02866 13.8789 8.96033 13.6122 8.8012 13.4C8.64207 13.1878 8.40518 13.0476 8.14262 13.0101C7.88007 12.9725 7.61338 13.0409 7.4012 13.2L3.4012 16.2C3.2789 16.2933 3.17977 16.4136 3.11154 16.5515C3.04331 16.6894 3.00781 16.8412 3.00781 16.995C3.00781 17.1488 3.04331 17.3006 3.11154 17.4385C3.17977 17.5764 3.2789 17.6967 3.4012 17.79L7.2612 20.79C7.43575 20.9255 7.65025 20.9993 7.8712 21C8.02392 20.9996 8.17453 20.9643 8.31147 20.8967C8.44841 20.8291 8.56805 20.731 8.6612 20.61C8.82359 20.4015 8.89687 20.1373 8.86502 19.8749C8.83316 19.6126 8.69877 19.3735 8.4912 19.21L6.9212 18H20.0012C20.2664 18 20.5208 17.8946 20.7083 17.7071C20.8958 17.5196 21.0012 17.2652 21.0012 17C21.0012 16.7348 20.8958 16.4804 20.7083 16.2929C20.5208 16.1054 20.2664 16 20.0012 16Z" fill="#1D3557"/>
        </svg>
        <span>Sort by</span>                
      </span>
      <?php endif;?>
      <span class="open-filters-sidebar <?php if($has_filters) echo '_has_active-filter';?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>  
        <span>Filters</span>                
      </span>
    </div>
</div>