<?php
	/* -----> SIDEBARS PROPERTIES <----- */
	$sidebars = get_theme_mod('theme_sidebars');
	$sb_arr = array();

	if( !empty($sidebars) ){
		foreach( $sidebars as $k => $v ){
			$sb_arr[$v] = $k;
		}
	}

	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> 'all'
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_align",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> "all",
			"value"			=> array( esc_html_x( 'Customize Alignment', 'backend', 'setech' ) => true ),
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html_x( 'Alignment', 'backend', 'setech' ),
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"param_name"	=> "alignment",
			"responsive"	=> "all",
			"dependency"		=> array(
				"element"	=> "customize_align",
				"not_empty"	=> true
			),
			"value"			=> array(
				esc_html_x( "Left", 'backend', 'setech' ) => 'left',
				esc_html_x( "Center", 'backend', 'setech' ) => 'center',
				esc_html_x( "Right", 'backend', 'setech' ) => 'right',
			),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_size",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> "all",
			"value"			=> array( esc_html_x( 'Customize Size', 'backend', 'setech' ) => true ),
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Icons Size', 'backend', 'setech' ),
			"param_name"		=> "icons_size",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "14px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Size', 'backend', 'setech' ),
			"param_name"		=> "title_size",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "12px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Spacings', 'backend', 'setech' ),
			"param_name"		=> "spacing",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "20px",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icons Color', 'backend', 'setech' ),
			"param_name"		=> "icons_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#000",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icons Color on Hover', 'backend', 'setech' ),
			"param_name"		=> "icons_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR,
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icons Background', 'backend', 'setech' ),
			"param_name"		=> "icons_bg",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "rgba(255,255,255, .05)",
		),
	);

	/* -----> RESPONSIVE STYLING TABS PROPERTIES <----- */
	$styles_landscape = $styles_portrait = $styles_mobile = $styles;

	$styles_landscape = rb_responsive_styles($styles_landscape, 'landscape', rb_landscape_group_name());
	$styles_portrait = rb_responsive_styles($styles_portrait, 'portrait', rb_tablet_group_name());
	$styles_mobile = rb_responsive_styles($styles_mobile, 'mobile', rb_mobile_group_name());

	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html_x( 'Direction', 'RB_VC_Button', 'setech' ),
				"param_name"	=> "dir",
				"value"			=> array(
					esc_html_x( 'Column', 'RB_VC_Button', 'setech' )	=> 'column',
					esc_html_x( 'Line', 'RB_VC_Button', 'setech' )		=> 'line'
				),
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "icon_bg",
				"value"				=> array( esc_html_x( 'Add Icons Background', 'backend', 'setech' ) => true ),
			),
			array(
                'type' 			=> 'param_group',
                'heading' 		=> esc_html_x( 'Menu List', 'backend', 'setech' ),
                'param_name' 	=> 'values',
                'params' 		=> array(
					array(
						"type"				=> "dropdown",
						"heading"			=> esc_html_x( 'Function', 'backend', 'setech' ),
						"param_name"		=> "function",
						"admin_label"		=> true,
						"value"				=> array(
							esc_html_x( "Custom URL", 'backend', 'setech' ) 		=> 'custom',
							esc_html_x( "Woo Cart", 'backend', 'setech' )		=> 'cart',
							esc_html_x( "WPML", 'backend', 'setech' )			=> 'wpml',
							esc_html_x( "Search", 'backend', 'setech' )			=> 'rb_search',
							esc_html_x( "Custom Sidebar", 'backend', 'setech' )	=> 'sidebar',
						)		
					),
					array(
						"type"				=> "dropdown",
						"heading"			=> esc_html_x( 'Type', 'backend', 'setech' ),
						"param_name"		=> "type",
						"dependency"		=> array(
							"element"	=> "function",
							"value"		=> "custom"
						),
						"value"				=> array(
							esc_html_x( "Simple", 'backend', 'setech' ) 		=> 'simple',
							esc_html_x( "Phone Call", 'backend', 'setech' )	=> 'phone',
							esc_html_x( "Send Mail", 'backend', 'setech' )	=> 'mail',
						)
					),
					array(
						"type"			=> "checkbox",
						"param_name"	=> "larger",
						"value"			=> array( esc_html_x( 'Eye-catching', 'backend', 'setech' ) => true ),
						"dependency"	=> array(
							"element"		=> "function",
							"value"			=> "custom"
						)
					),
					array(
						"type"				=> "textfield",
						"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
						"param_name"		=> "title",
						"edit_field_class" 	=> "vc_col-xs-6",
						"dependency"		=> array(
							"element"	=> "function",
							"value"		=> array("custom", "sidebar", "rb_search")
						),
						"value"				=> ""
					),
					array(
						"type"				=> "textfield",
						"heading"			=> esc_html_x( 'Url', 'backend', 'setech' ),
						"param_name"		=> "url",
						"edit_field_class" 	=> "vc_col-xs-6",
						"dependency"		=> array(
							"element"	=> "function",
							"value"		=> "custom"
						),
						"value"				=> ""
					),
					array(
						"type"				=> "dropdown",
						"heading"			=> esc_html_x( 'Sidebar', 'backend', 'setech' ),
						"param_name"		=> "sidebar",
						"edit_field_class" 	=> "vc_col-xs-6",
						"dependency"		=> array(
							"element"	=> "function",
							"value"		=> "sidebar"
						),
						"value"				=> $sb_arr
					),
					array(
						'type' 			=> 'iconpicker',
						'heading' 		=> __( 'Icon', 'setech' ),
						'param_name' 	=> 'icon_rb_flaticons',
						'value' 		=> '',
						'settings' 		=> array(
							'emptyIcon' 	=> true,
							'type' 			=> 'rb_flaticons',
							'iconsPerPage' => 4000,
						),
						"dependency"	=> array(
							"element"		=> "function",
							"value"			=> array("custom", "sidebar")
						),
						'description' => __( 'Select icon from library.', 'setech' ),
					),
                ),
                "value"			=> "",
            ),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra class name', 'backend', 'setech' ),
				"description"		=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'backend', 'setech' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			),
		),
		/* -----> STYLING TAB <----- */
		$styles,
		/* -----> TABLET LANDSCAPE TAB <----- */
		$styles_landscape,
		/* -----> TABLET PORTRAIT TAB <----- */
		$styles_portrait,
		/* -----> MOBILE TAB <----- */
		$styles_mobile
	));

	/* -----> MODULE DECLARATION <----- */

	vc_map( array(
		"name"				=> esc_html_x( 'RB Icon List', 'backend', 'setech' ),
		"base"				=> "rb_sc_icon_list",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Icon_List extends WPBakeryShortCode {
	    }
	}
?>