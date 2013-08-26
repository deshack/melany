<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Melany
 */

get_header(); ?>

	<section id="primary" class="content-area col-md-9" role="main">

		<article id="post-0" class="error404 not-found">
			<header class="page-header">
				<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'melany' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'melany' ); ?></p>

			<section id="widgets404">
				<div class="row">
					<article class="col-md-6">
						<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
					</article>

					<article class="col-md-6">
						<?php if ( melany_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
						<div class="widget widget_categories">
							<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'melany' ); ?></h2>
							<ul>
							<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								) );
							?>
							</ul>
						</div><!-- .widget -->
						<?php endif; ?>
					</article>
				</div>
				<div class="row">
					<article class="col-md-6">
						<?php
						/* translators: %1$s: smiley */
						$archive_content = '<div><p>' . sprintf( __( 'Try looking in the monthly archives.', 'melany' )) . '</p></div>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
						?>
					</article>

					<article class="col-md-6">
						<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
					</article>
				</div>
			</section>

			</div><!-- .entry-content -->
		</article><!-- #post-0 .post .error404 .not-found -->

	</section><!-- #primary -->

<?php get_footer(); ?>
