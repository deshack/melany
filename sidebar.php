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
					<div class="thumbnail text-center">
						<img src="<?php echo get_theme_mod( 'melany_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<p><?php bloginfo( 'description' ); ?></p>

						<a href="//plus.google.com/<?php echo get_theme_mod( 'melany_plus_icon' ); ?>?prsrc=3" rel="publisher" target="_blank" style="text-decoration:none;">
							<img src="//ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:32px;height:32px;"/>
						</a>
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
