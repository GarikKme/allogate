'use strict';

function startImport(max_id) {
	var step = parseInt(max_id) > 1 ? parseFloat(100/(max_id-1)) : 100;
	sendRequest(0, max_id, step);
}

function sendRequest(id, max_id, step) {
		jQuery.ajax({
			type: 'post',
			async: true,
			dataType: 'text',
			url: ajaxurl,
			data: {
				action: 'rb_imp_run',
				nonce: window.rb_imp_ajax,
				options: window.rb_imp,
				id: id,
			},
			error: function(resp) {
				jQuery('div#rb_imp_err').show(200);
			},
			success: function(resp) {
				console.log(resp);
				var progress = jQuery('progress#rb_imp');
				var p_perc = jQuery('#rb_imp_percent');
				if (resp.length) {
					var o_resp = JSON.parse(resp);
					var id = parseInt(o_resp.id);
					if (undefined !== id) {
						var pvalue = id * step;
						if (pvalue > 100) {
							pvalue = 100;
						}
						progress.val(pvalue);
						p_perc[0].dataset['value'] = pvalue.toFixed(2);
						p_perc.css({width : pvalue + '%'});
						//p_perc.text(id * step + '%');
						id++;
						sendRequest(id, max_id, step);
					}
					var messages = o_resp.messages || '';
					if (messages.length) {
						var error_log = jQuery('#rb_error_log');
						error_log.val(error_log.val() + "\n" + messages);
					}
				} else {
					progress.val(100);
					p_perc[0].dataset['value'] = 100;
					p_perc.css({width : '100%'});
					//p_perc.text('100%');
					jQuery('div#rb_imp_done').show(200);
				}
			}
		});
}
