<?php

function rb_vc_shortcode_sc_latest_posts ( $atts = array(), $content = "" ){

	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"title"							=> "",
		"tax"							=> "",
		"total_items_count"				=> "2",
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"title_color"					=> PRIMARY_COLOR,
		"date_color"					=> PRIMARY_COLOR,
		"article_color"					=> PRIMARY_COLOR,
		"article_color_hover"			=> PRIMARY_COLOR,
	);

	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );

	/* -----> Variables declaration <----- */
	$out = $styles = "";
	$terms_temp = $all_terms = array();
	$terms = isset( $atts[ $tax . "_terms" ] ) ? $atts[ $tax . "_terms" ] : "";
	$id = uniqid( "rb_latest_posts_" );

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

	/* -----> Formating Main Query <----- */
	$query_atts = array(
		'post_type'				=> 'post',
		'post_status'			=> 'publish',
		'orderby'				=> 'date',
		'order'					=> 'DESC',
		'posts_per_page'		=> '-1',
		'nopaging'				=> true,
		'ignore_sticky_posts'	=> true,
	);

	if( !empty($tax) ){
		$query_atts['tax_query'] = array(
			array(
				'taxonomy'	=> $tax,
				'field'		=> 'slug',
				'terms'		=> $terms
			)
		);
	}

	$q = new WP_Query( $query_atts );
	$count = 0;

	/* -----> Customize default styles <----- */
	if( !empty($title_color) ){
		$styles .= "
			#".$id." h5{
				color: ".$title_color.";
			}
		";
	}
	if( !empty($date_color) ){
		$styles .= "
			#".$id." .date{
				color: ".$date_color.";
			}
		";
	}
	if( !empty($article_color) ){
		$styles .= "
			#".$id." .title{
				color: ".$article_color.";
			}
		";
	}
	if( !empty($article_color_hover) ){
			$styles .= "
				@media 
					screen and (min-width: 1367px),
					screen and (min-width: 1200px) and (any-hover: hover),
					screen and (min-width: 1200px) and (min--moz-device-pixel-ratio:0),
					screen and (min-width: 1200px) and (-ms-high-contrast: none),
					screen and (min-width: 1200px) and (-ms-high-contrast: active)
				{
					#".$id." .title:hover{
						color: ".esc_attr($article_color_hover).";
					}
				}
			";
		}
	/* -----> End of mobile styles <----- */
	
	rb__vc_styles($styles);

	/* -----> Latest Posts module output <----- */
	if( $q->have_posts() ):
		ob_start();

			echo "<div id='".$id."' class='rb_latest_posts'>";

			if( !empty($title) ){
				echo "<h5>".esc_html($title)."</h5>";
			}

			while( $q->have_posts() && $count < (int)$total_items_count ) : $q->the_post();

				echo "<div class='rb_latest_post'>";

					if( !empty($image = get_the_post_thumbnail(get_the_ID(), 'thumbnail')) ){
						echo "<a href='".get_permalink()."' class='image_wrapper'>";
							echo $image;
						echo "</a>";
					}

					echo "<div class='info_wrapper'>";
						echo "<a href='".get_permalink()."' class='title'>".get_the_title()."</a>";
						echo "<p class='date'>".get_the_date()."</p>";
					echo "</div>";

				echo "</div>";


				$count++;

			endwhile;

			echo "</div>";

		wp_reset_postdata();
		$out .= ob_get_clean();
	endif;

	return $out;
}
add_shortcode( 'rb_sc_latest_posts', 'rb_vc_shortcode_sc_latest_posts' );

?>