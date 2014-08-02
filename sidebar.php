<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Melany
 */
?>
	<section id="secondary" class="widget-area col-md-3" role="complementary">
		<?php if ( ! is_page_template('templates/home.php') || is_home() ) : ?>
			<?php // Prevent logo section to be shown on image post format
				if ( ! has_post_format( 'image' ) )
					melany_logo( 'logo-sidebar' ); ?>
		<?php endif; // !is_front_page() || is_home() ?>

		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
		<?php endif; // end sidebar widget area ?>
	</section><!-- #secondary -->
