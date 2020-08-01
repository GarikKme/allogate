<?php

function rb_vc_shortcode_sc_our_team ( $atts = array(), $content = "" ){
	$team_hide_meta = get_theme_mod('rb_staff_hide_meta') ? get_theme_mod('rb_staff_hide_meta') : array();

	$defaults = array(
		/* -----> GENERAL TAB <----- */
		"tax"							=> "",
		"orderby"						=> get_theme_mod('rb_staff_order_by'),
		"order"							=> get_theme_mod('rb_staff_order'),
		"columns"						=> get_theme_mod('rb_staff_columns'),
		"total_items_count"				=> "-1",
		"items_pp"						=> get_theme_mod('rb_staff_items_pp'),
		"thumb_size"					=> "full",
		"carousel"						=> false,
		"hide_meta"						=> true,
		"team_hide_meta"				=> implode(',', $team_hide_meta),
		"el_class"						=> "",
		/* -----> STYLING TAB <----- */
		"titles_color"					=> '#000',
		"links_color"					=> '#4C4C4D',
		"text_color"					=> "#4C4C4D",
		"socials_color"					=> "#fff",
		"socials_background"			=> PRIMARY_COLOR,
		"background_color"				=> "#fff",
		"shadow_color"					=> "rgba(0, 0, 0, 0.07)",
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
	$count = 1;
	$total_items_count = $total_items_count == '-1' ? 999 : $total_items_count;
	$terms_temp = $all_terms = array();
	$team_hide_meta = $hide_meta == false ? '' : $team_hide_meta;
	$terms = isset( $atts[ $tax . "_terms" ] ) ? $atts[ $tax . "_terms" ] : "";
	$id = uniqid( "rb_our_team_" );

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
	if( !empty($titles_color) ){
		$styles .= "
			#".$id." h5,
			#".$id." h6{
				color: ".$titles_color.";
			}
		";
	}
	if( !empty($links_color) ){
		$styles .= "
			#".$id." .rb_team_member .information_wrapper .meta,
			#".$id." .rb_team_member .information_wrapper .phone,
			#".$id." .rb_team_member .information_wrapper .email{
				color: ".$links_color.";
			}
		";
	}
	if( !empty($text_color) ){
		$styles .= "
			#".$id."{
				color: ".$text_color.";
			}
		";
	}
	if( !empty($socials_color) ){
		$styles .= "
			#".$id." .rb_team_member .social-icons li a{
				color: ".$socials_color.";
			}
		";
	}
	if( !empty($socials_background) ){
		$styles .= "
			#".$id." .rb_team_member .social-icons{
				background-color: ".$socials_background.";
			}
		";
	}
	if( !empty($background_color) ){
		$styles .= "
			#".$id.":before{
				background-color: ".$background_color.";
			}
		";
	}
	if( !empty($shadow_color) ){
		$styles .= "
			#".$id." .rb_team_member:before{
				-webkit-box-shadow: 0 0 35px 0 ".$shadow_color.";
			    -moz-box-shadow: 0 0 35px 0 ".$shadow_color.";
			    box-shadow: 0 0 35px 0 ".$shadow_color.";
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

	/* -----> Formating Main Query <----- */
	$query_atts = array(
		'post_type'			=> 'rb_staff',
		'post_status'		=> 'publish',
		'orderby'			=> $orderby,
		'order'				=> $order,
	);

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

	if( !$carousel ){
		$query_atts['paged'] = $paged;
		$query_atts['posts_per_page'] = $items_pp;
	} else {
		$query_atts['nopaging']	= true;
		$query_atts['posts_per_page'] = -1;
	}

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

	$q = new WP_Query( $query_atts );

	$found_posts = $q->found_posts;

	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );

	/* -----> Our Team module output <----- */
	$module_classes = "rb_our_team_module";
	$module_classes .= $carousel ? " rb_carousel_wrapper" : " columns_".$columns;
	$module_classes .= !empty($el_class) ? " ".esc_attr($el_class) : '';

	$module_atts = "";
	if( $carousel ){
		$module_atts .= " data-pagination='on'";
		$module_atts .= " data-columns='".$columns."'";
		$module_atts .= " data-draggable='on'";
		$module_atts .= " data-tablet-portrait='2'";
	}

	if( $q->have_posts() ):
		ob_start();

			echo "<div id='".$id."' class='".$module_classes."' ".$module_atts.">";

				echo $carousel ? "<div class='rb_carousel'>" : "";

				while( $q->have_posts() && $count <= $total_items_count ) : $q->the_post();

					$position = rb_get_taxonomy_links('rb_staff_member_position', ', ');
					$department = rb_get_taxonomy_links('rb_staff_member_department', ', ');
					$experience = rb_get_metabox('staff_experience');
					$email = rb_get_metabox('staff_email');
					$phone = rb_get_metabox('staff_phone');
					$biography = rb_get_metabox('staff_biography');
					$socials = (array)json_decode(rb_get_metabox('staff_socials'));

					echo "<div class='rb_team_member'>";

						echo "<div class='image_wrapper'>";
							echo "<a href='".get_permalink()."'>";
								the_post_thumbnail( $thumb_size );
							echo "</a>";

							if( strripos($team_hide_meta, 'socials') === false && !empty($socials) ){
								echo '<ul class="social-icons">';

									foreach( $socials as $key => $value ){
										$value = (array)$value;

										echo '<li>';
											echo '<a href="'.esc_url($value['social_url']).'" title="'.esc_attr($value['social_title']).'" target="_blank">';
												echo '<i class="rbicon-'.esc_attr($value['social_icon']).'"></i>';
											echo '</a>';
										echo '</li>';
									}

								echo '</ul>';
							}
						echo "</div>";

						echo "<div class='information_wrapper'>";
							if( strripos($team_hide_meta, 'name') === false ){
								echo "<a href='".get_permalink()."' class='h5 name'>";
									the_title();
								echo "</a>";
							}

							if( !empty($position) || !empty($department) ){
								echo "<div class='meta'>";
									if( !empty($position) && strripos($team_hide_meta, 'position') === false ){
										echo "<span class='position'>";
											echo sprintf('%s', $position);
										echo "</span>";
									}

									if( !empty($department) && strripos($team_hide_meta, 'department') === false ){
										echo "<span class='department'>";
											echo sprintf('%s', $department);
										echo "</span>";
									}
								echo "</div>";
							}

							if( strripos($team_hide_meta, 'experience') === false && !empty($experience) ){
								echo "<div class='experience'>";
									echo esc_html_x( 'Experience: ', 'frontend', 'setech' );
									echo esc_html($experience);
								echo "</div>";
							}

							if( strripos($team_hide_meta, 'email') === false && !empty($email) ){
								echo "<a href='mailto:".esc_attr($email)."' class='email'>";
									echo esc_html($email);
								echo "</a>";
							}

							if( strripos($team_hide_meta, 'phone') === false && !empty($phone) ){
								echo "<a href='tel:".esc_attr($phone)."' class='phone'>";
									echo esc_html($phone);
								echo "</a>";
							}

							if( strripos($team_hide_meta, 'biography') === false && !empty($biography) ){
								echo "<div class='biography'>";
									echo "<h6>".esc_html_x( 'Biography:', 'frontend', 'setech' )."</h6>";
									echo esc_html($biography);
								echo "</div>";
							}

							if( strripos($team_hide_meta, 'info') === false && !empty(get_the_content()) ){
								echo "<div class='personal_info'>";
									echo "<h6>".esc_html_x( 'Personal Information:', 'frontend', 'setech' )."</h6>";
									the_content();
								echo "</div>";
							}

						echo "</div>";

					echo '</div>';

					$count ++;

				endwhile;

				echo $carousel ? "</div>" : "";

			echo "</div>";

			if( !$carousel ) setech__pagination( $q, $total_items_count, $items_pp, 'standart', $max_paged );

		wp_reset_postdata();
		$out .= ob_get_clean();
	endif;

	return $out;
}
add_shortcode( 'rb_sc_our_team', 'rb_vc_shortcode_sc_our_team' );

?>