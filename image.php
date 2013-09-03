<?php
/**
 * The template for displaying image attachments.
 *
 * @package Melany
 */

get_header(); ?>

	<section id="primary" class="content-area image-attachment">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-meta">
						<?php
							$metadata = wp_get_attachment_metadata();
							printf( __( 'Published on', 'melany' ) . ' <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> ' . _x( 'at', 'Full-size image', 'melany' ) . ' <a href="%3$s" title="' . __( 'Link to full-size image', 'melany' ) . '">%4$s &times; %5$s</a> ' . __( 'in', 'melany' ) . ' <a href="%6$s" title="' . __( 'Return to %7$s', 'melany' ) . '" rel="gallery">%8$s</a>',
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_url( wp_get_attachment_url() ),
								$metadata['width'],
								$metadata['height'],
								esc_url( get_permalink( $post->post_parent ) ),
								esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
								get_the_title( $post->post_parent )
							);
						edit_post_link( __( 'Edit', 'melany' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->

					<nav role="navigation" id="image-navigation" class="image-navigation">
						<div class="nav-previous"><?php previous_image_link( false, '<span class="meta-nav">&larr;</span> ' . __( 'Previous', 'melany' ) ); ?></div>
						<div class="nav-next"><?php next_image_link( false, __( 'Next', 'melany' ) .'  <span class="meta-nav">&rarr;</span>' ); ?></div>
					</nav><!-- #image-navigation -->
				</header><!-- .entry-header -->

				<div class="entry-content">

					<div class="entry-attachment">
						<div class="attachment">
							<?php melany_the_attached_image(); ?>
						</div><!-- .attachment -->

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div><!-- .entry-caption -->
						<?php endif; ?>
					</div><!-- .entry-attachment -->

					<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'melany' ),
							'after'  => '</div>',
						) );
					?>

				</div><!-- .entry-content -->

				<footer class="entry-meta">
					<?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open
						printf( '<a class="comment-link" href="#respond" title="' . __( 'Post a comment', 'melany' ) . '">' . __( 'Post a comment', 'melany' ) . '</a> ' . __( 'or leave a trackback:', 'melany' ) . ' <a class="trackback-link" href="%s" title="' . __( 'Trackback URL for your post', 'melany' ) . '" rel="trackback">' . __( 'Trackback URL', 'melany' ) . '</a>.', esc_url( get_trackback_url() ) );
					elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open
						printf( __( 'Comments are closed, but you can leave a trackback:', 'melany' ) . ' <a class="trackback-link" href="%s" title="' . __( 'Trackback URL for your post', 'melany' ) . '" rel="trackback">' . __( 'Trackback URL', 'melany' ) . '</a>.', 'melany' ), esc_url( get_trackback_url() ) );
					elseif ( comments_open() && ! pings_open() ) : // Only comments open
						printf( __( 'Trackbacks are closed, but you can', 'melany' ) . ' <a class="comment-link" href="#respond" title="' . __( 'Post a comment', 'melany' ) . '">' . __( 'post a comment', 'melany' ) . '</a>.' );
					elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed
						_e( 'Both comments and trackbacks are currently closed.', 'melany' );
					endif;
					edit_post_link( __( 'Edit', 'melany' ), ' <span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-## -->

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

	</section><!-- #primary -->

<?php get_footer(); ?>
