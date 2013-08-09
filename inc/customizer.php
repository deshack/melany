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
	$wp_customize->add_setting( 'melany_logo', array(
		'default'		=> get_template_directory_uri() . '/img/logo.png',
	) );
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
	 * Add integrated social icons
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
	/* Ubuntu Wiki Icon */
	$wp_customize->add_setting( 'melany_ubuntu_wiki' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_ubuntu_wiki', array(
		'label' => __( 'Ubuntu Wiki Page Name', 'melany' ),
		'section' => 'melany_social_section',
		'settings' => 'melany_ubuntu_wiki',
	)));

	/**
	 * Add RSS Feed Icon
	 */
	$wp_customize->add_section( 'melany_rss_section', array(
		'title' => __( 'RSS Feed', 'melany' ),
		'priority' => 30,
		'description' => 'Display the RSS Feed Icon below Social Icons',
	));
	$wp_customize->add_setting( 'melany_rss_icon' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_rss_icon', array(
		'label' => __( 'Display RSS Feed Icon', 'melany' ),
		'section' => 'melany_rss_section',
		'settings' => 'melany_rss_icon',
		'type' => 'checkbox',
	)));

	/**
	 * Jetpack Infinite Scroll
	 */
	$wp_customize->add_section( 'melany_infinite_scroll_section', array(
		'title' => 'Jetpack Infinite Scroll',
		'priority' => 30,
		'description' => 'Enable Jetpack Infinite Scroll function',
	));
	$wp_customize->add_setting( 'melany_infinite_scroll' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'melany_infinite_scroll', array(
		'label' => __( 'Automatically show new posts when scrolling down the page', 'melany' ),
		'section' => 'melany_infinite_scroll_section',
		'settings' => 'melany_infinite_scroll',
		'type' => 'checkbox',
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
