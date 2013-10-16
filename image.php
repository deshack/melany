<?php
/**
 * The template for displaying image attachments.
 *
 * @package Melany
 */

get_header(); ?>

	<section id="primary" class="content-area image-attachment <?php melany_grid_class(); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="page-header entry-header">
					<hgroup class="row">
						<div class="col-sm-10">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</div>
						<div class="col-sm-2">
							<?php edit_post_link( __( 'Edit', 'melany' ) ); ?>
						</div>
					</hgroup>
					<div class="entry-meta">
						<small><?php melany_posted_on();
							printf( __( ' in', 'melany' ) . ' <a href="%1$s" rel="gallery">%2$s</a>',
								esc_url( get_permalink( $post->post_parent ) ),
								get_the_title( $post->post_parent )
							); ?>
						</small>
					</div><!-- .entry-meta -->
				</header>

				<div class="entry-content">
					<div class="entry-attachment">
						<div class="attachment">
							<?php melany_the_attached_image(); ?>
						</div>

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div><!-- .entry-caption -->
						<?php endif; ?>
					</div><!-- .entry-attachment -->

					<?php the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'melany' ),
							'after'  => '</div>'
						) );
					?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->

		<?php endwhile; // end of the loop. ?>

	</section><!-- #primary -->

<?php get_footer(); ?>
