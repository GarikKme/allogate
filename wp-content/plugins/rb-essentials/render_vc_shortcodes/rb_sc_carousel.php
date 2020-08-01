<?php

function rb_vc_shortcode_carousel ( $atts, $content ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		'columns'					=> '1',
		'landscape_columns'			=> '1',
		'portrait_columns'			=> '1',
		'mobile_columns'			=> '1',
		'slides_to_scroll'			=> '1',
		'pagination'				=> true,
		'navigation'				=> false,
		'auto_height'				=> true,
		'draggable'					=> true,
		'infinite'					=> false,
		'autoplay'					=> false,
		'autoplay_speed'			=> '3000',
		'pause_on_hover'			=> false,
		'vertical'					=> false,
		'vertical_swipe'			=> false,
		'el_class'					=> '',
		/* -----> STYLING TAB <----- */
		'custom_colors'				=> true,
		'nav_color'					=> PRIMARY_COLOR,
		'nav_hover_color'			=> PRIMARY_COLOR,
		'dots_color'				=> '#e5e5e5',
		'dots_active_color'			=> PRIMARY_COLOR,
	);

	$responsive_vars = array(
		'all' => array(
			'custom_styles'	=> ''
		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$id = uniqid( "rb_carousel_" );
	$section_atts = " data-columns='".$columns."'";
	$section_atts .= " data-slides-to-scroll='".$slides_to_scroll."'";
	$section_atts .= " data-pagination='".( $pagination ? 'on' : 'off' )."'";
	$section_atts .= " data-navigation='".( $navigation ? 'on' : 'off' )."'";
	$section_atts .= " data-auto-height='".( $auto_height ? 'on' : 'off' )."'";
	$section_atts .= " data-draggable='".( $draggable ? 'on' : 'off' )."'";
	$section_atts .= " data-infinite='".( $infinite ? 'on' : 'off' )."'";
	$section_atts .= " data-autoplay='".( $autoplay ? 'on' : 'off' )."'";
	$section_atts .= " data-autoplay-speed='".$autoplay_speed."'";
	$section_atts .= " data-pause-on-hover='".( $pause_on_hover ? 'on' : 'off' )."'";
	$section_atts .= " data-vertical='".( $vertical ? 'on' : 'off' )."'";
	$section_atts .= " data-vertical-swipe='".( $vertical_swipe ? 'on' : 'off' )."'";
	$section_atts .= " data-tablet-landscape='".$landscape_columns."'";
	$section_atts .= " data-tablet-portrait='".$portrait_columns."'";
	$section_atts .= " data-mobile='".$mobile_columns."'";

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
	if( $custom_colors ){
		if( !empty($nav_color) ){
			$styles .= "
				#".$id." .rb_carousel .slick-arrow{
					color: ".$nav_color.";
				}
			";
		}
		if( !empty($nav_hover_color) ){
			$styles .= "
				@media 
					screen and (min-width: 1367px),
					screen and (min-width: 1200px) and (any-hover: hover),
					screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0),
					screen and (min-width: 1200px) and (-ms-high-contrast: none),
					screen and (min-width: 1200px) and (-ms-high-contrast: active)
				{
					#".$id." .rb_carousel .slick-arrow:hover{
						color: ".$nav_hover_color.";
					}
				}
			";
		}
		if( !empty($dots_color) ){
			$styles .= "
				#".$id." .slick-dots li button{
					border-color: ".$dots_color.";
				}
				#".$id." .slick-dots li:after{
					background-color: ".$dots_color.";
				}
			";
		}
		if( !empty($dots_active_color) ){
			$styles .= "
				#".$id." .slick-dots li.slick-active button{
					border-color: ".$dots_active_color.";
				}
			";
		}
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( !empty($vc_landscape_styles) ){
		$styles .= "
			@media 
				screen and (max-width: 1199px), /*Check, is device a tablet*/
				screen and (max-width: 1366px) and (any-hover: none) /*Enable this styles for iPad Pro 1024-1366*/
			{
				#".$id."{
					".$vc_landscape_styles."
				}
			}
		";
	}
	/* -----> End of landscape styles <----- */

	/* -----> Customize portrait styles <----- */
	if( !empty($vc_portrait_styles) ){
		$styles .= "
			@media screen and (max-width: 991px){
				#".$id."{
					".$vc_portrait_styles."
				}
			}
		";
	}
	/* -----> End of portrait styles <----- */

	/* -----> Customize mobile styles <----- */
	if( !empty($vc_mobile_styles) ){
		$styles .= "
			@media screen and (max-width: 767px){
				#".$id."{
					".$vc_mobile_styles."
				}
			}
		";
	}
	/* -----> End of mobile styles <----- */ 

	rb__vc_styles($styles);

	/* -----> Carousel module output <----- */
	if ( !empty( $content ) ){
		$out .= "<div id='".$id."' class='rb_carousel_wrapper ".esc_attr($el_class)."'". ( !empty($section_atts) ? $section_atts : "" ) .">";

			$shortcode = do_shortcode($content);
			$count = 1;

			if( preg_match_all('/woocommerce/', $shortcode) != 0 ){
				$shortcode = preg_replace('/products/', 'products rb_carousel', $shortcode, $count);
				$out .= $shortcode;
			} else {
				$out .= "<div class='rb_carousel rb_wrapper'>";
					$out .= $shortcode;
				$out .= "</div>";
			}


		$out .= "</div>";
	}
	wp_enqueue_script( 'slick_carousel' );

	return $out;
}
add_shortcode( 'rb_sc_carousel', 'rb_vc_shortcode_carousel' );

?>