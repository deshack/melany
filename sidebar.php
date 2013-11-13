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
				if ( ! has_post_format( 'image' ) ) : ?>
				<section id="logo-sidebar">
					<div class="thumbnail text-center">
						<div class="caption">
							<h2><?php bloginfo( 'name' ); ?></h2>
						</div>
						<?php if ( get_theme_mod( 'melany_logo' ) ) : ?>
							<img src="<?php echo get_theme_mod( 'melany_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<?php endif; ?>
						<div class="caption">
							<p><?php bloginfo( 'description' ); ?></p>
						</div>
					</div>
				</section>
			<?php endif; // has_post_format( 'image' ) ?>
		<?php endif; // !is_front_page() || is_home() ?>

		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
		<?php endif; // end sidebar widget area ?>
	</section><!-- #secondary -->
