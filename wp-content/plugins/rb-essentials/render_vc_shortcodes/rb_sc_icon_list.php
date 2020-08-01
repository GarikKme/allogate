<?php
function rb_vc_shortcode_sc_icon_list ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"dir"							=> "column",
		"icon_bg"						=> false,
		"values"						=> "",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"icons_color"					=> "#000",
		"icons_color_hover"				=> PRIMARY_COLOR,
		"icons_bg"						=> "rgba(255,255,255, .05)",
	);

	$responsive_vars = array(
		"all" => array(
			"custom_styles"		=> "",
			"customize_align"	=> false,
			"alignment"			=> "left",
			"customize_size"	=> false,
			"icons_size"		=> "14px",
			"title_size"		=> "12px",
			"spacing"			=> "20px"
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$values = (array)vc_param_group_parse_atts($values);
	$image = !empty($image) ? wp_get_attachment_image_src($image, 'full')[0] : '';
	$id = uniqid( "rb_icon_list_" );
	if( class_exists('WooCommerce') ){
		$rb_woocommerce = new Setech_WooExt();
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
	if( $customize_size ){
		if( !empty($icons_size) ){
			$styles .= "
				#".$id." i:before{
					font-size: ".(int)esc_attr($icons_size)."px;
				}
			";
		}
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .title{
					font-size: ".(int)esc_attr($title_size)."px;
				}
				#".$id." .title.larger{
					font-size: ".((int)esc_attr($title_size) + 3)."px;
					font-weight: 500;
				}
			";
		}
		if( !empty($spacing) ){
			$styles .= "
				#".$id.".direction_line > *{
					margin-right: ".(int)esc_attr($spacing)."px;
				}
				#".$id.".direction_column > * > *{
					margin-top: ".(int)esc_attr($spacing)."px;
				}
			";
		}
	}
	if( $icon_bg && !empty($icons_bg) ){
		$styles .= "
			#".$id." i{
				background-color: ".esc_attr($icons_bg).";
			}
		";
	}
	if( !empty($icons_color) ){
		$styles .= "
			#".$id." > a,
			#".$id." > p,
			#".$id." > .mini-cart > a,
			#".$id." .wpml-ls-statics-shortcode_actions .wpml-ls-current-language > a{
				color: ".esc_attr($icons_color).";
			}
		";
	}
	if( !empty($icons_color_hover) ){
		$styles .= "
			@media 
				screen and (min-width: 1367px), /*Disable this styles for iPad Pro 1024-1366*/
				screen and (min-width: 1200px) and (any-hover: hover), /*Check, is device a desktop (Not working on IE & FireFox)*/
				screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0), /*Check, is device a desktop with firefox*/
				screen and (min-width: 1200px) and (-ms-high-contrast: none), /*Check, is device a desktop with IE 10 or above*/
				screen and (min-width: 1200px) and (-ms-high-contrast: active) /*Check, is device a desktop with IE 10 or above*/
			{
				#".$id." > a:hover,
				#".$id." > .mini-cart > a:hover,
				#".$id." .wpml-ls-statics-shortcode_actions .wpml-ls-current-language > a:hover{
					color: ".$icons_color_hover.";
				}
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
			if( $customize_size_landscape ){
				if( !empty($icons_size_landscape) ){
					$styles .= "
						#".$id." *:before{
							font-size: ".(int)esc_attr($icons_size_landscape)."px;
						}
					";
				}
				if( !empty($title_size_landscape) ){
					$styles .= "
						#".$id." .title{
							font-size: ".(int)esc_attr($title_size_landscape)."px;
						}
					";	
				}
				if( !empty($spacing_landscape) ){
					$styles .= "
						#".$id.".direction_line > *{
							margin-right: ".(int)esc_attr($spacing_landscape)."px;
						}
						#".$id.".direction_column > * > *{
							margin-top: ".(int)esc_attr($spacing_landscape)."px;
						}
					";
				}
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
			if( $customize_size_portrait ){
				if( !empty($icons_size_portrait) ){
					$styles .= "
						#".$id." *:before{
							font-size: ".(int)esc_attr($icons_size_portrait)."px;
						}
					";
				}
				if( !empty($title_size_portrait) ){
					$styles .= "
						#".$id." .title{
							font-size: ".(int)esc_attr($title_size_portrait)."px;
						}
					";	
				}
				if( !empty($spacing_portrait) ){
					$styles .= "
						#".$id.".direction_line > *{
							margin-right: ".(int)esc_attr($spacing_portrait)."px;
						}
						#".$id.".direction_column > * > *{
							margin-top: ".(int)esc_attr($spacing_portrait)."px;
						}
					";
				}
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
			if( $customize_size_mobile ){
				if( !empty($icons_size_mobile) ){
					$styles .= "
						#".$id." *:before{
							font-size: ".(int)esc_attr($icons_size_mobile)."px;
						}
					";
				}
				if( !empty($title_size_mobile) ){
					$styles .= "
						#".$id." .title{
							font-size: ".(int)esc_attr($title_size_mobile)."px;
						}
					";	
				}
				if( !empty($spacing_mobile) ){
					$styles .= "
						#".$id.".direction_line > *{
							margin-right: ".(int)esc_attr($spacing_mobile)."px;
						}
						#".$id.".direction_column > * > *{
							margin-top: ".(int)esc_attr($spacing_mobile)."px;
						}
					";
				}
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

	$module_classes = 'rb_icon_list_module';
	$module_classes .= ' header_icons';
	$module_classes .= ' direction_'.esc_attr($dir);
	$module_classes .= $icon_bg ? ' icon_bg' : '';
	$module_classes .= !empty($el_class) ? ' '.esc_attr($el_class) : '';

	/* -----> Filter Products module output <----- */
	$out .= "<div id='".$id."' class='".$module_classes."'>";

		foreach( $values as $value ){
			$icon = !empty($value['icon_rb_flaticons']) ? esc_attr($value['icon_rb_flaticons']) : '';
			$title = !empty($value['title']) ? esc_html($value['title']) : '';
			$url = !empty($value['url']) ? $value['url'] : '';
			$sidebar = !empty($value['sidebar']) ? esc_attr($value['sidebar']) : '';
			$larger = !empty($value['larger']) ? 'larger' : '';

			switch( $value['function'] ){
				case 'sidebar':
					$out .= "<a href='#' class='custom_sidebar_trigger' data-sidebar='".esc_attr($sidebar)."'>";
						$out .= "<i class='".$icon."'></i>";
						$out .= "<span class='title'>".$title."</span>";
					$out .= "</a>";
					break;
				case 'cart':
					if( class_exists('WooCommerce') ){
						$out .= $rb_woocommerce->rb_woocommerce_get_mini_cart();
					}
					break;
				case 'wpml':
					if( class_exists('SitePress') ){
						ob_start();
							do_action('wpml_add_language_selector');
						$out .= ob_get_clean();
					}
					break;
				case 'rb_search':
					$out .= "<a class='search-trigger'>";
						$out .= "<span class='title'>".$title."</span>";
					$out .= "</a>";
					break;
				case 'custom':
					if( $value['type'] == 'phone' ){
						$link = 'tel:'.$url;
					} else if( $value['type'] == 'mail' ){
						$link = 'mailto:'.$url;
					} else {
						$link = $url;
					}

					$start_tag = !empty($link) ? "<a href='".esc_url($link)."'" : '<p';
					$end_tag = !empty($link) ? "</a>" : "</p>";

					$out .= $start_tag." class='custom_url'>";
						$out .= !empty($icon) ? "<i class='".$icon."'></i>" : '';
						$out .= "<span class='title ".$larger."'>".$title."</span>";
					$out .= $end_tag;
					break;
			}
		}

	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_icon_list', 'rb_vc_shortcode_sc_icon_list' );

?>