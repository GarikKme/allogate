<?php

function rb_vc_shortcode_sc_image ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"image"							=> "",
		"hover_image"					=> "",
		"bg_hover"						=> "no_hover",
		"max_tilt"						=> "10",
		"perspective"					=> "1000",
		"scale"							=> "1",
		"speed"							=> "300",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_align"	=> false,
			"alignment"			=> "center",
		),
	);
	$responsive_vars = add_bg_properties($responsive_vars); //Add custom background properties to responsive vars array

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$id = uniqid( "rb_image_" );
	$image_alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
	$image = !empty($image) ? wp_get_attachment_image_src($image, 'full')[0] : '';

	$hover_image_alt = get_post_meta($hover_image, '_wp_attachment_image_alt', TRUE);
	$hover_image = !empty($hover_image) ? wp_get_attachment_image_src($hover_image, 'full')[0] : '';
	
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
				".$vc_desktop_styles."
			}
		";
	}
	if( $customize_align ){
		$styles .= "
			#".$id."{
				text-align: ".esc_attr($alignment).";
			}
		";
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( 
		!empty($vc_landscape_styles) || 
		$customize_align_landscape
	){
		$styles .= "
			@media 
				screen and (max-width: 1199px),
				screen and (max-width: 1366px) and (any-hover: none)
			{
		";

			if( !empty($vc_landscape_styles) ){
				$styles .= "
					#".$id."{
						".$vc_landscape_styles.";
					}
				";
			}
			if( $customize_align_landscape ){
				$styles .= "
					#".$id."{
						text-align: ".esc_attr($alignment_landscape).";
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of landscape styles <----- */

	/* -----> Customize portrait styles <----- */
	if( 
		!empty($vc_portrait_styles) || 
		$customize_align_portrait
	){
		$styles .= "
			@media screen and (max-width: 991px){
		";

			if( !empty($vc_portrait_styles) ){
				$styles .= "
					#".$id."{
						".$vc_portrait_styles.";
					}
				";
			}
			if( $customize_align_portrait ){
				$styles .= "
					#".$id."{
						text-align: ".esc_attr($alignment_portrait).";
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of portrait styles <----- */

	/* -----> Customize mobile styles <----- */
	if( 
		!empty($vc_mobile_styles) || 
		$customize_align_mobile
	){
		$styles .= "
			@media screen and (max-width: 767px){
		";

			if( !empty($vc_mobile_styles) ){
				$styles .= "
					#".$id."{
						".$vc_mobile_styles.";
					}
				";
			}
			if( $customize_align_mobile ){
				$styles .= "
					#".$id."{
						text-align: ".esc_attr($alignment_mobile).";
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */

	rb__vc_styles($styles);

	$module_classes = " background_".$bg_hover;

	$module_atts = "";
	if( $bg_hover == '3d' ){
		$module_atts .= !empty($max_tilt) ? ' data-max_tilt='.$max_tilt.'' : 'data-max_tilt="10"';
		$module_atts .= !empty($perspective) ? ' data-perspective='.$perspective.'' : 'data-perspective="1000"';
		$module_atts .= !empty($scale) ? ' data-scale='.$scale.'' : 'data-scale="1"';
		$module_atts .= !empty($speed) ? ' data-speed='.$speed.'' : 'data-speed="300"';
	}

	if( !empty($el_class) ){
		$module_classes .= " ".esc_attr($el_class);
	}

	/* -----> Image module output <----- */
	if( !empty($image) ){

		$out .= "<div id='".$id."' class='rb_image_module".$module_classes."' ".esc_attr($module_atts).">";

			$out .= '<div class="main_image">';
				if( !empty($hover_image) ){
					$out .= '<img class="hover_image" src="'.$hover_image.'" alt="'.esc_attr($hover_image_alt).'" />';
				}
				$out .= '<img class="image" src="'.$image.'" alt="'.esc_attr($image_alt).'" />';
			$out .= '</div>';

		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_image', 'rb_vc_shortcode_sc_image' );

?>