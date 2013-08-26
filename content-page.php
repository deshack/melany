<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Melany
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<hgroup class="clearfix">
			<h1 class="entry-title span11"><?php the_title(); ?></h1>
			<?php melany_edit_post_link( __( 'Edit', 'melany' ), '<div class="span1">', '</div>' ); ?>
		</hgroup>
	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<?php if ( has_post_thumbnail() )
			the_post_thumbnail( 'large', array( 'class' => 'aligncenter' ) ); ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'melany' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
