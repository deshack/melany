<?php
/**
 * @package Melany
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php melany_edit_post_link( __( 'Edit', 'melany' )); ?>

		<div class="entry-meta muted">
			<small><?php melany_posted_on();
					/* Check categories for this blog */
					if( melany_categorized_blog() ){
						$category_list = get_the_category_list( __( ', ', 'melany' ) );
						printf( __( ' in %1$s', 'melany' ), $category_list );
					}
				?></small>
		</div>
	</header><!-- .page-header -->

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

	<footer class="well">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'melany' ) );

			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( '<span>Tags: %1$s</span><span class="pull-right">Bookmark the <a href="%2$s" title="Permalink to %3$s" rel="bookmark">permalink</a>.</span>', 'melany' );
			} else {
				$meta_text = __( '<span class="pull-right">Bookmark the <a href="%2$s" title="Permalink to %3$s" rel="bookmark">permalink</a>.</span>', 'melany' );
			}

			printf(
				$meta_text,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
