<?php

function rb_vc_shortcode_sc_banners ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"title"							=> "",
		"add_divider"					=> false,
		"description"					=> "",
		"button_title"					=> "",
		"banner_url"					=> "#",
		"button_pos"					=> "default",
		"new_tab"						=> true,
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"customize_colors"				=> true,
		"title_color"					=> "#000",
		"divider_color"					=> "#000",
		"text_color"					=> "#4C4C4D",
		"overlay_color"					=> "rgba(255,255,255,.6)",
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
			"module_alignment"	=> "left",
		),
	);
	$responsive_vars = add_bg_properties($responsive_vars); //Add custom background properties to responsive vars array

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$id = uniqid( "rb_banner_" );
	$title = wp_kses( $title, array(
		"b"			=> array(),
		"strong"	=> array(),
		"mark"		=> array(),
		"br"		=> array()
	));
	$description = wp_kses( $description, array(
		"b"			=> array(),
		"strong"	=> array(),
		"mark"		=> array(),
		"br"		=> array()
	));
	$start_tag = empty($button_title) && !empty($banner_url) ? '<a href="'.esc_url($banner_url).'"'.($new_tab ? ' target="_blank"' : '') : '<div';
	$end_tag = empty($button_title) && !empty($banner_url) ? '</a>' : '</div>';
	
	/* -----> Visual Composer Responsive styles <----- */
	list( $vc_desktop_class, $vc_landscape_class, $vc_portrait_class, $vc_mobile_class ) = vc_responsive_styles($atts);

	preg_match("/(?<=\{).+?(?=\})/", $vc_desktop_class, $vc_desktop_styles); 
	$vc_desktop_styles = implode($vc_desktop_styles);
	$vc_desktop_styles .= "
		background-position: ".(!empty($custom_bg_position) ? $custom_bg_position : $bg_position ).";
		background-size: ".(!empty($custom_bg_size) ? $custom_bg_size : $bg_size ).";
		background-repeat: ".$bg_repeat.";
		". ($bg_display == '1' ? 'background-image: none !important;' : '') ."
	";

	preg_match("/(?<=\{).+?(?=\})/", $vc_landscape_class, $vc_landscape_styles);
	$vc_landscape_styles = implode($vc_landscape_styles);
	$vc_landscape_styles .= "
		background-position: ".(!empty($custom_bg_position_landscape) ? $custom_bg_position_landscape : $bg_position_landscape ).";
		background-size: ".(!empty($custom_bg_size_landscape) ? $custom_bg_size_landscape : $bg_size_landscape ).";
		background-repeat: ".$bg_repeat_landscape.";
		". ($bg_display_landscape == '1' ? 'background-image: none !important;' : '') ."
	";

	preg_match("/(?<=\{).+?(?=\})/", $vc_portrait_class, $vc_portrait_styles);
	$vc_portrait_styles = implode($vc_portrait_styles);
	$vc_portrait_styles .= "
		background-position: ".(!empty($custom_bg_position_portrait) ? $custom_bg_position_portrait : $bg_position_portrait ).";
		background-size: ".(!empty($custom_bg_size_portrait) ? $custom_bg_size_portrait : $bg_size_portrait ).";
		background-repeat: ".$bg_repeat_portrait.";
		". ($bg_display_portrait == '1' ? 'background-image: none !important;' : '') ."
	";

	preg_match("/(?<=\{).+?(?=\})/", $vc_mobile_class, $vc_mobile_styles);
	$vc_mobile_styles = implode($vc_mobile_styles);
	$vc_mobile_styles .= "
		background-position: ".(!empty($custom_bg_position_mobile) ? $custom_bg_position_mobile : $bg_position_mobile ).";
		background-size: ".(!empty($custom_bg_size_mobile) ? $custom_bg_size_mobile : $bg_size_mobile ).";
		background-repeat: ".$bg_repeat_mobile.";
		". ($bg_display_mobile == '1' ? 'background-image: none !important;' : '') ."
	";

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
				text-align: ".$module_alignment.";
			}
		";
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .banner_title{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($divider_color) ){
		$styles .= "
			#".$id." .banner_divider{
				background-color: ".esc_attr($divider_color).";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id." .banner_desc{
				color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($overlay_color) ){
		$styles .= "
			#".$id.":before{
				background-color: ".esc_attr($overlay_color).";
			}
		";
	}
	if( !empty($btn_font_color) ){
		$styles .= "
			#".$id." .rb_button{
				color: ".esc_attr($btn_font_color).";	
			}
		";
	}
	if( !empty($btn_bg_color) ){
		$styles .= "
			#".$id." .rb_button{
				background-color: ".esc_attr($btn_bg_color).";	
			}
		";
	}
	if( !empty($btn_border_color) ){
		$styles .= "
			#".$id." .rb_button{
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
				#".$id." .rb_button.arrow_fade_in:hover span:after,
				#".$id." .rb_button:hover{
					color: ".esc_attr($btn_font_color_hover).";
				}
			";			
		}
		if( !empty($btn_bg_color_hover) ){
			$styles .= "
				#".$id." .rb_button:hover{
					background-color: ".esc_attr($btn_bg_color_hover).";
				}
			";
		}
		if( !empty($btn_border_color_hover) ){
			$styles .= "
				#".$id." .rb_button:hover{
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
			if( $customize_align_landscape ){
				$styles .= "
					#".$id."{
						text-align: ".$module_alignment_landscape.";
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
						".$vc_portrait_styles.";
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
						".$vc_mobile_styles.";
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

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */

	rb__vc_styles($styles);

	$module_classes = "rb_banner_module";
	$module_classes .= " button_".esc_attr($button_pos);
	$module_classes .= " align_".esc_attr($module_alignment);
	$module_classes .= $customize_align_landscape ? " landscape_align_".esc_attr($module_alignment_landscape) : '';
	$module_classes .= $customize_align_portrait ? " portrait_align_".esc_attr($module_alignment_portrait) : '';
	$module_classes .= $customize_align_mobile ? " mobile_align_".esc_attr($module_alignment_mobile) : '';
	$module_classes .= !empty($el_class) ? " ".esc_attr($el_class) : '';

	$button_classes = 'rb_button medium';
	$button_classes .= ' arrow_fade_out';

	/* -----> Banner module output <----- */
	$out .= $start_tag." id='".$id."' class='".$module_classes."'>";
		$out .= "<div class='banner_desc_wrapper'>";
			if( !empty($title) ){
				$out .= "<p class='banner_title title_ff'>".$title."</p>";
			}
			if( $add_divider ){
				$out .= "<span class='banner_divider'></span>";
			}
			if( !empty($description) ){
				$out .= "<p class='banner_desc'>".$description."</p>";
			}
		$out .= "</div>";
		if( !empty($button_title) ){
			$out .= "<a href='".esc_url($banner_url)."' ".($new_tab ? "target='_blank'" : "")." class='".esc_attr($button_classes)."'>";
				$out .= "<span>".esc_html($button_title)."</span>";
			$out .= "</a>";
		}
	$out .= $end_tag;

	return $out;
}
add_shortcode( 'rb_sc_banners', 'rb_vc_shortcode_sc_banners' );

?>