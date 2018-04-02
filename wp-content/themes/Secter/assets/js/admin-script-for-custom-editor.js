jQuery(window).load(function () {

    var style_editor = jQuery('#editor-buttons-css');
    style_editor.appendTo(jQuery('#post-body-content'));

    jQuery('.sorted-item').each(function (index) {
        jQuery(this).attr('id', 'sortable-' + (index + 1));
        jQuery('#sortable-' + (index + 1)).sortable({
            start: function (event, ui) {
                var textareaID = ui.item.find('textarea').attr('id');
                tinyMCE.execCommand('mceRemoveEditor', false, textareaID);
            },
            stop: function (event, ui) {
                var textareaID = ui.item.find('textarea').attr('id');
                console.log(tinyMCE.execCommand('mceAddEditor', false, textareaID));
            }
        });
    });

    var uniq = 'uniq-id-', counter = 0;

    jQuery('.add-admin-editor').click(function () {
        counter++;
        var item = jQuery(this);
        var id = uniq + counter;
        var sorted = jQuery(this).data('sorted');
        var item_target = jQuery(this).data('target');
        jQuery.ajax({
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'add_new_editor',
                id: id,
                selector: item_target
            },
            success: function (resp) {
                if (sorted == 'sorted') {
                    var id_item = item.closest('.custom-content').find('.sorted-item').attr('id');
                    console.log(id_item);
                    jQuery('#' + id_item).append(resp).sortable({
                        start: function (event, ui) {
                            var textareaID = ui.item.find('textarea').attr('id');
                            tinyMCE.execCommand('mceRemoveEditor', false, textareaID);
                        },
                        stop: function (event, ui) {
                            var textareaID = ui.item.find('textarea').attr('id');
                            tinyMCE.execCommand('mceAddEditor', false, textareaID);
                        }
                    });
                }
                else {
                    item.parent('.add-item-button').before(resp);
                }
                console.log(tinyMCE.execCommand('mceAddEditor', false, id));
            }
        });
    });

    jQuery(document).on('click', '.delete-item', function () {
        jQuery(this).closest('.item').remove();
    });

    jQuery(document).on('change', 'input.file_upload', function () {
        var block = jQuery(this).closest('.block-uploader');
        if (this.files[0]['size'] != 0) {
            jQuery('#publish').attr('disabled', 'disabled');
            var data = new FormData();
            jQuery(this).hide();
            block.find('.progress_file_upload').show();
            data.append('action', 'file_upload');
            data.append('file_upload', this.files[0]);
            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            block.find('progress').attr({'value': evt.loaded, 'max': evt.total})
                        }
                    }, false);
                    return xhr;
                },
                success: function (response) {
                    if (response.response != false) {
                        block.find('.link-image').val(response.response);
                        block.find('.image-uploader').attr('src', response.response);
                    }
                    else
                        alert('Что-то пошло не так! Пожалуйста, попробуйте позже');
                    jQuery('#publish').removeAttr('disabled');
                    block.find('.file_upload').show();
                    block.find('.progress_file_upload').hide();
                    block.find('.file_upload').val('');
                }
            });
        }
        else {
            block.find('.file_upload').val('');
            alert('Размер файла должен быть больше 0 байт');
        }
    });

    jQuery(document).on('change', '.link-image', function () {
        var block = jQuery(this).closest('.block-uploader');
        block.find('.image-uploader').attr('src', jQuery(this).val());
    });

    jQuery(document).on('change', '.nofollow-newsletter', function () {
        var block = jQuery(this).closest('.checkbox-block-editor-secter').find('input[type="hidden"]');
        if (block.val() == 1)
            block.val(0);
        else
            block.val(1)
    })
});