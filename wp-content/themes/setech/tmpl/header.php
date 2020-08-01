<?php 
defined( 'ABSPATH' ) or die(); ?>

	<div id="site-header" class="site-header">
		<div class="header-content">
			<!-- Start Top Bar Box -->
			<?php 
				if( 
					!empty(get_theme_mod('top_bar_number')) || 
					!empty(get_theme_mod('top_bar_email')) || 
					!empty(get_theme_mod('top_bar_address')) || 
					!empty(get_theme_mod('icon_custom_sb')) || 
					!empty(get_theme_mod('woo_cart'))
				) :
			?>
			<div class="top-bar-box">
				<div class="container <?php if( get_theme_mod('top_bar_wide') ) echo 'wide_container'; ?>">
					<div class="header_info_links">
						<?php if( !empty(get_theme_mod('top_bar_number')) ) : ?>
							<a class="top_bar_phone" href="tel:<?php echo esc_attr(get_theme_mod('top_bar_number')) ?>"><?php echo esc_html(get_theme_mod('top_bar_number')) ?></a>
						<?php 
							endif; 
							if( !empty(get_theme_mod('top_bar_email')) ) :
						?>
							<a class="top_bar_mail" href="mailto:<?php echo esc_attr(get_theme_mod('top_bar_email')) ?>"><?php echo esc_html(get_theme_mod('top_bar_email')) ?></a>
						<?php 
							endif; 
							if( !empty(get_theme_mod('top_bar_address')) ) :
						?>
							<p class="top_bar_address"><?php echo esc_html(get_theme_mod('top_bar_address')) ?></p>
						<?php endif; ?>
					</div>
					<div class="header_icons">
						<?php get_template_part( 'tmpl/header-icons' ); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<!-- Start Menu Box -->
			<div class="menu-box">
				<div class="container <?php if( get_theme_mod('menu_wide') ) echo 'wide_container'; ?>">
					<div class="site_logotype">
						<a href="<?php echo esc_url(home_url( '/' )) ?>">
							<?php setech_logo('logotype', 'logo_dimensions') ?>
						</a>
					</div>
					<nav class="menu-main-container header_menu" itemscope="itemscope">
						<?php wp_nav_menu( setech__main_menu_args() ) ?>
					</nav>
					<div class="menu-right-info">
						<?php if( !empty(get_theme_mod('menu_have_a_question_title')) ) : ?>
							<div class="have_a_question">
								<i class="rbicon-whatsapp"></i>
								<div class="info">
									<p><?php echo get_theme_mod('menu_have_a_question_title') ?></p>
									<a href="tel:<?php echo str_replace(' ', '', get_theme_mod('menu_have_a_question_phone')) ?>">
										<?php echo get_theme_mod('menu_have_a_question_phone') ?>
									</a>
								</div>
							</div>
						<?php endif; ?>
						<div class="search-trigger"></div>
					</div>
				</div>
			</div>
			<?php if( ( SETECH__ACTIVE && !is_front_page() && !is_404() ) || ( !SETECH__ACTIVE && !is_404() ) ) : ?>
				<?php
					$title_img = !empty(rb_get_metabox('title_image')) ? rb_get_metabox('title_image') : get_theme_mod('title_area_bg') ;
					$dynamic_img = !empty(rb_get_metabox('title_interactive_image')) ? rb_get_metabox('title_interactive_image') : get_theme_mod('title_area_interactive');

					$dynamic_image = !empty($dynamic_img) ? wp_get_attachment_image_src( $dynamic_img, 'full' )[0] : '';

					$title_extra_classes = get_theme_mod('title_area_mask') ? ' masked' : '';
					$title_extra_classes .= get_theme_mod('title_mouse_animation') ? ' mouse_anim' : '';
					$title_extra_classes .= get_theme_mod('title_scroll_animation') ? ' scroll_anim' : '';
					$title_extra_classes .= get_theme_mod('title_share_bg') ? ' shared_bg' : '';

					$title_extra_styles = 'style="';
					$title_extra_styles .= !empty(get_theme_mod('title_custom_gradient_css')) ? esc_attr(get_theme_mod('title_custom_gradient_css')) : '';
					$title_extra_styles .= !empty($title_img) ? 'background-image: url('.wp_get_attachment_image_src( $title_img, "full" )[0].');' : '';
					$title_extra_styles .= '"';

					$title_hide = is_array(get_theme_mod('title_fields_hide')) ? implode(',', get_theme_mod('title_fields_hide')) : '';
				?>
				<?php if( empty(rb_get_metabox('slider_shortcode')) ): ?>
					<div class="page_title_container<?php echo sprintf('%s', $title_extra_classes) ?>" <?php echo sprintf('%s', $title_extra_styles) ?>>
						
						<?php if( rb_get_metabox('title_interactive_remove') != 'on' && !empty($dynamic_image) ) : ?>
							<img data-depth="0.80" src="<?php echo esc_url($dynamic_image) ?>" class="page_title_dynamic_image" alt="<?php the_title_attribute() ?>" />
						<?php endif; ?>

						<div class="page_title_wrapper container">
							<?php
								if( is_singular('post') && strripos($title_hide, 'cats') === false ){
									echo "<div class='single_post_categories title_ff'>";
										the_category(' ');
									echo "</div>";
								}
							?>
							<?php if( strripos($title_hide, 'title') === false ) : ?>
								<div class="page_title_customizer_size">
									<h1 class="page_title">
										<?php echo rb_get_page_title() ?>
									</h1>
								</div>
							<?php endif; ?>
							<?php if( strripos($title_hide, 'divider') === false ) : ?>
								<span class="title_divider"></span>
							<?php endif; ?>
							<?php 
								if( strripos($title_hide, 'breadcrumbs') === false ){
									get_template_part( 'tmpl/header-breadcrumbs' );
								}
							?>
						</div>

						<?php
							if( is_singular( 'rb_case_study' ) ){
								$logo = !empty(rb_get_metabox('case_logo_image')) ? rb_get_metabox('case_logo_image') : '';
								$logo_title = !empty(rb_get_metabox('case_logo_title')) ? rb_get_metabox('case_logo_title') : '';

								if( !empty($logo) || !empty($logo_title) ){
									echo '<div class="case_study_logo">';
										echo wp_get_attachment_image( rb_get_metabox('case_logo_image'), 'thumbnail' );
										echo '<p>'.$logo_title.'</p>';
									echo '</div>';
								}
							}
						?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php get_template_part( 'tmpl/header-breadcrumbs' ); ?>
			<?php endif; ?>
		</div>
		<!-- /.site-header-inner -->
	</div>
	<!-- /.site-header -->