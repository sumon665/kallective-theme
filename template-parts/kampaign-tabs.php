<?php global $post; ?>
<?php if($post->post_type == 'kampaign' || $post->post_type=='microevent' || $post->post_type=='makeoffer'){ ?>
	<div class="tabs">
		<div class="tabs-header-wrap">
		<div class="tabs-header">
			<div class="tabs-header__toggle visible-mobile">
			Event Info
			</div>
			<ul class="tabs-header-list">
			<li class="tabs-header-list__item active" data-tab="1">Event Info</li>
			<li class="tabs-header-list__item" data-tab="2">Transparency</li>
			<li class="tabs-header-list__item" data-tab="3">Disclaimer</li>
			</ul>
		</div>
		</div>
		<div class="tabs-content">
		<div class="tabs-content__item active" data-tab="1">
			<div class="product-tabs-description">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-info', true));?>
				</div>
			</div>
			</div>
		</div>
		<div class="tabs-content__item" data-tab="2">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-transparency', true));?>
				</div>
			</div>
		</div>
		<div class="tabs-content__item" data-tab="3">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-disclaimer', true));?>
				</div>
			</div>
		</div>
		</div>
	</div>
<?php } elseif($post->post_type=='raffle') { ?>
    <div class="tabs">
		<div class="tabs-header-wrap">
		<div class="tabs-header">
			<div class="tabs-header__toggle visible-mobile">
			Event Info
			</div>
			<ul class="tabs-header-list">
			<li class="tabs-header-list__item active" data-tab="1">Event Info</li>
			<li class="tabs-header-list__item" data-tab="2">Transparency</li>
			<li class="tabs-header-list__item" data-tab="3">Rules</li>
            <li class="tabs-header-list__item" data-tab="4">Disclaimer</li>
			</ul>
		</div>
		</div>
		<div class="tabs-content">
		<div class="tabs-content__item active" data-tab="1">
			<div class="product-tabs-description">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-info', true));?>
				</div>
			</div>
			</div>
		</div>
		<div class="tabs-content__item" data-tab="2">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-transparency', true));?>
				</div>
			</div>
		</div>
        <div class="tabs-content__item" data-tab="3">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-rules', true));?>
				</div>
			</div>
		</div>
        <div class="tabs-content__item" data-tab="4">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-disclaimer', true));?>
				</div>
			</div>
		</div>
		</div>
	</div>
<?php } elseif($post->post_type=='pixelgrid') { ?>
    <div class="tabs">
		<div class="tabs-header-wrap">
		<div class="tabs-header">
			<div class="tabs-header__toggle visible-mobile">
			The Pixel Project
			</div>
			<ul class="tabs-header-list">
			<li class="tabs-header-list__item active" data-tab="1">The Pixel Project</li>
			<li class="tabs-header-list__item" data-tab="2">How It Works</li>
			<li class="tabs-header-list__item" data-tab="3">FAQs</li>
            <li class="tabs-header-list__item" data-tab="4">Official Rules</li>
			</ul>
		</div>
		</div>
		<div class="tabs-content">
		<div class="tabs-content__item active" data-tab="1">
			<div class="product-tabs-description">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-pixelproject', true));?>
				</div>
			</div>
			</div>
		</div>
        <div class="tabs-content__item" data-tab="2">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-pixelhow', true));?>
				</div>
			</div>
		</div>
		<div class="tabs-content__item" data-tab="3">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-pixelfaq', true));?>
				</div>
			</div>
		</div>
        <div class="tabs-content__item" data-tab="4">
			<div class="product-tabs-description-item">
				<div class="product-tabs-description-item__value campaign-tabs_description">
				<?=apply_filters('the_content', get_post_meta($post->ID,'_tab-pixelrules', true));?>
				</div>
			</div>
		</div>
		</div>
	</div>
<?php } ?>