<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Melany
 */
?>
	<section id="secondary" class="span3" role="complementary">

		<aside id="logo">
			<ul class="thumbnails">
				<li class="span12">
					<div class="thumbnail text-center">
						<?php if( get_theme_mod( 'melany_logo' ) ) : ?>
							<img src="<?php echo get_theme_mod( 'melany_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<?php endif; ?>

						<p><?php bloginfo( 'description' ); ?></p>

						<?php # Google+ Icon
							if( get_theme_mod( 'melany_plus_icon' ) ) : ?>
						<span class="social-badge">
							<a href="//plus.google.com/<?php echo get_theme_mod( 'melany_plus_icon' ); ?>?prsrc=3" rel="publisher" target="_blank" style="text-decoration:none;" title="Google+">
								<img src="//ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:32px;height:32px;"/>
							</a>
						</span>
						<?php endif; ?>

						<?php # Facebook Icon
							if( get_theme_mod( 'melany_fb_icon' ) ) : ?>
						<span class="social-badge">
							<a href="//www.facebook.com/<?php echo get_theme_mod( 'melany_fb_icon' ); ?>" target="_blank" title="Facebook">
								<img src="<?php echo get_template_directory_uri(); ?>/img/facebook-icon-32.png" alt="Facebook" />
							</a>
						</span>
						<?php endif; ?>

						<?php # Twitter Icon
							if( get_theme_mod( 'melany_twitter_icon' ) ) : ?>
						<span class="social-badge">
							<a href="//www.twitter.com/<?php echo get_theme_mod( 'melany_twitter_icon' ); ?>" target="_blank" title="Twitter">
								<img src="<?php echo get_template_directory_uri(); ?>/img/twitter-icon-32.png" alt="Twitter" />
							</a>
						</span>
						<?php endif; ?>

						<?php # RSS Icon
							if( get_theme_mod( 'melany_rss_icon' ) ) : ?>
						<span class="social-badge">
							<a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php echo __( 'RSS Feed', 'melany' ); ?>" target="_blank">
								<img src="<?php echo get_template_directory_uri(); ?>/img/rss-icon.png" alt="RSS Feed" />
							</a>
						</span>
						<?php endif; ?>

						<br />

						<?php # Ubuntu Wiki
							if( get_theme_mod( 'melany_ubuntu_wiki' ) ) : ?>
						<span class="social-badge">
							<a href="http://wiki.ubuntu.com/<?php echo get_theme_mod( 'melany_ubuntu_wiki' ); ?>" target="_blank" title="Ubuntu Wiki">
								<img src="<?php echo get_template_directory_uri(); ?>/img/ubuntu-icon.png" alt="Ubuntu" />
							</a>
						</span>
						<?php endif; ?>

						<?php # GitHub Icon
							if( get_theme_mod( 'melany_github_icon' ) ) : ?>
						<span class="social-badge">
							<a href="https://github.com/<?php echo get_theme_mod( 'melany_github_icon' ); ?>" target="_blank" title="GitHub">
								<img src="<?php echo get_template_directory_uri(); ?>/img/github.png" alt="GitHub" />
							</a>
						</span>
						<?php endif; ?>
					</div>
				</li>
			</ul>
		</aside>

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
