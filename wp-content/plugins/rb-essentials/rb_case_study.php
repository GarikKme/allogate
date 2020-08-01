<?php

add_action( "init", "register_rb_case_study_cat", 7 );
add_action( "init", "register_rb_case_study_tag", 8 );
add_action( "init", "register_rb_case_study", 9 );

function register_rb_case_study (){
	$rewrite_slug = rb_get_slug('rb_case_study');

	$labels = array(
		'name' => esc_html_x( 'Case Study', 'backend', 'setech' ),
		'singular_name' => esc_html_x( 'Case Study Item', 'backend', 'setech' ),
		'menu_name' => esc_html_x( 'Case Study', 'backend', 'setech' ),
		'add_new' => esc_html_x( 'Add New', 'backend', 'setech' ),
		'add_new_item' => esc_html_x( 'Add New Case Study Item', 'backend', 'setech' ),
		'edit_item' => esc_html_x('Edit Case Study Item', 'backend', 'setech' ),
		'new_item' => esc_html_x( 'New Case Study Item', 'backend', 'setech' ),
		'view_item' => esc_html_x( 'View Case Study Item', 'backend', 'setech' ),
		'search_items' => esc_html_x( 'Search Case Study Item', 'backend', 'setech' ),
		'not_found' => esc_html_x( 'No Case Study Items found', 'backend', 'setech' ),
		'not_found_in_trash' => esc_html_x( 'No Case Study Items found in Trash', 'backend', 'setech' ),
		'parent_item_colon' => '',
	);

	register_post_type( 'rb_case_study', array(
		'label' => esc_html_x( 'Case Study items', 'backend', 'setech' ),
		'labels' => $labels,
		'public' => true,
		'rewrite' => array( 'slug' => $rewrite_slug ),
		'capability_type' => 'post',
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'page-attributes',
			'thumbnail'
		),
		'menu_position' => 24,
		'menu_icon' => 'dashicons-list-view',
		'taxonomies' => array( 'rb_case_study_cat' ),
		'has_archive' => true,
		'show_in_rest' => true
	));
}

function register_rb_case_study_cat(){
	$rewrite_slug = rb_get_slug('rb_case_study');

	register_taxonomy( 'rb_case_study_cat', 'rb_case_study', array(
		'hierarchical' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => $rewrite_slug . '-category' ),
		'show_in_rest' => true
	));
}

function register_rb_case_study_tag(){
	$rewrite_slug = rb_get_slug('rb_case_study');

	register_taxonomy( 'rb_case_study_tag', 'rb_case_study', array(
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => $rewrite_slug . '-tag' ),
		'show_tagcloud' => false,
		'show_in_rest' => true
	));
}

//Add case_study orders
function add_case_study_order_column( $columns ) {
  $columns['menu_order'] = "Order";
  return $columns;
}
add_action('manage_edit-rb_case_study_columns', 'add_case_study_order_column');

//Show case_study order on 'edit all' page
function show_case_study_order_column($name){
  global $post;
  switch ($name) {
    case 'menu_order':
      $order = $post->menu_order;
      echo $order;
      break;
   default:
      break;
   }
}
add_action('manage_rb_case_study_posts_custom_column', 'show_case_study_order_column');

//Show case_study thumbnails on 'edit all' page
function add_rb_case_study_thumb_name ($columns) {
	$columns = array_slice($columns, 0, 1, true) +
				array('rb_case_study_thumbnail' => esc_html_x('Thumbnails', 'backend', 'setech')) +
				array_slice($columns, 1, NULL, true);
	return $columns;
}
add_filter('manage_rb_case_study_posts_columns', 'add_rb_case_study_thumb_name');

function add_rb_case_study_thumb ($column, $id) {
	if ('rb_case_study_thumbnail' === $column) {
		echo the_post_thumbnail('thumbnail');
	}
}
add_action('manage_rb_case_study_posts_custom_column', 'add_rb_case_study_thumb', 5, 2);