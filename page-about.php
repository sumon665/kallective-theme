<?php
/*
Template Name: About
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
    <div class="about-section">
        <p class="about-top"><?php echo __('Empowering Organizations. Rewarding Impact.', 'kallective');?></p>
        <div class="about-header">
        <?php the_content();?>
        </div>
        <?php $content_items = get_field('content_items');?>
        <?php if($content_items):?>
        <div class="about-content">
          <ul class="about-content-list">
            <?php foreach($content_items as $c_item):?>
            <li class="about-content-item">
              <h2><?php echo $c_item['title'];?></h2>
              <p><?php echo $c_item['description'];?></p>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <?php $benefits = get_field('benefits');?>
        <?php if($benefits):?>
        <div class="about-benefits">
          <ul class="about-benefits-list">
            <?php foreach($benefits as $b_item):?>
            <li class="about-benefits-item">
              <h3><?php echo $b_item['title'];?></h3>
              <p><?php echo $b_item['description'];?></p>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <div class="about-social">
        <h4 class="about-social__title"><?php echo __('Follow us on social', 'kallective');?></h4>
        <ul class="footer-social">
            <li>
            <a href="<?php echo get_option('instagram_url');?>" target="_blank" rel="noopener noreferrer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 2H7C4.23858 2 2 4.23858 2 7V17C2 19.7614 4.23858 22 7 22H17C19.7614 22 22 19.7614 22 17V7C22 4.23858 19.7614 2 17 2Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 11.3701C16.1234 12.2023 15.9812 13.0523 15.5937 13.7991C15.2062 14.5459 14.5931 15.1515 13.8416 15.5297C13.0901 15.908 12.2384 16.0397 11.4077 15.906C10.5771 15.7723 9.80971 15.3801 9.21479 14.7852C8.61987 14.1903 8.22768 13.4229 8.09402 12.5923C7.96035 11.7616 8.09202 10.91 8.47028 10.1584C8.84854 9.40691 9.45414 8.7938 10.2009 8.4063C10.9477 8.0188 11.7977 7.87665 12.63 8.00006C13.4789 8.12594 14.2648 8.52152 14.8716 9.12836C15.4785 9.73521 15.8741 10.5211 16 11.3701Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17.5 6.5H17.51" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>                      
            </a>
            </li>
            <li>
            <a href="<?php echo get_option('facebook_url');?>" target="_blank" rel="noopener noreferrer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 2H15C13.6739 2 12.4021 2.52678 11.4645 3.46447C10.5268 4.40215 10 5.67392 10 7V10H7V14H10V22H14V14H17L18 10H14V7C14 6.73478 14.1054 6.48043 14.2929 6.29289C14.4804 6.10536 14.7348 6 15 6H18V2Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>                      
            </a>
            </li>
        </ul>
        </div>
    </div>
</div>
<?php
get_footer();