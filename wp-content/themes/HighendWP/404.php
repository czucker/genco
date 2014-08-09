<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php get_header(); ?>


	<!-- BEGIN #main-content -->
	<div id="main-content">
	<div class="container">

		<div class="not-found-box aligncenter">

			<div class="not-found-box-inner">
				<h1 class="extra-large"><?php _e('File not Found', 'hbthemes'); ?></h1>
				<h4 class="additional-desc"><?php _e("Sorry, but we couldn't find the content you were looking for.", "hbthemes"); ?></h4>
				<div class="hb-separator-s-1"></div>
				<a href="<?php echo home_url(); ?>" class="hb-button"><?php _e('Back to our Home', 'hbthemes'); ?></a>
			</div>

			<i class="hb-moon-construction"></i>
		</div>

	</div>
	<!-- END .container -->

	</div>
	<!-- END #main-content -->

<?php get_footer(); ?>