<?php

function rb_vc_shortcode_sc_button ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"icon_lib"						=> "FontAwesome",
		"title"							=> "Click Me!",
		"url"							=> "#",
		"new_tab"						=> true,
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"btn_size"						=> "large",
		"font_size"						=> "18px",
		"spacings"						=> "",
		"btn_style"						=> "arrow_fade_out",
		"btn_font_color"				=> '#fff',
		"btn_font_color_hover"			=> '#fff',
		"btn_bg_color"					=> PRIMARY_COLOR,
		"btn_bg_color_hover"			=> PRIMARY_COLOR,
		"btn_border_color"				=> PRIMARY_COLOR,
		"btn_border_color_hover"		=> PRIMARY_COLOR,
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_align"	=> false,
			"aligning"			=> "left",
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$icon = esc_attr(rb_ext_vc_sc_get_icon($atts));
	$id_wrapper = uniqid( "rb_button_wrapper_" );
	$id = uniqid( "rb_button_" );

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
	if( $customize_align ){
		$styles .= "
			#".$id_wrapper."{
				text-align: ".$aligning.";
			}
		";
	}
	if( !empty($vc_desktop_styles) ){
		$styles .= "
			#".$id."{
				".$vc_desktop_styles."
			}
		";
	}
	if( !empty($btn_font_color) ){
		$styles .= "
			#".$id."{
				color: ".esc_attr($btn_font_color).";	
			}
		";
	}
	if( !empty($btn_bg_color) ){
		$styles .= "
			#".$id."{
				background-color: ".esc_attr($btn_bg_color).";	
			}
		";
	}
	if( !empty($btn_border_color) ){
		$styles .= "
			#".$id."{
				border-color: ".esc_attr($btn_border_color).";	
			}
		";
	}
	$styles .= "
		@media 
			screen and (min-width: 1367px),
			screen and (min-width: 1200px) and (any-hover: hover),
			screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0),
			screen and (min-width: 1200px) and (-ms-high-contrast: none),
			screen and (min-width: 1200px) and (-ms-high-contrast: active)
		{
	";

		if( !empty($btn_font_color_hover) ){
			$styles .= "
				#".$id.".arrow_fade_in:hover span:after,
				#".$id.":hover{
					color: ".esc_attr($btn_font_color_hover).";
				}
			";			
		}
		if( !empty($btn_bg_color_hover) ){
			$styles .= "
				#".$id.":hover{
					background-color: ".esc_attr($btn_bg_color_hover).";
				}
			";
		}
		if( !empty($btn_border_color_hover) ){
			$styles .= "
				#".$id.":hover{
					border-color: ".esc_attr($btn_border_color_hover).";
				}
			";
		}

	$styles .= "
		}
	";
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( 
		!empty($vc_landscape_styles) || 
		$customize_align_landscape 
	){
		$styles .= "
			@media 
				screen and (max-width: 1199px), /*Check, is device a tablet*/
				screen and (max-width: 1366px) and (any-hover: none) /*Enable this styles for iPad Pro 1024-1366*/
			{
		";

			if( !empty($vc_landscape_styles) ){
				$styles .= "
					#".$id."{
						".$vc_landscape_styles."
					}
				";
			}
			if( $customize_align_landscape ){
				$styles .= "
					#".$id_wrapper."{
						text-align: ".$aligning_landscape.";
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
						".$vc_portrait_styles."
					}
				";
			}
			if( $customize_align_portrait ){
				$styles .= "
					#".$id_wrapper."{
						text-align: ".$aligning_portrait.";
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
						".$vc_mobile_styles."
					}
				";
			}
			if( $customize_align_mobile ){
				$styles .= "
					#".$id_wrapper."{
						text-align: ".$aligning_mobile.";
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */ 

	rb__vc_styles($styles);

	/* -----> Getting Icon <----- */
	if( !empty($icon_lib) ){
		$icon_output = '';
		if( $icon_lib == 'rb_svg' ){
			$icon = "icon_".$icon_lib;
			$svg_icon = json_decode(str_replace("``", "\"", $atts[$icon]), true);
			$upload_dir = wp_upload_dir();
			$this_folder = $upload_dir['basedir'] . '/rb-svgicons/' . md5($svg_icon['collection']) . '/';

			$icon_output .= "<i class='svg' style='width:".$svg_icon['width']."px; height:".$svg_icon['height']."px;'>";
				$icon_output .= file_get_contents($this_folder . $svg_icon['name']);
			$icon_output .= "</i>";
		} else {
			if( !empty($icon) ){
				$icon_output .= '<i class="'.esc_attr($icon).'"></i>';
			}
		}
	}

	$button_classes = 'rb_button ';
	$button_classes .= esc_attr($btn_style);
	$button_classes .= $btn_size != 'default' ? ' '.esc_attr($btn_size) : '';

	/* -----> Button module output <----- */
	if( !empty($title) ){
		$out .= "<div id='".$id_wrapper."' class='rb_button_wrapper ".esc_attr($el_class)."'>";
			$out .= "<a id='".$id."' class='".$button_classes."' href='".(!empty($url) ? $url : '#')."' ".($new_tab ? 'target="_blank"' : '').">";
				$out .= "<span>";
					$out .= $icon_output;
					$out.= esc_html($title);
				$out .= "</span>";
			$out .= "</a>";
		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_button', 'rb_vc_shortcode_sc_button' );

?>