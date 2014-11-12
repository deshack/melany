<?php
/**
 * Melany Theme Customizer
 *
 * @package Melany\Customizer
 * @since  0.2.0
 */

/**
 * Melany Customizer.
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @package Melany\Customizer
 * @since  1.1.1
 * @version  1.0.0
 * @link(Theme Customization API, http://codex.wordpress.org/Theme_Customization_API)
 */
class Melany_Customizer {
	/**
	 * Register sections and controls.
	 *
	 * This hooks into 'customize_register' (available from WP 3.4) and allows to add
	 * new sections and controls to the Theme Customize screen.
	 *
	 * Note: to enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * @see  add_action('customize_register', $func)
	 * @link(Otto on Theme Customizer, http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/)
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	public static function register( $wp_customize ) {
		if ( method_exists($wp_customize, 'add_panel' ) ) {
			/**
			 * Wrap Melany settings in a panel.
			 *
			 * Requires WordPress 4.0. Check if `$wp_customize->add_panel()` method
			 * exists for backwards compatibility.
			 *
			 * @since Melany 1.1.0
			 */
			$wp_customize->add_panel( 'melany', array(
				'priority'			=> 10,
				'capability'		=> 'edit_theme_options',
				'theme_supports'	=> '',
				'title'				=> __( 'Melany Settings', 'melany' ),
				'description'		=> __( 'Customize Melany Theme', 'melany' )
			));
		}

		// Register title settings.
		self::_register_title( $wp_customize );
		// Register logo and favicon section and settings.
		self::_register_logo( $wp_customize );
		// Register header section and settings.
		self::_register_header( $wp_customize );
		// Register content settings.
		self::_register_content( $wp_customize );
		// Register footer settings.
		self::_register_footer( $wp_customize );
		// Register Author Box settings.
		self::_register_author_box( $wp_customize );
		// Register color settings.
		self::_register_colors( $wp_customize );

		// Change built-in settings.
		$wp_customize->get_setting( 'blogname' )->transport         = 'refresh';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'refresh';
	}

	/**
	 * Output custom settings to the live theme's head.
	 *
	 * Hooked into 'wp_head'.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 */
	public static function header_output() {
		?>
		<!-- Customizer CSS -->
		<style type="text/css">
			<?php self::generate_css('body.page-template-templateshome-php', 'background-color', 'melany_home_background' ); ?>
			<?php self::generate_css('body.page-template-templateshome-php .jumbotron', 'color', 'melany_home_color' ); ?>
			<?php self::generate_css('::-moz-selection', 'background', 'melany_selection_color' ); ?>
			<?php self::generate_css('::selection','background', 'melany_selection_color' ); ?>
		</style>
		<!-- /Customizer CSS -->
		<?php
	}

	/**
	 * Enqueue life settings preview script.
	 *
	 * Hooked into 'customize_preview_init'.
	 *
	 * @see add_action('customize_preview_init', $func)
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 */
	public static function live_preview() {
		wp_enqueue_script(
			'melany-customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'jquery', 'customize-preview' ),
			MELANY_VERSION,
			true
		);
	}

	/**
	 * Sanitize numeric value.
	 *
	 * If the provided value is not numeric, save the default value.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param mixed $value
	 * @return  int
	 */
	public static function sanitize_numeric( $value ) {
		if ( ! is_numeric( $value ) )
			$value = '';
		return $value;
	}

	/**
	 * Sanitize checkbox value.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param  mixed $value
	 * @return  string 1 if $value evaluates to true, 0 otherwise.
	 */
	public static function sanitize_checkbox( $value ) {
		if ( $value )
			return true;
		else
			return false;
	}

	/**
	 * Sanitize logo shape setting.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param  string $value
	 * @return  string
	 */
	public static function sanitize_logo_shape( $value ) {
		$accepted = array( 'default', 'rounded', 'circle' );

		if ( ! in_array( $value, $accepted ) )
			return;
		return $value;
	}

	/**
	 * Sanitize navbar color setting.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param  string $value
	 * @return string
	 */
	public static function sanitize_navbar_color( $value ) {
		$accepted = array( 'default', 'green', 'inverse' );

		if ( ! in_array( $value, $accepted ) )
			return;
		return $value;
	}

	/**
	 * Generate CSS for use in header output.
	 *
	 * If the setting `$mod_name` has no defined value, the CSS will not be
	 * output.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @static
	 *
	 * @uses get_theme_mod()
	 *
	 * @param string $selector CSS selector.
	 * @param string $style The name of the CSS property to modify.
	 * @param string $mod_name The name of the 'theme_mod' option to fetch.
	 * @param string $prefix Optional. Anything that needs to be output before
	 * the CSS property.
	 * @param string $postfix Optional. Anything that needs to be output after
	 * the CSS property.
	 * @param bool $echo Optional. Whether to print directly to the page.
	 * Default true.
	 * @return string Returns a single line of CSS with selectors and a property.
	 */
	protected static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$css = '';
		$mod = get_theme_mod( $mod_name );

		if ( ! empty( $mod ) ) {
			$css = sprintf( '%s { %s:%s; }',
				$selector,
				$style,
				$prefix.$mod.$postfix
			);
			if ( $echo )
				echo $css;
		}

		return $css;
	}

	/**
	 * Register settings under Site Title and Tagline section.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_title( $wp_customize ) {
		/**
		 * Add title length field within Site Title & Tagline section
		 *
		 * @Type: Core hack
		 * @Author: Mirko Pizii
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_setting( 'melany_title_length', array(
			'default'	=> 20,
			'transport' => 'refresh',
			'type'		=> 'theme_mod',
			'sanitize_callback' => array( __CLASS__, 'sanitize_numeric' )
		));
		$wp_customize->add_control( 'melany_title_length', array(
			'label'			=> __( 'Title Length', 'melany' ),
			'section'		=> 'title_tagline',
			'description'	=> __( 'Set the number of characters after which the title in the navbar gets truncated.', 'melany' )
		));
	}

	/**
	 * Logo and favicon settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_logo( $wp_customize ) {
		/**
		 * Add logo section.
		 *
		 * @since  Melany 0.2.0
		 */
		$wp_customize->add_section( 'melany_logo_section', array(
			'title'			=> __( 'Logo and favicon', 'melany' ),
			'priority'		=> 30,
			'description'	=> __( 'Upload a logo to be displayed at the top of the sidebar', 'melany' ),
			'panel'			=> 'melany'
		));

		// Add logo setting and control.
		$wp_customize->add_setting( 'melany_logo', array(
			'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_logo', array(
			'label'		=> __( 'Logo', 'melany' ),
			'section'	=> 'melany_logo_section',
			'settings'	=> 'melany_logo',
		)));

		// Add logo shape setting and control.
		$wp_customize->add_setting( 'melany_logo_shape', array(
			'default'	=> 'default',
			'sanitize_callback' => array( __CLASS__, 'sanitize_logo_shape' )
		));
		$wp_customize->add_control( 'melany_logo_shape', array(
			'label'			=> __( 'Logo Shape', 'melany' ),
			'type'			=> 'radio',
			'section'		=> 'melany_logo_section',
			'choices'		=> array(
				'default'		=> __( 'Default', 'melany' ),
				'rounded'		=> __( 'Rounded', 'melany' ),
				'circle'		=> __( 'Circle', 'melany' ),
			),
		));

		// Add favicon setting and control
		$wp_customize->add_setting( 'melany_favicon', array(
			'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'melany_favicon', array(
			'label'			=> __( 'Favicon', 'melany' ),
			'section'		=> 'melany_logo_section',
			'settings'		=> 'melany_favicon',
		)));
	}

	/**
	 * Header Customizer settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_header( $wp_customize ) {
		$wp_customize->add_section( 'melany_header_section', array(
			'title'			=> __( 'Header', 'melany' ),
			'priority'		=> 31,
			'description'	=> __( 'Settings affecting the header.', 'melany' ),
			'panel'			=> 'melany'
		));
		/**
		 * Add link to the home page in header image.
		 */
		$wp_customize->add_setting( 'melany_header', array(
			'default'		=> false,
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
		));
		$wp_customize->add_control( 'melany_header', array(
			'label'			=> __( 'Add a link to the home page in the header image', 'melany' ),
			'type'			=> 'checkbox',
			'section'		=> 'melany_header_section',
			'settings'		=> 'melany_header'
		));
	}

	/**
	 * Content settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_content( $wp_customize ) {
		/**
		 * Content options section
		 *
		 * @since Melany 1.1.0
		 */
		$wp_customize->add_section( 'melany_content_section', array(
			'title'			=> __( 'Content', 'melany' ),
			'priority'		=> 32,
			'description'	=> __( 'Customize how the content is displayed', 'melany' ),
			'panel'			=> 'melany'
		));
		$wp_customize->add_setting( 'melany_home_excerpt', array(
			'default'		=> false,
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
		));
		$wp_customize->add_control( 'melany_home_excerpt', array(
			'label'			=> __( 'Full text posts in Home Page', 'melany' ),
			'type'			=> 'checkbox',
			'section'		=> 'melany_content_section',
			'settings'		=> 'melany_home_excerpt',
		));
		$wp_customize->add_setting( 'melany_home_tags', array(
			'default'		=> true,
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
		));
		$wp_customize->add_control( 'melany_home_tags', array(
			'label'			=> __( 'Display tags in Home Page', 'melany' ),
			'type'			=> 'checkbox',
			'section'		=> 'melany_content_section',
			'settings'		=> 'melany_home_tags'
		));
		$wp_customize->add_setting( 'melany_home_thumb', array(
			'default'		=> false,
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
		));
		$wp_customize->add_control( 'melany_home_thumb', array(
			'label'			=> __( 'Display Featured Images in Home Page', 'melany' ),
			'type'			=> 'checkbox',
			'section'		=> 'melany_content_section',
			'settings'		=> 'melany_home_thumb'
		));
	}

	/**
	 * Footer settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_footer( $wp_customize ) {
		/**
		 * Footer section
		 *
		 * @since Melany 1.1.0
		 */
		$wp_customize->add_section( 'melany_footer_section', array(
			'title'			=> __( 'Footer', 'melany' ),
			'priority'		=> 33,
			'description'	=> __( 'Customize the site footer. If "Copyright text" is empty, the site name will be used. Credits appear after the copyright text.', 'melany' ),
			'panel'			=> 'melany'
		));
		/**
		 * Copyright text
		 *
		 * If empty, the site name will be used instead.
		 *
		 * @since Melany 1.1.0
		 */
		$wp_customize->add_setting( 'melany_copyright', array(
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'melany_copyright', array(
			'label'			=> __( 'Copyright text', 'melany' ),
			'type'			=> 'text',
			'section'		=> 'melany_footer_section',
			'settings'		=> 'melany_copyright'
		));
		/**
		 * Credits
		 *
		 * @since Melany 1.0.0
		 */
		$wp_customize->add_setting( 'melany_footer_credits', array(
			'type' 			=> 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'melany_footer_credits', array(
			'label' 		=> __( 'Credits', 'melany' ),
			'type'			=> 'text',
			'section' 		=> 'melany_footer_section',
			'settings'		=> 'melany_footer_credits'
		));
	}

	/**
	 * Author Box settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_author_box( $wp_customize ) {
		/**
		 * Author Box section
		 *
		 * @since Melany 1.0.0
		 */
		$wp_customize->add_section( 'melany_author_section', array(
			'title'			=> __( 'Author Box', 'melany' ),
			'priority'		=> 34,
			'description'	=> __( 'Customize Author Box display', 'melany' ),
			'panel'			=> 'melany'
		));
		$wp_customize->add_setting( 'melany_author_display', array(
			'default'		=> true,
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
		));
		$wp_customize->add_setting( 'melany_author_count', array(
			'default'		=> true,
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
		));
		$wp_customize->add_control( 'melany_author_display', array(
			'label'			=> __( 'Display Author Box?', 'melany' ),
			'type'			=> 'checkbox',
			'section'		=> 'melany_author_section',
			'settings'		=> 'melany_author_display'
		));
		$wp_customize->add_control( 'melany_author_count', array(
			'label'			=> __( 'Show Posts Number?', 'melany' ),
			'type'			=> 'checkbox',
			'section'		=> 'melany_author_section',
			'settings'		=> 'melany_author_count'
		));
	}

	/**
	 * Colors settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @static
	 *
	 * @param  \WP_Customize_Manager $wp_customize
	 */
	protected static function _register_colors( $wp_customize ) {
		/**
		 * Static homepage custom background and text color
		 *
		 * @since Melany 1.0.0
		 */
		$wp_customize->add_setting( 'melany_home_background', array(
			'default'		=> '#3d8b3d',
			'transport'		=> 'refresh',
			'type'			=> 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color'
		));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_home_background', array(
			'label'			=> __( 'Homepage Background Color', 'melany' ),
			'section'		=> 'colors',
			'settings'		=> 'melany_home_background',
		)));

		$wp_customize->add_setting( 'melany_home_color', array(
			'default'		=> '#ffffff',
			'transport'		=> 'refresh',
			'type'			=> 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color'
		));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_home_color', array(
			'label'			=> __( 'Homepage Text Color', 'melany' ),
			'section'		=> 'colors',
			'settings'		=> 'melany_home_color'
		)));
		$wp_customize->add_setting( 'melany_navbar_color', array(
			'default'		=> 'inverse',
			'transport'		=> 'refresh',
			'type'			=> 'theme_mod',
			'sanitize_callback' => array( __CLASS__, 'sanitize_navbar_color' )
		));
		$wp_customize->add_control( 'melany_navbar_color', array(
			'label'			=> __( 'Navbar color scheme', 'melany' ),
			'type'			=> 'select',
			'section'		=> 'colors',
			'choices'		=> array(
				'default'		=> __( 'Light', 'melany' ),
				'inverse'		=> __( 'Dark', 'melany' ),
				'green'			=> __( 'Green', 'melany' )
			),
		));
		$wp_customize->add_setting( 'melany_selection_color', array(
			'default'	=> '#5cb85c',
			'transport'	=> 'refresh',
			'type'		=> 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color'
		));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'melany_selection_color', array(
			'label'			=> __( 'Text selection color', 'melany' ),
			'section'		=> 'colors',
			'settings'		=> 'melany_selection_color'
		)));
	}
}

// Setup Theme Customizer settings and controls.
add_action( 'customize_register', array( 'Melany_Customizer', 'register' ) );

// Output custom CSS to live site.
add_action( 'wp_head', array( 'Melany_Customizer', 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen.
// Don't include it yet, we still use the 'refresh' transport.
// add_action( 'customize_preview_init', array( 'Melany_Customizer', 'live_preview' ) );