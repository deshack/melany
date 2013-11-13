<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package Melany
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if ( get_theme_mod( 'melany_favicon' ) ) : ?>
	<link rel="shortcut icon" href="<?php echo get_theme_mod( 'melany_favicon' ); ?>" />
<?php else : ?>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/img/favicon.png'; ?>" />
<?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'before' ); ?>
<div id="scroll">
<header id="masthead" <?php melany_header_class(); ?> role="banner">

	<?php // Brand and toggle get grouped for better mobile display ?>
	<div class="navbar-header" role="banner">
		<button type="button" class="navbar-toggle menu-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" data-parent="#site-header">
			<span class="sr-only"><?php echo __( 'Toggle navigation', 'melany' ); ?></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<button type="button" class="search-toggle" data-toggle="collapse" data-target=".search-collapse" data-parent="#site-header">
			<span class="sr-only"><?php echo __( 'Toggle search', 'melany' ); ?></span>
			<span class="glyphicon glyphicon-search"></span>
		</button>
		<?php $name = get_bloginfo( 'name', 'display' );
			$length = get_theme_mod( 'melany_title_length' ); ?>
		<a class="navbar-brand site-branding" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php melany_site_name( $name, $length ); ?></a>
	</div><!-- .navbar-header -->

	<?php // Collect the nav links, forms, and other content for toggling ?>
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="sr-only"><?php _e( 'Menu', 'melany' ); ?></h1>
			<div class="sr-only skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'melany' ); ?>"><?php _e( 'Skip to content', 'melany' ); ?></a></div>
			<?php
				wp_nav_menu( array(
				'theme_location'	=> 'primary',
				'container' 			=> false,
				'menu_class' 			=> 'nav navbar-nav',
				'fallback_cb'			=> 'melany_page_menu',
				'depth'						=> 3,
				'walker'					=> new Bootstrap_Walker,
			) ); ?>
		</nav><!-- #site-navigation -->
	</div><!-- .navbar-collapse -->
	<div class="collapse search-collapse">
		<?php get_search_form( true ); ?>
	</div>
</header><!-- #masthead -->

<div id="page" class="container hfeed site">
	<section id="content" class="site-content">
		<main id="main" class="row" role="main">
			<?php // Prevent custom header image or logo section to be shown on static home pages ?>
			<?php if ( ! is_page_template('templates/home.php') || is_home() ) : ?>
				<?php $header_image = get_header_image();
					if ( ! empty( $header_image ) ) : ?>
					<div id="header" class="col-xm-12">
						<img id="header-image" src="<?php header_image(); ?>" class="aligncenter" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</div>
				<?php endif; // !empty() ?>
				<?php // Prevent logo section to be shown on image post format
					if ( ! has_post_format( 'image' ) ) : ?>
					<section id="logo" class="col-xs-12">
						<div class="thumbnail text-center">
							<div class="caption">
								<h2><?php bloginfo( 'name' ); ?></h2>
							</div>
							<?php if ( get_theme_mod( 'melany_logo' ) ) : ?>
								<img src="<?php echo get_theme_mod( 'melany_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
							<?php endif; ?>
							<div class="caption">
								<p><?php bloginfo( 'description' ); ?></p>
							</div>
						</div>
					</section>
				<?php endif; // has_post_format( 'image' ) ?>
			<?php endif; // !is_front_page() || is_home() ?>
