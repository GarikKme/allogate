<?php

function rb_vc_shortcode_sc_testimonials ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"style"							=> "simple",
		"shape"							=> "square",
		"image_pos"						=> "top",
		"columns"						=> "1",
		"carousel"						=> false,
		"autoplay"						=> false,
		"slides_to_scroll"				=> "1",
		"autoplay_speed"				=> "3000",
		"values"						=> "",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"background_color"				=> SECONDARY_COLOR,
		"bg_color_hover"				=> "#fff",
		"quotes_bg"						=> "#fff",
		"quotes_bg_hover"				=> PRIMARY_COLOR,
		"quotes_color"					=> PRIMARY_COLOR,
		"quotes_color_hover"			=> "#fff",
		"unactive_rating"				=> "#D0DFF2",
		"unactive_rating_hover"			=> "#D0DFF2",
		"active_rating"					=> "#FABD4A",
		"active_rating_hover"			=> "#FABD4A",
		"text_color"					=> "#000",
		"text_color_hover"				=> "#000",
		"dots_color"					=> PRIMARY_COLOR,
		"shadow_color"					=> "rgba(0,0,0, .15)",
	);

	$responsive_vars = array(
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
	$values = (array)vc_param_group_parse_atts($values);
	$id = uniqid( "rb_testimonials_" );

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
	if( !empty($background_color) ){
		$styles .= "
			#".$id." .testimonial{
				background-color: ".esc_attr($background_color).";
			}
		";
	}
	if( !empty($quotes_bg) ){
		$styles .= "
			#".$id." .testimonial .quotes_wrapper{
				background-color: ".esc_attr($quotes_bg).";
			}
		";
	}
	if( !empty($quotes_color) ){
		$styles .= "
			#".$id." .testimonial .quotes_wrapper{
				color: ".esc_attr($quotes_color).";
			}
		";
	}
	if( !empty($unactive_rating) ){
		$styles .= "
			#".$id." .testimonial .testimonials_stars:before{
				color: ".esc_attr($unactive_rating).";
			}
		";
	}
	if( !empty($active_rating) ){
		$styles .= "
			#".$id." .testimonial .testimonials_stars:after{
				color: ".esc_attr($active_rating).";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id." .testimonial .content_wrapper *{
				color: ".esc_attr($text_color).";
			}
			#".$id." .testimonial .content_wrapper .testimonial_name:before{
				background-color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($dots_color) ){
		$styles .= "
			#".$id." .rb_carousel .slick-dots li button{
				background-color: ".esc_attr($dots_color).";
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

		if( !empty($bg_color_hover) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover{
					background-color: ".esc_attr($bg_color_hover).";
				}
			";
		}
		if( !empty($quotes_bg_hover) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover .quotes_wrapper{
					background-color: ".esc_attr($quotes_bg_hover).";
				}
			";
		}
		if( !empty($quotes_color_hover) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover .quotes_wrapper{
					color: ".esc_attr($quotes_color_hover).";
				}
			";
		}
		if( !empty($unactive_rating_hover) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover .testimonials_stars:before{
					color: ".esc_attr($unactive_rating_hover).";
				}
			";
		}
		if( !empty($active_rating_hover) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover .testimonials_stars:after{
					color: ".esc_attr($active_rating_hover).";
				}
			";
		}
		if( !empty($text_color_hover) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover .content_wrapper *{
					color: ".esc_attr($text_color_hover).";
				}
			";
		}
		if( !empty($shadow_color) ){
			$styles .= "
				#".$id.".style_simple .testimonial:hover{
				    -webkit-box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
				    -moz-box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
				    box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
				}
				#".$id.".style_simple .testimonial.slick-slide:hover{
				    -webkit-box-shadow: 0px 6px 16px 0px ".esc_attr($shadow_color).";
				    -moz-box-shadow: 0px 6px 16px 0px ".esc_attr($shadow_color).";
				    box-shadow: 0px 6px 16px 0px ".esc_attr($shadow_color).";
				}
			";
		}

	$styles .= "
		}
	";
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( !empty($vc_landscape_styles) ){
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
						".$vc_portrait_styles.";
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
						".$vc_mobile_styles.";
					}
				";
			}

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */

	rb__vc_styles($styles);

	$module_classes = "rb_testimonials_module";
	$module_classes .= " style_".$style;
	$module_classes .= " image_".$image_pos;
	$module_classes .= $carousel ? " rb_carousel_wrapper" : '';
	$module_classes .= !empty($el_class) ? " ".esc_attr($el_class) : '';

	$module_atts = 'data-columns="'.$columns.'"';
	$module_atts .= ' data-pagination="on" data-draggable="on" data-infinite="on" data-auto-height="on"';
	$module_atts .= ' data-slides-to-scroll="'.esc_attr($slides_to_scroll).'"';
	$module_atts .= $autoplay ? ' data-autoplay="on"' : '';
	$module_atts .= $autoplay && !empty($autoplay_speed) ? ' data-autoplay-speed="'.esc_attr($autoplay_speed).'"' : '';

	/* -----> Banner module output <----- */
	$out .= "<div id='".$id."' class='".$module_classes."' ".($carousel ? $module_atts : '').">";
		$out .= "<div class='".($carousel ? 'rb_carousel' : 'rb_testimonials_wrapper columns_'.$columns)."'>";

			foreach ($values as $value) {
				$out .= "<div class='testimonial'>";

					$image = '';
					if( !empty($value['image']) ){
						$image_alt = get_post_meta($value['image'], '_wp_attachment_image_alt', TRUE);

						$image = wp_get_attachment_image_src($value['image'], array('100', '100'))[0];
					}

					if( !empty($image) ){
						$out .= "<div class='image_wrapper ".esc_attr($shape)."'>";
							$out .= "<img src='".esc_url($image)."' alt='".esc_attr($image_alt)."' />";
						$out .= "</div>";
					} else {
						$out .= "<div class='quotes_wrapper ".esc_attr($shape)."'>";
							$out .= "<span class='quotes'></span>";
						$out .= "</div>";
					}
					$out .= "<div class='content_wrapper'>";
						if( !empty($value['stars']) ){
							$out .= "<div class='testimonials_stars stars_".esc_attr($value['stars'])."'></div>";
						}
						if( !empty($value['description']) ){
							$out .= "<p class='testimonial_desc'>".esc_html($value['description'])."</p>";
						}
						if( !empty($value['name']) ){
							$out .= "<p class='h4 testimonial_name'>".esc_html($value['name'])."</p>";
						}
					$out .= "</div>";
				$out .= "</div>";
			}

		$out .= "</div>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_testimonials', 'rb_vc_shortcode_sc_testimonials' );

?>