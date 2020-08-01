<?php

function rb_setup_metaboxes(){

    // Sidebar properties for metaboxes
    $all_sidebars = array();
    $sidebars = get_theme_mod('theme_sidebars');
    $choosen_sidebar = rb_get_metabox('page_sidebar');

    foreach( $sidebars as $k => $v ){
        $all_sidebars[$k] = $v;
    }

    // Staff Taxonomies for metaboxes
    $departments = $positions = array();

    $terms = get_terms( array(
        'taxonomy'      => 'rb_staff_member_department',
        'hide_empty'    => false
    ) );

    foreach( $terms as $term ){
        $term = (array)$term;

        $departments[$term['name']] = $term['name'];
    }

    $terms = get_terms( array(
        'taxonomy'      => 'rb_staff_member_position',
        'hide_empty'    => false
    ) );

    foreach( $terms as $term ){
        $term = (array)$term;
        $positions[$term['name']] = $term['name'];
    }

    // Custom metaboxes properties
    $metaboxes = array(
        /* ----------> Post Metaboxes <---------- */
        'format_gallery' => array(
            'type'          => 'gallery',
            'title'         => esc_html_x('Choose Gallery', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'gallery'
            )
        ),
        'format_link_title' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Link Title', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'link'
            )
        ),
        'format_link_url' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Link Url', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'link'
            )
        ),
        'format_quote' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Quote', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'quote'
            )
        ),
        'format_quote_author' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Quote Author', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'quote'
            )
        ),
        'format_video' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Video URL', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'video'
            )
        ),
        'format_audio' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Audio URL', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'side',
            'priority'      => 'high',
            'dependency'    => array(
                'field'         => 'post_format',
                'operator'      => '==',
                'value'         => 'audio'
            )
        ),
        'related_blog_posts' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Related Shortcode', 'backend', 'setech'),
            'description'   => esc_html_x('To create a custom related posts layout please generate the needed shortcode using Blog module and insert the generated shortcode into this field. Or type in "none" to disable related posts.', 'backend', 'setech'),
            'screen'        => 'post',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        /* ----------> Common Metaboxes <---------- */
        'page_sidebar' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Select Sidebar', 'backend', 'setech'),
            'screen'        => array('page', 'post', 'product', 'rb_staff', 'rb_portfolio'),
            'context'       => 'side',
            'priority'      => 'low',
            'input_attr'    => array_merge(
                array(
                    'default'   => esc_html_x('Default', 'backend', 'setech'),
                    'none'      => esc_html_x('None', 'backend', 'setech'),
                ),
                $all_sidebars
            )
        ),
        'sidebar_pos' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Sidebar Position', 'backend', 'setech'),
            'screen'        => array('page', 'post', 'product', 'rb_staff', 'rb_portfolio'),
            'context'       => 'side',
            'priority'      => 'low',
            'input_attr'    => array(
                'default'       => esc_html_x('Default', 'backend', 'setech'),
                'left'          => esc_html_x('Left', 'backend', 'setech'),
                'right'         => esc_html_x('Right', 'backend', 'setech'),
            )
        ),
        'title_image' => array(
            'type'          => 'image',
            'title'         => esc_html_x('Header Image', 'backend', 'setech'),
            'screen'        => array('post', 'page', 'product', 'rb_staff', 'rb_portfolio', 'rb_case_study'),
            'context'       => 'side',
            'priority'      => 'low'
        ),
        'title_interactive_image' => array(
            'type'          => 'image',
            'title'         => esc_html_x('Header Interactive Image', 'backend', 'setech'),
            'screen'        => array('post', 'page', 'product', 'rb_staff', 'rb_portfolio', 'rb_case_study'),
            'context'       => 'side',
            'priority'      => 'low'
        ),
        'title_interactive_remove' => array(
            'type'          => 'checkbox',
            'title'         => esc_html_x('Remove Interactive Image', 'backend', 'setech'),
            'screen'        => array('post', 'page', 'product', 'rb_staff', 'rb_portfolio', 'rb_case_study'),
            'context'       => 'side',
            'priority'      => 'low'
        ),
        /* ----------> Shop Metaboxes <---------- */
        'product_slides_count' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Slides to show in product gallery', 'backend', 'setech'),
            'screen'        => 'product',
            'context'       => 'side',
            'priority'      => 'low'
        ),
        /* ----------> Page Metaboxes <---------- */
        'slider_shortcode' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Main Slider Shortcode', 'backend', 'setech'),
            'screen'        => 'page',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        /* ----------> Staff Metaboxes <---------- */
        'staff_experience' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Experience', 'backend', 'setech'),
            'screen'        => 'rb_staff',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        'staff_email' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Email', 'backend', 'setech'),
            'screen'        => 'rb_staff',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        'staff_phone' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Phone Number', 'backend', 'setech'),
            'screen'        => 'rb_staff',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        'staff_biography' => array(
            'type'          => 'textarea',
            'title'         => esc_html_x('Biography', 'backend', 'setech'),
            'screen'        => 'rb_staff',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        'staff_socials' => array(
            'type'          => 'repeater',
            'title'         => esc_html_x('Socials', 'backend', 'setech'),
            'screen'        => 'rb_staff',
            'context'       => 'normal',
            'priority'      => 'high',
            'button'        => esc_html_x('Add new social network', 'backend', 'setech'),
            'fields'        => array(
                'social_title' => array(
                    'type'  => 'text',
                    'title' => esc_html_x('Social account title', 'backend', 'setech'),
                ),
                'social_url' => array(
                    'type'  => 'text',
                    'title' => esc_html_x('Social account URL', 'backend', 'setech'),
                ),
                'social_icon' => array(
                    'type'  => 'icon',
                    'title' => esc_html_x('Social account Icon', 'backend', 'setech'),
                ),
            )
        ),
        /* ----------> Portfolio Metaboxes <---------- */
        'portfolio_type' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Portfolio Type', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'side',
            'priority'      => 'high',
            'input_attr'    => array(
                'large_images'  => esc_html_x('Large Images', 'backend', 'setech'),
                'large_slider'  => esc_html_x('Large Slider', 'backend', 'setech'),
                'small_images'  => esc_html_x('Small Images', 'backend', 'setech'),
                'small_slider'  => esc_html_x('Small Slider', 'backend', 'setech'),
                'gallery'       => esc_html_x('Gallery', 'backend', 'setech'),
                'small_masonry' => esc_html_x('Small Masonry', 'backend', 'setech'),
                'large_masonry' => esc_html_x('Large Masonry', 'backend', 'setech'),
                'custom_layout' => esc_html_x('Custom Layout', 'backend', 'setech'),
            )
        ),
        'portfolio_gallery_template' => array(
            'type'          => 'radio',
            'title'         => esc_html_x('Gallery Template', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'side',
            'priority'      => 'high',
            'format'        => 'image',
            'input_attr'    => array(
                'grid_1'        => 'grid_1.png',
                'grid_2'        => 'grid_2.png',
                'grid_3'        => 'grid_3.png',
                'grid_4'        => 'grid_4.png',
                'grid_5'        => 'grid_5.png',
                'grid_6'        => 'grid_6.png',
                'grid_7'        => 'grid_7.png',
            ),
            'dependency'    => array(
                'field'         => 'portfolio_type',
                'operator'      => '==',
                'value'         => 'custom_layout'
            )
        ),
        'portfolio_gallery' => array(
            'type'          => 'gallery',
            'title'         => esc_html_x('Gallery', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'side',
            'priority'      => 'high',
        ),
        'portfolio_client' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Client', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'side',
            'priority'      => 'high'
        ),
        'portfolio_author' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Author', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'side',
            'priority'      => 'high'
        ),
        'portfolio_masonry_width' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Masonry Width', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'normal',
            'description'   => esc_html_x('This option is used in the Isotope Portfolio Layout only. The image will take the selected number of columns and will be displayed accordingly.', 'backend', 'setech'),
            'priority'      => 'high',
            'input_attr'    => array(
                '1' => esc_html_x('One', 'backend', 'setech'),
                '2' => esc_html_x('Two', 'backend', 'setech'),
                '3' => esc_html_x('Three', 'backend', 'setech'),
                '4' => esc_html_x('Four', 'backend', 'setech'),
                '5' => esc_html_x('Five', 'backend', 'setech'),
                '6' => esc_html_x('Six', 'backend', 'setech'),
            )
        ),
        'portfolio_masonry_height' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Masonry Height', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'normal',
            'description'   => esc_html_x('This option is used in the Isotope Portfolio Layout only. The image will take the selected number of lines and will be displayed accordingly.', 'backend', 'setech'),
            'priority'      => 'high',
            'input_attr'    => array(
                '1' => esc_html_x('One', 'backend', 'setech'),
                '2' => esc_html_x('Two', 'backend', 'setech'),
                '3' => esc_html_x('Three', 'backend', 'setech'),
                '4' => esc_html_x('Four', 'backend', 'setech'),
                '5' => esc_html_x('Five', 'backend', 'setech'),
                '6' => esc_html_x('Six', 'backend', 'setech'),
            )
        ),
        'related_portfolio_posts' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Related Shortcode', 'backend', 'setech'),
            'description'   => esc_html_x('To create a custom related portfolio layout please generate the needed shortcode using Portfolio module and insert the generated shortcode into this field. Or type in "none" to disable related portfolio posts.', 'backend', 'setech'),
            'screen'        => 'rb_portfolio',
            'context'       => 'normal',
            'priority'      => 'high'
        ),
        /* ----------> Case Study Metaboxes <---------- */
        'case_logo_image' => array(
            'type'          => 'image',
            'title'         => esc_html_x('Case Logo', 'backend', 'setech'),
            'screen'        => 'rb_case_study',
            'context'       => 'side',
            'priority'      => 'high'
        ),
        'case_logo_title' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Case Logo Title', 'backend', 'setech'),
            'screen'        => 'rb_case_study',
            'context'       => 'side',
            'priority'      => 'high'
        ),
        /* ----------> Header Metaboxes <---------- */
        'header_absolute' => array(
            'type'          => 'checkbox',
            'title'         => esc_html_x('Menu and logo overlays title area and homepage slider', 'backend', 'setech'),
            'description'   => esc_html_x('This option will force the menu and logo sections to overlay the title area. It is useful when using transparent menu.', 'backend', 'setech'),
            'screen'        => 'rb-tmpl-header',
            'context'       => 'side',
            'priority'      => 'low'
        ),
        /* ----------> Megamenu Metaboxes <---------- */
        'megamenu_width' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Megamenu Width', 'backend', 'setech'),
            'screen'        => 'rb-megamenu',
            'context'       => 'side',
            'priority'      => 'low',
            'input_attr'    => array(
                'content_width'     => esc_html_x('Content Width', 'backend', 'setech'),
                'full_width'        => esc_html_x('Full Width', 'backend', 'setech'),
                'custom_width'      => esc_html_x('Custom Width', 'backend', 'setech'),
            )
        ),
        'megamenu_custom_width' => array(
            'type'          => 'text',
            'title'         => esc_html_x('Megamenu Custom Width', 'backend', 'setech'),
            'description'   => esc_html_x('Please, enter value with unit ( px / % / vw )', 'backend', 'setech'),
            'screen'        => 'rb-megamenu',
            'context'       => 'side',
            'priority'      => 'low',
            'dependency'    => array(
                'field'         => 'megamenu_width',
                'operator'      => '==',
                'value'         => 'custom_width'
            ),
        ),
        'megamenu_position' => array(
            'type'          => 'select',
            'title'         => esc_html_x('Megamenu Position', 'backend', 'setech'),
            'screen'        => 'rb-megamenu',
            'context'       => 'side',
            'priority'      => 'low',
            'dependency'    => array(
                'field'         => 'megamenu_width',
                'operator'      => '==',
                'value'         => 'content_width'
            ),
            'input_attr'    => array(
                'depend'        => esc_html_x('Depend By Parent', 'backend', 'setech'),
                'center'        => esc_html_x('Always Center', 'backend', 'setech'),
            )
        ),
    );

    return $metaboxes;
}

?>