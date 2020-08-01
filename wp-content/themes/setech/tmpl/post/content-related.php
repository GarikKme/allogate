<?php
defined( 'ABSPATH' ) or die();

// Remove Quote & Link posts from related
$extra_args = array(
    'post_type'		=> 'post',
    'post_status' 	=> 'publish',
    'order' 		=> 'DESC',
    'tax_query' 	=> array(
        array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array( 'post-format-quote', 'post-format-link' )
        )
    )
);

$asides = get_posts( $extra_args );
$posts__not_in = array( get_the_ID() );

if( count($asides) ){
    foreach( $asides as $aside ){
        $posts__not_in[] = $aside->ID;
    }
}

// Query args
$args = array(
	'post_type'           => 'post',
	'posts_per_page'      => get_theme_mod('blog_related_items'),
	'post__not_in'        => $posts__not_in,
	'ignore_sticky_posts' => true
);

$related_item_type = get_theme_mod('blog_related_pick');
$hide_meta = implode(',', (array)get_theme_mod('blog_related_hide'));
$columns = get_theme_mod('blog_related_columns');
$enable_carousel = get_theme_mod('blog_related_items') > get_theme_mod('blog_related_columns') ? true : false;

// Filter by tags
if ( 'tag' == $related_item_type ) {
	if ( ! ( $terms = get_the_tags() ) )
		return;

	$args['tag__in'] = wp_list_pluck( $terms, 'term_id' );
}
// Filter by categories
elseif ( 'category' == $related_item_type ) {
	if ( ! ( $terms = get_the_category() ) )
		return;

	$args['category__in'] = wp_list_pluck( $terms, 'term_id' );
}
// Show random items
elseif ( 'random' == $related_item_type ) {
	$args['orderby'] = 'rand';
}
// Show latest items
elseif ( 'recent' == $related_item_type ) {
	$args['order'] = 'DESC';
	$args['orderby'] = 'date';
}


// Create the query instance
$query = new WP_Query( $args );

if ( $query->have_posts() ):
?>

	<?php if( !empty(rb_get_metabox('related_blog_posts')) && rb_get_metabox('related_blog_posts') != 'none' ) : ?>

		<div class="related-posts">
			<?php echo do_shortcode(rb_get_metabox('related_blog_posts')) ?>
		</div>

	<?php elseif( get_theme_mod('blog_related') && rb_get_metabox('related_blog_posts') != 'none' ) : ?>

		<div class="related-posts">

			<?php if( !empty(get_theme_mod('blog_related_title')) ) : ?>
				<h2 class="single-content-title">
					<?php echo esc_html( get_theme_mod('blog_related_title') ) ?>
				</h2>
			<?php endif ?>

			<div class="blog blog_grid layout_<?php echo esc_attr($columns) ?>">
				<div class="content_inner" data-columns="<?php echo esc_attr($columns) ?>">

					<?php if( $enable_carousel ) : ?>
						<div class="rb_carousel_wrapper" data-columns="<?php echo esc_attr($columns) ?>" data-pagination="on" data-draggable="on">
							<div class="rb_carousel">
					<?php endif; ?>

						<?php 
							while ( $query->have_posts() ): $query->the_post();

							$extra_class = 'post';

							if( ( get_post_format() == 'link' || get_post_format() == 'quote' ) && ( !empty(rb_get_metabox('format_link_title')) || !empty(rb_get_metabox('format_quote')) ) ){
									$extra_class .= ' spacing-top';
							}
						?>

							<div id="post-<?php the_ID() ?>" <?php post_class( $extra_class ) ?>>
								<div class="post-inner">
									<?php if( !empty(setech__post_featured( $hide_meta )) ) : ?>
										<div class="post-media-wrapper">
											<!-- Featured Media -->
											<?php echo setech__post_featured( $hide_meta, get_theme_mod('blog_related_cropp') ) ?>

											<!-- Post Date -->
											<?php setech__post_date( $hide_meta, 'simple' ) ?>
										</div>
									<?php endif; ?>
									
									<div class='post-information'>
										<!-- Post Title -->
										<?php setech__post_title( $hide_meta ) ?>
										
										<?php if( !empty(setech__the_content()) ) : ?>
											<!-- Post Content -->
											<div class="post-content"><?php echo setech__the_content(get_theme_mod('blog_related_text_length'), get_theme_mod('blog_read_more'), $hide_meta) ?></div>
										<?php endif; ?>

										<!-- Post Meta -->
										<?php setech__post_meta($hide_meta) ?>
									</div>
								</div>
							</div>

						<?php endwhile; ?>

					<?php if( $enable_carousel ) : ?>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<?php wp_reset_postdata() ?>
		</div>
		
	<?php endif ?>
<?php endif ?>