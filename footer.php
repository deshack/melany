<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Melany
 */
?>
		</div>
	</section><!-- #main -->

	<footer id="footer" role="contentinfo">
		<div class="text-center navbar-text">
			<small>
				<?php printf( '&copy; ' ); ?>
				<?php echo date( 'Y ' ); ?>
				<?php bloginfo( 'name' ); ?>
				<span class="sep"> - </span>
				<?php printf( __( 'Powered by ', 'melany' )); ?>WordPress
				<span class="sep"> - </span>
				<?php printf( __( '%1$s theme by %2$s', 'melany' ), '<a href="https://github.com/deshack/melany" target="_blank">Melany</a>', 'deshack' ); ?>
			</small>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
