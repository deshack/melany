<?php
/**
 * Class Name: Bootstrap_Walker 
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 4.0.0
 * Author: Mattia Migliorini
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Based on the wp_bootstrap_navwalker by Edward McIntyre (@twittem).
 *
 * @package Melany
 * @subpackage Bootstrap_Walker
 *
 * @link https://github.com/twittem/wp-bootstrap-navwalker
 * @since Melany 1.0.0
 * @version 4.0.0
 */

/**
 * Custom Twitter Bootstrap Walker Class
 *
 * Custom WordPress Nav Walker class to implement the Twitter Bootstrap 3
 * navigation style using the WordPress built-in menu manager.
 *
 * @since 1.0.0
 * @see Walker_Nav_Menu
 */
class Bootstrap_Walker extends Walker_Nav_Menu{
	
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', (array) apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( ! empty( $args->has_children ) && $args->has_children )
				$class_names .= ' dropdown';


			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';

			// If item has_children add atts to a.
			if ( ! empty( $args->has_children ) && $args->has_children ) {
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			if ( ! empty( $args->before ) )
				$item_output = $args->before;
			else
				$item_output = '';

			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->attr_title ) && strpos( $item->attr_title, 'glyphicon' ) !== false )
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';

			$item_output .= (!empty($args->link_before) ? $args->link_before : '') . apply_filters( 'the_title', $item->title, $item->ID ) . (!empty($args->link_after) ? $args->link_after : '');

			if ( !empty($args->has_children) && $args->has_children )
				$item_output .= ' <span class="caret"></span></a>';
			else
				$item_output .= '</a>';

			$item_output .= (!empty($args->after) ? $args->after : '');

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a menu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display a link to the home page and
	 * will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @since 4.0.0
	 * @see wp_nav_menu()
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 * @return void|string. Void if $args['echo'] is true, HTML string otherwise.
	 */
	public static function fallback( $args ) {
		$fb_output = null;

		extract( $args );

		// Assume we have a list

		// Show Home in the menu
		$home_class = '';
		if ( is_front_page() && !is_paged() )
			$home_class = ' class="current_page_item active"';
		$fb_output .= '<li' . $home_class . '>' . $link_before . '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . $before . '<span class="glyphicon glyphicon-home"></span> ' . __( 'Home', 'melany' ) . $after . '</a>' . $link_after . '</li>';

		if ( current_user_can( 'manage_options' ) )
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">' . __( 'Add a menu', 'melany' ) . '</a></li>';

		$fb_output = sprintf( $items_wrap, $menu_id, $menu_class, $fb_output );

		if ( ! empty( $container ) )
			$fb_output = '<' . $container . ' class="' . $container_class . '" id="' . $container_id . '">' . $fb_output . '</' . $container . '>';
		if ( $echo )
			echo $fb_output;
		else
			return $fb_output;
	}
}
