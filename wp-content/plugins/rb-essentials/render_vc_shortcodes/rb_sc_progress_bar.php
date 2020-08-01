<?php

function rb_vc_shortcode_sc_progress_bar ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		'title'						=> '',
		'percents'					=> '',
		'title_color'				=> "#000",
		'percents_color'			=> PRIMARY_COLOR,
		'gradient_color_1'			=> PRIMARY_COLOR,
		'gradient_color_2'			=> PRIMARY_COLOR,
		'el_class'					=> '',
 	);

 	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		"all" => array(
 			"custom_styles"		=> "",
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$percents = !empty($percents) ? esc_attr($percents) : '100';
	$id = uniqid('rb_progress_bar_');

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
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .h6{
				color: ".esc_attr($title_color).";
			}
		";	
	}
	if( !empty($percents_color) ){
		$styles .= "
			#".$id." .percents{
				color: ".esc_attr($percents_color).";
			}
		";	
	}
	if( !empty($gradient_color_1) && !empty($gradient_color_2) ){
		$styles .= "
			#".$id." .bar{
				background: -webkit-linear-gradient(to right, ".esc_attr($gradient_color_1).", ".esc_attr($gradient_color_2).");
    			background: linear-gradient(to right, ".esc_attr($gradient_color_1).", ".esc_attr($gradient_color_2).");
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
				#".$id."{
					".$vc_landscape_styles.";
				}
			}
		";
	}
	/* -----> End of landscape styles <----- */

	/* -----> Customize portrait styles <----- */
	if( !empty($vc_portrait_styles) ){
		$styles .= "
			@media screen and (max-width: 991px){
				#".$id."{
					".$vc_portrait_styles.";
				}
			}
		";
	}
	/* -----> End of portrait styles <----- */

	/* -----> Customize mobile styles <----- */
	if( !empty($vc_mobile_styles) ){
		$styles .= "
			@media screen and (max-width: 767px){
				#".$id."{
					".$vc_mobile_styles.";
				}
			}
		";
	}
	/* -----> End of mobile styles <----- */
	rb__vc_styles($styles);
	
	/* -----> Divider module output <----- */
	$out .= "<div id='".$id."' class='rb_progress_bar_module ".esc_attr($el_class)."'>";
		if( !empty($title) ){
			$out .= "<p>".esc_html($title)."</p>";
		}
		$out .= "<div class='progress_bar'>";
			$out .= "<span class='bar' data-percent='".$percents."'>";
				$out .= "<span class='percents'>".(int)esc_html($percents)."%</span>";
			$out .= "</span>";
		$out .= "</div>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_progress_bar', 'rb_vc_shortcode_sc_progress_bar' );

?>