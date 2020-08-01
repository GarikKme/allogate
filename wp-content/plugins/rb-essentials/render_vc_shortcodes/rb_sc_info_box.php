<?php

function rb_vc_shortcode_sc_info_box ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		'style'						=> 'info',
		'title'						=> '',
		'description'				=> '',
		'closable'					=> false,
		'el_class'					=> '',
 	);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = "";

	$module_classes = 'rb_info_box';
	$module_classes .= ' '.esc_attr($style);
	$module_classes .= !empty($el_class) ? ' '.esc_attr($el_class) : '';
	
	/* -----> Divider module output <----- */
	$out .= "<div class='".$module_classes."'>";
		$out .= "<div class='icon_wrapper'><i></i></div>";
		$out .= "<div class='content_wrapper'>";
			if( !empty($title) ){
				$out .= "<p class='info_box_title'>".esc_html($title)."</p>";
			}
			if( !empty($description) ){
				$out .= "<p class='info_box_desc'>".esc_html($description)."</p>";
			}
		$out .= "</div>";
		if( $closable ){
			$out .= "<i class='close_info_box'></i>";
		}
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_info_box', 'rb_vc_shortcode_sc_info_box' );

?>