<?php

function rb_vc_shortcode_sc_case_study ( $atts = array(), $content = "" ){
	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"tax"							=> "",
		"orderby"						=> get_theme_mod('rb_case_study_orderby'),
		"order"							=> get_theme_mod('rb_case_study_order'),
		"columns"						=> get_theme_mod('rb_case_study_columns'),
		"total_items_count"				=> "-1",
		"items_pp"						=> get_theme_mod('rb_case_study_items_pp'),
		"chars_count"					=> get_theme_mod('rb_case_study_chars_count'),
		"more_btn_text"					=> get_theme_mod('rb_case_study_button_text'),
		"related_query"					=> "",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"hover_animate"					=> false,
		"title_color"					=> "#000",
		"text_color"					=> 'rgba(0,0,0, .75)',
		"divider_color"					=> '#DADCE2',
		"btn_font_color"				=> '#000',
		"btn_font_color_hover"			=> '#fff',
		"btn_bg_color"					=> "#fff",
		"btn_bg_color_hover"			=> PRIMARY_COLOR,
		"btn_border_color"				=> "#DADCE2",
		"btn_border_color_hover"		=> PRIMARY_COLOR,
		"background_color"				=> "#fff",
		"shadow_color"					=> "rgba(0,0,0,.05)",
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
	$out = $styles = $vc_desktop_class = $vc_landscape_class = $vc_portrait_class = $vc_mobile_class = "";
	$total_items_count = $total_items_count == '-1' ? 999 : $total_items_count;
	$terms_temp = $all_terms = array();
	$terms = isset( $atts[ $tax . "_terms" ] ) ? $atts[ $tax . "_terms" ] : "";
	$id = uniqid( "rb_case_study_" );
	$count = 0;

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
	if( !empty($title_color) ){
		$styles .= "
			#".$id." .rb_case_study_wrapper .rb_case_study h5{
				color: ".esc_attr($title_color).";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id." .rb_case_study_wrapper .rb_case_study .case-study-content{
				color: ".esc_attr($text_color).";
			}
		";
	}
	if( !empty($divider_color) ){
		$styles .= "
			#".$id." .rb_case_study_wrapper .rb_case_study .case-study-content:before{
				background-color: ".esc_attr($divider_color).";
			}
		";
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
	if( !empty($background_color) ){
		$styles .= "
			#".$id." .rb_case_study_wrapper .rb_case_study{
				background-color: ".esc_attr($background_color).";
			}
		";
	}
	if( !empty($shadow_color) ){
		$styles .= "
			#".$id." .rb_case_study_wrapper .rb_case_study{
				-webkit-box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
				-moz-box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
				box-shadow: 0px 0px 35px 0px ".esc_attr($shadow_color).";
			}
		";
	}
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

	/* -----> Formating Filter By Query <----- */
	$terms = explode(",", $terms);

	foreach( $terms as $term ){
		if( !empty($term) ) $terms_temp[] = $term;
	}

	$all_terms_temp = !empty($tax) ? get_terms($tax) : array();
	$all_terms_temp = !is_wp_error($all_terms_temp) ? $all_terms_temp : array();

	foreach( $all_terms_temp as $term ){
		$all_terms[] = $term->slug;
	}

	$terms = !empty($terms_temp) ? $terms_temp : $all_terms;

	/* -----> Filter by Titles, Category, Tags, Formats <----- */
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

	$query_atts = array(
		'post_type'				=> 'rb_case_study',
		'post_status'			=> 'publish',
		'posts_per_page'		=> $items_pp,
		'paged'					=> $paged,
		'ignore_sticky_posts'	=> true,
	);

	if( !empty($related_query) ){
		$related_query_atts = array();
		$query_atts['post__not_in'] = array(get_the_ID());

		if( $related_query == 'category' ){
			$single_terms = rb_get_taxonomy_links('rb_case_study_cat', '', 'backend', get_the_ID());

			if( !empty($single_terms) ){
				$related_query_atts['tax_query'] = array(
					array(
						'taxonomy'	=> 'rb_case_study_cat',
						'field'		=> 'slug',
						'terms'		=> $single_terms
					)
				);
			} else {
				$related_query_atts['orderby'] = 'rand';
			}
		} else if( $related_query == 'tags' ){
			$single_terms = rb_get_taxonomy_links('rb_case_study_tag', '', 'backend', get_the_ID());

			if( !empty($single_terms) ){
				$related_query_atts['tax_query'] = array(
					array(
						'taxonomy'	=> 'rb_case_study_tag',
						'field'		=> 'slug',
						'terms'		=> $single_terms
					)
				);
			} else {
				$related_query_atts['orderby'] = 'rand';
			}
		} else if( $related_query == 'random' ){
			$related_query_atts['orderby'] = 'rand';
		} else if( $related_query == 'latest' ){
			$related_query_atts['order'] = 'DESC';
			$related_query_atts['orderby'] = 'date';
		}

		$query_atts = array_merge($query_atts, $related_query_atts);
	} else {
		$query_atts['orderby'] = $orderby;
		$query_atts['order'] = $order;
		
		if( !empty($terms) && $tax != 'title' ){
			$query_atts['tax_query'] = array(
				array(
					'taxonomy'		=> $tax,
					'field'			=> 'slug',
					'terms'			=> $terms
				)
			);
		} else if( !empty($tax) && $tax == 'title' ){
			$query_atts['post__in'] = explode(',', $atts['titles']);
		}
	}

	/* -----> Case Study module output <----- */
	$q = new WP_Query( $query_atts );

	if( $q->have_posts() ):
		ob_start();

		echo "<div id='".$id."' class='rb_case_study_module".($hover_animate ? ' animate' : '')."'>";

			echo '<div class="rb_case_study_wrapper columns_'.$columns.'">';
				while( $q->have_posts() && $count < $total_items_count ):
					$q->the_post(); 
				?>
					<div class="rb_case_study">
						<a href="<?php the_permalink() ?>" class="image-wrapper">
							<?php
								$thumbnail = $logo = '';

								if( has_post_thumbnail() ){
									$thumbnail_id = get_post_thumbnail_id(get_the_ID());

									$thumb_title = get_post($thumbnail_id)->post_title;
									$thumb_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
									$thumb_alt = !empty($thumb_alt) ? $thumb_alt : $thumb_title;

									$img_srcset = wp_get_attachment_image_srcset( $thumbnail_id, 'full' );
									$img_sizes = '';

									if ( $columns == '2' ) {
								        $img_sizes = '(max-width: 767px) 100vw, 50vw';
								    } elseif ( $columns == '3' ) {
								        $img_sizes = '(max-width: 767px) 100vw, (max-width: 991px) 50vw, 33vw';
								    } elseif ( $columns == '4' ) {
								        $img_sizes = '(max-width: 767px) 100vw, (max-width: 991px) 50vw, (max-width: 1366px) 33vw, 25vw';
								    } else {
								        $img_sizes = '100vw';
								    }

									ob_start();
										the_post_thumbnail( 'full', array(
											'alt' => esc_attr($thumb_alt),
											'sizes' => esc_attr($img_sizes)
										) );
									$thumbnail .= ob_get_clean();
								}
								echo sprintf('%s', $thumbnail);
							?>

							<div class="logo-wrapper">
								<?php echo wp_get_attachment_image( rb_get_metabox('case_logo_image'), 'thumbnail' ) ?>
							</div>
						</a>
						<a href="<?php the_permalink() ?>">
							<h5><?php the_title() ?></h5>
						</a>
						<div class="case-study-content">
							<?php echo setech__the_content($chars_count, $more_btn_text, '', 'arrow_fade_in', 'medium') ?>
						</div>
					</div>
				<?php $count++; endwhile;

			echo '</div>';

			setech__pagination( $q, $total_items_count, $items_pp );

		echo "</div>";

		wp_reset_postdata();
		$out .= ob_get_clean();
	endif;

	return $out;
}
add_shortcode( 'rb_sc_case_study', 'rb_vc_shortcode_sc_case_study' );


?>