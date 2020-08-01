<?php

function rb_vc_shortcode_sc_text ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		'style'						=> 'with_subtitle',
		'icon_shape'				=> 'none',
		'subtitle'					=> '',
		'title'						=> '',
		'title_tag'					=> 'h3',
		'button_title'				=> '',
		'button_url'				=> '#',
		'button_type'				=> "arrow_fade_out",
		'button_size'				=> "medium",
		'show_divider'				=> true,
		'el_class'					=> '',
		/* -----> STYLING TAB <----- */
		'button_size'				=> 'medium',
		'customize_colors'			=> true,
		'icon_color'				=> PRIMARY_COLOR,
		'icon_background'			=> "#FFEEED",
		'subtitle_color'			=> PRIMARY_COLOR,
		'subtitle_background'		=> "#FFEEED",
		'title_color'				=> "#000",
		'font_color'				=> "rgba(0,0,0, .75)",
		'font_color_hover'			=> PRIMARY_COLOR,
		'font_list_markers'			=> PRIMARY_COLOR,
		'divider_color'				=> PRIMARY_COLOR,
		"btn_font_color"			=> '#fff',
		"btn_font_color_hover"		=> '#fff',
		"btn_bg_color"				=> PRIMARY_COLOR,
		"btn_bg_color_hover"		=> PRIMARY_COLOR,
		"btn_border_color"			=> PRIMARY_COLOR,
		"btn_border_color_hover"	=> PRIMARY_COLOR,
 	);
 	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		'all' => array(
 			'custom_styles'		=> '',
 			'customize_align'	=> false,
 			'module_alignment'	=> 'left',
 			'customize_size' 	=> false,
 			'icon_size'			=> "30px",
			'icon_shape_size'	=> "74px",
			'icon_margin'		=> "27px",
			'subtitle_size'		=> "14px",
			'subtitle_margin'	=> "15px",
			'title_size'		=> "36px",
			'title_lh'			=> "1.4em",
			'title_margin'		=> "18px",
			'content_size'		=> "15px",
			'content_lh'		=> "27px",
			'paragraph_spacing'	=> "1.7em",
			'button_margin'		=> "35px",
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$icon = esc_attr(rb_ext_vc_sc_get_icon($atts));
	$id = uniqid( "rb_textmodule_" );
	$title = wp_kses( $title, array(
		"b"			=> array(),
		"strong"	=> array(),
		"mark"		=> array(),
		"br"		=> array()
	));
	$subtitle = wp_kses( $subtitle, array(
		"b"			=> array(),
		"strong"	=> array(),
		"mark"		=> array(),
		"br"		=> array()
	));

	$content = apply_filters( "the_content", $content );
	// Remove empty <p> && <p></p> tags
	$content = preg_replace('/<p[^>]*><\\/p[^>]*>/', '', $content); 
	$content = preg_replace('/<p[^>]*>$/', '', $content); 

	$first_p = substr($content, 0, 4);
	if( $first_p == '</p>' ){
		$content = substr($content, 5);
	}

	$last_p = substr($content, -4, -1);
	if( $last_p == '<p>' ){
		$content = substr($content, 0, -4);
	}

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
			.".$id."{
				".$vc_desktop_styles.";
			}
		";
	}
	if( $customize_align ){
		$styles .= "
			.".$id.",
			.".$id." ul{
				text-align: ".$module_alignment.";
			}
		";
	}
	if( $customize_colors ){
		if( !empty($icon_color) ){
			$styles .= "
				.".$id." .rb_textmodule_icon{
					color: ".esc_attr($icon_color).";
				}
				.".$id." .rb_textmodule_icon svg{
					fill: ".esc_attr($icon_color).";
				}
			";
		}
		if( !empty($icon_background) ){
			$styles .= "
				.".$id." .rb_textmodule_icon{
					background-color: ".esc_attr($icon_background).";
				}
			";
		}
		if( !empty($subtitle_color) ){
			$styles .= "
				.".$id." .rb_textmodule_subtitle{
					color: ".esc_attr($subtitle_color).";
				}
			";
		}
		if( !empty($subtitle_background) ){
			$styles .= "
				.".$id." .rb_textmodule_subtitle{
					background-color: ".esc_attr($subtitle_background).";
				}
			";
		}
		if( !empty($title_color) ){
			$styles .= "
				.".$id." .rb_textmodule_title{
					color: ".esc_attr($title_color).";
				}
			";
		}
		if( !empty($font_color) ){
			$styles .= "
				.".$id." .rb_textmodule_content_wrapper,
				.".$id." .rb_textmodule_content_wrapper a{
					color: ".esc_attr($font_color).";
				}
			";
		}
		if( !empty($font_color_hover) ){
			$styles .= "
				.".$id." .rb_textmodule_content_wrapper a:hover{
					color: ".esc_attr($font_color_hover).";
				}
			";
		}
		if( !empty($font_list_markers) ){
			$styles .= "
				.".$id." .rb_textmodule_content_wrapper ul li:before{
					color: ".esc_attr($font_list_markers).";
				}
			";
		}
		if( !empty($divider_color) ){
			$styles .= "
				.".$id." .rb_textmodule_divider{
					background-color: ".esc_attr($divider_color).";
				}
			";
		}
		if( !empty($btn_font_color) ){
			$styles .= "
				.".$id." .rb_button{
					color: ".esc_attr($btn_font_color).";	
				}
			";
		}
		if( !empty($btn_bg_color) ){
			$styles .= "
				.".$id." .rb_button{
					background-color: ".esc_attr($btn_bg_color).";	
				}
			";
		}
		if( !empty($btn_border_color) ){
			$styles .= "
				.".$id." .rb_button{
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
					.".$id." .rb_button.arrow_fade_in:hover span:after,
					.".$id." .rb_button:hover{
						color: ".esc_attr($btn_font_color_hover).";
					}
				";			
			}
			if( !empty($btn_bg_color_hover) ){
				$styles .= "
					.".$id." .rb_button:hover{
						background-color: ".esc_attr($btn_bg_color_hover).";
					}
				";
			}
			if( !empty($btn_border_color_hover) ){
				$styles .= "
					.".$id." .rb_button:hover{
						border-color: ".esc_attr($btn_border_color_hover).";
					}
				";
			}

		$styles .= "
			}
		";
	}
	if( $customize_size ){
		if( !empty($icon_size) ){
			$styles .= "
				.".$id." .rb_textmodule_icon{
					font-size: ".(int)esc_attr($icon_size)."px;
				}
			";
		}
		if( !empty($icon_shape_size) ){
			$styles .= "
				.".$id." .rb_textmodule_icon{
					width: ".(int)esc_attr($icon_shape_size)."px;
					height: ".(int)esc_attr($icon_shape_size)."px;
					line-height: ".(int)esc_attr($icon_shape_size)."px;
				}
			";
		}
		if( !empty($icon_margin) ){
			$styles .= "
				.".$id." .rb_textmodule_icon{
			";

				if( $module_alignment != 'left' ){
					$styles .= "margin-right: ".(int)esc_attr($icon_margin)."px !important;";
				} else if( $module_alignment == 'center' ){
					$styles .= "margin-bottom: ".(int)esc_attr($icon_margin)."px !important;";
				} else {
					$styles .= "margin-right: ".(int)esc_attr($icon_margin)."px !important;";
				}

			$styles .= "
				}
			";
		}
		if( 
			!empty($icon_shape_size) && 
			!empty($title_size) && 
			!empty($title_lh) && 
			$module_alignment != 'center'
		){
			$icon_mt = (int)$title_size * (int)$title_lh - (int)$icon_shape_size;
			$icon_mt = ctype_digit($icon_mt) ? $icon_mt : 0;

			$styles .= "
				.".$id." .rb_textmodule_title{
					margin-top: -".$icon_mt."px;
				}
			";	
		}
		if( !empty($subtitle_size) ){
			$styles .= "
				.".$id." .rb_textmodule_subtitle{
					font-size: ".(int)esc_attr($subtitle_size)."px;
				}
			";
		}
		if( !empty($subtitle_margin) ){
			$styles .= "
				.".$id." .rb_textmodule_subtitle{
					margin-bottom: ".(int)esc_attr($subtitle_margin)."px;
				}
			";
		}
		if( !empty($title_size) ){
			$styles .= "
				.".$id." .rb_textmodule_title{
					font-size: ".(int)esc_attr($title_size)."px;
				}
			";
		}
		if( !empty($title_lh) ){
			$styles .= "
				.".$id." .rb_textmodule_title{
					line-height: ".(float)esc_attr($title_lh)."em;
				}
			";
		}
		if( !empty($title_margin) ){
			if( $show_divider ){
				$styles .= "
					.".$id." .rb_textmodule_title.has_divider{
						margin-bottom: ".( (int)esc_attr($title_margin) / 2 )."px;
						padding-bottom: ".( (int)esc_attr($title_margin) / 2 )."px;
					}
				";
			} else {
				$styles .= "
					.".$id." .rb_textmodule_title{
						margin-bottom: ".(int)esc_attr($title_margin)."px;
					}
				";
			}
		}
		if( !empty($content_size) ){
			$styles .= "
				.".$id." .rb_textmodule_content_wrapper{
					font-size: ".(int)esc_attr($content_size)."px;
				}
			";
		}
		if( !empty($content_lh) ){
			$styles .= "
				.".$id." .rb_textmodule_content_wrapper{
					line-height: ".(int)esc_attr($content_lh)."px;
				}
			";
		}
		if( !empty($paragraph_spacing) ){
			$styles .= "
				.".$id." .rb_textmodule_content_wrapper > *:not(:last-child){
					margin-bottom: ".esc_attr($paragraph_spacing).";
				}
			";	
		}
		if( !empty($button_margin) ){
			 $styles .= "
				.".$id." .rb_textmodule_button{
					margin-top: ".(int)esc_attr($button_margin)."px;
				}
			";
		}
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
					.".$id.",
					.".$id." ul{
						text-align: ".$module_alignment_landscape.";
					}
				";
			}
			if( $customize_size_landscape ){
				if( !empty($icon_size_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
							font-size: ".(int)esc_attr($icon_size_landscape)."px;
						}
					";
				}
				if( !empty($icon_shape_size_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
							width: ".(int)esc_attr($icon_shape_size_landscape)."px;
							height: ".(int)esc_attr($icon_shape_size_landscape)."px;
							line-height: ".(int)esc_attr($icon_shape_size_landscape)."px;
						}
					";
				}
				if( !empty($icon_margin_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
					";
					
						if( $module_alignment != 'left' ){
							$styles .= "margin-right: ".(int)esc_attr($icon_margin_landscape)."px !important;";
						} else if( $module_alignment == 'center' ){
							$styles .= "margin-bottom: ".(int)esc_attr($icon_margin_landscape)."px !important;";
						} else {
							$styles .= "margin-right: ".(int)esc_attr($icon_margin_landscape)."px !important;";
						}

					$styles .= "
						}
					";
				}
				if( 
					!empty($icon_shape_size_landscape) && 
					!empty($title_size_landscape) && 
					!empty($title_lh_landscape) && 
					$module_alignment_landscape != 'center'
				){
					$icon_mt = (int)$title_size_landscape * (int)$title_lh_landscape - (int)$icon_shape_size_landscape;
					$icon_mt = ctype_digit($icon_mt) ? $icon_mt : 0;

					$styles .= "
						.".$id." .rb_textmodule_title{
							margin-top: -".$icon_mt."px;
						}
					";	
				}
				if( !empty($subtitle_size_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_subtitle{
							font-size: ".(int)esc_attr($subtitle_size_landscape)."px;
						}
					";
				}
				if( !empty($subtitle_margin_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_subtitle{
							margin-bottom: ".(int)esc_attr($subtitle_margin_landscape)."px;
						}
					";
				}
				if( !empty($title_size_landscape) ){
					$styles .= "
						.wbp_wrapper .".$id." .rb_textmodule_title{
							font-size: ".(int)esc_attr($title_size_landscape)."px;
						}
					";
				}
				if( !empty($title_lh_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_title{
							line-height: ".(float)esc_attr($title_lh_landscape)."em;
						}
					";
				}
				if( !empty($title_margin_landscape) ){
					if( $show_divider ){
						$styles .= "
							.".$id." .rb_textmodule_title.has_divider{
								margin-bottom: ".( (int)esc_attr($title_margin_landscape) / 2 )."px;
								padding-bottom: ".( (int)esc_attr($title_margin_landscape) / 2 )."px;
							}
						";
					} else {
						$styles .= "
							.".$id." .rb_textmodule_title{
								margin-bottom: ".(int)esc_attr($title_margin_landscape)."px;
							}
						";
					}
				}
				if( !empty($content_size_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper{
							font-size: ".(int)esc_attr($content_size_landscape)."px;
						}
					";
				}
				if( !empty($content_lh_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper{
							line-height: ".(int)esc_attr($content_lh_landscape)."px;
						}
					";
				}
				if( !empty($paragraph_spacing_landscape) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper > *:not(:last-child){
							margin-bottom: ".esc_attr($paragraph_spacing_landscape).";
						}
					";	
				}
				if( !empty($button_margin_landscape) ){
					 $styles .= "
						.".$id." .rb_textmodule_button{
							margin-top: ".(int)esc_attr($button_margin_landscape)."px;
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
					.".$id."{
						".$vc_portrait_styles.";
					}
				";
			}
			if( $customize_align_portrait ){
				$styles .= "
					.".$id.",
					.".$id." ul{
						text-align: ".$module_alignment_portrait.";
					}
				";
			}
			if( $customize_size_portrait ){
				if( !empty($icon_size_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
							font-size: ".(int)esc_attr($icon_size_portrait)."px;
						}
					";
				}
				if( !empty($icon_shape_size_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
							width: ".(int)esc_attr($icon_shape_size_portrait)."px;
							height: ".(int)esc_attr($icon_shape_size_portrait)."px;
							line-height: ".(int)esc_attr($icon_shape_size_portrait)."px;
						}
					";
				}
				if( !empty($icon_margin_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
					";
					
						if( $module_alignment != 'left' ){
							$styles .= "margin-right: ".(int)esc_attr($icon_margin_portrait)."px !important;";
						} else if( $module_alignment == 'center' ){
							$styles .= "margin-bottom: ".(int)esc_attr($icon_margin_portrait)."px !important;";
						} else {
							$styles .= "margin-right: ".(int)esc_attr($icon_margin_portrait)."px !important;";
						}

					$styles .= "
						}
					";
				}
				if( 
					!empty($icon_shape_size_portrait) && 
					!empty($title_size_portrait) && 
					!empty($title_lh_portrait) && 
					$module_alignment_portrait != 'center'
				){
					$icon_mt = (int)$title_size_portrait * (int)$title_lh_portrait - (int)$icon_shape_size_portrait;
					$icon_mt = ctype_digit($icon_mt) ? $icon_mt : 0;

					$styles .= "
						.".$id." .rb_textmodule_title{
							margin-top: -".$icon_mt."px;
						}
					";	
				}
				if( !empty($subtitle_size_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_subtitle{
							font-size: ".(int)esc_attr($subtitle_size_portrait)."px;
						}
					";
				}
				if( !empty($subtitle_margin_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_subtitle{
							margin-bottom: ".(int)esc_attr($subtitle_margin_portrait)."px;
						}
					";
				}
				if( !empty($title_size_portrait) ){
					$styles .= "
						.wpb_wrapper .".$id." .rb_textmodule_title{
							font-size: ".(int)esc_attr($title_size_portrait)."px;
						}
					";
				}
				if( !empty($title_lh_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_title{
							line-height: ".(float)esc_attr($title_lh_portrait)."em;
						}
					";
				}
				if( !empty($title_margin_portrait) ){
					if( $show_divider ){
						$styles .= "
							.".$id." .rb_textmodule_title.has_divider{
								margin-bottom: ".( (int)esc_attr($title_margin_portrait) / 2 )."px;
								padding-bottom: ".( (int)esc_attr($title_margin_portrait) / 2 )."px;
							}
						";
					} else {
						$styles .= "
							.".$id." .rb_textmodule_title{
								margin-bottom: ".(int)esc_attr($title_margin_portrait)."px;
							}
						";
					}
				}
				if( !empty($content_size_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper{
							font-size: ".(int)esc_attr($content_size_portrait)."px;
						}
					";
				}
				if( !empty($content_lh_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper{
							line-height: ".(int)esc_attr($content_lh_portrait)."px;
						}
					";
				}
				if( !empty($paragraph_spacing_portrait) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper > *:not(:last-child){
							margin-bottom: ".esc_attr($paragraph_spacing_portrait).";
						}
					";	
				}
				if( !empty($button_margin_portrait) ){
					 $styles .= "
						.".$id." .rb_textmodule_button{
							margin-top: ".(int)esc_attr($button_margin_portrait)."px;
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
					.".$id."{
						".$vc_mobile_styles.";
					}
				";
			}
			if( $customize_align_mobile ){
				$styles .= "
					.".$id.",
					.".$id." ul{
						text-align: ".$module_alignment_mobile.";
					}
				";
			}
			if( $customize_size_mobile ){
				if( !empty($icon_size_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
							font-size: ".(int)esc_attr($icon_size_mobile)."px;
						}
					";
				}
				if( !empty($icon_shape_size_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
							width: ".(int)esc_attr($icon_shape_size_mobile)."px;
							height: ".(int)esc_attr($icon_shape_size_mobile)."px;
							line-height: ".(int)esc_attr($icon_shape_size_mobile)."px;
						}
					";
				}
				if( !empty($icon_margin_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_icon{
					";
					
						if( $module_alignment != 'left' ){
							$styles .= "margin-right: ".(int)esc_attr($icon_margin_mobile)."px !important;";
						} else if( $module_alignment == 'center' ){
							$styles .= "margin-bottom: ".(int)esc_attr($icon_margin_mobile)."px !important;";
						} else {
							$styles .= "margin-right: ".(int)esc_attr($icon_margin_mobile)."px !important;";
						}

					$styles .= "
						}
					";
				}
				if( 
					!empty($icon_shape_size_mobile) && 
					!empty($title_size_mobile) && 
					!empty($title_lh_mobile) && 
					$module_alignment_mobile != 'center'
				){
					$icon_mt = (int)$title_size_mobile * (int)$title_lh_mobile - (int)$icon_shape_size_mobile;
					$icon_mt = ctype_digit($icon_mt) ? $icon_mt : 0;

					$styles .= "
						.".$id." .rb_textmodule_title{
							margin-top: -".$icon_mt."px;
						}
					";	
				}
				if( !empty($subtitle_size_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_subtitle{
							font-size: ".(int)esc_attr($subtitle_size_mobile)."px;
						}
					";
				}
				if( !empty($subtitle_margin_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_subtitle{
							margin-bottom: ".(int)esc_attr($subtitle_margin_mobile)."px;
						}
					";
				}
				if( !empty($title_size_mobile) ){
					$styles .= "
						.wpb_wrapper .".$id." .rb_textmodule_title{
							font-size: ".(int)esc_attr($title_size_mobile)."px;
						}
					";
				}
				if( !empty($title_lh_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_title{
							line-height: ".(float)esc_attr($title_lh_mobile)."em;
						}
					";
				}
				if( !empty($title_margin_mobile) ){
					if( $show_divider ){
						$styles .= "
							.".$id." .rb_textmodule_title.has_divider{
								margin-bottom: ".( (int)esc_attr($title_margin_mobile) / 2 )."px;
								padding-bottom: ".( (int)esc_attr($title_margin_mobile) / 2 )."px;
							}
						";
					} else {
						$styles .= "
							.".$id." .rb_textmodule_title{
								margin-bottom: ".(int)esc_attr($title_margin_mobile)."px;
							}
						";
					}
				}
				if( !empty($content_size_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper{
							font-size: ".(int)esc_attr($content_size_mobile)."px;
						}
					";
				}
				if( !empty($content_lh_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper{
							line-height: ".(int)esc_attr($content_lh_mobile)."px;
						}
					";
				}
				if( !empty($paragraph_spacing_mobile) ){
					$styles .= "
						.".$id." .rb_textmodule_content_wrapper > *:not(:last-child){
							margin-bottom: ".esc_attr($paragraph_spacing_mobile).";
						}
					";	
				}
				if( !empty($button_margin_mobile) ){
					 $styles .= "
						.".$id." .rb_textmodule_button{
							margin-top: ".(int)esc_attr($button_margin_mobile)."px;
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

	$module_classes = $id.' rb_textmodule';
	$module_classes .= ' '.$style;
	$module_classes .= $customize_align ? ' align_'.esc_attr($module_alignment) : '';
	$module_classes .= $customize_align_landscape ? ' landscape_align_'.esc_attr($module_alignment_landscape) : '';
	$module_classes .= $customize_align_portrait ? ' portrait_align_'.esc_attr($module_alignment_portrait) : '';
	$module_classes .= $customize_align_mobile ? ' mobile_align_'.esc_attr($module_alignment_mobile) : '';
	$module_classes .= !empty($el_class) ? ' '.esc_attr($el_class) : '';

	$button_classes = $customize_size ? ' '.esc_attr($button_type) : ' arrow_fade_out';
	$button_classes .= $customize_size ? ' '.esc_attr($button_size) : ' medium';

	/* -----> Text module output <----- */
	if ( !empty($title) || !empty($subtitle) || !empty($content) ){
		$out .= "<div class='".$module_classes."'>"; //ID in class, coz slick-slider rewrite ID.

			if( $style == 'with_subtitle' ){
				if( !empty($subtitle) ){
					$out .= "<p class='h5 rb_textmodule_subtitle'>". $subtitle ."</p>";
				}
			} else {
				if( !empty($icon) ){
					$out .= "<div class='rb_textmodule_icon shape_".esc_attr($icon_shape)."'>";
						$out .= "<i class='".esc_attr($icon)."'></i>";
					$out .= "</div>";
				}
			}

			$out .= "<div class='rb_textmodule_info_wrapper'>";
				if( !empty($title) ){
					$out .= "<".$title_tag." class='rb_textmodule_title ".($show_divider ? 'has_divider' : '')."'>";
						$out .= $title;
						if( $show_divider ){
							$out .= "<span class='rb_textmodule_divider'></span>";
						}
					$out .= "</".$title_tag.">";
				}
				if( !empty($content) ){
					$out .= "<div class='rb_textmodule_content_wrapper'>";
						$out .= $content;
					$out .= "</div>";
				}
				if( !empty($button_title) ){
					$out .= "<a href='".esc_url($button_url)."' class='rb_textmodule_button rb_button".$button_classes."'>";
						$out .= "<span>".esc_html($button_title)."</span>";
					$out .= "</a>";
				}
			$out .= "</div>";

		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_text', 'rb_vc_shortcode_sc_text' );

?>