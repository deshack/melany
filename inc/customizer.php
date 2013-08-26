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
		'description' => 'Upload a logo to display at the top of the sidebar',
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

}
add_action( 'customize_register', 'melany_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function melany_customize_preview_js() {
	wp_enqueue_script( 'melany_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130304', true );
}
add_action( 'customize_preview_init', 'melany_customize_preview_js' );
