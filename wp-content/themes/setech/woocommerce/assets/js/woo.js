( function( jQuery ) {
	"use strict";

	function is_mobile () {
		if ( window.innerWidth < 768 ){
			return true;
		} else {
			return false;
		}
	}
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

	/* ===========> Scripts Init <=========== */
	window.addEventListener( "load", function() {
		rb_ajax_add_to_cart();
		rb_trigger_mini_cart();
		rb_smooth_review_link();
		rb_widget_filters();
		rb_product_thumbnails_carousel();
		rb_fix_sticky_product();
		rb_tablet_hover();
		/* ----> Ajax <---- */
		rb_ajax_loop_pagination();
	});

	jQuery(window).resize( function (){
		rb_trigger_mini_cart();
	});

	/* ===========> Scripts Declaration <=========== */
	function rb_trigger_mini_cart(){
		var cart = jQuery('.mini-cart');
		cart.off();

		if( !is_mobile() ){
			if( cart.hasClass('sidebar-view') ){
				jQuery('.mini_cart_trigger').on('click', function(e){
					e.preventDefault();
					cart.addClass('active');
					jQuery('body').addClass('active');

					jQuery('.close_mini_cart').off();
					rb_close_mini_cart();
				});
			} else if ( cart.hasClass('popup-view') ){
				cart.on('mouseover', function(){
					jQuery(this).addClass('active');
				});

				cart.on('mouseleave', function(){
					jQuery(this).removeClass('active');
				});
			}
		}
	}
	function rb_close_mini_cart(){
		jQuery('.close_mini_cart').on('click', function(){
			jQuery('.mini-cart').removeClass('active');
			jQuery('body').removeClass('active');
		});
	}
	function rb_smooth_review_link(){
		jQuery('.woocommerce-review-link').on('click', function(e){
			e.preventDefault();

			document.querySelector(this.getAttribute('href')).scrollIntoView({
	            behavior: 'smooth'
	        });
		});
	}
	function rb_widget_filters(){
		jQuery('ul.woocommerce-widget-layered-nav-list').each(function(i, el){
			var filterBy = jQuery(el).find('.woocommerce-widget-layered-nav-list__item:not(.chosen) > a').one().attr('href');

			if( typeof filterBy != 'undefined' ){
				rb_widget_filter_helper( filterBy, jQuery(el) );
			} else {
				var filteredOne = jQuery(el).find('.woocommerce-widget-layered-nav-list__item > a').one().attr('href');
				rb_widget_filter_helper( filteredOne, jQuery(el) );
			}
		});
	}
	function rb_widget_filter_helper( filter, el ){
		filter = filter.match(/filter_(.*?=)/g);

		var lastMatch = filter.length;
		filter = jQuery(filter).last()[0];

		filter = filter.slice(0, -1);

		if( filter == 'filter_color' ){
			jQuery(el).find('.woocommerce-widget-layered-nav-list__item > a').each(function(k, v){
				var color = jQuery(v).text().toLowerCase();
				jQuery(v).parent().css('background-color', color);
			});
		}

		jQuery(el).closest('.rb-widget').addClass(filter);
	}
	function rb_product_thumbnails_carousel(){
		var count = 0;
		var slider = false;
		var show = jQuery('.woocommerce-product-gallery').data('show');
		var vertical = jQuery('.woocommerce-product-gallery').data('vertical');
		if( show == 'all' ) show = 999;

		if( vertical == 'active' && jQuery(window).width() > 767 ){
			// Carousel init

			jQuery('.woocommerce-product-gallery .flex-control-thumbs li').each(function(i, el) {
				if( !slider ) count++;

				if( count > show ){
					jQuery('.woocommerce-product-gallery .flex-control-thumbs').slick({
						slidesToShow: show,
						slidesToScroll: 1,
						infinite: false,
						arrows: true,
						vertical: true,
						verticalSwiping: true,
						responsive: [
							{
								breakpoint: 991,
								settings: {
									slidesToShow: 3
								}		
							}
						]
					});

					slider = true;
					count = 0;
				}
			});
		}
	}
	function rb_fix_sticky_product(){
		if( jQuery('.rb_sticky_template, .site-sticky').length != 0 && !window.innerWidth < 768 ){
			var stickyH = jQuery('.rb_sticky_template, .site-sticky').height();
			stickyH = stickyH + 10;
			jQuery('.woocommerce.single .content-area .site-main > .type-product .woocommerce-product-gallery, .woocommerce.single .content-area .site-main > .type-product .summary').css('top', stickyH+'px');	
		}
	}

	/* ===========> Ajax Add-To-Cart Declaration <=========== */
	function rb_ajax_add_to_cart(){
		jQuery('.single_add_to_cart_button').off();
		jQuery('.single_add_to_cart_button').on('click', function(e){
			e.preventDefault();

			var button = jQuery(this);
			var form = button.closest('form.cart');
			var product_id = form.find('input[name=add-to-cart]').val() || button.val() || form.find('.variation_id').val();

			if( !product_id ) 
				return;
			if( button.is('.disabled') ) 
				return;

			var data = {
				action: 'rb_ajax_add_to_cart',
				'add-to-cart': product_id,
			};

			form.serializeArray().forEach(function(element){
				data[element.name] = element.value;
			});

			jQuery(document.body).trigger('adding_to_cart', [button, data]);

			jQuery.ajax({
				type: 'POST',
				'url': wc_add_to_cart_params.ajax_url,
				data: data,
				beforeSend: function( response ){
					button.removeClass('added').addClass('loading');
				},
				complete: function( response ){
					button.addClass('added').removeClass('loading');
				},
				success: function( response ){
					if( response.error & response.product_url ){
						window.location = response.product_url;
						return;
					} else {
						jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, button]);
					}
				}
			});

			return false;
		});
	}
	function rb_tablet_hover(){
		if( not_desktop() ){
			jQuery('.woocommerce-loop-product__link').on('click', function(e){

				if( !jQuery(this).hasClass('hovered') ){
					e.preventDefault();

					jQuery(this).addClass('hovered');
					jQuery('.woocommerce-loop-product__link').not(jQuery(this)).removeClass('hovered');
				}

			});
		}
	}

	/* ===========> Ajax Pagination <=========== */
	function rb_ajax_reinit_scripts(){
		setTimeout(function() {
			rb_ajax_add_to_cart();
		}, 200);
	}
	function rb_ajax_loop_pagination(){
		var button = jQuery('.woocommerce-pagination .rb_load_more');
		var can_be_loaded = true;

		if( button.data('pagination') == 'click' ){

			button.on('click', function(e){
				e.preventDefault();

				jQuery.ajax({
					url: rb_ajaxurl,
					type: 'POST',
					data: {
						action: 'rb_woo_load_more',
						query: woo_script_load_more_params.posts,
						page: woo_script_load_more_params.current_page
					},
					beforeSend: function( xhr ){
						button.addClass('active');
					},
					success: function( data ){
						if( data ){
							button.removeClass('active');
							jQuery('ul.products').append(data);

							woo_script_load_more_params.current_page++;

							rb_ajax_reinit_scripts();

							if( woo_script_load_more_params.current_page == woo_script_load_more_params.max_page ){
								button.remove();
							} else {
								button.html('More Products');
							}
						} else {
							button.remove();
						}
					}
				});
			});

		} else if( button.data('pagination') == 'scroll' ){

			jQuery(window).scroll(function(){
				var window_end = jQuery(this).scrollTop() + jQuery(window).height();
				var products_end = jQuery('ul.products').offset().top + jQuery('ul.products').height();

				if( window_end >= products_end && can_be_loaded ){

					jQuery.ajax({
						url: rb_ajaxurl,
						type: 'POST',
						data: {
							action: 'rb_woo_load_more',
							query: woo_script_load_more_params.posts,
							page: woo_script_load_more_params.current_page
						},
						beforeSend: function( xhr ){
							can_be_loaded = false;
							button.addClass('active');
						},
						success: function( data ){
							if( data ){
								jQuery('ul.products').append(data);

								woo_script_load_more_params.current_page++;

								can_be_loaded = true;

								rb_ajax_reinit_scripts();

								if( woo_script_load_more_params.current_page == woo_script_load_more_params.max_page ){
									button.remove();
								}
							} else {
								button.remove();
							}
						}
					});

				}
			});
		}
	}

} ).call( this, jQuery )