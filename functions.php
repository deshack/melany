<?php
/**
 * Melany functions and definitions
 *
 * @package Melany
 * @since 0.5.0
 */

/**
 * Melany version.
 *
 * @since 1.1.0
 * @var  string
 */
define( 'MELANY_VERSION', '1.1.2' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

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
	 * Support title tag.
	 *
	 * @since future-release
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	// Set post thumbnail size
	set_post_thumbnail_size( 800, 300, false );
	// Add image size for Featured Posts
	add_image_size( 'featured-thumb', 800, 300, true );

	/**
	 * Switch default core markup for search form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list'
	) );

	/**
	 * Enable support for Post Formats
	 *
	 * WordPress Post Formats list
	 * aside, gallery, link, image, quote, status, video, audio, chat
	 */
	add_theme_support( 'post-formats', array( 'image' ) );

	/**
	 * Add support for featured content.
	 *
	 * @see Featured_Content
	 */
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'melany_get_featured_posts'
	) );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'melany' ),
	) );
}
add_action( 'after_setup_theme', 'melany_setup' );
endif; // melany_setup

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
add_action( 'init', 'melany_editor_styles' );
endif;

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
add_action( 'widgets_init', 'melany_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function melany_scripts() {
	// Register has-error script for further conditional use
	wp_register_script( 'has-error', get_template_directory_uri() . '/js/has-error.js', array( 'jquery' ), '1.0', true );

	// Enqueue styles
	wp_enqueue_style( 'melany-style', get_template_directory_uri() . '/main.css', false, MELANY_VERSION );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css', array('melany-style') );

	// Enqueue scripts
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.2.0', false );
	wp_enqueue_script( 'melany-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130513', true );
	wp_enqueue_script( 'melany-tooltips', get_template_directory_uri() . '/js/tooltips.js', array( 'bootstrap' ), MELANY_VERSION, true );

	// Fix IE
	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/respond.min.js', array(), '1.4.0', false );
	wp_enqueue_style( 'ie10fix', get_template_directory_uri() . '/css/ie10fix.css', array(), '1.0.0' );
	wp_enqueue_script( 'ie10fix', get_template_directory_uri() . '/js/ie10fix.js', array(), '1.0.0', false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'melany-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	if ( is_singular() && comments_open() && get_option( 'require_name_email' ) ) {
		wp_enqueue_script( 'has-error' );
	}
}
add_action( 'wp_enqueue_scripts', 'melany_scripts' );

/**
 * Load the Bootstrap Walker.
 */
require get_template_directory() . '/inc/bootstrap-walker.php';

/**
 * Implement the Custom Header feature
 */
require get_template_directory() . '/inc/custom-header.php' ;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add Featured Content functionality.
 *
 * To override in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] )
	require get_template_directory() . '/inc/featured-content.php';

/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';

/**
 * Backwards compatibility for title tag.
 *
 * @since future-release
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function melany_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'melany_render_title' );
}
