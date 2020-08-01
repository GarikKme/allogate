<?php
function rb_vc_svg ( $settings, $value ){
	$svg = json_decode($value, true);
	$svg_content = '';
	if (!empty($svg) && function_exists('rbsvg_shortcode')) {
		$svg_content = rbsvg_shortcode($svg);
	}
	$output = '<div class="my_param_block" style="display: inline-block; min-width: 100px;">'
		.'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" hidden value="' . esc_attr( $value ) . '" />';
	$output .= "<a href='#' class='rb_svg_icon' style='" . (!empty($value) ? "display:none;" : "") . "'>Add</a>";
	$output .= "<a href='#' class='rb_svg_icon_remove' style='color: red; " . (empty($value) ? "display:none;" : "") . "'>Remove</a>";
	$output .= $svg_content;
	$output .= "</div>";
	return $output;
}

?>