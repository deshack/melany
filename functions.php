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
	 *
	 * WordPress Post Formats list
	 * aside, gallery, link, image, quote, status, video, audio, chat
	 *
	 * @since 1.0.0
	 */
	add_theme_support( 'post-formats', array( 'image' ) );

	/**
	 * Add new image sizes
	 */
	add_image_size( 'single_post_thumb', 800, 300, true );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'melany_custom_background_args', array(
		'default-color'	=> 'ffffff',
		'default-image'	=> '',
	) ) );
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
	wp_enqueue_style( 'melany-style', get_stylesheet_uri() );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css', array('melany-style') );

	// Enqueue scripts
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.0.0', false );
	wp_enqueue_script( 'melany-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'melany-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'melany-tooltips', get_template_directory_uri() . '/js/tooltips.js', array( 'bootstrap' ), '3.0.0', true );

	// Fix IE
	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/respond.min.js', array(), '1.4.0', false );
	wp_enqueue_style( 'ie10fix-css', get_template_directory_uri() . '/css/ie10fix.css', array(), '1.0.0' );
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
require get_template_directory() . '/lib/bootstrap/bootstrap-walker.php';

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
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';
