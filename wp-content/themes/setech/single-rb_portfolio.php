<?php
defined( 'ABSPATH' ) or die(); ?>

<?php get_header() ?>
	<?php while ( have_posts() ): the_post(); ?>

		<?php
			$categories = rb_get_taxonomy_links('rb_portfolio_cat', ', ');
			$tags = rb_get_taxonomy_links('rb_portfolio_tag', ', ');
			$type = rb_get_metabox('portfolio_type');
			$gallery = explode(',', rb_get_metabox('portfolio_gallery'));
			$client = rb_get_metabox('portfolio_client');
			$author = rb_get_metabox('portfolio_author');
			$related = rb_get_metabox('related_portfolio_posts');
			$content = setech__the_content();
		?>
		
		<div class="portfolio-single-content type_<?php echo esc_attr($type) ?>">
			<div class="portfolio-media">
				<?php
					switch( $type ){
						case 'small_images':
						
							foreach ($gallery as $image) {
								$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
								$src = wp_get_attachment_image_src( $image, 'full' )[0];

								echo "<img src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
							}

							break;
						case 'small_slider':

							echo '<div class="rb_carousel_wrapper" data-columns="1" data-draggable="on" data-pagination="on">';
								echo '<div class="rb_carousel">';

									foreach ($gallery as $image) {
										$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
										$src = wp_get_attachment_image_src( $image, 'full' )[0];

										echo "<img src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
									}

								echo '</div>';
							echo '</div>';

							break;
						case 'large_images':

							foreach ($gallery as $image) {
								$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
								$src = wp_get_attachment_image_src( $image, 'full' )[0];

								echo "<img src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
							}

							break;
						case 'large_slider':

							echo '<div class="rb_carousel_wrapper" data-columns="1" data-draggable="on" data-navigation="on">';
								echo '<div class="rb_carousel">';

									foreach ($gallery as $image) {
										$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
										$src = wp_get_attachment_image_src( $image, 'full' )[0];

										echo "<img src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
									}

								echo '</div>';
							echo '</div>';

							break;
						case 'gallery':

							echo '<div class="rb_gallery_images magnific">';

								foreach ($gallery as $image) {
									$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
									$src = wp_get_attachment_image_src( $image, 'full' )[0];

									echo "<a href='".esc_url($src)."' class='rb_gallery_image'>";
										echo "<img src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
									echo "</a>";
								}

							echo '</div>';

							break;
						case 'small_masonry':

							echo '<div class="rb_gallery_images masonry">';

								foreach ($gallery as $image) {
									$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
									$src = wp_get_attachment_image_src( $image, 'full' )[0];

									echo "<img class='rb_gallery_image' src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
								}

							echo '</div>';

							break;
						case 'large_masonry':

							echo '<div class="rb_gallery_images masonry">';

								foreach ($gallery as $image) {
									$alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
									$src = wp_get_attachment_image_src( $image, 'full' )[0];

									echo "<img class='rb_gallery_image' src='".esc_url($src)."' alt='".esc_attr($alt)."' />";
								}

							echo '</div>';

							break;
						case 'custom_layout':

							$type = substr(rb_get_metabox('portfolio_gallery_template'), 0, -4);

							echo '<div class="gallery_custom_grid '.esc_attr($type).'">';

								foreach ($gallery as $image) {
									$src = wp_get_attachment_image_src( $image, 'full' )[0];

									echo '<div class="pic" style="background-image: url('.esc_url($src).')"></div>';
								}

							echo '</div>';

							break;
					}
				?>
			</div>
				
			<?php if( $type != 'small_images' && $type != 'small_slider' && $type != 'small_masonry' ) : ?>
				<h4><?php the_title() ?></h4>
			<?php endif; ?>
			<div class="portfolio-content-wrapper">
				<div class="main-part">
					<?php if( $type == 'small_images' || $type == 'small_slider' || $type == 'small_masonry' ) : ?>
						<h4><?php the_title() ?></h4>
					<?php endif; ?>
					<div class="portfolio-content">
						<?php echo sprintf('%s', $content) ?>
					</div> 
				</div>
				<div class="aside-part">
					<?php if( !empty($categories) ) : ?>
						<div>
							<span class="label">
								<?php echo strripos($categories, ',') !== false ? esc_html_x('Categories:', 'frontend', 'setech') : esc_html_x('Category:', 'frontend', 'setech') ?>
							</span>
							<?php echo sprintf('%s', $categories); ?>
						</div>
					<?php endif; ?>
					<?php if( !empty($tags) ) : ?>
						<div>
							<span class="label">
								<?php echo strripos($tags, ',') !== false ? esc_html_x('Tags:', 'frontend', 'setech') : esc_html_x('Tag:', 'frontend', 'setech') ?>
							</span>
							<?php echo sprintf('%s', $tags); ?>
						</div>
					<?php endif; ?>
					<?php if( !empty($author) ) : ?>
						<div>
							<span class="label">
								<?php echo esc_html_x('Author:', 'frontend', 'setech'); ?>
							</span>
							<?php echo sprintf('%s', $author); ?>
						</div>
					<?php endif; ?>
					<?php if( !empty($client) ) : ?>
						<div>
							<span class="label">
								<?php echo esc_html_x('Client:', 'frontend', 'setech'); ?>
							</span>
							<?php echo sprintf('%s', $client); ?>
						</div>
					<?php endif; ?>
					<div>
						<span class="label">
							<?php echo esc_html_x('Date:', 'frontend', 'setech'); ?>
						</span>
						<?php echo get_the_date(); ?>
					</div>
					<?php get_template_part( 'tmpl/post/content-sharing' ); ?>
				</div>
			</div>

		</div>

		<?php get_template_part( 'tmpl/post/content-navigator' ) ?>

		<?php if( get_theme_mod('rb_portfolio_related') ) : ?>

			<div class="related-posts">

				<?php if( !empty(get_theme_mod('rb_portfolio_related_title')) ) : ?>
					<h2 class="single-content-title">
						<?php echo esc_html( get_theme_mod('rb_portfolio_related_title') ) ?>
					</h2>
				<?php endif ?>

				<?php 
					echo rb_vc_shortcode_sc_portfolio( array(
						'layout'			=> 'grid',
						'columns' 			=> get_theme_mod('rb_portfolio_related_columns'),
						'total_items_count' => get_theme_mod('rb_portfolio_related_items'),
						'hover'				=> get_theme_mod('rb_portfolio_related_hover'),
						'square_img'		=> false,
						'no_spacing'		=> false,
						'related_query'		=> get_theme_mod('rb_portfolio_related_pick')
					));
				?>

			</div>

		<?php endif; ?>

	<?php endwhile ?>
<?php get_footer() ?>
