jQuery(document).ready(function () {

    jQuery('.city_editor').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    var menu = '<li class="city_seting">';
    menu += '<span class="delete_item_seting"></span>';
    menu += '<div><span class="title_param">Title:</span><span class="value_param"><input type="text" class="change_value_city" name="title-city[]" value="Enter title"></span></div>';
    menu += '<div><span class="title_param">Link:</span><span class="value_param"><input type="text" class="change_value_city" name="link-city[]" value="#"></span></div>';
    menu += '<input type="hidden" class="change_value_city" value="" name="top_in_proc[]"/>';
    menu += '<input type="hidden" class="change_value_city" value="" name="left_in_proc[]"/>';
    menu += '<input type="hidden" class="change_value_city" value="" name="top[]"/>';
    menu += '<input type="hidden" class="change_value_city" value="" name="left[]"/>';
    menu += '</li>';

    var item_city = '<a href="#" class="item-city">Enter title</a>';

    function draggable_image_large() {
        var container = jQuery('.container_block-1');
        var id = jQuery(container).find('a').index(jQuery(this).width('auto').height('auto'));
        jQuery('.city_seting:eq(' + (id) + ') input.change_value_city[name="top[]"]').val(parseInt(jQuery(this).css('top')));
        jQuery('.city_seting:eq(' + (id) + ') input.change_value_city[name="left[]"]').val(parseInt(jQuery(this).css('left')));
        jQuery('.city_seting:eq(' + (id) + ') input.change_value_city[name="top_in_proc[]"]').val(parseInt(jQuery(this).css('top')) / container.height() * 100);
        jQuery('.city_seting:eq(' + (id) + ') input.change_value_city[name="left_in_proc[]"]').val(parseInt(jQuery(this).css('left')) / container.width() * 100);
    }

    jQuery(".item-city").draggable({
        containment: ".container_block-1",
        scroll: false,
        drag: draggable_image_large
    });

    jQuery(document).on('click', '#add_new_item', function () {
        jQuery(menu).appendTo(jQuery(".list-citys"));
        jQuery(item_city).appendTo(jQuery(".container_block-1")).css({
            'position': 'absolute',
            'width': 'auto',
            'height': 'auto'
        }).draggable({
            containment: ".container_block-1",
            scroll: false,
            drag: draggable_image_large
        });
    });

    jQuery(document).on('click', '.delete_item_seting', function () {
        var id = jQuery(jQuery('.list-citys .city_seting')).index(jQuery(this).closest('.city_seting'));
        jQuery('.list-citys .city_seting:eq(' + id + '), .container_block-1 .item-city:eq(' + id + ')').remove();
    });
    var frame;
    jQuery(document).on('click', '#insert-my-media', function (event) {
        event.preventDefault();
        if (frame) {
            frame.open();
            return;
        }
        frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            library: {type: ['image/png', 'image/jpeg']},
            multiple: false
        });
        frame.on('select', function () {
            var selection = frame.state().get('selection').first().toJSON();
            jQuery('#background-img').val(selection.url);
            jQuery('#background-img-width-to-height').val(selection.width / selection.height);
            jQuery('#background-origin-height').val(selection.height);
            jQuery('.container_block-1').css({
                'background': 'url("' + selection.url + '") no-repeat center /cover',
                'height': (selection.height * 1170 / selection.width)
            });
        });
        frame.open();
    });

    jQuery(document).on('keyup', '.change_value_city[name="title-city[]"]', function (e) {
        var id = jQuery(jQuery('.list-citys .city_seting')).index(jQuery(this).closest('.city_seting'));
        jQuery('.container_block-1 .item-city:eq(' + id + ')').html(jQuery(this).val()).width('auto').height('auto');
    });

    jQuery(document).on('click', '.item-city', function () {
        return false;
    })

});
