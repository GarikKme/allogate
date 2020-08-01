<?php
defined( 'ABSPATH' ) or die();
?>

	<div class="content blog layout_<?php echo esc_attr(get_theme_mod('blog_columns')) ?>" role="main" itemprop="mainContentOfPage">
		<?php if ( have_posts() ): ?>
			<div class="content_inner <?php echo esc_attr(get_theme_mod('blog_view')) ?>" data-columns="<?php echo esc_attr(get_theme_mod('blog_columns')) ?>">
				<?php 
					while ( have_posts() ): the_post(); 

					$extra_class = 'post';
					$extra_class .= ' button_'.get_theme_mod('blog_button_style');

				?>
					<div id="post-<?php the_ID() ?>" <?php post_class( $extra_class ) ?>>
						<div class="post-inner">
							<?php if( !empty(setech__post_featured()) ) : ?>
								<div class="post-media-wrapper">
									<!-- Featured Media -->
									<?php echo setech__post_featured() ?>

									<!-- Post Date -->
									<?php setech__post_date( '', 'simple' ) ?>
								</div>
							<?php endif; ?>

							<div class='post-information'>
								<!-- Post Title -->
								<?php setech__post_title() ?>

								<?php 
									$content = setech__the_content(get_theme_mod('blog_chars_count'));
									if( !empty($content) ) : 
								?>
									<!-- Post Content -->
									<div class="post-content">
										<?php echo sprintf('%s', $content); ?>
									</div>
								<?php endif; ?>

								<!-- Post Meta -->
								<?php setech__post_meta() ?>
							</div>
						</div>
					</div>
				<?php endwhile ?>
			</div>

			<?php setech__pagination() ?>
		<?php else: ?>
			<?php get_template_part( 'tmpl/post/content-none' ) ?>
		<?php endif ?>
	</div>
	<!-- /.content -->
