jQuery(document).ready(function ($) {
    "use strict";

    /* -----------> Media upload field <------------ */
    function media_upload() {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;
        jQuery('body').on('click', '.js_custom_upload_media', function () {
            var button_id = jQuery(this).attr('id');
            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                    jQuery('.' + button_id + '_img').attr('src', attachment.url);
                    jQuery('.' + button_id + '_url').val(attachment.url).change();
                } else {
                    return _orig_send_attachment.apply(jQuery('#' + button_id), [props, attachment]);
                }
            }

            wp.media.editor.open(jQuery('#' + button_id));

            jQuery(this).removeClass('empty');
            jQuery(this).closest('.widget-row').find('.js_custom_remove_media').removeClass('hidden');

            return false;
        });
    }
    media_upload();

    function media_remove() {
        jQuery('body').on('click', '.js_custom_remove_media', function() {
            jQuery(this).closest('.widget-row').find('input.widefat').val('').change();
            jQuery(this).closest('.widget-row').find('img').attr('src', '');
            jQuery(this).closest('.widget-row').find('.js_custom_upload_media').addClass('empty');
            jQuery(this).addClass('hidden');
        });
    }
    media_remove();


    /* -----------> Textarea Field <------------ */
    function widget_textarea(){
         jQuery('body').on('input', 'textarea.widget_textarea_control', function() {
            var val = jQuery(this).val();
            jQuery(this).closest('.widget-row').find('input.widefat').val(val);
        });
    }
    widget_textarea();
});