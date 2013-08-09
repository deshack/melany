<?php
/**
 * The template for displaying search forms in Melany
 *
 * @package Melany
 */
?>
	<form method="get" class="navbar-search pull-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="screen-reader-text"><?php _ex( 'Search', 'assistive text', 'melany' ); ?></label>
		<input type="text" class="search-query" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'melany' ); ?>" />
		<i class="icon-search"></i>
	</form>
