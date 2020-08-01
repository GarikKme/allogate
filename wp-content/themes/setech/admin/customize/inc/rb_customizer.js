/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( jQuery ) {

	var live_controls = JSON.parse(preview_controls.ajax_data);

	jQuery.each(live_controls, function() {
	
		var control_id = '';
		var	elem = '';
		var style = '';

		jQuery.each(this, function( k,v ){
			switch(k) {
				case 'control':
					control_id = v;
					break;
				case 'trigger_class':
					elem = v;
					break;
				case 'style_to_change':
					style = v;
					break;
				default:
					break;
			}
		});

		wp.customize(control_id, function(value){
			value.bind(function(newval){
				jQuery(elem).css(style, newval);
			});
		})

	});

} )( jQuery );