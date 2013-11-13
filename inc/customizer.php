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
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'refresh';

	/**
	 * Add logo and favicon handler
	 *
	 * @since 0.2
	 */
	$wp_customize->add_section( 'melany_logo_section', array(
		'title' => __( 'Logo and favicon', 'melany' ),
		'priority' => 30,
		'description' => __( 'Upload a logo to be displayed at the top of the sidebar', 'melany' ),
	));
	$wp_customize->add_setting( 'melany_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_logo', array(
		'label' => __( 'Logo', 'melany' ),
		'section' => 'melany_logo_section',
		'settings' => 'melany_logo',
	)));
	$wp_customize->add_setting( 'melany_favicon' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_favicon', array(
		'label'			=> __( 'Favicon', 'melany' ),
		'section'		=> 'melany_logo_section',
		'settings'	=> 'melany_favicon',
	)));

	/**
	 * Add title length field within Site Title & Tagline section
	 *
	 * @Type: Core hack
	 * @Author: Mirko Pizii
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'melany_title_length', array(
		'default' => 20,
		'transport' => 'refresh',
		'type' => 'theme_mod'
	));
	$wp_customize->add_control( 'melany_title_length', array(
		'label' => __( 'Title Length', 'melany' ),
		'section' => 'title_tagline',
	));

	/**
	 * Add footer credits text field within Site Title & Tagline section
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'melany_footer_credits', array(
		'type' => 'theme_mod'
	));
	$wp_customize->add_control( 'melany_footer_credits', array(
		'label' => __( 'Credits', 'melany' ),
		'section' => 'title_tagline'
	));

	/**
	 * Static homepage custom background and text color
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'melany_home_background', array(
		'default'		=> '#3d8b3d',
		'transport'	=> 'refresh',
		'type'			=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_home_background', array(
		'label'			=> __( 'Homepage Background Color', 'melany' ),
		'section'		=> 'colors',
		'settings'	=> 'melany_home_background',
	)));

	$wp_customize->add_setting( 'melany_home_color', array(
		'default'		=> '#ffffff',
		'transport'	=> 'refresh',
		'type'			=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_home_color', array(
		'label'			=> __( 'Homepage Text Color', 'melany' ),
		'section'		=> 'colors',
		'settings'	=> 'melany_home_color'
	)));
	$wp_customize->add_setting( 'melany_navbar_color', array(
		'default'			=> 'inverse',
		'transport'			=> 'refresh',
		'type'				=> 'theme_mod'
	));
	$wp_customize->add_control( 'melany_navbar_color', array(
		'label'				=> __( 'Navbar color scheme', 'melany' ),
		'type'				=> 'select',
		'section'			=> 'colors',
		'choices'			=> array(
			'default'		=> __( 'Light', 'melany' ),
			'inverse'		=> __( 'Dark', 'melany' ),
			'green'			=> __( 'Green', 'melany' )
		),
	));

	$wp_customize->add_section( 'melany_author_section', array(
		'title'			=> __( 'Author Box', 'melany' ),
		'priority'		=> 31,
		'description'	=> __( 'Customize Author Box display', 'melany' )
	));
	$wp_customize->add_setting( 'melany_author_display', array(
		'default'		=> true
	));
	$wp_customize->add_control( 'melany_author_display', array(
		'label'			=> __( 'Display Author Box?', 'melany' ),
		'type'			=> 'checkbox',
		'section'		=> 'melany_author_section',
		'settings'		=> 'melany_author_display'
	));
	$wp_customize->add_setting( 'melany_author_count', array(
		'default'		=> true,
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
