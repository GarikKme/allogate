<?php
function rb_vc_shortcode_sc_service ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"icon_lib"						=> "FontAwesome",
		"icon_img"						=> "icon",
		"style"							=> "icon_top",
		"image"							=> "",
		"icon_shape"					=> "none",
		"vertical_align"				=> "flex-start",
		"title"							=> "",
		"title_tag"						=> "h3",
		"url"							=> "",
		"new_tab"						=> true,
		"author"						=> "",
		"author_divider"				=> "rgba(0,0,0,.5)",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"hover"							=> "none",
		"hover_image"					=> "",
		"hover_color"					=> PRIMARY_COLOR,
		"customize_colors"				=> true,
		"shape_color"					=> "#fff",
		"shape_hover_color"				=> "#fff",
		"icon_color"					=> PRIMARY_COLOR,
		"icon_hover_color"				=> PRIMARY_COLOR,
		"title_color"					=> "#000",
		"title_hover_color"				=> "#000",
		"text_color"					=> "rgba(0, 0, 0, .75)",
		"text_hover_color"				=> "rgba(0, 0, 0, .75)",
		"text_links_hover"				=> PRIMARY_COLOR,
		"shadow_color"					=> "",
		"shadow_hover_color"			=> "",
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_align"	=> false,
			"module_alignment"	=> "left",
			"customize_size"	=> false,
			"icon_size"			=> "30px",
			"title_size"		=> "20px",
			"title_lh"			=> "initial",
			"text_size"			=> "15px",
			"text_lh"			=> "27px",
			"title_margins"		=> "23px 0px 0px 0px",
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$icon = esc_attr(rb_ext_vc_sc_get_icon($atts));
	$image_alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
	$image = !empty($image) ? wp_get_attachment_image_src($image, 'full')[0] : '';
	$content = apply_filters( "the_content", $content );
	$id = uniqid( "rb_service_" );
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
	if( ($style == 'icon_left' || $style == 'icon_right') && !empty($vertical_align) ){
		$styles .= "
			#".$id."{
				-webkit-align-items: ".$vertical_align.";
				-moz-align-items: ".$vertical_align.";
				-ms-align-items: ".$vertical_align.";
				align-items: ".$vertical_align.";
			}
		";
	}
	if( !empty($author_divider) ){
		$styles .= "
			#".$id." .author_wrapper:before{
				background-color: ".$author_divider.";
			}
		";
	}
	if( $customize_align ){
		$styles .= "
			#".$id."{
				text-align: ".$module_alignment.";
			}
		";
	}
	if( $customize_size ){
		if( !empty($icon_size) ){
			$styles .= "
				#".$id." .service_image_wrapper{
					width: ".(int)esc_attr($icon_size)."px;
				}
				#".$id." .service_icon_wrapper i,
				#".$id." .service_icon_wrapper i:before{
					font-size: ".(int)esc_attr($icon_size)."px;
				}
				#".$id." .service_icon_wrapper i.svg{
					width: ".(int)esc_attr($icon_size)."px !important;
					height: ".(int)esc_attr($icon_size)."px !important;
				}
			";
		}
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .service_title{
					font-size: ".(int)esc_attr($title_size)."px;
				}
			";
		}
		if( !empty($title_lh) ){
			$styles .= "
				#".$id." .service_title{
					line-height: ".esc_attr($title_lh).";
				}
			";
		}
		if( !empty($text_size) ){
			$styles .= "
				#".$id." .content_wrapper{
					font-size: ".(int)esc_attr($text_size)."px;
				}
			";
		}
		if( !empty($text_lh) ){
			$styles .= "
				#".$id." .content_wrapper{
					line-height: ".esc_attr($text_lh).";
				}
			";
		}
		if( !empty($title_margins) ){
			$styles .= "
				#".$id." .service_title{
					margin: ".esc_attr($title_margins).";
				}
			";
		}
		if( !empty($icon_margins) ){
			$styles .= "
				#".$id." .service_icon_wrapper{
					margin: ".esc_attr($icon_margins).";
				}
			";
		}
	}
	if( $customize_colors ){
		if( !empty($shape_color) ){
			$styles .= "
				#".$id.":not(.shape_none) .service_icon_wrapper{
					background-color: ".esc_attr($shape_color).";
				}
			";
		}
		if( !empty($icon_color) ){
			$styles .= "
				#".$id." .service_icon_wrapper i,
				#".$id." .service_icon_wrapper i:before{
					color: ".esc_attr($icon_color).";
				}
				#".$id." .service_icon_wrapper svg{
					fill: ".esc_attr($icon_color).";
				}
			";
		}
		if( !empty($title_color) ){
			$styles .= "
				#".$id." .author_wrapper,
				#".$id." .service_title{
					color: ".esc_attr($title_color).";
				}
			";
		}
		if( !empty($text_color) ){
			$styles .= "
				#".$id." .content_wrapper,
				#".$id." .content_wrapper > a{
					color: ".esc_attr($text_color).";
				}
			";
		}
		if( !empty($shadow_color) ){
			$styles .= "
				#".$id."{
					-webkit-box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
					-moz-box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
					box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
				}
			";	
		}
		if( $hover == 'image' && !empty($hover_image) ){
			$styles .= "
				#".$id.":before {
					background-image: url(".wp_get_attachment_image_url($hover_image, 'full').");
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
			if( $hover == 'color' && !empty($hover_color) ){
				$styles .= "
					#".$id.":hover {
						background-color: ".esc_attr($hover_color)." !important;
					}
				";
			}
			if( !empty($shape_hover_color) ){
				$styles .= "
					#".$id.":not(.shape_none):hover .service_icon_wrapper{
						background-color: ".esc_attr($shape_hover_color).";
					}
				";
			}
			if( !empty($icon_hover_color) ){
				$styles .= "
					#".$id.":hover .service_icon_wrapper i,
					#".$id.":hover .service_icon_wrapper i:before{
						color: ".esc_attr($icon_hover_color).";
					}
					#".$id.":hover .service_icon_wrapper svg{
						fill: ".esc_attr($icon_hover_color).";
					}
				";
			}
			if( !empty($title_hover_color) ){
				$styles .= "
					#".$id.":hover .service_title{
						color: ".esc_attr($title_hover_color).";
					}
				";
			}
			if( !empty($text_hover_color) ){
				$styles .= "
					#".$id.":hover .content_wrapper,
					#".$id.":hover .content_wrapper > a{
						color: ".esc_attr($text_hover_color).";
					}
				";
			}
			if( !empty($text_links_hover) ){
				$styles .= "
					#".$id." .content_wrapper > a:hover{
						color: ".esc_attr($text_links_hover).";
					}
				";
			}
			if( !empty($shadow_hover_color) ){
				$styles .= "
					#".$id.":hover{
						-webkit-box-shadow: 0px 0px 16px -4px ".esc_attr($shadow_hover_color).";
						-moz-box-shadow: 0px 0px 16px -4px ".esc_attr($shadow_hover_color).";
						box-shadow: 0px 0px 16px -4px ".esc_attr($shadow_hover_color).";
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( 
		!empty($vc_landscape_styles) ||
		$customize_size_landscape || 
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
					#".$id."{
						text-align: ".$module_alignment_landscape.";
					}
				";
			}
			if( $customize_size_landscape ){
				if( !empty($icon_size_landscape) ){
					$styles .= "
						#".$id." .service_icon_wrapper i,
						#".$id." .service_icon_wrapper i:before{
							font-size: ".(int)esc_attr($icon_size_landscape)."px;
						}
						#".$id." .service_icon_wrapper i.svg{
							width: ".(int)esc_attr($icon_size_landscape)."px !important;
							height: ".(int)esc_attr($icon_size_landscape)."px !important;
						}
					";
				}
				if( !empty($title_size_landscape) ){
					$styles .= "
						#".$id." .service_title{
							font-size: ".(int)esc_attr($title_size_landscape)."px;
						}
					";
				}
				if( !empty($title_lh_landscape) ){
					$styles .= "
						#".$id." .service_title{
							line-height: ".esc_attr($title_lh_landscape).";
						}
					";
				}
				if( !empty($text_size_landscape) ){
					$styles .= "
						#".$id." .content_wrapper{
							font-size: ".(int)esc_attr($text_size_landscape)."px;
						}
					";
				}
				if( !empty($text_lh_landscape) ){
					$styles .= "
						#".$id." .content_wrapper{
							line-height: ".esc_attr($text_lh_landscape).";
						}
					";
				}
				if( !empty($title_margins_landscape) ){
					$styles .= "
						#".$id." .service_title{
							margin: ".esc_attr($title_margins_landscape).";
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
		$customize_size_portrait || 
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
					#".$id."{
						text-align: ".$module_alignment_portrait.";
					}
				";
			}
			if( $customize_size_portrait ){
				if( !empty($icon_size_portrait) ){
					$styles .= "
						#".$id." .service_icon_wrapper i,
						#".$id." .service_icon_wrapper i:before{
							font-size: ".(int)esc_attr($icon_size_portrait)."px;
						}
						#".$id." .service_icon_wrapper i.svg{
							width: ".(int)esc_attr($icon_size_portrait)."px !important;
							height: ".(int)esc_attr($icon_size_portrait)."px !important;
						}
					";
				}
				if( !empty($title_size_portrait) ){
					$styles .= "
						#".$id." .service_title{
							font-size: ".(int)esc_attr($title_size_portrait)."px;
						}
					";
				}
				if( !empty($title_lh_portrait) ){
					$styles .= "
						#".$id." .service_title{
							line-height: ".esc_attr($title_lh_portrait).";
						}
					";
				}
				if( !empty($text_size_portrait) ){
					$styles .= "
						#".$id." .content_wrapper{
							font-size: ".(int)esc_attr($text_size_portrait)."px;
						}
					";
				}
				if( !empty($text_lh_portrait) ){
					$styles .= "
						#".$id." .content_wrapper{
							line-height: ".esc_attr($text_lh_portrait).";
						}
					";
				}
				if( !empty($title_margins_portrait) ){
					$styles .= "
						#".$id." .service_title{
							margin: ".esc_attr($title_margins_portrait).";
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
		$customize_size_mobile || 
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
					#".$id."{
						text-align: ".$module_alignment_mobile.";
					}
				";
			}
			if( $customize_size_mobile ){
				if( !empty($icon_size_mobile) ){
					$styles .= "
						#".$id." .service_icon_wrapper i,
						#".$id." .service_icon_wrapper i:before{
							font-size: ".(int)esc_attr($icon_size_mobile)."px;
						}
						#".$id." .service_icon_wrapper i.svg{
							width: ".(int)esc_attr($icon_size_mobile)."px !important;
							height: ".(int)esc_attr($icon_size_mobile)."px !important;
						}
					";
				}
				if( !empty($title_size_mobile) ){
					$styles .= "
						#".$id." .service_title{
							font-size: ".(int)esc_attr($title_size_mobile)."px;
						}
					";
				}
				if( !empty($title_lh_mobile) ){
					$styles .= "
						#".$id." .service_title{
							line-height: ".esc_attr($title_lh_mobile).";
						}
					";
				}
				if( !empty($text_size_mobile) ){
					$styles .= "
						#".$id." .content_wrapper{
							font-size: ".(int)esc_attr($text_size_mobile)."px;
						}
					";
				}
				if( !empty($text_lh_mobile) ){
					$styles .= "
						#".$id." .content_wrapper{
							line-height: ".esc_attr($text_lh_mobile).";
						}
					";
				}
				if( !empty($title_margins_mobile) ){
					$styles .= "
						#".$id." .service_title{
							margin: ".esc_attr($title_margins_mobile).";
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

	$icon_output = '';

	$module_classes = 'rb_service_module';
	$module_classes .= ' style_'.esc_attr($style);
	$module_classes .= ' shape_'.esc_attr($icon_shape);
	$module_classes .= ' hover_'.esc_attr($hover);

	$module_classes .= $customize_align ? ' align_'.esc_attr($module_alignment) : '';
	$module_classes .= $customize_align_landscape ? ' landscape_align_'.esc_attr($module_alignment_landscape) : '';
	$module_classes .= $customize_align_portrait ? ' portrait_align_'.esc_attr($module_alignment_portrait) : '';
	$module_classes .= $customize_align_mobile ? ' mobile_align_'.esc_attr($module_alignment_mobile) : '';

	$module_classes .= ' '.esc_attr($el_class);

	$start_tag = !empty($url) ? "<a href='".esc_url($url)."'".($new_tab ? ' target="_blank"' : '')."" : "<div";
	$end_tag = !empty($url) ? "</a>" : "</div>";

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
	$out .= $start_tag." id='".$id."' class='".$module_classes."'>";
		if( $icon_img == 'icon' && !empty($icon) ){
			$out .= "<div class='service_icon_wrapper'>";
				$out .= $icon_output;
			$out .= "</div>";
		} else if( $icon_img == 'image' && !empty($image) ){
			$out .= "<div class='service_image_wrapper'>";
				$out .= "<img src='".esc_url($image)."' alt='".esc_attr($image_alt)."' />";
			$out .= "</div>";
		}
		$out .= '<div class="service_content_wrapper">';
			if( !empty($title) ){
				$out .= '<'.$title_tag.' class="service_title">';
					$out .= $title;
				$out .= '</'.$title_tag.'>';
			}
			if( !empty($content) ){
				$out .= "<div class='content_wrapper'>";
					$out .= $content;
				$out .= "</div>";
			}
			if( !empty($author) ){
				$out .= "<div class='author_wrapper'>";
					$out .= esc_html($author);
				$out .= "</div>";
			}
		$out .= '</div>';

	$out .= $end_tag;

	return $out;
}
add_shortcode( 'rb_sc_service', 'rb_vc_shortcode_sc_service' );

?>