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
				<?php do_action( 'melany_credits' ); ?>
				<?php printf( '&copy; 2013 Mattia Migliorini' ); ?>
				<span class="sep"> - </span>
				<?php printf( __( 'Powered by ', 'melany' )); ?><a href="http://wordpress.org/" target="_blank" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'melany' ); ?>" rel="generator">WordPress</a><?php printf( __( ' and ', 'melany' )); ?><a href="http://twitter.github.com/bootstrap" target="_blank">Bootstrap</a>
				<span class="sep"> - </span>
				<?php printf( __( '%1$s theme by %2$s', 'melany' ), '<a href="https://github.com/deshack/melany" target="_blank">Melany</a>', '<a href="http://www.deshack.net/" target="_blank" rel="designer">deshack</a>' ); ?>
			</small>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script type="text/javascript">
	$('.selectpicker').selectpicker();
</script>
</body>
</html>
