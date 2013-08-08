<?php
/**
 * Bootstrap_Walker for Wordpress
 * Author: George Huger, Illuminati Karate, Inc
 * More Info: http://illuminatikarate.com/blog/bootstrap-walker-for-wordpress
 *
 * Formats a Wordpress menu to be used as a Bootstrap dropdown menu (http://getbootstrap.com).
 *
 * Specifically, it makes these changes to the normal Wordpress menu output to support Bootstrap:
 * 	- adds a 'dropdown' class to level-0 <li>'s which contain a dropdown
 * 	- adds a 'dropdown-submenu' class to level-1 <li>'s which contain a dropdown
 * 	- adds the 'dropdown-menu' class to level-1 and level-2 <ul>'s
 *
 * Supports menus up to 3 levels deep.
 * 
 */

class Bootstrap_Walker extends Walker_Nav_Menu{
	/**
	 * Start of the <ul>
	 *
	 * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu". 
	 * 		So basically add one to what you'd expect it to be
	 */        
	function start_lvl( &$output, $depth = 0, $args = array() ){
		$tabs = str_repeat("\t", $depth);
		// If we are about to start the first submenu, we need to give it a dropdown-menu class
		if ($depth == 0 || $depth == 1) { //really, level-1 or level-2, because $depth is misleading here (see note above)
			$output .= "\n{$tabs}<ul class=\"dropdown-menu\">\n";
		} else {
			$output .= "\n{$tabs}<ul>\n";
		}
		return;
	}

	/**
	 * End of the <ul>
	 *
	 * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu". 
	 * 		So basically add one to what you'd expect it to be
	 */        
	function end_lvl( &$output, $depth = 0, $args = array() ){
		if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!)
			// we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now
			$output .= '<!--.dropdown-->';
		}
		$tabs = str_repeat("\t", $depth);
		$output .= "\n{$tabs}</ul>\n";
		return;
	}
        
	/**
	 * Output the <li> and the containing <a>
	 * Note: $depth is "correct" at this level
	 */        
	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ){
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $object->classes ) ? array() : (array) $object->classes;

		/* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */
		if ($object->hasChildren) {
			$classes[] = 'dropdown';
			// level-1 menus also need the 'dropdown-submenu' class
			if($depth == 1) {
				$classes[] = 'dropdown-submenu';
			}
		}

		/* This is the stock Wordpress code that builds the <li> with all of its attributes */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';            
		$attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
		$attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
		$attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
		$attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';
		$object_output = isset( $args->before ) ? $args->before : '';
        
		/* If this item has a dropdown menu, make clicking on this link toggle it */
		if ($object->hasChildren && $depth == 0) {
			$object_output .= '<a'. $attributes .' class="dropdown-toggle" data-toggle="dropdown">';
		} else {
			$object_output .= '<a'. $attributes .'>';
		}

		$object_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $object->title, $object->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );

		/* Output the actual caret for the user to click on to toggle the menu */            
		if ($object->hasChildren && $depth == 0) {
			$object_output .= ' <b class="caret"></b></a>';
		} else {
			$object_output .= '</a>';
		}

		$object_output .= isset( $args->after ) ? $args->after : '';
		$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
		return;
	}

	/**
	 * Close the <li>
	 * Note: the <a> is already closed
	 * Note 2: $depth is "correct" at this level
	 */        
	function end_el ( &$output, $object, $depth = 0, $args = array() ){
		$output .= '</li>';
		return;
	}

	/**
	 * Add a 'hasChildren' property to the item
	 * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633 
	 */
	function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output){
		// check whether this item has children, and set $item->hasChildren accordingly
		$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

		// continue with normal behavior
		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
?>
