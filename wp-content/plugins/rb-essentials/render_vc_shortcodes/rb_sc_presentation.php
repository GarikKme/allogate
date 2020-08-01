<?php

function rb_vc_shortcode_sc_presentation ( $atts = array(), $content = "" ){
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
	$id = uniqid( "rb_presentation_" );
	$count = 0;

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

	rb__vc_styles($styles);

	/* -----> Filter Products module output <----- */
	if( !empty($values) ){
		$out .= "<div id='".$id."' class='rb_presentation_module ".esc_attr($el_class)."'>";

			$out .= '<ul class="presentation_triggers">';
				foreach( $values as $key => $value ){
					$out .= '<li class="presentation_trigger'.($count == 0 ? ' active' : '').'" data-tab="'.$id.'_'.$key.'">';
						$out .= '<i class="images_count">'.count(explode(',', $value['images'])).'</i>';
						$out .= esc_html($value['title']);
					$out .= '</li>';

					$count ++;
				}
			$out .= '</ul>';

			$count = 0;

			$out .= '<div class="presentation_content">';
				foreach( $values as $key => $value ){
					$out .= '<div class="presentation_tab'.($count == 0 ? ' active' : '').'" data-tab="'.$id.'_'.$key.'">';
						foreach( explode(',', $value['images']) as $image ){
							$image_alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
							$image_custom_url = get_post_meta($image, 'rb_custom_url', TRUE);
							$image_title = get_the_title($image);
							$image_src = wp_get_attachment_image_src( $image,'full' )[0];

							$out .= '<div class="presentation_single_image">';
								$out .= '<a href="'.esc_attr($image_custom_url).'" class="presentation_image_wrapper">';
									$out .= '<img src="'.esc_url($image_src).'" class="presentation_img" alt="'.esc_attr($image_alt).'" />';
								$out .= "</a>";

								$out .= '<a href="'.esc_attr($image_custom_url).'" class="presentation_link">'.esc_html($image_title).'</a>';
							$out .= "</div>";
						}
					$out .= "</div>";
					$count ++;
				}
			$out .= "</div>";

		$out .= "</div>";
	}

	return $out;
}
add_shortcode( 'rb_sc_presentation', 'rb_vc_shortcode_sc_presentation' );

?>