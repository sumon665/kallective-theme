<h1 class="cabinet-layout__content-title visible-desktop">Campaigns</h1>
<?php if(!isset($args['campaigns']) || empty($args['campaigns'])) :?>
<!-- empty start -->
<div class="cabinet-favorites-empty">
    <p class="cabinet-favorites-empty__txt">You have no any active campaigns yet</p>
    <a href="" class="btn-primary cabinet-favorites-empty__link">Show campaigns</a>
</div>
<!-- empty end -->
<?php endif;?>
<?php $active = [];
$ended = [];
foreach($args['campaigns'] as $c){
	$campaign = get_post( $c->kampaign );
	$campaign->claimed = $c->amount;
	$collected = get_post_meta($c->kampaign, '_organization-collected', true);
	$goal = get_post_meta($c->kampaign, '_organization-goal', true);
	if($collected < $goal){
		$active[] = $campaign;
	} else {
		$ended[] = $campaign;
	}
}
?>
<!-- content start -->
<div class="cabinet-campaigns-content">
	<?php if(count($active)):?>
    <p class="cabinet-campaigns-content-label color-light"><b>Active campaigns</b></p>
    <ul class="cabinet-campaigns-list">
	<?php foreach($active as $act_campaign):?>
	<?php
		$collected = get_post_meta($act_campaign->ID, '_organization-collected', true);
		$goal = get_post_meta($act_campaign->ID, '_organization-goal', true);
		$percent = $collected / $goal * 100;
	?>
    <li>
        <div class="cabinet-campaigns-item">
        <h2 class="cabinet-campaigns-item__title"><?php echo $act_campaign->post_title;?></h2>
        <div class="cabinet-campaigns-item-goal">
            <p class="cabinet-campaigns-item-goal__title">Campaign Goal</p>
            <p class="cabinet-campaigns-item-goal__credits"><?php echo $collected;?> / <?php echo $goal;?> credits</p>
            <div class="cabinet-campaigns-item-goal-progress">
            <i style="width: <?php echo $percent;?>%;"></i>
            </div>
        </div>
        <p class="cabinet-campaigns-item__info">
            <b class="color-light">Status:</b>
            <span class="cabinet-campaigns-item-status _active">Active</span>
        </p>
        <p class="cabinet-campaigns-item__info">
            <b class="color-light">You contributed: </b> <?php echo $act_campaign->claimed;?> credits
        </p>
        </div>
    </li>
	<?php endforeach;?>
    </ul>
	<?php endif;?>
	<?php if(count($ended)):?>
    <p class="cabinet-campaigns-content-label color-light"><b>Ended campaigns</b></p>
    <ul class="cabinet-campaigns-list">
	<?php foreach($ended as $end_campaign):?>
	<?php 
		$collected = get_post_meta($end_campaign->ID, '_organization-collected', true);
		$goal = get_post_meta($end_campaign->ID, '_organization-goal', true);
		$status = "Giveaway started";
		$sold = get_post_meta($end_campaign->ID, '_giveaway-sold', true);
		if($sold) $status = "Giveaway sold";
	?>
    <li>
        <div class="cabinet-campaigns-item">
        <h2 class="cabinet-campaigns-item__title"><?php echo $end_campaign->post_title;?></h2>
        <div class="cabinet-campaigns-item-goal">
            <p class="cabinet-campaigns-item-goal__title">Campaign Goal</p>
            <p class="cabinet-campaigns-item-goal__credits"><?php echo $collected;?> / <?php echo $goal;?> credits</p>
            <div class="cabinet-campaigns-item-goal-progress">
            <i style="width: 100%;"></i>
            </div>
        </div>
        <p class="cabinet-campaigns-item__info">
            <b class="color-light">Status:</b>
            <span class="cabinet-campaigns-item-status"><?php echo $status;?></span>
        </p>
        <p class="cabinet-campaigns-item__info">
            <b class="color-light">You contributed: </b><?php echo $end_campaign->claimed;?> credits
        </p>
        </div>
    </li>
	<?php endforeach;?>
    </ul>
	<?php endif;?>
</div>
<!-- content end -->