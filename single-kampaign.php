<?php
	get_header();
	$M = get_post_meta($post->ID);
	$M = array_map(function($x){ return $x[0]; }, $M);


	if($post->post_type == 'kampaign' || $post->post_type=='microevent'){
		$startsIn = get_post_meta($post->ID, '_giveaway_starts', true) ?: 0;
		if($startsIn>0 && $startsIn<time()){
			update_post_meta($post->ID, '_giveaway_active', 1);
			$is_sitewide = get_post_meta($post->ID, '_product-id') == -1;
			if($is_sitewide){
				create_store_coupon($post->ID);
			}
		}
		
		
		
	} else {
		$startTime = raffle_startTime($post->ID);
		$raffleActive = get_post_meta($post->ID, '_giveaway_active', true) == 1;
		$raffleSold = get_post_meta($post->ID, '_giveaway_sold', true) == 1;
		if($startTime<=time() && !$raffleActive && !$raffleSold){
			update_post_meta($post->ID, '_giveaway_active', 1);
			$raffleActive = 1;
		}
	}

	if( in_array($post->post_type, ['kampaign', 'microevent', 'makeoffer']) ){
		$startTime = event_limitTime( $M, true );
		if($startTime != false && $startTime<0 && isset($M['_giveaway-showcase']) && $M['_giveaway-showcase'] == 1){
			do_action('kampaign_showcase_off', $post->ID);

			/* Update meta */
			$M = get_post_meta($post->ID);
			$M = array_map(function($x){ return $x[0]; }, $M);
		}
	}

	

	$O = get_post( get_post_meta($post->ID, '_organization-id', true) ?: 0);

	$limitTime = event_limitTime( $M );
	$isExpired = isset($M['_event-expired']) ? ($M['_event-expired'] == 1) : false;
	if(!$isExpired && $limitTime !== false && $limitTime < 0){
		do_action('kampaign_time_limit_reached', $post->ID);
		$M = get_post_meta($post->ID);
		$M = array_map(function($x){ return $x[0]; }, $M);
	}

    //actionbox buttons
    $buttons = get_k_buttons($post);
	$showRaised = true;
	$className = "kpt_{$post->post_type}";
	if(class_exists("$className")){
		$showRaised = $className::showRaised($post->ID);
	}

	$activeButtons = 0;
	foreach($buttons as &$singleButton){
		if(preg_match('/active/', $singleButton->class))
			$activeButtons++;
		if(preg_match('/soon/', $singleButton->class))
			$singleButton->attr = "disabled";
	}

	$clockData = get_clock_data($post);

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
    <div class="product-layout">
          <div class="product-layout-info">
            <div class="product-details__name hidden-desktop"><?php the_title();?></div>
            <div class="campaign-goal hidden-desktop">
              <p>
                <b>Impact Goal: <span class="color-accent"><?php echo format_kampaign_usd(get_post_meta($post->ID, '_organization-goal',true));?></span></b>
              </p>
            </div>
            <div class="product-layout-info__img">
              <div class="product-gallery-wrap">
                <div class="campaign-img">
                  <img src="<?php echo wp_get_attachment_image_src( get_post_meta($post->ID, '_thumbnail_id', true), 'full' )[0];?>" alt="">
                </div>
              </div>
            </div>
            <div class="product-layout-info__desc">
              <div class="product-details">
                <h1 class="product-details__name visible-desktop"><?php the_title();?></h1>
                <p class="campaign-goal visible-desktop">
                  <b>Impact Goal: <span class="color-accent"><?php echo format_kampaign_usd(get_post_meta($post->ID, '_organization-goal',true));?></span></b>
                </p>
                <div class="campaign-description">
                  <?php echo $post->post_content;?>
                </div>
                <div class="campaign-sponsor">
                  <div class="campaign-sponsor__logo">
                    <img src="<?php echo get_the_post_thumbnail_url($O->ID, 'full'); ?>" alt="sponsor">
                  </div>
                  <div class="campaign-sponsor__info">
                    <p class="color-light">Supports</p>
                    <p class="campaign-sponsor__info-value"><?php echo $O->post_title;?></p>
                  </div>
                </div>
                <div class="campaign-details">
                  <?php if($showRaised === 2):?>
                  <div class="campaign-finished-img">
                    <img src="<?php echo get_template_directory_uri();?>/img/icons/partying-face.svg" width="104" height="104" alt="partying-face">
                  </div>
                  <?php endif;?>
                  <div class="campaign-amount">
                    <p>
                    <?php if($showRaised==2 && $post->post_type=='makeoffer')
                        echo "Total Raised + Offers";
                      else
                        echo "Amount Raised";
                    ?>
                    </p>
                    <p class="campaign-amount__value"><?php echo format_kampaign_usd(get_post_meta($post->ID, '_organization-collected', true));?></p>
                    <p class="color-light">of <?php echo format_kampaign_usd(get_post_meta($post->ID, '_organization-goal', true));?> Goal</p>
                  </div>
                  <?php if($post->post_type == 'makeoffer' && $activeButtons){ ?>
                        <div class="actionBox-input offer">
                            <label>$</label>
                            <input type="number" placeholder="Make an offer" />
                        </div>
                  <?php } ?>
                  <div class="campaign-countdown-wrap kampaign-clock"  data-seconds="<?=$clockData->time?>" data-increment="<?=$clockData->increment?>" data-now="<?=time()?>">
                    <p class="campaign-countdown-title"><?=$clockData->title?></p>
                    <div class="campaign-countdown numbers">
                      <div class="campaign-countdown-item ">
                        <span class="d">00</span>
                        <p class="color-light">Days</p>
                      </div>
                      <div class="campaign-countdown-item">
                        <span class="h">00</span>
                        <p class="color-light">Hrs</p>
                      </div>
                      <div class="campaign-countdown-item">
                        <span class="m">00</span>
                        <p class="color-light">Mins</p>
                      </div>
                      <div class="campaign-countdown-item">
                        <span class="s">00</span>
                        <p class="color-light">Secs</p>
                      </div>
                    </div>
                  </div>
                  <div class="campaign-actions">
                  <?php
                        foreach($buttons as $singleButton){
                            if($activeButtons==1 && !preg_match('/active/', $singleButton->class))
                                continue;
                            echo "<button ".(isset($singleButton->attr) ? $singleButton->attr : '')." ".(isset($singleButton->id) ? "id='{$singleButton->id}'" : "")." class='full {$singleButton->class} btn-primary'>{$singleButton->text}</button>";
                        }
                    ?>
                  </div>
                  <div class="campaign-hiw-wrap">
                    <div class="campaign-hiw-trigger">
                      <p class="campaign-hiw-txt color-light">
                        <i class="icon icon-info"></i>
                        How it works
                      </p>
                      <div class="campaign-hiw-tooltip">
                        <div class="campaign-hiw-tooltip__title">How it works</div>
                        <p class="campaign-hiw-tooltip__desc">
                          Participants use their Event Credits to contribute and gain access to our Giveaway Events.<br/><br/>
                          1 credit = $1 donated to charity<br/><br/>
                          Participants can input their desired contribution amount by entering the number of credits they wish to use. On the checkout screen, participants can confirm their contribution and complete the checkout process.<br/><br/>
                          Once the Campaign has reached the Event Goal, all participants will be emailed informing them of when the Giveaway Event begins. Make sure you’re there before the event begins as all inventory is available on a first-come, first-served basis.
                          
                        </p>
                        <p class="campaign-hiw-tooltip__note">
                          <?php echo isset($M['_short-disclaimer']) ? $M['_short-disclaimer'] : 'This event is not sponsored, endorsed, or affiliated with Apple or its affiliates.';?>        
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="campaign-note color-light">*<?php echo isset($M['_short-disclaimer']) ? $M['_short-disclaimer'] : 'This event is not sponsored, endorsed, or affiliated with Apple or its affiliates.';?> </p>
              </div>
            </div>
          </div>
          <div class="product-tabs">
          <?php
                if(get_post_meta($post->ID, '_hide-tabs', true) != 1)
                    get_template_part( 'template-parts/kampaign', 'tabs' );
            ?>
          </div>
        </div>
</div>
<div class="kampaign-modal" data-id="<?=$post->ID?>">
    <div class="kampaign-modal-inner">
        <div class="kampaign-modal-close">&times;</div>
        <?php
            $bal = get_wallet_balance( get_current_user_id() );

            if(!is_user_logged_in()){
                include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/login.php");
            } else if($post->post_type == 'kampaign' || $post->post_type=='microevent'){
                $canContribute = $M['_organization-collected'] < $M['_organization-goal'];
                if($canContribute){
                    if($bal < 1)
                        include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/not_enough_credits.php");
                    else
                        include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/contribute.php");
                } else {
                    if(!check_contribution($post->ID, get_current_user_id()))
                        include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/not_eligible.php");
                    else
                        include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/checkout.php");
                }
            } else {
                $raffleActive = $M['_giveaway_active'] == 1;
                $raffleSold = $M['_giveaway_sold'] == 1;
                if($raffleActive && !$raffleSold){
                    if($bal < 1)
                        include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/not_enough_credits.php");
                    else
                        include_once(WP_PLUGIN_DIR . "/kampaigns/template/modals/contribute.php");
                }
            }
        ?>
    </div>
</div>
<?php
get_footer();