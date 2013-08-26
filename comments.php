<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to melany_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Melany
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>
	<hr />
	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php printf( __( 'Comments', 'melany' )); ?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="sr-only"><?php _e( 'Comment navigation', 'melany' ); ?></h1>
			<ul class="pager">
				<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'melany' ) ); ?></li>
				<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'melany' ) ); ?></li>
			</ul>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ul class="comment-list media-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use melany_comment() to format the comments.
				 * If you want to override this in a child theme then you can
				 * define melany_comment() and that will be used instead.
				 * See melany_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array(
					'callback'	=> 'melany_comment',
					'format'		=> 'html5',
				) );
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="sr-only"><?php _e( 'Comment navigation', 'melany' ); ?></h1>
			<ul class="pager">
				<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'melany' ) ); ?></li>
				<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'melany' ) ); ?></li>
			</ul>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'melany' ); ?></p>
	<?php endif; ?>

	<?php $comment_field = melany_get_comment_field();
				$comment_notes_before = melany_get_comment_notes_before();
				$comment_notes_after = melany_get_comment_notes_after();
	?>
	<?php comment_form( array(
			'comment_field'					=> $comment_field,
			'comment_notes_before'	=> $comment_notes_before,
			'comment_notes_after'		=> $comment_notes_after,
			'cancel_reply_link'			=> "Cancel reply",
		) );
	?>

</div><!-- #comments -->
