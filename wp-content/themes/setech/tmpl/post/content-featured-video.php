<?php
defined( 'ABSPATH' ) or die();
?>
	
	<div class="post-video">
		<?php if ( ! is_single() ): ?>
			<div class="post-video-thumbnail">
				<?php if ( has_post_thumbnail() ): ?>
					<a href="<?php echo esc_url( get_permalink() ) ?>">
						<?php
							$image = setech__get_image_resized( array( 'post_id' => get_the_ID(), 'size' => setech__option( 'blog__archive__imagesize' ) ) );
							echo wp_kses_post( $image['thumbnail'] );
						?>
					</a>
				<?php else: ?>
					
				<?php endif ?>
			</div>
		<?php else: ?>
			<div class="post-video-player">
				<?php echo wp_oembed_get( get_post_meta( get_the_ID(), '_post_video_oembed', true ), array( 'width' => '760' ) ); ?>
			</div>
		<?php endif ?>

	</div>
