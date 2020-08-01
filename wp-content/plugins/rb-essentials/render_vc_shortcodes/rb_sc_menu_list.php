<?php
function rb_vc_shortcode_sc_menu_list ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"values"						=> "",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
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
	$image = !empty($image) ? wp_get_attachment_image_src($image, 'full')[0] : '';
	$id = uniqid( "rb_menu_list_" );

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

	/* -----> Filter Products module output <----- */
	if( !empty($values) ){
		$out .= "<div id='".$id."' class='rb_menu_list_module ".esc_attr($el_class)."'>";

			$out .= "<ul class='rb_menu_list_wrapper'>";

				foreach( $values as $value ){

					$title = !empty($value['title']) ? esc_html($value['title']) : '';
					$url = !empty($value['url']) ? esc_url($value['url']) : '#';
					$tag = !empty($value['tag']) ? esc_html($value['tag']) : '';
					$tag_color = !empty($value['tag_color']) ? esc_attr($value['tag_color']) : PRIMARY_COLOR;

					$out .= "<li class='menu-item'>";
						$out .= "<a href='".$url."'>";
							$out .= $title;
							$out .= !empty($tag) ? "<span class='mm_tag' style='background-color:".$tag_color."'>".$tag."</span>" : '';
						$out .= "</a>";					
					$out .= "</li>";

				}

			$out .= "</ul>";

		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_menu_list', 'rb_vc_shortcode_sc_menu_list' );

?>