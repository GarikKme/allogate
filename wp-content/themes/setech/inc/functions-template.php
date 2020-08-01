<?php
defined( 'ABSPATH' ) or die();

/**
 * An action callback to display the comments list and
 * comment form
 * 
 * @return  void
 * @since   1.0.0
 */
function setech__comments_list() {
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		return;
	}
	
	// If comments are open or we have at least one comment, load up the comment template.
	if ( is_singular() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
}


/**
 * An action callback to display the related posts content
 * at the bottom of the page.
 * 
 * @return  void
 * @since   1.0.0
 */
function setech__related_posts() {
	if ( is_single() ) {
		get_template_part( 'tmpl/post/content-related' );
	}
}


/**
 * The helper function to show the pagination bar
 * on the blog pages
 * 
 * @param   WP_Query  $query  The custom query
 * @param   $max_posts  Maximum posts will be shown
 * @param   $posts_per_page  Posts per each page
 * @return  void
 * @since   1.0.0
 */
function setech__pagination( $query = null, $max_posts = '', $posts_per_page = '', $type = 'standart', $custom_max_num_pages = '' ) {
	global $wp_query;

	if ( !( $query instanceOf WP_Query ) )
		$query = &$wp_query;

	if( empty($custom_max_num_pages) ){
		if( !empty($max_posts) && !empty($posts_per_page) ){
			$max_num_pages = ceil((float)($max_posts / $posts_per_page));
			$max_num_pages = $max_num_pages > $query->max_num_pages ? $query->max_num_pages : $max_num_pages;
		} else {
			$max_num_pages = $query->max_num_pages;
		}
	} else {
		$max_num_pages = $custom_max_num_pages;
	}

	// Don't print empty markup if there's only one page.
	if ( $max_num_pages < 2 ) return;

	if ( is_page_template() )
		$paged = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
	else
		$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );
	$out 		  = '';

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	// Set up paginated links.
	$links = paginate_links( array(
		'total'    	=> $max_num_pages,
		'current'  	=> $paged,
		'mid_size' 	=> 1,
		'add_args' 	=> array_map( 'urlencode', $query_args ),
		'prev_text' => '',
		'next_text' => '',
	) );
	
	if( !empty($links) ){
		$out .= '<nav class="paging-navigation '.$type.'">';
			$out .= '<div class="pagination loop-pagination">';
				$out .= $type != 'standart' ? '<div class="rb_button rb_load_more">'.esc_html_x( 'Load More', 'frontend', 'setech' ).'</div>' : $links;
			$out .='</div>';
		$out .= '</nav>';
	}

	echo sprintf('%s', $out);
}

/**
 * The helper function which get the site breadcrumbs
 * 
 * @return  void
 * @since   1.0.0
 */
function setech__dimox_breadcrumbs(){
	/* === OPTIONS === */
	$text['home']	 = esc_html__( 'Home', 'setech' ); // text for the 'Home' link
	$text['category'] = esc_html__( 'Archive by Category "%s"', 'setech' ); // text for a category page
	$text['search']   = esc_html__( 'Search for "%s"', 'setech' ); // text for a search results page
	$text['taxonomy'] = esc_html__( 'Archive by %s "%s"', 'setech' );
	$text['tag']	  = esc_html__( 'Posts Tagged "%s"', 'setech' ); // text for a tag page
	$text['author'] = esc_html__( 'Articles Posted by %s', 'setech' ); // text for an author page
	$text['404']	  = esc_html__( 'Error 404', 'setech' ); // text for the 404 page

	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_on_404   	= 0; // 1 - show breadcrumbs on the 404, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title	 = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter	  = "<span class='delimiter'></span>";
	$before		 = '<span class="current">'; // tag before the current crumb
	$after		  = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link	= esc_url( home_url( '/' ) );
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr	= ' property="v:title"';
	$link		 = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	if ( isset( $post->post_parent ) ) {
		$parent_id	= $parent_id_2 = $post->post_parent;
	}

	$frontpage_id = get_option( 'page_on_front' );

	if ( ! $show_on_404 && is_404() ) {
		return;
	}

	if ( is_home() || is_front_page() || (empty( $post )) ) {

		if ( $show_on_home == 1 ) {
			echo '<nav class="bread-crumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></nav>'; }
	} else {

		echo '<nav class="bread-crumbs">';
		if ( $show_home_link == 1 ) {
			echo '<a href="' . $home_link . '" property="v:title">' . $text['home'] . '</a>';
			if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) { echo sprintf("%s", $delimiter ); }
		}

		if ( is_category() ) {
			$cat = get_category( get_query_var( 'cat' ) );
			$cat_name = isset( $cat->name ) ? $cat->name : '';
			$parent_cats = array();
			$has_parent_cat = false;
			$temp_cat = $cat;
			while ( true ) {
				if ( isset( $temp_cat->parent ) && $temp_cat->parent ) {
					array_push( $parent_cats, $temp_cat->parent );
					$temp_cat = get_category( $temp_cat->parent );
				} else {
					break;
				}
			}
			$parent_cats = array_reverse( $parent_cats );
			for ( $i = 0; $i < count( $parent_cats ); $i++ ) {
				$cur_cat_obj = get_category( $parent_cats[ $i ] );
				$cur_cat_name = isset( $cur_cat_obj->name ) ? $cur_cat_obj->name : '';
				if ( ! empty( $cur_cat_name ) && isset( $cur_cat_obj->term_id ) ) {
					$cur_cat_link = get_category_link( $cur_cat_obj->term_id );
					if($has_parent_cat){
						echo sprintf("%s", $delimiter);
					}
					printf( $link, $cur_cat_link, $cur_cat_name );
					$has_parent_cat = true;
				}
			}
			if ( $show_current == 1 ) {
				if($has_parent_cat){
					echo sprintf("%s", $delimiter);
				}
				echo sprintf("%s", $before) . sprintf( $text['category'], $cat_name );
			}
		} elseif ( is_tag() ) {
			echo sprintf("%s", $before) . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo sprintf("%s", $before) . esc_html( sprintf( $text['author'], $userdata->display_name ) ) . $after;

		} elseif ( is_day() ) {
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
			echo sprintf( $link, get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
			echo sprintf("%s", $before) . get_the_time( 'd' ) . $after;

		} elseif ( is_month() ) {
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
			echo sprintf("%s", $before) . get_the_time( 'F' ) . $after;

		} elseif ( is_year() ) {
			echo sprintf("%s", $before) . get_the_time( 'Y' ) . $after;

		} elseif ( has_post_format() && ! is_singular() ) {
			echo get_post_format_string( get_post_format() );
		} else if ( is_tax( array( 'rb_case_study_tag', 'rb_case_study_cat', 'rb_portfolio_tag', 'rb_portfolio_cat', 'rb_staff_member_department', 'rb_staff_member_position' ) ) ) {
			$tax_slug = get_query_var( 'taxonomy' );
			$term_slug = get_query_var( $tax_slug );
			$tax_obj = get_taxonomy( $tax_slug );
			$term_obj = get_term_by( 'slug', $term_slug, $tax_slug );
			$parent_terms = array();
			$has_parent_term = false;
			if ( isset( $tax_obj->hierarchical ) && $tax_obj->hierarchical ) {
				$temp_term_obj = $term_obj;
				while ( true ) {
					if ( isset( $temp_term_obj->parent ) && $temp_term_obj->parent ) {
						array_push( $parent_terms, $temp_term_obj->parent );
						$temp_term_obj = get_term_by( 'id', $temp_term_obj->parent, $tax_slug );
					} else {
						break;
					}
				}
				$parent_terms = array_reverse( $parent_terms );
				for ( $i = 0; $i < count( $parent_terms ); $i++ ) {
					$cur_term = get_term_by( 'id', $parent_terms[ $i ], $tax_slug );
					$cur_term_name = isset( $cur_term->name ) ? $cur_term->name : '';
					if ( ! empty( $cur_term_name ) && isset( $cur_term->term_id ) ) {
						$cur_term_link = get_term_link( $cur_term->term_id, $tax_slug );
						if($has_parent_term){
							echo sprintf("%s", $delimiter);
						}
						printf( $link, $cur_term_link, $cur_term_name );
						$has_parent_term = true;
					}
				}
			}
			if ( $show_current == 1 ) {
				$singular_tax_label = isset( $tax_obj->labels ) && isset( $tax_obj->labels->singular_name ) ? $tax_obj->labels->singular_name : '';
				$term_name = isset( $term_obj->name ) ? $term_obj->name : '';
				if($has_parent_term){
					echo sprintf("%s", $delimiter);
				}
				echo sprintf("%s", $before) . esc_html( sprintf( $text['taxonomy'], $singular_tax_label, $term_name ) );
			}
		} elseif ( is_archive() ) {
			if ( $show_current ) {
				$post_type = get_post_type();
				$post_type_obj = get_post_type_object( $post_type );

				if( $post_type == 'rb_case_study' || $post_type == 'rb_portfolio' || $post_type == 'rb_staff' ){
					$post_type_name = get_theme_mod($post_type.'_slug');
				}

				if( empty($post_type_name) ){
					$post_type_name = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
				}

				echo sprintf("%s", $before) . esc_html($post_type_name) . $after;
			}
		} elseif ( is_search() ) {
			echo sprintf("%s", $before) . sprintf( $text['search'], get_search_query() ) . $after;
		} elseif ( is_single() ) {
			$post_type = get_post_type();
			$post_type_obj = get_post_type_object( $post_type );

			if( $post_type == 'rb_case_study' || $post_type == 'rb_portfolio' || $post_type == 'rb_staff' ){
				$post_type_label = get_theme_mod($post_type.'_slug');
			} 

			if( empty($post_type_label) ){
				$post_type_label = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
			}

			$post_type_link = get_post_type_archive_link( $post_type );
			if ( $post_type_obj->has_archive ) {
				printf( $link, $post_type_link, $post_type_label  );
				echo sprintf("%s", $delimiter);
			}

			$page_title = get_the_title();
			$page_title = wp_kses( $page_title, array(
				"b"			=> array(),
				"em"		=> array(),
				"sup"		=> array(),
				"sub"		=> array(),
				"strong"	=> array(),
				"mark"		=> array(),
				"br"		=> array()
			));

			if ( $show_current ) { echo sprintf("%s", $before) . get_the_title() . $after; }
		} elseif ( is_page() && ! $parent_id ) {
			echo sprintf("%s", $before) . esc_html(get_the_title()) . $after;
		} elseif ( is_page() && $parent_id ) {
			if ( $parent_id != $frontpage_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					if ( $parent_id != $frontpage_id ) {
						$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), esc_html(get_the_title($page->ID)) );
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo sprintf("%s", $breadcrumbs[ $i ]);
					if ( $i != count( $breadcrumbs ) -1 ) { echo sprintf("%s", $delimiter); }
				}
			}
			if ( $show_current == 1 ) {
				if ( $show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id) ) { echo sprintf("%s", $delimiter); }
				echo sprintf("%s", $before) . esc_html(get_the_title()) . $after;
			}
		} elseif ( is_404() ) {
			echo sprintf("%s", $before) . esc_html($text['404']) . $after;
		}

		if ( get_query_var( 'paged' ) ) {
			echo sprintf("%s", $delimiter) . esc_html__( 'Page', 'setech' ) . ' ' . get_query_var( 'paged' );
		}
		echo '</nav><!-- .breadcrumbs -->';
	}
}

/**
 * The helper function which get the specified sidebar
 * 
 * @return  void
 * @since   1.0.0
 */
function setech__get_sidebar( $id = null, $custom_sidebar = '', $custom_sidebar_pos = '', $extra_class = '', $show_empty = false ){
	if( get_post_type(get_the_ID()) == 'rb_case_study' && $show_empty == false )
		return;

	$page_type = 'page';
	$sidebar = null;
	$out = '';

	if( $id ){
		$post_type = get_post_type($id);

		switch ($post_type){
			case 'page':
				$page_type = 'page';
				break;
			case 'post':
				if( is_single() ){
					$page_type = 'blog_single';
				} else {
					$page_type = 'blog';
				}
				break;
			case 'rb_staff':
				$page_type = 'rb_staff';
				break;
			case 'rb_portfolio':
				$page_type = 'rb_portfolio';
				break;
			case 'rb_case_study':
				$page_type = 'rb_case_study';
				break;
			case 'attachment':
				$page_type = 'blog';
				break;
		}
	}

	if( is_home() || is_category() || is_archive() ) $page_type = 'blog';
	if( is_front_page() && !is_home() ) $page_type = null;

	if( class_exists('WooCommerce') ){
		if( is_woocommerce() && is_archive() ){
			$page_type = 'woocommerce';
		} elseif( is_woocommerce() && is_single() ){
			$page_type = 'woocommerce_single';
		}
	}

	ob_start();
	dynamic_sidebar( get_theme_mod($page_type.'_sidebar') );
	$check_sidebar = ob_get_clean();

	if( !empty($custom_sidebar) && $custom_sidebar != 'default' ){
		ob_start();
		dynamic_sidebar( $custom_sidebar );
		$check_sidebar = ob_get_clean();
	}

	if( $custom_sidebar_pos == 'default' || empty($custom_sidebar_pos) ){
		$custom_sidebar_pos = get_theme_mod($page_type.'_sidebar_position');
	} else {
		$custom_sidebar_pos = $custom_sidebar_pos;
	}

	if( !empty($check_sidebar) ){
		$out = '<aside class="sidebar position_'.esc_attr($custom_sidebar_pos).' '.(!empty($extra_class) ? $extra_class : '').'">';
			$out .= '<i class="close_sidebar"></i>';
			$out .= $check_sidebar;
		$out .= '</aside>';
	} else if( empty($check_sidebar) && !empty($custom_sidebar) && $show_empty == true ){
		$out = '<aside class="sidebar position_'.esc_attr($custom_sidebar_pos).' '.(!empty($extra_class) ? $extra_class : '').'">';
			$out .= '<p class="empty_custom_sb_title">'.esc_html_x('Fill the custom sidebar or choose anouther one.', 'frontend', 'setech').'</p>';
		$out .= '</aside>';
	}

	return $out;
}