<?php
    return array(
        'woo_general' => array(
            'title'     => esc_html_x('General', 'customizer', 'setech'),
            'layout'    => array(
                'woo_cart' => array(
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Show Cart', 'customizer', 'setech'),
                    'default'   => false
                ),
                'woocommerce_mini_cart' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Mini Cart View', 'customizer', 'setech'),
                    'default'   => 'sidebar-view',
                    'choices'   => array(
                        'popup-view' => esc_html_x('Popup', 'customizer', 'setech'),
                        'sidebar-view'  => esc_html_x('Sidebar', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'woo_cart',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'woo_archive_cols' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Shop Columns', 'customizer', 'setech'),
                    'default'   => '3',
                    'choices'   => array(
                        '2' => esc_html_x('2 Columns', 'customizer', 'setech'),
                        '3' => esc_html_x('3 Columns', 'customizer', 'setech'),
                        '4' => esc_html_x('4 Columns', 'customizer', 'setech'),
                    )
                ),
                'woo_archive_count' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Show Products per Page', 'customizer', 'setech'),
                    'default'       => '9',
                    'input_attrs'   => array(
                        'min'   => '2'
                    )
                ),
                'woo_tag_lifetime' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Lifetime of the "New" badge', 'customizer', 'setech'),
                    'description'   => esc_html_x('In days', 'customizer', 'setech'),
                    'default'       => '14'
                ),
                'woo_pagination' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Pagination Type', 'customizer', 'setech'),
                    'default'   => 'default',
                    'choices'   => array(
                        'default'   => esc_html_x('Default', 'customizer', 'setech'),
                        'click'     => esc_html_x('Load More on Click', 'customizer', 'setech'),
                        'scroll'    => esc_html_x('Load More on Scroll', 'customizer', 'setech'),
                    )
                ),
                'woo_slug' => array(
                    'type'          => 'text',
                    'label'         => esc_html_x('Slug', 'customizer', 'setech'),
                    'default'       => 'Shop',
                ),
                'woo_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for WooCommerce', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'woo_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for WooCommerce', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'woo_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for WooCommerce', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
            )
        ),
        'woo_sidebar' => array(
            'title'     => esc_html_x('Sidebar', 'customizer', 'setech'),
            'layout'    => array(
                'woocommerce_sidebar' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Shop Sidebar', 'customizer', 'setech'),
                    'default'       => 'woocommerce',
                    'choices'       => array_merge( 
                        array(
                            'none'  => esc_html_x('None', 'customizer', 'setech'),
                        ),
                        is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array()
                    ),
                ),
                'woocommerce_sidebar_position' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Shop Sidebar Position', 'customizer', 'setech'),
                    'default'   => 'left',
                    'choices'   => array(
                        'right' => esc_html_x('Right', 'customizer', 'setech'),
                        'left'  => esc_html_x('Left', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'woocommerce_sidebar',
                        'operator'  => '!=',
                        'value'     => 'none'
                    )
                ),
                'woocommerce_single_sidebar' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Product Details Sidebar', 'customizer', 'setech'),
                    'default'       => 'woocommerce_single',
                    'choices'       => array_merge( 
                        array(
                            'none'  => esc_html_x('None', 'customizer', 'setech'),
                        ),
                        is_array(get_theme_mod('theme_sidebars')) ? get_theme_mod('theme_sidebars') : array()
                    ),
                ),
                'woocommerce_single_sidebar_position' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Product Details Sidebar Position', 'customizer', 'setech'),
                    'default'   => 'right',
                    'choices'   => array(
                        'right' => esc_html_x('Right', 'customizer', 'setech'),
                        'left'  => esc_html_x('Left', 'customizer', 'setech'),
                    ),
                    'dependency'    => array(
                        'control'   => 'woocommerce_single_sidebar',
                        'operator'  => '!=',
                        'value'     => 'none'
                    )
                ),
            )
        ),
        'woo_single' => array(
            'title'     => esc_html_x('Product Details', 'customizer', 'setech'),
            'layout'    => array(
                'woo_gallery_thumbnails_count' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Quantity of visible gallery thumbnails', 'customizer', 'setech'),
                    'default'       => '3',
                    'input_attrs'   => array(
                        'min'   => '2'
                    )
                ),
                'woo_related_cols' => array(
                    'type'      => 'radio',
                    'label'     => esc_html_x('Related Columns', 'customizer', 'setech'),
                    'default'   => '3',
                    'choices'   => array(
                        '2' => esc_html_x('2 Columns', 'customizer', 'setech'),
                        '3' => esc_html_x('3 Columns', 'customizer', 'setech'),
                        '4' => esc_html_x('4 Columns', 'customizer', 'setech'),
                    )
                ),
                'woo_related_count' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Related Products per Page', 'customizer', 'setech'),
                    'default'       => '6'
                ),
                'related_products_carousel' => array(
                    'type'      => 'checkbox',
                    'label'     => esc_html_x('Enable related carousel', 'customizer', 'setech'),
                    'default'   => true
                ),
                'related_products_slides_to_scroll' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Slides to scroll', 'customizer', 'setech'),
                    'default'       => '1',
                    'dependency'    => array(
                        'control'   => 'related_products_carousel',
                        'operator'  => '==',
                        'value'     => 'true'
                    ),
                ),
                'related_products_autoplay_speed' => array(
                    'type'          => 'number',
                    'label'         => esc_html_x('Autoplay speed', 'customizer', 'setech'),
                    'description'   => esc_html_x('Delay in seconds. Enter "0" to disable autoplay', 'customizer', 'setech'),
                    'default'       => '3',
                    'input_attrs'   => array(
                        'min'   => '0'
                    ),
                    'dependency'    => array(
                        'control'   => 'related_products_carousel',
                        'operator'  => '==',
                        'value'     => 'true'
                    )
                ),
                'woo_single_custom_header' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Header Template for Product', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'separator'     => 'line-top',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Custom Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_headers
                ),
                'woo_single_custom_sticky_header' => array(
                    'type'           => 'select',
                    'label'          => esc_html_x('Sticky Template for Product', 'customizer', 'setech'),
                    'default'        => 'inherit',
                    'choices'        => array(
                        'inherit'       => esc_html_x('Inherit from Sticky Header', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_sticky_headers
                ),
                'woo_single_custom_footer' => array(
                    'type'          => 'select',
                    'label'         => esc_html_x('Footer Template for Product', 'customizer', 'setech'),
                    'default'       => 'inherit',
                    'choices'       => array(
                        'inherit'       => esc_html_x('Inherit from Footer Appearance', 'customizer', 'setech'),
                        'default'       => esc_html_x('Default', 'customizer', 'setech'),
                    ) + $custom_footers
                ),
            )
        ),
    );
?>