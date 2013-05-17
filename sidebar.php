<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Melany
 */
?>
	<section id="secondary" class="span3" role="complementary">
		<?php if( get_theme_mod( 'melany_logo' )) : ?>
		<aside id="logo">
			<ul class="thumbnails">
				<li class="span12">
					<div class="thumbnail">
						<img src="<?php echo get_theme_mod( 'melany_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<p class="text-right"><?php bloginfo( 'description' ); ?></p>
					</div>
				</li>
			</ul>
		</aside>
		<?php endif; ?>
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h3 class="widget-title"><?php _e( 'Archives', 'melany' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h3 class="widget-title"><?php _e( 'Meta', 'melany' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</section><!-- #secondary -->
