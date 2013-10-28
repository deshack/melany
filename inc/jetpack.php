<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Melany
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function melany_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'primary',
		'footer'    => 'scroll',
	) );
}
add_action( 'after_setup_theme', 'melany_jetpack_setup' );
