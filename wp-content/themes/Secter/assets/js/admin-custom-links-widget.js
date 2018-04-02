jQuery(window).load(function () {
    jQuery(document).on('click', '.custom-widget-links .add-link', function () {
        var before = '<div class="item-element">';
        before += '<p><span>Link</span>' + jQuery(this).closest('.custom-widget-links').find('.hidden-input-links').val() + '</p>';
        before += '<p><span>rel</span>' + jQuery(this).closest('.custom-widget-links').find('.hidden-input-select').val() + '</p>';
        before += '<p><span>Title link</span>' + jQuery(this).closest('.custom-widget-links').find('.hidden-input-title').val() + '</p>';
        before += '<button type="button" class="delete-link">Delete</button></div>';
        jQuery(this).before(before);
    });

    jQuery(document).on('click', '.custom-widget-links .item-element .delete-link', function () {
        jQuery(this).closest('.item-element').remove();
    });
});