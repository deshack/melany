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
