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
	 * Add logo handler
	 *
	 * @since 0.2
	 */
	$wp_customize->add_section( 'melany_logo_section', array(
		'title' => __( 'Logo', 'melany' ),
		'priority' => 30,
		'description' => 'Upload a logo to display at the top of the sidebar',
	));
	$wp_customize->add_setting( 'melany_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_logo', array(
		'label' => __( 'Logo', 'melany' ),
		'section' => 'melany_logo_section',
		'settings' => 'melany_logo',
	)));

	/**
	 * Add integrated social badges
	 *
	 * @since 0.3
	 */
	$wp_customize->add_section( 'melany_social_section', array(
		'title' => __( 'Social Icons', 'melany' ),
		'priority' => 30,
		'description' => 'Add Social Icons and display them under site description',
	));
	/* Google+ Icon */
	$wp_customize->add_setting( 'melany_plus_icon' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_plus_icon', array(
		'label' => __( 'Google+ ID', 'melany' ),
		'section' => 'melany_social_section',
		'settings' => 'melany_plus_icon',
	)));
	/* Facebook Icon */
	$wp_customize->add_setting( 'melany_fb_icon' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_fb_icon', array(
		'label' => __( 'Facebook ID', 'melany' ),
		'section' => 'melany_social_section',
		'settings' => 'melany_fb_icon',
	)));
	/* Twitter Icon */
	$wp_customize->add_setting( 'melany_twitter_icon' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_twitter_icon', array(
		'label' => __( 'Twitter Username', 'melany' ),
		'section' => 'melany_social_section',
		'settings' => 'melany_twitter_icon',
	)));
	/* GitHub Icon */
	$wp_customize->add_setting( 'melany_github_icon' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_github_icon', array(
		'label' => __( 'GitHub Username', 'melany' ),
		'section' => 'melany_social_section',
		'settings' => 'melany_github_icon',
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
