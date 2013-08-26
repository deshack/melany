<?php
/**
 * Melany functions and definitions
 *
 * @package Melany
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
if( get_theme_mod( 'melany_infinite_scroll' )) :
	require( get_template_directory() . '/inc/jetpack.php' );
endif;

if ( ! function_exists( 'melany_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function melany_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Bootstrap Walker
	 */
	require( get_template_directory() . '/inc/bootstrap-walker.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Melany, use a find and replace
	 * to change 'melany' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'melany', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'melany' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // melany_setup
add_action( 'after_setup_theme', 'melany_setup' );

if ( !function_exists( 'melany_editor_styles' ) ) :
/**
 * Add support to custom stylesheet via WordPress Editor Style
 * built-in function.
 *
 * @since 0.5.4
 */
function melany_editor_styles() {
	add_editor_style( 'css/custom-style.css' );
}
endif;
add_action( 'init', 'melany_editor_styles' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @since 0.1
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function melany_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'melany_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_theme_support( 'custom-background', array( $args['default-color'], $args['default-image'] ) );
	}
}
add_action( 'after_setup_theme', 'melany_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function melany_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'melany' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'Melany_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function melany_scripts() {
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '2.3.1' );
	wp_enqueue_style( 'boostrap-select-style', get_template_directory_uri() . '/css/bootstrap-select.min.css', array( 'bootstrap-style' ) );
	wp_enqueue_style( 'melany-style', get_stylesheet_uri(), array( 'bootstrap-style' ) );
	wp_enqueue_style( 'bootstrap-responsive', get_template_directory_uri() . '/css/bootstrap-responsive.min.css', array( 'melany-style' ), '2.3.1' );
	wp_enqueue_style( 'melany-responsive', get_template_directory_uri() . '/css/responsive.css', array( 'bootstrap-responsive' ) );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '2.3.1', true );
	wp_enqueue_script( 'bootstrap-select', get_template_directory_uri() . '/js/bootstrap-select.min.js', array( 'bootstrap' ), '20130510', true );

	wp_enqueue_script( 'Melany-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'Melany-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'Melany-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'melany_scripts' );

/**
 * Fix "category tag" bad value error
 */
function add_nofollow_cat( $text ) {
	$text = str_replace( 'rel="category tag"', "", $text );
	return $text;
}
add_filter( 'the_category', 'add_nofollow_cat' );

/**
 * Display the post content.
 *
 * @since 0.1
 *
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 */
function melany_the_content($more_link_text = null, $stripteaser = false) {
	$content = melany_get_the_content($more_link_text, $stripteaser);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	echo $content;
}

/**
 * Retrieve the post content.
 *
 * @since 0.1
 *
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 * @return string
 */
function melany_get_the_content( $more_link_text = null, $stripteaser = false ) {
	global $more, $page, $pages, $multipage, $preview;

	$post = get_post();

	if ( null === $more_link_text )
		$more_link_text = __( '(more...)', 'melany' );

	$output = '';
	$hasTeaser = false;

	// If post password required and it doesn't match the cookie.
	if ( post_password_required() )
		return get_the_password_form();

	if ( $page > count($pages) ) // if the requested page doesn't exist
		$page = count($pages); // give them the highest numbered page that DOES exist

	$content = $pages[$page-1];
	if ( preg_match('/<!--more(.*?)?-->/', $content, $matches) ) {
		$content = explode($matches[0], $content, 2);
		if ( !empty($matches[1]) && !empty($more_link_text) )
			$more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));

		$hasTeaser = true;
	} else {
		$content = array($content);
	}
	if ( (false !== strpos($post->post_content, '<!--noteaser-->') && ((!$multipage) || ($page==1))) )
		$stripteaser = true;
	$teaser = $content[0];
	if ( $more && $stripteaser && $hasTeaser )
		$teaser = '';
	$output .= $teaser;
	if ( count($content) > 1 ) {
		if ( $more ) {
			$output .= '<span id="more-' . $post->ID . '"></span>' . $content[1];
		} else {
			if ( ! empty($more_link_text) )
				$output .= apply_filters( 'the_content_more_link', ' <div class="clearfix"></div><a href="' . get_permalink() . "#more-{$post->ID}\" class=\"btn btn-large btn-primary pull-right\">$more_link_text</a>", $more_link_text );
			$output = force_balance_tags($output);
		}

	}
	if ( $preview ) // preview fix for javascript bug with foreign languages
		$output =	preg_replace_callback('/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output);

	return $output;
}

/**
 * Display Read more button below an excerpt
 *
 * @since 0.4
 */
function excerpt_read_more_link( $output ){
	global $post;
	return $output . '<div class="clearfix more-button"><a href="' . get_permalink( $post->ID ) . '" class="btn btn-large btn-primary">' . __( 'Continue reading', 'melany' ) . '</a></div>';
}
add_filter( 'the_excerpt', 'excerpt_read_more_link' );

/**
 * Display or retrieve edit comment link with formatting.
 *
 * @since 0.1
 *
 * @param string $link Optional. Anchor text.
 * @param string $before Optional. Display before edit link.
 * @param string $after Optional. Display after edit link.
 * @return string|null HTML content, if $echo is set to false.
 */
function melany_edit_comment_link( $link = null, $before = '', $after = '' ) {
	global $comment;

	if ( !current_user_can( 'edit_comment', $comment->comment_ID ) )
		return;

	if ( null === $link )
		$link = __( 'Edit This', 'melany' );

	$link = '<a class="btn btn-small pull-right" href="' . get_edit_comment_link( $comment->comment_ID ) . '" title="' . esc_attr__( 'Edit comment' ) . '">' . $link . '</a>';
	echo $before . apply_filters( 'melany_edit_comment_link', $link, $comment->comment_ID ) . $after;
}

/**
 * Outputs a complete commenting form for use within a template.
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comment_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comment_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @since 0.1
 * @param array $args Options for strings, fields etc in the form
 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function melany_comment_form( $args = array(), $post_id = null ) {
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<div class="control-group">' . '<label for="author" class="control-label">' . ( $req ? '<span class="badge badge-important">*</span> ' : '' ) . __( 'Name', 'melany' ) . '</label> ' .
		            '<div class="controls"><div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div></div>',
		'email'  => '<div class="control-group"><label for="email" class="control-label">' . ( $req ? '<span class="badge badge-important">*</span> ' : '' ) . __( 'Email', 'melany' ) . '</label> ' .
		            '<div class="controls"><div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div></div>',
		'url'    => '<div class="control-group"><label for="url" class="control-label">' . __( 'Website', 'melany' ) . '</label>' .
		            '<div class="controls"><div class="input-prepend"><span class="add-on"><i class="icon-home"></i></span><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div></div>',
	);

	$required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'melany' ), '<span class="badge badge-important">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<div class="control-group"><label for="comment" class="control-label">' . _x( 'Comment', 'noun', 'melany' ) . '</label><div class="controls"><div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></div></div>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="alert">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>' . __( 'Your email address will not be published.', 'melany' ) . ( $req ? $required_text : '' ) . '</div>',
		'comment_notes_after'  => '<p class="alert alert-info">' . sprintf( __( 'You may use these <abbr class="initialism" title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <pre>' . allowed_tags() . '</pre>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply', 'melany' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 'melany' ),
		'cancel_reply_link'    => __( 'Cancel reply', 'melany' ),
		'label_submit'         => __( 'Post Comment', 'melany' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <?php melany_cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="form-horizontal">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<?php echo $args['comment_notes_after']; ?>
						<p class="form-submit">
							<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" class="btn btn-primary" />
							<?php comment_id_fields( $post_id ); ?>
						</p>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * The default arguments that can be override are 'add_below', 'respond_id',
 * 'reply_text', 'login_text', and 'depth'. The 'login_text' argument will be
 * used, if the user must log in or register first before posting a comment. The
 * 'reply_text' will be used, if they can post a reply. The 'add_below' and
 * 'respond_id' arguments are for the JavaScript moveAddCommentForm() function
 * parameters.
 *
 * @since 0.1
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function melany_get_comment_reply_link($args = array(), $comment = null, $post = null) {
	global $user_ID;

	$defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __( 'Reply', 'melany' ),
		'login_text' => __( 'Log in to Reply', 'melany' ), 'depth' => 0, 'before' => '', 'after' => '');

	$args = wp_parse_args($args, $defaults);

	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
		return;

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	if ( empty($post) )
		$post = $comment->comment_post_ID;
	$post = get_post($post);

	if ( !comments_open($post->ID) )
		return false;

	$link = '';

	if ( get_option('comment_registration') && !$user_ID )
		$link = '<a rel="nofollow" class="comment-reply-login" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
	else
		$link = "<a class='btn btn-small pull-right' href='" . esc_url( add_query_arg( 'replytocom', $comment->comment_ID ) ) . "#" . $respond_id . "' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
	return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
}

/**
 * Displays the HTML content for reply to comment link.
 *
 * @since 0.1
 * @see get_comment_reply_link() Echoes result
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function melany_comment_reply_link($args = array(), $comment = null, $post = null) {
	echo melany_get_comment_reply_link($args, $comment, $post);
}

/**
 * Retrieve HTML content for cancel comment reply link.
 *
 * @since 0.1
 *
 * @param string $text Optional. Text to display for cancel reply link.
 */
function melany_get_cancel_comment_reply_link($text = '') {
	if ( empty($text) )
		$text = __( 'Click here to cancel reply.', 'melany' );

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';
	return apply_filters('cancel_comment_reply_link', '<a rel="nofollow" id="cancel-comment-reply-link" class="btn btn-small pull-right" href="' . $link . '"' . $style . '>' . $text . '</a>', $link, $text);
}

/**
 * Display HTML content for cancel comment reply link.
 *
 * @since 0.1
 *
 * @param string $text Optional. Text to display for cancel reply link.
 */
function melany_cancel_comment_reply_link($text = '') {
	echo melany_get_cancel_comment_reply_link($text);
}

/**
 * Display edit post link for post.
 *
 * @since 0.1
 *
 * @param string $link Optional. Anchor text.
 * @param string $before Optional. Display before edit link.
 * @param string $after Optional. Display after edit link.
 * @param int $id Optional. Post ID.
 */
function melany_edit_post_link( $link = null, $before = '', $after = '', $id = 0 ) {
	if ( !$post = get_post( $id ) )
		return;

	if ( !$url = get_edit_post_link( $post->ID ) )
		return;

	if ( null === $link )
		$link = __( 'Edit This', 'melany' );

	$post_type_obj = get_post_type_object( $post->post_type );
	$link = '<a class="btn btn-small pull-right" href="' . $url . '" title="' . esc_attr( $post_type_obj->labels->edit_item ) . '">' . $link . '</a>';
	echo $before . apply_filters( 'melany_edit_post_link', $link, $post->ID ) . $after;
}

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Implement the Category Dropdown Control
 */
//require_once( get_template_directory() . '/inc/category-dropdown.php' );
