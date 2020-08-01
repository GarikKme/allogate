( function( api ) {
    'use strict';

    api.bind( 'ready', function() {

        /* -----------> Custom text <------------ */
        jQuery('.customize-control-custom-text').each(function(i, el) {

            /* -----------> Google Fonts Upload Field <------------ */
            if( jQuery(el).find('input').data('customize-setting-link') == 'g_fonts_api' ){

                var success_msg = jQuery(el).find('input').attr('success');
                var error_msg = jQuery(el).find('input').attr('error');

                jQuery(el).find('input').keydown(function(e){
                    if( e.keyCode == 13 ){
                        var new_key = jQuery(el).find('input').val();

                        jQuery.ajax({
                            url: ajax_object.ajaxurl,
                            type: 'POST',
                            data:{
                                action: 'load_g_fonts',
                                new_key: new_key,
                            },
                            success: function( data ){
                                if( data == 'success' ){
                                    jQuery(el).find('.error').hide();
                                    jQuery(el).find('.success').text(success_msg);
                                    jQuery(el).find('.success').show();
                                } else {
                                    jQuery(el).find('.success').hide();
                                    jQuery(el).find('.error').text(error_msg);
                                    jQuery(el).find('.error').show();
                                }
                            },
                            error: function( error ){
                                alert( 'Something goes wrong' );
                            }
                        });
                    }
                });
            }

        });


        /* -----------> Rewrite Permalinks <------------ */
        jQuery('#_customize-input-rb_portfolio_slug, #_customize-input-rb_staff_slug, #_customize-input-rb_case_study_slug').on('keydown', function(){
            jQuery('#_customize-input-rb_reset_permalinks').val('true').change();
        });


        /* -----------> Typography refresh weight <------------ */
        jQuery('li[id*="font_family"]').each(function(i, el) {

            jQuery(el).find('select').on('change', function() {
                jQuery(el).next().find('select').empty();

                var new_weights = jQuery(el).find('select').val();

                jQuery.ajax({
                    url: ajax_object.ajaxurl,
                    type: 'POST',
                    data:{
                        action: 'dynamic_font_weights',
                        weights: new_weights,
                    },
                    success: function( data ){
                        new_weights = JSON.parse(data);

                        jQuery.each(new_weights, function( key, value ){
                            key = key.split('-')[1];
                            jQuery(el).next().find('select').append(jQuery("<option></option>").attr("value",key).text(value));
                        });

                        jQuery(el).next().find('select').val('regular');
                        jQuery(el).next().find('select').trigger('change');                        
                    },
                    error: function( error ){
                        alert( 'Something goes wrong' );
                    }
                });
            });

        });


        /* -----------> Typography refresh subsets <------------ */
        jQuery('li[id*="font_family"]').each(function(i, el) {

            jQuery(el).find('select').on('change', function() {
                jQuery(el).next().next().find('select').empty();

                var new_subsets = jQuery(el).find('select').val().split(',')[0];

                jQuery.ajax({
                    url: ajax_object.ajaxurl,
                    type: 'POST',
                    data:{
                        action: 'dynamic_font_subsets',
                        subsets: new_subsets,
                    },
                    success: function( data ){
                        new_subsets = JSON.parse(data);

                        jQuery(new_subsets).each(function(key, value){
                            jQuery(el).next().next().find('select').append(jQuery("<option></option>").attr("value", value).text(value));
                        });

                        jQuery(el).next().next().find('select').trigger('change');
                    },
                    error: function( error ){
                        alert( 'Something goes wrong' );
                    }
                });
            });

        });


    	/* -----------> Multiple input <------------ */
    	jQuery('.customize-control-multiple_input').each(function(i, el) {

    		//Get main control input
    		var default_input = {};
    		var main_input = jQuery(el).find('input').not('input[name^="multiple_"]').data('customize-setting-link');

    		var saved = wp.customize.control(main_input).setting.get();

    		jQuery(el).find('input[name^="multiple_"]').each(function(i, el) {
    			//Get input name
    			var key = jQuery(el).data('name');

    			//Fill defaults
    			if( jQuery(el).val() != '' ){
    				default_input[key] = jQuery(el).val();
    			}

    			//Set default value
    			wp.customize.control(main_input).setting.set(default_input);

    			//Main save control script
    			jQuery(el).on('input', function() {
    				//Clear before new value
    				wp.customize.control(main_input).setting.set('');

    				//Apply saved value
    				if( typeof saved != 'object' ){
    					var multiple_input = {};
    				} else {
    					var multiple_input = saved;
    				}

    				//Fill object
    				var value = jQuery(this).val();
    				multiple_input[key] = value;
    				
    				//Set new value
    				wp.customize.control(main_input).setting.set(multiple_input);
    			});
    		});

    	});


        /* -----------> Repeater input <------------ */
        jQuery('.customize-control-repeater').each(function(i, el) {
            
            //Get main control input
            var main_input = jQuery(el).find('input').not('input[name^="repeater_"]').data('customize-setting-link');

            //Add new input
            jQuery(el).find('button.add').on('click', function() {
                var randomName = 'repeater_' + Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000;
                jQuery(this).prev().append('<div class="repeater-item"><input type="text" class="new" placeholder="New Sidebar" name="'+randomName+'"/><i class="remove"></i></div>');

                remove_input(main_input);
            });

            //Remove input
            remove_input(main_input);

            //Save fields
            jQuery(el).find('button.save').on('click', function() {
                var repeater_input = {};

                jQuery(el).find('input[name^="repeater_"]').each(function(i, el) {
                    //Get input name
                    var key = jQuery(el).data('name');

                    //Clear before new value
                    wp.customize.control(main_input).setting.set('');

                    //Fill object
                    var value = jQuery(this).val();
                    if( jQuery(el).hasClass('new') ){
                        var data_name = value;
                        data_name = data_name.replace(/ /g, "_");
                        data_name = data_name.toLowerCase();

                        repeater_input[data_name] = value;
                    } else {
                        repeater_input[key] = value;
                    }
                });

                //Set new value
                wp.customize.control(main_input).setting.set(repeater_input);
            });

        });

        function remove_input(main_input){
            jQuery('.remove').off();
            jQuery('.remove').on('click', function() {

                var main_value = wp.customize.control(main_input).setting.get();
                var removed_value = jQuery(this).prev().data('name');

                delete main_value[removed_value];

                wp.customize.control(main_input).setting.set(main_value);

                jQuery(this).parent().remove();
            });
        }


        /* -----------> Dependencies <------------ */
        jQuery('.control-wrapper').each(function(i, el) {

            if( typeof jQuery(el).data('depend-by') !== "undefined" ){
                var depend_by = jQuery(el).data('depend-by');
                var depend_operator = jQuery(el).data('depend-operator');
                var depend_value = jQuery(el).data('depend-value');
                var depend_default = jQuery(el).data('depend-default');
                var observable_control = jQuery(el).closest('#customize-theme-controls').find('[data-customize-setting-link="'+depend_by+'"]');

                if( 
                    observable_control.is('textarea') || 
                    observable_control.is('[type="custom-text"]') ||
                    observable_control.is('[type="text"]') ||
                    observable_control.is('[type="email"]') ||
                    observable_control.is('[type="url"]') ||
                    observable_control.is('[type="number"]') ||
                    observable_control.is('[type="date"]')
                ){
                    observable_control.on('input', function(){
                        setech_reactive_dependency( jQuery(this), depend_operator, depend_value, jQuery(el), depend_default );
                    });
                } else {
                    observable_control.on('change', function(){
                        setech_reactive_dependency( jQuery(this), depend_operator, depend_value, jQuery(el), depend_default );
                    });
                }

            }

        });

        function dep_done(changeable){
            changeable.removeClass('hidden');
        }

        function dep_fail(changeable, depend_default){
            changeable.addClass('hidden');

            var main_input = changeable.find('[data-customize-setting-link]').data('customize-setting-link');
            wp.customize.control(main_input).setting.set(depend_default);
        }

        function setech_reactive_dependency( observable, depend_operator, depend_value, changeable, depend_default ){

            if( observable.attr('type') == 'checkbox' ){
                switch (depend_operator){
                    case '==':
                    case '===':
                        if( 
                            (( depend_value == 'true' || depend_value == '1' ) && observable.prop('checked')) ||
                            ( depend_value == false && !observable.prop('checked') )
                        ){
                            dep_done(changeable);
                        }
                        else if( 
                            (( depend_value == 'true' || depend_value == '1') && !observable.prop('checked') ) ||
                            ( depend_value == false && observable.prop('checked') )
                        ){
                            dep_fail(changeable, depend_default);
                        }
                        break;
                    case '!=':
                    case '!==':
                        if(
                            (( depend_value == 'true' || depend_value == '1' ) && observable.prop('checked')) ||
                            ( depend_value == false && !observable.prop('checked') )
                        ){
                            dep_fail(changeable, depend_default);
                        } else if(
                            (( depend_value == 'true' || depend_value == '1') && !observable.prop('checked') ) ||
                            ( depend_value == false && observable.prop('checked') )
                        ){
                            dep_done(changeable);
                        }
                        break;
                }
            } else {
                switch (depend_operator){
                    case '==':
                        if( depend_value != 'empty' && depend_value != '!empty' ){
                            if( jQuery.isArray(observable.val()) ){
                                ( jQuery.inArray(depend_value, observable.val()) !== -1 ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                            } else {
                                ( depend_value == observable.val() ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                            }
                        } else if( depend_value == 'empty' ){
                            ( observable.val() == '' ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        } else if( depend_value == '!empty' ){
                            ( observable.val() != '' ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        }
                        break;
                    case '!=':
                        if( depend_value != 'empty' && depend_value != '!empty' ){
                            if( jQuery.isArray(observable.val()) ){
                                ( jQuery.inArray(depend_value, observable.val()) === -1 ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                            } else {
                                ( depend_value != observable.val() ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                            }
                        } else if( depend_value == 'empty' ){
                            ( observable.val() != '' ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        } else if( depend_value == '!empty' ){
                            ( observable.val() == '' ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        }
                        break;
                    case '===':
                        ( depend_value === observable.val() ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        break;
                    case '!==':
                        ( depend_value !== observable.val() ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        break;
                    case '>':
                        ( parseInt(observable.val()) > parseInt(depend_value) ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        break;
                    case '>=':
                        ( parseInt(observable.val()) >= parseInt(depend_value) ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        break;
                    case '<':
                        ( parseInt(observable.val()) < parseInt(depend_value) ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        break;
                    case '<=':
                        ( parseInt(observable.val()) <= parseInt(depend_value) ) ? dep_done(changeable) : dep_fail(changeable, depend_default);
                        break;
                }
            }
        }

        /* -----------> Sneaky Select <------------ */
        jQuery('li[id*="customize-control-widget_rb_icon_list"]').on('click', function(){
            jQuery('.sneaky-select').each(function(i, el){
                var start_value = jQuery(el).prev().val();

                if( start_value != '' ){
                    var current_value = jQuery(el).find('.sneaky-item[data-value="'+start_value+'"]').html();
                    jQuery(el).find('.sneaky-selected').html(current_value);
                }
            });

            jQuery('.sneaky-selected').on('click', function(){
                jQuery(this).next().toggle();
            });

            jQuery('.sneaky-item').on('click', function(){
                var value = jQuery(this).data('value');
                var html = jQuery(this).html();
                jQuery(this).closest('.widget-inner-content').find('.widefat').val(value);
                jQuery(this).closest('.widget-inner-content').find('.widefat').change();
                jQuery(this).closest('.sneaky-select').find('.sneaky-selected').html(html);

                jQuery(this).parent().hide();
            });
        });
    });

}( wp.customize ) );