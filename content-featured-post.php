<?php
/**
 * The Template for displaying featured posts on the front page
 *
 * @package Melany
 * @since 1.1.0
 */
?>

<?php $featured_posts = melany_get_featured_posts();
	$classes = 'item';
?>
<?php if ( get_the_ID() === $featured_posts[0]->ID )
	$classes .= ' active';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
<?php if ( has_post_thumbnail() )
	the_post_thumbnail( 'featured-thumb' ); ?>
	<div class="container">
		<header class="carousel-caption entry-header">
			<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
		</header><!-- .carousel-caption -->
	</div><!-- .container -->
</article><!-- #post-## -->