<?php
/**
 * Melany Theme Customizer
 *
 * @package Melany
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function melany_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'refresh';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'refresh';
	//$wp_customize->get_setting( 'header_textcolor' )->transport = 'refresh';
	
	if ( method_exists($wp_customize, 'add_panel' ) ) :
	/**
	 * Wrap Melany settings in a panel.
	 *
	 * Requires WordPress 4.0. Check if `$wp_customize->add_panel()` method
	 * exists for backwards compatibility.
	 *
	 * @since  1.1.0
	 */
	$wp_customize->add_panel( 'melany', array(
		'priority'			=> 10,
		'capability'		=> 'edit_theme_options',
		'theme_supports'	=> '',
		'title'				=> __( 'Melany Settings', 'melany' ),
		'description'		=> __( 'Customize Melany Theme', 'melany' )
	));
	endif;

	/**
	 * Add title length field within Site Title & Tagline section
	 *
	 * @Type: Core hack
	 * @Author: Mirko Pizii
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'melany_title_length', array(
		'default'	=> 20,
		'transport' => 'refresh',
		'type'		=> 'theme_mod'
	));
	$wp_customize->add_control( 'melany_title_length', array(
		'label'			=> __( 'Title Length', 'melany' ),
		'section'		=> 'title_tagline',
		'description'	=> __( 'Set the number of characters after which the title in the navbar gets truncated.', 'melany' )
	));

	/**
	 * Add logo and favicon handler
	 *
	 * @since 0.2
	 */
	$wp_customize->add_section( 'melany_logo_section', array(
		'title'			=> __( 'Logo and favicon', 'melany' ),
		'priority'		=> 30,
		'description'	=> __( 'Upload a logo to be displayed at the top of the sidebar', 'melany' ),
		'panel'			=> 'melany'
	));
	$wp_customize->add_setting( 'melany_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_logo', array(
		'label'		=> __( 'Logo', 'melany' ),
		'section'	=> 'melany_logo_section',
		'settings'	=> 'melany_logo',
	)));
	$wp_customize->add_setting( 'melany_logo_shape', array(
		'default'	=> 'default',
	));
	$wp_customize->add_control( 'melany_logo_shape', array(
		'label'			=> __( 'Logo Shape', 'melany' ),
		'type'			=> 'radio',
		'section'		=> 'melany_logo_section',
		'choices'		=> array(
			'default'		=> __( 'Default', 'melany' ),
			'rounded'		=> __( 'Rounded', 'melany' ),
			'circle'		=> __( 'Circle', 'melany' ),
		),
	));
	$wp_customize->add_setting( 'melany_favicon' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_favicon', array(
		'label'			=> __( 'Favicon', 'melany' ),
		'section'		=> 'melany_logo_section',
		'settings'		=> 'melany_favicon',
	)));

	/**
	 * Add a link to the home in the header image (opt-in)
	 *
	 * @since 1.1.0
	 */
	$wp_customize->add_section( 'melany_header_section', array(
		'title'			=> __( 'Header', 'melany' ),
		'priority'		=> 31,
		'description'	=> __( 'Settings affecting the header.', 'melany' ),
		'panel'			=> 'melany'
	));
	$wp_customize->add_setting( 'melany_header', array(
		'default'		=> false
	));
	$wp_customize->add_control( 'melany_header', array(
		'label'			=> __( 'Add a link to the home page in the header image', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_header_section',
		'settings'		=> 'melany_header'
	));

	/**
	 * Static homepage custom background and text color
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'melany_home_background', array(
		'default'		=> '#3d8b3d',
		'transport'		=> 'refresh',
		'type'			=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_home_background', array(
		'label'			=> __( 'Homepage Background Color', 'melany' ),
		'section'		=> 'colors',
		'settings'		=> 'melany_home_background',
	)));

	$wp_customize->add_setting( 'melany_home_color', array(
		'default'		=> '#ffffff',
		'transport'		=> 'refresh',
		'type'			=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_home_color', array(
		'label'			=> __( 'Homepage Text Color', 'melany' ),
		'section'		=> 'colors',
		'settings'		=> 'melany_home_color'
	)));
	$wp_customize->add_setting( 'melany_navbar_color', array(
		'default'		=> 'inverse',
		'transport'		=> 'refresh',
		'type'			=> 'theme_mod'
	));
	$wp_customize->add_control( 'melany_navbar_color', array(
		'label'			=> __( 'Navbar color scheme', 'melany' ),
		'type'			=> 'select',
		'section'		=> 'colors',
		'choices'		=> array(
			'default'		=> __( 'Light', 'melany' ),
			'inverse'		=> __( 'Dark', 'melany' ),
			'green'			=> __( 'Green', 'melany' )
		),
	));
	$wp_customize->add_setting( 'melany_selection_color', array(
		'default'	=> '#5cb85c',
		'transport'	=> 'refresh',
		'type'		=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_selection_color', array(
		'label'			=> __( 'Text selection color', 'melany' ),
		'section'		=> 'colors',
		'settings'		=> 'melany_selection_color'
	)));

	/**
	 * Content options section
	 *
	 * @since 1.1.0
	 */
	$wp_customize->add_section( 'melany_content_section', array(
		'title'			=> __( 'Content', 'melany' ),
		'priority'		=> 32,
		'description'	=> __( 'Customize how the content is displayed', 'melany' ),
		'panel'			=> 'melany'
	));
	$wp_customize->add_setting( 'melany_home_excerpt', array(
		'default'		=> false,
	));
	$wp_customize->add_control( 'melany_home_excerpt', array(
		'label'			=> __( 'Full text posts in Home Page', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_content_section',
		'settings'		=> 'melany_home_excerpt',
	));
	$wp_customize->add_setting( 'melany_home_tags', array(
		'default'		=> true
	));
	$wp_customize->add_control( 'melany_home_tags', array(
		'label'			=> __( 'Display tags in Home Page', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_content_section',
		'settings'		=> 'melany_home_tags'
	));
	$wp_customize->add_setting( 'melany_home_thumb', array(
		'default'		=> false
	));
	$wp_customize->add_control( 'melany_home_thumb', array(
		'label'			=> __( 'Display Featured Images in Home Page', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_content_section',
		'settings'		=> 'melany_home_thumb'
	));

	/**
	 * Footer section
	 *
	 * @since 1.1.0
	 */
	$wp_customize->add_section( 'melany_footer_section', array(
		'title'			=> __( 'Footer', 'melany' ),
		'priority'		=> 33,
		'description'	=> __( 'Customize the site footer. If "Copyright text" is empty, the site name will be used. Credits appear after the copyright text.', 'melany' ),
		'panel'			=> 'melany'
	));
	/**
	 * Copyright text
	 *
	 * If empty, the site name will be used instead.
	 *
	 * @since 1.1.0
	 */
	$wp_customize->add_setting( 'melany_copyright' );
	$wp_customize->add_control( 'melany_copyright', array(
		'label'			=> __( 'Copyright text', 'melany' ),
		'type'			=> 'text',
		'section'		=> 'melany_footer_section',
		'settings'		=> 'melany_copyright'
	));
	/**
	 * Credits
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'melany_footer_credits', array(
		'type' 			=> 'theme_mod'
	));
	$wp_customize->add_control( 'melany_footer_credits', array(
		'label' 		=> __( 'Credits', 'melany' ),
		'type'			=> 'text',
		'section' 		=> 'melany_footer_section',
		'settings'		=> 'melany_footer_credits'
	));

	/**
	 * Author Box section
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section( 'melany_author_section', array(
		'title'			=> __( 'Author Box', 'melany' ),
		'priority'		=> 34,
		'description'	=> __( 'Customize Author Box display', 'melany' ),
		'panel'			=> 'melany'
	));
	$wp_customize->add_setting( 'melany_author_display', array(
		'default'		=> true
	));
	$wp_customize->add_setting( 'melany_author_count', array(
		'default'		=> true,
	));
	$wp_customize->add_control( 'melany_author_display', array(
		'label'			=> __( 'Display Author Box?', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_author_section',
		'settings'		=> 'melany_author_display'
	));
	$wp_customize->add_control( 'melany_author_count', array(
		'label'			=> __( 'Show Posts Number?', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_author_section',
		'settings'		=> 'melany_author_count'
	));

}
add_action( 'customize_register', 'melany_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function melany_customize_preview_js() {
	wp_enqueue_script( 'melany_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'melany_customize_preview_js' );
