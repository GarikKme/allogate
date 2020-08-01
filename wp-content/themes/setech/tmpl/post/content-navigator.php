<?php
defined( 'ABSPATH' ) or die();

global $post;

$first_post_loop = get_posts( 'post_type='.get_post_type().'&numberposts=1&order=ASC' );
$first_post = $first_post_loop[0];

$last_post_loop = get_posts( 'post_type='.get_post_type().'&numberposts=1' );
$last_post = $last_post_loop[0];

$next_post = get_next_post() ? get_next_post() : $first_post;
$prev_post = get_previous_post() ? get_previous_post() : $last_post;
$post_type = get_post_type_object( get_post()->post_type );

if ( !get_next_post() && !get_previous_post() ) {
	return;
}
?>

<nav class="navigation post-navigation" role="navigation">
	<ul class="nav-links">
		<?php if ( is_attachment() ): ?>
			<?php previous_post_link( '<li>%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', esc_html__( 'Published In', 'setech' ) ) ); ?>
		<?php else: ?>

			<?php if ( $prev_post ): ?>
					
				<?php $thumbnail = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>

				<li class="prev-post <?php echo !empty($thumbnail) ? 'hover' : ''; ?>">
					<div class="post-nav-link">
						<a href="<?php echo get_permalink( $prev_post ) ?>">
							<?php echo esc_html_x('Previous Post', 'single page', 'setech'); ?>
						</a>
					</div>
					
					<?php if( !empty($thumbnail) ) : ?>
						<a href="<?php echo get_permalink( $prev_post ) ?>">
							<img src="<?php echo esc_url($thumbnail) ?>" alt="<?php echo esc_attr($prev_post->post_title) ?>" />
						</a>
					<?php endif; ?>

					<div class="post-nav-text-wrapper">	
						<a href="<?php echo get_permalink( $prev_post ) ?>">
							<span class="post-title"><?php echo wp_kses_post( $prev_post->post_title ) ?></span>
							<span class="post-date"><?php echo substr(wp_kses_post( $prev_post->post_date ), 0, -9); ?></span>
						</a>
					</div>
				</li>
			<?php else: ?>
				<li class="prev-post disabled"></li>
			<?php endif ?>
			
			<li class="archive-dots">
				<a href="<?php echo get_post_type_archive_link(get_post()->post_type) ?>">
					<span></span>
					<span></span>
					<span></span>
				</a>
			</li>

			<?php if ( $next_post ): ?>
					
				<?php $thumbnail = get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>

				<li class="next-post <?php echo !empty($thumbnail) ? 'hover' : ''; ?>">
					<div class="post-nav-link">
						<a href="<?php echo get_permalink( $next_post ) ?>">
							<?php echo esc_html_x('Next Post', 'single page', 'setech'); ?>
						</a>
					</div>

					<div class="post-nav-text-wrapper">
						<a href="<?php echo get_permalink( $next_post ) ?>">
							<span class="post-title"><?php echo wp_kses_post( $next_post->post_title ) ?></span>
							<span class="post-date"><?php echo substr(wp_kses_post( $next_post->post_date ), 0, -9); ?></span>
						</a>
					</div>

					<?php if( !empty($thumbnail) ) : ?>
						<a href="<?php echo get_permalink( $next_post ) ?>">
							<img src="<?php echo esc_url($thumbnail) ?>" alt="<?php echo esc_attr($next_post->post_title) ?>" />
						</a>
					<?php endif; ?>
				</li>
			<?php else: ?>
				<li class="next-post disabled"></li>
			<?php endif ?>

		<?php endif; ?>
	</ul>
</nav>