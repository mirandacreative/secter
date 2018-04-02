jQuery(window).load(function () {
    jQuery(document).on('change', 'input.file_upload', function () {
        var block = jQuery(this).closest('.block-uploader');
        if (this.files[0]['size'] != 0) {
            var data = new FormData();
            jQuery(this).hide();
            jQuery('#publish').attr('disabled', 'disabled');
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
                    console.log(response);
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
});