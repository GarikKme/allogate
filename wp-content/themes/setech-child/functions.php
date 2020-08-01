<?php

add_action( 'after_setup_theme', 'rb_child_theme_setup' );
function rb_child_theme_setup() {
    load_child_theme_textdomain( 'setech', get_stylesheet_directory() . '/languages' );
}

?>
