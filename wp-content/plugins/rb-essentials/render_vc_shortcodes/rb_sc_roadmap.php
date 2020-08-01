<?php

function rb_vc_shortcode_sc_roadmap ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"style"						=> "square",
		"values"					=> "",
		"el_class"					=> "",
		/* -----> STYLING TAB <----- */
		"custom_styles"				=> "",
		"shape_bg"					=> "#434974",
		"active_shape_bg"			=> PRIMARY_COLOR,
		"icon_color"				=> '#fff',
		"active_icon_color"			=> '#fff',
		"number_color"				=> "#fff",
		"active_number_color"		=> PRIMARY_COLOR,
		"number_background"			=> PRIMARY_COLOR,
		"active_number_background"	=> "#fff",
		"title_color"				=> "#000",
		"text_color"				=> "#4C4C4D",
		"line_color"				=> "#73778C",
		"arrow_color"				=> PRIMARY_COLOR,
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_size"	=> false,
			"title_size"		=> "20px",
			"title_margins"		=> "45px 0px 0px 0px",
			"text_size"			=> "16px",
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Parse values array <----- */
	$values = (array)vc_param_group_parse_atts($values);

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$id = uniqid( "rb_roadmap_" );

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
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
					font-size: ".(int)$title_size."px;
				}
			";
		}
		if( !empty($title_margins) ){
			$styles .= "
				#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
					margin: ".$title_margins.";
				}
			";
		}
		if( !empty($text_size) ){
			$styles .= "
				#".$id." .roadmap_description{
					font-size: ".(int)$text_size."px;
				}
			";
		}
	}
	if( !empty($shape_bg) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_icon_wrapper{
				background-color: ".esc_attr($shape_bg).";
			}
		";
	}
	if( !empty($active_shape_bg) ){
		$styles .= "
			#".$id." .rb_roadmap_item.active .roadmap_icon_wrapper{
				background-color: ".esc_attr($active_shape_bg).";
			}
		";
	}
	if( !empty($icon_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_icon_wrapper > i{
				color: ".esc_attr($icon_color).";
			}
		";
	}
	if( !empty($active_icon_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item.active .roadmap_icon_wrapper > i{
				color: ".esc_attr($active_icon_color).";
			}
		";
	}
	if( !empty($number_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_icon_wrapper .number{
				color: ".esc_attr($number_color).";
			}
		";
	}
	if( !empty($active_number_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item.active .roadmap_icon_wrapper .number{
				color: ".esc_attr($active_number_color).";
			}
		";
	}
	if( !empty($number_background) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_icon_wrapper .number{
				background-color: ".esc_attr($number_background).";
			}
		";
	}
	if( !empty($active_number_background) ){
		$styles .= "
			#".$id." .rb_roadmap_item.active .roadmap_icon_wrapper .number{
				background-color: ".esc_attr($active_number_background).";
			}
		";
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_description{
				color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($line_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_divider{
				background-image: linear-gradient(90deg, ".esc_attr($line_color).", ".esc_attr($line_color)." 40%, transparent 40%, transparent 100%);
			}
		";
	}
	if( !empty($arrow_color) ){
		$styles .= "
			#".$id." .rb_roadmap_item .roadmap_divider:after{
				color: ".esc_attr($arrow_color).";
			}
		";
	}
 	/* -----> End of default styles <----- */

 	/* -----> Customize landscape styles <----- */
	if( 
		!empty($vc_landscape_styles) ||
		$customize_size_landscape
	){
		$styles .= "
			@media 
				screen and (max-width: 1199px), /*Check, is device a tablet*/
				screen and (max-width: 1366px) and (any-hover: none) /*Enable this styles for iPad Pro 1024-1366*/
			{";

				if( !empty($vc_landscape_styles) ){
					$styles .= "#".$id."{
						".$vc_landscape_styles."
					}";
				}
				if( $customize_size_landscape ){
					if( !empty($title_size_landscape) ){
						$styles .= "
							#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
								font-size: ".(int)$title_size_landscape."px;
							}
						";
					}
					if( !empty($title_margins_landscape) ){
						$styles .= "
							#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
								margin: ".$title_margins_landscape.";
							}
						";
					}
					if( !empty($text_size_landscape) ){
						$styles .= "
							#".$id." .roadmap_description{
								font-size: ".(int)$text_size_landscape."px;
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
		$customize_size_portrait
	){
		$styles .= "
			@media screen and (max-width: 991px){
		";

				if( !empty($vc_portrait_styles) ){
					$styles .= "#".$id."{
						".$vc_portrait_styles."
					}";
				}
				if( $customize_size_portrait ){
					if( !empty($title_size_portrait) ){
						$styles .= "
							#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
								font-size: ".(int)$title_size_portrait."px;
							}
						";
					}
					if( !empty($title_margins_portrait) ){
						$styles .= "
							#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
								margin: ".$title_margins_portrait.";
							}
						";
					}
					if( !empty($text_size_portrait) ){
						$styles .= "
							#".$id." .roadmap_description{
								font-size: ".(int)$text_size_portrait."px;
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
		$customize_size_mobile
	){
		$styles .= "
			@media screen and (max-width: 767px){
		";

				if( !empty($vc_mobile_styles) ){
					$styles .= "#".$id."{
						".$vc_mobile_styles."
					}";
				}
				if( $customize_size_mobile ){
					if( !empty($title_size_mobile) ){
						$styles .= "
							#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
								font-size: ".(int)$title_size_mobile."px;
							}
						";
					}
					if( !empty($title_margins_mobile) ){
						$styles .= "
							#".$id." .rb_roadmap_item .roadmap_content_wrapper .roadmap_title{
								margin: ".$title_margins_mobile.";
							}
						";
					}
					if( !empty($text_size_mobile) ){
						$styles .= "
							#".$id." .roadmap_description{
								font-size: ".(int)$text_size_mobile."px;
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

 	/* -----> Roadmap classes <----- */

 	$extra_classes = 'style_'.esc_attr($style);

	/* -----> Roadmap module output <----- */
	$out .= "<div id='".$id."' class='rb_roadmap_module ".$extra_classes." ".esc_attr($el_class)."'>";

		foreach ($values as $value) {
			/* -----> Getting Icon <----- */
			$icon_output = '';

			if( !empty($value['icon_lib']) ){
				if( $value['icon_lib'] == 'rb_svg' ){
					$icon = "icon_".$value['icon_lib'];
					$svg_icon = json_decode(str_replace("``", "\"", $value[$icon]), true);
					$upload_dir = wp_upload_dir();
					$this_folder = $upload_dir['basedir'] . '/rb-svgicons/' . md5($svg_icon['collection']) . '/';

					$icon_output .= "<i class='svg' style='width:".$svg_icon['width']."px; height:".$svg_icon['height']."px;'>";
						$icon_output .= file_get_contents($this_folder . $svg_icon['name']);
					$icon_output .= "</i>";
				} else {
					$icon = array_keys($value)[1];

					if( !empty($value[$icon]) ){
						$icon_output .= '<i class="'.esc_attr($value[$icon]).'"></i>';
					}
				}
			}

			/* -----> Roadmap Item <----- */
			$out .= "<div class='rb_roadmap_item".( isset($value['active']) ? ' active' : '' )."'>";

				$out .= "<div class='roadmap_icon_wrapper'>";
					$out .= $icon_output;

					if( !empty($value['number']) ){
						$out .= "<span class='number title_ff'>";
							$out .= isset($value['active']) ? '<i></i>' : esc_html($value['number']);
						$out .= "</span>";
					}
				$out .= "</div>";

				$out .= "<span class='roadmap_divider'></span>";

				$out .= "<div class='roadmap_content_wrapper'>";
					if( !empty($value['title']) ){
						$out .= "<p class='h3 roadmap_title'>".esc_html($value['title'])."</p>";
					}
					if( !empty($value['description']) ){
						$description = wp_kses( $value['description'], array(
							"b"			=> array(),
							"strong"	=> array(),
							"mark"		=> array(),
							"br"		=> array()
						));

						$out .= "<p class='roadmap_description'>".$description."</p>";
					}
				$out .= "</div>";
			$out .= "</div>";
		}

	$out .= "</div>";

	
	return $out;
}
add_shortcode( 'rb_sc_roadmap', 'rb_vc_shortcode_sc_roadmap' );

?>