<?php

function rb_vc_shortcode_sc_popup_video ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"icon_lib"				=> "FontAwesome",
		"title"					=> "",
		"url"					=> "#",
		"el_class"				=> "",
		/* -----> STYLING TAB <----- */
		"icon_color"			=> PRIMARY_COLOR,
		"icon_shape_color"		=> "#fff",
		"pulse_color"			=> "rgba(255,255,255, .3)",
		"title_color"			=> "#fff",
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_size"	=> false,
			"icon_size"			=> "26px",
			"title_size"		=> "18px",
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$icon = esc_attr(rb_ext_vc_sc_get_icon($atts));
	$id = uniqid( "rb_popup_video_" );

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
	if( $customize_size ){
		if( !empty($icon_size) ){
			$styles .= "
				#".$id." .icon_wrapper i{
					font-size: ".(int)esc_attr($icon_size)."px;
				}
			";
		}
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .icon_title{
					font-size: ".(int)esc_attr($title_size)."px;
				}
			";	
		}
	}
	if( !empty($icon_color) ){
		$styles .= "
			#".$id." .icon_wrapper i{
				color: ".esc_attr($icon_color).";
			}
		";	
	}
	if( !empty($icon_shape_color) ){
		$styles .= "
			#".$id." .icon_wrapper{
				background-color: ".esc_attr($icon_shape_color).";
			}
		";	
	}
	if( !empty($pulse_color) ){
		$styles .= "
			#".$id." .icon_wrapper .circle{
				border-color: ".esc_attr($pulse_color).";
			}
		";	
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .icon_title{
				color: ".esc_attr($title_color).";
			}
		";	
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( !empty($vc_landscape_styles) ){
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

			if( !empty($vc_portrait_styles) ){
				$styles .= "
					#".$id."{
						".$vc_portrait_styles."
					}
				";
			}

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

			if( !empty($vc_mobile_styles) ){
				$styles .= "
					#".$id."{
						".$vc_mobile_styles."
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */ 

	rb__vc_styles($styles);

	$icon_output = '';

	/* -----> Getting Icon <----- */
	if( !empty($icon_lib) ){
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

	/* -----> Filter Products module output <----- */
	$out .= "<div id='".$id."' class='rb_popup_video_module ".esc_attr($el_class)."'>";
		if( !empty($url) ){
			$out .= "<a class='video-link' href='".esc_url($url)."'>";
				if( !empty($icon_output) ){
					$out .= "<span class='icon_wrapper'>";
						$out .= '<span class="circle"></span>';
						$out .= '<span class="circle"></span>';
						$out .= '<span class="circle"></span>';

						$out .= $icon_output;
					$out .= "</span>";
				}
				if( !empty($title) ){
					$out .= "<p class='icon_title'>".esc_html($title)."</p>";
				}
			$out .= "</a>";
		}
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_popup_video', 'rb_vc_shortcode_sc_popup_video' );

?>