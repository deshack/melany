<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Melany
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if ( get_theme_mod( 'melany_favicon' ) ) : ?>
	<link rel="shortcut icon" href="<?php echo get_theme_mod( 'melany_favicon' ); ?>" />
<?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'before' ); ?>
<header class="navbar navbar-fixed-top navbar-inverse" role="banner">
	<div class="navbar-inner">
		<div class="container-fluid">
			<!-- toggle collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="brand" rel="home"><?php melany_site_name(get_bloginfo('name', 'display')); ?></a>
			<div class="nav-collapse collapse">
				<nav>
					<h1 class="menu-toggle"><?php _e( 'Menu', 'melany' ); ?></h1>
					<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'melany' ); ?>"><?php _e( 'Skip to content', 'melany' ); ?></a></div>

					<?php
						wp_nav_menu( array(
						'theme_location'	=> 'primary',
						'container' 			=> false,
						'menu_class' 			=> 'nav',
						'fallback_cb'			=> 'melany_page_menu',
						'depth'						=> 3,
						'walker'					=> new Bootstrap_Walker(),
					) ); ?>
				</nav>
				<?php get_search_form( true ); ?>
			</div>
		</div>
	</div>
</header>

<div id="page" class="container-fluid hfeed site">
	<section id="main" class="container-fluid">
		<div class="row-fluid">
			<section id="logo" class="span3">
				<ul class="thumbnails">
					<li class="span12">
						<div class="thumbnail text-center">
							<h2><?php bloginfo( 'name' ); ?></h2>
							<?php if ( get_theme_mod( 'melany_logo' ) ) : ?>
								<img src="<?php echo get_theme_mod( 'melany_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
							<?php endif; ?>
							<p><?php bloginfo( 'description' ); ?></p>
						</div>
					</li>
				</ul>
			</section>
