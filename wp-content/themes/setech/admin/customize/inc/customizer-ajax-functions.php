<?php 

/**
 * The helper function that will used to
 * get choosen font with AJAX and load it
 *
 * @return  ajax
 */ 
function load_g_fonts(){
    if( isset($_POST['new_key']) && !empty($_POST['new_key']) ){
        global $wp_filesystem;

        if( empty( $wp_filesystem ) ) {
            require_once( ABSPATH .'/wp-admin/includes/file.php' );
            WP_Filesystem();
        }
        $file = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.$_POST['new_key'];

        if ( $wp_filesystem && $wp_filesystem->exists($file) ) {
            $content = $wp_filesystem->get_contents($file);
        } else {
            wp_die();
        }

        $g_fonts = json_decode($g_fonts_json, true);

        if( !empty($g_fonts['items']) ){
            update_option('rb_g_fonts', $g_fonts);
            echo 'success';
        } else if( $g_fonts == null || isset($g_fonts['error']) ){
            echo 'error';
        }
    }

    wp_die();
}
add_action( 'wp_ajax_load_g_fonts', 'load_g_fonts' );
add_action( 'wp_ajax_nopriv_load_g_fonts', 'load_g_fonts' );


/**
 * The helper function that will used to
 * get choosen font-weights with AJAX
 *
 * @return  ajax
 */ 
function dynamic_font_weights(){
    if( isset($_POST['weights']) && !empty($_POST['weights']) ){

    	$count = 0; //It needs for right options order after JSON.parse
        $isset_weight = array( '100', '100italic', '200', '200italic', '300', '300italic', '400', '400italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic' );

        foreach( $isset_weight as $weight ){
            if( stristr($_POST['weights'], $weight) ){
                $font_weight[$count.'-'.$weight] = str_replace('00', '00 ', $weight);
            }

            $count ++;
        }

        echo json_encode($font_weight);
    }

    wp_die();
}
add_action( 'wp_ajax_dynamic_font_weights', 'dynamic_font_weights' );
add_action( 'wp_ajax_nopriv_dynamic_font_weights', 'dynamic_font_weights' );


/**
 * The helper function that will used to
 * get choosen font-subsets with AJAX
 *
 * @return  ajax
 */ 
function dynamic_font_subsets(){
    if( isset($_POST['subsets']) && !empty($_POST['subsets']) ){
        $g_fonts = setech_get_google_fonts();

        foreach( $g_fonts['items'] as $key => $font ){
            if( $_POST['subsets'] == $font['family'] ){
                echo json_encode($font['subsets']);
            }
        }
    }

    wp_die();
}
add_action( 'wp_ajax_dynamic_font_subsets', 'dynamic_font_subsets' );
add_action( 'wp_ajax_nopriv_dynamic_font_subsets', 'dynamic_font_subsets' );

?>