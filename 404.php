<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Melany
 */

get_header(); ?>

	<section id="primary" class="content-area col-md-12" role="main">

		<article id="post-0" class="error404 not-found">
			<header class="page-header entry-header">
				<h1 class="entry-title text-center"><?php _e( 'Oops! That page can&rsquo;t be found.', 'melany' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<img src="<?php echo get_template_directory_uri() . '/img/404.png'; ?>" class="aligncenter img-rounded" alt="404">
				<p class="text-center"><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'melany' ); ?></p>

				<section id="widgets404">
					<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
						<div class="input-group">
							<label class="sr-only"><?php _e( 'Search:', 'melany' ); ?></label>
							<input type="search" id="s" name="s" class="form-control" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( __('Search&hellip;', 'melany') ); ?>" />
							<span class="input-group-btn">
								<button type="submit" for="s" class="btn btn-success">
									<span class="sr-only"><?php _e( 'Search', 'melany' ); ?></span>
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</form>

					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" class="btn btn-success btn-lg btn-block"><?php _e( 'Back to home', 'melany' ); ?></button>
						</div>
					</div><!-- .row -->
				</section><!-- #widgets404 -->

			</div><!-- .entry-content -->
		</article><!-- #post-0 .post .error404 .not-found -->

	</section><!-- #primary -->

<?php get_footer(); ?>
