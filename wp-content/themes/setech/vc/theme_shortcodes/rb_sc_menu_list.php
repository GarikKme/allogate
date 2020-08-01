<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'RB_VC_Menu_List', 'setech' ),
			"responsive"	=> 'all'
		)
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
                'type' 			=> 'param_group',
                'heading' 		=> esc_html_x( 'Menu List', 'RB_VC_Menu_List', 'setech' ),
                'param_name' 	=> 'values',
                'params' 		=> array(
					array(
						"type"				=> "textfield",
						"admin_label"		=> true,
						"heading"			=> esc_html_x( 'Title', 'RB_VC_Menu_List', 'setech' ),
						"param_name"		=> "title",
						"dependency"		=> array(
							"element"	=> "product",
							"value"		=> "custom"
						),
						"value"				=> ""
					),
					array(
						"type"				=> "textfield",
						"heading"			=> esc_html_x( 'Url', 'RB_VC_Menu_List', 'setech' ),
						"param_name"		=> "url",
						"edit_field_class" 	=> "vc_col-xs-6",
						"dependency"		=> array(
							"element"	=> "product",
							"value"		=> "custom"
						),
						"value"				=> ""
					),
					array(
						"type"				=> "textfield",
						"heading"			=> esc_html_x( 'Tag', 'RB_VC_Menu_List', 'setech' ),
						"param_name"		=> "tag",
						"edit_field_class" 	=> "vc_col-xs-6",
						"dependency"		=> array(
							"element"	=> "product",
							"value"		=> "custom"
						),
						"value"				=> ""
					),
					array(
						"type"				=> "colorpicker",
						"heading"			=> esc_html_x( 'Tag Color', 'RB_VC_Menu_List', 'setech' ),
						"param_name"		=> "tag_color",
						"value"				=> PRIMARY_COLOR
					),
                ),
                "value"			=> "",
            ),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra class name', 'RB_VC_Menu_List', 'setech' ),
				"description"		=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'RB_VC_Menu_List', 'setech' ),
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
		"name"				=> esc_html_x( 'RB Menu List', 'RB_VC_Menu_List', 'setech' ),
		"base"				=> "rb_sc_menu_list",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Menu_List extends WPBakeryShortCode {
	    }
	}
?>