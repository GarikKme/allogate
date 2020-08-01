<?php

function rb_vc_shortcode_sc_divider ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		'style'						=> 'default',
		'el_class'					=> '',
		/* -----> STYLING TAB <----- */
		'color'						=> PRIMARY_COLOR,
		'helper_color'				=> '#e5e5e5',
 	);
 	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		'all' => array(
 			'custom_styles'		=> '',
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$id = uniqid( "rb_divider_" );

	/* -----> Visual Composer Responsive styles <----- */
	list( $vc_desktop_class, $vc_landscape_class, $vc_portrait_class, $vc_mobile_class ) = vc_responsive_styles($atts);

	preg_match("/(?<=\{).+?(?=\})/", $vc_desktop_class, $vc_desktop_styles); 
	$vc_desktop_styles = implode($vc_desktop_styles);

	preg_match("/(?<=\{).+?(?=\})/", $vc_landscape_class, $vc_landscape_styles);
	$vc_landscape_styles = implode($vc_landscape_styles);

	preg_match("/(?<=\{).+?(?=\})/", $vc_portrait_class, $vc_portrait_styles);
	$vc_portrait_styles = implode($vc_portrait_styles);

	preg_match("/(?<=\{).+?(?=\})/", $vc_mobile_class, $vc_mobile_styles);
	$vc_mobile_styles = implode($vc_mobile_styles);

	/* -----> Customize default styles <----- */
	if( !empty($vc_desktop_styles) ){
		$styles .= "
			#".$id."{
				".$vc_desktop_styles.";
			}
		";
	}
	if( !empty($color) ){
		if( $style == 'default' || $style == 'style_2' ){
			$styles .= "
				#".$id." .rb_divider{
					background-color: ".esc_attr($color).";
				}
			";
		} else if( $style == 'style_1' ){
			$styles .= "
				#".$id." .rb_divider span{
					background-color: ".esc_attr($color).";
				}
			";
		}
	}
	if( !empty($helper_color) && $style == 'style_1' ){
		$styles .= "
			#".$id." .rb_divider:before,
			#".$id." .rb_divider:after{
				background-color: ".esc_attr($helper_color).";
			}
		";
	}
	if( !empty($color) && !empty($helper_color) && $style == 'dashed' ){
		$styles .= "
			#".$id." .rb_divider{
				background-image: linear-gradient(90deg, transparent, transparent 50%, #fff 50%, #fff 100%), linear-gradient(90deg, ".esc_attr($color).", ".esc_attr($helper_color).");
			}
		";
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( !empty($vc_landscape_styles) ){
		$styles .= "
			@media 
				screen and (max-width: 1199px),
				screen and (max-width: 1366px) and (any-hover: none)
			{
		";

			$styles .= "
				#".$id."{
					".$vc_landscape_styles.";
				}
			";

		$styles .= "
			}
		";
	}
	/* -----> End of landscape styles <----- */

	/* -----> Customize portrait styles <----- */
	if( !empty($vc_portrait_styles) ){
		$styles .= "
			@media screen and (max-width: 991px){
		";

			$styles .= "
				#".$id."{
					".$vc_portrait_styles.";
				}
			";

		$styles .= "
			}
		";
	}
	/* -----> End of portrait styles <----- */

	/* -----> Customize mobile styles <----- */
	if( !empty($vc_mobile_styles) ){
		$styles .= "
			@media screen and (max-width: 767px){
		";

			$styles .= "
				#".$id."{
					".$vc_mobile_styles.";
				}
			";

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */
	
	rb__vc_styles($styles);

	$module_classes = 'rb_divider_wrapper';
	$module_classes .= ' '.esc_attr($style);
	$module_classes .= !empty($el_class) ? ' '.esc_attr($el_class) : '';
	
	/* -----> Divider module output <----- */
	$out .= "<div id='".$id."' class='".$module_classes."'>";
		$out .= "<div class='rb_divider'><span></span></div>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_divider', 'rb_vc_shortcode_sc_divider' );

?>