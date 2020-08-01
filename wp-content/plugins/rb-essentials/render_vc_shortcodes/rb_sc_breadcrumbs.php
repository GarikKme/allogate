<?php 

function rb_vc_shortcode_sc_breadcrumbs ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"label"					=> "Search",
		"el_class"				=> "",
		/* -----> STYLING TAB <----- */
		"color"					=> "#858585",
		"color_hover"			=> "#141414",
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
	$id = uniqid( "rb_breadcrumbs_" );

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
	if( !empty($color) ){
		$styles .= "
			#".$id." .bread-crumbs,
			#".$id." .bread-crumbs *{
				color: ".esc_attr($color).";
			}
		";
	}
	if( !empty($color_hover) ){
		$styles .= "
			@media 
				screen and (min-width: 1367px), /*Disable this styles for iPad Pro 1024-1366*/
				screen and (min-width: 1200px) and (any-hover: hover), /*Check, is device a desktop (Not working on IE & FireFox)*/
				screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0), /*Check, is device a desktop with firefox*/
				screen and (min-width: 1200px) and (-ms-high-contrast: none), /*Check, is device a desktop with IE 10 or above*/
				screen and (min-width: 1200px) and (-ms-high-contrast: active) /*Check, is device a desktop with IE 10 or above*/
			{
				#".$id." .bread-crumbs a:hover{
					color: ".$color_hover.";
				}
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
	
	/* -----> Logotype module output <----- */
	if( !is_front_page() ){
		$out .= "<div id='".$id."' class='rb_breadcrumbs_module". ( !empty($el_class) ? " $el_class" : "" ) ."'>";
			ob_start();
				setech_dimox_breadcrumbs();
			$breadcrumbs = ob_get_clean();

			if( !empty($breadcrumbs) ){
				$out .= sprintf('%s', $breadcrumbs);
			}
		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_breadcrumbs', 'rb_vc_shortcode_sc_breadcrumbs' );

?>