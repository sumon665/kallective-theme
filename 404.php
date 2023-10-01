<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kallective
 */

get_header();
?>

<section class="not-fond-section">
	<div class="wrapper">
		<div class="not-fond-layout">
		<div class="not-fond-layout__txt">
			<h1><?php echo __('Oops!', 'kallective');?></h1>
			<p><?php echo __('Unfortunately, we can not find this page', 'kallective');?></p>
			<a href="/" class="btn-primary"><?php echo __('Back to catalog', 'kallective');?></a>
		</div>
		<div class="not-fond-layout__img">
			<img src="<?php echo get_template_directory_uri( ); ?>/img/icons/404.svg" width="264" height="96" alt="404">
		</div>
		</div>
	</div>
</section>

<?php
get_footer();
