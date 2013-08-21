<?php
/**
 * @package Melany
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<div class="row">
			<div class="col-sm-10">
				<h1><?php the_title(); ?></h1>
			</div>
			<div class="col-sm-2">
				<?php melany_edit_post_link( __( 'Edit', 'melany' ) ); ?>
			</div>
		</div><!-- .row -->
		<div class="entry-meta">
			<small><?php melany_posted_on();
					/* Check categories for this blog */
					if( melany_categorized_blog() ){
						$category_list = get_the_category_list( __( ', ', 'melany' ) );
						printf( __( ' in %1$s', 'melany' ), $category_list );
					}
				?></small>
		</div><!-- .entry-meta -->
	</header><!-- .page-header -->

	<div class="entry-content clearfix">
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

	<footer class="panel panel-default">
		<div class="panel-body">
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
		</div><!-- .panel-body -->
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
