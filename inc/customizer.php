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
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

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
}
add_action( 'customize_register', 'melany_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function melany_customize_preview_js() {
	wp_enqueue_script( 'melany_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130304', true );
}
add_action( 'customize_preview_init', 'melany_customize_preview_js' );
