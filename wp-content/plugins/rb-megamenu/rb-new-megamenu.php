<?php
/*
Plugin Name: RB Megamenu
Description: Internal use for rbthemes themes only.
Version:     1.0.0
Author:      Rainbow-Themes
Author URI:  http://rainbow-themes.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: rb-megamenu
*/
if( !defined('ABSPATH') ){
	exit;
}

if ( !class_exists( "RB_Megamenu" ) ){
	class RB_Megamenu {
		public function __construct (){
			add_action( 'init', array( $this, 'rb_megamenu_init' ) );
			add_filter( 'get_terms', array( $this, 'remove_main_menu_from_list' ), 10, 4 );
			add_filter( 'walker_nav_menu_start_el', array( $this, 'start_el_filter' ), 10, 4 );
		}

		public function remove_main_menu_from_list( $terms, $taxonomies, $args, $term_query ) {
            if ( is_admin() && class_exists('Vc_Manager') && 'vc_edit_form' === vc_post_param('action' ) && vc_verify_admin_nonce() ) {
                $theme_location = 'header-menu';
                $locations = get_nav_menu_locations();
                $menuID = $locations[$theme_location];

                $terms_clear = array();

                foreach ( $terms as $term ) {
                    if ( $term->term_id != $menuID ) {
                        $terms_clear[] = $term;
                    }
                }

                return $terms_clear;
            } else {
                return $terms;
            }
        }

		// Megamenu Initialization
		public function rb_megamenu_init() {
			$labels = array(
				'name' 					=> __('RB Megamenu', 'rb_megamenu'),
				'singular_name' 		=> __('Megamenu', 'rb_megamenu'),
				'add_new' 				=> __('Add Megamenu', 'rb_megamenu'),
				'add_new_item' 			=> __('Add New Megamenu', 'rb_megamenu'),
				'edit_item' 			=> __('Edit Megamenu', 'rb_megamenu'),
				'new_item' 				=> __('New Megamenu', 'rb_megamenu'),
				'view_item' 			=> __('View Megamenu', 'rb_megamenu'),
				'search_items' 			=> __('Search Megamenu', 'rb_megamenu'),
				'not_found' 			=> __('No Megamenu found', 'rb_megamenu'),
				'not_found_in_trash' 	=> __('No Megamenu found in Trash', 'rb_megamenu'),
			);

			$args = array(
				'labels' 				=> $labels,
				'public'                => true,
		        'exclude_from_search'   => true,
		        'publicly_queryable'    => false,
		        'menu_icon'             => 'dashicons-editor-kitchensink',
				'show_in_nav_menus' 	=> true,
				'supports' 				=> array( 'title', 'editor' ),
				'pages'					=> false,
				'show_in_rest' 			=> true,
			);
			register_post_type('rb-megamenu', $args);
		}

		public function start_el_filter ( $item_output, $item, $depth, $args ){
            if ( !isset( $item->object ) || $item->object != "rb-megamenu" || !isset( $item->object_id ) ){
                return $item_output;
            }

            $item->classes[] = 'menu-item-has-children';
            
            $post_id = $item->object_id;

            $post_content = get_post($post_id)->post_content;
            $processed_content = do_shortcode( $post_content );

            if( empty($processed_content) ){
                return $item_output;
            }

            $megamenu_item_output = "";
            $walker_class = isset( $args->walker ) && !empty( $args->walker ) ? $args->walker : "Walker_Nav_Menu";
            $walker_instance = new $walker_class();

            $walker_instance->start_lvl( $megamenu_item_output, $depth, $args );

            /*** VC Composer Styles ***/
            $vc_shortcodes_custom_css = get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );
            if ( !empty( $vc_shortcodes_custom_css ) ) {
                $vc_shortcodes_custom_css = preg_replace( "#\.(vc_custom_\d+)#", ".$1", $vc_shortcodes_custom_css );
                $vc_shortcodes_custom_css = strip_tags( $vc_shortcodes_custom_css );
                $vc_shortcodes_styles = $vc_shortcodes_custom_css;

                rb__vc_styles($vc_shortcodes_styles);
            }

            $vc_post_custom_css = get_post_meta( $post_id, '_wpb_post_custom_css', true );
            if ( !empty( $vc_post_custom_css ) ) {
                $vc_post_custom_css = strip_tags( $vc_post_custom_css );
                $vc_post_styles = $vc_post_custom_css;
                
                rb__vc_styles($vc_post_custom_css);
            }
            /***\ VC Composer Styles \***/

            $width = get_post_meta($post_id, '_rb_megamenu_width', true);
            $custom_width = get_post_meta($post_id, '_rb_megamenu_custom_width', true);
            $position = get_post_meta($post_id, '_rb_megamenu_position', true);

            if( $width != 'custom_width' ){
            	$megamenu_extra_atts = "data-width='".esc_attr($width)."'";
            } else {
            	if( !empty($custom_width) ){
            		$megamenu_extra_atts = "data-width='".esc_attr($custom_width)."'";
            	}
            }

            if( $position ){
            	$megamenu_extra_atts .= " data-position='".esc_attr($position)."'";
            } else {
            	$megamenu_extra_atts .= " data-position='depend'";
            }

            $megamenu_item_output .= "<li class='rb_megamenu_item' ".$megamenu_extra_atts.">";
            $megamenu_item_output .= $processed_content;   
            $megamenu_item_output .= "</li>";

            $walker_instance->end_lvl( $megamenu_item_output, $depth, $args );

            return $item_output . $megamenu_item_output; 
        }


	}
}

$megamenu = new RB_Megamenu();

?>