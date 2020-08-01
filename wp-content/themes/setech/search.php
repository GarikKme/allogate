<?php
defined( 'ABSPATH' ) or die();

global $wp_query;

$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
$index = 1 + ( ( $paged - 1 ) * $wp_query->query_vars['posts_per_page'] );
?>

	<?php get_header() ?>

		<?php if ( have_posts() ): ?>
			<div class="content blog layout_large" role="main" itemprop="mainContentOfPage">
				<div class="container">
					<?php get_search_form() ?>

					<?php 
						while ( have_posts() ): the_post(); 

						$extra_class = 'post';
					?>
						<div id="post-<?php the_ID() ?>" <?php post_class( $extra_class ) ?>>
							<div class="post-inner">
								<?php if( has_post_thumbnail() ): ?>
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

									<!-- Post Content -->
									<?php if( !empty(setech__the_content()) ) : ?>
										<!-- Post Content -->
										<div class="post-content">
											<?php echo setech__the_content('200') ?>
										</div>
									<?php endif; ?>

									<!-- Post Meta -->
									<?php setech__post_meta() ?>
								</div>
							</div>
						</div>
					<?php endwhile ?>
				</div>
			</div>
			
			<?php setech__pagination() ?>
		<?php else: ?>
			<div class="content">
				<div class="search-no-results">
					<h3><?php echo esc_html_x( 'Nothing Found', 'Search form', 'setech' ) ?></h3>
					<p><?php echo esc_html_x( 'Sorry, no posts matched your criteria. Please try another search', 'Search form', 'setech' ) ?></p>
					
					<p><?php echo esc_html_x( 'You might want to consider some of our suggestions to get better results:', 'Search form', 'setech' ) ?></p>
					<ul>
						<li><?php echo esc_html_x( 'Check your spelling.', 'Search form', 'setech' ) ?></li>
						<li><?php echo esc_html_x( 'Try a similar keyword, for example: tablet instead of laptop.', 'Search form', 'setech' ) ?></li>
						<li><?php echo esc_html_x( 'Try using more than one keyword.', 'Search form', 'setech' ) ?></li>
					</ul>
				</div>
				<?php get_search_form() ?>
			</div>
		<?php endif ?>

	<?php get_footer() ?>