<?php
/**
 * Template Name: Home
 *
 * @package Melany
 * @since 1.0.0
 */
get_header(); ?>

<section id="primary" class="content-area">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'home' ); ?>

	<?php endwhile; // End of the loop ?>

</section><!-- #primary -->

<?php get_footer(); ?>
