<?php
/**
 * The template for displaying search forms in Melany
 *
 * @package Melany
 */
?>
<form method="get" class="search-form navbar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="sr-only"><?php _ex( 'Search:', 'label', 'melany' ); ?></label>
	<input type="search" id="s" name="s" class="form-control" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'melany' ); ?>" />
	<input type="submit" for="s" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'melany' ); ?>">
</form>
