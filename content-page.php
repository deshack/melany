<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Melany
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header entry-header">
		<hgroup class="row">
			<div class="col-sm-10">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</div>
			<?php edit_post_link( __( 'Edit', 'melany' ), '<div class="col-sm-2">', '</div>' ); ?>
		</hgroup>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() )
			the_post_thumbnail( 'single_post_thumb', array( 'class' => 'aligncenter img-rounded' ) ); ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'melany' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
