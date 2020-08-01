<?php
	if ( !class_exists( 'rb_ext_VC_Config' ) ){
		class rb_ext_VC_Config{
			public function __construct ( $args = array() ){
				require_once(trailingslashit(get_template_directory()) . '/vc/vc_extends/rb_vc_extends.php');

				add_action( 'admin_init', array( $this, 'remove_meta_boxes' ) );
				add_action( 'admin_menu', array( $this, 'remove_grid_elements_menu' ) );
				add_action( 'vc_iconpicker-type-rb_flaticons', array( $this, 'add_rb_flaticons' ) );

				add_action( 'init', array( $this, 'remove_vc_elements' ) );
				add_action( 'init', array( $this, 'config' ) );
				if( SETECH__ACTIVE ){
					add_action( 'init', array( $this, 'extend_shortcodes' ) );
				}
				add_action( 'init', array( $this, 'extend_params' ) );
				add_action( 'init', array( $this, 'modify_vc_elements' ) );
			}
			public function add_rb_shortcode($name, $param1, $param2)  {
				$short = 'shortcode';
				call_user_func('vc_add_' . $short.$name, $param1, $param2);
			}
			// Remove Teaser metabox
			public function remove_meta_boxes() {
				remove_meta_box( 'vc_teaser', 'page', 		'side' );
				remove_meta_box( 'vc_teaser', 'post', 		'side' );
				remove_meta_box( 'vc_teaser', 'portfolio', 	'side' );
				remove_meta_box( 'vc_teaser', 'product', 	'side' );
			}
			// Remove 'Grid Elements' from Admin menu
			public function remove_grid_elements_menu(){
				remove_menu_page( 'edit.php?post_type=vc_grid_item' );
			}
			// Remove VC Elements
			public function remove_vc_elements (){
				vc_remove_element( 'vc_separator' );
				vc_remove_element( 'vc_text_separator' );
				vc_remove_element( 'vc_message' );
				vc_remove_element( 'vc_gallery' );
				vc_remove_element( 'vc_tta_tour' );
				vc_remove_element( 'vc_tta_pageable' );
				vc_remove_element( 'vc_custom_heading' );
				vc_remove_element( 'vc_cta' );
				vc_remove_element( 'vc_posts_slider' );
				vc_remove_element( 'vc_progress_bar' );
				vc_remove_element( 'vc_basic_grid' );
				vc_remove_element( 'vc_media_grid' );
				vc_remove_element( 'vc_masonry_grid' );
				vc_remove_element( 'vc_masonry_media_grid' );
				vc_remove_element( 'vc_widget_sidebar' );
			}
			public function config(){
				vc_set_default_editor_post_types( array(
					'page',					
					'megamenu_item',
					'rb-megamenu',
					'rb-tmpl-footer',
					'rb-tmpl-sticky',
					'rb-tmpl-header',
					'rb_case_study',
				)); 
			}
			// Extend Composer with Theme Shortcodes
			public function extend_shortcodes (){
				$shortcodes = array(
					'rb_sc_banners',
					'rb_sc_blog',
					'rb_sc_button',
					'rb_sc_breadcrumbs',
					'rb_sc_carousel',
					'rb_sc_case_study',
					'rb_sc_divider',
					'rb_sc_gallery',
					'rb_sc_icon',
					'rb_sc_icon_list',
					'rb_sc_image',
					'rb_sc_info_box',
					'rb_sc_latest_posts',
					'rb_sc_logo',
					'rb_sc_menu',
					'rb_sc_menu_list',
					'rb_sc_milestone',
					'rb_sc_notice',
					'rb_sc_our_team',
					'rb_sc_popup_video',
					'rb_sc_portfolio',
					'rb_sc_presentation',
					'rb_sc_pricing_plan',
					'rb_sc_progress_bar',
					'rb_sc_roadmap',
					'rb_sc_search',
					'rb_sc_service',
					'rb_sc_testimonials',
					'rb_sc_text',
					'rb_sc_tips',
					'rb_sc_title_area',
				);
				if( class_exists('WooCommerce') ){
					$shortcodes[] = 'rb_sc_tips';
				}

				if( SETECH__ACTIVE ){
					foreach( $shortcodes as $shortcode ){
						require_once( trailingslashit( get_template_directory() ) . 'vc/theme_shortcodes/'.$shortcode.'.php' );
						require_once( SETECH__PLUGINS_DIR . 'rb-essentials/render_vc_shortcodes/'.$shortcode.'.php' );
					}
				}
			}
			// Extend Composer with Custom Parametres
			public function extend_params (){
				require_once( trailingslashit( get_template_directory() ) . 'vc/params/rb_dropdown.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/params/rb_svg.php' );
			}
			// Modify VC Elements
			public function modify_vc_elements (){
				if ( function_exists( 'vc_add'.'_shortcode_param' ) ) {
 					$this->add_rb_shortcode('_param' , 'rb_svg' , 'rb_vc_svg');
				}				
				vc_remove_param( 'vc_row', 'columns_placement' );		

				vc_remove_param( 'vc_tta_accordion', 'style' );
				vc_remove_param( 'vc_tta_accordion', 'shape' );
				vc_remove_param( 'vc_tta_accordion', 'color' );
				vc_remove_param( 'vc_tta_accordion', 'no_fill' );
				vc_remove_param( 'vc_tta_accordion', 'spacing' );
				vc_remove_param( 'vc_tta_accordion', 'gap' );

				vc_remove_param( 'vc_tta_tabs', 'style' );
				vc_remove_param( 'vc_tta_tabs', 'shape' );
				vc_remove_param( 'vc_tta_tabs', 'color' );
				vc_remove_param( 'vc_tta_tabs', 'no_fill_content_area' );
				vc_remove_param( 'vc_tta_tabs', 'spacing' );
				vc_remove_param( 'vc_tta_tabs', 'gap' );
				vc_remove_param( 'vc_tta_tabs', 'pagination_style' );
				vc_remove_param( 'vc_tta_tabs', 'pagination_color' );

				vc_remove_param( 'vc_toggle', 'style' );
				vc_remove_param( 'vc_toggle', 'color' );
				vc_remove_param( 'vc_toggle', 'size' );
				vc_remove_param( 'vc_toggle', 'use_custom_heading' );

				vc_remove_param( 'vc_images_carousel', 'partial_view' );	
			}
			public function add_rb_flaticons ( $icons ){
				$icon_id = "";
				$fi_array = array();
				$fi_icons = rb_get_all_flaticon_icons();	

				if ( !is_array( $fi_icons ) || empty( $fi_icons ) ){
					return $icons;
				}

				for ( $i = 0; $i < count( $fi_icons ); $i++ ){
					$icon_id = $fi_icons[$i];
					$icon_class = "flaticon-{$icon_id}";
					array_push( $fi_array, array( "$icon_class" => $icon_id ) );
				}
				$icons = array_merge( $icons, $fi_array );
				return $icons;
			}
		}
	}
	/**/
	/* Config and enable extension */
	/**/
	$vc_config = new rb_ext_VC_Config ();
	/**/
	/* \Config and enable extension */


	if(!class_exists('VC_RB_Background')){
		class VC_RB_Background extends rb_ext_VC_Config{
			static public $row_atts = '';
			static public $column_atts = '';

			function __construct(){
				add_action('admin_init', array($this,'rb_extra_vc_params'));
			}

			/* -----> Start Customize VC_ROW <-----*/
			public static function rb_open_vc_shortcode($atts, $content){
				extract( shortcode_atts( array(
					/* From rb_vc_extends.php -> rb_structure_background_props() */
					//Desktop
					"bg_position"					=> "center",
					"bg_size"						=> "cover",
					"bg_repeat"						=> "no-repeat",
					"bg_attachment"					=> "scroll",
					"custom_bg_position"			=> "",
					"custom_bg_size"				=> "",
					"bg_hover"						=> "no_hover",
					"bg_transition"					=> "0.3",
					"add_shadow"					=> false,
					"shadow_color"					=> "rgba(0,0,0, .15)",
					//Landscape
					"custom_styles_landscape" 		=> "",
					"customize_bg_landscape"		=> false,
					"bg_position_landscape"			=> "center",
					"bg_size_landscape"				=> "cover",
					"bg_repeat_landscape"			=> "no-repeat",
					"bg_attachment_landscape"		=> "scroll",
					"custom_bg_position_landscape"	=> "",
					"custom_bg_size_landscape"		=> "",
					"hide_bg_landscape" 			=> false,
					//Portrait
					"custom_styles_portrait" 		=> "",
					"customize_bg_portrait"			=> false,
					"bg_position_portrait"			=> "center",
					"bg_size_portrait"				=> "cover",
					"bg_repeat_portrait"			=> "no-repeat",
					"bg_attachment_portrait"		=> "scroll",
					"custom_bg_position_portrait"	=> "",
					"custom_bg_size_portrait"		=> "",
					"hide_bg_portrait" 				=> false,
					//Mobile
					"custom_styles_mobile" 			=> "",
					"customize_bg_mobile"			=> false,
					"bg_position_mobile"			=> "center",
					"bg_size_mobile"				=> "cover",
					"bg_repeat_mobile"				=> "no-repeat",
					"bg_attachment_mobile"			=> "scroll",
					"custom_bg_position_mobile"		=> "",
					"custom_bg_size_mobile"			=> "",
					"hide_bg_mobile" 				=> false,
					/*\ From rb_structure_background_props \*/

					/* Start Overlay Properties */
					"bg_rb_color" 						=> "none",
					"rb_overlay_color" 				=> PRIMARY_COLOR,
					"rb_gradient_color_from" 			=> "#000",
					"rb_gradient_color_to" 			=> "#fff",
					"rb_gradient_opacity" 				=> "50",
					"rb_gradient_type" 				=> "linear",
					"rb_gradient_angle" 				=> "45",
					"rb_gradient_shape_variant_type" 	=> "simple",
					"rb_gradient_shape_type" 			=> "ellipse",
					"rb_gradient_size_keyword_type" 	=> "closest-side",
					"rb_gradient_size_type" 			=> "60% 55%",
					/*\ End Overlay Properties \*/

					/* Start Extra Layer Properties */
					"add_layers" 				=> false,
					"rb_layer_image" 			=> "",
					"extra_layer_pos" 			=> "left",
					"extra_layer_width" 		=> "",
					"extra_layer_size" 			=> "initial",
					"extra_layer_position" 		=> "left top",
					"extra_layer_repeat" 		=> "no-repeat",
					"extra_layer_bg" 			=> "",
					"extra_layer_margin" 		=> "0px 0px",
					"extra_layer_opacity" 		=> "100",
					"hide_layer_landscape" 		=> false,
					"hide_layer_portrait" 		=> false,
					"hide_layer_mobile" 		=> false,
					"overflow_hidden"			=> false,
					"z_index" 					=> "",
					"shift" 					=> "",
					/* End Extra Layer Properties */

					/* Start Particles Properties */
					"particles"			=> false,
					"particles_width"	=> "300px",
					"particles_height"	=> "300px",
					"particles_hide"	=> "767",
					"particles_left"	=> "",
					"particles_top"		=> "",
					"particles_start"	=> "top_left",
					"particles_speed"	=> "2",
					"particles_size"	=> "10",
					"particles_linked"	=> false,
					"particles_count"	=> "25",
					"particles_shape"	=> "circle",
					"particles_image"	=> "",
					"particles_mode"	=> "out",
					"particles_color"	=> PRIMARY_COLOR,
					/*\ End Particles Properties \*/

					/* Start Mask Properties */
					"add_mask"			=> false,
					"mask_image"		=> "",
					"mask_start"		=> "top_left"
					/*\ End Mask Properties \*/

				), $atts ) );

				/* -----> Variables declaration <----- */
				$out = $styles = $full_width = $extra_layer_styles = $particles_styles = $particles_wrap_styles = $particles_data = "";
				$id = uniqid( "rb_content_" );

				/* -----> Visual Composer Responsive styles <----- */
				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_landscape, $vc_landscape_styles); 
				$vc_landscape_styles = implode($vc_landscape_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_portrait, $vc_portrait_styles); 
				$vc_portrait_styles = implode($vc_portrait_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_mobile, $vc_mobile_styles); 
				$vc_mobile_styles = implode($vc_mobile_styles);

				/* -----> Customize default styles <----- */
				$styles .= "
					.".$id." > .vc_row{
						background-attachment: ".$bg_attachment." !important;
						background-repeat: ".$bg_repeat." !important;
					}
				";
				if( $bg_size == 'custom' && !empty($custom_bg_size) ){
					$styles .= "
						.".$id." > .vc_row{
							background-size: ".$custom_bg_size." !important;
						}
					";
				} else if( $bg_size == 'custom' && empty($custom_bg_size) ) {
					$styles .= "
						.".$id." > .vc_row{
							background-size: cover !important;
						}
					";
				} else {
					$styles .= "
						.".$id." > .vc_row{
							background-size: ".$bg_size." !important;
						}
					";
				}
				if( $bg_position == 'custom' && !empty($custom_bg_position) ){
					$styles .= "
						.".$id." > .vc_row{
							background-position: ".$custom_bg_position." !important;
						}
					";
				} else if( $bg_position == 'custom' && empty($custom_bg_position) ) {
					$styles .= "
						.".$id." > .vc_row{
							background-position: center center !important;
						}
					";
				} else {
					$styles .= "
						.".$id." > .vc_row{
							background-position: ".$bg_position." !important;
						}
					";
				}
				if( $bg_rb_color == 'color' && !empty($rb_overlay_color) ){
					$styles .= "
						.".$id." > .vc_row:before{
							background-color: ".$rb_overlay_color.";
						}
					";
				}
				if( $bg_hover != 'no_hover' && !empty($bg_transition) ){
					$styles .= "
						@media 
							screen and (min-width: 1367px),
							screen and (min-width: 1200px) and (any-hover: hover),
							screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0),
							screen and (min-width: 1200px) and (-ms-high-contrast: none),
							screen and (min-width: 1200px) and (-ms-high-contrast: active)
						{
					";

						$styles .= "
							.".$id." > .vc_row{
								-webkit-transition-duration: ".esc_attr($bg_transition)."s;
								transition-duration: ".esc_attr($bg_transition)."s;
							}
						";

					$styles .= "
						}
					";
				}
				if( $bg_rb_color == 'gradient' ){
					!empty($rb_gradient_color_from) ? $color1 = esc_attr($rb_gradient_color_from) : $color1 = '#000';
					!empty($rb_gradient_color_to) ? $color2 = esc_attr($rb_gradient_color_to) : $color2 = '#fff';
					!empty($rb_gradient_opacity) ? $opacity = (esc_attr($rb_gradient_opacity) / 100) : $opacity = 0;


					if( $rb_gradient_type == 'linear' ){
						!empty($rb_gradient_angle) ? $angle = (int)esc_attr($rb_gradient_angle) : $angle = 0;

						$styles .= "
							.".$id." > .vc_row:before{
								background: -webkit-linear-gradient(".$angle."deg, ".$color1.", ".$color2." );
								background: -moz-linear-gradient(".$angle."deg, ".$color1.", ".$color2." );
								background: -o-linear-gradient(".$angle."deg, ".$color1.", ".$color2." );
								background: linear-gradient(".$angle."deg, ".$color1.", ".$color2." );
								opacity: ".$opacity.";
							}
						";
					} else if( $rb_gradient_type == 'radial' ){
						!empty($rb_gradient_size_type) ? $size = esc_attr($rb_gradient_size_type) : $size = '0% 0%';

						if( $rb_gradient_shape_variant_type == 'simple' ){
							$styles .= "
								.".$id." > .vc_row:before{
									background: -webkit-radial-gradient(".$rb_gradient_shape_type.", ".$color1.", ".$color2." );
									background: -moz-radial-gradient(".$rb_gradient_shape_type.", ".$color1.", ".$color2." );
									background: -o-radial-gradient(".$rb_gradient_shape_type.", ".$color1.", ".$color2." );
									background: radial-gradient(".$rb_gradient_shape_type.", ".$color1.", ".$color2." );
									opacity: ".$opacity.";
								}
							";
						} else {
							$styles .= "
								.".$id." > .vc_row:before{
									background: -webkit-radial-gradient(".$size." ".$rb_gradient_size_keyword_type.", ".$color1." , ".$color2." );
									background: -moz-radial-gradient(".$size." ".$rb_gradient_size_keyword_type.", ".$color1." , ".$color2." );
									background: -o-radial-gradient(".$size." ".$rb_gradient_size_keyword_type.", ".$color1." , ".$color2." );
									background: radial-gradient(".$rb_gradient_size_keyword_type." at ".$size.", ".$color1." , ".$color2." );
									opacity: ".$opacity.";
								}
							";
						}
					}
				}
				if( $overflow_hidden ){
					$styles .= "
						.".$id." > .vc_row{
							overflow: hidden !important;
						}
					";
				}
				if( !empty($z_index) ){
					$styles .= "
						.".$id." > .vc_row{
							position: relative;
							overflow: visible;
							z-index: ".(int)esc_attr($z_index).";
						}
					";
				}
				if( !empty($shift) ){
					$styles .= "
						#".$id."{
							position: relative;
							bottom: ".(int)esc_attr($shift)."px;
						}
					";
				}
				if( $add_shadow ){
					$styles .= "
						#".$id." > .vc_row{
							-webkit-box-shadow: 0 0 35px 0 ".esc_attr($shadow_color).";
							-moz-box-shadow: 0 0 35px 0 ".esc_attr($shadow_color).";
							box-shadow: 0 0 35px 0 ".esc_attr($shadow_color).";
						}
					";
				}
				/* -----> End of default styles <----- */

				/* -----> Customize landscape styles <----- */
				if(
					!empty($custom_styles_landscape) || 
					$customize_bg_landscape || 
					$hide_bg_landscape || 
					$hide_layer_landscape 
				){
					$styles .= "
						@media screen and (max-width: 1199px){
					";

						if( !empty($custom_styles_landscape) ){
							$styles .= "
								.".$id." > .vc_row{
									".$vc_landscape_styles."
								}
							";
						}
						if( $customize_bg_landscape ){
							$styles .= "
								.".$id." > .vc_row{
									background-attachment: ".$bg_attachment_landscape." !important;
									background-repeat: ".$bg_repeat_landscape." !important;
								}
							";
							if( $bg_size_landscape == 'custom' && !empty($custom_bg_size_landscape) ){
								$styles .= "
									.".$id." > .vc_row{
										background-size: ".$custom_bg_size_landscape." !important;
									}
								";
							} else if( $bg_size_landscape == 'custom' && empty($custom_bg_size_landscape) ) {
								$styles .= "
									.".$id." > .vc_row{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									.".$id." > .vc_row{
										background-size: ".$bg_size_landscape." !important;
									}
								";
							}
							if( $bg_position_landscape == 'custom' && !empty($custom_bg_position_landscape) ){
								$styles .= "
									.".$id." > .vc_row{
										background-position: ".$custom_bg_position_landscape." !important;
									}
								";
							} else if( $bg_position_landscape == 'custom' && empty($custom_bg_position_landscape) ) {
								$styles .= "
									.".$id." > .vc_row{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									.".$id." > .vc_row{
										background-position: ".$bg_position_landscape." !important;
									}
								";
							}
						}
						if( $hide_bg_landscape ){
							$styles .= "
								.".$id." > .vc_row{
									background-image: none !important;
								}
							";
						}
						if( $hide_layer_landscape ){
							$styles .= "
								#".$id." > .rb_layer{
									display: none;
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
					!empty($custom_styles_portrait) || 
					$customize_bg_portrait || 
					$hide_bg_portrait || 
					$hide_layer_portrait 
				){
					$styles .= "
						@media screen and (max-width: 991px){
					";

						if( !empty($custom_styles_portrait) ){
							$styles .= "
								.".$id." > .vc_row{
									".$vc_portrait_styles."
								}
							";
						}
						if( $customize_bg_portrait ){
							$styles .= "
								.".$id." > .vc_row{
									background-attachment: ".$bg_attachment_portrait." !important;
									background-repeat: ".$bg_repeat_portrait." !important;
								}
							";
							if( $bg_size_portrait == 'custom' && !empty($custom_bg_size_portrait) ){
								$styles .= "
									.".$id." > .vc_row{
										background-size: ".$custom_bg_size_portrait." !important;
									}
								";
							} else if( $bg_size_portrait == 'custom' && empty($custom_bg_size_portrait) ) {
								$styles .= "
									.".$id." > .vc_row{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									.".$id." > .vc_row{
										background-size: ".$bg_size_portrait." !important;
									}
								";
							}
							if( $bg_position_portrait == 'custom' && !empty($custom_bg_position_portrait) ){
								$styles .= "
									.".$id." > .vc_row{
										background-position: ".$custom_bg_position_portrait." !important;
									}
								";
							} else if( $bg_position_portrait == 'custom' && empty($custom_bg_position_portrait) ) {
								$styles .= "
									.".$id." > .vc_row{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									.".$id." > .vc_row{
										background-position: ".$bg_position_portrait." !important;
									}
								";
							}
						}
						if( $hide_bg_portrait ){
							$styles .= "
								.".$id." > .vc_row{
									background-image: none !important;
								}
							";
						}
						if( $hide_layer_portrait ){
							$styles .= "
								#".$id." > .rb_layer{
									display: none;
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
					!empty($custom_styles_mobile) || 
					$customize_bg_mobile || 
					$hide_bg_mobile || 
					$hide_layer_mobile 
				){
					$styles .= "
						@media screen and (max-width: 767px){
					";

						if( !empty($custom_styles_mobile) ){
							$styles .= "
								.".$id." > .vc_row{
									".$vc_mobile_styles."
								}
							";
						}
						if( $customize_bg_mobile ){
							$styles .= "
								.".$id." > .vc_row{
									background-attachment: ".$bg_attachment_mobile." !important;
									background-repeat: ".$bg_repeat_mobile." !important;
								}
							";
							if( $bg_size_mobile == 'custom' && !empty($custom_bg_size_mobile) ){
								$styles .= "
									.".$id." > .vc_row{
										background-size: ".$custom_bg_size_mobile." !important;
									}
								";
							} else if( $bg_size_mobile == 'custom' && empty($custom_bg_size_mobile) ) {
								$styles .= "
									.".$id." > .vc_row{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									.".$id." > .vc_row{
										background-size: ".$bg_size_mobile." !important;
									}
								";
							}
							if( $bg_position_mobile == 'custom' && !empty($custom_bg_position_mobile) ){
								$styles .= "
									.".$id." > .vc_row{
										background-position: ".$custom_bg_position_mobile." !important;
									}
								";
							} else if( $bg_position_mobile == 'custom' && empty($custom_bg_position_mobile) ) {
								$styles .= "
									.".$id." > .vc_row{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									.".$id." > .vc_row{
										background-position: ".$bg_position_mobile." !important;
									}
								";
							}
						}
						if( $hide_bg_mobile ){
							$styles .= "
								.".$id." > .vc_row{
									background-image: none !important;
								}
							";
						}
						if( $hide_layer_mobile ){
							$styles .= "
								.".$id." > .rb_layer{
									display: none;
								}
							";
						}

					$styles .= "
						}
					";
				}
				/* -----> End of mobile styles <----- */


				/* -----> Custom VC_ROW output <----- */
				$row_classes = $id;
				$row_classes .= " rb-content";
				$row_classes .= " background_".$bg_hover;
				$row_classes .= $add_mask ? " mask_".$mask_start : '';

				$row_data = $add_mask ? 'data-mask="'.wp_get_attachment_image_src($mask_image)[0].'"' : '';

				$out = '<div id="'.$id.'" class="'.$row_classes.'" '.$row_data.'>';

				$styles = trim($styles);
				$styles = preg_replace('/\s+/', ' ', $styles);

				rb__vc_styles($styles);

				/*-----> Get VC_ROW properties <-----*/
				$sc_obj = Vc_Shortcodes_Manager::getInstance()->getElementClass( 'vc_row' );
				$row_class_vc = vc_map_get_attributes( $sc_obj->getShortcode(), $atts );
				extract( $row_class_vc );

				$extra_layer_classes = "";
				$extra_layer_atts = "";

				if( !empty($full_width) ){
					$extra_layer_classes .= " rb_stretch_row";
					$extra_layer_atts .= " data-vc-full-width='true' data-vc-full-width-init='false'";
				}

				/*-----> Extra Layer Input <-----*/
				if( $add_layers ){
					if( !empty($rb_layer_image) ){
						$src = wp_get_attachment_image_src($rb_layer_image, 'full');
						$extra_layer_styles .= 'background-image:url("'.esc_attr($src[0]).'");';
					}

					$extra_layer_styles .= "
						".(!empty($extra_layer_pos) ? $extra_layer_pos.":0%;" : '')."
						".(!empty($extra_layer_width) ? " width:".(float)esc_attr($extra_layer_width)."% !important;" : '')."
						".(!empty($extra_layer_size) ? " background-size:".$extra_layer_size.";" : '')."
						".(!empty($extra_layer_position) ? " background-position:".$extra_layer_position.";" : '')."
						".(!empty($extra_layer_repeat) ? " background-repeat:".$extra_layer_repeat.";" : '')."
						".(!empty($extra_layer_bg) ? " background-color:".$extra_layer_bg.";" : '')."
						".(!empty($extra_layer_margin) ? " margin: ".esc_attr($extra_layer_margin).";" : 'rb_vc_config.php')."
						".(!empty($extra_layer_opacity) ? " opacity: ".( (int)esc_attr($extra_layer_opacity) / 100 ).";" : '')."
					";

					$out .= "<div class='rb_layer".$extra_layer_classes."'".$extra_layer_atts.">";
						$out .= "<div style='".esc_attr($extra_layer_styles)."'></div>";
					$out .= "</div>";

					if( !empty($full_width) ){
						$out .= "<div class='vc_row-full-width vc_clearfix'></div>";
					}
				}

				/*-----> Particles <-----*/
				if( $particles ){
					wp_enqueue_script( 'rb-particles' );

					$particles_id = uniqid('particles-');

					$particles_data .= !empty($particles_color) ? " data-color='".esc_attr($particles_color)."'" : "";
					$particles_data .= !empty($particles_size) ? " data-size='".esc_attr($particles_size)."'" : "";
					$particles_data .= !empty($particles_linked) ? " data-linked='".esc_attr($particles_linked)."'" : "";
					$particles_data .= !empty($particles_count) ? " data-count='".esc_attr($particles_count)."'" : "";
					$particles_data .= !empty($particles_speed) ? " data-speed='".esc_attr($particles_speed)."'" : "";
					$particles_data .= !empty($particles_hide) ? " data-hide='".esc_attr($particles_hide)."'" : "";
					$particles_data .= !empty($particles_shape) ? " data-shape='".esc_attr($particles_shape)."'" : "";
					$particles_data .= !empty($particles_mode) ? " data-mode='".esc_attr($particles_mode)."'" : "";
					$particles_data .= !empty($particles_image) ? " data-image-url='".wp_get_attachment_image_src($particles_image)[0]."'" : "";
					$particles_data .= !empty($particles_image) ? " data-image-width='".wp_get_attachment_image_src($particles_image)[1]."'" : "";
					$particles_data .= !empty($particles_image) ? " data-image-height='".wp_get_attachment_image_src($particles_image)[2]."'" : "";

					$particles_styles .= !empty($particles_width) ? "width:".esc_attr($particles_width).";" : "";
					$particles_styles .= !empty($particles_height) ? "height:".esc_attr($particles_height).";" : "";

					$particles_wrap_styles .= !empty($particles_left) ? "margin-left:".esc_attr($particles_left).";" : "";
					$particles_wrap_styles .= !empty($particles_top) ? "margin-top:".esc_attr($particles_top).";" : "";

					$out .= "<div class='particles-wrapper' ". (!empty($particles_wrap_styles) ? 'style="'.$particles_wrap_styles.'"' : '') .">";
						$out .= "<div id='".$particles_id."' class='particles-js ".$particles_start."' ".$particles_data." style='".$particles_styles."'></div>";
					$out .= "</div>";

					if( !empty($full_width) ){
						$out .= "<div class='vc_row-full-width vc_clearfix'></div>";
					}
				}

				return $out;
			}
			public static function rb_close_vc_shortcode($atts, $content){
				$out = "</div>";

				return $out;
			}
			/*\ -----> End Customize VC_ROW <-----\*/


			/* -----> Start Customize VC_COLUMN <-----*/
			public static function rb_open_vc_shortcode_column($atts, $content){
				extract( shortcode_atts( array(
					/* From rb_vc_extends.php -> rb_structure_background_props() */
					//Desktop
					"bg_position"					=> "center",
					"bg_size"						=> "cover",
					"bg_repeat"						=> "no-repeat",
					"bg_attachment"					=> "scroll",
					"custom_bg_position"			=> "",
					"custom_bg_size"				=> "",
					//Landscape
					"custom_styles_landscape" 		=> "",
					"customize_bg_landscape"		=> false,
					"bg_position_landscape"			=> "center",
					"bg_size_landscape"				=> "cover",
					"bg_repeat_landscape"			=> "no-repeat",
					"bg_attachment_landscape"		=> "scroll",
					"custom_bg_position_landscape"	=> "",
					"custom_bg_size_landscape"		=> "",
					"hide_bg_landscape" 			=> false,
					//Portrait
					"custom_styles_portrait" 		=> "",
					"customize_bg_portrait"			=> false,
					"bg_position_portrait"			=> "center",
					"bg_size_portrait"				=> "cover",
					"bg_repeat_portrait"			=> "no-repeat",
					"bg_attachment_portrait"		=> "scroll",
					"custom_bg_position_portrait"	=> "",
					"custom_bg_size_portrait"		=> "",
					"hide_bg_portrait" 				=> false,
					//Mobile
					"custom_styles_mobile" 			=> "",
					"customize_bg_mobile"			=> false,
					"bg_position_mobile"			=> "center",
					"bg_size_mobile"				=> "cover",
					"bg_repeat_mobile"				=> "no-repeat",
					"bg_attachment_mobile"			=> "scroll",
					"custom_bg_position_mobile"		=> "",
					"custom_bg_size_mobile"			=> "",
					"hide_bg_mobile" 				=> false,
					/*\ From rb_structure_background_props \*/
					"column_shadow_color"			=> "",
					"animation_load"				=> "none",
					"animation_duration"			=> "1000",
					"animation_delay"				=> "0",
					"timing_function"				=> "ease",
					"custom_timing_function"		=> "",
					"place_ahead"					=> false,
				), $atts ) );

				/* -----> Variables declaration <----- */
				$out = $styles = $offset = $width = "";
				$id = uniqid( "rb_column_" );

				/* -----> Visual Composer Responsive styles <----- */
				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_landscape, $vc_landscape_styles); 
				$vc_landscape_styles = implode($vc_landscape_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_portrait, $vc_portrait_styles); 
				$vc_portrait_styles = implode($vc_portrait_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_mobile, $vc_mobile_styles); 
				$vc_mobile_styles = implode($vc_mobile_styles);

				/* -----> Customize default styles <----- */
				$styles .= "
					#".$id." > .wpb_column > .vc_column-inner{
						background-attachment: ".$bg_attachment." !important;
						background-repeat: ".$bg_repeat." !important;
					}
				";
				if( $bg_size == 'custom' && !empty($custom_bg_size) ){
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-size: ".$custom_bg_size." !important;
						}
					";
				} else if( $bg_size == 'custom' && empty($custom_bg_size) ) {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-size: cover !important;
						}
					";
				} else {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-size: ".$bg_size." !important;
						}
					";
				}
				if( $bg_position == 'custom' && !empty($custom_bg_position) ){
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-position: ".$custom_bg_position." !important;
						}
					";
				} else if( $bg_position == 'custom' && empty($custom_bg_position) ) {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-position: center center !important;
						}
					";
				} else {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-position: ".$bg_position." !important;
						}
					";
				}
				if( !empty($column_shadow_color) ){
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							-webkit-box-shadow: 0px 0px 35px 0px ".esc_attr($column_shadow_color).";
							-moz-box-shadow: 0px 0px 35px 0px ".esc_attr($column_shadow_color).";
							box-shadow: 0px 0px 35px 0px ".esc_attr($column_shadow_color).";
						}
					";
				}
				if( $animation_load != 'none' ){
					if( !empty($animation_duration) ){
						$styles .= "
							#".$id."{
								transition-duration: ".(int)$animation_duration."ms;
							}
						";
					}
					if( !empty($animation_delay) ){
						$styles .= "
							#".$id."{
								transition-delay: ".(int)$animation_delay."ms;
							}
						";
					}
					if( !empty($timing_function) ){
						$styles .= "
							#".$id."{
								transition-timing-function: ".($timing_function != 'custom' ? $timing_function : $custom_timing_function ).";
							}
						";
					}
				}
				/* -----> End of default styles <----- */

				/* -----> Customize landscape styles <----- */
				if(
					!empty($custom_styles_landscape) || 
					$customize_bg_landscape || 
					$hide_bg_landscape 
				){
					$styles .= "
						@media screen and (max-width: 1199px){
					";

						if( !empty($custom_styles_landscape) ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									".$vc_landscape_styles."
								}
							";
						}
						if( $customize_bg_landscape ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-attachment: ".$bg_attachment_landscape." !important;
									background-repeat: ".$bg_repeat_landscape." !important;
								}
							";
							if( $bg_size_landscape == 'custom' && !empty($custom_bg_size_landscape) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$custom_bg_size_landscape." !important;
									}
								";
							} else if( $bg_size_landscape == 'custom' && empty($custom_bg_size_landscape) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$bg_size_landscape." !important;
									}
								";
							}
							if( $bg_position_landscape == 'custom' && !empty($custom_bg_position_landscape) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$custom_bg_position_landscape." !important;
									}
								";
							} else if( $bg_position_landscape == 'custom' && empty($custom_bg_position_landscape) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$bg_position_landscape." !important;
									}
								";
							}
						}
						if( $hide_bg_landscape ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-image: none !important;
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
					!empty($custom_styles_portrait) || 
					$customize_bg_portrait || 
					$hide_bg_portrait 
				){
					$styles .= "
						@media screen and (max-width: 991px){
					";

						if( !empty($custom_styles_portrait) ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									".$vc_portrait_styles."
								}
							";
						}
						if( $customize_bg_portrait ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-attachment: ".$bg_attachment_portrait." !important;
									background-repeat: ".$bg_repeat_portrait." !important;
								}
							";
							if( $bg_size_portrait == 'custom' && !empty($custom_bg_size_portrait) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$custom_bg_size_portrait." !important;
									}
								";
							} else if( $bg_size_portrait == 'custom' && empty($custom_bg_size_portrait) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$bg_size_portrait." !important;
									}
								";
							}
							if( $bg_position_portrait == 'custom' && !empty($custom_bg_position_portrait) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$custom_bg_position_portrait." !important;
									}
								";
							} else if( $bg_position_portrait == 'custom' && empty($custom_bg_position_portrait) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$bg_position_portrait." !important;
									}
								";
							}
						}
						if( $hide_bg_portrait ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-image: none !important;
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
					!empty($custom_styles_mobile) || 
					$customize_bg_mobile || 
					$hide_bg_mobile || 
					$place_ahead 
				){
					$styles .= "
						@media screen and (max-width: 767px){
					";

						if( !empty($custom_styles_mobile) ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									".$vc_mobile_styles."
								}
							";
						}
						if( $customize_bg_mobile ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-attachment: ".$bg_attachment_mobile." !important;
									background-repeat: ".$bg_repeat_mobile." !important;
								}
							";
							if( $bg_size_mobile == 'custom' && !empty($custom_bg_size_mobile) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$custom_bg_size_mobile." !important;
									}
								";
							} else if( $bg_size_mobile == 'custom' && empty($custom_bg_size_mobile) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$bg_size_mobile." !important;
									}
								";
							}
							if( $bg_position_mobile == 'custom' && !empty($custom_bg_position_mobile) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$custom_bg_position_mobile." !important;
									}
								";
							} else if( $bg_position_mobile == 'custom' && empty($custom_bg_position_mobile) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$bg_position_mobile." !important;
									}
								";
							}
						}
						if( $hide_bg_mobile ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-image: none !important;
								}
							";
						}
						if( $place_ahead ){
							$styles .= "
								#".$id."{
									-ms-flex-order: -1;
									 -webkit-order: -1;
											 order: -1;
								}
							";
						}

					$styles .= "
						}
					";
				}
				/* -----> End of mobile styles <----- */

				/*-----> Get VC_ROW properties <-----*/
				$sc_obj = Vc_Shortcodes_Manager::getInstance()->getElementClass('vc_column');
				$atts = vc_map_get_attributes( $sc_obj->getShortcode(), $atts );
				extract( $atts );

				$width = wpb_translateColumnWidthToSpan( $width );
				$width = vc_column_offset_class_merge( $offset, $width );

				$animation_classes = '';
				$animation_classes .= $animation_load != 'none' ? $animation_load.' animated' : '';

				/* -----> Custom VC_COLUMN output <----- */
				$out .= '<div class="row_hover_effect"></div>';

				$out .= "<div id='".$id."' class='rb_column_wrapper ".$width." ".$animation_classes."'>";

				rb__vc_styles($styles);

				return $out;
			}
			public static function rb_close_vc_shortcode_column($atts, $content){	
				$out = "</div>";
				return $out;
			}
			/*\ -----> End Customize VC_COLUMN <-----\*/


			/* -----> Start Customize VC_ROW_INNER <-----*/
			public static function rb_open_vc_shortcode_row_inner($atts, $content){
				extract( shortcode_atts( array(
					/* From rb_vc_extends.php -> rb_structure_background_props() */
					//Desktop
					"bg_position"					=> "center",
					"bg_size"						=> "cover",
					"bg_repeat"						=> "no-repeat",
					"bg_attachment"					=> "scroll",
					"custom_bg_position"			=> "",
					"custom_bg_size"				=> "",
					"add_shadow"					=> false,
					//Landscape
					"custom_styles_landscape" 		=> "",
					"customize_bg_landscape"		=> false,
					"bg_position_landscape"			=> "center",
					"bg_size_landscape"				=> "cover",
					"bg_repeat_landscape"			=> "no-repeat",
					"bg_attachment_landscape"		=> "scroll",
					"custom_bg_position_landscape"	=> "",
					"custom_bg_size_landscape"		=> "",
					"hide_bg_landscape" 			=> false,
					//Portrait
					"custom_styles_portrait" 		=> "",
					"customize_bg_portrait"			=> false,
					"bg_position_portrait"			=> "center",
					"bg_size_portrait"				=> "cover",
					"bg_repeat_portrait"			=> "no-repeat",
					"bg_attachment_portrait"		=> "scroll",
					"custom_bg_position_portrait"	=> "",
					"custom_bg_size_portrait"		=> "",
					"hide_bg_portrait" 				=> false,
					//Mobile
					"custom_styles_mobile" 			=> "",
					"customize_bg_mobile"			=> false,
					"bg_position_mobile"			=> "center",
					"bg_size_mobile"				=> "cover",
					"bg_repeat_mobile"				=> "no-repeat",
					"bg_attachment_mobile"			=> "scroll",
					"custom_bg_position_mobile"		=> "",
					"custom_bg_size_mobile"			=> "",
					"hide_bg_mobile" 				=> false,
					/*\ From rb_structure_background_props \*/
				), $atts ) );

				/* -----> Variables declaration <----- */
				$out = $styles = "";
				$id = uniqid( "rb_inner_row_" );

				/* -----> Visual Composer Responsive styles <----- */
				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_landscape, $vc_landscape_styles); 
				$vc_landscape_styles = implode($vc_landscape_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_portrait, $vc_portrait_styles); 
				$vc_portrait_styles = implode($vc_portrait_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_mobile, $vc_mobile_styles); 
				$vc_mobile_styles = implode($vc_mobile_styles);

				/* -----> Customize default styles <----- */
				$styles .= "
					#".$id." > .vc_row{
						background-attachment: ".$bg_attachment." !important;
						background-repeat: ".$bg_repeat." !important;
					}
				";
				if( $bg_size == 'custom' && !empty($custom_bg_size) ){
					$styles .= "
						#".$id." > .vc_row{
							background-size: ".$custom_bg_size." !important;
						}
					";
				} else if( $bg_size == 'custom' && empty($custom_bg_size) ) {
					$styles .= "
						#".$id." > .vc_row{
							background-size: cover !important;
						}
					";
				} else {
					$styles .= "
						#".$id." > .vc_row{
							background-size: ".$bg_size." !important;
						}
					";
				}
				if( $bg_position == 'custom' && !empty($custom_bg_position) ){
					$styles .= "
						#".$id." > .vc_row{
							background-position: ".$custom_bg_position." !important;
						}
					";
				} else if( $bg_position == 'custom' && empty($custom_bg_position) ) {
					$styles .= "
						#".$id." > .vc_row{
							background-position: center center !important;
						}
					";
				} else {
					$styles .= "
						#".$id." > .vc_row{
							background-position: ".$bg_position." !important;
						}
					";
				}
				/* -----> End of default styles <----- */

				/* -----> Customize landscape styles <----- */
				if(
					!empty($custom_styles_landscape) || 
					$customize_bg_landscape || 
					$hide_bg_landscape 
				){
					$styles .= "
						@media screen and (max-width: 1199px){
					";

						if( !empty($custom_styles_landscape) ){
							$styles .= "
								#".$id." > .vc_row{
									".$vc_landscape_styles."
								}
							";
						}
						if( $customize_bg_landscape ){
							$styles .= "
								#".$id." > .vc_row{
									background-attachment: ".$bg_attachment_landscape." !important;
									background-repeat: ".$bg_repeat_landscape." !important;
								}
							";
							if( $bg_size_landscape == 'custom' && !empty($custom_bg_size_landscape) ){
								$styles .= "
									#".$id." > .vc_row{
										background-size: ".$custom_bg_size_landscape." !important;
									}
								";
							} else if( $bg_size_landscape == 'custom' && empty($custom_bg_size_landscape) ) {
								$styles .= "
									#".$id." > .vc_row{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .vc_row{
										background-size: ".$bg_size_landscape." !important;
									}
								";
							}
							if( $bg_position_landscape == 'custom' && !empty($custom_bg_position_landscape) ){
								$styles .= "
									#".$id." > .vc_row{
										background-position: ".$custom_bg_position_landscape." !important;
									}
								";
							} else if( $bg_position_landscape == 'custom' && empty($custom_bg_position_landscape) ) {
								$styles .= "
									#".$id." > .vc_row{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .vc_row{
										background-position: ".$bg_position_landscape." !important;
									}
								";
							}
						}
						if( $hide_bg_landscape ){
							$styles .= "
								#".$id." > .vc_row{
									background-image: none !important;
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
					!empty($custom_styles_portrait) || 
					$customize_bg_portrait || 
					$hide_bg_portrait 
				){
					$styles .= "
						@media screen and (max-width: 991px){
					";

						if( !empty($custom_styles_portrait) ){
							$styles .= "
								#".$id." > .vc_row{
									".$vc_portrait_styles."
								}
							";
						}
						if( $customize_bg_portrait ){
							$styles .= "
								#".$id." > .vc_row{
									background-attachment: ".$bg_attachment_portrait." !important;
									background-repeat: ".$bg_repeat_portrait." !important;
								}
							";
							if( $bg_size_portrait == 'custom' && !empty($custom_bg_size_portrait) ){
								$styles .= "
									#".$id." > .vc_row{
										background-size: ".$custom_bg_size_portrait." !important;
									}
								";
							} else if( $bg_size_portrait == 'custom' && empty($custom_bg_size_portrait) ) {
								$styles .= "
									#".$id." > .vc_row{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .vc_row{
										background-size: ".$bg_size_portrait." !important;
									}
								";
							}
							if( $bg_position_portrait == 'custom' && !empty($custom_bg_position_portrait) ){
								$styles .= "
									#".$id." > .vc_row{
										background-position: ".$custom_bg_position_portrait." !important;
									}
								";
							} else if( $bg_position_portrait == 'custom' && empty($custom_bg_position_portrait) ) {
								$styles .= "
									#".$id." > .vc_row{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .vc_row{
										background-position: ".$bg_position_portrait." !important;
									}
								";
							}
						}
						if( $hide_bg_portrait ){
							$styles .= "
								#".$id." > .vc_row{
									background-image: none !important;
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
					!empty($custom_styles_mobile) || 
					$customize_bg_mobile || 
					$hide_bg_mobile 
				){
					$styles .= "
						@media screen and (max-width: 767px){
					";

						if( !empty($custom_styles_mobile) ){
							$styles .= "
								#".$id." > .vc_row{
									".$vc_mobile_styles."
								}
							";
						}
						if( $customize_bg_mobile ){
							$styles .= "
								#".$id." > .vc_row{
									background-attachment: ".$bg_attachment_mobile." !important;
									background-repeat: ".$bg_repeat_mobile." !important;
								}
							";
							if( $bg_size_mobile == 'custom' && !empty($custom_bg_size_mobile) ){
								$styles .= "
									#".$id." > .vc_row{
										background-size: ".$custom_bg_size_mobile." !important;
									}
								";
							} else if( $bg_size_mobile == 'custom' && empty($custom_bg_size_mobile) ) {
								$styles .= "
									#".$id." > .vc_row{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .vc_row{
										background-size: ".$bg_size_mobile." !important;
									}
								";
							}
							if( $bg_position_mobile == 'custom' && !empty($custom_bg_position_mobile) ){
								$styles .= "
									#".$id." > .vc_row{
										background-position: ".$custom_bg_position_mobile." !important;
									}
								";
							} else if( $bg_position_mobile == 'custom' && empty($custom_bg_position_mobile) ) {
								$styles .= "
									#".$id." > .vc_row{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .vc_row{
										background-position: ".$bg_position_mobile." !important;
									}
								";
							}
						}
						if( $hide_bg_mobile ){
							$styles .= "
								#".$id." > .vc_row{
									background-image: none !important;
								}
							";
						}

					$styles .= "
						}
					";
				}
				/* -----> End of mobile styles <----- */

				/* -----> Custom VC_ROW_INNER output <----- */
				$out = "<div id='".$id."' class='rb_inner_row_wrapper".($add_shadow ? ' shadow' : '')."'>";

				rb__vc_styles($styles);

				return $out;
			}
			public static function rb_close_vc_shortcode_row_inner($atts, $content){
				$out = "</div>";
				return $out;
			}
			/* -----> End Customize VC_ROW_INNER <-----*/


			/* -----> Start Customize VC_COLUMN_INNER <-----*/
			public static function rb_open_vc_shortcode_column_inner($atts, $content){
				extract( shortcode_atts( array(
					/* From rb_vc_extends.php -> rb_structure_background_props() */
					//Desktop
					"bg_position"					=> "center",
					"bg_size"						=> "cover",
					"bg_repeat"						=> "no-repeat",
					"bg_attachment"					=> "scroll",
					"custom_bg_position"			=> "",
					"custom_bg_size"				=> "",
					//Landscape
					"custom_styles_landscape" 		=> "",
					"customize_bg_landscape"		=> false,
					"bg_position_landscape"			=> "center",
					"bg_size_landscape"				=> "cover",
					"bg_repeat_landscape"			=> "no-repeat",
					"bg_attachment_landscape"		=> "scroll",
					"custom_bg_position_landscape"	=> "",
					"custom_bg_size_landscape"		=> "",
					"hide_bg_landscape" 			=> false,
					//Portrait
					"custom_styles_portrait" 		=> "",
					"customize_bg_portrait"			=> false,
					"bg_position_portrait"			=> "center",
					"bg_size_portrait"				=> "cover",
					"bg_repeat_portrait"			=> "no-repeat",
					"bg_attachment_portrait"		=> "scroll",
					"custom_bg_position_portrait"	=> "",
					"custom_bg_size_portrait"		=> "",
					"hide_bg_portrait" 				=> false,
					//Mobile
					"custom_styles_mobile" 			=> "",
					"customize_bg_mobile"			=> false,
					"bg_position_mobile"			=> "center",
					"bg_size_mobile"				=> "cover",
					"bg_repeat_mobile"				=> "no-repeat",
					"bg_attachment_mobile"			=> "scroll",
					"custom_bg_position_mobile"		=> "",
					"custom_bg_size_mobile"			=> "",
					"hide_bg_mobile" 				=> false,
					/*\ From rb_structure_background_props \*/
					"animation_load"				=> "none",
					"animation_duration"			=> "1000",
					"animation_delay"				=> "0",
					"timing_function"				=> "ease",
					"custom_timing_function"		=> "",
					"place_ahead"					=> false,
				), $atts ) );

				/* -----> Variables declaration <----- */
				$out = $styles = $offset = $width = "";
				$id = uniqid( "rb_column_" );

				/* -----> Visual Composer Responsive styles <----- */
				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_landscape, $vc_landscape_styles); 
				$vc_landscape_styles = implode($vc_landscape_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_portrait, $vc_portrait_styles); 
				$vc_portrait_styles = implode($vc_portrait_styles);

				preg_match("/(?<=\{).+?(?=\})/", $custom_styles_mobile, $vc_mobile_styles); 
				$vc_mobile_styles = implode($vc_mobile_styles);

				/* -----> Customize default styles <----- */
				$styles .= "
					#".$id." > .wpb_column > .vc_column-inner{
						background-attachment: ".$bg_attachment." !important;
						background-repeat: ".$bg_repeat." !important;
					}
				";
				if( $bg_size == 'custom' && !empty($custom_bg_size) ){
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-size: ".$custom_bg_size." !important;
						}
					";
				} else if( $bg_size == 'custom' && empty($custom_bg_size) ) {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-size: cover !important;
						}
					";
				} else {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-size: ".$bg_size." !important;
						}
					";
				}
				if( $bg_position == 'custom' && !empty($custom_bg_position) ){
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-position: ".$custom_bg_position." !important;
						}
					";
				} else if( $bg_position == 'custom' && empty($custom_bg_position) ) {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-position: center center !important;
						}
					";
				} else {
					$styles .= "
						#".$id." > .wpb_column > .vc_column-inner{
							background-position: ".$bg_position." !important;
						}
					";
				}
				if( $animation_load != 'none' ){
					if( !empty($animation_duration) ){
						$styles .= "
							#".$id."{
								transition-duration: ".(int)$animation_duration."ms;
							}
						";
					}
					if( !empty($animation_delay) ){
						$styles .= "
							#".$id."{
								transition-delay: ".(int)$animation_delay."ms;
							}
						";
					}
					if( !empty($timing_function) ){
						$styles .= "
							#".$id."{
								transition-timing-function: ".($timing_function != 'custom' ? $timing_function : $custom_timing_function ).";
							}
						";
					}
				}
				/* -----> End of default styles <----- */

				/* -----> Customize landscape styles <----- */
				if(
					!empty($custom_styles_landscape) || 
					$customize_bg_landscape || 
					$hide_bg_landscape 
				){
					$styles .= "
						@media screen and (max-width: 1199px){
					";

						if( !empty($custom_styles_landscape) ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									".$vc_landscape_styles."
								}
							";
						}
						if( $customize_bg_landscape ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-attachment: ".$bg_attachment_landscape." !important;
									background-repeat: ".$bg_repeat_landscape." !important;
								}
							";
							if( $bg_size_landscape == 'custom' && !empty($custom_bg_size_landscape) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$custom_bg_size_landscape." !important;
									}
								";
							} else if( $bg_size_landscape == 'custom' && empty($custom_bg_size_landscape) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$bg_size_landscape." !important;
									}
								";
							}
							if( $bg_position_landscape == 'custom' && !empty($custom_bg_position_landscape) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$custom_bg_position_landscape." !important;
									}
								";
							} else if( $bg_position_landscape == 'custom' && empty($custom_bg_position_landscape) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$bg_position_landscape." !important;
									}
								";
							}
						}
						if( $hide_bg_landscape ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-image: none !important;
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
					!empty($custom_styles_portrait) || 
					$customize_bg_portrait || 
					$hide_bg_portrait 
				){
					$styles .= "
						@media screen and (max-width: 991px){
					";

						if( !empty($custom_styles_portrait) ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									".$vc_portrait_styles."
								}
							";
						}
						if( $customize_bg_portrait ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-attachment: ".$bg_attachment_portrait." !important;
									background-repeat: ".$bg_repeat_portrait." !important;
								}
							";
							if( $bg_size_portrait == 'custom' && !empty($custom_bg_size_portrait) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$custom_bg_size_portrait." !important;
									}
								";
							} else if( $bg_size_portrait == 'custom' && empty($custom_bg_size_portrait) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$bg_size_portrait." !important;
									}
								";
							}
							if( $bg_position_portrait == 'custom' && !empty($custom_bg_position_portrait) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$custom_bg_position_portrait." !important;
									}
								";
							} else if( $bg_position_portrait == 'custom' && empty($custom_bg_position_portrait) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$bg_position_portrait." !important;
									}
								";
							}
						}
						if( $hide_bg_portrait ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-image: none !important;
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
					!empty($custom_styles_mobile) || 
					$customize_bg_mobile || 
					$hide_bg_mobile || 
					$place_ahead 
				){
					$styles .= "
						@media screen and (max-width: 767px){
					";

						if( !empty($custom_styles_mobile) ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									".$vc_mobile_styles."
								}
							";
						}
						if( $customize_bg_mobile ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-attachment: ".$bg_attachment_mobile." !important;
									background-repeat: ".$bg_repeat_mobile." !important;
								}
							";
							if( $bg_size_mobile == 'custom' && !empty($custom_bg_size_mobile) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$custom_bg_size_mobile." !important;
									}
								";
							} else if( $bg_size_mobile == 'custom' && empty($custom_bg_size_mobile) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: cover !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-size: ".$bg_size_mobile." !important;
									}
								";
							}
							if( $bg_position_mobile == 'custom' && !empty($custom_bg_position_mobile) ){
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$custom_bg_position_mobile." !important;
									}
								";
							} else if( $bg_position_mobile == 'custom' && empty($custom_bg_position_mobile) ) {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: center center !important;
									}
								";
							} else {
								$styles .= "
									#".$id." > .wpb_column > .vc_column-inner{
										background-position: ".$bg_position_mobile." !important;
									}
								";
							}
						}
						if( $hide_bg_mobile ){
							$styles .= "
								#".$id." > .wpb_column > .vc_column-inner{
									background-image: none !important;
								}
							";
						}
						if( $place_ahead ){
							$styles .= "
								#".$id."{
									-ms-flex-order: -1;
									 -webkit-order: -1;
											 order: -1;
								}
							";
						}

					$styles .= "
						}
					";
				}
				/* -----> End of mobile styles <----- */

				/*-----> Get VC_ROW properties <-----*/
				$sc_obj = Vc_Shortcodes_Manager::getInstance()->getElementClass('vc_column');
				$atts = vc_map_get_attributes( $sc_obj->getShortcode(), $atts );
				extract( $atts );

				$width = wpb_translateColumnWidthToSpan( $width );
				$width = vc_column_offset_class_merge( $offset, $width );

				$animation_classes = '';
				$animation_classes .= $animation_load != 'none' ? $animation_load.' animated' : '';

				/* -----> Custom VC_COLUMN output <----- */
				$out .= "<div id='".$id."' class='rb_column_wrapper ".$width." ".$animation_classes."'>";

				rb__vc_styles($styles);

				return $out;
			}
			public static function rb_close_vc_shortcode_column_inner($atts, $content){
				$out = "</div>";
				return $out;
			}
			/* -----> End Customize VC_COLUMN_INNER <-----*/


			function rb_extra_vc_params(){
				/* -----> STYLING GROUP TITLES <----- */
				$group_name = esc_html__('Design Options', 'setech');
				$landscape_group = esc_html__('Tablet', 'setech')."&nbsp;&nbsp;&nbsp;<i class='vc-composer-icon vc-c-icon-layout_landscape-tablets'></i>";
				$portrait_group = esc_html__('Tablet', 'setech')."&nbsp;&nbsp;&nbsp;<i class='vc-composer-icon vc-c-icon-layout_portrait-tablets'></i>";
				$mobile_group = esc_html__('Mobile', 'setech')."&nbsp;&nbsp;&nbsp;<i class='vc-composer-icon vc-c-icon-layout_portrait-smartphones'></i>";

				if( function_exists('vc_add_param') ){
					/*-----> Extra VC_Row Params <-----*/
					rb_structure_background_props('vc_row');
					//VC_Row Overlay Properties
					vc_add_param(
						'vc_row',
						array(
							"type" 			=> "dropdown",
							"heading" 		=> esc_html__("Overlay", 'setech'),
							"param_name"	=> "bg_rb_color",
							"group" 		=> $group_name,
							"value" 		=> array(
								esc_html__("None", 'setech') => "none",
								esc_html__("Color", 'setech') => "color",
								esc_html__("Gradient", 'setech') => "gradient",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 			=> "colorpicker",
							"heading"		=> esc_html__( 'Color', 'setech' ),
							"param_name" 	=> "rb_overlay_color",
							"group" 		=> $group_name,
							"dependency"	=> array(
								"element"	=> "bg_rb_color",
								"value" 	=> "color",
							),
							"value"			=> PRIMARY_COLOR
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "colorpicker",
							"heading"			=> esc_html__( 'From', 'setech' ),
							"param_name" 		=> "rb_gradient_color_from",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "bg_rb_color",
								'value' 	=> 'gradient',
							),
							"value"				=> "#000"
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "colorpicker",
							"heading"			=> esc_html__( 'To', 'setech' ),
							"param_name" 		=> "rb_gradient_color_to",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "bg_rb_color",
								'value' 	=> 'gradient',
							),
							"value"			=> "#fff"
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"				=> "textfield",
							"heading"			=> esc_html__( 'Opacity', 'setech' ),
							"param_name"		=> "rb_gradient_opacity",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-4",
							"description"		=> esc_html__( '100 - visible, 0 - invisible', 'setech' ),
							"dependency"		=> array(
								"element"	=> "bg_rb_color",
								'value' 	=> 'gradient',						
							),
							"value" 			=> '50',
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Type", 'setech'),
							"param_name"		=> "rb_gradient_type",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"dependency"		=> array(
								"element"	=> "bg_rb_color",
								'value' 	=> 'gradient',
							),
							"value" 			=> array(
								esc_html__("Linear", 'setech') => "linear",
								esc_html__("Radial", 'setech') => "radial",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"				=> "textfield",
							"heading"			=> esc_html__( 'Angle', 'setech' ),
							"param_name"		=> "rb_gradient_angle",
							"value" 			=> '45',
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"description"		=> esc_html__( 'Degrees: -360 to 360', 'setech' ),
							"dependency"		=> array(
								"element"	=> "rb_gradient_type",
								'value' 	=> 'linear',						
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Shape variant", 'setech'),
							"param_name"		=> "rb_gradient_shape_variant_type",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"dependency"		=> array(
								"element"	=> "rb_gradient_type",
								'value' 	=> 'radial',	
							),
							"value" 			=> array(
								esc_html__("Simple", 'setech') => "simple",
								esc_html__("Extended", 'setech') => "extended",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Shape", 'setech'),
							"param_name"		=> "rb_gradient_shape_type",
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "rb_gradient_shape_variant_type",
								'value' 	=> 'simple',	
							),
							"value" 			=> array(
								esc_html__("Ellipse", 'setech') => "ellipse",
								esc_html__("Circle", 'setech') => "circle",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading"			=> esc_html__("Size keyword", 'setech'),
							"param_name"		=> "rb_gradient_size_keyword_type",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"dependency"	=> array(
								"element"	=> "rb_gradient_shape_variant_type",
								'value' => 'extended',	
							),
							"value" => array(
								esc_html__("Closest side", 'setech') => "closest-side",
								esc_html__("Farthest side", 'setech') => "farthest-side",
								esc_html__("Closest corner", 'setech') => "closest-corner",
								esc_html__("Farthest corner", 'setech') => "farthest-corner",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Size", 'setech'),
							"param_name"		=> "rb_gradient_size_type",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"description"		=> esc_html__( 'Two space separated percent values, for example (60% 55%)', 'setech' ),
							"dependency"		=> array(
								"element"	=> "rb_gradient_shape_variant_type",
								'value' 	=> 'extended',	
							),
							"value" 			=> '60% 55%',
						)
					);

					//VC_Row Extra Layer Properties
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "checkbox",
							"param_name"		=> "add_layers",
							"group" 			=> $group_name,						
							"value"				=> array( esc_html__( 'Add Layer', 'setech' ) => true )
						)
					);					
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "attach_image",
							"heading" 			=> esc_html__("Layer", 'setech'),
							"param_name"		=> "rb_layer_image",
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							'type' 				=> 'dropdown',
							'heading' 			=> esc_html__( 'Layer position', 'setech' ),
							'param_name' 		=> 'extra_layer_pos',
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							'dependency' 		=> array(
								'element' 	=> 'add_layers',
								'not_empty' => true,
							),
							'value' 			=> array(
								__( 'Left', 'setech' ) => 'left',
								__( 'Right', 'setech' ) => 'right',
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							'type' 				=> 'textfield',
							'heading' 			=> __( 'Layer width', 'setech' ),
							'param_name' 		=> 'extra_layer_width',
							"group" 			=> $group_name,
							'description' 		=> __( 'In percents', 'setech' ),
							"edit_field_class" 	=> "vc_col-xs-6",
							'dependency' 		=> array(
								'element' 	=> 'add_layers',
								'not_empty' => true,
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Layer Image Size", 'setech'),
							"param_name" 		=> "extra_layer_size",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value" => array(
								esc_html__("Initial", 'setech') => "initial",
								esc_html__("Cover", 'setech') => "cover",
								esc_html__("Contain", 'setech') => "contain",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Layer Image Position", 'setech'),
							"param_name" 		=> "extra_layer_position",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value" 			=> array(
								esc_html__("Left Top", 'setech') => "left top",
								esc_html__("Left Center", 'setech') => "left center",
								esc_html__("Left Bottom", 'setech') => "left bottom",
								esc_html__("Right Top", 'setech') => "right top",
								esc_html__("Right Center", 'setech') => "right center",
								esc_html__("Right Bottom", 'setech') => "right bottom",
								esc_html__("Center Top", 'setech') => "center top",
								esc_html__("Center Center", 'setech') => "center center",
								esc_html__("Center Bottom", 'setech') => "center bottom",
							),	
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Layer Image Position", 'setech'),
							"param_name" 		=> "extra_layer_repeat",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value" 			=> array(
								esc_html__("No Repeat", 'setech') => "no-repeat",
								esc_html__("Repeat", 'setech') => "repeat",
								esc_html__("Repeat X", 'setech') => "repeat-x",
								esc_html__("Repeat Y", 'setech') => "repeat-y",
							),	
						)
					);			
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "colorpicker",
							"heading" 			=> esc_html__("Layer Background Color", 'setech'),
							"param_name" 		=> "extra_layer_bg",
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value"				=> '',
						)
					);		
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Layer Margin", 'setech'),
							"param_name" 		=> "extra_layer_margin",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"description"		=> esc_html__( '1, 2( top/bottom, left/right ) or 4, space separated, values with units', 'setech' ),
							"dependency"		=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value" => "0px 0px",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Layer Opacity", 'setech'),
							"param_name" 		=> "extra_layer_opacity",
							"group" 			=> $group_name,
							"edit_field_class" 	=> "vc_col-xs-6",
							"description"		=> esc_html__( '100 = Visible, 0 = Transparent', 'setech' ),
							"dependency"		=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value" => "100",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"			=> "checkbox",
							"param_name"	=> "hide_layer_landscape",
							"group"			=> $landscape_group,
							"dependency"	=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value"			=> array( esc_html__( 'Hide Layer', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"			=> "checkbox",
							"param_name"	=> "hide_layer_portrait",
							"group"			=> $portrait_group,
							"dependency"	=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value"			=> array( esc_html__( 'Hide Layer', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"			=> "checkbox",
							"param_name"	=> "hide_layer_mobile",
							"group"			=> $mobile_group,
							"dependency"	=> array(
								"element"	=> "add_layers",
								"not_empty"	=> true
							),
							"value"			=> array( esc_html__( 'Hide Layer', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "checkbox",
							"param_name" 		=> "add_shadow",
							"group" 			=> $group_name,
							"value" 			=> array( esc_html__( 'Add Shadow', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "colorpicker",
							"heading" 			=> esc_html__("Shadow Color", 'setech'),
							"param_name" 		=> "shadow_color",
							"dependency"		=> array(
								"element"	=> "add_shadow",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "rgba(0,0,0, .15)",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"			=> "checkbox",
							"param_name"	=> "particles",
							"group" 		=> $group_name,
							"value"			=> array( esc_html__( 'Add particles', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Area Width (with unit)", 'setech'),
							"param_name" 		=> "particles_width",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "300px",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Area Height (with unit)", 'setech'),
							"param_name" 		=> "particles_height",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "300px",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Hide Particles on Choosen Resolution", 'setech'),
							"param_name" 		=> "particles_hide",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "767",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Particles Left Offset (with unit)", 'setech'),
							"param_name" 		=> "particles_left",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Particles Top Offset (with unit)", 'setech'),
							"param_name" 		=> "particles_top",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Particles Start Pos", 'setech'),
							"param_name" 		=> "particles_start",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> array(
								esc_html__("Top Left", 'setech') => "top_left",
								esc_html__("Top Center", 'setech') => "top_center",
								esc_html__("Top Right", 'setech') => "top_right",
								esc_html__("Right Center", 'setech') => "right_center",
								esc_html__("Bottom Right", 'setech') => "bottom_right",
								esc_html__("Bottom Center", 'setech') => "bottom_center",
								esc_html__("Bottom Left", 'setech') => "bottom_left",
								esc_html__("Left Center", 'setech') => "left_center",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Particles Speed (0 to 10)", 'setech'),
							"param_name" 		=> "particles_speed",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "2",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Particles Size (1 to 50)", 'setech'),
							"param_name" 		=> "particles_size",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "10",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Particles Count (1 to 500)", 'setech'),
							"param_name" 		=> "particles_count",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> "25",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Particles Shape", 'setech'),
							"param_name" 		=> "particles_shape",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> array(
								esc_html__("Circle", 'setech') 	=> "circle",
								esc_html__("Square", 'setech') 	=> "edge",
								esc_html__("Hexagon", 'setech') 	=> "polygon",
								esc_html__("Image", 'setech') 	=> "image",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"				=> "attach_image",
							"heading"			=> esc_html__( 'Image', 'setech' ),
							"param_name"		=> "particles_image",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "particles_shape",
								"value"		=> "image"
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Particles Mode", 'setech'),
							"param_name" 		=> "particles_mode",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> array(
								esc_html__("Out", 'setech') 		=> "out",
								esc_html__("Bounce", 'setech') 	=> "bounce",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "checkbox",
							"param_name" 		=> "particles_linked",
							"dependency"	=> array(
								"element"	=> "particles",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> array( esc_html__( 'Particles Linked', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "colorpicker",
							"heading" 			=> esc_html__("Particles Color (#HEX Only!)", 'setech'),
							"param_name" 		=> "particles_color",
							"dependency"		=> array(
								"element"	=> "particles_shape",
								"value"		=> array( "circle", "edge", "polygon" )
							),
							"group" 			=> $group_name,
							"value" 			=> PRIMARY_COLOR,
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"				=> "checkbox",
							"param_name"		=> "add_mask",
							"group" 			=> $group_name,
							"description"		=> esc_html__( 'Mask usage is not recommended when particles or layers enabled.', 'setech' ),
							"value"				=> array( esc_html__( 'Add SVG Mask', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"				=> "attach_image",
							"heading"			=> esc_html__( 'Image', 'setech' ),
							"param_name"		=> "mask_image",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "add_mask",
								"not_empty"	=> true
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Mask Start Pos", 'setech'),
							"param_name" 		=> "mask_start",
							"edit_field_class" 	=> "vc_col-xs-4",
							"dependency"		=> array(
								"element"	=> "add_mask",
								"not_empty"	=> true
							),
							"group" 			=> $group_name,
							"value" 			=> array(
								esc_html__("Top Left", 'setech') 		=> "top_left",
								esc_html__("Top Center", 'setech') 		=> "top_center",
								esc_html__("Top Right", 'setech') 		=> "top_right",
								esc_html__("Right Center", 'setech') 	=> "right_center",
								esc_html__("Bottom Right", 'setech') 	=> "bottom_right",
								esc_html__("Bottom Center", 'setech')	=> "bottom_center",
								esc_html__("Bottom Left", 'setech') 		=> "bottom_left",
								esc_html__("Left Center", 'setech') 		=> "left_center",
							),
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type"				=> "checkbox",
							"param_name"		=> "overflow_hidden",
							"group" 			=> $group_name,
							"value"				=> array( esc_html__( 'Overflow hidden', 'setech' ) => true )
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Row Z-Index", 'setech'),
							"param_name" 		=> "z_index",
							"edit_field_class" 	=> "vc_col-xs-6",
							"group" 			=> $group_name,
							"value" 			=> "",
						)
					);
					vc_add_param(
						'vc_row',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Row Bottom Shift", 'setech'),
							"param_name" 		=> "shift",
							"edit_field_class" 	=> "vc_col-xs-6",
							"group" 			=> $group_name,
							"value" 			=> "",
						)
					);

					/*-----> Extra VC_Column Params <-----*/
					rb_structure_background_props('vc_column');
					vc_add_param(
						'vc_column',
						array(
							"type" 			=> "colorpicker",
							"heading"		=> esc_html__( 'Shadow Color', 'setech' ),
							"param_name" 	=> "column_shadow_color",
							"group" 		=> $group_name,
							"value"			=> ""
						)
					);
					vc_add_param(
						'vc_column',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Animate on load", 'setech'),
							"param_name"		=> "animation_load",
							"group" 			=> $group_name,
							"value" 			=> array(
								esc_html__("None", 'setech') 				=> "none",
								esc_html__("Fade From Left", 'setech') 		=> "fade_left",
								esc_html__("Fade From Right", 'setech') 	=> "fade_right",
								esc_html__("Fade From Bottom", 'setech') 	=> "fade_bottom",
								esc_html__("Slide From Left", 'setech') 	=> "grow_left",
								esc_html__("Slide From Right", 'setech') 	=> "grow_right",
								esc_html__("Slide From Bottom", 'setech') 	=> "grow_bottom",
							),
						)
					);
					vc_add_param(
						'vc_column',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Duration", 'setech'),
							"param_name"		=> "animation_duration",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"description"	=> esc_html__( 'In milliseconds', 'setech' ),
							"dependency"	=> array(
								"element"	=> "animation_load",
								"value" 	=> array( 'fade_left', 'fade_right', 'fade_bottom', 'grow_left', 'grow_right', 'grow_bottom' ),
							),
							"value" 			=> "1000"
						)
					);
					vc_add_param(
						'vc_column',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Delay", 'setech'),
							"param_name"		=> "animation_delay",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"description"	=> esc_html__( 'In milliseconds', 'setech' ),
							"dependency"	=> array(
								"element"	=> "animation_load",
								"value" 	=> array( 'fade_left', 'fade_right', 'fade_bottom', 'grow_left', 'grow_right', 'grow_bottom' ),
							),
							"value" 			=> "0"
						)
					);
					vc_add_param(
						'vc_column',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Timing Function", 'setech'),
							"param_name"		=> "timing_function",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"dependency"	=> array(
								"element"	=> "animation_load",
								"value" 	=> array( 'fade_left', 'fade_right', 'fade_bottom', 'grow_left', 'grow_right', 'grow_bottom' ),
							),
							"value" 			=> array(
								esc_html__("Ease", 'setech') 						=> "ease",
								esc_html__("Preconfigured Cubic-Bezier", 'setech') 	=> "cubic-bezier(.35,.71,.26,.88)",
								esc_html__("Ease in Out", 'setech') 					=> "ease-in-out",
								esc_html__("Linear", 'setech') 						=> "linear",
								esc_html__("Custom", 'setech') 						=> "custom",
							),
						)
					);
					vc_add_param(
						'vc_column',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Custom Timing Function", 'setech'),
							"param_name"		=> "custom_timing_function",
							"group" 			=> $group_name,
							"description"	=> esc_html__( 'Enter transition timing function', 'setech' ),
							"dependency"	=> array(
								"element"	=> "timing_function",
								"value" 	=> array( 'custom' ),
							),
							"value" 			=> ""
						)
					);
					vc_add_param(
						'vc_column',
						array(
							"type" 			=> "checkbox",
							"param_name" 	=> "place_ahead",
							"group" 		=> $mobile_group,
							"description"	=> esc_html__( 'If this column have`t content, use "padding-top" or "padding-bottom" properties for set the column height', 'setech' ),
							"value"			=> array( esc_html__( 'Put this column on first place', 'setech' ) => true )
						)
					);

					/*-----> Extra VC_Inner-Row Params <-----*/
					rb_structure_background_props('vc_row_inner');
					vc_add_param(
						'vc_row_inner',
						array(
							"type" 			=> "checkbox",
							"param_name" 	=> "add_shadow",
							"group" 		=> esc_html__('Design Options', 'setech'),
							"value"			=> array( esc_html__( 'Add Shadow', 'setech' ) => true )
						)
					);

					/*-----> Extra VC_Inner-Column Params <-----*/
					rb_structure_background_props('vc_column_inner');
					vc_add_param(
						'vc_column_inner',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Animate on load", 'setech'),
							"param_name"		=> "animation_load",
							"group" 			=> $group_name,
							"value" 			=> array(
								esc_html__("None", 'setech') 				=> "none",
								esc_html__("Fade From Left", 'setech') 		=> "fade_left",
								esc_html__("Fade From Right", 'setech') 	=> "fade_right",
								esc_html__("Fade From Bottom", 'setech') 	=> "fade_bottom",
								esc_html__("Slide From Left", 'setech') 	=> "grow_left",
								esc_html__("Slide From Right", 'setech') 	=> "grow_right",
								esc_html__("Slide From Bottom", 'setech') 	=> "grow_bottom",
							),
						)
					);
					vc_add_param(
						'vc_column_inner',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Duration", 'setech'),
							"param_name"		=> "animation_duration",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"description"	=> esc_html__( 'In milliseconds', 'setech' ),
							"dependency"	=> array(
								"element"	=> "animation_load",
								"value" 	=> array( 'fade_left', 'fade_right', 'fade_bottom', 'grow_left', 'grow_right', 'grow_bottom' ),
							),
							"value" 			=> "1000"
						)
					);
					vc_add_param(
						'vc_column_inner',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Delay", 'setech'),
							"param_name"		=> "animation_delay",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"description"	=> esc_html__( 'In milliseconds', 'setech' ),
							"dependency"	=> array(
								"element"	=> "animation_load",
								"value" 	=> array( 'fade_left', 'fade_right', 'fade_bottom', 'grow_left', 'grow_right', 'grow_bottom' ),
							),
							"value" 			=> "0"
						)
					);
					vc_add_param(
						'vc_column_inner',
						array(
							"type" 				=> "dropdown",
							"heading" 			=> esc_html__("Timing Function", 'setech'),
							"param_name"		=> "timing_function",
							"edit_field_class" 	=> "vc_col-xs-4",
							"group" 			=> $group_name,
							"dependency"	=> array(
								"element"	=> "animation_load",
								"value" 	=> array( 'fade_left', 'fade_right', 'fade_bottom', 'grow_left', 'grow_right', 'grow_bottom' ),
							),
							"value" 			=> array(
								esc_html__("Ease", 'setech') 						=> "ease",
								esc_html__("Preconfigured Cubic-Bezier", 'setech') 	=> "cubic-bezier(.35,.71,.26,.88)",
								esc_html__("Ease in Out", 'setech') 					=> "ease-in-out",
								esc_html__("Linear", 'setech') 						=> "linear",
								esc_html__("Custom", 'setech') 						=> "custom",
							),
						)
					);
					vc_add_param(
						'vc_column_inner',
						array(
							"type" 				=> "textfield",
							"heading" 			=> esc_html__("Custom Timing Function", 'setech'),
							"param_name"		=> "custom_timing_function",
							"group" 			=> $group_name,
							"description"	=> esc_html__( 'Enter transition timing function', 'setech' ),
							"dependency"	=> array(
								"element"	=> "timing_function",
								"value" 	=> array( 'custom' ),
							),
							"value" 			=> ""
						)
					);
					vc_add_param(
						'vc_column_inner',
						array(
							"type" 			=> "checkbox",
							"param_name" 	=> "place_ahead",
							"group" 		=> $mobile_group,
							"description"	=> esc_html__( 'If this column have`t content, use "padding-top" or "padding-bottom" properties for set the column height', 'setech' ),
							"value"			=> array( esc_html__( 'Put this column on first place', 'setech' ) => true )
						)
					);
				}
			} 
		}
		new VC_RB_Background;
	}

	// VC_ROW hook
	if ( !function_exists( 'vc_theme_before_vc_row' ) ) {
		function vc_theme_before_vc_row($atts, $content = null) {
			$GLOBALS['rb_row_atts'] = $atts;
			return VC_RB_Background::rb_open_vc_shortcode($atts, $content);
		}
	}
	if ( !function_exists( 'vc_theme_after_vc_row' ) ) {
		function vc_theme_after_vc_row($atts, $content = null) {
			unset($GLOBALS['rb_row_atts']);
			return VC_RB_Background::rb_close_vc_shortcode($atts, $content);
		}
	}

	// VC_COLUMN hook
	if ( !function_exists( 'vc_theme_before_vc_column' ) ) {
		function vc_theme_before_vc_column($atts, $content = null) {
			new VC_RB_Background();
			return VC_RB_Background::rb_open_vc_shortcode_column($atts, $content);
		}
	}
	if ( !function_exists( 'vc_theme_after_vc_column' ) ) {
		function vc_theme_after_vc_column($atts, $content = null) {
			new VC_RB_Background();
			return VC_RB_Background::rb_close_vc_shortcode_column($atts, $content);
		}
	}

	// VC_ROW_INNER hook
	if ( !function_exists( 'vc_theme_before_vc_row_inner' ) ){
		function vc_theme_before_vc_row_inner($atts, $content = null) {
			new VC_RB_Background();
			return VC_RB_Background::rb_open_vc_shortcode_row_inner($atts, $content);
		}
	}
	if ( !function_exists( 'vc_theme_after_vc_row_inner' ) ){
		function vc_theme_after_vc_row_inner($atts, $content = null) {
			new VC_RB_Background();
			return VC_RB_Background::rb_close_vc_shortcode_row_inner($atts, $content);
		}
	}

	// VC_COLUMN_INNER hook
	if ( !function_exists( 'vc_theme_before_vc_column_inner' ) ) {
		function vc_theme_before_vc_column_inner($atts, $content = null) {
			new VC_RB_Background();
			return VC_RB_Background::rb_open_vc_shortcode_column_inner($atts, $content);
		}
	}
	if ( !function_exists( 'vc_theme_after_vc_column_inner' ) ) {
		function vc_theme_after_vc_column_inner($atts, $content = null) {
			new VC_RB_Background();
			return VC_RB_Background::rb_close_vc_shortcode_column_inner($atts, $content);
		}
	}
	
?>