<?php

function rb_vc_shortcode_sc_blog ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"post_tax"					=> "",
		"orderby"					=> "date",
		"order"						=> "DESC",
		"layout"					=> "large",
		"enable_masonry"			=> false,
		"enable_carousel"			=> false,
		"post_hide_meta_override"	=> false,
		"post_hide_meta"			=> "",
		"total_items_count"			=> "-1",
		"items_pp"					=> get_theme_mod("blog_posts_per_page"),
		"chars_count"				=> get_theme_mod('blog_chars_count'),
		"more_btn_text"				=> get_theme_mod('blog_read_more'),
		"el_class"					=> "",
		/* -----> STYLING TAB <----- */
		"hover_animate"				=> false,
		"customize_size"			=> false,
		"title_size"				=> "24px",
		"title_lh"					=> "31px",
		"background_color"			=> "#fff",
		"title_color"				=> "#000",
		"text_color"				=> "#4C4C4D",
		"accent_color"				=> PRIMARY_COLOR,
		"meta_color"				=> "#000",
		"active_dot"				=> PRIMARY_COLOR,
		"arrows_color"				=> PRIMARY_COLOR,
		'button_type'				=> 'round',
		"btn_font_color"			=> '#fff',
		"btn_font_color_hover"		=> '#fff',
		"btn_bg_color"				=> PRIMARY_COLOR,
		"btn_bg_color_hover"		=> PRIMARY_COLOR,
		"btn_border_color"			=> PRIMARY_COLOR,
		"btn_border_color_hover"	=> PRIMARY_COLOR,
	);

	$responsive_vars = array(
 		/* -----> RESPONSIVE TABS <----- */
 		"all" => array(
 			"custom_styles"		=> "",
 		),
	);

	$responsive_defaults = add_responsive_suffix($responsive_vars);
	$defaults = array_merge($defaults, $responsive_defaults);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = $tax_query = $count = "";
	$id = uniqid( "rb_blog_" );
	$total_items_count = $total_items_count == '-1' ? 999 : $total_items_count;
	if( $layout == 'def' ){
		$layout = get_theme_mod('blog_view') == 'large' ? '1' : get_theme_mod('blog_columns');	
	}

	/* -----> Visual Composer Responsive styles <----- */
	list( $vc_desktop_class, $vc_landscape_class, $vc_portrait_class, $vc_mobile_class ) = vc_responsive_styles($atts);

	preg_match("/(?<=\{).+?(?=\})/", $vc_desktop_class, $vc_desktop_styles); 
	$vc_desktop_styles = implode($vc_desktop_styles);

	preg_match("/(?<=\{).+?(?=\})/", $vc_landscape_class, $vc_landscape_styles);
	$vc_landscape_styles = implode($vc_landscape_styles);

	preg_match("/(?<=\{).+?(?=\})/", $vc_portrait_class, $vc_portrait_styles);
	$vc_portrait_styles = implode($vc_portrait_styles);

	preg_match("/(?<=\{).+?(?=\})/", $vc_mobile_class, $vc_mobile_styles);
	$vc_mobile_styles = implode($vc_mobile_styles);

	/* -----> Customize default styles <----- */
	if( !empty($vc_desktop_styles) ){
		$styles .= "
			#".$id."{
				".$vc_desktop_styles."
			}
		";
	}
	if( $customize_size ){
		if( !empty($title_size) ){
			$styles .= "
				#".$id." .post-title{
					font-size: ".esc_attr($title_size).";
				}
			";
		}
		if( !empty($title_lh) ){
			$styles .= "
				#".$id." .post-title{
					line-height: ".esc_attr($title_lh).";
				}
			";
		}
	}
	if( !empty($background_color) ){
		$styles .= "
			#".$id." .post-inner{
				background-color: ".esc_attr($background_color).";
			}
		";
	}
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .post-title a{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id." .post-content{
				color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($accent_color) ){
		$styles .= "
			#".$id." .post-date a:before,
			#".$id." .post-meta-wrapper .coments_count a:before,
			#".$id." .post-meta-wrapper .social-share a{
				color: ".esc_attr($accent_color).";
			}
			#".$id." .blog_grid .content_inner .post .post-inner .post-meta-wrapper:before{
				background-color: ".esc_attr($accent_color).";
			}
		";
	}
	if( !empty($meta_color) ){
		$styles .= "
			#".$id." .post-meta-wrapper a{
				color: ".esc_attr($meta_color).";
			}
		";
		if( $layout != '2' && $layout != '3' && $layout != '4' ){
			$styles .= "
				#".$id." .post-categories a{
					color: ".esc_attr($meta_color).";
				}
			";
		}
	}
	if( $enable_carousel ){
		if( !empty($active_dot) ){
			$styles .= "
				#".$id." .slick-dots li.slick-active button{
					border-color: ".esc_attr($active_dot).";
				}
			";
		}
		if( !empty($arrows_color) ){
			$styles .= "
				#".$id." .rb_carousel .slick-arrow{
					color: ".esc_attr($arrows_color).";
				}
			";
		}
	}
	if( !empty($btn_font_color) ){
		$styles .= "
			#".$id." .rb_button{
				color: ".esc_attr($btn_font_color).";	
			}
		";
	}
	if( !empty($btn_bg_color) ){
		$styles .= "
			#".$id." .rb_button{
				background-color: ".esc_attr($btn_bg_color).";	
			}
		";
	}
	if( !empty($btn_border_color) ){
		$styles .= "
			#".$id." .rb_button{
				border-color: ".esc_attr($btn_border_color).";	
			}
		";
	}
	$styles .= "
		@media 
			screen and (min-width: 1367px),
			screen and (min-width: 1200px) and (any-hover: hover),
			screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0),
			screen and (min-width: 1200px) and (-ms-high-contrast: none),
			screen and (min-width: 1200px) and (-ms-high-contrast: active)
		{
	";

		if( !empty($btn_font_color_hover) ){
			$styles .= "
				#".$id." .rb_button.arrow_fade_in:hover span:after,
				#".$id." .rb_button:hover{
					color: ".esc_attr($btn_font_color_hover).";
				}
			";
		}
		if( !empty($btn_bg_color_hover) ){
			$styles .= "
				#".$id." .rb_button:hover{
					background-color: ".esc_attr($btn_bg_color_hover).";
				}
			";
		}
		if( !empty($btn_border_color_hover) ){
			$styles .= "
				#".$id." .rb_button:hover{
					border-color: ".esc_attr($btn_border_color_hover).";
				}
			";
		}

	$styles .= "
		}
	";
	/* -----> End of default styles <----- */

	/* -----> Customize landscape styles <----- */
	if( !empty($vc_landscape_styles) ){
		$styles .= "
			@media 
				screen and (max-width: 1199px),
				screen and (max-width: 1366px) and (any-hover: none)
			{
				#".$id."{
					".$vc_landscape_styles.";
				}
			}
		";
	}
	/* -----> End of landscape styles <----- */

	/* -----> Customize portrait styles <----- */
	if( !empty($vc_portrait_styles) ){
		$styles .= "
			@media screen and (max-width: 991px){
				#".$id."{
					".$vc_portrait_styles.";
				}
			}
		";
	}
	/* -----> End of portrait styles <----- */

	/* -----> Customize mobile styles <----- */
	if( !empty($vc_mobile_styles) ){
		$styles .= "
			@media screen and (max-width: 767px){
				#".$id."{
					".$vc_mobile_styles.";
				}
			}
		";
	}
	/* -----> End of mobile styles <----- */

	rb__vc_styles($styles);

	/* -----> Filter by Titles, Category, Tags, Formats <----- */
	if( 
		( $atts['post_tax'] == 'category' && !empty($atts['post_category_terms']) ) ||
		( $atts['post_tax'] == 'post_tag' && !empty($atts['post_post_tag_terms']) ) ||
		( $atts['post_tax'] == 'post_format' && !empty($atts['post_post_format_terms']) )
	){
		$tax_query = array(
			array(
				"taxonomy"	=> $atts['post_tax'],
				"field"		=> "slug",
				"operator"	=> "IN"
			)
		);

		if( $atts['post_tax'] == 'category' ){
			$terms = $atts['post_category_terms'];
			$tax_query[0]['terms'] = strripos($terms, ',') ? explode(',', $terms) : $terms;
		} else if( $atts['post_tax'] == 'post_tag' ){
			$terms = $atts['post_post_tag_terms'];
			$tax_query[0]['terms'] = strripos($terms, ',') ? explode(',', $terms) : $terms;
		} else if( $atts['post_tax'] == 'post_format' ){
			$terms = $atts['post_post_format_terms'];
			$tax_query[0]['terms'] = strripos($terms, ',') ? explode(',', $terms) : $terms;
		}
	}

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;


	$query_atts = array(
		'post_type'				=> 'post',
		'post_status'			=> 'publish',
		'posts_per_page'		=> $items_pp,
		'paged'					=> $paged,
		'tax_query'				=> $tax_query,
		'orderby'				=> $orderby,
		'order'					=> $order,
		'ignore_sticky_posts'	=> true
	);

	if( !empty($atts['post_tax']) && $atts['post_tax'] == 'title' && !empty($atts['titles']) ){
		$query_atts['post__in'] = explode(',', $atts['titles']);
	}

	$carousel_atts = 'data-columns='.esc_attr($layout).'';
	$carousel_atts .= $layout > 2 ? ' data-tablet-portrait=2' : '';
	$carousel_atts .= ' data-pagination=on';
	$carousel_atts .= ' data-navigation=on';
	$carousel_atts .= ' data-auto-height=on';
	$carousel_atts .= ' data-draggable=on';

	/* -----> Blog module output <----- */
	$q = new WP_Query( $query_atts );

	if ( $q->have_posts() ):
		ob_start();

		echo "<div id='".$id."' class='rb_blog_module_wrapper".($hover_animate ? ' animate' : '')."'>";

			echo '<div class="blog layout_'.$layout.'">';
				echo '<div class="content_inner '.($enable_masonry ? 'masonry' : '').'" data-columns="'.$layout.'">';

					if( $enable_carousel ){
						echo '<div class="rb_carousel_wrapper" '.esc_attr($carousel_atts).'>';
							echo '<div class="rb_carousel">';
					}

					while( $q->have_posts() && $count < $total_items_count ):
						$q->the_post(); 

						$extra_class = 'post';
						$extra_class .= ' button_'.esc_attr($button_type);
					?>
						<div id="post-<?php the_ID() ?>" <?php post_class( $extra_class ) ?>>
							<div class="post-inner">
								<?php if( !empty(setech__post_featured( $post_hide_meta )) ) : ?>
									<div class="post-media-wrapper">
										<!-- Featured Media -->
										<?php echo setech__post_featured( $post_hide_meta, false, $layout ) ?>

										<!-- Post Date -->
										<?php setech__post_date( $post_hide_meta, 'simple' ) ?>
									</div>
								<?php endif; ?>
								
								<div class='post-information'>
									<!-- Post Title -->
									<?php setech__post_title( $post_hide_meta ) ?>

									<?php if( !empty(setech__the_content()) ) : ?>
										<!-- Post Content -->
										<div class="post-content"><?php echo setech__the_content($chars_count, $more_btn_text, $post_hide_meta) ?></div>
									<?php endif; ?>

									<!-- Post Meta -->
									<?php setech__post_meta($post_hide_meta) ?>
								</div>
							</div>
						</div>
					<?php $count++; endwhile;

					if( $enable_carousel ){
							echo '</div>';
						echo '</div>';
					}

				echo '</div>';
			echo '</div>';

			if( !$enable_carousel ) setech__pagination( $q, $total_items_count, $items_pp );

		echo "</div>";

		wp_reset_postdata();
		$out .= ob_get_clean();
	endif;

	return $out;
}
add_shortcode( 'rb_sc_blog', 'rb_vc_shortcode_sc_blog' );

?>