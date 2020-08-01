<?php
defined( 'ABSPATH' ) or die();
?>

	<?php get_header() ?>
		<div class="content">
			<h1><?php echo esc_html_x( '404', '404 Page', 'setech' ) ?></h1>
			<h3><?php echo esc_html_x( 'Page Not Found', '404 Page', 'setech' ) ?></h3>
			<div class="content-404">
				<?php echo esc_html_x( 'We looked everywhere for this page.Are you sure the website URL is correct? Get in touch with the site owner.', '404 Page', 'setech' ) ?>
			</div>
			<a href="<?php echo esc_url(home_url( '/' )) ?>" class="button"><?php echo esc_html_x( 'GO BACK', '404 Page', 'setech' ) ?></a>
		</div>
		<!-- /.content-inner -->
	<?php get_footer() ?>
