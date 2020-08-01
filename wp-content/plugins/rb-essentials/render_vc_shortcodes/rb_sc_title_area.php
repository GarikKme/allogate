<?php

function rb_vc_shortcode_sc_title_area ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"show_mask"				=> true,
		"mask"					=> "",
		"mask_start"			=> "top_left",
		"interactive_img"		=> "",
		"hide_fields"			=> "none",
		"mouse_anim"			=> true,
		"scroll_anim"			=> true,
		"el_class"				=> "",
 		/* -----> STYLES TABS <----- */
 		"share_bg"				=> false,
 		"custom_gradient"		=> false,
		"custom_gradient_css"	=> "",
		"bg_gradient_1"			=> '#1fc5b6',
		"bg_gradient_2"			=> '#296ad4',
		"cats_bg"				=> '#fff',
		"cats_color"			=> PRIMARY_COLOR,
		"title_color"			=> '#fff',
		"divider_color"			=> '#fff',
		"breadcrumbs_color"		=> 'rgba(255,255,255, .8)',
 	);
 	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		"all" => array(
 			"custom_styles"		=> "",
 			"customize_size"	=> false,
			"category_size"		=> "17px",
			"title_size"		=> "70px",
			"title_margins"		=> "0px 0px 0px 0px",
			"divider_margins"	=> "0px 0px 0px 0px",
			"breadcrumbs_size"	=> "17px",
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$id = uniqid( "rb_title_area_" );

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
	if( $show_mask && !empty($mask) ){
		$styles .= "
			#".$id."{
				-webkit-mask-image: url(".wp_get_attachment_image_url($mask).");
				-webkit-mask-size: cover;
			    -webkit-mask-repeat: no-repeat;
	    		-webkit-mask-position: ".esc_attr(str_replace('_', ' ', $mask_start)).";
			}
		";
	}
	if( !empty($bg_gradient_1) && !empty($bg_gradient_2) ){
		$styles .= "
			#".$id."{
				background: -webkit-linear-gradient(-6deg, ".esc_attr($bg_gradient_2).", ".esc_attr($bg_gradient_1).");
    			background: linear-gradient(-6deg, ".esc_attr($bg_gradient_2).", ".esc_attr($bg_gradient_1).");
			}
		";
	}
	if( !empty($cats_bg) ){
		$styles .= "
			#".$id." .single_post_categories{
				background-color: ".esc_attr($cats_bg).";
			}
		";
	}
	if( !empty($cats_color) ){
		$styles .= "
			#".$id." .single_post_categories a{
				color: ".esc_attr($cats_color).";
			}
		";
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .page_title{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($divider_color) ){
		$styles .= "
			#".$id." .title_divider{
				background-color: ".esc_attr($divider_color).";
			}
		";
	}
	if( !empty($breadcrumbs_color) ){
		$styles .= "
			#".$id." .woocommerce-breadcrumb *,
			#".$id." .bread-crumbs *,
			#".$id." .bread-crumbs{
				color: ".esc_attr($breadcrumbs_color).";
			}
		";
	}
	if( $customize_size ){
		if( !empty($category_size) ){
			$styles .= "
				#".$id." .single_post_categories a{
					font-size: ".(int)esc_attr($category_size)."px;
				}
			";
		}
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .page_title{
					font-size: ".(int)esc_attr($title_size)."px;
				}
			";
		}
		if( !empty($title_margins) ){
			$styles .= "
				#".$id." .page_title{
					margin: ".esc_attr($title_margins).";
				}
			";
		}
		if( !empty($divider_margins) ){
			$styles .= "
				#".$id." .title_divider{
					margin: ".esc_attr($divider_margins).";
				}
			";
		}
		if( !empty($breadcrumbs_size) ){
			$styles .= "
				#".$id." .woocommerce-breadcrumb *,
				#".$id." .bread-crumbs *{
					font-size: ".(int)esc_attr($breadcrumbs_size)."px;
				}
			";
		}
	}
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( 
		!empty($vc_landscape_styles) ||
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
				if( !empty($category_size_landscape) ){
					$styles .= "
						#".$id." .single_post_categories a{
							font-size: ".(int)esc_attr($category_size_landscape)."px;
						}
					";
				}
				if( !empty($title_size_landscape) ){
					$styles .= "
						#".$id." .page_title{
							font-size: ".(int)esc_attr($title_size_landscape)."px;
						}
					";
				}
				if( !empty($title_margins_landscape) ){
					$styles .= "
						#".$id." .page_title{
							margin: ".esc_attr($title_margins_landscape).";
						}
					";
				}
				if( !empty($divider_margins_landscape) ){
					$styles .= "
						#".$id." .title_divider{
							margin: ".esc_attr($divider_margins_landscape).";
						}
					";
				}
				if( !empty($breadcrumbs_size_landscape) ){
					$styles .= "
						#".$id." .woocommerce-breadcrumb *,
						#".$id." .bread-crumbs *{
							font-size: ".(int)esc_attr($breadcrumbs_size_landscape)."px;
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
				if( !empty($category_size_portrait) ){
					$styles .= "
						#".$id." .single_post_categories a{
							font-size: ".(int)esc_attr($category_size_portrait)."px;
						}
					";
				}
				if( !empty($title_size_portrait) ){
					$styles .= "
						#".$id." .page_title{
							font-size: ".(int)esc_attr($title_size_portrait)."px;
						}
					";
				}
				if( !empty($title_margins_portrait) ){
					$styles .= "
						#".$id." .page_title{
							margin: ".esc_attr($title_margins_portrait).";
						}
					";
				}
				if( !empty($divider_margins_portrait) ){
					$styles .= "
						#".$id." .title_divider{
							margin: ".esc_attr($divider_margins_portrait).";
						}
					";
				}
				if( !empty($breadcrumbs_size_portrait) ){
					$styles .= "
						#".$id." .woocommerce-breadcrumb *,
						#".$id." .bread-crumbs *{
							font-size: ".(int)esc_attr($breadcrumbs_size_portrait)."px;
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
				if( !empty($category_size_mobile) ){
					$styles .= "
						#".$id." .single_post_categories a{
							font-size: ".(int)esc_attr($category_size_mobile)."px;
						}
					";
				}
				if( !empty($title_size_mobile) ){
					$styles .= "
						#".$id." .page_title{
							font-size: ".(int)esc_attr($title_size_mobile)."px;
						}
					";
				}
				if( !empty($title_margins_mobile) ){
					$styles .= "
						#".$id." .page_title{
							margin: ".esc_attr($title_margins_mobile).";
						}
					";
				}
				if( !empty($divider_margins_mobile) ){
					$styles .= "
						#".$id." .title_divider{
							margin: ".esc_attr($divider_margins_mobile).";
						}
					";
				}
				if( !empty($breadcrumbs_size_mobile) ){
					$styles .= "
						#".$id." .woocommerce-breadcrumb *,
						#".$id." .bread-crumbs *{
							font-size: ".(int)esc_attr($breadcrumbs_size_mobile)."px;
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

	$extra_classes = '';
	$extra_classes .= $mouse_anim ? ' mouse_anim' : '';
	$extra_classes .= $scroll_anim ? ' scroll_anim' : '';
	$extra_classes .= $share_bg ? ' shared_bg' : '';
	$extra_classes .= !empty($el_class) ? ' '.$el_class : "";

	$extra_styles = 'style="';
	$extra_styles .= $custom_gradient ? esc_attr($custom_gradient_css) : '';
	$extra_styles .= !empty(rb_get_metabox('title_image')) ? ' background-image: url('.wp_get_attachment_image_src( rb_get_metabox('title_image'), "full" )[0].');' : '';
	$extra_styles .= '"';
	
	/* -----> Title Area module output <----- */
	$out .= "<div id='".$id."' class='custom page_title_container ".$extra_classes."' ".$extra_styles.">";

		if( !empty($interactive_img) ){
			$dynamic_image = !empty(rb_get_metabox('title_interactive_image')) ? rb_get_metabox('title_interactive_image') : $interactive_img;
			$dynamic_image = wp_get_attachment_image_src( $dynamic_image, 'full' )[0];

			$out .= "<img data-depth='0.80' src='".esc_url($dynamic_image)."' class='page_title_dynamic_image' alt='".get_the_title()."' />";
		}

		$out .= "<div class='page_title_wrapper'>";

			if( is_singular('post') && strripos($hide_fields, 'cats') === false ){
				$out .= "<div class='single_post_categories title_ff'>";
					ob_start();
						the_category(' ');
					$out .= ob_get_clean();
				$out .= "</div>";
			}
			if( strripos($hide_fields, 'title') === false ){
				$out .= '<div class="page_title_customizer_size">';
					$out .= "<h1 class='page_title'>";
						$out .= rb_get_page_title();
					$out .= "</h1>";
				$out .= '</div>';
			}
			if( strripos($hide_fields, 'divider') === false ){
				$out .= "<span class='title_divider'></span>";
			}
			if( strripos($hide_fields, 'breadcrumbs') === false ){
				ob_start();
					get_template_part( 'tmpl/header-breadcrumbs' );
				$out .= ob_get_clean();
			}

		$out .= "</div>";
		
		if( is_singular( 'rb_case_study' ) ){
			$logo = !empty(rb_get_metabox('case_logo_image')) ? rb_get_metabox('case_logo_image') : '';
			$logo_title = !empty(rb_get_metabox('case_logo_title')) ? rb_get_metabox('case_logo_title') : '';

			if( !empty($logo) || !empty($logo_title) ){
				$out .= '<div class="case_study_logo">';
					$out .= wp_get_attachment_image( rb_get_metabox('case_logo_image'), 'thumbnail' );
					$out .= '<p>'.$logo_title.'</p>';
				$out .= '</div>';
			}
		}

	$out .= "</div>";

	// endif;

	return $out;
}
add_shortcode( 'rb_sc_title_area', 'rb_vc_shortcode_sc_title_area' );

?>