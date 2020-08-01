'use strict';

var svg_header = '<svg width="24" height="24" viewBox="-6 -6 60 60" xmlns="http://www.w3.org/2000/svg"';
var svg_end = '</svg>';

var cssAnimation = null;
var idTimeout = null;

function stopAnimation() {
	if (idTimeout) {
		clearTimeout(idTimeout);
	}
	if (cssAnimation) {
		cssAnimation.remove();
	}
	jQuery('ul.rbsvgi_icons li.ui-selected svg *').removeClass('animate');
}

function processForm2Param(_data) {
	var rObj = {};
	for (var k = 0; k < _data.length; k++) {
		var value = '';
		switch (_data[k].type) {
			case 'text':
			case 'number':
			case 'hidden':
			case 'textarea':
			case 'select-one':
				value = _data[k].value;
				break;
			case 'radio':
				value = _data[k].checked ? _data[k].value : null;
				break;
			case 'checkbox':
				value = _data[k].checked ? '1' : '0';
				break;
			case 'select-multiple':
				// need to check this
				var y = 0;
				for (var i = 0; i < _data[k].options.length; i++) {
					if (_data[k].options[i].selected == true) {
						value += y > 0 ? ',' : '';
						value += _data[k].options[i].value;
						y++;
					}
				}
				break;
		}
		if (value && value.length > 0) {
			rObj[_data[k].name] = value;
		}
	}
	return rObj;
}

(function($) {
	'use strict';

	$(document).ready(function(e) {
		$('#rbfi-import').on('click', function(e) {
			e.preventDefault;
			e.stopPropagation;
			$('#rbfi-import-form').show();
			$('#rbfi-upload-form').hide();
			$('.rbsvgi_container').hide();
			return false;
		});

		$('#rbfi-import-cancel').on('click', function(e) {
			e.preventDefault;
			e.stopPropagation;
			$('#rbfi-import-form').hide();
			$('#rbfi-upload-form').show();
			$('.rbsvgi_container').show();
			return false;
		});

		$('.rbsvgi_container #rbsvgi_names').on('change', function(e) {
			var name = $(e.target).val();
			if (0 === name.indexOf('(css_preset)')) {
				// hide all not neccessary options in this case
				$('.rbsvgi_container .controls .row.variable').addClass('disable'); // potentially dangerous as we may need element to be hidden
				jQuery.ajax({
					type: 'post',
					async: true,
					dataType: 'text',
					url: ajaxurl,
					data: {
						action: 'rbsvgi_ajax_get_css_presets_css',
						nonce: window.rbsvgi_nonce,
						name: name.substr(12),
					},
					error: function(resp) {},
					success: function(resp) {
						if (resp.length) {
							window.rbsvgi_last_preset_css = resp;
						}
					}
				});
			} else {
				$('.rbsvgi_container .controls .row.variable').removeClass('disable');
				jQuery.ajax({
					type: 'post',
					async: true,
					dataType: 'text',
					url: ajaxurl,
					data: {
						action: 'rbsvgi_ajax_get_svg_atts',
						nonce: window.rbsvgi_nonce,
						name: name,
					},
					error: function(resp) {},
					success: function(resp) {
						if (resp.length > 0) {
							var is_preset = name.indexOf('(preset)') === 0
							var atts = JSON.parse(resp);
							var time_out = 0;
							if (!is_preset) {
								var coll_name = atts['svg'].split('/');
								var curr_collection = jQuery('.rbsvgi_container #rbsvgi_collections').val();
								if (coll_name[0] !== curr_collection) {
									jQuery('.rbsvgi_container #rbsvgi_collections').val(coll_name[0]).trigger('change');
									time_out = 600;
								}
							}
							updateCollection(time_out, atts, is_preset);
						}
					}
				});
			}
		});

		function updateCollection(time_out, atts, is_preset) {
			setTimeout(function() {
				if (!is_preset) {
					var coll_name = atts['svg'].split('/');
					var svg = jQuery('.rbsvgi_container li>i>svg[class="' + coll_name[1] + '"]');
					if (svg.length === 1) {
						selectOne(svg.closest('li'));
					}
				}
				if (atts) {
					assignParams(jQuery('.rbsvgi_container .controls').find('.row_options input,.row_options select, .row_options textarea'), atts);
				}
				// now we need to restore selected primitive checkboxes
				var layers_inner = jQuery('.rbsvgi_container .layers_inner');
				if (!is_preset) {
					jQuery('.rbsvgi_container #layers_all').prop('checked', false);

					var nids = atts['nids'].split(',');
					for (var i = 0; i < nids.length; i++) {
						layers_inner.find('input[data-nid="rbsvgi_' + nids[i] + '"]').prop('checked', true);
					}
				} else {
					jQuery('.rbsvgi_container #layers_all').prop('checked', true);
					layers_inner.find('input[data-nid^="rbsvgi_"]').prop('checked', true);
				}
			}, time_out);
		}

		$('.rbsvgi_container #rbsvgi_collections').on('change', function(e) {
			var collection = $(e.target).val();
			var ul_icons = $(e.target).parent().find('ul.rbsvgi_icons');
			jQuery.ajax({
				type: 'post',
				async: true,
				dataType: 'text',
				url: ajaxurl,
				data: {
					action: 'rbsvgi_ajax_get_collection',
					nonce: window.rbsvgi_nonce,
					collection: collection,
				},
				error: function(resp) {},
				success: function(resp) {
					ul_icons.find('li').remove();
					ul_icons.append(resp);
					initIcons();
				}
			});
		});

		$('.rbsvgi_container #rbfi-delete-collection').on('click', function(e) {
			var name = $('.rbsvgi_container #rbsvgi_collections').val();
			if (name.length > 0 && window.confirm('Are you sure you want to delete "' + name + '" collection?\nNote that all svg files will be deleted too.')) {
				jQuery.ajax({
					type: 'post',
					async: true,
					dataType: 'text',
					url: ajaxurl,
					data: {
						action: 'rbsvgi_ajax_del_col',
						nonce: window.rbsvgi_nonce,
						collection: name,
					},
					error: function(resp) {},
					success: function(resp) {
						$('.rbsvgi_container #rbsvgi_collections option[value="' + name + '"]').remove();
						delete window.rbsvgi.collections[name];
						jQuery('.rbsvgi_container #rbsvgi_collections').trigger('change');
						updateCollection(600, null, true);
					}
				});
			}
		});

		$('#rbfi-upload-form #rbfi-upload').on('click', function(e) {
			var collection = $('#rbfi-upload-form input[name="collection"]').val();
			if (-1 !== Object.keys(window.rbsvgi.collections).indexOf(collection)) {
				$('#rbfi-upload-form span.error.collection').show();
				setTimeout(function(){
					$('#rbfi-upload-form span.error.collection').hide();
				}, 4000);
				e.preventDefault;
				e.stopPropagation;
				return false;
			}
		});

		$('.rbsvgi_container #rbsvgi_manage_css').on('click', function(e) {
			var dlg = $('#manage_css_dlg');
			dlg.dialog({
				modal: true,
				autoOpen: false,
				height: 'auto',
				minWidth: document.body.clientWidth/3,
				title: dlg.data('title'),
				show: { effect: 'slideDown', duration: 300 },
				buttons: {
					'Save': function(ui) {
						var that = this;
						var css = $(this).find('textarea[name="css"]').val().trim();
						var name = $(this).find('input[name="names"]').val();
						var keyframes = getKeyframesNum(css);
						var res = null;
						if (keyframes > 1) {
							res = parseCssKeyframes(css);
						} else if (keyframes == 1) {
							res = css;
						} else if (css.length === 0) {
							res = '';
						}
						if (null !== res) {
							jQuery.ajax({
								type: 'post',
								async: true,
								context: that,
								dataType: 'text',
								url: ajaxurl,
								data: {
									action: 'rbsvgi_ajax_save_css_presets',
									nonce: window.rbsvgi_nonce,
									css: res,
									name: name,
								},
								error: function(resp) {},
								success: function(resp) {
									if (resp.length) {
										var jresp = JSON.parse(resp);
										Object.keys(jresp).reduce(function(prev, k, a){
											switch (jresp[k]) {
												case 'add':
													if (0 === $(that).find('.row.names select option[value="' + k + '"]').length ) {
														$('.rbsvgi_container #rbsvgi_names optgroup.css_presets').append($('<option>', { value: '(css_preset)'+k }).text(k));
														$(that).find('.row.names select').append($('<option>', { value: k }).text(k));
													}
													break;
												case 'del':
													$('.rbsvgi_container #rbsvgi_names option[value="(css_preset)' + k + '"]').remove();
													$(that).find('.row.names select option[value="' + k + '"]').remove();
													$(that).find('.row.names input').val('');
													break;
											}
											return prev;
										}, jresp[0]);
										alert('Saved successfully.');
									}
								}
							});
						}
					},
					Cancel: function() {
						dlg.dialog('close');
					}
				},
				open: function(ui) {
					var that = this;
					var textarea = $(this).find('.row.css textarea');
					var sel_name = $(this).find('.row.names select');
					var sel_input = $(this).find('.row.names input');
					textarea.val('');
					sel_name.val('');
					sel_input.val('');
					var textarea_ev = $._data(textarea[0], 'events');
					if (undefined === textarea_ev) {
						// first run, let's set up some events
						textarea.on('paste', null, function(e){
							var t = $(this);
							var sel_input = t.closest('.ui-dialog-content').find('.row.names input');
							if (sel_input.val().length === 0) {
								// should we verify it somehow?
								setTimeout(function() {
									var text = t.val();
									var keyframes = getKeyframesNum(text);
									if (keyframes) {
										if (1 === keyframes.length) {
											var keyframe_name = text.match(/@keyframes\s+(\w+)(?:\s+)/);
											sel_input.val(keyframe_name[1]);
											t.closest('.ui-dialog-content').find('.row.note').addClass('disable');
										} else {
											// hide select and re-label to Prefix
											// when saved treat it like prefix
											var sel = t.closest('.ui-dialog-content').find('.row.names select');
											t.closest('.ui-dialog-content').find('.row.note').removeClass('disable');
											//sel.hide();
										}
									}
								}, 200);
							}
						});

						textarea.on('change', null, function(e){
							var t = $(this);
							var sel = t.closest('.ui-dialog-content').find('.row.names select');
							var keyframes = getKeyframesNum(e.target.value);
							if (keyframes <= 1) {
								//sel.show();
								t.closest('.ui-dialog-content').find('.row.note').addClass('disable');
							} else {
								//sel.hide();
								t.closest('.ui-dialog-content').find('.row.note').removeClass('disable');
							}
						});

						$(this).find('.row.names select').on('change', function(e){
							onChangeCssPresetName(e);
						});
					}

					jQuery.ajax({
						type: 'post',
						async: true,
						context: that,
						dataType: 'text',
						url: ajaxurl,
						data: {
							action: 'rbsvgi_ajax_get_css_presets_names',
							nonce: window.rbsvgi_nonce,
						},
						error: function(resp) {},
						success: function(resp) {
							var sel = $(this).find('.row.names select');
							if (sel[0].options.length === 1) {
								sel.append(resp);
							}
						}
					});
				},
			});
			dlg.dialog('open');
		});

		function getKeyframesNum(text) {
			var match = text.match(/@keyframes\s+/g);
			return match ? match.length : match;
		}

		function parseCssKeyframes(text) {
			var ret = {};
			var items = text.match(/(@keyframes\s+\w+(?:|\s+)\{(?:[^}{]+|\{(?:[^}{]+|\{[^}{]*\})*\})*\})/g);
			for(var i=0;i<items.length;i++) {
				var item_name = items[i].match(/@keyframes\s+(\w+)(?:[\s{])/)[1];
				ret[item_name] = items[i];
			}
			return ret;
		}

		function onChangeCssPresetName(ev) {
			// need to ask the database for content and insert it in the respective field
			var name = ev.target.value;
			var that = $(ev.target).closest('.ui-dialog-content');
			if (name.length) {
				jQuery.ajax({
					type: 'post',
					async: true,
					context: that,
					dataType: 'text',
					url: ajaxurl,
					data: {
						action: 'rbsvgi_ajax_get_css_presets_css',
						nonce: window.rbsvgi_nonce,
						name: name,
					},
					error: function(resp) {},
					success: function(resp) {
						if (resp.length) {
							var textarea = that.find('.row.css textarea');
							window.rbsvgi_last_preset_css = resp;
							textarea.val(resp);
						}
					}
				});
			}
		}

		/* --- end of manage css dialog functions --- */

		$('.rbsvgi_container #rbsvgi_del_names').on('click', function(e) {
			var name = $('.rbsvgi_container #rbsvgi_names').val();
			if (name.length > 0 && window.confirm('Are you sure you want to delete ' + name + '?')) {
				jQuery.ajax({
					type: 'post',
					async: true,
					dataType: 'text',
					url: ajaxurl,
					data: {
						action: 'rbsvgi_ajax_del_name',
						nonce: window.rbsvgi_nonce,
						name: name,
					},
					error: function(resp) {},
					success: function(resp) {
						$('.rbsvgi_container #rbsvgi_names option[value="' + name + '"]').remove();
					}
				});
			}
		});

		$('.rbsvgi_container .layers #layers_all').on('click', function(e) {
			var is_sel = e.target.checked;
			var parent = $(e.target).closest('.layers').find('.layers_inner input').prop('checked', is_sel);
		});

		$('.rbsvgi_container .rbsvgi_icons').selectable({
			filter: 'li',
			stop: function(ev, ui) {
				var layers = $('.rbsvgi_container .layers .layers_inner');
				layers.children().remove();

				var selectedItems = $('li.ui-selected', this);
				if (1 === selectedItems.length) {
					selectOne(selectedItems);
				} else {
					// multiple selection
					$('.controls .row.title input').val(''); // empty title, it will serve as prefix when saved
				}
			}
		});

		initIcons();
	});

	function selectOne(li) {
		var layers = $('.rbsvgi_container .layers .layers_inner');
		var svg_root = li.find('svg');
		$('.controls .row.title input').val(svg_root[0].id.slice(0, -4));
		var layers_html = '';
		svg_root.find('[class^="rbsvgi"]').each(function() {
			var svg_style = ' style="' + $(this).attr('style') + '">';
			var tag = this.tagName;
			layers_html += '<label><input type="checkbox" data-nid="' + this.className.baseVal + '"/><span class="type ' + tag + '">' + svg_header + svg_style + '<use xlink:href="#' + tag + '"/>' + svg_end + '</span>' + tag + '</label>';
		});
		$('.rbsvgi_container #layers_all').prop('checked', true);
		layers.append(layers_html);
		$('.rbsvgi_container .layers_inner input').prop('checked', true);
		li.addClass('ui-selected');
	}

	function initIcons() {}

	$('.buttons #buttons-save').on('click', function(e) {
		var our_svg = $('li.ui-selected svg');
		var svg_elements = $('.rbsvgi_container .layers .layers_inner input:checked');

		//$('.controls .row.shortcode input').val('');
		var title = $('.controls .row.title input').val();
		var is_title_unique = false; //checkAnimTitle(title, 'animations');
		var th = $(e.target).closest('.controls');
		var _data = $(th).find('.row_options:not([class*="disable"]) [name]').filter(function(id, val) {
			return !jQuery(val).closest('.row_options').hasClass('disable');
		});
		var rObj = processForm2Param(_data);
		var preset_name = $('.controls #rbsvgi_names').val();
		if (undefined !== preset_name && 0 === preset_name.indexOf('(css_preset)')) {
			rObj['css_preset'] = preset_name.substr(12);
		}

		if (our_svg.length === 1 && svg_elements.length >= 1 && title.length > 0 && !is_title_unique) {
			var nids = '';
			svg_elements.each(function() {
				//nids += ',' + this.dataset['nid'].substr(8);
				nids += ',' + this.className.substr(8);
			});
			nids = nids.substr(1); // remove the first ','

			if (undefined !== rObj['title'] && rObj['title'].length > 0) {
				var selectedItems = $('li.ui-selected', this);
				rObj['nids'] = nids;
				rObj['svg'] = $('.rbsvgi_container select[name="collections"]').val() + '/' + our_svg[0].id;
				saveTemplate(title, rObj, false);
			}
		} else if (our_svg.length > 1) {
			// multiple selection
			rObj['collection'] = $('.rbsvgi_container select[name="collections"]').val();
			rObj['items'] = Object.keys(our_svg).reduce(function(prev, k, a){
				if (a && undefined !== our_svg[k].id) {
					prev += ',' + our_svg[k].id;
				}
				return prev;
			}, our_svg[0].id);
			saveTemplate(title, rObj, false);
		} else {
			alert("Error: Check the name, it has to be not empty and unique.\nMake sure you select the icon and select one or more elements.");
		}
	});

	$('.buttons #buttons-save_preset').on('click', function(e) {
		var preset_name = $('.controls #rbsvgi_names').val();
		if (undefined !== preset_name && 0 !== preset_name.indexOf('(css_preset)')) {
			//$('.controls .row.shortcode input').val('');
			var title = $('.controls .row.title input').val();
			var is_title_unique = checkAnimTitle(title, 'presets');

			if (title.length > 0 && !is_title_unique) {
				var th = $(e.target).closest('.controls');
				var _data = $(th).find('.row_options:not([class*="disable"]) [name]').filter(function(id, val) {
					return !jQuery(val).closest('.row_options').hasClass('disable');
				});
				var rObj = processForm2Param(_data);
				if (undefined !== rObj['title'] && rObj['title'].length > 0) {
					saveTemplate('(preset)' + title, rObj, true);
				}
			} else {
				alert('Error: Check the name, it has to be not empty and unique.');
			}
		}
	});

	function checkAnimTitle(title, group_class) {
		if ('presets' === group_class) {
			title = '(preset)' + title;
		}
		return $('#rbsvgi_names optgroup.' + group_class + ' option[value="' + title + '"]').length > 0;
	}

	function saveTemplate(title, rObj, is_preset) {
		jQuery.ajax({
			type: 'post',
			async: true,
			dataType: 'text',
			url: ajaxurl,
			data: {
				action: 'rbsvgi_ajax_update_template',
				nonce: window.rbsvgi_nonce,
				name: title,
				atts: rObj,
			},
			error: function(resp) {},
			success: function(resp) {
				if (!resp.length) {
					alert('Updated successfully');
					if (is_preset) {
						$('.rbsvgi_container #rbsvgi_names optgroup.presets').append($('<option>', { value: title }).text(title.substr(8)));
					} else {
						//$('.controls .row.shortcode input').val('[rbsvgi title="' + title + '"/]');
						$('.rbsvgi_container #rbsvgi_names optgroup.animations').append($('<option>', { value: title }).text(title));
					}
				} else {
					//console.log(resp);
				}
			}
		});
	}

	$('.buttons #buttons-preview').on('click', function(e) {
		if (cssAnimation) {
			cssAnimation.remove();
		}
		$('ul.rbsvgi_icons li i *').removeClass('animate');
		var th = $(e.target).closest('.controls');
		var _data = $(th).find('.row_options:not([class*="disable"]) [name]').filter(function(id, val) {
			return !jQuery(val).closest('.row_options').hasClass('disable');
		});
		var rObj = processForm2Param(_data);
		var our_svg = $('li.ui-selected svg');
		var animateCss = ".animate{\n";

		var preset_name = $('.controls #rbsvgi_names').val();
		if (undefined !== preset_name && 0 === preset_name.indexOf('(css_preset)')) {
			animateCss += "animation-name: "+ preset_name.substr(12) +";\n";
			animateCss += "animation-duration: " + rObj['duration'] + "s;\n";
			animateCss += "animation-repeat: " + rObj['repeat'] + ";\n";
			animateCss += "animation-direction: alternate;\n";
			animateCss += "}\n";
			var css = window.rbsvgi_last_preset_css;
			css = css.replace(/(@keyframes\s+)(\w+)(\s+)/, "$1"+preset_name.substr(12)+"$3");
			animateCss += css;
		} else {
			animateCss += "animation: aniFrames " + rObj['timing_func'] + " " + rObj['duration'] + "s " + rObj['repeat'] + " alternate;\n";
			var origin = rObj['transform-origin'].split(',');
			//animateCss += "transform-origin: "+ rObj['transform-origin'] +";\n";
			animateCss += "transform-origin: " + parseInt(origin[0]) * our_svg[0].viewBox.baseVal.width / 100 + "px " + parseInt(origin[1]) * our_svg[0].viewBox.baseVal.height / 100 + "px;\n";
			animateCss += "}\n";
			animateCss += "@keyframes aniFrames{\n";
			var transform = '';
			var opacity = '';

			transform += ' rotate(' + (rObj['rotate-0'] | 0) + 'deg)';
			transform += ' scale(' + parseInt(rObj['scale-0']) / 100 + ')';

			var t_left = null;
			if (rObj['translate-left0'] !== undefined) { t_left = rObj['translate-left0'] + 'px'; }
			var t_top = null;
			if (rObj['translate-top0'] !== undefined) { t_top = rObj['translate-top0'] + 'px'; }

			if (t_top || t_left) { transform += ' translate(' + (t_left ? t_left : '0px') + ', ' + (t_top ? t_top : '0px') + ')'; }

			transform = transform.trim();
			opacity = '';
			if (parseInt(rObj['opacity-0']) <= 100) { opacity = " opacity:" + parseInt(rObj['opacity-0']) / 100 + ";\n"; }

			animateCss += "0% { " + opacity + " transform: " + transform + "; }\n";

			transform = ''

			transform += ' rotate(' + (rObj['rotate-1'] | 0) + 'deg)';
			transform += ' scale(' + parseInt(rObj['scale-1']) / 100 + ')';

			var t_left = null;
			if (rObj['translate-left1'] !== undefined) { t_left = rObj['translate-left1'] + 'px'; }
			var t_top = null;
			if (rObj['translate-top1'] !== undefined) { t_top = rObj['translate-top1'] + 'px'; }

			if (t_top || t_left) { transform += ' translate(' + (t_left ? t_left : '0px') + ', ' + (t_top ? t_top : '0px') + ')'; }


			transform = transform.trim();
			opacity = '';
			if (parseInt(rObj['opacity-1']) <= 100) { opacity = " opacity:" + parseInt(rObj['opacity-1']) / 100 + ";\n"; }
			animateCss += "100% { " + opacity + " transform: " + transform + "; }\n";
			animateCss += "}\n";
		}
		console.log(animateCss);
		cssAnimation = $('<style type="text/css">' + animateCss + '</style>').appendTo('head');
		idTimeout = setTimeout('stopAnimation()', rObj['duration'] * rObj['repeat'] * 1000);
		if (undefined !== preset_name && 0 === preset_name.indexOf('(css_preset)')) {
			our_svg.addClass('animate');
		} else {
			if (1 === our_svg.length) {
				$('.rbsvgi_container .layers .layers_inner input:checked').each(function() {
					var nid = this.dataset['nid'];
					our_svg.find('[class^="' + nid + '"]').addClass('animate');
				});
			} else {
				our_svg.find('[class^="rbsvgi_"]').addClass('animate');
			}
		}

		//$('ul.rbsvgi_icons li.selected').addClass('animate');
	});

})(window.jQuery);
