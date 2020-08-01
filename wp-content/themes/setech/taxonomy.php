<?php
get_header ();
	
	/* -----> Variables Declaration <----- */
	$taxonomy = get_query_var( 'taxonomy' );
	$term_slug = get_query_var( $taxonomy );

	/* -----> Taxonomy archive page <----- */
	switch( $taxonomy ){
		case 'rb_staff_member_position':
		case 'rb_staff_member_department':
			
			echo rb_vc_shortcode_sc_our_team( array(
				'tax' 				=> $taxonomy,
				'hide_meta'			=> true,
				$taxonomy.'_terms'	=> $term_slug
			));

			break;
		case 'rb_portfolio_tag':
		case 'rb_portfolio_cat':

			echo rb_vc_shortcode_sc_portfolio( array(
				'tax' 				=> $taxonomy,
				'hide_meta'			=> true,
				$taxonomy.'_terms'	=> $term_slug
			));

			break;
		case 'rb_case_study_tag':
		case 'rb_case_study_cat':

			echo rb_vc_shortcode_sc_case_study( array(
				'tax' 				=> $taxonomy,
				$taxonomy.'_terms'	=> $term_slug
			));

			break;
		default:
			break;
	}

get_footer ();
?>