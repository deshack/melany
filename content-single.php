<?php
/**
 * @package Melany
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header entry-header">
		<hgroup class="row">
			<div class="col-sm-10">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</div>
			<div class="col-sm-2">
				<?php edit_post_link( __( 'Edit', 'melany' ) ); ?>
			</div>
		</hgroup>
		<div class="entry-meta">
			<small><?php melany_posted_on();
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( ', ' );
					if ( $categories_list && melany_categorized_blog() ) : ?>
						<span class="cat-links">
							<?php printf( __(' in %1$s', 'melany' ), $categories_list ); ?>
						</span>
				<?php endif; ?></small>
		</div><!-- .entry-meta -->
	</header><!-- .page-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() )
			the_post_thumbnail( 'single_post_thumb', array( 'class' => 'aligncenter img-rounded' ) ); ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links well"><b>' . __( 'Pages:', 'melany' ) . '</b>',
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php melany_author_box(); ?>

	<footer class="entry-meta">
		<?php $tag_list = get_the_tag_list( '', ' - ' );
			if( '' != $tag_list ) : ?>

			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo __( 'Tags', 'melany' ); ?></h3>
				</div>
				<div class="panel-body">
					<?php printf( $tag_list ); ?>
				</div>
			</div>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
