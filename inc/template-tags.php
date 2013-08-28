<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Melany
 */

/**
 * Display or retrieve list of pages with optional home link.
 *
 * The arguments are listed below and part of the arguments are for
 * wp_list_pages() function. Check that function for more info on those
 * arguments.
 *
 * sort_column - How to sort the list of pages. Defaults
 * to page title. Use column for posts table.
 * menu_class - Class to use for the div ID which contains
 * the page list. Defaults to 'menu'.
 * echo - Whether to echo list or return it. Defaults to echo.
 * link_before - Text before show_home argument text.
 * link_after - Text after show_home argument text.
 * show_home - If you set this argument, then it will
 * display the link to the home page. The show_home argument really just needs
 * to be set to the value of the text of the link.
 *
 * @since 0.5.6
 *
 * @param array|string $args
 * @return string html menu
 */
if ( ! function_exists( 'melany_page_menu' ) ) :
function melany_page_menu( $args = array() ) {
	$defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_page_menu_args', $args );

	$menu = '';

	$list_args = $args;

	// Show Home in the menu
	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = __('Home', 'melany');
		else
			$text = $args['show_home'];
		$class = '';
		if ( is_front_page() && !is_paged() )
			$class = 'class="current_page_item"';
		$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $list_args['exclude'] ) ) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}
/*
	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );
*/
	if ( $menu )
		$menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';

	$menu = apply_filters( 'wp_page_menu', $menu, $args );
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}
endif;

if ( ! function_exists( 'melany_active_item_class' ) ) :
/**
 * Add Bootstrap support to active menu elements
 *
 * @since 0.5.12
 */
function melany_active_item_class( $classes = array(), $menu_item = false ) {
	if ( in_array( 'current-menu-item', $menu_item->classes ) )
		$classes[] = 'active';

	return $classes;
}
add_filter( 'nav_menu_css_class', 'melany_active_item_class', 10, 2 );
endif;

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

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';
	?>

	<?php if ( is_single() ) : // navigation links for single posts ?>

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

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="pagination pagination-centered <?php echo $nav_class; ?>">
			<?php melany_pagination(); ?>
	</nav>
	<?php endif; ?>
	<?php
}
endif; // melany_content_nav

if ( ! function_exists( 'melany_pagination' ) ) :
/**
 * Paginate page navigation
 *
 * @since 0.5.8
 */
function melany_pagination( $pages = '', $range = 1 ){
	// Calculate the number of items to show
	$showitems = ( $range * 2 ) + 1;

	global $paged;
	if ( empty( $paged) )
		$paged = 1;

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;

		if ( ! $pages )
			$pages = 1;
	}

	if ( 1 != $pages ) {
		echo '<ul class="page-numbers">';
		if ( $paged > 2 && $paged > $range+1 && $showitems < $pages )
			echo '<li><a href="' . get_pagenum_link(1) . '">&laquo;</a></li>';
		if ( $paged > 1 && $showitems < $pages )
			echo '<li>' . get_previous_posts_link( '&lsaquo;' ) . '</li>';
		if ( $paged - $range > 1 && $showitems < $pages )
			echo '<li><a href="' . get_pagenum_link(1) . '">1</a></li>';
		if ( $paged - $range > 2 && $showitems < $pages )
			echo '<li><span class="dots">...</span></li>';

		for ( $i=1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				echo ( $paged == $i ) ? '<li><span class="active">' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
			}
		}

		if ( $paged + $range < $pages - 1 && $showitems < $pages )
			echo '<li><span class="dots">...</span></li>';
		if ( $paged + $range < $pages && $showitems < $pages )
			echo '<li><a href="' . get_pagenum_link( $pages ) . '">' . $pages . '</a></li>';
		if ( $paged < $pages && $showitems < $pages )
			echo '<li>' . get_next_posts_link( '&rsaquo;' ) . '</li>';
		if ( $paged < $pages-1 && $paged + $range - 1 < $pages && $showitems < $pages )
			echo '<li><a href="' . get_pagenum_link( $pages ) . '">&raquo;</a></li>';

		echo "</ul>\n";
	}
}
endif;

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
	<li class="post pingback clearfix">
		<div class="pingback-inner"><span class="lead"><?php _e( 'Pingback:', 'melany' ); ?></span> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'melany' ), '<button class="btn btn-small pull-right">', '</button>' ); ?></div>
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
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date updated" datetime="%3$s">%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'melany' ),
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

function melany_site_name($text = '', $numberchar = 20) {
    echo (strlen($text) > $numberchar) ? substr($text, 0, $numberchar) . '...' : $text;
}
