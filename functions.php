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
	require( get_template_directory() . '/lib/bootstrap/bootstrap-walker.php' );

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

	/**
	 * Add new image sizes
	 */
	add_image_size( 'single_post_thumb', 800, 300, true );
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
	wp_register_script( 'input-required', get_template_directory_uri() . '/js/input-required.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_style( 'melany-style', get_stylesheet_uri() );
	wp_enqueue_style( 'boostrap-select-style', get_template_directory_uri() . '/css/bootstrap-select.min.css', array( 'melany-style' ) );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.0.0-rc1', false );
	wp_enqueue_script( 'bootstrap-select', get_template_directory_uri() . '/js/bootstrap-select.min.js', array( 'bootstrap' ), '20130510', true );

	wp_enqueue_script( 'Melany-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'Melany-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'melany-tooltips', get_template_directory_uri() . '/js/tooltips.js', array( 'bootstrap' ), '3.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'Melany-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	if ( is_singular() && comments_open() && get_option( 'require_name_email' ) ) {
		wp_enqueue_script( 'input-required' );
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
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Implement the Category Dropdown Control
 */
//require_once( get_template_directory() . '/inc/category-dropdown.php' );
