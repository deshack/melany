/**
 * Add has-error state to comment form required inputs
 */
jQuery('#commentform #author').blur( function() {
	if( ! jQuery(this).val() ) {
		jQuery(this).parent('div').addClass('has-error');
	}
});

jQuery('#commentform #email').blur( function() {
	if( ! jQuery(this).val() ) {
		jQuery(this).parent('div').addClass('has-error');
	}
});

/**
 * Remove has-error state when clicking on reply link
 */
jQuery('.comment-reply-link').click( function() {
	jQuery('#commentform #author').parent('div').removeClass('has-error');
	jQuery('#commentform #email').parent('div').removeClass('has-error');
});

/**
 * Remove has-error state when clicking on cancel reply link
 */
jQuery('#cancel-comment-reply-link').click( function() {
	jQuery('#commentform #author').parent('div').removeClass('has-error');
	jQuery('#commentform #email').parent('div').removeClass('has-error');
});
