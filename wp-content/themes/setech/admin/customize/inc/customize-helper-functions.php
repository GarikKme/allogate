<?php

function setech_sanitize_dropdown_pages( $page_id, $setting ) {
  // Ensure $input is an absolute integer.
  $page_id = absint( $page_id );

  // If $page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}


/**
 * The helper function that will used to
 * read customizer panels, sections, settings and controls
 *
 * @param   string  $wp_customuze is wordpress customizer main variable
 * @param   string  $extensions is array with all custom customizer extensions
 * @return  mixed
 */ 
function setech_read_options( $wp_customize, $extensions ){
    $ajax_data = array();
    $count = 0;
    
    foreach( $extensions as $key => $value ){
        $panel_atts = $section_atts = array();

        //Get Panel parameters
        foreach( $value as $panel_key => $panel_value ){
            if( $panel_key != 'layout' ){
                $panel_atts[$panel_key] = $panel_value;
            } else {

                //Get Section parameters
                foreach( $panel_value as $panel_k => $panel_v ){
                    foreach( $panel_v as $section_key => $section_value ){
                        if( $section_key != 'layout' ){
                            $section_atts[$section_key] = $section_value;
                        } else {
                            //Each Secion
                            foreach( $section_value as $k => $v ){
                                //Clear arrays before fill
                                $control_atts = $settings_atts = $choices_default = array();

                                //Each Sontrol
                                foreach ( $v as $settings_key => $settings_value ){
                                    //Fill control & setting attributes
                                    switch( $settings_key ){
                                        case 'default':
                                        case 'capability':
                                        case 'theme_supports':
                                        case 'transport':
                                        case 'sanitize_callback':
                                        case 'sanitize_js_callback':
                                            $settings_atts[$settings_key] = $settings_value;
                                            break;
                                        case 'setting_type':
                                            $settings_atts['type'] = $settings_value;
                                        case 'live_preview':
                                            $settings_atts['transport'] = 'postMessage';
                                            break;
                                        case 'label':
                                        case 'description':
                                        case 'priority':
                                        case 'type':
                                        case 'input_attrs':
                                        case 'function':
                                        case 'separator':
                                        case 'add_label':
                                        case 'save_label':
                                        case 'dependency':
                                            $control_atts[$settings_key] = $settings_value;
                                            break;
                                        //Custom multiple_inputs controls handler
                                        case 'choices':
                                            if( $control_atts['type'] == 'multiple_input' && rb_is_multi_array($settings_value) ){
                                                //Take default values from multiple input controls
                                                foreach ($settings_value as $choice_k => $choice_v) {
                                                    if( array_key_exists('value', $choice_v) ){
                                                        $choices_default[$choice_k] = $choice_v['value'];
                                                    }
                                                }
                                                $control_atts[$settings_key] = $settings_value;
                                                if( !empty($choices_default) ){
                                                    $control_atts['default'] = $choices_default;
                                                }
                                            } else {
                                                $control_atts[$settings_key] = $settings_value;
                                            }
                                            break;
                                        default:
                                            break;
                                    }

                                    //Gather JSON array for all live-preview controls
                                    if( $settings_key == 'live_preview' ){

                                        $ajax_data[$count] = array( 'control' => $k );

                                        foreach( $settings_value as $ajax_key => $ajax_value ){
                                            $ajax_data[$count][$ajax_key] = $ajax_value;
                                        }

                                        $count ++;
                                    }

                                    if( $settings_value == 'alpha-color' ){
                                        $control_atts['palette'] = $GLOBALS['palette'];
                                    }
                                }

                                $control_atts['section'] = $panel_k;
                                $control_atts['settings'] = $k;

                                //Settings initialiation
                                $wp_customize->add_setting( $k, $settings_atts, 'sanitize_callback' );

                                //Custom & Advanced WP Controls initialiation
                                if( in_array('wp_image', $control_atts) ){
                                    unset($control_atts['type']);
                                    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $k, $control_atts ) );
                                } else {
                                    $wp_customize->add_control( new RB_Customizer( $wp_customize, $k, $control_atts ) );
                                }
                            }
                        }
                    }

                    $section_atts['panel'] = $key;

                    //Section initialiation
                    $wp_customize->add_section( $panel_k, $section_atts);
                }
            }
        }

        //Panel initialiation
        $wp_customize->add_panel( $key, $panel_atts);
    }

    //Prepare Ajax data to send
    $ajax_data = json_encode($ajax_data);
    $GLOBALS['data_to_send'] = array(
        'ajax_data' => $ajax_data,
    );
}


/**
 * The helper function that will used to
 * set default controls properties on first theme initialization
 *
 * @param   string  $extensions is array with all custom customizer extensions
 * @return  mixed
 */ 
function setech_get_defaults( $extensions ){
    $defaults = array();

    foreach ($extensions as $key => $value) {
        foreach ($value as $panel_key => $panel_value) {
            if( $panel_key == 'layout' ){
                foreach ($panel_value as $panel_k => $panel_v){
                    foreach( $panel_v as $section_key => $section_value ){
                        if( $section_key == 'layout' ){
                            foreach ($section_value as $k => $v) {
                                foreach ($v as $setting_key => $setting_value) {
                                    if( $setting_key == 'default' ){
                                        $defaults[$k] = $setting_value;
                                    }
                                    if( $v['type'] == 'multiple_input' && is_array($setting_value) && rb_is_multi_array($setting_value) ){
                                        $choices_default = array();

                                        foreach ($setting_value as $choice_k => $choice_v) {
                                            if( array_key_exists('value', $choice_v) ){
                                                $choices_default[$choice_k] = $choice_v['value'];
                                            }
                                        }

                                        $defaults[$k] = $choices_default;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $defaults;
}


/**
 * The helper function that will used to
 * get google fonts array
 *
 * @return  mixed
 */ 
function setech_get_google_fonts(){
    global $wp_filesystem;

    if( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }

    if( get_option('rb_g_fonts') ){
        $google_fonts = get_option('rb_g_fonts');
    } else {
        $file = SETECH__PATH . 'assets/fonts/gf.json';
        if ( $wp_filesystem && $wp_filesystem->exists($file) ) {
            $google_fonts = $wp_filesystem->get_contents($file);
        } else {
            return array();
        }
        $google_fonts = json_decode($google_fonts, true);
    }

    return $google_fonts;
}

/**
 * The helper function that will used to
 * create typography controls
 *
 * @param   string  $location is prefix for controls
 * @param   string  $def_family is default value for font-family control
 * @param   string  $def_weight is default value for font-weight control
 * @param   string  $def_color is default value for font-color control
 * @param   string  $def_size is default value for font-size control
 * @param   string  $def_height is default value for font-height control
 * @return  mixed
 */	
function setech_typography_control( $location, $def_family, $def_weight, $def_subset, $def_color, $def_size, $def_height ){
    $font_choices = array();
    $loc = esc_html($location);
    $def_f = esc_html($def_family);
    $def_w = $def_weight;
    $def_ss = $def_subset;
    $def_c = esc_html($def_color);
    $def_s = esc_html($def_size);
    $def_h = esc_html($def_height);

    $g_fonts = setech_get_google_fonts();

    // Create choices for font-weight & font-subsets
    $isset_weight = array( '100', '100italic', '200', '200italic', '300', '300italic', '400', '400italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic' );

    if( get_theme_mod($loc.'_font_family') && !empty(get_theme_mod($loc.'_font_family')) ){
        foreach( $isset_weight as $weight ){
            if( stristr(get_theme_mod($loc.'_font_family'), $weight) ){
                $font_weight[$weight] = str_replace('00', '00 ', $weight);
            }
        }
        foreach( $g_fonts['items'] as $key => $font ){
            if( explode(',', get_theme_mod($loc.'_font_family'))[0] == $font['family'] ){
                foreach( $font['subsets'] as $value ){
                    $font_subsets[$value] = $value;
                }
            }
        }
    } else {
        $font_weight['regular'] = 'regular';
        $font_subsets = array(
            'latin' => 'latin'
        );
    }

    // Gather all fonts in one array
    $theme_fonts = $GLOBALS['default_fonts'];

    foreach( $g_fonts['items'] as $key => $font ){
        $theme_fonts[$font['family']] = array(
            'cat' => $font['category'],
            'var' => join(',', $font['variants']),
            'sub' => join(';', $font['subsets']),
        );
        if( $font['family'] == $def_f ){
            $font_default = $font['variants'];
        }
    }
        
    // Create choices for font-family
    foreach ($theme_fonts as $k => $v) {
        $font_choices[$k.','.$v['var']] = $k;
    }

    $def_f = $def_f.','.implode(",", $font_default);

    if( !$def_c ){
        $def_c = array();
    } else {
        $def_c = array(
            $loc.'_font_color' => array(
                'type'      => 'alpha-color',
                'label'     => esc_html_x(ucfirst($loc).' font Color', 'customizer', 'setech'),
                'default'   => $def_c,
                'sanitize_callback' => 'wp_strip_all_tags',
                'live_preview'      => array(
                    'trigger_class'     => 'body',
                    'style_to_change'   => 'color',
                )
            ),
        );
    }

    if( $def_s && $def_h ){
        $f_sizes = array(
            $loc.'_font_size' => array(
                'type'      => 'text',
                'default'   => $def_s,
                'label'     => esc_html_x(ucfirst($loc).' font size', 'customizer', 'setech')
            ),
            $loc.'_font_height' => array(
                'type'      => 'text',
                'default'   => $def_h,
                'label'     => esc_html_x(ucfirst($loc).' line height', 'customizer', 'setech'),
                'separator' => 'line'
            )
        );
    } else {
        $f_sizes = array();
    }

    $out = array_merge(
        array(
            $loc.'_font_family' => array(
                'type'      => 'select',
                'label'     => esc_html_x(ucfirst($loc).' font family', 'customizer', 'setech'),
                'default'   => $def_f,
                'choices'   => $font_choices
            ),
            $loc.'_font_weight' => array(
                'type'          => 'select',
                'label'         => esc_html_x(ucfirst($loc).' font weight', 'customizer', 'setech'),
                'default'       => $def_w,
                'choices'       => $font_weight,
                'input_attrs'   => array(
                    'multiple' => true
                )
            ),
            $loc.'_font_subset' => array(
                'type'          => 'select',
                'label'         => esc_html_x(ucfirst($loc).' font subsets', 'customizer', 'setech'),
                'default'       => $def_ss,
                'choices'       => $font_subsets,
                'input_attrs'   => array(
                    'multiple' => true
                )
            )
        ),
        $def_c,
        $f_sizes
    );

    return $out;
}

?>