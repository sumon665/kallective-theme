<?php get_header(); ?>
    <?php if( have_rows('slider')  && !get_query_var('page')): ?>
      <section class="home-slider-section">
          <div class="home-slider">
          <?php while( have_rows('slider') ): the_row(); 
              $image = get_sub_field('image');
              ?>
              <div class="home-slider__item">
                <div class="wrapper">
                  <div class="home-slide-layout">
                    <div class="home-slide-layout__txt">
                      <h2><?php the_sub_field('heading'); ?></h2>
                      <p><?php the_sub_field('description'); ?></p>
                      <a href="<?php the_sub_field('link'); ?>" class="btn-primary"><?php echo __('Shop now', 'kallective');?></a>
                    </div>
                    <div class="home-slide-layout__img">
                      <img src="<?php echo $image['sizes']['large'];?>" alt="">
                    </div>
                  </div>
                </div>
              </div>
          <?php endwhile; ?>
          </div>
      </section>
    <?php endif; ?>
      <section class="goods-section">
        <div class="wrapper">
          <?php get_template_part('template-parts/searchbar', 'products'); ?>
          <div class="special-tiles-slider hidden-desktop">
            <div class="goods-grid-item special">
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
            <div class="goods-grid-item special">
              <div class="product-tile special-tile">
                <a href="/new-arrivals/" class="product-tile-top">
                  <span class="product-tile__img">
                    <img src="<?php echo get_template_directory_uri( );?>/img/girl.png" alt="">
                  </span>
                  <span class="product-tile-special-txt">
                    <?php echo __('New collections', 'kallective');?>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <?php 
          $paged = (isset($_GET['pagination'])) ? absint($_GET['pagination']) : 1;
          $products = wc_get_products([
            'status' => 'publish',
            'paginate' => true,
            'page' => $paged,
            'limit' => 12,
            'type' => ['external', 'grouped', 'simple', 'variable'],
            'nyp' => 'no',
            'ordby' => 'shwi',
            'visibility' => 'visible'
          ]); 
          $cnt = 0;
          ?>
          <ul class="goods-grid">
            <?php foreach($products->products as $product):  
                $post_object = get_post($product->get_id());
                setup_postdata($GLOBALS['post'] =& $post_object);
                $cnt++;
                ?>
                <li class="goods-grid-item">
                    <?php get_template_part('template-parts/card', 'product'); ?>
                </li>
                <?php if($cnt == 2 && $paged == 1): ?>
                  <li class="goods-grid-item special">
                    <div class="product-tile special-tile">
                      <a href="/new-arrivals/"  class="product-tile-top">
                        <span class="product-tile__img">
                          <img src="https://oneteam.com.ua/files/product-photos/ee6255.jpg" alt="">
                        </span>
                        <span class="product-tile-special-txt">
                          <?php echo __('New arrivals', 'kallective');?>
                        </span>
                      </a>
                    </div>
                  </li>
                <?php elseif($cnt == 6 && $paged == 1) : ?>
                  <li class="goods-grid-item special">
                    <div class="product-tile special-tile">
                      <a href="/new-arrivals/"  class="product-tile-top">
                        <span class="product-tile__img">
                          <img src="<?php echo get_template_directory_uri( );?>/img/girl.png" alt="">
                        </span>
                        <span class="product-tile-special-txt">
                          <?php echo __('New collections', 'kallective');?>
                        </span>
                      </a>
                    </div>
                  </li>
                <?php endif; ?>
            <?php endforeach;
            wp_reset_postdata();
            ?>
          </ul>
          <div class="pagination-section">
            <?php if($products->max_num_pages != get_query_var( 'page' )) : ?>
            <button type="button" class="btn-secondary-outline"><?php echo __('Load more items', 'kallective');?></button>
            <?php endif; ?>
            <?php if (function_exists("kallective_paginate_links")) {
                echo kallective_paginate_links( [
                    'type' => 'list',
                    'current' => max( 1, $_GET['pagination'] ),
                    'total'   => $products->max_num_pages,
					'format' => '?pagination=%#%'
                ] );
            } ?>
          </div>
        </div>
      </section>
    
    <?php get_footer(); ?>