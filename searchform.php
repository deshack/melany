<?php
/**
 * The template for displaying search forms in Melany
 *
 * @package Melany
 */
?>
	<form method="get" class="navbar-form pull-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'melany' ); ?>" />
	</form>
