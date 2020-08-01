<?php 

function rb_vc_shortcode_sc_logo ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"image"						=> "",
		"width"						=> "",
		"height"					=> "",
		"retina"					=> true,
		"el_class"					=> "",
 	);
 	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		"all" => array(
 			"custom_styles"		=> "",
 			"customize_align"	=> false,
			"alignment"			=> "left",
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true);
	$image = !empty($image) ? wp_get_attachment_image_src($image, 'full') : '';
	$retina_w = !empty($image) ? (int)($image[1] / 2) : '';
	$id = uniqid( "rb_logo_" );

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
					.".$id."{
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
					.".$id."{
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
					.".$id."{
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

	$module_styles = empty($width) ? 'width:'.$retina_w.'px;' : 'width:'.(int)esc_attr($width).'px;';
	$module_styles .= !empty($height) ? ' height:'.(int)esc_attr($height).'px;' : '';
	
	/* -----> Logotype module output <----- */
	$out .= "<div id='".$id."' class='site_logotype". ( !empty($el_class) ? " $el_class" : "" ) ."'>";
		$out .= "<a href='".esc_url(home_url('/'))."'>";
			if( !empty($image) ){
				$out .= "<img src='".esc_url($image[0])."' alt='".esc_attr($image_alt)."' style='". $module_styles ."'>";
			} else {
				ob_start();
					setech_logo('logotype', 'logo_dimensions', 'h3');
				$out .= ob_get_clean();
			}
		$out .= "</a>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_logo', 'rb_vc_shortcode_sc_logo' );

?>