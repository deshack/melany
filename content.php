<?php
/**
 * @package Melany
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'jumbotron' ); ?>>
	<header class="page-header entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
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
		<?php endif; ?>
	</header><!-- .entry-header -->
	
	<?php
	/**
	 * Display Excerpts for blog homepage, archives and search when the "Full text" customizer option is off
	 */
	if ( ( ! get_theme_mod('melany_home_excerpt') && is_home() ) || is_search() || is_archive() ) : ?>
	<div class="entry-summary">
	<?php melany_post_thumbnail(); ?>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
	<?php melany_post_thumbnail(); ?>
		<?php the_content( __( 'Continue reading', 'melany' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'melany' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

<?php if ( 'post' == get_post_type() && get_theme_mod( 'melany_home_tags' ) ) : // Hide tag text for pages on Search ?>
	<?php $tags_list = get_the_tag_list( '', ' - ' );
		if ( $tags_list ) : ?>

	<footer class="entry-meta panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo __( 'Tags', 'melany' ); ?></h3>
		</div><!-- .panel-heading -->
		<div class="panel-body">
			<?php printf( $tags_list ); ?>
		</div><!-- .panel-body -->
	</footer><!-- .entry-meta -->

	<?php endif; // End if $tags_list ?>
<?php endif; // End if 'post' ?>
</article><!-- #post-## -->
