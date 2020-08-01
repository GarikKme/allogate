<?php

function setech_customizer_controls(){
    // Get all exist headers
    $custom_headers = array();
    if( function_exists('rb_hf_init') ){
        $args = array(
            'post_type'         => 'rb-tmpl-header',
            'posts_per_page'    => -1
        );

        $headers = new WP_Query($args);
        foreach ($headers->posts as $header) {
            $custom_headers[$header->ID] = esc_html($header->post_title);
        }
    }

    // Get all exist sticky headers
    $custom_sticky_headers = array();
    if( function_exists('rb_hf_init') ){
        $args = array(
            'post_type'         => 'rb-tmpl-sticky',
            'posts_per_page'    => -1
        );

        $sticky_headers = new WP_Query($args);
        foreach ($sticky_headers->posts as $sticky) {
            $custom_sticky_headers[$sticky->ID] = esc_html($sticky->post_title);
        }
    }

    // Get all exist footers
    $custom_footers = array();
    if( function_exists('rb_hf_init') ){
        $args = array(
            'post_type'         => 'rb-tmpl-footer',
            'posts_per_page'    => -1
        );

        $footers = new WP_Query($args);
        foreach ($footers->posts as $footer) {
            $custom_footers[$footer->ID] = esc_html($footer->post_title);
        }
    }

    class_exists('WooCommerce') ? $woo_panel_layout = require '_woocommerce.php' : $woo_panel_layout = array();
    
    return $customizer_extensions = array(
        'general' => array(
            'title'         => esc_html_x('General', 'customizer', 'setech'),
            'description'   => esc_html_x('General Theme Options', 'customizer', 'setech'),
            'priority'      => 5,
            'layout'        => require '_general.php'
        ),
        'header_panel' => array(
            'title'         => esc_html_x('Header', 'customizer', 'setech'),
            'description'   => esc_html_x('Setech Header Properties', 'customizer', 'setech'),
            'priority'      => 6,
            'layout'        => require '_header.php'
        ),
        'footer_panel' => array(
            'title'         => esc_html_x('Footer', 'customizer', 'setech'),
            'descripton'    => esc_html_x('Setech Footer Properties', 'customizer', 'setech'),
            'priority'      => 7,
            'layout'        => require '_footer.php'
        ),
        'woo_panel' => array(
            'title'         => esc_html_x('Shop', 'customizer', 'setech'),
            'descripton'    => esc_html_x('Setech WooCommerce Shop Properties', 'customizer', 'setech'),
            'priority'      => 8,
            'layout'        => $woo_panel_layout
        )
    );
}

?>