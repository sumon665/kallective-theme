<?php
/*
Template Name: Contact Us
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
    <div class="contact-section">
          <h1 class="contact-top"><?php echo __('Drop us a line', 'kallective');?></h1>
          <div class="contact-emails">
            <h2><?php echo __('Email Us', 'kallective');?></h2>
            <div class="contact-emails-row">
              <div class="contact-emails-col">
                <span class="contact-emails-col__label"><?php echo __('Member Inquiries', 'kallective');?></span>
                <a href="mailto:<?php echo get_option('members_email');?>" class="contact-emails-col__value"><?php echo get_option('members_email');?></a>
              </div>
              <div class="contact-emails-col">
                <span class="contact-emails-col__label"><?php echo __('Partnership Inquiries', 'kallective');?></span>
                <a href="mailto:<?php echo get_option('partnership_email');?>" class="contact-emails-col__value"><?php echo get_option('partnership_email');?></a>
              </div>
              <div class="contact-emails-col">
                <span class="contact-emails-col__label"><?php echo __('Become A Vendor', 'kallective');?></span>
                <a href="mailto:<?php echo get_option('vendor_email');?>" class="contact-emails-col__value"><?php echo get_option('vendor_email');?></a>
              </div>
            </div>
          </div>
          <div class="contact-form-section">
            <h2 class="contact-form-section__title"><?php echo __('Message us', 'kallective');?></h2>
            <p class="contact-form-section__txt"><?php echo __('Interested in working with us, or have a question about our marketplace? Go ahead and drop us a line and we’ll get back to you soon.', 'kallective');?></p>
            <?php echo do_shortcode('[contact-form-7 id="5" title="Contact form"]');?>
          </div>
        </div>
</div>
<?php
get_footer();