<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Melany
 */
?>
	<aside id="secondary" class="span2" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<article id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</article>

			<article id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'melany' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</article>

			<article id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'melany' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</article>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
