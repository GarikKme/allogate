<?php
defined( 'ABSPATH' ) or die();

?>

	<?php get_header() ?>

		<?php if ( have_posts() ): ?>
			<?php
				if( get_theme_mod('blog_view') == 'large' ){
					get_template_part( 'tmpl/post/loop-large' );
				} else {
					get_template_part( 'tmpl/post/loop-grid' );
				}
			?>
		<?php else: ?>
			<div class="content">
				<?php get_template_part( 'tmpl/post/content', 'none' ) ?>
			</div>
		<?php endif ?>

	<?php get_footer(); ?>
