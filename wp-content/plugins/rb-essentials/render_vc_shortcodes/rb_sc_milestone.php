<?php

function rb_vc_shortcode_sc_milestone ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"style"							=> "simple",
		"icon_lib"						=> "FontAwesome",
		"icon_shape"					=> "none",
		"title"							=> "",
		"count"							=> "50",
		"symbol"						=> "%",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"icon_shape_color"				=> PRIMARY_COLOR,
		"icon_color"					=> "#fff",
		"count_color"					=> "#000",
		"title_color"					=> "#4C4C4D",
		"bg_hover_color"				=> "",
		"shadow_color"					=> "rgba(0,0,0,.15)",
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_align"	=> false,
			"alignment"			=> "left",
			"customize_size"	=> false,
			"icon_size"			=> "36px",
			"count_size"		=> "36px",
			"title_size"		=> "14px",
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $icon_output = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$icon = esc_attr(rb_ext_vc_sc_get_icon($atts));
	$id = uniqid( "rb_milestone_" );
	$title = wp_kses( $title, array(
		"b"			=> array(),
		"strong"	=> array(),
		"mark"		=> array(),
		"br"		=> array()
	));

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
				text-align: ".$alignment.";
			}
		";
	}
	if( $customize_size ){
		if( !empty($icon_size) ){
			$styles .= "
				#".$id." .milestone_wrapper .milestone_content .milestone_icon i,
				#".$id." .milestone_wrapper .milestone_content .milestone_icon i:before{
					font-size: ".(int)$icon_size."px;
				}
				#".$id." .milestone_wrapper .milestone_content .milestone_icon:not(.shape_none){
					width: ".( (int)$icon_size + 34 )."px;
					height: ".( (int)$icon_size + 34 )."px;
					line-height: ".( (int)$icon_size + 34 )."px;
				}
			";
		}
		if( !empty($count_size) ){
			$styles .= "
				#".$id." .milestone_content{
					font-size: ".esc_attr($count_size).";
				}
			";
		}
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .milestone_content{
					font-size: ".esc_attr($title_size).";
				}
			";
		}
	}
	if( !empty($icon_shape_color) ){
		$styles .= "
			#".$id." .milestone_wrapper .milestone_content .milestone_icon:not(.shape_none){
				background-color: ".esc_attr($icon_shape_color).";
			}
		";
	}
	if( !empty($icon_color) ){
		$styles .= "
			#".$id." .milestone_wrapper .milestone_content .milestone_icon i{
				color: ".esc_attr($icon_color).";
			}
		";
	}
	if( !empty($count_color) ){
		$styles .= "
			#".$id." .milestone_wrapper .milestone_content .count_wrapper{
				color: ".esc_attr($count_color).";
			}
		";
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .milestone_wrapper .milestone_content .milestone_title{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($bg_hover_color) ){
		$styles .= "
			@media 
				screen and (min-width: 1367px),
				screen and (min-width: 1200px) and (any-hover: hover),
				screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0),
				screen and (min-width: 1200px) and (-ms-high-contrast: none),
				screen and (min-width: 1200px) and (-ms-high-contrast: active)
			{
				#".$id." .milestone_wrapper:hover{
					background-color: ".esc_attr($bg_hover_color).";
				}
			}
		";
	}
	if( !empty($shadow_color) ){
		$styles .= "
			#".$id." .milestone_wrapper.style_advanced{
				-webkit-box-shadow: 0px 0px 40px 0px ".esc_attr($shadow_color).";
				-moz-box-shadow: 0px 0px 40px 0px ".esc_attr($shadow_color).";
				box-shadow: 0px 0px 40px 0px ".esc_attr($shadow_color).";
			}
		";
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( 
		!empty($vc_landscape_styles) ||
		$customize_align_landscape ||
		$customize_size_landscape
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
					#".$id."{
						text-align: ".$alignment_landscape.";
					}
				";
			}
			if( $customize_size_landscape ){
				if( !empty($icon_size_landscape) ){
					$styles .= "
						#".$id." .milestone_wrapper .milestone_content .milestone_icon i,
						#".$id." .milestone_wrapper .milestone_content .milestone_icon i:before{
							font-size: ".(int)$icon_size_landscape."px;
						}
						#".$id." .milestone_wrapper .milestone_content .milestone_icon:not(.shape_none){
							width: ".( (int)$icon_size_landscape + 34 )."px;
							height: ".( (int)$icon_size_landscape + 34 )."px;
							line-height: ".( (int)$icon_size_landscape + 34 )."px;
						}
					";
				}
				if( !empty($count_size_landscape) ){
					$styles .= "
						#".$id." .milestone_content{
							font-size: ".esc_attr($count_size_landscape).";
						}
					";
				}
				if( !empty($title_size_landscape) ){
					$styles .= "
						#".$id." .milestone_content{
							font-size: ".esc_attr($title_size_landscape).";
						}
					";
				}
			}

		$styles .= "
			}
		";
	}
	/* -----> End of landscape styles <----- */

	/* -----> Customize portrait styles <----- */
	if( 
		!empty($vc_portrait_styles) ||
		$customize_align_portrait ||
		$customize_size_portrait
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
					#".$id."{
						text-align: ".$alignment_portrait.";
					}
				";
			}
			if( $customize_size_portrait ){
				if( !empty($icon_size_portrait) ){
					$styles .= "
						#".$id." .milestone_wrapper .milestone_content .milestone_icon i,
						#".$id." .milestone_wrapper .milestone_content .milestone_icon i:before{
							font-size: ".(int)$icon_size_portrait."px;
						}
						#".$id." .milestone_wrapper .milestone_content .milestone_icon:not(.shape_none){
							width: ".( (int)$icon_size_portrait + 34 )."px;
							height: ".( (int)$icon_size_portrait + 34 )."px;
							line-height: ".( (int)$icon_size_portrait + 34 )."px;
						}
					";
				}
				if( !empty($count_size_portrait) ){
					$styles .= "
						#".$id." .milestone_content{
							font-size: ".esc_attr($count_size_portrait).";
						}
					";
				}
				if( !empty($title_size_portrait) ){
					$styles .= "
						#".$id." .milestone_content{
							font-size: ".esc_attr($title_size_portrait).";
						}
					";
				}
			}

		$styles .= "
			}
		";
	}
	/* -----> End of portrait styles <----- */

	/* -----> Customize mobile styles <----- */
	if( 
		!empty($vc_mobile_styles) ||
		$customize_align_mobile ||
		$customize_size_mobile
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
					#".$id."{
						text-align: ".$alignment_mobile.";
					}
				";
			}
			if( $customize_size_mobile ){
				if( !empty($icon_size_mobile) ){
					$styles .= "
						#".$id." .milestone_wrapper .milestone_content .milestone_icon i,
						#".$id." .milestone_wrapper .milestone_content .milestone_icon i:before{
							font-size: ".(int)$icon_size_mobile."px;
						}
						#".$id." .milestone_wrapper .milestone_content .milestone_icon:not(.shape_none){
							width: ".( (int)$icon_size_mobile + 34 )."px;
							height: ".( (int)$icon_size_mobile + 34 )."px;
							line-height: ".( (int)$icon_size_mobile + 34 )."px;
						}
					";
				}
				if( !empty($count_size_mobile) ){
					$styles .= "
						#".$id." .milestone_content{
							font-size: ".esc_attr($count_size_mobile).";
						}
					";
				}
				if( !empty($title_size_mobile) ){
					$styles .= "
						#".$id." .milestone_content{
							font-size: ".esc_attr($title_size_mobile).";
						}
					";
				}
			}

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */ 

	rb__vc_styles($styles);

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

	$module_classes = 'rb_milestone_module';
	$gradient = uniqid('gradient_');
	$icon_gradient = uniqid('icon_gradient_');

	/* -----> Milestone module output <----- */
	$out .= "<div id='".$id."' class='rb_milestone_module'>";
		$out .= "<div class='milestone_wrapper style_".$style."'>";

			$out .= "<div class='milestone_content'>";
				if( !empty($icon_output) ){
					$out .= "<div class='milestone_icon".($style != 'advanced' ? ' shape_'.$icon_shape : '')."'>";
						$out .= $icon_output;
					$out .= "</div>";
				}
				if( !empty($count) ){
					$out .= "<div class='count_wrapper title_ff'>";
						$out .= "<span class='counter'>".esc_html($count)."</span>";
						if( !empty($symbol) ){
							$out .= "<span class='symbol'>".esc_html($symbol)."</span>";
						}
					$out .= "</div>";
				}
				if( !empty($title) ){
					$out .= "<p class='milestone_title'>".$title."</p>";
				}
			$out .= "</div>";

		$out .= "</div>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_milestone', 'rb_vc_shortcode_sc_milestone' );

?>