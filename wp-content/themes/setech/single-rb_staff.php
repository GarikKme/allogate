<?php
defined( 'ABSPATH' ) or die(); ?>

<?php get_header() ?>
	<?php while ( have_posts() ): the_post(); ?>

		<?php
			$department = rb_get_taxonomy_links('rb_staff_member_department', ', ');
			$position = rb_get_taxonomy_links('rb_staff_member_position', ', ');
			$experience = rb_get_metabox('staff_experience');
			$email = rb_get_metabox('staff_email');
			$phone = rb_get_metabox('staff_phone');
			$biography = rb_get_metabox('staff_biography');
			$content = setech__the_content('-1');

			$accent_background = !empty(get_theme_mod('rb_staff_single_accent_background')) ? wp_get_attachment_image_url(get_theme_mod('rb_staff_single_accent_background'), 'full') : '';
			$accent_background = !empty($accent_background) ? " style='background-image: url(".esc_url($accent_background).");'" : '';
		?>

		<div class="main_member_info" <?php echo sprintf('%s', $accent_background); ?>>
			<div class="social-icons-wrapper">
				<ul class="social-icons">
					
				<?php 
					$socials = (array)json_decode(rb_get_metabox('staff_socials'));

					foreach( $socials as $key => $value ){
						$value = (array)$value;

						echo '<li>';
							echo '<a href="'.$value['social_url'].'" title="'.$value['social_title'].'" target="_blank">';
								echo '<i class="rbicon-'.$value['social_icon'].'"></i>';
							echo '</a>';
						echo '</li>';
					}
				?>

				</ul>
			</div>
			<div class="image-wrapper">
				<?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
			</div>
			<div class="text-information">
				<h2 class="name"><?php the_title() ?></h2>

				<?php if( !empty($position) ) : ?>
					<div class="pos">
						<span class="label">
							<?php echo strripos($position, ',') !== false ? esc_html_x('Positions:', 'frontend', 'setech') : esc_html_x('Position:', 'frontend', 'setech') ?>
						</span>
						<?php echo sprintf('%s', $position); ?>
					</div>
				<?php endif; ?>

				<?php if( !empty($department) ) : ?>
					<div class="dep">
						<span class="label">
							<?php echo strripos($department, ',') !== false ? esc_html_x('Departments:', 'frontend', 'setech') : esc_html_x('Department:', 'frontend', 'setech') ?>
						</span>
						<?php echo sprintf('%s', $department); ?>
					</div>
				<?php endif; ?>

				<?php if( !empty($experience) ) : ?>
					<div class="experience">
						<span class="label">
							<?php echo esc_html_x('Experience:', 'frontend', 'setech') ?>
						</span>
						<?php echo esc_html($experience) ?>
					</div>
				<?php endif; ?>

				<?php if( !empty($email) ) : ?>
					<div class="email">
						<span class="label">
							<?php echo esc_html_x('Email:', 'frontend', 'setech') ?>
						</span>
						<a href="mailto:<?php echo esc_attr($email) ?>">
							<?php echo esc_html($email) ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if( !empty($phone) ) : ?>
					<div class="phone">
						<span class="label">
							<?php echo esc_html_x('Tel:', 'frontend', 'setech') ?>
						</span>
						<a href="tel:<?php echo esc_attr($phone) ?>">
							<?php echo esc_html($phone) ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if( !empty($biography) ) : ?>
			<div class="secondary_member_info">
				<h4><?php echo esc_html_x('Biography:', 'frontend', 'setech') ?></h4>
				<?php echo esc_html($biography) ?>
			</div>
		<?php endif; ?>

		<?php if( !empty($content) ) : ?>
			<div class="secondary_member_info">
				<h4><?php echo esc_html_x('Personal Information:', 'frontend', 'setech') ?></h4>
				<?php echo sprintf('%s', $content) ?>
			</div>
		<?php endif; ?>

	<?php endwhile ?>
<?php get_footer() ?>
