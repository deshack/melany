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
<?php else : ?>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/img/favicon.png'; ?>" />
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
<header class="navbar navbar-fixed-top navbar-inverse" role="navigation">

	<?php // Brand and toggle get grouped for better mobile display ?>
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only"><?php echo __( 'Toggle navigation', 'melany' ); ?></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php melany_site_name( get_bloginfo( 'name', 'display' ) ); ?></a>
	</div><!-- .navbar-header -->

	<?php // Collect the nav links, forms, and other content for toggling ?>
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<nav>
			<?php
				wp_nav_menu( array(
				'theme_location'	=> 'primary',
				'container' 			=> false,
				'menu_class' 			=> 'nav navbar-nav',
				'fallback_cb'			=> 'melany_page_menu',
				'depth'						=> 3,
				'walker'					=> new Bootstrap_Walker(),
			) ); ?>
		</nav>
		<?php get_search_form( true ); ?>
	</div><!-- .navbar-collapse -->
</header>

<div id="page" class="container hfeed site">
	<section id="main" class="row">
		<section id="logo" class="col-lg-3">
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
