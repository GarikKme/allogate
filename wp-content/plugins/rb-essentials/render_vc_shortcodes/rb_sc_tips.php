<?php

function rb_vc_shortcode_sc_tips ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"image"							=> "",
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
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = $local_styles = "";
	$values = (array)vc_param_group_parse_atts($values);
	$image_alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
	$image = !empty($image) ? wp_get_attachment_image_src($image, 'full')[0] : '';
	$id = uniqid( "rb_tips_" );

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
		$out .= "<div id='".$id."' class='rb_tips_module ".esc_attr($el_class)."'>";

			$out .= "<div class='rb_tips_wrapper'>";
				$out .= '<img src="'.$image.'" alt="'.esc_attr($image_alt).'" />';

				foreach( $values as $value ){
					if( $value['product'] == 'custom' ){
						$inner_image_alt = !empty($value['tip_image']) ? get_post_meta($value['tip_image'], '_wp_attachment_image_alt', TRUE) : '';
						$inner_img = !empty($value['tip_image']) ? wp_get_attachment_image_src( $value['tip_image'], 'thumbnail' ) : '';
						$link = !empty($value['url']) ? $value['url'] : '#';
					} else {
						$product = wc_get_product($value['product']);

						$image_id = get_post_thumbnail_id( $value['product'] );
						$inner_image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
						$inner_img = wp_get_attachment_image_src( get_post_thumbnail_id( $value['product'] ), 'thumbnail' );
						$link = get_permalink( $value['product'] );
					}

					if( !empty($value['pos_top']) && !empty($value['pos_left']) ){
						$local_styles = 'top:'.(int)esc_attr($value['pos_top']).'%; left:'.(int)esc_attr($value['pos_left']).'%;';
					}

					$out .= "<a href='".esc_url($link)."' class='rb_tip' style='".$local_styles."'>";
						$out .= "<i class='tip_trigger'></i>";
						$out .= "<div class='tip_info_wrapper'>";
    						$out .= !empty($inner_img) ? '<img src="'.$inner_img[0].'" alt="'.esc_attr($inner_image_alt).'" />' : '';
							if( $value['product'] == 'custom' ){
								$out .= "<p>".esc_html($value['title'])."</p>";
								$out .= "<span>".esc_html($value['price'])."</span>";
							} else {
								$out .= "<p>".esc_html($product->get_title())."</p>";
								$out .= "<span>".wc_price($product->get_price())."</span>";
							}
						$out .= "</div>";
					$out .= "</a>";
				}
			$out .= "</div>";

		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_tips', 'rb_vc_shortcode_sc_tips' );

?>