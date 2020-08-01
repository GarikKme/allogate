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
function not_desktop(){
	if( (window.innerWidth < 1367 && is_mobile_device()) || window.innerWidth < 1200 ){
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
function is_mobile_portrait () {
	if ( window.innerWidth < 480 ){
		return true;
	} else {
		return false;
	}
}
function rb_destroy_masonry(){
	if( is_mobile_portrait() && jQuery('.layout_masonry').length != 0 ){
		jQuery('.layout_masonry').find('.rb_portfolio_items').isotope( 'destroy' );
	}
}

/* ===========> Scripts Init <=========== */
window.addEventListener( "load", function() {
	rb_portfolio_types();
	rb_portfolio_isotope();
	rb_portfolio_loadmore();
	rb_portfolio_asymmetric();
	rb_carousel_wide();
	rb_motion_category_fix();
	rb_portfolio_hover_on_devices();
	rb_motion_category_mobile();
});

jQuery(window).on('resize', function(){
	rb_destroy_masonry();
});

/* ===========> rb_portfolio_asymmetric() variables prepare <=========== */
var lFollowY = 0;
var y = 0;
var friction = 1 / 30;

/* ===========> Scripts Declaration <=========== */

function rb_portfolio_types(){
	setTimeout(function(){
		var el = jQuery('.portfolio-single-content');

		if( el.hasClass('type_small_images') || el.hasClass('type_small_slider') || el.hasClass('type_small_masonry') ){
			jQuery('.portfolio-content-wrapper').stickySidebar({ 
				topSpacing: 180,
				bottomSpacing: 60,
				minWidth: 767
			});
		}
	}, 400);
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
function rb_masonry_elements_set_size(element, spacings){
	element.each(function(i, el){
		var columns = jQuery(el).closest('.rb_portfolio_module').data('columns');
		var currentWidth = (jQuery(el).closest('.rb_portfolio_items').width() / columns) - spacings;

		var masonryWidth = jQuery(el).data('masonry-width') > 0 ? jQuery(el).data('masonry-width') : 1;
		var masonryHeight = jQuery(el).data('masonry-height') > 0 ? jQuery(el).data('masonry-height') : 1;

		var widthSpace = spacings * jQuery(el).data('masonry-width') - spacings;
		var heightSpace = spacings * jQuery(el).data('masonry-height') - spacings;

		jQuery(el).width(masonryWidth * currentWidth + widthSpace);
		jQuery(el).height(masonryHeight * currentWidth + heightSpace);
	});

	if( is_mobile_portrait() ){
		element.width('100%');
		element.height('100%');
	}
}
function rb_portfolio_isotope(){
	if( jQuery('.layout_grid_filter').length != 0 ){
		jQuery('.layout_grid_filter').each(function(i, el){
			jQuery(el).find('.rb_portfolio_items').isotope({
				filter: '.all'
			});

			jQuery(el).find('.portfolio-filter-trigger').off();
			jQuery(el).find('.portfolio-filter-trigger').on('click', function(){
				var filter = jQuery(this).data('value');

				jQuery(el).find('.portfolio-filter-trigger').removeClass('active');
				jQuery(this).addClass('active');

				jQuery(el).find('.rb_portfolio_items').isotope({
					filter: '.'+filter,
					masonry: {
						columnWidth: '.rb_portfolio_item'
					}
				});
			});
		});
	}

	if( jQuery('.layout_masonry').length != 0 ){
		jQuery('.layout_masonry').each(function(i, el){

			if( jQuery(el).data('spacings') ){
				var spacings = 30;
			} else {
				var spacings = 0;
			}

			rb_masonry_elements_set_size(jQuery(el).find('.rb_portfolio_items .rb_portfolio_item'), spacings);

			jQuery(window).resize( function(){
				rb_masonry_elements_set_size(jQuery(el).find('.rb_portfolio_items .rb_portfolio_item'), spacings);
			});

			if( !is_mobile_portrait() ){
				setTimeout(function(){
					jQuery(el).find('.rb_portfolio_items').isotope({
						itemSelector: ".rb_portfolio_item",
						percentPosition: true,
						layoutMode: 'masonry',
						masonry: {
							columnWidth: '.grid-sizer',
						}
					});
				}, 200);
			}

		});
	}

	if( jQuery('.layout_pinterest').length != 0 ){
		jQuery('.layout_pinterest').each(function(i, el){

			setTimeout(function(){
				jQuery(el).find('.rb_portfolio_items').isotope({
					layoutMode: 'masonry'
				});
			}, 200);
		});
	}

	if( 
		jQuery('.layout_masonry').length != 0 || 
		jQuery('.layout_pinterest').length != 0 || 
		jQuery('.layout_asymmetric').length != 0 
	){
		rb_portfolio_animate( jQuery('.layout_masonry, .layout_pinterest, .layout_asymmetric').find('.rb_portfolio_item') );
	}
}
function rb_portfolio_loadmore(){
	var count = 0;

	jQuery('.rb_load_more').on('click', function(){

		var button = jQuery(this);
		var my_module = button.closest('.load_more').prev();
		var query = my_module.data('ajax-query');
		var posts = my_module.data('ajax-posts');
		var page = my_module.data('ajax-page');
		var tax = my_module.data('ajax-tax');
		var hover = my_module.data('ajax-hover');
		var layout = my_module.data('ajax-layout');
		var portfolio_hide_meta = my_module.data('ajax-portfolio_hide_meta');

		if( my_module.data('spacings') ){
			var spacings = 30;
		} else {
			var spacings = 0;
		}

		var data = {
			'action': 'rb_portfolio_loadmore',
			'query': query,
			'posts': posts,
			'page': page+count,
			'tax': tax,
			'hover': hover,
			'layout': layout,
			'portfolio_hide_meta': portfolio_hide_meta
		};

		jQuery.ajax({
			url : rb_ajaxurl,
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...');
			},
			success : function( data ){
				count++;

				if( data ){
					data = jQuery(data);

					setTimeout(function() {
						my_module.find('.rb_portfolio_items').append(data);

						if( my_module.hasClass('layout_masonry') ){
							rb_masonry_elements_set_size(my_module.find('.rb_portfolio_item'), spacings);
						}

						if( 
							my_module.hasClass('layout_grid_filter') || 
							my_module.hasClass('layout_masonry') || 
							my_module.hasClass('layout_pinterest')
						){
							my_module.find('.rb_portfolio_items').isotope( 'appended', data );
						}

						if( 
							jQuery('.layout_masonry').length != 0 || 
							jQuery('.layout_pinterest').length != 0 || 
							jQuery('.layout_asymmetric').length != 0 
						){
							rb_portfolio_animate( jQuery('.layout_masonry, .layout_pinterest, .layout_asymmetric').find('.rb_portfolio_item') );
						}

						if( jQuery('.layout_asymmetric').length != 0 ){
							rb_portfolio_asymmetric();
						}

					}, 300);

					if( posts.length > count + 1 ){
						button.text('More Posts');
					} else {
						button.remove();
					}
				}
			},
			error : function(){
				alert('Something goes wrong');
			}
		});

	});
}
function rb_portfolio_animate(element){
	element.each(function(i, el){
		var transitionSpeed = 1050 + Math.floor(Math.random() * 300);
		var transitionDelay = 100 + Math.floor(Math.random() * 300);

		jQuery(el).css({
			'transition': "all "+transitionSpeed+"ms cubic-bezier(0.35, 0.71, 0.26, 0.88) "+transitionDelay+"ms",
			'-webkit-transition': "all "+transitionSpeed+"ms cubic-bezier(0.35, 0.71, 0.26, 0.88) "+transitionDelay+"ms",
		});
	});

	element.addClass('loaded');

	setTimeout(function(){
		element.css({
			'transition': 'none',
			'-webkit-transition': 'none'
		});
	}, 1850);
}
function rb_portfolio_asymmetric(){
	if( jQuery('.layout_asymmetric').length != 0 && !is_mobile_portrait() ){
		setTimeout(function(){
			jQuery('.layout_asymmetric').find('.rb_portfolio_item:nth-child(2), .rb_portfolio_item:nth-child(4n+2), .rb_portfolio_item:nth-child(4n-1)').each(function(i, el){
				jQuery(el).attr('data-parallax', '{"y":-30,"smoothness":50}');
			});
		}, 1900);
	}
}
function rb_carousel_wide(){
	jQuery('.open_info').on('click', function(){

		var this_is = jQuery(this);
		var parent = this_is.parent();

		parent.toggleClass('active');

		if( parent.hasClass('active') ){
			this_is.prevAll().hide();
			setTimeout(function(){
				this_is.next().fadeIn();
			}, 250);
		} else {
			this_is.next().fadeOut(300);
			setTimeout(function(){
				this_is.prevAll().fadeIn(300);
			}, 400);
		}
	});

	// Hide advanced info boxes after slide change
	var carousel = jQuery('.layout_carousel_wide .rb_carousel_wrapper');

	if( carousel.length != 0 ){
		carousel.on('afterChange', function(){
			var otherSlides = carousel.find('.slick-slide').not('.slick-active');

			otherSlides.find('.hidden_info').removeClass('active');

			otherSlides.find('.hidden_info > p, .hidden_info > .h5').show();
			otherSlides.find('.advanced_info').hide();
		});
	}
}
function rb_motion_category_fix(){
	var windowHeight = Math.ceil(jQuery(window).height() * 0.8); // 0.8 from styles ( max-height = 80vh )

	if( jQuery('.layout_motion_category').length != 0 ){

		jQuery('.layout_motion_category .rb_portfolio_items_wrapper').each(function(i, el){

			if( jQuery(el).height() == windowHeight ){

				jQuery(el).find('.rb_portfolio_items').css('margin-right', '-17px');
			}

		});

	}
}
function rb_portfolio_hover_on_devices(){
	if( not_desktop() ){
		jQuery('.rb_portfolio_item .image_wrapper a').on('click', function(e){

			var this_is = jQuery(this);

			if( !this_is.closest('.image_wrapper').hasClass('device_hover') && this_is.closest('.rb_portfolio_module').is('.hover_overlay, .hover_slide_left, .hover_slide_bottom') ){
				e.preventDefault();

				jQuery('.rb_portfolio_item .image_wrapper').removeClass('device_hover');
				this_is.closest('.image_wrapper').addClass('device_hover');
			}
		});
	}
}
function rb_motion_category_mobile(){
	if( is_mobile() && jQuery('.layout_motion_category').length != 0 ){

		jQuery('.layout_motion_category').each(function(i, el){

			setInterval(function(){

				var currentBg = jQuery(el).find('.mobile_only .portfolio-mobile-motion-cat.active');

				currentBg.hide().removeClass('active');

				if( currentBg.next().length != 0 ){
					currentBg.next().show().addClass('active');
				} else {
					var next = currentBg.parent().find('.portfolio-mobile-motion-cat')[0];
					jQuery(next).show().addClass('active');
				}

			}, 2000);

		});
	}
}

} ).call( this, jQuery )