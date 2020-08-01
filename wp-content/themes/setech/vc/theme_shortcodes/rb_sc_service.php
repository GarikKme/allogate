<?php
	/* -----> ICONS PROPERTIES <----- */
	$icons = rb_ext_icon_vc_sc_config_params( 'icon_img', 'icon' );

	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> 'all'
		),
		array(
			"type"				=> "dropdown",
			"heading"			=> esc_html_x( 'Hover Animation', 'backend', 'setech' ),
			"param_name"		=> "hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"				=> array(
				esc_html_x( "None", 'backend', 'setech' ) 				=> 'none',
				esc_html_x( "Color on Hover", 'backend', 'setech' ) 	=> 'color',
				esc_html_x( "Image on Hover", 'backend', 'setech' ) 	=> 'image',
			),
		),
		array(
			"type"				=> "attach_image",
			"heading"			=> esc_html_x( 'Hover Image', 'backend', 'setech' ),
			"param_name"		=> "hover_image",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "hover",
				"value"		=> 'image'
			),
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Hover Color', 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "hover_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "hover",
				"value"		=> "color"
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_align",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> "all",
			"dependency"	=> array(
				"element"		=> "icon_img",
				"value"			=> array( "icon", "image" )
			),
			"value"			=> array( esc_html_x( 'Customize Alignment', 'backend', 'setech' ) => true ),
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html_x( 'Text Alignment', 'backend', 'setech' ),
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"param_name"	=> "module_alignment",
			"responsive"	=> "all",
			"dependency"		=> array(
				"element"	=> "customize_align",
				"not_empty"	=> true
			),
			"value"			=> array(
				esc_html_x( "Left", 'backend', 'setech' ) 	=> 'left',
				esc_html_x( "Center", 'backend', 'setech' ) 	=> 'center',
				esc_html_x( "Right", 'backend', 'setech' ) 	=> 'right',
			),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_size",
			"group"			=> esc_html_x( "Styling", "backend", 'setech' ),
			"responsive"	=> "all",
			"value"			=> array( esc_html_x( 'Customize Sizes', "backend", 'setech' ) => true ),
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Icon/Image Size', "backend", 'setech' ),
			"param_name"		=> "icon_size",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "30px"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Size', "backend", 'setech' ),
			"param_name"		=> "title_size",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "20px"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Line-Height', "backend", 'setech' ),
			"param_name"		=> "title_lh",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "initial"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Text Size', "backend", 'setech' ),
			"param_name"		=> "text_size",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "15px"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Text Line-Height', "backend", 'setech' ),
			"param_name"		=> "text_lh",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "27px"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Margins', "backend", 'setech' ),
			"description"		=> esc_html_x( 'Top / Right / Bottom / Left', 'backend', 'setech' ),
			"param_name"		=> "title_margins",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "23px 0px 0px 0px"
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_colors",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"			=> array( esc_html_x( 'Customize Colors', 'backend', 'setech' ) => true ),
			"std"			=> '1'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shape Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "shape_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#fff"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shape Hover Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "shape_hover_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#fff"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icon Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "icon_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icon Hover Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "icon_hover_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"param_name"		=> "title_color",
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#000"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Hover Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"param_name"		=> "title_hover_color",
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#000"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Text Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "text_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "rgba(0, 0, 0, .75)"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Text Hover Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "text_hover_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "rgba(0, 0, 0, .75)"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Text Links Color on Hover', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"param_name"		=> "text_links_hover",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shadow Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "shadow_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> ""
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shadow Hover Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "shadow_hover_color",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> ""
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
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Icon / Image', 'backend', 'setech' ),
				"param_name"		=> "icon_img",
				"value"				=> array(
					esc_html_x( "Icon", 'backend', 'setech' ) 		=> 'icon',
					esc_html_x( "Image", 'backend', 'setech' ) 		=> 'image',
				),
			),
		),
		$icons,
		array(
			array(
				"type"				=> "attach_image",
				"heading"			=> esc_html_x( 'Image', 'RB_VC_Image', 'setech' ),
				"param_name"		=> "image",
				"dependency"		=> array(
					"element"	=> "icon_img",
					"value"		=> 'image'
				),
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Icon Position', 'backend', 'setech' ),
				"param_name"		=> "style",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> array(
					esc_html_x( "Icon Top", 'backend', 'setech' ) 		=> 'icon_top',
					esc_html_x( "Icon Left", 'backend', 'setech' ) 		=> 'icon_left',
					esc_html_x( "Icon Right", 'backend', 'setech' ) 	=> 'icon_right',
				),
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Icon Shape', 'backend', 'setech' ),
				"param_name"		=> "icon_shape",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> array(
					esc_html_x( "None", 'backend', 'setech' ) 		=> 'none',
					esc_html_x( "Round", 'backend', 'setech' ) 		=> 'round',
					esc_html_x( "Square", 'backend', 'setech' ) 	=> 'square',
				),
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Vertical Alignment', 'backend', 'setech' ),
				"param_name"		=> "vertical_align",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> array("icon_left", "icon_right")
				),
				"value"				=> array(
					esc_html_x( "Top", 'backend', 'setech' ) 		=> 'flex-start',
					esc_html_x( "Center", 'backend', 'setech' ) 	=> 'center',
					esc_html_x( "Bottom", 'backend', 'setech' ) 	=> 'flex-end',
				),
			),
			array(
				"type"				=> "textarea",
				"admin_label"		=> true,
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "title",
				"value"				=> ""
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Title HTML Tag', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "title_tag",
				"value"				=> array(
					esc_html_x( "Default - (H3)", 'backend', 'setech' ) 	=> 'h3',
					esc_html_x( "H1", 'backend', 'setech' ) 				=> 'h1',
					esc_html_x( "H2", 'backend', 'setech' ) 				=> 'h2',
					esc_html_x( "H4", 'backend', 'setech' ) 				=> 'h4',
					esc_html_x( "H5", 'backend', 'setech' ) 				=> 'h5',
					esc_html_x( "H6", 'backend', 'setech' ) 				=> 'h6',
				),
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'URL', 'backend', 'setech' ),
				"param_name"		=> "url",
				"value"				=> ""
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "new_tab",
				"value"				=> array( esc_html_x( 'Open in new tab', "backend", 'setech' ) => true ),
				"std"				=> "1"
			),
			array(
				"type"				=> "textarea_html",
				"heading"			=> esc_html_x( 'Content', 'backend', 'setech' ),
				"param_name"		=> "content"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Author', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "author",
				"value"				=> ""
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Author Divider', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "author_divider",
				"dependency"		=> array(
					"element"	=> "author",
					"not_empty"	=> true
				),
				"value"				=> "rgba(0,0,0,.5)"
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
		"name"				=> esc_html_x( 'RB Service', 'backend', 'setech' ),
		"base"				=> "rb_sc_service",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Service extends WPBakeryShortCode {
	    }
	}
?>