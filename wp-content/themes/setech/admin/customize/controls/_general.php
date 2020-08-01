<?php
    // Get typography props
    $setech_typography_control = array();
    if( function_exists('setech_typography_control') ){
        $setech_typography_control = array_merge(
            setech_typography_control( 'titles', 'Poppins', array('600', '700'), 'latin', '#000000', false, false ),
            setech_typography_control( 'body', 'Poppins', 'regular', 'latin', '#4C4C4D', '15px', '27px' )
        );
    }

    // Set default sidebars
    $default_sidebars = array(
        'blog_sidebar'          => esc_html_x('Blog', 'customizer', 'setech'),
        'blog_single_sidebar'   => esc_html_x('Blog Single', 'customizer', 'setech'),
        'custom_sidebar'        => esc_html_x('Custom Sidebar', 'customizer', 'setech'),
    );
    if( class_exists('WooCommerce') ){
        $default_sidebars['woocommerce'] = esc_html_x('Woocommerce', 'customizer', 'setech');
        $default_sidebars['woocommerce_single'] = esc_html_x('Woocommerce Singe', 'customizer', 'setech');
    }

	return array(
		'colors' => array(
            'title'     => esc_html_x('Theme Colors', 'customizer', 'setech'),
            'layout'    => array(
                'primary_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Theme Color', 'customizer', 'setech'),
                    'default'           => PRIMARY_COLOR,
                    'sanitize_callback' => 'wp_strip_all_tags'
                ),
                'secondary_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Second Color', 'customizer', 'setech'),
                    'default'           => SECONDARY_COLOR,
                    'sanitize_callback' => 'wp_strip_all_tags'
                ),
            )
        ),
        'typography' => array(
            'title'     => esc_html_x('Typography', 'customizer', 'setech'),
            'layout'    => array_merge(
                $setech_typography_control,
                array(
                    'g_fonts_api' => array(
                        'type'          => 'custom-text',
                        'label'         => esc_html_x('Google Fonts Api Key', 'customizer', 'setech'),
                        'transport'     => 'postMessage',
                        'function'      => 'setech_update_fonts',
                        'description'   => esc_html_x('Enter Your Api Key and press Enter', 'customizer', 'setech'),
                        'input_attrs'   => array(
                            'success'   => esc_html_x('Google Fonts updated. Please refresh the page to see the changes', 'customizer', 'setech'),
                            'error'     => esc_html_x('Wrong API Key or Resource is unavailable', 'customizer', 'setech')
                        )
                    )
                )
            )
        ),
        'blog_layout' => array(
            'title'     => esc_html_x('Blog Layout', 'customizer', 'setech'),
            'layout'    => array(
                'blog_view' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Blog layout', 'customizer', 'setech'),
                    'default'   => 'large',
                    'choices'   => array(
                        'large'     => esc_html_x('Large', 'customizer', 'setech'),
                        'grid'      => esc_html_x('Grid', 'customizer', 'setech'),
                        'masonry'   => esc_html_x('Masonry', 'customizer', 'setech'),
                    )
                ),
                'blog_columns' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Blog Columns', 'customizer', 'setech'),
                    'default'   => '2',
                    'choices'   => array(
                        '2' => esc_html_x('2 Columns', 'customizer', 'setech'),
                        '3' => esc_html_x('3 Columns', 'customizer', 'setech'),
                        '4' => esc_html_x('4 Columns', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'blog_view',
                        'operator'  => '!=',
                        'value'     => 'large'
                    )
                ),
                'blog_chars_count' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Crop content', 'customizer', 'setech'),
                    'default'       => '-1',
                    'description'   => esc_html_x('"-1" to SHOW whole content | empty or "0" to HIDE content', 'customizer', 'setech'),
                    'input_attrs'   => array(
                        'min'   => '-1'
                    )
                ),
                'blog_read_more' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Read More Button Title', 'customizer', 'setech'),
                    'default'       => 'Read More',
                ),
                'blog_button_style' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Blog Read More Style', 'customizer', 'setech'),
                    'default'   => 'round',
                    'choices'   => array(
                        'round'     => esc_html_x('Round', 'customizer', 'setech'),
                        'simple'    => esc_html_x('Simple', 'customizer', 'setech'),
                    )
                ),
                'blog_posts_per_page' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Posts Per Page', 'customizer', 'setech'),
                    'default'       => '-1',
                    'description'   => esc_html_x('"-1" to show all posts', 'customizer', 'setech'),
                    'input_attrs'   => array(
                        'min'   => '-1'
                    )
                ),
                'blog_sidebar' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Select sidebar', 'customizer', 'setech'),
                    'default'       => 'blog_sidebar',
                    'choices'       => array_merge( 
                        array(
                            'none'  => esc_html_x('None', 'customizer', 'setech'),
                        ),
                        is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array()
                    ),
                ),
                'blog_sidebar_position' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Sidebar Position', 'customizer', 'setech'),
                    'default'   => 'right',
                    'choices'   => array(
                        'right' => esc_html_x('Right', 'customizer', 'setech'),
                        'left'  => esc_html_x('Left', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'blog_sidebar',
                        'operator'  => '!=',
                        'value'     => 'none'
                    )
                ),
                'blog_single_sidebar' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Select Single sidebar', 'customizer', 'setech'),
                    'default'       => 'blog_single_sidebar',
                    'choices'       => array_merge( 
                        array(
                            'none'  => esc_html_x('None', 'customizer', 'setech'),
                        ),
                        is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array()
                    ),
                ),
                'blog_single_sidebar_position' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Sidebar Single Position', 'customizer', 'setech'),
                    'default'   => 'right',
                    'choices'   => array(
                        'right' => esc_html_x('Right', 'customizer', 'setech'),
                        'left'  => esc_html_x('Left', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'blog_single_sidebar',
                        'operator'  => '!=',
                        'value'     => 'none'
                    )
                ),
                'blog_related' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Related', 'customizer', 'setech'),
                    'separator' => 'line-top'
                ),
                'blog_related_cropp' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Cropped Images', 'customizer', 'setech'),
                ),
                'blog_related_title' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Title', 'customizer', 'setech'),
                    'default'       => 'Related Posts',
                    'dependency'    => array(
                        'control'   => 'blog_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'blog_related_columns' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Related Columns', 'customizer', 'setech'),
                    'default'   => '3',
                    'choices'   => array(
                        '2' => esc_html_x('2 Columns', 'customizer', 'setech'),
                        '3' => esc_html_x('3 Columns', 'customizer', 'setech'),
                        '4' => esc_html_x('4 Columns', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'blog_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'blog_related_items' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Related Items', 'customizer', 'setech'),
                    'default'       => '3',
                    'dependency'    => array(
                        'control'   => 'blog_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'blog_related_pick' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Pick From', 'customizer', 'setech'),
                    'default'       => 'category',
                    'choices'       => array(
                        'category'      => esc_html_x( 'Same Categories', 'customizer', 'setech' ),
                        'tags'          => esc_html_x( 'Same Tags', 'customizer', 'setech' ),
                        'random'        => esc_html_x('Random', 'customizer', 'setech'),
                        'latest'        => esc_html_x( 'Latest', 'customizer', 'setech' ),
                    ),
                    'dependency'    => array(
                        'control'   => 'blog_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'blog_related_text_length' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Text Lenght', 'customizer', 'setech'),
                    'default'       => '90',
                    'dependency'    => array(
                        'control'   => 'blog_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'blog_related_hide' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Hide', 'customizer', 'setech'),
                    'default'       => 'none',
                    'choices'       => array(
                        'none'          => esc_html_x('None', 'customizer', 'setech'),
                        'title'         => esc_html_x( 'Title', 'customizer', 'setech' ),
                        'cats'          => esc_html_x( 'Categories', 'customizer', 'setech' ),
                        'author'        => esc_html_x( 'Author', 'customizer', 'setech' ),
                        'date'          => esc_html_x( 'Date', 'customizer', 'setech' ),
                        'comments'      => esc_html_x( 'Comments', 'customizer', 'setech' ),
                        'share'         => esc_html_x( 'Share', 'customizer', 'setech' ),
                        'featured'      => esc_html_x( 'Featured', 'customizer', 'setech' ),
                        'read_more'     => esc_html_x( 'Read More', 'customizer', 'setech' ),
                        'excerpt'       => esc_html_x( 'Excerpt', 'customizer', 'setech' ),
                    ),
                    'input_attrs'   => array(
                        'multiple'      => true
                    ),
                    'dependency'    => array(
                        'control'       => 'blog_related',
                        'operator'      => '==',
                        'value'         => 'true'
                    )
                ),
                'blog_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Blog', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'blog_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Blog', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'blog_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Blog', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
                'blog_single_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Blog Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'blog_single_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Blog Single', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'blog_single_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Blog Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
            )
        ),
        'page_layout' => array(
            'title'     => esc_html_x('Page Layout', 'customizer', 'setech'),
            'layout'    => array(
                'page_sidebar' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Select sidebar', 'customizer', 'setech'),
                    'default'       => 'none',
                    'choices'       => array_merge( 
                        array(
                            'none'  => esc_html_x('None', 'customizer', 'setech'),
                        ),
                        is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array() 
                    ),
                ),
                'page_sidebar_position' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Sidebar Position', 'customizer', 'setech'),
                    'default'   => 'right',
                    'choices'   => array(
                        'right' => esc_html_x('Right', 'customizer', 'setech'),
                        'left'  => esc_html_x('Left', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'page_sidebar',
                        'operator'  => '!=',
                        'value'     => 'none'
                    )
                ),
            )
        ),
        'portfolio_layout' => array(
            'title'     => esc_html_x('Portfolio Layout', 'customizer', 'setech'),
            'layout'    => array(
                'rb_portfolio_layout' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Layout', 'customizer', 'setech'),
                    'default'       => 'grid',
                    'choices'       => array(
                        'grid'              => esc_html_x( 'Grid', 'customizer', 'setech' ),
                        'masonry'           => esc_html_x( 'Masonry', 'customizer', 'setech' ),
                        'pinterest'         => esc_html_x( 'Pinterest', 'customizer', 'setech' ),
                        'asymmetric'        => esc_html_x( 'Asymmetric', 'customizer', 'setech' ),
                        'carousel'          => esc_html_x( 'Carousel', 'customizer', 'setech' ),
                        'carousel_wide'     => esc_html_x( 'Carousel Wide', 'customizer', 'setech' ),
                        'motion_category'   => esc_html_x( 'Motion Category', 'customizer', 'setech' ),
                    )
                ),
                'rb_portfolio_hover' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Hover', 'customizer', 'setech'),
                    'default'       => 'overlay',
                    'choices'       => array(
                        'overlay'       => esc_html_x( 'Overlay', 'customizer', 'setech' ),
                        'slide_bottom'  => esc_html_x( 'Slide From Bottom', 'customizer', 'setech' ),
                        'slide_left'    => esc_html_x( 'Slide From Left', 'customizer', 'setech' ),
                        'swipe_right'   => esc_html_x( 'Swipe Right', 'customizer', 'setech' ),
                    )
                ),
                'rb_portfolio_orderby' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Order By', 'customizer', 'setech'),
                    'default'       => 'date',
                    'choices'       => array(
                        'date'          => esc_html_x( 'Date', 'customizer', 'setech' ),
                        'menu_order'    => esc_html_x( 'Order ID', 'customizer', 'setech' ),
                        'title'         => esc_html_x( 'Title', 'customizer', 'setech' ),
                    )
                ),
                'rb_portfolio_order' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Order', 'customizer', 'setech'),
                    'default'       => 'DESC',
                    'choices'       => array(
                        'ASC'   => esc_html_x( 'ASC', 'customizer', 'setech' ),
                        'DESC'  => esc_html_x( 'DESC', 'customizer', 'setech' ),
                    )
                ),
                'rb_portfolio_columns' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Columns', 'customizer', 'setech'),
                    'default'       => '4',
                    'choices'       => array(
                        '2' => esc_html_x( '2', 'customizer', 'setech' ),
                        '3' => esc_html_x( '3', 'customizer', 'setech' ),
                        '4' => esc_html_x( '4', 'customizer', 'setech' ),
                        '5' => esc_html_x( '5', 'customizer', 'setech' ),
                        '6' => esc_html_x( '6', 'customizer', 'setech' ),
                    )
                ),
                'rb_portfolio_items_pp' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Items per Page', 'customizer', 'setech'),
                    'default'       => '9',
                ),
                'rb_portfolio_square_img' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Square Images', 'customizer', 'setech'),
                ),
                'rb_portfolio_no_spacing' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Disable Spacings', 'customizer', 'setech'),
                ),
                'rb_portfolio_pagination' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Pagination', 'customizer', 'setech'),
                    'default'       => 'standart',
                    'choices'       => array(
                        'standart'      => esc_html_x( 'Standard', 'customizer', 'setech' ),
                        'load_more'     => esc_html_x( 'Load More', 'customizer', 'setech' ),
                    )
                ),
                'rb_portfolio_hide_meta' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Hide', 'customizer', 'setech'),
                    'default'       => '',
                    'choices'       => array(
                        ''              => esc_html_x( 'None', 'backend', 'setech' ),
                        'title'         => esc_html_x( 'Title', 'backend', 'setech' ),
                        'categories'    => esc_html_x( 'Categories', 'backend', 'setech' ),
                        'tags'          => esc_html_x( 'Tags', 'backend', 'setech' ),
                    )
                ),
                'rb_reset_permalinks' => array(
                    'type'          => 'text',
                    'default'       => 'false',
                ),
                'rb_portfolio_slug' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Slug', 'customizer', 'setech'),
                    'default'       => 'Portfolio Archive',
                ),
                'rb_portfolio_single_slug' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Single Slug', 'customizer', 'setech'),
                    'default'       => 'Portfolio Single',
                ),
                'rb_portfolio_related' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Related', 'customizer', 'setech'),
                    'separator' => 'line-top'
                ),
                'rb_portfolio_related_title' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Title', 'customizer', 'setech'),
                    'default'       => 'Related Projects',
                    'dependency'    => array(
                        'control'   => 'rb_portfolio_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_portfolio_related_hover' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Related Hover', 'customizer', 'setech'),
                    'default'       => 'overlay',
                    'choices'       => array(
                        'overlay'       => esc_html_x( 'Overlay', 'customizer', 'setech' ),
                        'slide_bottom'  => esc_html_x( 'Slide From Bottom', 'customizer', 'setech' ),
                        'slide_left'    => esc_html_x( 'Slide From Left', 'customizer', 'setech' ),
                        'swipe_right'   => esc_html_x( 'Swipe Right', 'customizer', 'setech' ),
                    ),
                    'dependency'    => array(
                        'control'   => 'rb_portfolio_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_portfolio_related_columns' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Related Columns', 'customizer', 'setech'),
                    'default'   => '4',
                    'choices'   => array(
                        '2' => esc_html_x('2 Columns', 'customizer', 'setech'),
                        '3' => esc_html_x('3 Columns', 'customizer', 'setech'),
                        '4' => esc_html_x('4 Columns', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'rb_portfolio_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_portfolio_related_items' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Related Items', 'customizer', 'setech'),
                    'default'       => '4',
                    'dependency'    => array(
                        'control'   => 'rb_portfolio_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_portfolio_related_pick' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Pick From', 'customizer', 'setech'),
                    'default'       => 'category',
                    'choices'       => array(
                        'category'      => esc_html_x( 'Same Categories', 'customizer', 'setech' ),
                        'tags'          => esc_html_x( 'Same Tags', 'customizer', 'setech' ),
                        'random'        => esc_html_x( 'Random', 'customizer', 'setech' ),
                        'latest'        => esc_html_x( 'Latest', 'customizer', 'setech' ),
                    ),
                    'dependency'    => array(
                        'control'   => 'rb_portfolio_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_portfolio_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Portfolio', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'rb_portfolio_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Portfolio', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'rb_portfolio_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Portfolio', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
                'rb_portfolio_single_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Portfolio Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'rb_portfolio_single_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Portfolio Single', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'rb_portfolio_single_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Portfolio Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
            ),
        ),
        'staff_layout' => array(
            'title'     => esc_html_x('Our Team Layout', 'customizer', 'setech'),
            'layout'    => array(
                'rb_staff_order_by' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Order by', 'customizer', 'setech'),
                    'default'       => 'date',
                    'choices'       => array(
                        'date'          => esc_html_x('Date', 'customizer', 'setech'),
                        'menu_order'    => esc_html_x('Order ID', 'customizer', 'setech'),
                        'title'         => esc_html_x('Title', 'customizer', 'setech'),
                    )
                ),
                'rb_staff_order' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Order', 'customizer', 'setech'),
                    'default'       => 'ASC',
                    'choices'       => array(
                        'ASC'   => esc_html_x('ASC', 'customizer', 'setech'),
                        'DESC'  => esc_html_x('DESC', 'customizer', 'setech'),
                    )
                ),
                'rb_staff_columns' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Columns', 'customizer', 'setech'),
                    'default'       => '3',
                    'choices'       => array(
                        '2' => esc_html_x('2', 'customizer', 'setech'),
                        '3' => esc_html_x('3', 'customizer', 'setech'),
                        '4' => esc_html_x('4', 'customizer', 'setech'),
                    )
                ),
                'rb_staff_items_pp' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Items per Page', 'customizer', 'setech'),
                    'default'       => '9',
                ),
                'rb_staff_hide_meta' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Hide', 'customizer', 'setech'),
                    'default'       => '',
                    'choices'       => array(
                        ''              => esc_html_x( 'None', 'customizer', 'setech' ),
                        'photo'         => esc_html_x( 'Photo', 'customizer', 'setech' ),
                        'name'          => esc_html_x( 'Name', 'customizer', 'setech' ),
                        'position'      => esc_html_x( 'Position', 'customizer', 'setech' ),
                        'department'    => esc_html_x( 'Department', 'customizer', 'setech' ),
                        'experience'    => esc_html_x( 'Experience', 'customizer', 'setech' ),
                        'email'         => esc_html_x( 'Email', 'customizer', 'setech' ),
                        'phone'         => esc_html_x( 'Phone Number', 'customizer', 'setech' ),
                        'socials'       => esc_html_x( 'Socials', 'customizer', 'setech' ),
                        'biography'     => esc_html_x( 'Biography', 'customizer', 'setech' ),
                        'info'          => esc_html_x( 'Personal Info', 'customizer', 'setech' ),
                    ),
                    'input_attrs'   => array(
                        'multiple'      => true
                    )
                ),
                'rb_staff_sidebar' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Select sidebar', 'customizer', 'setech'),
                    'default'       => 'none',
                    'choices'       => array_merge( 
                        array(
                            'none'  => esc_html_x('None', 'customizer', 'setech'),
                        ),
                        is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array() 
                    ),
                ),
                'rb_staff_sidebar_position' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Sidebar Position', 'customizer', 'setech'),
                    'default'   => 'right',
                    'choices'   => array(
                        'right' => esc_html_x('Right', 'customizer', 'setech'),
                        'left'  => esc_html_x('Left', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'rb_staff_sidebar',
                        'operator'  => '!=',
                        'value'     => 'none'
                    )
                ),
                'rb_staff_slug' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Slug', 'customizer', 'setech'),
                    'default'       => 'Our Team Archive',
                ),
                'rb_staff_single_accent_background' => array(
                    'type'          => 'wp_image',
                    'label'         => esc_html_x('Single Accent Background', 'customizer', 'setech'),
                ),
                'rb_staff_single_slug' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Single Slug', 'customizer', 'setech'),
                    'default'       => 'Our Team Single',
                ),
                'rb_staff_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Staff', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'rb_staff_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Staff', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'rb_staff_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Staff', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
                'rb_staff_single_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Staff Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'rb_staff_single_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Staff Single', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'rb_staff_single_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Staff Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
            )
        ),
        'case_study_layout' => array(
            'title'     => esc_html_x('Case Study Layout', 'customizer', 'setech'),
            'layout'    => array(
                'rb_case_study_orderby' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Order By', 'customizer', 'setech'),
                    'default'       => 'date',
                    'choices'       => array(
                        'date'          => esc_html_x( 'Date', 'customizer', 'setech' ),
                        'menu_order'    => esc_html_x( 'Order ID', 'customizer', 'setech' ),
                        'title'         => esc_html_x( 'Title', 'customizer', 'setech' ),
                    )
                ),
                'rb_case_study_order' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Order', 'customizer', 'setech'),
                    'default'       => 'DESC',
                    'choices'       => array(
                        'ASC'   => esc_html_x( 'ASC', 'customizer', 'setech' ),
                        'DESC'  => esc_html_x( 'DESC', 'customizer', 'setech' ),
                    )
                ),
                'rb_case_study_columns' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Columns', 'customizer', 'setech'),
                    'default'       => '3',
                    'choices'       => array(
                        '2' => esc_html_x( '2', 'customizer', 'setech' ),
                        '3' => esc_html_x( '3', 'customizer', 'setech' ),
                        '4' => esc_html_x( '4', 'customizer', 'setech' ),
                    )
                ),
                'rb_case_study_items_pp' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Items per Page', 'customizer', 'setech'),
                    'default'       => '9',
                ),
                'rb_case_study_chars_count' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Content Chars Count', 'customizer', 'setech'),
                    'default'       => '50',
                ),
                'rb_case_study_button_text' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('More Button Text', 'customizer', 'setech'),
                    'default'       => 'Read More',
                ),
                'rb_case_study_slug' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Slug', 'customizer', 'setech'),
                    'default'       => 'Case Studies Archive',
                ),
                'rb_case_study_related' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Related', 'customizer', 'setech'),
                    'separator' => 'line-top'
                ),
                'rb_case_study_related_title' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Title', 'customizer', 'setech'),
                    'default'       => 'Related Projects',
                    'dependency'    => array(
                        'control'   => 'rb_case_study_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_case_study_related_columns' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Related Columns', 'customizer', 'setech'),
                    'default'   => '4',
                    'choices'   => array(
                        '2' => esc_html_x('2 Columns', 'customizer', 'setech'),
                        '3' => esc_html_x('3 Columns', 'customizer', 'setech'),
                        '4' => esc_html_x('4 Columns', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'rb_case_study_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_case_study_related_items' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Related Items', 'customizer', 'setech'),
                    'default'       => '4',
                    'dependency'    => array(
                        'control'   => 'rb_case_study_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_case_study_related_pick' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Pick From', 'customizer', 'setech'),
                    'default'       => 'category',
                    'choices'       => array(
                        'category'      => esc_html_x( 'Same Categories', 'customizer', 'setech' ),
                        'tags'          => esc_html_x( 'Same Tags', 'customizer', 'setech' ),
                        'random'        => esc_html_x( 'Random', 'customizer', 'setech' ),
                        'latest'        => esc_html_x( 'Latest', 'customizer', 'setech' ),
                    ),
                    'dependency'    => array(
                        'control'   => 'rb_case_study_related',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'rb_case_study_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Case Study', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'rb_case_study_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Case Study', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'rb_case_study_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Case Study', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
                'rb_case_study_single_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Case Study Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'rb_case_study_single_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Case Study Single', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'rb_case_study_single_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Case Study Single', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
            )
        ),
        'sidebars' => array(
            'title'     => esc_html_x('Sidebars', 'customizer', 'setech'),
            'layout'    => array(
                'theme_sidebars' => array(
                    'type'          => 'repeater',
                    'label'         => esc_html_x('Sidebars', 'customizer', 'setech'),
                    'add_label'     => esc_html_x('Add New', 'customizer', 'setech'),
                    'save_label'    => esc_html_x('Apply', 'customizer', 'setech'),
                    'default'       => $default_sidebars,
                ),
            )
        ),
        'site_layout' => array(
            'title'     => esc_html_x('Site Layout', 'customizer', 'setech'),
            'layout'    => array(
                'sticky_sidebars' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Sticky Sidebars', 'customizer', 'setech'),
                ),
                'boxed_layout' => array(
                    'default'   => false,
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Apply Boxed Layout', 'customizer', 'setech'),
                ),
                'boxed_bg_color' => array(
                    'type'              => 'alpha-color',
                    'label'             => esc_html_x('Content Background', 'customizer', 'setech'),
                    'default'           => '#fff',
                    'sanitize_callback' => 'wp_strip_all_tags',
                    'live_preview'      => array(
                        'trigger_class'     => 'body[data-boxed="true"] .site.wrap',
                        'style_to_change'   => 'background-color',
                    ),
                    'dependency'    => array(
                        'control'   => 'boxed_layout',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
            )
        ),
        'social_share' => array(
            'title'     => esc_html_x('Social Share', 'customizer', 'setech'),
            'layout'    => array(
                'social_share_links' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Share to:', 'customizer', 'setech'),
                    'default'       => 'none',
                    'choices'       => array(
                        'none'          => esc_html_x('None', 'customizer', 'setech'),
                        'add.this'      => esc_html_x('Add.this', 'customizer', 'setech'),
                        'blogger'       => esc_html_x('Blogger', 'customizer', 'setech'),
                        'buffer'        => esc_html_x('Buffer', 'customizer', 'setech'),
                        'diaspora'      => esc_html_x('Diaspora', 'customizer', 'setech'),
                        'digg'          => esc_html_x('Digg', 'customizer', 'setech'),
                        'douban'        => esc_html_x('Douban', 'customizer', 'setech'),
                        'evernote'      => esc_html_x('Evernote', 'customizer', 'setech'),
                        'getpocket'     => esc_html_x('Getpocket', 'customizer', 'setech'),
                        'facebook'      => esc_html_x('Facebook', 'customizer', 'setech'),
                        'flipboard'     => esc_html_x('Flipboard', 'customizer', 'setech'),
                        'instapaper'    => esc_html_x('Instapaper', 'customizer', 'setech'),
                        'line.me'       => esc_html_x('Line.me', 'customizer', 'setech'),
                        'linkedin'      => esc_html_x('Linkedin', 'customizer', 'setech'),
                        'livejournal'   => esc_html_x('LiveJournal', 'customizer', 'setech'),
                        'hacker.news'   => esc_html_x('Hacker.news', 'customizer', 'setech'),
                        'ok.ru'         => esc_html_x('Ok.ru', 'customizer', 'setech'),
                        'pinterest'     => esc_html_x('Pinterest', 'customizer', 'setech'),
                        'qzone'         => esc_html_x('Qzone', 'customizer', 'setech'),
                        'reddit'        => esc_html_x('Reddit', 'customizer', 'setech'),
                        'skype'         => esc_html_x('Skype', 'customizer', 'setech'),
                        'tumblr'        => esc_html_x('Tumblr', 'customizer', 'setech'),
                        'twitter'       => esc_html_x('Twitter', 'customizer', 'setech'),
                        'vk'            => esc_html_x('Vk', 'customizer', 'setech'),
                        'weibo'         => esc_html_x('Weibo', 'customizer', 'setech'),
                        'xing'          => esc_html_x('Xing', 'customizer', 'setech'),
                    ),
                    'input_attrs'   => array(
                        'multiple'      => true,
                        'size'          => 20
                    ),
                )
            )
        ),
        'sidebars' => array(
            'title'     => esc_html_x('Sidebars', 'customizer', 'setech'),
            'layout'    => array(
                'theme_sidebars' => array(
                    'type'          => 'repeater',
                    'label'         => esc_html_x('Sidebars', 'customizer', 'setech'),
                    'add_label'     => esc_html_x('Add New', 'customizer', 'setech'),
                    'save_label'    => esc_html_x('Apply', 'customizer', 'setech'),
                    'default'       => $default_sidebars,
                ),
            )
        ),
        'purchase_code' => array(
            'title'     => esc_html_x('Purchase Code', 'customizer', 'setech'),
            'layout'    => array(
                'envato_purchase_code_setech' => array(
                    'type'          => 'text',
                    'setting_type'  => 'option',
                    'label'         => esc_html_x('Please enter your purchase code', 'customizer', 'setech'),
                    'default'       => '',
                ),
            )
        ),
        'help' => array(
            'title'     => esc_html_x('Help', 'customizer', 'setech'),
            'layout'    => array(
                'documentation' => array(
                    'type'          => 'link',
                    'label'         => esc_html_x('Documentation', 'customizer', 'setech'),
                    'default'       => 'https://'.get_option('stylesheet').'.rainbow-themes.net/manual',
                    'input_attrs'   => array(
                        'icon'  => 'dashicons-welcome-widgets-menus'
                    )
                ),
                'tutorial' => array(
                    'type'      => 'link',
                    'label'     => esc_html_x('Video Tutorial', 'customizer', 'setech'),
                    'default'   => 'https://www.youtube.com/channel/UCvT8BgvBtxOSeGFcw-zNlFA',
                    'input_attrs'   => array(
                       'icon'  => 'dashicons-format-video'
                    )
                ),
            )
        )
	);
?>