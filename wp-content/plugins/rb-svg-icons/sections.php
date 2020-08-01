<?php
	$manage_css_dlg = array(
		'names' => array(
			'title' => esc_html__( 'Preset names', 'rb-svgi' ),
			'type' 	=> 'select',
			'subtype' => 'editable',
			'atts' => 'onchange="this.nextElementSibling.value=this.value"',
			'addrowclasses' => 'editable',
			'source'	=> array(
				'' => array('', true),
			),
		),
		'css' => array(
			'title' => esc_html__( 'CSS code', 'rb-svgi' ),
			'type' => 'textarea',
			'atts' => 'rows="10"',
		),
		'note' => array(
			'type' => 'info',
			'addrowclasses' => 'disable',
			'value' => esc_html__('Note that there are several animations detected. They will be saved separately with the preset as prefix specified.', 'rb-svgi'),
		),
		'note1' => array(
			'type' => 'info',
			'value' => esc_html__('Delete all code and press Save in order to delete selected preset.', 'rb-svgi'),
		),
	);

	$controls = array(
		'tab0' => array(
			'type' => 'tab',
			'init' => 'open',
			'title' => esc_html__( 'General', 'rb-svgi' ),
			'layout' => array(
				'title' => array(
					'title' => esc_html__( 'Give it a name', 'rb-svgi' ),
					'type' 	=> 'text',
				),
				'trigger' => array(
					'title' => esc_html__( 'Trigger when', 'rb-svgi' ),
					'type' 	=> 'select',
					'source'	=> array(
						'hover' => array('Hover', true),
						'hover-rev' => array('Hover with reverse', false),
						'scroll' => array('Scroll', false),
						'onload' => array('On Page Load', false),
					),
				),
				'duration' => array(
					'title' => esc_html__( 'Duration', 'rb-svgi' ),
					'description' => esc_html__( 'in seconds', 'rb-svgi' ),
					'type' 	=> 'number',
					'value'	=> '2',
				),
				'repeat' => array(
					'title' => esc_html__( 'Repeat', 'rb-svgi' ),
					'description' => esc_html__( '-1 to infinite', 'rb-svgi' ),
					'type' 	=> 'number',
					'value'	=> '1',
				),
				'transform-origin' => array(
					'title' => esc_html__( 'Transform Origin', 'rb-svgi' ),
					'addrowclasses' => 'variable',
					'cols' => 3,
					'type' => 'radio',
					'value' => array(
						'0%,0%'=>	array( '', false ),
						'50%,0%'=>	array( '', false ),
						'100%,0%'=>	array( '', false ),
						'0%,50%'=>	array( '', false ),
						'50%,50%'=>	array( '', true ),
						'100%,50%'=>	array( '', false ),
						'0%,100%'=>	array( '', false ),
						'50%,100%'=>	array( '', false ),
						'100%,100%'=>	array( '', false ),
					),
				),
				'timing_func' => array(
					'title' => esc_html__( 'Timing function', 'rb-svgi' ),
					'addrowclasses' => 'variable',
					'type' 	=> 'select',
					'source'	=> array(
						'ease' => array('ease', true),
						'linear' => array('linear', false),
						'ease-in' => array('ease-in', false),
						'ease-out' => array('ease-out', false),
						'ease-in-out' => array('ease-in-out', false),
					),
				),
				'rotate' => array(
					'title' => esc_html__( 'Rotate', 'rb-svgi' ),
					'addrowclasses' => 'variable',
					'description' => esc_html__( 'in degrees', 'rb-svgi' ),
					'type' 	=> 'input_group',
					'source' => array(
						'0' => array('number', '', '0', '<span class="dashicons dashicons-arrow-right-alt"></span>'),
						'1' => array('number', '', '0'),
					),
				),
				'scale' => array(
					'title' => esc_html__( 'Scale', 'rb-svgi' ),
					'addrowclasses' => 'variable',
					'description' => esc_html__( 'in one hundreds', 'rb-svgi' ),
					'type' 	=> 'input_group',
					'source' => array(
						'0' => array('number', '', '100', '<span class="dashicons dashicons-arrow-right-alt"></span>'),
						'1' => array('number', '', '100'),
					),
				),
				'opacity' => array(
					'title' => esc_html__( 'Opacity', 'rb-svgi' ),
					'addrowclasses' => 'variable',
					'description' => esc_html__( 'in one hundreds', 'rb-svgi' ),
					'type' 	=> 'input_group',
					'source' => array(
						'0' => array('number', '', '100', '<span class="dashicons dashicons-arrow-right-alt"></span>'),
						'1' => array('number', '', '100'),
					),
				),
				'translate' => array(
					'title' => esc_html__( 'Translate (px)', 'rb-svgi' ),
					'addrowclasses' => 'variable',
					'type' => 'input_group',
					'source' => array(
						'left0' => array('number', 'Left', ''),
						'top0' => array('number', 'Top', '', '<span class="dashicons dashicons-arrow-right-alt"></span>'),
						'left1' => array('number', 'Left', ''),
						'top1' => array('number', 'Top', ''),
					),
				),
			),
		),
		'tab1' => array(
			'type' => 'tab',
			'title' => esc_html__( 'Background', 'rb-svgi' ),
			'layout' => array(
				'is_bg' => array(
						'type' => 'checkbox',
						'title' => esc_html__('Add background?', 'taurus' ),
						//'atts' => 'data-options=""',
						'addrowclasses' => 'alt checkbox',
					),
			),
		),
/*		'dimensions' => array(
			'title' => esc_html__( 'Dimensions', 'rb-svgi' ),
			'type' 	=> 'input_group',
			'source' => array(
				'0' => array('number', '', '120'),
				'1' => array('number', '', '120'),
			),
		),*/
		'buttons' => array(
			'type' 	=> 'buttons',
			'header' => '<hr>',
			'source' => array(
				'preview' => array(
					'title' => esc_html__( 'Preview', 'rb-svgi' ),
					'atts' => 'class="button button-primary"',
				),
				'save' => array(
					'title' => esc_html__( 'Save', 'rb-svgi' ),
					'atts' => 'class="button button-secondary"',
				),
				'save_preset' => array(
					'title' => esc_html__( 'Save as preset', 'rb-svgi' ),
					'atts' => 'class="button button-secondary"',
				),
			)
		),
		/*'shortcode' => array(
			'title' => esc_html__( 'Shortcode', 'rb-svgi' ),
			'type' 	=> 'text',
			'atts' => 'readonly'
		),*/
	);
?>