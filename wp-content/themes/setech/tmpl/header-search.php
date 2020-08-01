<?php defined( 'ABSPATH' ) or die(); ?>

<!-- Start Search Form -->
<div class="site-search hidden">
	<div class="container">
		<?php if( get_theme_mod('search_title') ) : ?>
			<div class="search-title"><?php echo get_theme_mod('search_title'); ?></div>
		<?php endif; ?>
		<i class="close-search"></i>
		<?php get_search_form() ?>
	</div>
</div>