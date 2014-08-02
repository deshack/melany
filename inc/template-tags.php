<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @since 0.5.0
 *
 * @package Melany
 * @subpackage Template Tags
 */

if ( ! function_exists( 'melany_post_thumbnail' ) ) :
/**
 * Display the post thumbnail
 *
 * @since 1.1.0
 *
 * @see the_post_thumbnail() 
 */
function melany_post_thumbnail() {
	if ( is_home() && ! get_theme_mod( 'melany_home_thumb' ) )
		return;

	if ( has_post_thumbnail() )
		the_post_thumbnail( 'post_thumbnail', array( 'class' => 'aligncenter img-rounded' ) );
}
endif; // melany_post_thumbnail()

if ( ! function_exists( 'melany_grid_class' ) ) :
/**
 * Set the correct Bootstrap grid class
 *
 * Currently supports only the #primary element.
 *
 * @since 1.0.0
 */
function melany_grid_class() {
	$base = 'col-md-';

	if ( has_post_format( 'image' ) || is_attachment() )
		$class = $base . '12';
	else
		$class = $base . '9';

	echo $class;
}
endif; // Ends check for melany_grid_class()

if ( ! function_exists( 'melany_edit_post_link' ) ) :
/**
 * Add CSS classes to edit post link
 *
 * @since 1.0.0
 *
 * @param string $output Required. edit_post_link() HTML output.
 * @return string $output - edit_post_link() HTML output with custom CSS classes.
 */
function melany_edit_post_link( $output ) {
	$output = str_replace( 'class="post-edit-link"', 'class="post-edit-link btn btn-default"', $output );
	return $output;
}
add_filter( 'edit_post_link', 'melany_edit_post_link' );
endif;

if ( ! function_exists( 'melany_edit_comment_link' ) ) :
/**
 * Add custom CSS classes to edit_comment_link()
 *
 * @since 1.0.0
 *
 * @param string $output Required. edit_comment_link() HTML output.
 * @return string $output - edit_comment_link() HTML output with custom CSS classes.
 */
function melany_edit_comment_link( $output ) {
	$output = str_replace( 'class="comment-edit-link"', 'class="comment-edit-link btn btn-default"', $output );
	return $output;
}
add_filter( 'edit_comment_link', 'melany_edit_comment_link' );
endif;

if ( ! function_exists( 'melany_cancel_comment_reply_link' ) ) :
/**
 * Customize Cancel Comment Reply link
 *
 * @since 1.0.0
 *
 * @param string $text Required. The output of get_cancel_comment_reply_link().
 * @return string $output - The customized link
 */
function melany_cancel_comment_reply_link( $text ) {
	// $text is a link, we need to extract only the text and save it in $title
	preg_match( '/>(.*)</', $text, $matches );
	$title = $matches[0];
	$title = str_replace( '>', '', $title );
	$title = str_replace( '<', '', $title );
	// Now substitute the text with &times;
	$output = preg_replace( '#\>[^\]]+\<\/a>#', '>&times;</a>', $text );
	// Put $title as value of the title property, then add classes and other useful properties
	$output = str_replace( 'id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="btn btn-danger close tooltip-toggle" data-toggle="tooltip" data-trigger="click hover" title="' . $title . '"', $output );
	return $output;
}
add_filter( 'cancel_comment_reply_link', 'melany_cancel_comment_reply_link' );
endif; // ends check for melany_cancel_comment_reply_link

if ( ! function_exists( 'melany_excerpt_read_more_link' ) ) :
/**
 * Display Read more button below an excerpt
 *
 * @since 0.4
 *
 * @param string $output Required. the_excerpt() HTML output.
 * @return string $output - the_excerpt() HTML output followed by custom readmore button.
 */
function melany_excerpt_read_more_link( $output ){
	global $post;
	return $output . '<div class="clearfix text-center more-button"><a href="' . get_permalink( $post->ID ) . '" class="btn btn-success">' . __( 'Continue reading', 'melany' ) . '</a></div>';
}
add_filter( 'the_excerpt', 'melany_excerpt_read_more_link' );
endif;

if ( ! function_exists( 'melany_page_menu' ) ) :
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
 * @deprecated 1.1.0 Use Bootstrap_Walker::fallback
 * @see Bootstrap_Walker::fallback
 *
 * @param array|string $args
 * @return string html menu
 */
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
			$class = 'class="current_page_item active"';
		$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . '<span class="glyphicon glyphicon-home"></span> ' . $text . $args['link_after'] . '</a></li>';
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

	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$list_args['walker'] = new Bootstrap_Walker;
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

	if ( $menu )
		$menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';

	$menu = apply_filters( 'wp_page_menu', $menu, $args );
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}
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

		<h1 class="sr-only"><?php _e( 'Post navigation', 'melany' ); ?></h1>
		<ul class="pager">
		<?php
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( $previous ) :
				$previous_title = get_the_title( $previous->ID );
				previous_post_link( '<li title="' . $previous_title . '" class="previous tooltip-toggle" data-toggle="tooltip" data-placement="right">%link</li>', __( '&larr; Older', 'melany' ));
			else : ?>
				<li class="previous disabled"><a href="#"><?php printf( __( '&larr; Older', 'melany' )); ?></a></li>
			<?php endif; ?>

			<?php if ( $next ) :
				$next_title = get_the_title( $next->ID );
				next_post_link( '<li title="' . $next_title . '" class="next tooltip-toggle" data-toggle="tooltip" data-placement="left">%link</li>', __( 'Newer &rarr;', 'melany' ) );
			else : ?>
				<li class="next disabled"><a href="#"><?php printf( __( 'Newer &rarr;', 'melany' )); ?></a></li>
			<?php endif; ?>
		</ul>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
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
		echo '<ul class="pagination">';
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
	<li class="post pingback media clearfix">
		<div class="pingback-inner media-body"><h4 class="media-heading"><?php _e( 'Pingback:', 'melany' ); ?></h4> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'melany' ) ); ?></div>
	<?php
			break;
		default :
	?>
	<li <?php comment_class( 'media clearfix' ); ?> id="comment-<?php comment_ID(); ?>">
		<a class="pull-left" href="<?php comment_author_url(); ?>">
			<?php echo get_avatar( $comment, 64 ); ?>
		</a>
		<div class="media-body">
			<div class="media-body-inner">
				<header class="row">
					<hgroup class="col-sm-9">
						<h4 class="media-heading"><?php printf( sprintf( '<cite>%s</cite>', get_comment_author_link() ) ); ?></h4>
						<h6><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'melany' ), get_comment_date(), get_comment_time() ); ?></time></h6>
					</hgroup>
					<div class="col-sm-3">
						<div class="comment-edit-link btn btn-default">
							<?php comment_reply_link( array_merge( $args, array(
									'depth'			=> $depth,
									'max_depth'	=> $args['max_depth'],
								) ) );
							?>
						</div>
						<?php edit_comment_link( __( 'Edit', 'melany' ) ); ?>
					</div>
				</header>
				<?php if ( $comment->comment_approved = '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'melany' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-content"><?php comment_text(); ?></div>
			</div><!-- .media-body-inner -->
		</div><!-- .media-body -->

	<?php
			break;
	endswitch;
}
endif; // ends check for melany_comment()

if ( ! function_exists( 'melany_comment_form_fields' ) ) :
/**
 * Customized comment form fields
 *
 * Adds also X-Autocomplete Fields support
 *
 * @since 1.0.0
 *
 * @param array $fields Required. Default form fields
 * @return array $fields - The new fields
 */
function melany_comment_form_fields( $fields ) {
	$commenter	= wp_get_current_commenter();
	$req				= get_option( 'require_name_email' );
	$aria_req		= ( $req ? ' aria-required="true"' : '' );
	$fields['author']		= '<div class="comment-form-author form-group">' . '<label for="author" class="sr-only">' . __( 'Name', 'melany' ) . '</label>' . '<div class="input-group">' . '<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>'  . '<input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . __( 'Name', 'melany' ) . ( $req ? '*' : '' ) . '" size="30"' . $aria_req . ' x-autocompletetype="name-full" /></div></div>';
	$fields['email']		= '<div class="comment-form-email form-group">' . '<label for="email" class="sr-only">' . __( 'Email', 'melany' ) . '</label>' . '<div class="input-group">' . '<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>' . '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email', 'melany' ) . ( $req ? '*' : '' )  . '" size="30"' . $aria_req . ' x-autocompletetype="email" /></div></div>';
	$fields['url']			= '<div class="comment-form-url form-group">' . '<label for="url" class="sr-only">' . __( 'Website', 'melany' ) . '</label>' . '<div class="input-group">' . '<span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>' . '<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website', 'melany' ) . '" size="30" x-autocompletetype="url" /></div></div>';
	return $fields;
}
add_filter( 'comment_form_default_fields', 'melany_comment_form_fields' );
endif; // ends check for melany_comment_form_fields

if ( ! function_exists( 'melany_get_comment_field' ) ) :
/**
 * Customize comment textarea
 *
 * @since 1.0.0
 */
function melany_get_comment_field() {
	return '<div class="comment-form-comment form-group">' . '<label for="comment" class="sr-only">' . _x( 'Comment', 'noun', 'melany' ) . '</label>' . '<div class="input-group">' . '<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>' . '<textarea id="comment" name="comment" class="form-control" placeholder="' . _x( 'Comment', 'noun', 'melany' ) . '" rows="8"></textarea></div></div>';
}
endif; // ends check for melany_get_comment_field

if ( ! function_exists( 'melany_get_comment_notes_before' ) ) :
/**
 * Customize comment_notes_before comment_form() parameter
 *
 * @since 1.0.0
 */
function melany_get_comment_notes_before() {
	$req = get_option( 'require_name_email' );
	$required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'melany' ), '<span class="required">*</span>' );
	return '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p class="comment-notes">' . __( 'Your email address will not be published.', 'melany' ) . ( $req ? $required_text : '' ) . '</p></div>';
}
endif; // ends check for melany_get_comment_notes_before

if ( ! function_exists( 'melany_get_comment_notes_after' ) ) :
/**
 * Customize comment_notes_after comment_form() parameter
 *
 * @since 1.0.0
 */
function melany_get_comment_notes_after() {
	return '<p class="form-allowed-tags help-block">' . sprintf( __( 'You may use these HTML tags and attributes: %s', 'melany' ), ' <pre>' . allowed_tags() . '</pre>' ) . '</p>';
}
endif; // ends check for melany_get_comment_notes_after

if ( ! function_exists( 'melany_comment_form_logged_in' ) ) :
function melany_comment_form_logged_in( $input ) {
	$output = str_replace( 'class="logged-in-as"', 'class="logged-in-as help-block"', $input );
	return $output;
}
add_filter( 'comment_form_logged_in', 'melany_comment_form_logged_in' );
endif; // ends check for melany_comment_form_logged_in

if ( ! function_exists( 'melany_avatar_class' ) ) :
/**
 * Add CSS classes to avatars
 *
 * @since 1.0.0
 */
function melany_avatar_class( $output ) {
	$output = str_replace( 'class="avatar', 'class="avatar media-object ', $output );
	return $output;
}
add_filter( 'get_avatar', 'melany_avatar_class' );
endif;

if ( ! function_exists( 'melany_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image
 */
function melany_the_attached_image() {
	$post					= get_post();
	$attachment_size		= apply_filters( 'melany_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url	= wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the 
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_post( array(
		'post_parent'			=> $post->post_parent,
		'fields'				=> 'ids',
		'numberposts'			=> -1,
		'post_status'			=> 'inherit',
		'post_type'				=> 'attachment',
		'post_mime_type'		=> 'image',
		'order'					=> 'ASC',
		'orderby'				=> 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current ( $attachment_ids );
				break;
			}
		}

		// Get the URL of the next image attachment
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size, false, array( 'class' => 'aligncenter' ) )
	);
}
endif; // Ends check for melany_the_attached_image

if ( ! function_exists( 'melany_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function melany_posted_on() {
	if ( is_attachment() )
		$metadata = wp_get_attachment_metadata();

	$sticky = '';
	if ( is_sticky() )
		$sticky = '<span class="glyphicon glyphicon-pushpin"></span> ';

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'C' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( $sticky . '<span class="posted-on">' . __( 'Posted on %1$s', 'melany' ) . '</span> <span class="byline">' . __( 'by %2$s', 'melany' ) . '</span>',
		sprintf( '<a href="%1$s" title="%2$s" class="tooltip-toggle" data-toggle="tooltip" data-trigger="click hover" data-placement="bottom" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'melany' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

if ( ! function_exists( 'melany_categorized_blog' ) ) :
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
endif;

if ( ! function_exists( 'melany_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in melany_categorized_blog
 */
function melany_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'melany_category_transient_flusher' );
add_action( 'save_post', 'melany_category_transient_flusher' );
endif;

if ( ! function_exists( 'melany_site_name' ) ) :
/**
 * Break site name if too long
 *
 * Applies to the header bar
 *
 * @author Mirko Pizii
 * @see header.php
 * @param string $text Required. Site title
 * @param int $numchars Optional. Number of characters to display before breaking the name
 */
function melany_site_name( $text, $numchars ) {
	if ( empty( $numchars ) )
		$numchars = 20;

	echo ( strlen($text) > $numchars) ? substr($text, 0, $numchars) . '...' : $text;
}
endif; // Ends check for melany_site_name

if ( ! function_exists( 'melany_header_class' ) ) :
/**
 * Print CSS classes for site header
 *
 * @since 1.0.0
 *
 * @param string $class Optional. Custom CSS classes
 */
function melany_header_class( $custom = '' ) {
	$class = 'site-header navbar navbar-fixed-top';
	$color = get_theme_mod( 'melany_navbar_color' );
	if ( $color == '' || empty( $color ) )
		$color = 'inverse';

	$class .= ' navbar-' . $color;

	if ( ! empty( $custom ) )
		$class .= ' ' . $custom;

	echo 'class="' . $class . '"';
}
endif;

if ( ! function_exists( 'melany_footer_class' ) ) :
/**
 * Print CSS classes for site footer
 *
 * @since 1.0.0
 *
 * @param string $custom Optional. Custom CSS classes
 */
function melany_footer_class( $custom = '' ) {
	$class = 'site-footer navbar';
	$color = get_theme_mod( 'melany_navbar_color' );
	if ( $color == '' || empty( $color ) )
		$color = 'inverse';

	$class .= ' navbar-' . $color;

	if ( 'page' == get_option( 'show_on_front' ) && is_front_page() )
		$class .= ' navbar-fixed-bottom';

	if ( ! empty( $custom ) )
		$class .= ' ' . $custom;

	echo 'class="' . $class . '"';
}
endif;

if ( ! function_exists( 'melany_body_class' ) ) :
/**
 * Custom body classes
 *
 * Filters body_class() function and adds custom classes
 *
 * @since 1.0.0
 *
 * @param array $classes. The body_class() output.
 * @return array $classes. The new classes: body_class() output + custom classes
 */
function melany_body_class($classes) {
	$header_image = get_header_image();
	if ( ! empty($header_image) )
		$classes[] = 'header-image';
	return $classes;
}
add_filter( 'body_class', 'melany_body_class' );
endif;

if ( ! function_exists( 'melany_custom_home_background' ) ) :
/**
 * Custom static homepage background color
 *
 * @since 1.0.0
 */
function melany_custom_home_background() {
	if ( !is_page_template('templates/home.php') )
		return;

	$bg			= get_theme_mod( 'melany_home_background' );
	$color	= get_theme_mod( 'melany_home_color' );
	
	if ( $bg )
		$bg_style = 'body.home.page.page-template-templateshome-php { background-color:' . $bg . '; }';
	else
		$bg_style = '';
	if ( $color )
		$color_style = 'body.home.page.page-template-templateshome-php .jumbotron { color:' . $color . '; }';
	else
		$color_style = '';

	echo '<style type="text/css" id="custom-home-background">' . "\n\t" . $bg_style . "\n\t" . $color_style . "\n</style>\n";
}
add_action( 'wp_head', 'melany_custom_home_background' );
endif;

if ( ! function_exists( 'melany_author_box' ) ) :
/**
 * Display a box with author infos
 *
 * @since 1.0.0
 */
function melany_author_box() {
	if ( ! get_theme_mod( 'melany_author_display', true ) )
		return;

	// Retrieve author info
	$author_name = get_the_author();
	?>

	<section id="author-box" class="media">
		<h2 class="media-heading vcard"><span class="glyphicon glyphicon-user"></span> <?php echo $author_name; ?></h2>
		<a class="pull-left" href="<?php the_author_meta( 'user_url' ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
		</a>
		<div class="media-body">
			<p><?php the_author_meta( 'description' ); ?></p>
		</div><!-- .media-body -->
		<div class="clearfix"></div>
		<?php if ( get_theme_mod( 'melany_author_count', true ) ) : ?>
			<p class="posts-num"><small>
				<span class="glyphicon glyphicon-pencil"> </span>	
				<?php $post_count = get_the_author_posts(); ?>
				<?php if ( $post_count == 1 )
					printf( __( '%1$s wrote 1 post', 'melany' ), get_the_author() );
				else
					printf( __( '%1$s wrote %2$s posts', 'melany' ), get_the_author(), $post_count ); ?>
			</small></p>
		<?php endif; ?>
	</section><!-- #author-box -->

	<?php
}
endif;

if ( ! function_exists( 'melany_logo' ) ) :
/**
 * Output code to display the logo section.
 *
 * @since 1.1
 * @uses get_melany_logo()
 */
function melany_logo( $id ) {
	$class = $id == 'logo' ? ' col-xs-12' : '';
	$html = '
	<section id="' . $id . '" class="site-logo' . $class . '"">
		<div class="thumbnail text-center">
			<div class="caption">
				<h2>' . get_bloginfo( 'name' ) . '</h2>
			</div>
			' . get_melany_logo() . '
			<div class="caption">
				<p>' . get_bloginfo( 'description' ) . '</p>
			</div>
		</div>
	</section>';

	echo $html;
}
endif;

if ( ! function_exists( 'get_melany_logo' ) ) :
/**
 * Get the logo from theme options
 *
 * @since 1.1
 */
function get_melany_logo() {
	$src = get_theme_mod( 'melany_logo' );
	$shape = get_theme_mod( 'melany_logo_shape' );
	if ( isset($shape) && !empty($shape) && $shape !== 'default' )
		$shape = 'class="img-' . $shape . '"';
	else
		$shape = '';
	$title = get_bloginfo( 'name' );
	$output = '';

	if ( $src )
		$output = '<img src="' . $src . '" alt="' . $title . '" ' . $shape . '>';

	return $output;
}
endif;

if ( ! function_exists( 'melany_custom_header' ) ) :
/**
 * Display the custom header image
 *
 * @since 1.1.0
 * @uses melany_get_custom_header()
 */

function melany_custom_header() {
	// Prevent custom header image to be shown on static front page
	if ( ! melany_get_custom_header() || is_page_template('templates/home.php') )
		return;

	echo '<div id="header" class="col-xm-12">';
	echo melany_get_custom_header();
	echo '</div>';
}
add_action( 'melany_header_after', 'melany_custom_header', 5 );
endif;

if ( ! function_exists( 'melany_get_custom_header' ) ) :
/**
 * Get the custom header image
 *
 * @since 1.1.0
 */
function melany_get_custom_header() {
	$header_image = get_header_image();
	$has_url = get_theme_mod( 'melany_header' );

	if ( empty( $header_image ) )
		return;

	$html = '';

	if ( $has_url ) {
		$html = "<a href=\"" . esc_url( home_url( '/' ) ) . "\" rel=\"home\">\n";
		$html .= "\t<img id=\"header-image\" src=\"" . get_header_image() . "\" class=\"aligncenter\" alt=\"" . esc_attr( get_bloginfo( 'name', 'display' ) ) . "\">\n";
		$html .= "</a>";
	} else {
		$html = '<img id="header-image" src="' . get_header_image() . '" class="aligncenter" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
	}

	return $html;
}
endif;

if ( ! function_exists( 'melany_custom_selection_color' ) ) :
/**
 * Customize text selection color via the Theme Customizer.
 *
 * @since 1.1.0
 */
function melany_custom_selection_color() {
	$color = get_theme_mod('melany_selection_color');

	if ( empty($color) )
		return;

	echo '<style type="text/css" id="custom-selection-color">::selection{background:' . $color . ';}</style>';
}
add_action( 'wp_head', 'melany_custom_selection_color' );
endif;

/**
 * Output copyright text
 *
 * @since 1.1.0
 */
function melany_copy() {
	echo melany_get_copyright_text();
}

if ( ! function_exists( 'melany_get_copyright_text' ) ) :
function melany_get_copyright_text() {
	$output = '&copy; ' . date( 'Y' ) . ' ';
	$copy = get_theme_mod( 'melany_copyright' );
	if ( ! empty( $copy ) )
		$output .= $copy;
	else
		$output .= get_bloginfo( 'name' );

	return $output;
}
endif;