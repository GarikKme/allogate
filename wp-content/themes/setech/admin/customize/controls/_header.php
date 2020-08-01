<?php
    // Get typography props
    $setech_typography_control = array();
    if( function_exists('setech_typography_control') ){
        $setech_typography_control = setech_typography_control( 'menu', 'Poppins', array('500', '600'), 'latin', false, '16px', '27px' );
    }

	return array(
		'top_bar_section' => array(
            'title'     => esc_html_x('Top Bar', 'customizer', 'setech'),
            'layout'    => array_merge(
                array(
                    'top_bar_wide' => array(
                        'default'   => false,
                        'type'      => 'checkbox',
                        'label'     => esc_html_x('Apply full-width top bar', 'customizer', 'setech'),
                    ),
                    'top_bar_number' => array(
                        'type'      => 'text',
                        'label'     => esc_html_x('Phone Number', 'customizer', 'setech'),
                        'default'   => "",
                    ),
                    'top_bar_email' => array(
                        'type'      => 'text',
                        'label'     => esc_html_x('Email', 'customizer', 'setech'),
                        'default'   => "",
                    ),
                    'top_bar_address' => array(
                        'type'      => 'text',
                        'label'     => esc_html_x('Address', 'customizer', 'setech'),
                        'default'   => "",
                        'separator' => 'line'
                    ),
                    'icon_custom_sb' => array(
                        'default'   => false,
                        'type'      => 'checkbox',
                        'label'     => esc_html_x('Add Custom Sidebar Icon', 'customizer', 'setech')
                    ),
                    'custom_sidebar' => array(
                        'type'          => 'select',
                        'label'         => esc_html_x('Custom sidebar', 'customizer', 'setech'),
                        'default'       => 'custom_sidebar',
                        'dependency'    => array(
                            'control'   => 'icon_custom_sb',
                            'operator'  => '==',
                            'value'     => 'true'
                        ),
                        'choices'       => array_merge( 
                            array(
                                'none'  => esc_html_x('None', 'customizer', 'setech'),
                            ),
                            is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array()
                        ),
                    ),
                ),
                array(
                    'search_title' => array(
                        'type'      => 'text',
                        'label'     => esc_html_x('Search Title', 'customizer', 'setech'),
                        'default'   => esc_html_x('Search for anything.', 'customizer', 'setech'),
                    ),
                    'top_bar_bg_color' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Background', 'customizer', 'setech'),
                        'default'           => '#FFFFFF',
                        'sanitize_callback' => 'wp_strip_all_tags',
                        'live_preview'      => array(
                            'trigger_class'     => '.top-bar-box',
                            'style_to_change'   => 'background-color',
                        )
                    ),
                    'top_bar_border_color' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Border', 'customizer', 'setech'),
                        'default'           => '#CCCCCC',
                        'sanitize_callback' => 'wp_strip_all_tags',
                    ),
                    'top_bar_font_color' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Fonts & Icons Color', 'customizer', 'setech'),
                        'default'           => '#7F7F7F',
                        'sanitize_callback' => 'wp_strip_all_tags',
                        'live_preview'      => array(
                            'trigger_class'     => '.top-bar-box .container > * > a, .header_icons > .mini-cart > a',
                            'style_to_change'   => 'color',
                        )
                    ),
                    'top_bar_font_color_hover' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Fonts & Icons Hover', 'customizer', 'setech'),
                        'default'           => '#000',
                        'sanitize_callback' => 'wp_strip_all_tags'
                    ),
                    'top_bar_spacings' => array(
                        'type'          => 'multiple_input',
                        'label'         => esc_html_x('Spacings', 'customizer', 'setech'),
                        'choices'       => array(
                            'top'  => array( 
                                'placeholder' => esc_html_x('Top (px or %)', 'customizer', 'setech'), 
                                'value' => '6px'
                            ),
                            'bottom' => array( 
                                'placeholder' => esc_html_x('Bottom (px or %)', 'customizer', 'setech'), 
                                'value' => '5px'
                            ),
                        )
                    ),
                )
            ),
        ),
        'logotype_section' => array(
            'title'     => esc_html_x('Logo', 'customizer', 'setech'),
            'layout'    => array(
                'logotype' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Logo', 'customizer', 'setech'),
                    'description'   => esc_html_x('To get a retina logo please upload a double-size image and set the image dimentions to fit the actual logo size', 'customizer', 'setech'),
                ),
                'logo_dimensions' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Dimensions', 'customizer', 'setech'),
                    'choices'       => array(
                        'width'  => array( 
                            'placeholder' => esc_html_x('Width (px)', 'customizer', 'setech'), 
                            'value' => '130px' 
                        ),
                        'height' => array( 
                            'placeholder' => esc_html_x('Height (px)', 'customizer', 'setech'), 
                            'value' => 0
                        ),
                    )
                ),
                'logo_margins' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Spacings', 'customizer', 'setech'),
                    'choices'       => array(
                        'top'  => array( 
                            'placeholder' => esc_html_x('Top (px or %)', 'customizer', 'setech'), 
                        ),
                        'right' => array( 
                            'placeholder' => esc_html_x('Right (px or %)', 'customizer', 'setech'), 
                        ),
                        'bottom' => array( 
                            'placeholder' => esc_html_x('Bottom (px or %)', 'customizer', 'setech'), 
                        ),
                        'left' => array( 
                            'placeholder' => esc_html_x('Left (px or %)', 'customizer', 'setech'), 
                        ),
                    )
                ),
            )
        ),
        'menu_section' => array(
            'title'     => esc_html_x('Menu Appearance', 'customizer', 'setech'),
            'layout'    => array_merge(
                array(
                    'menu_wide' => array(
                        'default'   => true,
                        'type'      => 'checkbox',
                        'label'     => esc_html_x('Apply full-width menu', 'customizer', 'setech'),
                    )
                ),
                $setech_typography_control,
                array(
                    'menu_font_color' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Font Color', 'customizer', 'setech'),
                        'default'           => "#000000",
                        'sanitize_callback' => 'wp_strip_all_tags',
                    ),
                    'menu_accent_font_color' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Accent Font Color', 'customizer', 'setech'),
                        'default'           => PRIMARY_COLOR,
                        'sanitize_callback' => 'wp_strip_all_tags'
                    ),
                    'submenu_font_color' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Submenu Font Color', 'customizer', 'setech'),
                        'default'           => "rgba(0,0,0, .75)",
                        'sanitize_callback' => 'wp_strip_all_tags',
                    ),
                    'submenu_font_color_hover' => array(
                        'type'              => 'alpha-color',
                        'label'             => esc_html_x('Submenu Font Hover', 'customizer', 'setech'),
                        'default'           => "#000000",
                        'sanitize_callback' => 'wp_strip_all_tags'
                    ),
                    'menu_spacings' => array(
                        'type'          => 'multiple_input',
                        'label'         => esc_html_x('Spacings', 'customizer', 'setech'),
                        'choices'       => array(
                            'top'  => array( 
                                'placeholder' => esc_html_x('Top (px or %)', 'customizer', 'setech'), 
                                'value' => '30px'
                            ),
                            'bottom' => array( 
                                'placeholder' => esc_html_x('Bottom (px or %)', 'customizer', 'setech'), 
                                'value' => '26px'
                            ),
                        )
                    ),
                    'menu_mode' => array(
                        'default'       => 'desktop',
                        'type'          => 'radio',
                        'label'         => esc_html_x('Show desktop menu on:', 'customizer', 'setech'),
                        'choices'       => array(
                            'desktop'       => esc_html_x('Desktops', 'customizer', 'setech'),
                            'landscape'     => esc_html_x('Tablets Landscape', 'customizer', 'setech'),
                            'both'          => esc_html_x('Landscape & Portrait Tablets', 'customizer', 'setech'),
                        ),
                        'separator'     => 'line'
                    ),
                    'menu_have_a_question_title' => array(
                        'type'      => 'text',
                        'label'     => esc_html_x('"Have a Question" Title', 'customizer', 'setech'),
                        'default'   => '',
                    ),
                    'menu_have_a_question_phone' => array(
                        'type'          => 'text',
                        'label'         => esc_html_x('"Have a Question" Phone', 'customizer', 'setech'),
                        'default'       => '',
                        'dependency'    => array(
                            'control'   => 'menu_have_a_question_title',
                            'operator'  => '!=',
                            'value'     => ''
                        ),
                    ),
                )
            )
        ),
        'title_area' => array(
            'title'     => esc_html_x('Title Area', 'customizer', 'setech'),
            'layout'    => array(
                'title_area_spacings' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Title Spacing', 'customizer', 'setech'),
                    'choices'       => array(
                        'top'  => array( 
                            'placeholder' => esc_html_x('Top (px)', 'customizer', 'setech'), 
                            'value' => '67px' 
                        ),
                        'bottom' => array( 
                            'placeholder' => esc_html_x('Bottom (px)', 'customizer', 'setech'), 
                            'value' => '61px' 
                        ),
                    )
                ),
                'mobile_title_area_spacings' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x(' Mobile Title Spacing', 'customizer', 'setech'),
                    'choices'       => array(
                        'top'  => array( 
                            'placeholder' => esc_html_x('Top (px)', 'customizer', 'setech'), 
                            'value' => '40px' 
                        ),
                        'bottom' => array( 
                            'placeholder' => esc_html_x('Bottom (px)', 'customizer', 'setech'), 
                            'value' => '30px' 
                        ),
                    ),
                ),
                'title_archive_font_size' => array(
                    'type'          => 'textfield',
                    'label'         => esc_html_x('Title Font Size on Archive', 'customizer', 'setech'),
                    'default'       => "56px",
                    'live_preview'      => array(
                        'trigger_class'     => 'body:not(.single) .page_title_container .page_title_customizer_size',
                        'style_to_change'   => 'font-size',
                    )
                ),
                'title_single_font_size' => array(
                    'type'          => 'textfield',
                    'label'         => esc_html_x('Title Font Size on Singles', 'customizer', 'setech'),
                    'default'       => "48px",
                    'separator'     => 'line',
                    'live_preview'      => array(
                        'trigger_class'     => 'body.single .page_title_container .page_title_customizer_size',
                        'style_to_change'   => 'font-size',
                    )
                ),
                'title_custom_gradient' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Custom Gradient', 'customizer', 'setech'),
                ),
                'title_background_gradient_1' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Bg Gradient 1', 'customizer', 'setech'),
                    'default'           => SECONDARY_COLOR,
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_custom_gradient',
                        'operator'  => '!=',
                        'value'     => 'true'
                    ),
                ),
                'title_background_gradient_2' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Bg Gradient 2', 'customizer', 'setech'),
                    'default'           => SECONDARY_COLOR,
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_custom_gradient',
                        'operator'  => '!=',
                        'value'     => 'true'
                    ),
                ),
                'title_custom_gradient_css' => array(
                    'type'          => 'textarea',
                    'label'         => esc_html_x('Please, enter css code of custom gradient', 'customizer', 'setech'),
                    'dependency'    => array(
                        'control'   => 'title_custom_gradient',
                        'operator'  => '==',
                        'value'     => 'true'
                    ),
                    'default'       => "",
                ),
                'title_area_mask' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Title Area Mask', 'customizer', 'setech'),
                ),
                'title_share_bg' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Extend Background with Menu', 'customizer', 'setech'),
                ),
                'title_area_bg' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Title Area Background', 'customizer', 'setech'),
                ),
                'title_area_interactive' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Title Interactive Image', 'customizer', 'setech'),
                ),
                'title_fields_hide' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Hide', 'customizer', 'setech'),
                    'default'       => 'none',
                    'choices'       => array(
                        'none'          => esc_html_x('None', 'customizer', 'setech'),
                        'cats'          => esc_html_x( 'Categories', 'customizer', 'setech' ),
                        'title'         => esc_html_x( 'Title', 'customizer', 'setech' ),
                        'meta'          => esc_html_x( 'Meta', 'customizer', 'setech' ),
                        'divider'       => esc_html_x( 'Divider', 'customizer', 'setech' ),
                        'breadcrumbs'   => esc_html_x( 'Breadcrumbs', 'customizer', 'setech' )
                    ),
                    'input_attrs'   => array(
                        'multiple'      => true
                    ),
                ),
                'title_categories_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Categories Color', 'customizer', 'setech'),
                    'default'           => "#7E7E80",
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_fields_hide',
                        'operator'  => '!=',
                        'value'     => 'cats'
                    ),
                    'live_preview'      => array(
                        'trigger_class'     => '.page_title_container .single_post_categories a',
                        'style_to_change'   => 'color',
                    )
                ),
                'title_categories_hover_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Categories Hover Color', 'customizer', 'setech'),
                    'default'           => "#000000",
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_fields_hide',
                        'operator'  => '!=',
                        'value'     => 'cats'
                    ),
                    'live_preview'      => array(
                        'trigger_class'     => '.page_title_container .single_post_categories a',
                        'style_to_change'   => 'color',
                    )
                ),
                'title_title_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Title Color', 'customizer', 'setech'),
                    'default'           => '#000',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_fields_hide',
                        'operator'  => '!=',
                        'value'     => 'title'
                    ),
                    'live_preview'      => array(
                        'trigger_class'     => '.page_title_container .page_title',
                        'style_to_change'   => 'color',
                    )
                ),
                'title_meta_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Meta Color', 'customizer', 'setech'),
                    'default'           => 'rgba(0,0,0, .75)',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_fields_hide',
                        'operator'  => '!=',
                        'value'     => 'meta'
                    ),
                    'live_preview'      => array(
                        'trigger_class'     => '.page_title_container .single_post_meta a',
                        'style_to_change'   => 'color',
                    )
                ),
                'title_divider_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Divider Color', 'customizer', 'setech'),
                    'default'           => '#CBCFD4',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_fields_hide',
                        'operator'  => '!=',
                        'value'     => 'divider'
                    ),
                    'live_preview'      => array(
                        'trigger_class'     => '.page_title_container .title_divider',
                        'style_to_change'   => 'background-color',
                    )
                ),
                'title_breadcrumbs_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Breadcrumbs Color', 'customizer', 'setech'),
                    'default'           => 'rgba(0,0,0, .75)',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'    => array(
                        'control'   => 'title_fields_hide',
                        'operator'  => '!=',
                        'value'     => 'breadcrumbs'
                    ),
                    'live_preview'      => array(
                        'trigger_class'     => '.page_title_container .woocommerce-breadcrumb *, .page_title_container .bread-crumbs *',
                        'style_to_change'   => 'color',
                    )
                ),
                'title_mouse_animation' => array(
                    'default'   => true,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Mouse Move Animation', 'customizer', 'setech'),
                ),
                'title_scroll_animation' => array(
                    'default'   => true,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Scroll Animation', 'customizer', 'setech'),
                ),
            )
        ),
        'mobile_menu_section' => array(
            'title'     => esc_html_x('Mobile Menu', 'customizer', 'setech'),
            'layout'    => array(
                'mobile_top_bar_logotype' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Top Bar Logotype', 'customizer', 'setech'),
                    'description'   => esc_html_x('To get a retina logo please upload a double-size image and set the image dimentions to fit the actual logo size.', 'customizer', 'setech'),
                ),
                'mobile_top_bar_logo_dimensions' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Top Bar Logo Dimensions', 'customizer', 'setech'),
                    'choices'       => array(
                        'width'  => array( 
                            'placeholder' => esc_html_x('Width (px)', 'customizer', 'setech'), 
                            'value' => '130px' 
                        ),
                        'height' => array( 
                            'placeholder' => esc_html_x('Height (px)', 'customizer', 'setech'), 
                            'value' => '' 
                        ),
                    ),
                    'separator'     => 'line'
                ),
                'mobile_menu_logotype' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Menu Logotype', 'customizer', 'setech'),
                    'description'   => esc_html_x('To get a retina logo please upload a double-size image and set the image dimentions to fit the actual logo size.', 'customizer', 'setech'),
                ),
                'mobile_menu_logo_dimensions' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Menu Logo Dimensions', 'customizer', 'setech'),
                    'choices'       => array(
                        'width'  => array( 
                            'placeholder' => esc_html_x('Width (px)', 'customizer', 'setech'), 
                            'value' => '130px' 
                        ),
                        'height' => array( 
                            'placeholder' => esc_html_x('Height (px)', 'customizer', 'setech'), 
                            'value' => '' 
                        ),
                    ),
                    'separator'     => 'line'
                ),
                'mobile_show_minicart' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Mini-Cart', 'customizer', 'setech'),
                ),
                'mobile_show_custom_sidebar' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Custom Sidebar', 'customizer', 'setech'),
                ),
                'mobile_menu_spacings' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Spacings', 'customizer', 'setech'),
                    'choices'       => array(
                        'top'  => array( 
                            'placeholder' => esc_html_x('Top (px or %)', 'customizer', 'setech'), 
                            'value' => '13px'
                        ),
                        'bottom' => array( 
                            'placeholder' => esc_html_x('Bottom (px or %)', 'customizer', 'setech'), 
                            'value' => '13px'
                        ),
                    )
                ),
                'mobile_topbar_bg' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Top Bar Background', 'customizer', 'setech'),
                    'default'           => "#fff",
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'live_preview'      => array(
                        'trigger_class'     => '.site-header-mobile .top-bar-box',
                        'style_to_change'   => 'background-color',
                    )
                ),
                'mobile_icons_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Icons Color', 'customizer', 'setech'),
                    'default'           => "#000",
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'live_preview'      => array(
                        'trigger_class'     => '.site-header-mobile .menu-trigger span',
                        'style_to_change'   => 'background-color',
                    )
                ),
                'mobile_menu_font_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Menu Font Color', 'customizer', 'setech'),
                    'default'           => "#000",
                    'sanitize_callback' => 'wp_strip_all_tags',
                ),
                'mobile_accent_font_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Submenu Accent Color', 'customizer', 'setech'),
                    'default'           => "rgba(0,0,0,.75)",
                    'sanitize_callback' => 'wp_strip_all_tags',
                ),
            )
        ),
        'sticky_menu_section' => array(
            'title'     => esc_html_x('Sticky Menu', 'customizer', 'setech'),
            'layout'    => array(
                'sticky_logotype' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Sticky Logo', 'customizer', 'setech'),
                    'description'   => esc_html_x('To get a retina logo please upload a double-size image and set the image dimentions to fit the actual logo size.', 'customizer', 'setech'),
                ),
                'sticky_logo_dimensions' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Sticky Logo Dimensions', 'customizer', 'setech'),
                    'choices'       => array(
                        'width'  => array( 
                            'placeholder' => esc_html_x('Width (px)', 'customizer', 'setech'), 
                            'value' => '130px' 
                        ),
                        'height' => array( 
                            'placeholder' => esc_html_x('Height (px)', 'customizer', 'setech'), 
                            'value' => '' 
                        ),
                    )
                ),
                'sticky_spacings' => array(
                    'type'          => 'multiple_input',
                    'label'         => esc_html_x('Spacings', 'customizer', 'setech'),
                    'choices'       => array(
                        'top'  => array( 
                            'placeholder' => esc_html_x('Top (px or %)', 'customizer', 'setech'), 
                            'value' => '0'
                        ),
                        'bottom' => array( 
                            'placeholder' => esc_html_x('Bottom (px or %)', 'customizer', 'setech'), 
                            'value' => '0'
                        ),
                    )
                ),
                'sticky_shadow' => array(
                    'default'   => true,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Add Shadow', 'customizer', 'setech'),
                ),
                'sticky_shadow_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Shadow Color', 'customizer', 'setech'),
                    'default'           => 'rgba(16,1,148, 0.05)',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'dependency'           => array(
                        'control'   => 'sticky_shadow',
                        'operator'  => '==',
                        'value'     => 'true'
                    ),
                ),
                'sticky_background' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Background Color', 'customizer', 'setech'),
                    'default'           => '#fff',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'live_preview'      => array(
                        'trigger_class'     => '.site-sticky',
                        'style_to_change'   => 'background-color',
                    )
                ),
                'sticky_font_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Font Color', 'customizer', 'setech'),
                    'default'           => "#000",
                    'sanitize_callback' => 'wp_strip_all_tags',
                ),
                'sticky_accent_font_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Font Accent Color', 'customizer', 'setech'),
                    'default'           => PRIMARY_COLOR,
                    'sanitize_callback' => 'wp_strip_all_tags'
                ),
                'custom_sticky' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Sticky Menu Template', 'customizer', 'setech'),
                    'default'       => 'default',
                    'choices'       => array(
                        'default'   => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers,
                    'separator'     => 'line-top',
                    'description'   => esc_html_x('All settings above are applied for default sticky template only', 'customizer', 'setech'),
                )
            )
        ),
        'header_section' => array(
            'title'     => esc_html_x('Custom Header', 'customizer', 'setech'),
            'layout'    => array(
                'custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Custom Header Template', 'customizer', 'setech'),
                    'default'       => 'default',
                    'choices'       => array(
                        'default'   => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers,
                    'description'   => esc_html_x('The following tab settings will be ingnored if custom headers are applied: Top Bar, Logotype, Menu', 'customizer', 'setech'),
                ),
            )
        )
	)
?>