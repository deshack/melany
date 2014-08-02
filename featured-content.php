<?php
/**
 * The Template for displaying featured content
 *
 * @package Melany
 * @since 1.1.0
 */
?>

<div id="featured-content" class="featured-content carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
	<?php $count = 0; ?>
	<?php $featured_posts = melany_get_featured_posts(); ?>
	<?php foreach ( $featured_posts as $order => $post ) : ?>
		<li <?php echo $count == 0 ? 'class="active"' : ''; ?> data-target="#featured-content" data-slide-to="<?php echo $count; ?>"></li>
		<?php $count += 1; ?>
	<?php endforeach; ?>
	</ol>
	<div class="featured-content-inner carousel-inner">
	<?php
		/**
		 * Fires before the Melany featured content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'melany_featured_posts_before' );

		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );

			// Include the featured content template.
			get_template_part( 'content', 'featured-post' );
		endforeach;

		/**
		 * Fires after the Melany featured content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'melany_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div><!-- .featured-content-inner -->
	<!-- Arrows -->
	<a class="left carousel-control" href="#featured-content" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	<a class="right carousel-control" href="#featured-content" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- #featured-content.carousel -->