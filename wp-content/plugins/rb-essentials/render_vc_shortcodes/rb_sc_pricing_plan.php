<?php

function rb_vc_shortcode_sc_pricing_plan ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"title"							=> "",
		"price"							=> "49",
		"subprice"						=> "99",
		"currency"						=> "$",
		"price_desc"					=> "/month",
		"button_title"					=> "",
		"button_url"					=> "#",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"shadow_color"					=> "rgba(0, 0, 0, 0.05)",
		"title_background"				=> "#fff",
		"title_color"					=> "#000",
		"title_border"					=> "#DEDEDE",
		"text_color"					=> "#000",
		"list_items_color"				=> PRIMARY_COLOR,
		"price_border"					=> "#DADCE2",
		"price_background"				=> "#fff",
		"price_description"				=> "#7F7F7F",
		"btn_font_color"				=> '#000',
		"btn_bg_color"					=> SECONDARY_COLOR,
		"btn_border_color"				=> SECONDARY_COLOR,
		"btn_font_color_hover"			=> '#000',
		"btn_bg_color_hover"			=> SECONDARY_COLOR,
		"btn_border_color_hover"		=> SECONDARY_COLOR,
	);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = "";
	$id = uniqid( "rb_pricing_plan_" );
	$content = apply_filters( "the_content", $content );

	$first_p = substr($content, 0, 4);
	if( $first_p == '</p>' ){
		$content = substr($content, 5);
	}

	$last_p = substr($content, -4, -1);
	if( $last_p == '<p>' ){
		$content = substr($content, 0, -4);
	}

	/* -----> Customize default styles <----- */
	if( !empty($shadow_color) ){
		$styles .= "
			#".$id."{
				-webkit-box-shadow: 0 0 35px 0 ".esc_attr($shadow_color).";
				-moz-box-shadow: 0 0 35px 0 ".esc_attr($shadow_color).";
				box-shadow: 0 0 35px 0 ".esc_attr($shadow_color).";
			}
		";
	}
	if( !empty($title_background) ){
		$styles .= "
			#".$id." .title{
				background-color: ".esc_attr($title_background).";
			}
		";
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .title{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($title_border) ){
		$styles .= "
			#".$id." .title:after{
				background-color: ".esc_attr($title_border).";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id." .content-wrapper,
			#".$id." .main_info_wrapper .price_wrapper{
				color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($list_items_color) ){
		$styles .= "
			#".$id." .content-wrapper ul li:before{
				color: ".esc_attr($list_items_color).";
			}
		";
	}
	if( !empty($price_border) ){
		$styles .= "
			#".$id." .main_info_wrapper{
				border-color: ".esc_attr($price_border).";
			}
		";
	}
	if( !empty($price_background) ){
		$styles .= "
			#".$id." .main_info_wrapper{
				background-color: ".esc_attr($price_background).";
			}
		";
	}
	if( !empty($price_description) ){
		$styles .= "
			#".$id." .main_info_wrapper .price_wrapper p{
				color: ".esc_attr($price_description).";
			}
		";
	}
	if( !empty($btn_font_color) ){
		$styles .= "
			#".$id." .rb_button_wrapper .rb_button{
				color: ".esc_attr($btn_font_color).";	
			}
		";
	}
	if( !empty($btn_bg_color) ){
		$styles .= "
			#".$id." .rb_button_wrapper .rb_button{
				background-color: ".esc_attr($btn_bg_color).";	
			}
		";
	}
	if( !empty($btn_border_color) ){
		$styles .= "
			#".$id." .rb_button_wrapper .rb_button{
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
				#".$id." .rb_button_wrapper .rb_button.arrow_fade_in:hover span:after,
				#".$id." .rb_button_wrapper .rb_button:hover{
					color: ".esc_attr($btn_font_color_hover).";
				}
			";			
		}
		if( !empty($btn_bg_color_hover) ){
			$styles .= "
				#".$id." .rb_button_wrapper .rb_button:hover{
					background-color: ".esc_attr($btn_bg_color_hover).";
				}
			";
		}
		if( !empty($btn_border_color_hover) ){
			$styles .= "
				#".$id." .rb_button_wrapper .rb_button:hover{
					border-color: ".esc_attr($btn_border_color_hover).";
				}
			";
		}

	$styles .= "
		}
	";
	/* -----> End of default styles <----- */

	rb__vc_styles($styles);

	$module_classes = 'rb_pricing_plan_module';
	$module_classes .= !empty($el_class) ? ' '.esc_attr($el_class) : '';

	/* -----> Filter Products module output <----- */
	$out .= "<div id='".$id."' class='".$module_classes."'>";
		if( !empty($title) ){
			$out .= "<p class='title'>".esc_html($title)."</p>";
		}
		if( !empty($content) ){
			$out .= "<div class='content-wrapper'>".$content."</div>";
		}
		$out .= "<div class='main_info_wrapper'>";
			$out .= "<div class='price_wrapper title_ff'>";
				if( !empty($currency) ){
					$out .= "<i>".esc_html($currency)."</i>";
				}
				if( !empty($price) ){
					$out .= "<span>";
						$out .= esc_html($price);
						$out .= !empty($subprice) ? "<span class='subprice'>".esc_html($subprice)."</span>" : "";
					$out .= "</span>";
				}
				if( !empty($price_desc) ){
					$out .= "<p>".esc_html($price_desc)."</p>";
				}
			$out .= "</div>";
			if( !empty($button_title) && !empty($button_url) ){
				$out .= "<div class='rb_button_wrapper'>";
					$out .= "<a href='".esc_url($button_url)."' class='rb_button medium arrow_fade_out'>";
						$out .= "<span>".esc_html($button_title)."</span>";
					$out .= "</a>";
				$out .= "</div>";
			}
		$out .= "</div>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_pricing_plan', 'rb_vc_shortcode_sc_pricing_plan' );

?>