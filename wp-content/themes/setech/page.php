<?php
defined( 'ABSPATH' ) or die();
?>

	<?php get_header() ?>
		<?php if ( have_posts() ): the_post(); ?>
			
			<div class="page-content">
				<?php the_content() ?>
			</div>

			<?php 
				wp_link_pages( array(
					'before'      => '<div class="paging-navigation in-post"><div class="pagination"><span class="page-links-title">' . esc_html__( 'Pages:', 'setech' ) . '</span>',
					'after'       => '</div></div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) ); 
			?>

			<?php
				$args = array(
					'post_id' => get_the_ID()
				);

				setech__comments_list();
			?>
		<?php endif ?>
	<?php get_footer() ?>
