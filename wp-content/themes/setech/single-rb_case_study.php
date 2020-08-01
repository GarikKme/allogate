<?php
defined( 'ABSPATH' ) or die(); ?>

<?php get_header() ?>
	
	<?php if ( have_posts() ): the_post(); ?>
			
		<?php the_content() ?>

		<div class="post-meta">

			<?php
				$tags = get_the_terms( get_the_ID(), 'rb_case_study_tag', '', ' ');
				$cats = get_the_terms( get_the_ID(), 'rb_case_study_cat', '', ' ');

				if( !empty($tags) ) :
			?>
					<div class="post-tags">
						<span><?php echo esc_html_x('Tags:', 'frontend', 'setech') ?></span>
						<?php the_terms( get_the_ID(), 'rb_case_study_tag', '', ' ') ?>
					</div>
			<?php 
				endif;
				if( !empty($cats) ) : 
			?>
					<div class="post-cats">
						<span><?php echo esc_html_x('Categories:', 'frontend', 'setech') ?></span>
						<?php the_terms( get_the_ID(), 'rb_case_study_cat', '', ' ') ?>
					</div>
			<?php
				endif;
			?>

		</div>

		<?php get_template_part( 'tmpl/post/content-navigator' ) ?>

		<?php if( get_theme_mod('rb_case_study_related') ) : ?>

			<div class="related-posts">

				<?php if( !empty(get_theme_mod('rb_case_study_related_title')) ) : ?>
					<h2 class="single-content-title">
						<?php echo esc_html( get_theme_mod('rb_case_study_related_title') ) ?>
					</h2>
				<?php endif ?>

				<?php 
					echo rb_vc_shortcode_sc_case_study( array(
						'columns' 			=> get_theme_mod('rb_case_study_related_columns'),
						'total_items_count' => get_theme_mod('rb_case_study_related_items'),
						'related_query'		=> get_theme_mod('rb_case_study_related_pick')
					));
				?>

			</div>

		<?php endif; ?>

	<?php endif ?>

<?php get_footer() ?>