<h1 class="cabinet-layout__content-title visible-desktop">Credits</h1>
<p class="cabinet-credits-balance">Balance: <?php echo $args['balance'];?> credits</p>
<?php if(!isset($args['transactions']) || empty($args['transactions'])) :?>
<!-- empty start -->
<div class="cabinet-favorites-empty">
    <p class="cabinet-favorites-empty__txt">You have no any credits</p>
    <a href="/credits/" class="btn-primary cabinet-favorites-empty__link">Get started</a>
</div>
<!-- empty end -->
<?php else:?>
<!-- content start -->
<div class="cabinet-credits-content">
    <p class="cabinet-credits-content-label color-light"><b>Transaction history:</b></p>
    <ul class="cabinet-credits-list">
	<?php foreach($args['transactions'] as $transaction):?>
	<?php $date = date_create($transaction->transaction_date); ?>
    <li>
        <div class="cabinet-credits-item">
        <div class="cabinet-credits-item__left">
            <p><?php echo $transaction->transaction_description ? $transaction->transaction_description : "Campaign participating";?> <span class="color-light">(<?php echo date_format($date, 'm/d/Y');?>)</span></p>
            <p>
            <span class="cabinet-credits-item-status <?php echo $transaction->type == 'credits' ? '_completed' : '_denied';?>"><?php echo $transaction->type == 'credits' ? 'Charging' : 'Debiting';?></span>
            </p>
        </div>
        <div class="cabinet-credits-item__right">
            <p>Total Amount</p>
            <p class="cabinet-credits-item-amount"><?php echo $transaction->type == 'debits' ? "-" : "";?><?php echo $transaction->amount;?> credits</p>
        </div>
        </div>
    </li>
	<?php endforeach;?>
    </ul>
</div>
<!-- content end -->
<?php endif;?>