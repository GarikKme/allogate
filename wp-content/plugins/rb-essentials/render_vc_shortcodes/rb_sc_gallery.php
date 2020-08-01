<?php

function rb_vc_shortcode_sc_gallery ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		'columns'					=> '3',
		'values'					=> '',
		'url'						=> 'none',
		'enable_masonry'			=> true,
		'el_class'					=> '',
		/* -----> STYLING TAB <----- */
		'text_color'				=> '#fff',
		'plus_color'				=> PRIMARY_COLOR,
		'overlay_gradient_1'		=> 'rgba(255,175,0, .75)',
		'overlay_gradient_2'		=> 'rgba(255,104,73, .75)',
 	);
 	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		'all' => array(
 			'custom_styles'		=> '',
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$values = (array)vc_param_group_parse_atts($values);
	$id = uniqid( "rb_gallery_" );

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
	if( !empty($text_color) ){
		$styles .= "
			.".$id." .text_wrapper h5,
			.".$id." .text_wrapper p{
				color: ".esc_attr($text_color).";
			}
			.".$id." .icon_wrapper,
			.".$id." .text_wrapper h5:before{
				background-color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($plus_color) ){
		$styles .= "
			.".$id." .icon_wrapper:before{
				color: ".esc_attr($plus_color).";
			}
		";	
	}
	if( !empty($overlay_gradient_1) && !empty($overlay_gradient_2) ){
		$styles .= "
			.".$id." .rb_gallery_image .rb_gallery_overlay{
			    background: -webkit-linear-gradient(to bottom, ".esc_attr($overlay_gradient_1).", ".esc_attr($overlay_gradient_2).");
				background: linear-gradient(to bottom, ".esc_attr($overlay_gradient_1).", ".esc_attr($overlay_gradient_2).");
			}
		";
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( !empty($vc_landscape_styles) ){
		$styles .= "
			@media 
				screen and (max-width: 1199px),
				screen and (max-width: 1366px) and (any-hover: none)
			{
		";

			$styles .= "
				.".$id."{
					".$vc_landscape_styles.";
				}
			";

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

			$styles .= "
				.".$id."{
					".$vc_portrait_styles.";
				}
			";

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

			$styles .= "
				.".$id."{
					".$vc_mobile_styles.";
				}
			";

		$styles .= "
			}
		";
	}
	/* -----> End of mobile styles <----- */
	rb__vc_styles($styles);
	
	/* -----> Gallery module output <----- */
	$module_classes = $id;
	$module_classes .= ' rb_gallery_wrapper';
	$module_classes .= !empty($el_class) ? " $el_class" : "";

	$end_tag = '</a>';

	$out .= "<div class='".$module_classes."'>";
		$out .= "<div class='rb_gallery_images columns_".$columns . ($enable_masonry ? ' masonry' : '') . ($url == 'media' ? ' magnific' : '')."'>";

			foreach( $values as $value ){
				// Get Image
				$image_alt = get_post_meta($value['image'], '_wp_attachment_image_alt', TRUE);
				$image = !empty($value['image']) ? wp_get_attachment_image_src($value['image'], 'full')[0] : '';
				// Get URL
				if( $url == 'media' ){
					$start_tag = 'a href="'.$image.'"';
				} else if( $url == 'attachment' ){
					$start_tag = 'a href="'.get_attachment_link($value['image']).'"';
				} else {
					$start_tag = 'div';
					$end_tag = '</div>';
				}

				$out .= "<".$start_tag." class='rb_gallery_image'>";
					$out .= "<img src='".$image."' alt='".esc_attr($image_alt)."' />";
					$out .= "<div class='rb_gallery_overlay'>";

						if( !empty($value['title']) || !empty($value['subtitle']) ){
							$out .= "<div class='text_wrapper'>";
								if( !empty($value['title']) ){
									$out .= "<h5>".esc_html($value['title'])."</h5>";
								}
								if( !empty($value['subtitle']) ){
									$out .= "<p>".esc_html($value['subtitle'])."</p>";
								}
							$out .= "</div>";
						} else if( $url != 'none' ){
							$out .= "<span class='icon_wrapper'></span>";
						}

					$out .= "</div>";
				$out .= $end_tag;
			}

		$out .= "</div>";
	$out .= "</div>";

	return $out;
}
add_shortcode( 'rb_sc_gallery', 'rb_vc_shortcode_sc_gallery' );

?>