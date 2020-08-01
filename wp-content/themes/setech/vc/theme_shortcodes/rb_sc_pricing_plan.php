<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shadow Color', 'backend', 'setech' ),
			"param_name"		=> "shadow_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"				=> "rgba(0, 0, 0, 0.05)"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Background', 'backend', 'setech' ),
			"param_name"		=> "title_background",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#fff"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"param_name"		=> "title_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#000"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Border', 'backend', 'setech' ),
			"param_name"		=> "title_border",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#DEDEDE"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Text Color', 'backend', 'setech' ),
			"param_name"		=> "text_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#000"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'List Items Colors', 'backend', 'setech' ),
			"param_name"		=> "list_items_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-8",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Price Border', 'backend', 'setech' ),
			"param_name"		=> "price_border",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#DADCE2"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Price Background', 'backend', 'setech' ),
			"param_name"		=> "price_background",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#fff"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Price Description', 'backend', 'setech' ),
			"param_name"		=> "price_description",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> "#7F7F7F"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Title', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> '#000'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Background', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> SECONDARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Border', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> SECONDARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Title Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> '#000'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Background Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> SECONDARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Border Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> SECONDARY_COLOR
		),
	);
	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		array(
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"param_name"		=> "title",
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Price', 'backend', 'setech' ),
				"param_name"		=> "price",
				"edit_field_class" 	=> "vc_col-xs-6",
				"default"			=> "49"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Subprice', 'backend', 'setech' ),
				"param_name"		=> "subprice",
				"edit_field_class" 	=> "vc_col-xs-6",
				"default"			=> "99"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Currency', 'backend', 'setech' ),
				"param_name"		=> "currency",
				"edit_field_class" 	=> "vc_col-xs-6",
				"default"			=> "$"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Price Description', 'backend', 'setech' ),
				"param_name"		=> "price_desc",
				"edit_field_class" 	=> "vc_col-xs-6",
				"default"			=> "/month"
			),
			array(
				"type"				=> "textarea_html",
				"heading"			=> esc_html_x( 'Text', 'backend', 'setech' ),
				"param_name"		=> "content",
			),
            array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Button Title', 'backend', 'setech' ),
				"param_name"		=> "button_title",
				"value"				=> "",
				"edit_field_class" 	=> "vc_col-xs-6",
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Button URL', 'backend', 'setech' ),
				"param_name"		=> "button_url",
				"value"				=> "#",
				"edit_field_class" 	=> "vc_col-xs-6",
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
		$styles
	));

	/* -----> MODULE DECLARATION <----- */
	vc_map( array(
		"name"				=> esc_html_x( 'RB Pricing Plan', 'backend', 'setech' ),
		"base"				=> "rb_sc_pricing_plan",
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Pricing_Plan extends WPBakeryShortCode {
	    }
	}

?>