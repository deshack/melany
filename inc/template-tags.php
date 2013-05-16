<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Melany
 */

if ( ! function_exists( 'melany_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function melany_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>

	<?php if ( is_single() ) : // navigation links for single posts ?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'melany' ); ?></h1>
		<ul class="pager">
		<?php
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( $previous ) :
				previous_post_link( '<li class="previous">%link</li>', _x( '&larr;', 'Previous post link', 'melany' ) . __( ' Older', 'melany' ));
			else : ?>
				<li class="previous disabled"><a href="#"><?php printf( __( '&larr; Older', 'melany' )); ?></a></li>
			<?php endif; ?>

			<?php if ( $next ) :
				next_post_link( '<li class="next">%link</li>', __( 'Newer ', 'melany' ) . _x( '&rarr;', 'Next post link', 'melany' ) );
			else : ?>
				<li class="next disabled"><a href="#"><?php printf( __( 'Newer &rarr;', 'melany' )); ?></a></li>
			<?php endif; ?>
		</ul>
	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="pagination pagination-centered <?php echo $nav_class; ?>">
			<?php
				$total_pages = $wp_query->max_num_pages;
				$current_page = max(1, get_query_var( 'paged' ));
				echo paginate_links( array(
					'format' => '/page/%#%',
					'current' => $current_page,
					'total' => $total_pages,
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
					'mid_size' => 1,
					'type' => 'list',
				)); ?>
	<?php endif; ?>
	<?php
}
endif; // melany_content_nav

if ( ! function_exists( 'melany_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function melany_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'melany' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'melany' ), '<div class="btn btn-small pull-right">', '</div>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="clearfix comment-inner">
				<header>					<div class="lead clearfix">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( sprintf( '<cite>%s</cite>', get_comment_author_link() ) ); ?>
					<span class="muted"> - <time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'melany' ), get_comment_date(), get_comment_time() ); ?>
					</time></span>
					<?php melany_edit_comment_link( __( 'Edit', 'melany' ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'melany' ); ?></em>
					<br />
				<?php endif; ?>
			</header>

			<div class="comment-content"><?php comment_text(); ?></div>

			<?php
				melany_comment_reply_link( array_merge( $args,array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				) ) );
			?>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for melany_comment()

if ( ! function_exists( 'melany_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function melany_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'melany' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'melany' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;
/**
 * Returns true if a blog has more than 1 category
 */
function melany_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so melany_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so melany_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in melany_categorized_blog
 */
function melany_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'melany_category_transient_flusher' );
add_action( 'save_post', 'melany_category_transient_flusher' );
