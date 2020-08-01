( function( jQuery ) {
	"use strict";

/* ===========> Helper scripts <=========== */
function is_mobile_device(){
	if ( navigator.userAgent.match( /(Android|iPhone|iPod|iPad|Phone|DROID|webOS|BlackBerry|Windows Phone|ZuneWP7|IEMobile|Tablet|Kindle|Playbook|Nexus|Xoom|SM-N900T|GT-N7100|SAMSUNG-SGH-I717|SM-T330NU)/ ) ) {
		return true;
	} else {
		return false;
	}
}
function rb_detect_browser() { 
	var browser = 'unknown';

    if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 ) {
        browser = 'Opera';
    } else if(navigator.userAgent.indexOf("Chrome") != -1 ){
        browser = 'Chrome';
    } else if(navigator.userAgent.indexOf("Safari") != -1){
        browser = 'Safari';
    } else if(navigator.userAgent.indexOf("Firefox") != -1 ){
        browser = 'Firefox';
    } else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )){
    	browser = 'IE';
    }

    jQuery('body').addClass('browser_'+browser);
}
function rb_is_tablet_viewport () {
	if ( window.innerWidth > 767 && window.innerWidth < 1367 && is_mobile_device() ){
		return true;
	} else {
		return false;
	}		
}
function is_mobile () {
	if ( window.innerWidth < 768 ){
		return true;
	} else {
		return false;
	}
}
function not_desktop(){
	if( (window.innerWidth < 1367 && is_mobile_device()) || window.innerWidth < 1200 ){
		return true;
	} else {
		return false;
	}
}
function rb_resize_class() {
	var rbBody = jQuery('body');
	if( is_mobile_device() && rb_is_tablet_viewport()){
		rbBody.removeClass('rb_mobile');
		rbBody.addClass('rb_tablet');
	} else if ( is_mobile_device() && is_mobile() ){
		rbBody.removeClass('rb_tablet');
		rbBody.addClass('rb_mobile');
	} else {
		rbBody.removeClass('rb_tablet');
		rbBody.removeClass('rb_mobile');
	}
}
function rb_is_mobile () {
	var device = is_mobile_device();
	var viewport = not_desktop();
	return device || viewport;
}
function rb_potfolio_get_columns( element ){
	var windowWidth = jQuery(window).width();
	var columns = element.data('columns');

	if( windowWidth < 1200 && windowWidth > 991 && columns > 4 ){
		columns = 4;
	} else if( windowWidth < 768 && windowWidth > 479 && columns > 2 ){
		columns = 3;
	} else if( windowWidth < 480 && columns > 1 ){
		columns = 1;
	}

	return columns;
}
/* ===========> rb_move_background() variables prepare <=========== */
var lFollowX = 0,
    lFollowY = 0,
    x = 0,
    y = 0,
    friction = 1 / 30;

jQuery(window).on('mousemove click', function(e) {
	var lMouseX = Math.max(-100, Math.min(100, jQuery(window).width() / 2 - e.clientX));
	var lMouseY = Math.max(-100, Math.min(100, jQuery(window).height() / 2 - e.clientY));
	lFollowX = (15 * lMouseX) / 100;
	lFollowY = (15 * lMouseY) / 100;
});

/* ===========> Scripts Init <=========== */
jQuery(document).ready(function (){
	rb_detect_browser();
	rb_resize_class();
	rb_search_trigger();
	rb_click_overlay();
	rb_magnific_popup_init();
	rb_baner_hover();
	rb_scroll_to_top();
	rb_wishlist_hidden_title();
	rb_custom_sidebars();
	rb_fix_layout_paddings();
	rb_tips_touch();
});

window.addEventListener( "load", function() {
	rb_desktop_menu();
	rb_tablet_menu();
	rb_mobile_menu();
	rb_widget_menu();
	rb_blog_fix_divider();
	rb_show_sidebar();
	rb_masonry();
	rb_page_preloader();
	rb_carousel();
	rb_custom_carousel();
	rb_sticky_menu();
	rb_footer_on_bottom();
	rb_megamenu_pos();
	rb_sticky_footer();
	rb_presentation();
	rb_smooth_title();
	rb_extended_services_size();
	rb_close_info_box();
	rb_progress_bar();
	rb_progress_bar_width();
	rb_icons_wheel_init();
	rb_column_animation();
	rb_milestone_shape_size();
	rb_milestones_count();
	rb_particles_init();
	rb_mask_on_vc_row();
	rb_smooth_comment_anchor();
	rb_simple_staff_style();
	rb_sticky_sidebar();
	rb_share_title_bg();
	rb_3d_images();
	rb_centered_menu();
	rb_our_team_hover_on_devices();
	rb_product_hover_on_devices();

	setTimeout(function(){
		rb_move_background();
	}, 900);
});

jQuery(window).resize( function(){
	rb_resize_class();
	rb_masonry();
	rb_desktop_menu();
	rb_tablet_menu();
	rb_mobile_menu();
	rb_magnific_popup_init();
	rb_column_animation();
	rb_footer_on_bottom();
	rb_megamenu_pos();
	rb_sticky_footer();
	rb_sticky_menu();
	rb_milestone_shape_size();
	rb_extended_services_size();
	rb_progress_bar_width();
});

/* ===========> Scripts Declaration <=========== */
function rb_search_trigger(){
	jQuery('.search-trigger').on('click', function() {
		jQuery('.site-search').slideDown(300);
		jQuery('.site-search').find('.search-field').focus();
		jQuery('body').addClass('active');
	});

	jQuery('.close-search').on('click', function() {
		jQuery('body').removeClass('active');
		jQuery('.site-search').slideUp(300);
	});
}
function rb_desktop_menu(){
	jQuery('.current-menu-item').parents('li.menu-item').addClass('current-item-parent');

	jQuery('.menu-item-object-rb-megamenu > a').on('click', function(e){
		e.preventDefault();
		return false;
	});

	if( !not_desktop() ){
		jQuery('.menu-main-container.header_menu').css('pointer-events', 'none');

		jQuery('.menu-main-container.header_menu > .menu > .menu-item').has('.sub-menu').off();
		jQuery('.menu-main-container.header_menu > .menu > .menu-item').has('.sub-menu').on('hover', function() {
			jQuery(this).toggleClass('active');
			jQuery(this).children('.sub-menu').stop().slideToggle(300).toggleClass('active');
		});

		jQuery('.menu-main-container.header_menu .sub-menu > .menu-item-has-children').off();
		jQuery('.menu-main-container.header_menu .sub-menu > .menu-item-has-children').on('hover', function() {
			jQuery(this).children('.sub-menu').toggle();
			jQuery(this).children('a').toggleClass('active');
		});

		jQuery('.menu-main-container.header_menu').css('pointer-events', 'auto');
	}
}
function rb_tablet_menu(){
	var windowWidth = jQuery(window).width();

	if( 
		jQuery('#site').hasClass('desktop-menu-landscape') && windowWidth < 1200 && windowWidth > 991 || 
		jQuery('#site').hasClass('desktop-menu-both') && windowWidth < 1200 && windowWidth > 768 
	){
		
		if( rb_is_tablet_viewport() ){
			var this_is = {};
			var parent = {};
			var parentsSubMenus = {};

			jQuery('.menu-main-container .menu-item > a').off();
			jQuery('.menu-main-container .menu-item > a').on('click', function(e) {
				this_is = jQuery(this);
				parent = this_is.parent();
				parentsSubMenus = this_is.parents('.menu-item').children('.sub-menu');

				if( parent.has('.sub-menu').length == 1 ){
					e.preventDefault();
					parent.toggleClass('active');
					jQuery('.menu-main-container .sub-menu').not(parentsSubMenus).slideUp(300).removeClass('active');
					parent.children('.sub-menu').stop().slideToggle(300).toggleClass('active');
				}
			});
		}

		jQuery('body').click(function(e) {
			if( jQuery(e.target).closest('.menu-main-container').length === 0 ){
				jQuery('.menu-main-container .sub-menu').slideUp(300).removeClass('active');
			}
		});
	}
}
function rb_mobile_menu(){
	jQuery('.site-header-mobile').find('.menu-item').each(function(i, el){
		if( jQuery(el).find('.sub-menu').length != 0 && jQuery(el).find('.sub-menu-trigger').length == 0 ){
			jQuery(el).append('<span class="sub-menu-trigger"></span>');
		}
	});

	jQuery('.menu-trigger').off();
	jQuery('.menu-trigger').on('click', function(){
		jQuery('body').addClass('active');
		jQuery('.site-header-mobile .menu-box').toggleClass('active');
	});

	jQuery('.sub-menu-trigger').off();
	jQuery('.sub-menu-trigger').on('click', function() {
		if( jQuery(this).parent().hasClass('active') ){
			jQuery(this).prev().slideUp();
			jQuery(this).parent().removeClass('active');
		} else {
			var currentParents = jQuery(this).parents('.menu-item');
			jQuery('.sub-menu-trigger').parent().not(currentParents).removeClass('active');
			jQuery('.sub-menu-trigger').parent().not(currentParents).find('.sub-menu').slideUp(300);

			jQuery(this).prev().slideDown();
			jQuery(this).parent().addClass('active');
		}
	});
}
function rb_widget_menu(){
	jQuery('.rb-widget li').has('.sub-menu, .children').prepend('<span class="open"></span>');
	jQuery('.rb-widget li').has('.children').children('.post_count').remove();

	jQuery('.rb-widget li .open').on('click', function() {
		var triggeredList = jQuery(this).parent();

		triggeredList.toggleClass('active');
		triggeredList.children('.children, .sub-menu').stop().slideToggle(300);
	});
}
function rb_blog_fix_divider(){
	jQuery('.post-date:only-child').each(function(i, el){
		if( jQuery(el).css('display') == 'none' ){
			jQuery(el).parent().addClass('hidden');
		}
	});
}
function rb_show_sidebar(){
	setTimeout(function(){
		var wH = jQuery(window).height();
		var dH = jQuery(document).height();
		var el = jQuery('.sidebar_trigger');
		var show = jQuery('.sticky_footer').length != 0 ? dH - jQuery('.sticky_footer').height() : dH;

		if( (wH * 2) > dH ){
			el.addClass('active');
		} else {
			jQuery(window).scroll(function() {
				if( (wH + jQuery(this).scrollTop()) >= (show * 0.7) ){
					el.addClass('active');
				} else {
					el.removeClass('active');
				}
			});
		}

		jQuery(el).on('click', function() {
			jQuery('body').addClass('show_sidebar').addClass('active');
		});

		jQuery('.close_sidebar').on('click', function() {
			jQuery('body').removeClass('show_sidebar').removeClass('active');
		});
	}, 1);
}
function rb_click_overlay(){
	jQuery('.body-overlay').on('click', function() {
		jQuery('body').removeClass('active').removeClass('show_sidebar');

		// Site Search default
		jQuery('.site-search').slideUp(300);

		// Mini Cart defaults
		jQuery('.mini-cart').removeClass('active');

		// Custom sidebars defaults
		jQuery('.custom_sidebars_wrapper').removeClass('active');
		jQuery('.custom_sidebars_wrapper').find('aside').hide();

		// Mobile menu defaults
		jQuery('.site-header-mobile .menu-box').removeClass('active');
		setTimeout(function(){
			jQuery('.site-header-mobile .menu-box .menu').css('left', '0');
			jQuery('.site-header-mobile .close-menu').removeClass('back');
		}, 300);
	});
}
function rb_masonry(){
	if( !is_mobile() ){
		setTimeout(function(){
			
			if( jQuery('div.blog .content_inner.masonry').length != 0 ){
				jQuery('div.blog .content_inner.masonry').masonry({
					itemSelector: 'div.blog .content_inner.masonry .post',
					columnWidth: 'div.blog .content_inner.masonry .post',
				});
			}

			if( jQuery('.rb_gallery_images').length != 0 ){
				jQuery('.rb_gallery_images').each(function(i, el){
					if( jQuery(el).hasClass('masonry') ){
						jQuery(el).masonry({
							itemSelector: '.rb_gallery_image',
							columnWidth: '.rb_gallery_image',
						});
					}
				});
			}

		}, 300);

		if( jQuery('.rb-widget .gallery').length != 0 ){
			jQuery('.rb-widget .gallery').masonry({
				itemSelector: '.rb-widget .gallery .gallery-item',
				columnWidth: '.rb-widget .gallery .gallery-item',
			});
		}
	}
}
function rb_carousel(){
	jQuery( '.rb_carousel_wrapper' ).each( function() {

		var this_is = jQuery(this);

		if( this_is.find('.rb_carousel > *').length <= this_is.data('columns') ){
			return true;
		}

		/* -----> Getting carousel attributes <-----*/	
		if( this_is.hasClass('rb_portfolio_items') ){
			var slidesToShow = rb_potfolio_get_columns(this_is);
		} else {
			var slidesToShow = this_is.data('columns');
		}
		var slidesToScroll = jQuery.isNumeric(this_is.data('slides-to-scroll')) ? this_is.data('slides-to-scroll') : 1;
		var infinite = this_is.data('infinite') == 'on';
		var pagination = this_is.data('pagination') == 'on';
		var navigation = this_is.data('navigation') == 'on';
		var autoHeight = this_is.data('auto-height') == 'on';
		var draggable = this_is.data('draggable') == 'on';
		var autoplay = this_is.data('autoplay') == 'on';
		var autoplaySpeed = this_is.data('autoplay-speed');
		var pauseOnHover = this_is.data('pause-on-hover') == 'on';
		var vertical = this_is.data('vertical') == 'on';
		var verticalSwipe = this_is.data('vertical-swipe') == 'on';
		var tabletLandscape = this_is.data('tablet-landscape');
		var tabletPortrait = this_is.data('tablet-portrait');
		var mobile = this_is.data('mobile');
		var carousel = this_is.children('.rb_carousel');
		var rtl = jQuery('body').hasClass('rtl');

		if( carousel.length == 0 ){
			carousel = this_is.find('.products.rb_carousel'); //Need for woocommerce shortcodes 
		}
		var responsive = { responsive: [] }

		/* -----> Collect attributes in aruments object <-----*/	
		var args = {
			slidesToShow: slidesToShow,
			slidesToScroll: slidesToScroll,
			infinite: infinite,
			dots: pagination,
			arrows: navigation,
			adaptiveHeight: autoHeight,
			draggable: draggable,
			swipeToSlide: true,
			swipe: true,
			touchMove: true,
			touchThreshold: 10,
			autoplay: autoplay,	
			autoplaySpeed: autoplaySpeed,
			pauseOnHover: pauseOnHover, 
			vertical: vertical,
			verticalSwiping: verticalSwipe,
			rtl: rtl,
			margin: 20,
		}

		/* -----> Responsive rules <----- */
		if( typeof tabletLandscape !== 'undefined' )
			responsive.responsive.push( rb_carousel_responsive_array(1200, tabletLandscape) );
		
		if( typeof tabletPortrait !== 'undefined' )
			responsive.responsive.push( rb_carousel_responsive_array(992, tabletPortrait) );

		if( typeof mobile !== 'undefined' ){
			responsive.responsive.push( rb_carousel_responsive_array(768, mobile) );
		} else {
			if( this_is.parent().hasClass('layout_carousel') ){
				responsive.responsive.push( rb_carousel_responsive_array(768, 3) );
				responsive.responsive.push( rb_carousel_responsive_array(480, 1) );
			} else {
				responsive.responsive.push( rb_carousel_responsive_array(768, 1) );
			}
		}

		
		args = jQuery.extend({}, args, responsive);

		/* -----> Carousel init <-----*/	
		var carousel_obj = carousel.slick(args);
	});
}
function rb_carousel_responsive_array( res, cols ){
	var out = {
		breakpoint: res,
		settings: {
			slidesToShow: cols,
			slidesToScroll: 1,
		}
	};

	if( res == 768 ){
		out.settings['adaptiveHeight'] = true;
	}

	return out;
}
function rb_custom_carousel(){
	jQuery( '.rb_custom_carousel' ).each( function(i, el){
		var this_is = jQuery(this);
		var columns = '3';
		var custom_columns = this_is.attr('class');
		var rtl = jQuery('body').hasClass('rtl');

		custom_columns = custom_columns.match(/columns-(.*[0-9])/);

		if( custom_columns.length ){
			columns = custom_columns[1];
		}


		this_is.slick({
			slidesToShow: columns,
			slidesToScroll: 1,
			draggable: true,
			dots: true,
			arrows: false,
			rtl: rtl,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
					}
				}
			]
		});
	});
}
function rb_page_preloader(){
	setTimeout(function() {
		jQuery('.rb-blank-preloader').addClass('disabled');
	}, 400);
}
function rb_magnific_popup_init(){
	jQuery('.rb_gallery_images').each(function(i, el){
		if( jQuery(el).hasClass('magnific') ){
			jQuery(el).magnificPopup({
				delegate: '.rb_gallery_image',
				type: 'image',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					tCounter: ''
			    }
			});
		}
	});

	jQuery('.rb_popup_video_module').each(function(i, el){
		jQuery(el).magnificPopup({
			delegate: '.video-link',
			type: 'iframe',
		});
	});
}
function rb_baner_hover(){
	if( not_desktop() ){

		jQuery('.rb_banner_module.style_1').on('click', function(e){
			if( !jQuery(this).hasClass('active') ) {
				e.preventDefault();
			}

			jQuery('.rb_banner_module.style_1').removeClass('active');				
			jQuery(this).addClass('active');
		});

	}
}
function rb_scroll_to_top(){
	jQuery(window).on('scroll', function() {
		if( jQuery(this).scrollTop() > 500 ){
			jQuery('.button-up').addClass('active');
		} else {
			jQuery('.button-up').removeClass('active');
		}
	});

	jQuery('.button-up').on('click', function() {
		jQuery('html, body').animate({
			scrollTop: 0
		}, 1000)
	});
}
function rb_wishlist_hidden_title(){
	var this_is = jQuery('.wishlist_hidden_title');
	var wishlist = this_is.next();

	this_is.appendTo(wishlist);
}
function rb_custom_sidebars(){
	var sidebar_area = jQuery('.custom_sidebars_wrapper');

	jQuery('.custom_sidebar_trigger').on('click', function(e){
		e.preventDefault();

		var sidebar = jQuery(this).data('sidebar');
		sidebar_area.find('aside.'+sidebar).show();

		setTimeout(function(){
			jQuery('body').addClass('active');
			sidebar_area.addClass('active');
		}, 50);
	});

	sidebar_area.find('.close_custom_sidebar').on('click', function(){
		sidebar_area.find('aside').hide();
		sidebar_area.removeClass('active');
		jQuery('body').removeClass('active');
	});
}
function rb_sticky_menu(){
	var windowWidth = jQuery(window).width();

	if( jQuery('#site').hasClass('desktop-menu-desktop') ){

		if( windowWidth > 1199 ){
			var sticky = jQuery('.site-sticky:not(.sticky-mobile)').length != 0 ? jQuery('.site-sticky:not(.sticky-mobile)') : jQuery('.rb_sticky_template');
			var menu = jQuery('.site-header').length != 0 ? jQuery('.site-header') : jQuery('.rb_header_template');		
		} else {
			var sticky = jQuery('.site-sticky.sticky-mobile');
			var menu = jQuery('.site-header-mobile');
		}

	} else if( jQuery('#site').hasClass('desktop-menu-landscape') ){

		if( windowWidth > 991 ){
			var sticky = jQuery('.site-sticky:not(.sticky-mobile)').length != 0 ? jQuery('.site-sticky:not(.sticky-mobile)') : jQuery('.rb_sticky_template');
			var menu = jQuery('.site-header').length != 0 ? jQuery('.site-header') : jQuery('.rb_header_template');
		} else {
			var sticky = jQuery('.site-sticky.sticky-mobile');
			var menu = jQuery('.site-header-mobile');
		}

	} else if( jQuery('#site').hasClass('desktop-menu-both') ){

		if( windowWidth > 767 ){
			var sticky = jQuery('.site-sticky:not(.sticky-mobile)').length != 0 ? jQuery('.site-sticky:not(.sticky-mobile)') : jQuery('.rb_sticky_template');
			var menu = jQuery('.site-header').length != 0 ? jQuery('.site-header') : jQuery('.rb_header_template');
		} else {
			var sticky = jQuery('.site-sticky.sticky-mobile');
			var menu = jQuery('.site-header-mobile');
		}
	}

	if( sticky.length != 0 ){
		var startScroll = document.documentElement.scrollTop;
		var show = menu.height() * 2;

		if( startScroll > show ){
			sticky.addClass('active');
		}

		jQuery(window).scroll(function(){
			if( jQuery(this).scrollTop() > show ){
				sticky.addClass('active');
			} else {
				sticky.removeClass('active');
				sticky.find('.sub-menu').removeClass('active').slideUp(300);
			}
		});
	}
}
function rb_footer_on_bottom(){
	setTimeout(function(){

		var footer = jQuery('.rb_footer_template, #site-footer');
		var bodyHeight = jQuery('#site').height() - footer.outerHeight();
		var windowHeight = jQuery(window).height();

		if( !footer.hasClass('sticky_footer') ){
			if( windowHeight > bodyHeight && footer.outerHeight() + 100 < windowHeight - bodyHeight ){
				footer.addClass('bottom');
			} else {
				footer.removeClass('bottom');
			}
		}

	}, 300);
}
function rb_megamenu_pos(){
	if( !not_desktop() ){

		var rightOffset = jQuery('.main-content').offset().left;

		setTimeout(function(){

			jQuery('.menu-item-object-rb-megamenu').each(function(i, el) {

				var width = jQuery(el).find('.rb_megamenu_item').data('width');
				var position = jQuery(el).find('.rb_megamenu_item').data('position');

				if( width != 'full_width' ){
					if( width != 'content_width' ){
						jQuery(el).find('.sub-menu').css('width', width);
					}

					if( position == 'center' ){
						var menuOffset = jQuery(this).offset().left;
						var offset = menuOffset - rightOffset - 15;

						jQuery(this).find('.sub-menu').css({
							'margin-left': '-'+offset+'px',
							'left': '0'
						});
					} else if( position == 'depend' ){
						var menuOffset = jQuery(this).offset().left;
						var menuWidth = jQuery(this).find('.sub-menu').width();
						var windowWidth = jQuery(window).width();

						if( menuWidth + menuOffset > windowWidth ){
							jQuery(this).find('.sub-menu').css({
								'left': 'auto',
								'right': '-10px'
							});
						}
					}
				} else {
					var menuOffset = jQuery(this).offset().left;
					jQuery(this).find('.sub-menu').css({
						'margin-left': '-'+menuOffset+'px',
						'width': '100vw'
					});
				}

			});

		}, 50);


	} else {
		jQuery('.menu-item-object-megamenu_item .sub-menu').css({
			'margin-left': '0',
			'width': '100vw'
		});
	}
}
function rb_sticky_footer(){
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery(window).height();
	var footerHeight = jQuery('.rb_footer_template, #site-footer').innerHeight();
	var bodyHeight = jQuery('#site').height();
	var footer = jQuery('.sticky_footer');
	var content = jQuery('.before_footer_shortcode').length != 0 ? jQuery('.before_footer_shortcode') : jQuery('.site-content');

	if( footer.length != 0 && windowWidth > 991 ){
		if( bodyHeight < windowHeight && windowHeight - bodyHeight < footerHeight ){
			footer.removeClass('sticky_footer');
			content.css('margin-bottom', '0');
		} else {
			content.css('margin-bottom', Math.round(footerHeight)+'px');
			content.css('padding-bottom', '100px');

			jQuery(window).scroll(function(){
				if( jQuery(this).scrollTop() < 100 && footerHeight > windowHeight / 2 ){
					footer.css('opacity', '0');
				} else {
					footer.css('opacity', '1');
				}
			});
		}
	} else {
		footer.css('opacity', '1');
		content.css('margin-bottom', '0');
	}
}
function rb_presentation(){
	if( !not_desktop() ){
		jQuery('.rb_presentation_module').each(function(i, el){
			var height = jQuery(el).find('.presentation_tab').height();
			jQuery(el).css('padding-bottom', height+'px');
		});
	}

	jQuery('.presentation_trigger').on('click', function(){
		var this_is = jQuery(this);

		if( !this_is.hasClass('active') ){
			var currentTab = jQuery(this).data('tab');

			jQuery('.presentation_tab').removeClass('active');
			jQuery('.presentation_trigger').removeClass('active');

			jQuery('[data-tab="'+currentTab+'"]').addClass('active');

			setTimeout(function(){
	 			var currentHeight = jQuery('div[data-tab="'+currentTab+'"]').height();
				this_is.closest('.rb_presentation_module').css('padding-bottom', currentHeight+'px');
			}, 125);
		}
	});

	if( !not_desktop() ){
		jQuery('.presentation_image_wrapper').on('mouseover', function(){
			var image = jQuery(this).find('.presentation_img');
			var imageHeight = image.height();
			var thisHeight = jQuery(this).innerHeight();

			if( imageHeight > thisHeight ){
				var different = imageHeight - thisHeight;
				jQuery(image).css('transform', 'translateY(-'+different+'px)');
				jQuery(image).css('-webkit-transform', 'translateY(-'+different+'px)');
				jQuery(image).css('-webkit-transition', (different*4)+' linear');
				jQuery(image).css('transition', (different*4)+'ms linear');
			}
		});

		jQuery('.presentation_image_wrapper').on('mouseout', function(){
			jQuery(this).find('.presentation_img').css('transform', 'translateY(0px)');
			jQuery(this).find('.presentation_img').css('-webkit-transform', 'translateY(0px)');
		});
	}
}
function rb_move_background(){
	if( !not_desktop() && jQuery('.page_title_container').hasClass('mouse_anim') ){
		x += (lFollowX - x) * friction;
		y += (lFollowY - y) * friction;
		
		var translate = 'translate( calc(-50% + '+x+'px), calc(-50% + '+y+'px) )';

		jQuery('.page_title_dynamic_image').css({
		  '-webit-transform': translate,
		  '-moz-transform': translate,
		  'transform': translate
		});

		window.requestAnimationFrame(rb_move_background);
	}
}
function rb_smooth_title(){
	var pageTitle = jQuery('.page_title_wrapper');

	if( pageTitle.length > 0 && !not_desktop() && jQuery('.page_title_container').hasClass('scroll_anim') ){
		var titleTop = pageTitle.offset().top;
		var titleHeight = pageTitle.innerHeight();
		var spaceToBtm = parseInt(jQuery('.page_title_container').css('padding-bottom'));

		jQuery(window).scroll(function(){
			if( jQuery(this).scrollTop() < titleTop + spaceToBtm ){

				var shift = (jQuery(this).scrollTop() + 1) / (titleTop + spaceToBtm) * 100;
				var opacity = 1 - (shift / 100);

				pageTitle.css('-webkit-transform', 'translateY('+shift+'px)');
				pageTitle.css('transform', 'translateY('+shift+'px)');
				pageTitle.css('opacity', opacity * 2);
			}
		});
	}
}
function rb_extended_services_size(){
	jQuery('.extended_services_shape').each(function(i, el){
		var scaleY = jQuery(el).parent().innerHeight() / 100;
		var scaleX = jQuery(el).parent().innerWidth() / 100;

		if( is_mobile() && jQuery(el).parent().hasClass('style_hexagon') ){
			jQuery(el).css('transform', 'translate(-50%, -50%) scale(2.9, 2.9)');
		} else {
			jQuery(el).css('transform', 'translate(-50%, -50%) scale('+scaleX+', '+scaleY+')');
		}
	});
}
function rb_close_info_box(){
	jQuery('.close_info_box').on('click', function(){
		jQuery(this).parents('.rb_info_box').fadeOut(300);
	});
}
function rb_progress_bar(){
	var wHeight = jQuery(window).height();

	jQuery('.rb_progress_bar_module').each(function(i, el){
		var top = jQuery(el).offset().top;
		var height = jQuery(el).innerHeight();
		var barWidth = parseInt(jQuery(el).find('.bar').data('percent'));
		var transition = barWidth * 20;

		jQuery(el).find('.bar').css({
			"transition": transition+"ms",
			"-webkit-transition": transition+"ms"
		});

		jQuery(window).scroll(function(){
			if( jQuery(this).scrollTop() + wHeight > top + height ){
				jQuery(el).find('.bar').addClass('visible').width( barWidth+'%' );
			}
		});

	});
}
function rb_progress_bar_width(){
	jQuery('.rb_progress_bar_module').each(function(i, el){
		var barWidth = parseInt(jQuery(el).find('.bar').data('percent'));
		var title = jQuery(el).children('p');
		var titleWidth = (title.width() + 15) / jQuery(el).width() * 100;

		if( barWidth < titleWidth ){
			jQuery(el).find('.percents').hide();
		} else {
			jQuery(el).find('.percents').show();
		}
	});
}
function rb_icons_wheel_init(){
	jQuery('.rb_icons_wheel_module').each(function(i, el){
		//Animate icons when module is visible
		var module_offset = jQuery(el).offset().top;
		var module_show = jQuery(el).innerHeight() / 2;

		if( jQuery(window).scrollTop() + (jQuery(window).height() - module_show) >= module_offset ){
			jQuery(el).find('.icons_wheel_wrapper').addClass('active');
			jQuery(el).find('.circle_wrapper').addClass('active');

			setTimeout(function(){
				jQuery(el).find('.icons_wheel_wrapper').addClass('done');
			}, 1400);
		}

		jQuery(window).on('scroll', function() {
			if( jQuery(window).scrollTop() + (jQuery(window).height() - module_show) >= module_offset ){
				jQuery(el).find('.icons_wheel_wrapper').addClass('active');
				jQuery(el).find('.circle_wrapper').addClass('active');

				setTimeout(function(){
					jQuery(el).find('.icons_wheel_wrapper').addClass('done');
				}, 1400);
			}
		});

		//Wait for animation
		setTimeout(function(){
			//Init main icons_wheel script
			if( jQuery(el).hasClass('on_hover') && !not_desktop() ){
				rb_icons_wheel(jQuery(el), 'hover');
			} else {
				rb_icons_wheel(jQuery(el), 'click');
			}

			//Module Autoplay
			if( jQuery(el).hasClass('autoplay') ){
				var speed = jQuery(el).data('speed');
				
				//Autoplay init
				var wheel_interval = setInterval(function() {
					rb_icons_wheel_autoplay(jQuery(el));
				}, speed);

				if( jQuery(el).hasClass('on_hover') && !not_desktop() ){
					//Remove autoplay on hover and start on hover off
					jQuery(el).find('.icon_wrapper').hover(function() {
						window.clearInterval(wheel_interval);
					}, function() {
						wheel_interval = setInterval(function() {
							rb_icons_wheel_autoplay( jQuery(el) );
						}, speed);
					});
				} else {
					//Remove autoplay on click
					jQuery(el).find('.icon_wrapper').on('click', function() {
						window.clearInterval(wheel_interval);
					});
				}
			}
		}, 1400);
	});
}

function rb_icons_wheel(el, active_trigger){
	jQuery(el).find('.icon_wrapper').on(active_trigger, function() {
		var trigger = jQuery(this).parent().data('trigger');

		jQuery(this).closest('.icons_wheel_wrapper').find('.icon_wrapper').removeClass('active');
		jQuery(this).addClass('active');

		jQuery(this).closest('.icons_wheel_wrapper').find('.icons_wheel_info').removeClass('active');
		jQuery(this).closest('.icons_wheel_wrapper').find('.icons_wheel_info[data-id="'+trigger+'"]').addClass('active');
	});
}

function rb_icons_wheel_autoplay(el, speed){
	var active_el = jQuery(el).find('.icon_wrapper.active');
	var nextEl = active_el.parent().nextAll('.icons_wheel_icon');
	nextEl = nextEl[0];

	if( typeof nextEl == 'undefined'){
		nextEl = jQuery(el).find('.icons_wheel_icon:first-child');
	}
	
	jQuery(el).find('.icon_wrapper').removeClass('active');
	jQuery(nextEl).find('.icon_wrapper').addClass('active');

	jQuery(el).find('.icons_wheel_info').removeClass('active');
	jQuery(nextEl).next('.icons_wheel_info').addClass('active');
}
function rb_column_animation(){
	setTimeout(function(){
		var animatedColumns = [];
		var checkScroll = 0;
		var windowHeight = jQuery(window).height();

		jQuery('.rb_column_wrapper.animated').each(function(i, el){
			var module_offset = jQuery(el).offset().top;
			var module_show = windowHeight - jQuery(el).innerHeight() / 2;

			animatedColumns[i] = [ jQuery(el), module_show, module_offset ];

			if( jQuery(window).scrollTop() + module_show >= module_offset ){
				jQuery(el).addClass('loaded');
			}
		});

		jQuery(window).on('scroll', function(){
			var currentScroll = jQuery(this).scrollTop();

			if( currentScroll > checkScroll + 150 ){
				jQuery(animatedColumns).each(function(i, el){
					if( currentScroll + el[1] >= el[2] ){
						el[0].addClass('loaded');
					}
				});

				checkScroll = currentScroll;
			}
		});
	}, 500);
}
function rb_milestone_shape_size(){
	jQuery('.rb_milestone_module').each(function(i, el){
		var width = jQuery(this).innerWidth() / 100;

		jQuery(this).children('svg').css('transform', 'scale('+width+')');
	});
}
function rb_milestones_count(){
	if( jQuery('.count_wrapper').length > 0 ){
		jQuery('.count_wrapper .counter').counterUp({
			delay: 10,
			time: 1000
		});
	}
}
function rb_particles_init(){
	var particlesID = '';
	var particlesColor = '#3e4a59';
	var particlesSpeed = 2;
	var particlesSize = 10;
	var particlesLinked = false;
	var particlesCount = 25;
	var particlesShape = 'circle';
	var particlesMode = 'out';
	var particlesHide = 767;
	var particlesImageUrl = '';
	var particlesImageWidth = 100;
	var particlesImageHeight = 100;

	jQuery('.particles-js').each(function(i, el) {

		particlesID = jQuery(el).attr('id');

		if( jQuery(el).data('hide') != undefined ){
			particlesHide = jQuery(el).data('hide');
		}

		if( jQuery(window).width() > particlesHide ){

			/* -----> Grab data attributes <----- */
			if( jQuery(el).data('color') != undefined ){
				particlesColor = jQuery(el).data('color');
			}
			if( jQuery(el).data('speed') != undefined ){
				particlesSpeed = jQuery(el).data('speed');
			}
			if( jQuery(el).data('size') != undefined ){
				particlesSize = jQuery(el).data('size');
			}
			if( jQuery(el).data('linked') != undefined ){
				particlesLinked = jQuery(el).data('linked') == 1 ? true : false;
			}
			if( jQuery(el).data('count') != undefined ){
				particlesCount = jQuery(el).data('count');
			}
			if( jQuery(el).data('shape') != undefined ){
				particlesShape = jQuery(el).data('shape');
			}
			if( jQuery(el).data('mode') != undefined ){
				particlesMode = jQuery(el).data('mode');
			}
			if( jQuery(el).data('image-url') != undefined ){
				particlesImageUrl = jQuery(el).data('image-url');
			}
			if( jQuery(el).data('image-width') != undefined ){
				particlesImageWidth = jQuery(el).data('image-width');
			}
			if( jQuery(el).data('image-height') != undefined ){
				particlesImageHeight = jQuery(el).data('image-height');
			}

			/* -----> Particles Init <----- */
			particlesJS(particlesID,
			  {
			    "particles": {
			      "number": {
			        "value": particlesCount,
			        "density": {
			          "enable": false,
			          "value_area": 200
			        }
			      },
			      "color": {
			        "value": particlesColor
			      },
			      "shape": {
			        "type": particlesShape,
			        "stroke": {
			          "width": 0,
			          "color": "#000000"
			        },
			        "polygon": {
			          "nb_sides": 6
			        },
			        "image": {
				      "src": particlesImageUrl,
				      "width": particlesImageWidth,
				      "height": particlesImageHeight
				    }
			      },
			      "opacity": {
			        "value": 1,
			        "random": true,
			        "anim": {
			          "enable": true,
			          "speed": 0.2,
			          "opacity_min": 0.5,
			          "sync": false
			        }
			      },
			      "size": {
			        "value": particlesSize,
			        "random": false,
			        "anim": {
			          "enable": true,
			          "speed": 1,
			          "size_min": particlesSize * 0.7,
			          "sync": false
			        }
			      },
			      "line_linked": {
			        "enable": particlesLinked,
			        "distance": 150,
			        "color": particlesColor,
			        "opacity": 1,
			        "width": 1
			      },
			      "move": {
			        "enable": true,
			        "speed": particlesSpeed,
			        "direction": "none",
			        "random": false,
			        "straight": false,
			        "out_mode": particlesMode,
			        "attract": {
			          "enable": false,
			          "rotateX": 0,
			          "rotateY": 0
			        }
			      }
			    },
			    "interactivity": {
			      "detect_on": "canvas",
			      "events": {
			        "onhover": {
			          "enable": false,
			          "mode": "bubble"
			        },
			        "onclick": {
			          "enable": true,
			          "mode": "push"
			        },
			        "resize": true
			      },
			      "modes": {
			        "push": {
			          "particles_nb": 1
			        }
			      }
			    },
			    "retina_detect": true,
			  }
			);
		}

	});
}
function rb_mask_on_vc_row(){
	jQuery('.rb-content').each(function(i, el){
		if( typeof jQuery(el).data('mask') != 'undefined' ){
			var mask_url = jQuery(el).data('mask');

			jQuery(el).children('.vc_row').css('-webkit-mask-image', 'url('+mask_url+')' );
		}
	});
}
function rb_smooth_comment_anchor(){
	jQuery('.page_title_wrapper .coments_count a').on('click', function(e){
		e.preventDefault();

		jQuery('html, body').animate({
	        scrollTop: jQuery( jQuery.attr(this, 'href') ).offset().top - 125
	    }, 700);

	});
}
function rb_simple_staff_style(){
	if( not_desktop() ){
		jQuery('.rb_our_team_module').removeClass('style_advanced').addClass('style_simple');
	}
}
function rb_sticky_sidebar(){
	jQuery('.main-content-inner.sticky_sb').find('aside.sidebar').stickySidebar({ 
		topSpacing: 150,
		bottomSpacing: 40,
		minWidth: 1200
	});
}
function rb_share_title_bg(){
	var title = jQuery('.page_title_container');
	var titlePT = parseInt(title.css('padding-top'));

	if( title.hasClass('shared_bg') && jQuery('.site-header-mobile').css('display') == 'none' ){
		var menuH = title.hasClass('custom') ? title.closest('.rb-content').prev().height() : title.parent().find('.menu-box').height();

		title.css('padding-top', menuH+titlePT+'px');

		if( title.hasClass('custom') ){
			title.closest('.rb-content').prev().addClass('absolute');
		} else {
			jQuery('.menu-box').addClass('absolute');
		}
	}
}
function rb_3d_images(){
	jQuery('.rb_image_module.background_3d').each(function(i, el){

		var max_tilt = jQuery(el).data('max_tilt');
		var perspective = jQuery(el).data('perspective');
		var scale = jQuery(el).data('scale');
		var speed = jQuery(el).data('speed');

		var tilt = jQuery(el).tilt({
			maxTilt:        max_tilt,
			perspective:    perspective,
			easing:         "cubic-bezier(.03,.98,.52,.99)",
			scale:          scale,
			speed:          speed,
			transition:     true,
			disableAxis:    null,
			reset:          true,
			glare:          false,
			maxGlare:       1
		});

		tilt.tilt.reset.call(tilt);

	});
}
function rb_centered_menu(){
	if( !not_desktop() ){
		var logoWidth = jQuery('.site-header .menu-box .site_logotype').width();
		var rightInfoWidth = jQuery('.site-header .menu-box .menu-right-info').width();

		var minWidth = logoWidth < rightInfoWidth ? rightInfoWidth : logoWidth;

		jQuery('.site-header .menu-box .site_logotype, .site-header .menu-box .menu-right-info').css('min-width', parseInt(minWidth)+'px');
	}
}
function rb_our_team_hover_on_devices(){
	if( not_desktop() ){
		jQuery('.rb_team_member').on('click', function(e){

			var this_is = jQuery(this);

			if( !this_is.hasClass('device_hover') ){
				e.preventDefault();

				jQuery('.rb_team_member').removeClass('device_hover');
				this_is.addClass('device_hover');
			}
		});
	}
}
function rb_product_hover_on_devices(){
	if( not_desktop() ){
		jQuery('ul.products > li.product').on('click', function(e){

			var this_is = jQuery(this);

			if( !this_is.hasClass('device_hover') ){
				e.preventDefault();

				jQuery('ul.products > li.product').removeClass('device_hover');
				this_is.addClass('device_hover');
			}
		});
	}
}
function rb_fix_layout_paddings(){
	var content = jQuery('.main-content-inner-wrap').text().replace(/\s/g,'');
	if( content.length == 0 ){
		jQuery('#site-content').css('padding-top', '0');
	}
}
function rb_tips_touch(){
	if( not_desktop() ){
		jQuery('.rb_tip').on('click', function(e){
			if( !jQuery(this).hasClass('active') ){
				e.preventDefault();
			}

			jQuery('.rb_tip').removeClass('active');
			jQuery(this).addClass('active');
		});

		jQuery('body').click(function(e) {
			if( jQuery(e.target).closest('.rb_tip').length === 0 ){
				jQuery('.rb_tip').removeClass('active');
			}
		});
	}
}

} ).call( this, jQuery )