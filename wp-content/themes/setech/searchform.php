<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">

	<?php if ( have_posts() ) : ?>
		<h3 class='success-search'><?php printf( esc_html_x( 'Your search for: "%s" revealed the following:', 'Search form', 'setech' ), get_search_query() ) ?></h3>
	<?php endif; ?>

	<div class="label">
		<span class="screen-reader-text"><?php echo esc_html_x('Search...', 'Search form', 'setech') ?></span>
    	<input type="search" class="search-field" value="" name="s" placeholder="<?php echo esc_html_x('Search...', 'Search form', 'setech') ?>" />
    	<button type="submit" class="search-submit">
    		<span class='page-submit'><?php echo esc_html_x('SEARCH', 'Search form', 'setech'); ?></span>
    	</button>
	</div>
</form>