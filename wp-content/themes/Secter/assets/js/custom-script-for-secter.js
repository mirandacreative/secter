function hide_search() {
    if (jQuery(window).width() < 768)
        jQuery('#home .banner #search-field, #home .banner .offer-words').hide();
    else {
        jQuery('#home .banner #search-field').show();
    }
}

function fade_in() {
    jQuery('#home .right-expertise-and-solution .item').each(function () {
        console.log();
        if (jQuery(this).offset().top < jQuery(window).scrollTop() + document.documentElement.clientHeight - jQuery(this).height() / 2) {
            jQuery(this).show().addClass('secter-fadeInUp');
        }
    });
}

var width_offer = 0, click_offer = 0, offer_words = [], width_search = 0, click_search = 0, search_words = [], json_array = [];

jQuery(window).load(function () {

    fade_in();
    jQuery('.about-us .menu .current-menu-item, .town .menu .current-menu-item').parents('.sub-menu').show().parent('li').toggleClass('open');
    jQuery('#top-menu > ul').clone().prependTo(jQuery('.hamburger-menu'));
    jQuery('#header-menu > ul').clone().prependTo(jQuery('.hamburger-menu'));
    jQuery('<span class="open-button"></span>').insertBefore(jQuery('.hamburger-menu #menu-header-menu .menu-item-has-children ul'));
    jQuery('<span class="open-button"></span>').insertBefore(jQuery('.sidebar .menu .menu-item-has-children ul'));
    jQuery('.about-us .sidebar li a, .town .sidebar li a, .industry-cluster .sidebar li a, .business-resource .sidebar li a, .program .sidebar li a').each(function () {
        if (!jQuery(this).closest('li').hasClass('current-menu-item')) {
            jQuery('.mobile-sidebar ul').append('<li><a href="' + jQuery(this).attr('href') + '">' + jQuery(this).text() + '</a></li>');
        }
    });

    jQuery(document).on('click', '.user-login a', function (e) {
        jQuery('header .black-layer').show();
        jQuery('header .login-box').show();
        return false;
    });

    jQuery(document).on('click', '.user-register a', function (e) {
        jQuery('header .black-layer').show();
        jQuery('header .registration-box').show();
        return false;
    });

    jQuery(document).on('click', '.forget-pwd', function () {
        jQuery('#loginform, #forgotform').toggle();
        return false;
    });

    jQuery(document).on('submit', '#loginform', function (e) {
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'data': jQuery(this).serialize(),
                'action': 'login-user'
            },
            success: function (res) {
                if (res.success == false)
                    jQuery('header .login-box .label-danger.message').text(res.data.message).fadeIn();
                else {
                    jQuery('header .login-box .label-success.message').text(res.data.message).fadeIn();
                    document.location = res.data.reload;
                }
                setTimeout(function () {
                    jQuery('header .login-box .message').hide();
                }, 5000);
            }
        });
        e.preventDefault();
    });

    jQuery(document).on('submit', '#forgotform', function (e) {
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'data': jQuery(this).serialize(),
                'action': 'forgot-user'
            },
            success: function (res) {
                if (res.success == false)
                    jQuery('header .login-box .label-danger.message').text(res.data.message).fadeIn();
                else {
                    jQuery('header .login-box .label-success.message').text(res.data.message).fadeIn();
                    document.getElementById('forgotform').reset();
                }
                setTimeout(function () {
                    jQuery('header .login-box .message').hide();
                }, 5000);
            }
        });
        e.preventDefault();
    });

    jQuery(document).on('submit', '#registerform', function (e) {
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'data': jQuery(this).serialize(),
                'action': 'register-user'
            },
            success: function (res) {
                console.log(1);
                if (res.success == false)
                    jQuery('header .registration-box .label-danger.message').text(res.data.message).fadeIn();
                else {
                    jQuery('header .registration-box .label-success.message').text(res.data.message).fadeIn();
                    document.getElementById('registerform').reset();
                }
                setTimeout(function () {
                    jQuery('header .registration-box .message').hide();
                }, 5000);
            }
        });
        e.preventDefault();
    });


    jQuery('#header-menu li.menu-item-has-children').hover(
        function () {
            jQuery(this).addClass('open');
            jQuery(this).children('ul').slideDown(300);
        },
        function () {
            jQuery(this).removeClass('open');
            jQuery(this).children('ul').hide();
        }
    );

    jQuery('.hamburger-menu .menu-item-has-children > a, .open-button').bind('click', function (e) {
        var menu_item = jQuery(this).closest('li');
        var main_menu = jQuery(this).closest('ul');
        if (!menu_item.hasClass('open')) {
            main_menu.find('.open').toggleClass('open').find('.sub-menu').slideUp(300);
            menu_item.toggleClass('open');
            menu_item.children('.sub-menu').slideDown(300);
            e.preventDefault();
        }
        else {
            menu_item.children('.sub-menu').slideUp(300, function () {
                menu_item.toggleClass('open');
            });
        }
    });

    jQuery('.hamburger-button').click(function () {
        var menu = jQuery('.hamburger-menu');
        menu.toggleClass('open');
        if (menu.hasClass('open'))
            menu.slideDown(300);
        else
            menu.slideUp(300);

    });

    jQuery('.list-offer-words .offer-word').each(function (index) {
        width_offer += jQuery(this)[0].getBoundingClientRect().width + 5;
        offer_words[index] = jQuery(this)[0].getBoundingClientRect().width;
    });

    hide_search();
    jQuery('#home .banner .offer-words').hide();

    if (width_offer > jQuery('.offer-words').width())
        jQuery('#left-scroll').hide();
    else
        jQuery('.offer-words .scroll').hide();
    jQuery('.list-offer-words').width(width_offer);

    jQuery('#right-scroll').click(function () {
        jQuery('#left-scroll').show();
        click_offer++;
        var left = 0;
        for (var i = 0; i < click_offer; i++)
            left += offer_words[i] + 5;
        if (width_offer - left < jQuery('#home .banner .offer-words')[0].getBoundingClientRect().width) {
            jQuery('#home .banner .list-offer-words').css('left', -width_offer + jQuery('#home .banner .offer-words').width() + 5);
            jQuery(this).hide();
        }
        else
            jQuery('#home .banner .list-offer-words').css('left', -left + jQuery('#left-scroll')[0].getBoundingClientRect().width + 5);
    });

    jQuery('#left-scroll').click(function () {
        jQuery('#right-scroll').show();
        if (click_offer == 1) {
            jQuery('#home .banner .list-offer-words').css('left', 0);
            jQuery(this).hide();
            click_offer--;
        }
        else {
            click_offer--;
            var left = 0;
            for (var i = 0; i < click_offer; i++)
                left += offer_words[i] + 5;
            jQuery('#home .banner .list-offer-words').css('left', -left + jQuery('#left-scroll')[0].getBoundingClientRect().width + 5);
        }
    });

    jQuery(document).on('click', '.offer-word', function () {
        search_words = [];
        var value = jQuery(this).val();
        var id = jQuery(this).attr('id');
        if (!jQuery(this).hasClass('disable')) {
            jQuery(this).addClass('disable');
            jQuery('<input class="hidden-tag-id" name="search-tag[]" type="hidden" value="' + id + '">').insertBefore(jQuery('#home .banner #search-field .search-word'));
            jQuery('<input class="button-selected-tag" data-target="' + id + '" type="button" value="' + value + '">').insertBefore(jQuery('#home .banner #search-field .search-word'));
            var width = 0;
            jQuery('.inner-search-field input:not(.hidden-tag-id)').each(function (index) {
                width += jQuery(this)[0].getBoundingClientRect().width + 5;
                search_words[index] = jQuery(this)[0].getBoundingClientRect().width;
            });
            width_search = width - 5;
            jQuery('#home .banner #search-field .search-field').width(width_search);
            if (width_search > jQuery('#home .banner #search-field .inner-search-field')[0].getBoundingClientRect().width) {
                jQuery('#home .banner #search-field .search-field').css('left', -width_search + jQuery('.inner-search-field').width() - 2);
                width = width_search;
                jQuery.each(search_words, function (index, item) {
                    width -= item;
                    if (jQuery('#home .banner #search-field .inner-search-field')[0].getBoundingClientRect().width > width) {
                        click_search = index + 1;
                        return false;
                    }
                });
                jQuery('#right-scroll-search-words').hide();
                jQuery('#left-scroll-search-words').show();
            }
            else {
                jQuery('#home .banner #search-field .search-field').css('left', 0);
                jQuery('#right-scroll-search-words').hide();
                jQuery('#left-scroll-search-words').hide();
            }
        }
        if (jQuery(this).hasClass('dropdown-button')) {
            jQuery('#home .banner #search-field .search-word').val('');
            jQuery('#list-of-not-used-tags ul').remove();
            jQuery.each(json_array, function (index, value) {
                if (value.term_id == id) {
                    value.used = true;
                }
            });
        }
    });

    jQuery(document).on('click', '.button-selected-tag', function () {
        search_words = [];
        var width = 0;
        var width_overflow_search = jQuery('#home .banner #search-field .inner-search-field')[0].getBoundingClientRect().width;
        var id = jQuery(this).data('target');
        jQuery(this).remove();
        jQuery('.hidden-tag-id[value="' + id + '"]').remove();
        jQuery('.offer-word#' + id).removeClass('disable');
        jQuery('.inner-search-field input:not(.hidden-tag-id)').each(function (index) {
            width += jQuery(this)[0].getBoundingClientRect().width + 5;
            search_words[index] = jQuery(this)[0].getBoundingClientRect().width;
        });
        width_search = width - 5;
        jQuery('#home .banner #search-field .search-field').width(width_search);
        if (width_search > width_overflow_search) {
            jQuery('#home .banner #search-field .search-field').css('left', -width_search + jQuery('.inner-search-field').width() - 2);
            width = width_search;
            jQuery.each(search_words, function (index, item) {
                width -= item;
                if (width_overflow_search > width) {
                    click_search = index + 1;
                    return false;
                }
            });
            jQuery('#right-scroll-search-words').hide();
            jQuery('#left-scroll-search-words').show();
        }
        else {
            jQuery('#home .banner #search-field .search-field').css('left', 0);
            jQuery('#right-scroll-search-words').hide();
            jQuery('#left-scroll-search-words').hide();
            click_search = 0;
        }
        jQuery.each(json_array, function (index, value) {
            if (value.term_id == id) {
                value.used = false;
            }
        });
    });

    jQuery('#left-scroll-search-words').click(function () {
        jQuery('#right-scroll-search-words').show();
        if (click_search == 1) {
            jQuery('#home .banner #search-field .search-field').css('left', 0);
            jQuery(this).hide();
            click_search--;
        }
        else {
            click_search--;
            var left = 0;
            for (var i = 0; i < click_search; i++)
                left += search_words[i] + 5;
            jQuery('#home .banner #search-field .search-field').css('left', -left + 31);
        }
    });

    jQuery(document).click(function (event) {
        var block = jQuery('#list-of-not-used-tags');
        if (!block.is(event.target) && block.has(event.target).length === 0)
            block.children('ul').remove();
    });

    jQuery('#right-scroll-search-words').click(function () {
        jQuery('#left-scroll-search-words').show();
        click_search++;
        var left = 0;
        for (var i = 0; i < click_search; i++)
            left += search_words[i] + 5;
        if (width_search - left < jQuery('#home .banner #search-field .inner-search-field')[0].getBoundingClientRect().width) {
            jQuery('#home .banner #search-field .search-field').css('left', -width_search + jQuery('.inner-search-field').width() - 2);
            jQuery(this).hide();
        }
        else
            jQuery('#home .banner #search-field .search-field').css('left', -left + 31);
    });

    if (jQuery('input').is('#not-used-tags'))
        json_array = JSON.parse(jQuery('#not-used-tags').val());

    jQuery('#home .banner #search-field .search-word').keyup(function (e) {
        var block = '<ul>';
        var string = jQuery(this).val();
        jQuery.each(json_array, function (index, value) {
            if (value.name.toUpperCase().indexOf(string.toUpperCase()) != -1 && string != '' && value.used != true) {
                block += '<li><input id="' + value.term_id + '" type="button" class="offer-word dropdown-button" value="' + value.name + '"></li>';
            }
        });
        block += '</ul>';
        jQuery('#list-of-not-used-tags').html(block);
        jQuery('#list-of-not-used-tags ul').mCustomScrollbar({
            theme: "dark"
        });
    });

    jQuery(window).resize(function () {
        hide_search();
    });

    jQuery('.comprehensive-information .item').hover(
        function () {
            jQuery(this).find('a').addClass('secter-fadeInUp');
        },
        function () {
            jQuery(this).find('a').removeClass('secter-fadeInUp');
        }
    );

    jQuery(window).scroll(function () {
        fade_in();
        (jQuery(this).scrollTop() > offset) ? jQuery('#to-top').show() : jQuery('#to-top').hide();
    });

    jQuery('header .search-button-menu-element a').click(function () {
        if (jQuery(this).hasClass('open'))
            jQuery('form#search-field-header-menu').css({'height': 0, 'padding': '0 20px', 'border-width': 0});
        else
            jQuery('form#search-field-header-menu').css({'height': 62, 'padding': '10px 20px', 'border-width': 1});
        jQuery(this).toggleClass('open');
        return false;
    });

    jQuery('header .search-button-mob').click(function () {
        if (jQuery(this).hasClass('open'))
            jQuery('form#search-field-header-mob').css({'height': 0, 'padding': '0 10px', 'border-width': 0});
        else
            jQuery('form#search-field-header-mob').css({'height': 50, 'padding': '5px 10px', 'border-width': 1});
        jQuery(this).toggleClass('open');
    });

    jQuery('#home .banner .search-word').click(function () {
        jQuery(this).closest('.inner-banner').find('.offer-words').show().addClass('fadeIn');
    });

    jQuery('.about-us .mobile-sidebar .current-page, .about-us .select-town-block .town-selected, .town .mobile-sidebar .current-page, .town .select-town-block .town-selected, .industry-cluster .mobile-sidebar .current-page,.program .mobile-sidebar .current-page, .business-resource .mobile-sidebar .current-page').click(function () {
        if (!jQuery(this).hasClass('open'))
            jQuery(this).next().slideDown(300);
        else
            jQuery(this).next().slideUp(300);
        jQuery(this).toggleClass('open')
    });

    jQuery(document).on('click', '.events-list .link', function (e) {
        jQuery('footer .content-layer .time').text(jQuery(this).data('time'));
        jQuery('footer .content-layer .title').text(jQuery(this).text());
        jQuery('footer .content-layer .content').html(jQuery(this).data('content'));
        jQuery('footer .black-layer, footer .content-layer').fadeIn();
        return false;
    });

    jQuery(document).on('click', '.black-layer, .close-all-layers', function () {
        jQuery('.black-layer, header .login-box, header .registration-box, footer .content-layer').hide();
        jQuery('#loginform').show();
        jQuery('#forgotform').hide();
    });

    jQuery('#to-top').click(function (e) {
        e.preventDefault();
        jQuery('body').animate({
                scrollTop: 0
            }, 700
        );
    });

    var offset = 300;
    (jQuery(this).scrollTop() > offset) ? jQuery('#to-top').show() : jQuery('#to-top').hide();

    jQuery('#preloader').fadeOut('slow');

});