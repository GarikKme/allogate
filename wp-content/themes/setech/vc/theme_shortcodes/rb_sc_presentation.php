<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles =  array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' )
		)
	);

	/* -----> GET PRODUCT CATEGORIES <----- */
	$args = array(
	    'taxonomy'     => 'product_cat',
	    'orderby'      => 'name',
	    'hide_empty'   => 0
	);

	$all_categories = get_categories( $args );
	$category_array['None'] = 'none';

	foreach( $all_categories as $cat ){
		if( $cat->category_parent == 0 ){
			$category_array[$cat->name] = $cat->slug;
		}       
	}

	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		array(
			array(
                'type' 			=> 'param_group',
                'heading' 		=> esc_html_x( 'Values', 'backend', 'setech' ),
                'param_name' 	=> 'values',
                'params' 		=> array(
					array(
						"type"			=> "textfield",
						"admin_label"	=> true,
						"heading"		=> esc_html_x( 'Title', 'backend', 'setech' ),
						"param_name"	=> "title",
						"value"			=> ""
					),
					array(
						"type"			=> "attach_images",
						"heading"		=> esc_html_x( 'Images', 'backend', 'setech' ),
						"param_name"	=> "images",
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
		$styles
	));

	/* -----> MODULE DECLARATION <----- */
	vc_map( array(
		"name"				=> esc_html_x( 'RB Presentation', 'backend', 'setech' ),
		"base"				=> "rb_sc_presentation",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Presentation extends WPBakeryShortCode {
	    }
	}
?>