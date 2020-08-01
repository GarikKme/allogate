<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = rb_ext_merge_arrs( array(
		array(
			array(
				"type"			=> "css_editor",
				"param_name"	=> "custom_styles",
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"responsive"	=> 'all'
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Background Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "background_color",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> SECONDARY_COLOR,
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Background Hover Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "bg_color_hover",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"value"				=> "#fff",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Quotes Background', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "quotes_bg",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#fff",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Quotes Hover Background', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "quotes_bg_hover",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"value"				=> PRIMARY_COLOR,
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Quotes Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "quotes_color",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> PRIMARY_COLOR,
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Quotes Hover Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "quotes_color_hover",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"value"				=> "#fff",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Unactive Rating', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "unactive_rating",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#D0DFF2",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Unactive Rating Hover', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "unactive_rating_hover",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#D0DFF2",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Active Rating', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "active_rating",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#FABD4A",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Active Rating Hover', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "active_rating_hover",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#FABD4A",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Text Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "text_color",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#000",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Text Hover Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "text_color_hover",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#000",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Dots Color', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "dots_color",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> PRIMARY_COLOR,
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Shadow on Hover', 'backend', 'setech' ),
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"		=> "shadow_color",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "rgba(0,0,0, .15)",
			),
		)
	));

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
				"heading"			=> esc_html_x( 'Style', 'backend', 'setech' ),
				"param_name"		=> "style",
				"value"				=> array(
					esc_html_x( 'Simple', 'backend', 'setech' )		=> 'simple',
					esc_html_x( 'Extended', 'backend', 'setech' )	=> 'extended',
				)
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Image Shape', 'backend', 'setech' ),
				"param_name"		=> "shape",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "extended"
				),
				"value"				=> array(
					esc_html_x( 'Square', 'backend', 'setech' )		=> 'square',
					esc_html_x( 'Round', 'backend', 'setech' )		=> 'round',
				)
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Image Position', 'backend', 'setech' ),
				"param_name"		=> "image_pos",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "extended"
				),
				"value"				=> array(
					esc_html_x( 'Top', 'backend', 'setech' )		=> 'top',
					esc_html_x( 'Left', 'backend', 'setech' )		=> 'left',
				)
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Columns', 'backend', 'setech' ),
				"param_name"		=> "columns",
				"value"				=> array(
					esc_html_x( 'One', 'backend', 'setech' )		=> '1',
					esc_html_x( 'Two', 'backend', 'setech' )		=> '2',
					esc_html_x( 'Three', 'backend', 'setech' )		=> '3',
					esc_html_x( 'Four', 'backend', 'setech' )		=> '4',
					esc_html_x( 'Five', 'backend', 'setech' )		=> '5',
				)
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "carousel",
				"value"				=> array( esc_html_x( 'Carousel', 'backend', 'setech' ) => true ),
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "autoplay",
				"dependency"		=> array(
					"element"	=> "carousel",
					"not_empty"	=> true
				),
				"value"				=> array( esc_html_x( 'Autoplay', 'backend', 'setech' ) => true ),
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Slides to Scroll', 'backend', 'setech' ),
				"param_name"		=> "slides_to_scroll",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "carousel",
					"not_empty"	=> true
				),
				"value"				=> array(
					esc_html_x( 'One', 'backend', 'setech' )		=> '1',
					esc_html_x( 'Two', 'backend', 'setech' )		=> '2',
					esc_html_x( 'Three', 'backend', 'setech' )		=> '3',
					esc_html_x( 'Four', 'backend', 'setech' )		=> '4',
					esc_html_x( 'Five', 'backend', 'setech' )		=> '5',
				)
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Autoplay Speed', 'backend', 'setech' ),
				"param_name"		=> "autoplay_speed",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "carousel",
					"not_empty"	=> true
				),
				"value"				=> "3000"
			),
			array(
                'type' 			=> 'param_group',
                'heading' 		=> esc_html_x( 'Testimonials', 'backend', 'setech' ),
                'param_name' 	=> 'values',
                'params' 		=> array(
                	array(
						"type"				=> "attach_image",
						"heading"			=> esc_html_x( 'Image', 'RB_VC_Image', 'setech' ),
						"param_name"		=> "image",
					),
                	array(
						"type"				=> "textfield",
						"admin_label"		=> true,
						"heading"			=> esc_html_x( 'Name', 'backend', 'setech' ),
						"param_name"		=> "name",
						"edit_field_class" 	=> "vc_col-xs-6",
						"value"				=> ""
					),
					array(
						"type"				=> "textfield",
						"heading"			=> esc_html_x( 'Stars', 'backend', 'setech' ),
						"param_name"		=> "stars",
						"description"		=> esc_html_x( 'Please enter a number from 1 to 5. Or leave it empty.', 'backend', 'setech' ),
						"edit_field_class" 	=> "vc_col-xs-6",
						"value"				=> ""
					),
					array(
						"type"				=> "textarea",
						"heading"			=> esc_html_x( 'Content', 'backend', 'setech' ),
						"param_name"		=> "description",
						"value"				=> ""
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
		"name"				=> esc_html_x( 'RB Testimonials', 'backend', 'setech' ),
		"base"				=> "rb_sc_testimonials",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Testimonials extends WPBakeryShortCode {
	    }
	}
?>