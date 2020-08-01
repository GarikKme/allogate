<?php
defined( 'ABSPATH' ) or die();

?>
	<?php get_header() ?>
		<?php if ( have_posts() ): ?>
			<div class="single_content">
				<?php while ( have_posts() ): the_post(); ?>
					<?php get_template_part( 'tmpl/post/content', 'single' ) ?>
				<?php endwhile ?>

				<?php get_template_part( 'tmpl/post/content-navigator' ) ?>

				<?php setech__related_posts() ?>

				<?php setech__comments_list() ?>
			</div>
			
		<?php endif ?>
	<?php get_footer() ?>
