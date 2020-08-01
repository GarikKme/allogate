<?php

call_user_func_array( 'vc_add' . '_shortcode_param', array( 'rb_dropdown' , 'rb_vc_dropdown_field' ) );

function rb_vc_dropdown_field ( $settings, $value ){
	$output = '';
	$multiple = isset( $settings['multiple'] ) ? $settings['multiple'] : false;
	$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );
	$output .= '<select' . ( $multiple ? " multiple" : "" ) . ' name="'
	           . $settings['param_name']
	           . '" class="wpb_vc_param_value wpb-input wpb-select '
	           . $settings['param_name']
	           . ' ' . $settings['type']
	           . ' ' . $css_option
	           . '" data-option="' . $css_option . '">';
	if ( is_array( $value ) ) {
		$value = isset( $value['value'] ) ? $value['value'] : /*array_shift( */$value/* )*/;
	}
	if ( is_string( $value ) ){
		if ( strpos( $value, "," ) != -1 ){
			$value = explode( ",", $value );
		}
		else{
			$value = array( $value );
		}
	}
	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $index => $data ) {
			if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
				$option_label = $data;
				$option_value = $data;
			} elseif ( is_numeric( $index ) && is_array( $data ) ) {
				$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
				$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
			} else {
				$option_value = $data;
				$option_label = $index;
			}
			$selected = '';
			$option_value_string = (string) $option_value;
			if ( !empty( $value ) && in_array( $option_value_string, $value ) ) {
				$selected = ' selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
			           . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$output .= '</select>';
	return $output;
}
?>