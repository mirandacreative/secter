<?php

add_filter('page_row_actions', 'remove_quick_edit', 10, 1);
add_filter('post_row_actions', 'remove_quick_edit', 10, 1);

function remove_menus()
{
    remove_menu_page('edit-comments.php');
}

function change_SQL_query_WP_for_search($where)
{
    $where .= " OR ((wp_posts.post_title LIKE '%" . esc_sql($_GET['search-word']) . "%' OR wp_posts.post_excerpt LIKE '%" . esc_sql($_GET['search-word']) . "%' OR wp_posts.post_content LIKE '%" . esc_sql($_GET['search-word']) . "%') AND wp_posts.post_type IN ('page', 'post','town'))";
    return $where;
}

add_action('admin_menu', 'remove_menus');

add_action('init', 'secter_rewrite_rules');

function secter_rewrite_rules()
{
    add_rewrite_rule('([^/]+)/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]', 'top');
}

flush_rewrite_rules();

function enqueue_scripts_for_category($query)
{
    if ($query->is_category()) {
        wp_enqueue_style('custom-style-for-category', get_template_directory_uri() . '/assets/css-template/news.css', false);
        wp_register_script('masonry-js-for-secter', get_template_directory_uri() . '/assets/js/masonry.min.js', array('jquery'), false);
        wp_enqueue_script('masonry-js-for-secter');
    }
}

add_action('pre_get_posts', 'enqueue_scripts_for_category');

get_template_part('class-links-widget');

$template = get_page_template_slug($_GET['post']);
if (isset($_GET['post_type']))
    $post_type = $_GET['post_type'];
else
    $post_type = get_post_type($_GET['post']);

function secter_the_content($value)
{
    echo stripslashes(wpautop($value));
}

add_action('admin_enqueue_scripts', 'enqueue_admin_script_and_style');

function enqueue_admin_script_and_style()
{
    wp_enqueue_style('admin-custom-style', get_template_directory_uri() . '/assets/css-template/admin-style.css');
    if (isset($_GET['taxonomy'])) {
        wp_register_script('admin-script-for-post-type', get_template_directory_uri() . '/assets/js/admin-script-for-post-type.js', array('jquery'), false, false);
        wp_enqueue_script('admin-script-for-post-type');
    }
}

function enqueue_admin_script_for_custom_editor()
{
    wp_register_script('admin-custom-script-for-editor', get_template_directory_uri() . '/assets/js/admin-script-for-custom-editor.js', array('jquery', 'jquery-ui-sortable'), false, false);
    wp_enqueue_script('admin-custom-script-for-editor');
}

function enqueue_admin_script_for_page()
{
    wp_register_script('admin-script-for-page', get_template_directory_uri() . '/assets/js/admin-script-for-page.js', array('jquery'), false, false);
    wp_enqueue_script('admin-script-for-page');
}

function enqueue_admin_script_for_post_type()
{
    wp_register_script('admin-script-for-post-type', get_template_directory_uri() . '/assets/js/admin-script-for-post-type.js', array('jquery'), false, false);
    wp_enqueue_script('admin-script-for-post-type');
}

function remove_page_editor()
{
    remove_post_type_support('page', 'editor');
}

function secter_extra_editor_for_page_home($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<h2>SLIDER BANNER</h2>';
    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['slides'] as $slide) {
        echo '<li class="item secter-slider-item-editor-home ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[slides][]" value="' . $slide . '">';
        echo '<div class="image-uploader-block"><img src="' . $slide . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="slider" class="add-admin-editor" data-sorted="sorted" value="add new slide"></div>';
    echo '</div>';

    $argument = array(
        'textarea_name' => 'array[text-right-expertise][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-right-expertise');

    echo '<div class="custom-content">';
    echo '<h2>THE RIGHT EXPERTISE. THE RIGHT SOLUTIONS</h2>';
    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-right-expertise'] as $key => $text) {
        echo '<li class="item secter-right-expertise-item-editor-home ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-right-expertise" type="text" placeholder="title" name="array[title-right-expertise][]" value="' . $text . '">';
        $editor_id = 'secter_custom_editor_for_right_expertise_' . $key;
        wp_editor(stripslashes($content['text-right-expertise'][$key]), $editor_id, $argument);
        echo '<input class="link-right-expertise" type="text" placeholder="link" name="array[link-right-expertise][]" value="' . $content['link-right-expertise'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="right-expertise" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';

    $argument = array(
        'textarea_name' => 'array[text-success-stories][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-success-stories');

    echo '<div class="custom-content">';
    echo '<h2>SUCCESS STORIES</h2>';
    for ($i = 0; $i < 5; $i++) {
        echo '<div class="item secter-success-stories-item-editor-home">';
        echo '<input class="title-success-stories" type="text" placeholder="title" name="array[title-success-stories][]" value="' . $content['title-success-stories'][$i] . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-success-stories][]" value="' . $content['link-image-success-stories'][$i] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-success-stories'][$i] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_success_stories_' . $i;
        wp_editor(stripslashes($content['text-success-stories'][$i]), $editor_id, $argument);
        echo '<input class="link-success-stories" type="text" placeholder="link" name="array[link-success-stories][]" value="' . $content['link-success-stories'][$i] . '">';
        echo '</div>';
    }
    echo '</div>';

    $argument = array(
        'textarea_name' => 'array[text-comprehensive-information][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-success-stories');

    echo '<div class="custom-content">';
    echo '<h2>COMPREHENSIVE INFORMATION TO HELP YOUR BUSINESS</h2>';
    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-comprehensive-information'] as $key => $text) {
        echo '<li class="item secter-comprehensive-information-item-editor-home ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-comprehensive-information" type="text" placeholder="title" name="array[title-comprehensive-information][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-comprehensive-information][]" value="' . $content['link-image-comprehensive-information'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-comprehensive-information'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-comprehensive-information-hover][]" value="' . $content['link-image-comprehensive-information-hover'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-comprehensive-information-hover'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_comprehensive_information' . $key;
        wp_editor(stripslashes($content['text-comprehensive-information'][$key]), $editor_id, $argument);
        echo '<input class="link-comprehensive-information" type="text" placeholder="link" name="array[link-comprehensive-information][]" value="' . $content['link-comprehensive-information'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="comprehensive-information" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_page_staff($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-staff-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-staff');
    $editor_id = 'secter_custom_editor_for_staff_main';
    wp_editor(stripslashes($content['text-staff-main']), $editor_id, $argument);

    echo '</div>';
    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-staff][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-staff');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-staff'] as $key => $text) {
        echo '<li class="item secter-staff-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-staff" type="text" placeholder="title" name="array[title-staff][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-staff][]" value="' . $content['link-image-staff'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-staff'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_staff_' . $key;
        wp_editor(stripslashes($content['text-staff'][$key]), $editor_id, $argument);
        echo '<input class="email-staff" type="text" placeholder="Email" name="array[email-staff][]" value="' . $content['email-staff'][$key] . '">';
        echo '<input class="phone-staff" type="text" placeholder="Phone" name="array[phone-staff][]" value="' . $content['phone-staff'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="staff" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_page_board_of_directors($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-board-of-directors-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-board-of-directors');
    $editor_id = 'secter_custom_editor_for_board-of-directors_main';
    wp_editor(stripslashes($content['text-board-of-directors-main']), $editor_id, $argument);

    echo '</div>';
    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-board-of-directors][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-board-of-directors');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-board-of-directors'] as $key => $text) {
        echo '<li class="item secter-board-of-directors-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-board-of-directors" type="text" placeholder="title" name="array[title-board-of-directors][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-board-of-directors][]" value="' . $content['link-image-board-of-directors'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-board-of-directors'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_board-of-directors_' . $key;
        wp_editor(stripslashes($content['text-board-of-directors'][$key]), $editor_id, $argument);
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="board-of-directors" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_business_resource($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-business-resource-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-business-resource');
    $editor_id = 'secter_custom_editor_for_business-resource_main';
    wp_editor(stripslashes($content['text-business-resource-main']), $editor_id, $argument);

    echo '</div>';
    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-business-resource][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-business-resource');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-business-resource'] as $key => $text) {
        echo '<li class="item secter-business-resource-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-business-resource" type="text" placeholder="title" name="array[title-business-resource][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-business-resource][]" value="' . $content['link-image-business-resource'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-business-resource'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_business-resource_' . $key;
        wp_editor(stripslashes($content['text-business-resource'][$key]), $editor_id, $argument);
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="business-resource" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_programs($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-programs-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-programs');
    $editor_id = 'secter_custom_editor_for_programs_main';
    wp_editor(stripslashes($content['text-programs-main']), $editor_id, $argument);

    echo '</div>';
    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-programs][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-programs');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-programs'] as $key => $text) {
        echo '<li class="item secter-programs-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-programs" type="text" placeholder="title" name="array[title-programs][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-programs][]" value="' . $content['link-image-programs'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-programs'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_programs_' . $key;
        wp_editor(stripslashes($content['text-programs'][$key]), $editor_id, $argument);
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="programs" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_page_about_us($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-about-us][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-about-us');

    echo '<ul id="sortable" class="sorted-item">';
    echo '<li class="item secter-about-us-item-editor ui-state-default">';
    echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
    echo '<input class="title-about-us" type="text" placeholder="title" name="array[title-about-us][]" value="' . stripslashes($content['title-about-us'][0]) . '">';
    $editor_id = 'secter_custom_editor_for_about-us_0';
    wp_editor(stripslashes($content['text-about-us'][0]), $editor_id, $argument);
    echo '</li>';
    foreach ($content['title-about-us'] as $key => $text) {
        if ($key != 0) {
            echo '<li class="item secter-about-us-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-about-us" type="text" placeholder="title" name="array[title-about-us][]" value="' . $text . '">';
            $editor_id = 'secter_custom_editor_for_about-us_' . $key;
            wp_editor(stripslashes($content['text-about-us'][$key]), $editor_id, $argument);
            echo '</li>';
        }
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="about-us" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_page_newsletter($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-newsletter]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-newsletter');

    echo '<div class="item secter-newsletter-item-editor">';
    $editor_id = 'secter_custom_editor_for_text-newsletter';
    wp_editor(stripslashes($content['text-newsletter']), $editor_id, $argument);
    echo '</div>';
    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-link-newsletter'] as $key => $text) {
        echo '<li class="item secter-newsletter-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-link-newsletter" type="text" placeholder="title" name="array[title-link-newsletter][]" value="' . $text . '">';
        echo '<input class="link-newsletter" type="text" placeholder="link" name="array[link-newsletter][]" value="' . $content['link-newsletter'][$key] . '">';
        echo '<div class="checkbox-block-editor-secter">';
        echo '<input type="hidden" name="array[nofollow-newsletter][]" value="' . ((1 == $content['nofollow-newsletter'][$key]) ? '1' : '0') . '">';
        echo '<label>Nofollow? </label>';
        echo '<input class="nofollow-newsletter" type="checkbox"' . ((1 == $content['nofollow-newsletter'][$key]) ? 'checked="checked"' : '') . '>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="newsletter" class="add-admin-editor" data-sorted="sorted" value="add new link"></div>';
    echo '</div>';
}

function secter_extra_editor_for_page_towns($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-towns-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-towns-main');
    $editor_id = 'secter_custom_editor_for_towns_main';
    wp_editor(stripslashes($content['text-towns-main']), $editor_id, $argument);

    $argument = array(
        'textarea_name' => 'array[text-towns][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-towns');

    echo '</div>';
    echo '<div class="custom-content">';

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-towns'] as $key => $text) {
        echo '<li class="item secter-towns-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-towns" type="text" placeholder="title" name="array[title-towns][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-towns][]" value="' . $content['link-image-towns'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-towns'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_towns_' . $key;
        wp_editor(stripslashes($content['text-towns'][$key]), $editor_id, $argument);
        echo '<input class="link-towns" type="text" placeholder="Title for Link" name="array[title-link-towns][]" value="' . $content['title-link-towns'][$key] . '">';
        echo '<input class="link-towns" type="text" placeholder="Link" name="array[link-towns][]" value="' . $content['link-towns'][$key] . '">';
        echo '<input class="website-towns" type="text" placeholder="Title for Website" name="array[website-title-towns][]" value="' . $content['website-title-towns'][$key] . '">';
        echo '<input class="website-towns" type="text" placeholder="Website" name="array[website-towns][]" value="' . $content['website-towns'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="towns" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';
}

function secter_extra_editor_for_town($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';

    $argument = array(
        'textarea_name' => 'array[text-town-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-town-main');
    $editor_id = 'secter_custom_editor_for_town_main';
    wp_editor(stripslashes($content['text-town-main']), $editor_id, $argument);

    $argument = array(
        'textarea_name' => 'array[text-town][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-town');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-town'] as $key => $text) {
        echo '<li class="item secter-town-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-town" type="text" placeholder="title" name="array[title-town][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-town][]" value="' . $content['link-image-town'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-town'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_town_' . $key;
        wp_editor(stripslashes($content['text-town'][$key]), $editor_id, $argument);
        echo '<input class="link-town" type="text" placeholder="Title for Link" name="array[title-link-town][]" value="' . $content['title-link-town'][$key] . '">';
        echo '<input class="link-town" type="text" placeholder="Link" name="array[link-town][]" value="' . $content['link-town'][$key] . '">';
        echo '<input class="website-town" type="text" placeholder="Title for Website" name="array[website-title-town][]" value="' . $content['website-title-town'][$key] . '">';
        echo '<input class="website-town" type="text" placeholder="Website" name="array[website-town][]" value="' . $content['website-town'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="town" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';

    echo '<div class="custom-content">';
    echo '<h2>FEATURED PROPERTIES</h2>';
    $featured_properties = new WP_Query(array('post_type' => 'featured_properties', 'posts_per_page' => -1));
    echo '<ul class="items">';
    if ($featured_properties->have_posts()) {
        foreach ($content['id-featured-properties'] as $id) {
            echo '<li class="item secter-featured-properties-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<select name="array[id-featured-properties][]">';
            foreach ($featured_properties->posts as $post) {
                if ($post->ID == $id)
                    echo '<option selected="selected" value=' . $post->ID . '>' . $post->post_title . '</option>';
                else
                    echo '<option value=' . $post->ID . '>' . $post->post_title . '</option>';
            }
            echo '</select>';
            echo '</li>';
        }
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="featured-properties" class="add-admin-editor" value="add new featured properties"></div>';

    echo '</div>';
}

function secter_extra_editor_for_page_choose_sect($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<input type="text" placeholder="Title main block" name="array[main-block-title]" class="main-block-title" value="' . $content['main-block-title'] . '">';
    echo '<input type="text" placeholder="Subtitle main block" name="array[main-block-subtitle]" class="main-block-subtitle" value="' . $content['main-block-subtitle'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-special-landing-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-main');
    $editor_id = 'secter_custom_editor_for_choose_sect_main';
    wp_editor(stripslashes($content['text-special-landing-main']), $editor_id, $argument);
    echo '</div>';

    echo '<div class="custom-content">';
    echo '<h2>SLIDER</h2>';

    $argument = array(
        'textarea_name' => 'array[text-special-landing-slider][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-slider');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['text-special-landing-slider'] as $key => $text) {
        echo '<li class="item secter-special-landing-slider-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        $editor_id = 'secter_custom_editor_for_town_' . $key;
        wp_editor(stripslashes($text), $editor_id, $argument);
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="special-landing-slider" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';

    echo '<div class="custom-content secter-special-landing-featured-properties-editor">';
    echo '<h2>FEATURED PROPERTIES SPECIAL BLOCK</h2>';

    $argument = array(
        'textarea_name' => 'array[text-special-landing-featured-properties]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-featured-properties');

    echo '<div class="block-uploader">';
    echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
    echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-special-landing-featured-properties]" value="' . $content['link-image-special-landing-featured-properties'] . '">';
    echo '<div class="image-uploader-block"><img src="' . $content['link-image-special-landing-featured-properties'] . '" class="image-uploader"></div>';
    echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
    echo '</div>';
    echo '<input type="text" placeholder="Title for right block in featured roperties" class="title-special-landing-featured-properties" name="array[title-special-landing-featured-properties]" value="' . $content['title-special-landing-featured-properties'] . '">';
    $editor_id = 'secter_custom_editor_for_special_landing_featured_properties';
    wp_editor(stripslashes($content['text-special-landing-featured-properties']), $editor_id, $argument);
    echo '<input type="text" placeholder="Link for right block in featured roperties" class="link-special-landing-featured-properties" name="array[link-special-landing-featured-properties]" value="' . $content['link-special-landing-featured-properties'] . '">';
    echo '</div>';

    echo '<div class="custom-content">';
    echo '<h2>ARTICLE BLOCK</h2>';
    $argument = array(
        'textarea_name' => 'array[text-special-landing-article][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-article');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-special-landing-article'] as $key => $text) {
        echo '<li class="item secter-text-special-landing-article-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-special-landing-article" type="text" placeholder="Title artickle" name="array[title-special-landing-article][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-article][]" value="' . $content['link-image-article'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-article'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_special_landing_article_' . $key;
        wp_editor(stripslashes($content['text-special-landing-article'][$key]), $editor_id, $argument);
        echo '<input class="link-special-landing-article" type="text" placeholder="Link" name="array[link-special-landing-article][]" value="' . $content['link-special-landing-article'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="special-landing-article" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';

    echo '</div>';
}

function secter_extra_editor_for_page_real_estate($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<input type="text" placeholder="Title main block" name="array[main-block-title]" class="main-block-title" value="' . $content['main-block-title'] . '">';
    echo '<input type="text" placeholder="Subtitle main block" name="array[main-block-subtitle]" class="main-block-subtitle" value="' . $content['main-block-subtitle'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-special-landing-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-main');
    $editor_id = 'secter_custom_editor_for_real_estate_main';
    wp_editor(stripslashes($content['text-special-landing-main']), $editor_id, $argument);

    echo '</div>';
    echo '<div class="custom-content secter-special-landing-featured-properties-editor">';
    echo '<h2>FEATURED PROPERTIES SPECIAL BLOCK</h2>';

    $argument = array(
        'textarea_name' => 'array[text-special-landing-featured-properties]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-featured-properties');

    echo '<div class="block-uploader">';
    echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
    echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-special-landing-featured-properties]" value="' . $content['link-image-special-landing-featured-properties'] . '">';
    echo '<div class="image-uploader-block"><img src="' . $content['link-image-special-landing-featured-properties'] . '" class="image-uploader"></div>';
    echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
    echo '</div>';
    echo '<input type="text" placeholder="Title for right block in featured roperties" class="title-special-landing-featured-properties" name="array[title-special-landing-featured-properties]" value="' . $content['title-special-landing-featured-properties'] . '">';
    $editor_id = 'secter_custom_editor_for_special_landing_featured_properties';
    wp_editor(stripslashes($content['text-special-landing-featured-properties']), $editor_id, $argument);
    echo '<input type="text" placeholder="Link for right block in featured roperties" class="link-special-landing-featured-properties" name="array[link-special-landing-featured-properties]" value="' . $content['link-special-landing-featured-properties'] . '">';

    echo '</div>';

    echo '<div class="custom-content">';
    echo '<h2>ARTICLE BLOCK</h2>';
    $argument = array(
        'textarea_name' => 'array[text-special-landing-article][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-special-landing-article');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-special-landing-article'] as $key => $text) {
        echo '<li class="item secter-text-special-landing-article-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-special-landing-article" type="text" placeholder="Title artickle" name="array[title-special-landing-article][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-article][]" value="' . $content['link-image-article'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-article'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_special_landing_article_' . $key;
        wp_editor(stripslashes($content['text-special-landing-article'][$key]), $editor_id, $argument);
        echo '<input class="link-special-landing-article" type="text" placeholder="Link" name="array[link-special-landing-article][]" value="' . $content['link-special-landing-article'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="special-landing-article" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';

    echo '</div>';
}

function secter_extra_editor_for_page_industry_clusters($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<input type="text" placeholder="Title main block" name="array[main-block-title]" class="main-block-title" value="' . $content['main-block-title'] . '">';
    echo '<input type="text" placeholder="Subtitle main block" name="array[main-block-subtitle]" class="main-block-subtitle" value="' . $content['main-block-subtitle'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-industry-clusters-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-industry-clusters-main');
    $editor_id = 'secter_custom_editor_for_industry_clusters_main';
    wp_editor(stripslashes($content['text-industry-clusters-main']), $editor_id, $argument);
    echo '</div>';
    echo '<div class="custom-content">';
    echo '<h2>LIST OF BLOCK</h2>';
    $argument = array(
        'textarea_name' => 'array[text-industry-clusters-article][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-industry-clusters-article');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-industry-clusters-article'] as $key => $text) {
        echo '<li class="item secter-text-industry-clusters-article-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-industry-clusters-article" type="text" placeholder="Title artickle" name="array[title-industry-clusters-article][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-industry-clusters-article][]" value="' . $content['link-image-industry-clusters-article'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-industry-clusters-article'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_industry_clusters_article_' . $key;
        wp_editor(stripslashes($content['text-industry-clusters-article'][$key]), $editor_id, $argument);
        echo '<input class="link-industry-clusters-article" type="text" placeholder="Link" name="array[link-industry-clusters-article][]" value="' . $content['link-industry-clusters-article'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="industry-clusters-article" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';

    echo '</div>';
}

function secter_extra_editor_for_industry_clusters($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    $argument = array(
        'textarea_name' => 'array[text-industry-clusters-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-industry-clusters-main');
    $editor_id = 'secter_custom_editor_for_industry_clusters_main';
    wp_editor(stripslashes($content['text-industry-clusters-main']), $editor_id, $argument);

    echo '</div>';

    echo '<div class="custom-content">';
    echo '<h2>DATA BLOCK</h2>';
    echo '<input class="subtitle-special-block-industry-clusters" type="text" placeholder="Subtitle industry clusters" name="array[subtitle-special-block-industry-clusters]" value="' . $content['subtitle-special-block-industry-clusters'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-industry-clusters-data][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-industry-clusters-data');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['text-industry-clusters-data'] as $key => $text) {
        echo '<li class="item secter-text-industry-clusters-data-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-industry-clusters-data][]" value="' . $content['link-image-industry-clusters-data'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-industry-clusters-data'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_industry_clusters_data_' . $key;
        wp_editor(stripslashes($text), $editor_id, $argument);
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="industry-clusters-data" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';
    echo '</div>';

}


function secter_extra_editor_for_page_business_resources($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<input type="text" placeholder="Title main block" name="array[main-block-title]" class="main-block-title" value="' . $content['main-block-title'] . '">';
    echo '<input type="text" placeholder="Subtitle main block" name="array[main-block-subtitle]" class="main-block-subtitle" value="' . $content['main-block-subtitle'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-business-resources-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-business-resources-main');
    $editor_id = 'secter_custom_editor_for_business_resources_main';
    wp_editor(stripslashes($content['text-business-resources-main']), $editor_id, $argument);
    echo '</div>';
    echo '<div class="custom-content">';
    echo '<h2>LIST OF BLOCK</h2>';
    $argument = array(
        'textarea_name' => 'array[text-business-resources-article][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-business-resources-article');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-business-resources-article'] as $key => $text) {
        echo '<li class="item secter-text-business-resources-article-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-business-resources-article" type="text" placeholder="Title artickle" name="array[title-business-resources-article][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-business-resources-article][]" value="' . $content['link-image-business-resources-article'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-business-resources-article'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_industry_clusters_article_' . $key;
        wp_editor(stripslashes($content['text-business-resources-article'][$key]), $editor_id, $argument);
        echo '<input class="link-business-resources-article" type="text" placeholder="Link" name="array[link-business-resources-article][]" value="' . $content['link-business-resources-article'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="business-resources-article" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';

    echo '</div>';
}

function secter_extra_editor_for_page_programs($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<input type="text" placeholder="Title main block" name="array[main-block-title]" class="main-block-title" value="' . $content['main-block-title'] . '">';
    echo '<input type="text" placeholder="Subtitle main block" name="array[main-block-subtitle]" class="main-block-subtitle" value="' . $content['main-block-subtitle'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-programs-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-programs-main');
    $editor_id = 'secter_custom_editor_for_programs_main';
    wp_editor(stripslashes($content['text-programs-main']), $editor_id, $argument);
    echo '</div>';
    echo '<div class="custom-content">';
    echo '<h2>LIST OF BLOCK</h2>';
    $argument = array(
        'textarea_name' => 'array[text-programs-article][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-programs-article');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-programs-article'] as $key => $text) {
        echo '<li class="item secter-text-programs-article-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-programs-article" type="text" placeholder="Title artickle" name="array[title-programs-article][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-programs-article][]" value="' . $content['link-image-programs-article'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-programs-article'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_industry_clusters_article_' . $key;
        wp_editor(stripslashes($content['text-programs-article'][$key]), $editor_id, $argument);
        echo '<input class="link-programs-article" type="text" placeholder="Link" name="array[link-programs-article][]" value="' . $content['link-programs-article'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="programs-article" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';

    echo '</div>';
}

function secter_extra_editor_for_page_single_choose_sect($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content">';
    echo '<input type="text" placeholder="Title main block" name="array[main-block-title]" class="main-block-title" value="' . $content['main-block-title'] . '">';
    echo '<input type="text" placeholder="Subtitle main block" name="array[main-block-subtitle]" class="main-block-subtitle" value="' . $content['main-block-subtitle'] . '">';
    $argument = array(
        'textarea_name' => 'array[text-single_choose_sect-main]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-single_choose_sect-main');
    $editor_id = 'secter_custom_editor_for_single_choose_sect_main';
    wp_editor(stripslashes($content['text-single_choose_sect-main']), $editor_id, $argument);
    echo '</div>';
    echo '<div class="custom-content">';
    echo '<h2>LIST OF BLOCK</h2>';
    $argument = array(
        'textarea_name' => 'array[text-single_choose_sect-article][]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'text-single_choose_sect-article');

    echo '<ul id="sortable" class="sorted-item">';
    foreach ($content['title-single_choose_sect-article'] as $key => $text) {
        echo '<li class="item secter-text-single_choose_sect-article-item-editor ui-state-default">';
        echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
        echo '<input class="title-single_choose_sect-article" type="text" placeholder="Title artickle" name="array[title-single_choose_sect-article][]" value="' . $text . '">';
        echo '<div class="block-uploader">';
        echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
        echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-single_choose_sect-article][]" value="' . $content['link-image-single_choose_sect-article'][$key] . '">';
        echo '<div class="image-uploader-block"><img src="' . $content['link-image-single_choose_sect-article'][$key] . '" class="image-uploader"></div>';
        echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
        echo '</div>';
        $editor_id = 'secter_custom_editor_for_text_industry_clusters_article_' . $key;
        wp_editor(stripslashes($content['text-single_choose_sect-article'][$key]), $editor_id, $argument);
        echo '<input class="link-single_choose_sect-article" type="text" placeholder="Link" name="array[link-single_choose_sect-article][]" value="' . $content['link-single_choose_sect-article'][$key] . '">';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="add-item-button"><input type="button" data-target="single_choose_sect-article" class="add-admin-editor" data-sorted="sorted" value="add new editor"></div>';

    echo '</div>';
}

function secter_extra_editor_for_page_contact($post)
{
    $content = unserialize($post->post_content);

    echo '<div class="custom-content left-block">';
    echo '<h2>LEFT BLOCK</h2>';
    echo '<label for="telephon"><span>Telephone</span><input id="telephone" type="tel" name="array[telephone-contact-form]" value="' . $content['telephone-contact-form'] . '"></label>';
    echo '<label for="fax"><span>FAX</span><input id="fax" type="tel" name="array[fax-contact-form]" value="' . $content['fax-contact-form'] . '"></label>';
    echo '<label for="email"><span>Email</span><input id="email" type="email" name="array[email-contact-form]" value="' . $content['email-contact-form'] . '"></label>';
    $argument = array(
        'textarea_name' => 'array[address-contact-form]',
        'quicktags' => 0,
        'drag_drop_upload' => false,
        'editor_class' => 'address-contact-form');
    $editor_id = 'address-contact-form';
    wp_editor(stripslashes($content['address-contact-form']), $editor_id, $argument);
    echo '</div>';

    echo '<div class="custom-content right-block">';
    echo '<h2>RIGHT BLOCK</h2>';
    echo '<label for="link-facebook"><span>Link Facebook</span><input id="link-facebook" type="tel" name="array[link-facebook-contact-form]" value="' . $content['link-facebook-contact-form'] . '"></label>';
    echo '<label for="title-facebook"><span>Title Facebook</span><input id="title-facebook" type="tel" name="array[title-facebook-contact-form]" value="' . $content['title-facebook-contact-form'] . '"></label>';
    echo '<label for="link-twitter"><span>Link Twitter</span><input id="link-twitter" type="tel" name="array[link-twitter-contact-form]" value="' . $content['link-twitter-contact-form'] . '"></label>';
    echo '<label for="title-twitter"><span>Title Twitter</span><input id="title-twitter" type="tel" name="array[title-twitter-contact-form]" value="' . $content['title-twitter-contact-form'] . '"></label>';
    echo '<label for="link-linkedin"><span>Link LinkedIn</span><input id="link-linkedin" type="tel" name="array[link-linkedin-contact-form]" value="' . $content['link-linkedin-contact-form'] . '"></label>';
    echo '<label for="title-linkedin"><span>Title LinkedIn</span><input id="title-facebook" type="tel" name="array[title-linkedin-contact-form]" value="' . $content['title-linkedin-contact-form'] . '"></label>';
    echo '</div>';
}

if ($post_type === 'page' || $post_type === 'town') {
    if (is_admin())
        add_action('admin_enqueue_scripts', 'enqueue_admin_script_for_custom_editor');
    if ($post_type === 'page')
        add_action('admin_enqueue_scripts', 'enqueue_admin_script_for_page');
    if (basename($template) != '')
        add_action('init', 'remove_page_editor', 10);
    if (basename($template) === 'home.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_home', 1);
    if (basename($template) === 'staff.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_staff', 1);
    if (basename($template) === 'board-of-directors.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_board_of_directors', 1);
    if (basename($template) === 'about-us.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_about_us', 1);
    if (basename($template) === 'newsletter.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_newsletter', 1);
    if (basename($template) === 'towns.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_towns', 1);
    if (basename($template) === 'choose-sect.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_choose_sect', 1);
    if (basename($template) === 'real-estate.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_real_estate', 1);
    if (basename($template) === 'industry-clusters.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_industry_clusters', 1);
    if (basename($template) === 'business-resources.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_business_resources', 1);
    if (basename($template) === 'programs.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_programs', 1);
    if (basename($template) === 'single_choose_sect.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_single_choose_sect', 1);
    if (basename($template) === 'contact.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_page_contact', 1);
    if (basename($template) === 'single-industry_clusters.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_industry_clusters', 1);
    if (basename($template) === 'single-business_resources.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_business_resource', 1);
    if (basename($template) === 'single-programs.php')
        add_action('edit_form_after_title', 'secter_extra_editor_for_programs', 1);
    if ($post_type === 'town')
        add_action('edit_form_after_title', 'secter_extra_editor_for_town', 1);
}

if ($post_type === 'featured_properties' || $post_type === 'post')
    add_action('admin_enqueue_scripts', 'enqueue_admin_script_for_post_type');

add_action('save_post', 'update_custom_content');

function update_custom_content($post_id)
{
    if (get_post_type($post_id) === 'page' and get_page_template_slug($post_id) != '') {
        global $wpdb;
        $wpdb->update('wp_posts', array('post_content' => serialize($_POST['array'])), array('ID' => $post_id));
        if ($_POST['sidebar_slug'] != '')
            update_post_meta($post_id, 'sidebar_slug', $_POST['sidebar_slug']);
        else
            delete_post_meta($post_id, 'sidebar_slug');
    }

    if (get_post_type($post_id) === 'town') {
        global $wpdb;
        $wpdb->update('wp_posts', array('post_content' => serialize($_POST['array'])), array('ID' => $post_id));
        if ($_POST['logo_town'] != '')
            update_post_meta($post_id, 'logo_town', $_POST['logo_town']);
        else
            delete_post_meta($post_id, 'logo_town');
        if ($_POST['sidebar_slug'] != '')
            update_post_meta($post_id, 'sidebar_slug', $_POST['sidebar_slug']);
        else
            delete_post_meta($post_id, 'sidebar_slug');
    }

    if (get_post_type($post_id) === 'featured_properties') {
        if ($_POST['link_for_pdf'] != '')
            update_post_meta($post_id, 'link_for_pdf', $_POST['link_for_pdf']);
        else
            delete_post_meta($post_id, 'link_for_pdf');
    }

    if (get_post_type($post_id) === 'post') {
        if ($_POST['sidebar_slug'] != '')
            update_post_meta($post_id, 'sidebar_slug', $_POST['sidebar_slug']);
        else
            delete_post_meta($post_id, 'sidebar_slug');
        if ($_POST['banner_post'] != '')
            update_post_meta($post_id, 'banner_post', $_POST['banner_post']);
        else
            delete_post_meta($post_id, 'banner_post');
    }
}

function secter_enqueue_style()
{
    global $post;
    wp_enqueue_style('bootstrap-for-secter', get_template_directory_uri() . '/assets/css-lib/bootstrap.css', false);
    wp_enqueue_style('custom-style-for-secter', get_template_directory_uri() . '/style.css', false);
    wp_enqueue_style('animate-for-secter', get_template_directory_uri() . '/assets/css-lib/animate.css', false);
    wp_register_script('custom-script-for-secter', get_template_directory_uri() . '/assets/js/custom-script-for-secter.js', array('jquery'), false);
    wp_enqueue_script('custom-script-for-secter');
    if (get_page_template_slug($post->ID) == '')
        wp_enqueue_style('custom-style-page', get_template_directory_uri() . '/assets/css-template/page.css', false);
    if (get_page_template_slug($post->ID) == 'staff.php' || get_page_template_slug($post->ID) == 'board-of-directors.php') {
        wp_enqueue_style('custom-style-staff-board-of-directors', get_template_directory_uri() . '/assets/css-template/staff-board-of-directors.css', false);
    }
    if (get_page_template_slug($post->ID) == 'home.php') {
        wp_register_script('nivo-slider-js-for-secter', get_template_directory_uri() . '/assets/js/nivo.slider.js', array('jquery'), false);
        wp_enqueue_style('custom-style-for-home', get_template_directory_uri() . '/assets/css-template/home.css', false);
        wp_enqueue_style('nivo-slider-css-for-secter', get_template_directory_uri() . '/assets/css-lib/nivo-slider.css', false);
        wp_register_script('custom-scrollbar-for-towns', get_template_directory_uri() . '/assets/js/custom-scrollbar.min.js', array('jquery'), false);
        wp_enqueue_style('custom-scrollbar-towns', get_template_directory_uri() . '/assets/css-lib/custom-scrollbar.min.css', false);
        wp_enqueue_script('custom-scrollbar-for-towns');
        wp_enqueue_script('nivo-slider-js-for-secter');
    }
    if (get_page_template_slug($post->ID) == 'about-us.php') {
        wp_enqueue_style('custom-style-for-about-us', get_template_directory_uri() . '/assets/css-template/about-us.css', false);
    }
    if (get_page_template_slug($post->ID) == 'newsletter.php') {
        wp_enqueue_style('custom-style-for-newsletter', get_template_directory_uri() . '/assets/css-template/newsletter.css', false);
    }
    if (get_page_template_slug($post->ID) == 'towns.php') {
        wp_register_script('custom-scrollbar-for-towns', get_template_directory_uri() . '/assets/js/custom-scrollbar.min.js', array('jquery'), false);
        wp_enqueue_style('custom-style-for-towns', get_template_directory_uri() . '/assets/css-template/towns.css', false);
        wp_enqueue_style('custom-scrollbar-towns', get_template_directory_uri() . '/assets/css-lib/custom-scrollbar.min.css', false);
        wp_enqueue_script('custom-scrollbar-for-towns');
    }
    if (get_page_template_slug($post->ID) == 'choose-sect.php' || get_page_template_slug($post->ID) == 'real-estate.php') {
        if (get_page_template_slug($post->ID) == 'choose-sect.php') {
            wp_register_script('owl-carousel-js-for-secter', get_template_directory_uri() . '/assets/js/owl-carousel.js', array('jquery'), false);
            wp_enqueue_style('owl-carousel-css-for-secter', get_template_directory_uri() . '/assets/css-lib/owl-carousel.css', false);
            wp_enqueue_script('owl-carousel-js-for-secter');
        }
        wp_enqueue_style('custom-style-for-choose-sect-real-estate', get_template_directory_uri() . '/assets/css-template/choose-sect-real-estate.css', false);
    }
    if (get_page_template_slug($post->ID) == 'industry-clusters.php') {
        wp_enqueue_style('custom-style-for-industry-clusters', get_template_directory_uri() . '/assets/css-template/industry-clusters.css', false);
    }
    if (get_page_template_slug($post->ID) == 'business-resources.php') {
        wp_enqueue_style('custom-style-for-business-resources', get_template_directory_uri() . '/assets/css-template/business-resources.css', false);
    }
    if (get_page_template_slug($post->ID) == 'programs.php') {
        wp_enqueue_style('custom-style-for-business-resources', get_template_directory_uri() . '/assets/css-template/programs.css', false);
    }
    if (get_page_template_slug($post->ID) == 'news.php') {
        wp_enqueue_style('custom-style-for-news', get_template_directory_uri() . '/assets/css-template/news.css', false);
        wp_register_script('masonry-js-for-secter', get_template_directory_uri() . '/assets/js/masonry.min.js', array('jquery'), false);
        wp_enqueue_script('masonry-js-for-secter');
    }
    if (get_page_template_slug($post->ID) == 'featured-properties.php') {
        wp_enqueue_style('custom-style-for-featured-properties', get_template_directory_uri() . '/assets/css-template/featured-properties.css', false);
        wp_register_script('masonry-js-for-secter', get_template_directory_uri() . '/assets/js/masonry.min.js', array('jquery'), false);
        wp_enqueue_script('masonry-js-for-secter');
    }
    if (get_page_template_slug($post->ID) == 'search.php') {
        wp_enqueue_style('custom-style-for-search', get_template_directory_uri() . '/assets/css-template/search.css', false);
    }
    if (get_page_template_slug($post->ID) == 'calendar.php') {
        wp_enqueue_style('custom-style-for-calendar', get_template_directory_uri() . '/assets/css-template/calendar.css', false);
        wp_register_script('bootstrap-script-for-calendar', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), false);
        wp_enqueue_script('bootstrap-script-for-calendar');
    }
    if (get_page_template_slug($post->ID) == 'contact.php') {
        wp_enqueue_style('custom-style-for-contact', get_template_directory_uri() . '/assets/css-template/contact.css', false);
    }
    if (get_page_template_slug($post->ID) == 'sitemap.php') {
        wp_enqueue_style('custom-style-for-sitemap', get_template_directory_uri() . '/assets/css-template/sitemap.css', false);
    }
    if (get_post_type($post->ID) == 'town') {
        wp_register_script('custom-scrollbar-for-town', get_template_directory_uri() . '/assets/js/custom-scrollbar.min.js', array('jquery'), false);
        wp_enqueue_style('custom-style-for-town', get_template_directory_uri() . '/assets/css-template/town.css', false);
        wp_enqueue_style('custom-scrollbar-towns', get_template_directory_uri() . '/assets/css-lib/custom-scrollbar.min.css', false);
        wp_enqueue_script('custom-scrollbar-for-town');
    }
    if (get_page_template_slug($post->ID) == 'single-industry_clusters.php') {
        wp_enqueue_style('custom-style-for-industry-cluster', get_template_directory_uri() . '/assets/css-template/industry-cluster.css', false);
    }
    if (get_post_type($post->ID) == 'post') {
        wp_enqueue_style('custom-style-for-post', get_template_directory_uri() . '/assets/css-template/single-news.css', false);
    }
    if (get_page_template_slug($post->ID) == 'single-business_resources.php') {
        wp_enqueue_style('custom-style-for-single-business-resource', get_template_directory_uri() . '/assets/css-template/single-business-resource.css', false);
    }
    if (get_page_template_slug($post->ID) == 'single-programs.php') {
        wp_enqueue_style('custom-style-for-single-business-resource', get_template_directory_uri() . '/assets/css-template/single-programs.css', false);
    }
    if (get_page_template_slug($post->ID) == 'single_choose_sect.php') {
        wp_enqueue_style('custom-style-for-single_choose_sect', get_template_directory_uri() . '/assets/css-template/single_choose_sect.css', false);
    }
}

add_action('wp_enqueue_scripts', 'secter_enqueue_style');

add_theme_support('post-thumbnails', array('page', 'town', 'featured_properties', 'post', 'programs'));

register_nav_menus(array(
    'top_menu' => 'top-menu',
    'header_menu' => 'header-menu',
    'top_footer_menu' => 'top-footer-menu',
    'bottom_footer_menu' => 'bottom-footer-menu'
));


add_action('widgets_init', 'register_my_widgets');
function register_my_widgets()
{
    register_sidebar(array(
        'name' => 'News sidebar',
        'id' => 'news-sidebar',
        'description' => '',
        'class' => '',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));
    register_sidebar(array(
        'name' => 'Left footer sidebar',
        'id' => 'left-footer-sidebar',
        'description' => '',
        'class' => '',
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => ""
    ));
    register_sidebar(array(
        'name' => 'Center footer sidebar',
        'id' => 'center-footer-sidebar',
        'description' => '',
        'class' => '',
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => ""
    ));
    register_sidebar(array(
        'name' => 'Right footer sidebar',
        'id' => 'right-footer-sidebar',
        'description' => '',
        'class' => '',
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => ""
    ));
}


function new_wp_nav_menu_top()
{
    if (!is_user_logged_in())
        $wrap = '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item user-register user-item-menu"><a href="#">Register</a></li><li class="menu-item user-login user-item-menu"><a href="#">Login</a></li><li class="menu-item facebook-link"><a target="_blank" href="' . get_option('link_for_facebook') . '"></a></li></ul>';
    else
        $wrap = '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item user-logout user-item-menu"><a href="/wp-login.php?action=logout&_wpnonce=' . wp_create_nonce('log-out') . '&redirect_to=' . get_permalink() . '">Log out</a></li><li class="menu-item facebook-link"><a target="_blank" href="' . get_option('link_for_facebook') . '"></a></li></ul>';
    return $wrap;
}

function new_wp_nav_menu_header()
{
    $wrap = '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item search-button-menu-element"><a href="#"></a><form id="search-field-header-menu" class="animated bounceInLeft" method="get" action="/search-result/"><div class="search-field"><input type="text" placeholder="Start Exploring" class="search-word" autocomplete="off" name="search-word"></div><input type="submit" class="submit" value=""><div class="clearfix"></div></form></li></ul>';
    return $wrap;
}

function new_wp_nav_menu_footer_top()
{
    //if (!is_user_logged_in())
    //    $wrap = '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item user-login user-item-menu"><a href="#">Login</a></li><li class="menu-item facebook-link"><a target="_blank" href="' . get_option('link_for_facebook') . '">Follow Us</a></li></ul>';
    //else
    $wrap = '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item facebook-link"><a target="_blank" href="' . get_option('link_for_facebook') . '">Follow Us</a></li></ul>';
    /*<li class="menu-item user-logout user-item-menu"><a href="/wp-login.php?action=logout&redirect_to=' . get_permalink() . '">Log out</a></li>*/
    return $wrap;
}

function add_option_field_to_general_admin_page()
{
    register_setting('general', 'link_for_facebook');

    add_settings_field(
        'facebook_link-id',
        'Add link to Facebook',
        'link_for_facebook',
        'general',
        'default',
        array(
            'id' => 'link_for_facebook',
            'option_name' => 'link_for_facebook'
        )
    );
}

add_action('admin_menu', 'add_option_field_to_general_admin_page');

function link_for_facebook($val)
{ ?>
    <input style='width: 300px;' type="text" name="<?php echo $val['option_name']; ?>"
           id="<?php echo $val['id']; ?>"
           value="<?php echo get_option('link_for_facebook'); ?>"/>
<?php }

add_action('admin_menu', 'add_option_field_to_category_page');

function add_option_field_to_category_page()
{
    wp_register_script('admin-script-for-post-type', get_template_directory_uri() . '/assets/js/admin-script-for-post-type.js', array('jquery'), false, false);
    wp_enqueue_script('admin-script-for-post-type');
    register_setting('general', 'link_for_background_category');
    add_settings_field(
        'category_background_link-id',
        'Link to background for all category',
        'category_background_link',
        'general',
        'default',
        array(
            'id' => 'link_for_background_category',
            'option_name' => 'link_for_background_category'
        )
    );
}

add_action('admin_menu', 'add_option_field_to_general_admin_page');

function category_background_link($val)
{ ?>
    <div class="block-uploader">
        <div class="progress_file_upload">
            <progress></progress>
            <span>Uploading ...</span></div>
        <input style='width: 300px;' class="link-image" type="text" placeholder="Link for background"
               name="<?php echo $val['option_name']; ?>"
               value="<?php echo get_option('link_for_background_category'); ?>">
        <div class="image-uploader-block"><img src="<?php echo get_option('link_for_background_category'); ?>"
                                               class="image-uploader"></div>
        <input class="file_upload" type="file" accept="image/jpeg,image/png">
        <div class="clear"></div>
    </div>
<?php }

add_action('init', 'create_page_taxonomies', 0);

function create_page_taxonomies()
{
    register_taxonomy('page-tag', 'page', array(
        'hierarchical' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'page-tag'),
    ));
}

add_action('init', 'register_town_post_type');

function register_town_post_type()
{

    register_post_type('town', array(
        'label' => 'Towns',
        'labels' => array(
            'name' => 'Towns',
            'singular_name' => 'Town',
            'menu_name' => 'Towns',
            'all_items' => 'All Towns',
            'add_new' => 'Add Town',
            'add_new_item' => 'Add New Town',
            'edit' => 'Edit Town',
            'edit_item' => 'Edit Town',
            'new_item' => 'New Towm',
        ),
        'menu_icon' => 'dashicons-admin-multisite',
        'description' => '',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => false,
        'rest_base' => '',
        'show_in_menu' => true,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'has_archive' => true,
        'query_var' => true,
        'supports' => array('title', 'thumbnail')
    ));
}

add_action('init', 'register_featured_properties_post_type');

function register_featured_properties_post_type()
{

    register_post_type('featured_properties', array(
        'label' => 'Featured Properties',
        'labels' => array(
            'name' => 'Featured Properties',
            'singular_name' => 'Featured Property',
            'menu_name' => 'Featured Properties',
            'all_items' => 'All Featured Properties',
            'add_new' => 'Add Featured Property',
            'add_new_item' => 'Add New Featured Property',
            'edit' => 'Edit Featured Property',
            'edit_item' => 'Edit Featured Property',
            'new_item' => 'New Featured Property',
        ),
        'description' => '',
        'menu_icon' => 'dashicons-clipboard',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => false,
        'rest_base' => '',
        'show_in_menu' => true,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'has_archive' => false,
        'query_var' => true,
        'supports' => array('title', 'thumbnail', 'editor')
    ));
}

add_action('wp_ajax_file_upload', 'file_upload');

function file_upload()
{
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    $attachment_id = media_handle_upload('file_upload', 0);
    if (is_wp_error($attachment_id)) {
        echo json_encode(array('response' => false));
    } else {
        echo json_encode(array('response' => get_post($attachment_id)->guid));
    }
    wp_die();
}

add_action('wp_ajax_add_new_editor', 'add_new_editor');

function add_new_editor()
{
    $editor_id = $_POST['id'];
    $selector = $_POST['selector'];
    switch ($selector) {
        case 'slider':
            echo '<li class="item secter-slider-item-editor-home ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[slides][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            echo '</li>';
            break;
        case 'right-expertise':
            $argument = array(
                'textarea_name' => 'array[text-right-expertise][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-right-expertise');
            echo '<li class="item secter-right-expertise-item-editor-home ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-right-expertise" type="text" placeholder="title" name="array[title-right-expertise][]">';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-right-expertise" type="text" placeholder="link" name="array[link-right-expertise][]">';
            echo '</li>';
            break;
        case 'comprehensive-information':
            $argument = array(
                'textarea_name' => 'array[text-comprehensive-information][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-comprehensive-information');
            echo '<li class="item secter-comprehensive-information-item-editor-home ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-comprehensive-information" type="text" placeholder="title" name="array[title-comprehensive-information][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-comprehensive-information][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-comprehensive-information" type="text" placeholder="link" name="array[link-comprehensive-information][]">';
            echo '</li>';
            break;
        case 'staff':
            $argument = array(
                'textarea_name' => 'array[text-staff][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-staff');
            echo '<li class="item secter-staff-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-staff" type="text" placeholder="title" name="array[title-staff][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-staff][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="email-staff" type="text" placeholder="Email" name="array[email-staff][]">';
            echo '<input class="phone-staff" type="text" placeholder="Phone" name="array[phone-staff][]">';
            echo '</li>';
            break;
        case 'board-of-directors':
            $argument = array(
                'textarea_name' => 'array[text-board-of-directors][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-board-of-directors');
            echo '<li class="item secter-board-of-directors-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-board-of-directors" type="text" placeholder="title" name="array[title-board-of-directors][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-board-of-directors][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '</li>';
            break;
        case 'business-resource':
            $argument = array(
                'textarea_name' => 'array[text-business-resource][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-business-resource');
            echo '<li class="item secter-business-resource-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-business-resource" type="text" placeholder="title" name="array[title-business-resource][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-business-resource][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '</li>';
            break;
        case 'programs':
            $argument = array(
                'textarea_name' => 'array[text-programs][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-programs');
            echo '<li class="item secter-programs-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-programs" type="text" placeholder="title" name="array[title-programs][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-programs][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '</li>';
            break;
        case 'about-us':
            $argument = array(
                'textarea_name' => 'array[text-about-us][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-about-us');
            echo '<li class="item secter-about-us-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-about-us" type="text" placeholder="title" name="array[title-about-us][]">';
            wp_editor('', $editor_id, $argument);
            echo '</li>';
            break;
        case 'newsletter':
            echo '<li class="item secter-newsletter-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-link-newsletter" type="text" placeholder="title" name="array[title-link-newsletter][]">';
            echo '<input class="link-newsletter" type="text" placeholder="link" name="array[link-newsletter][]">';
            echo '<div class="checkbox-block-editor-secter">';
            echo '<input type="hidden" name="array[nofollow-newsletter][]" value="0">';
            echo '<label>Nofollow? </label>';
            echo '<input class="nofollow-newsletter" type="checkbox">';
            echo '</div>';
            echo '</li>';
            break;
        case 'towns':
            $argument = array(
                'textarea_name' => 'array[text-towns][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-towns');
            echo '<li class="item secter-towns-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-towns" type="text" placeholder="title" name="array[title-towns][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-towns][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-towns" type="text" placeholder="Title for Link" name="array[title-link-towns][]">';
            echo '<input class="link-towns" type="text" placeholder="Link" name="array[link-towns][]">';
            echo '<input class="website-towns" type="text" placeholder="Title for Website" name="array[website-title-towns][]">';
            echo '<input class="website-towns" type="text" placeholder="Website" name="array[website-towns][]">';
            echo '</li>';
            break;
        case 'town':
            $argument = array(
                'textarea_name' => 'array[text-town][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-town');
            echo '<li class="item secter-town-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-town" type="text" placeholder="title" name="array[title-town][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for background" name="array[link-image-town][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-town" type="text" placeholder="Link" name="array[title-link-town][]">';
            echo '<input class="link-town" type="text" placeholder="Link" name="array[link-town][]">';
            echo '<input class="website-town" type="text" placeholder="Website" name="array[website-title-town][]">';
            echo '<input class="website-town" type="text" placeholder="Website" name="array[website-town][]">';
            echo '</li>';
            break;
        case 'featured-properties':
            $featured_properties = new WP_Query(array('post_type' => 'featured_properties', 'posts_per_page' => -1));
            if ($featured_properties->have_posts()) {
                echo '<li class="item secter-featured-properties-item-editor ui-state-default">';
                echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
                echo '<select name="array[id-featured-properties][]">';
                foreach ($featured_properties->posts as $post)
                    echo '<option value=' . $post->ID . '>' . $post->post_title . '</option>';
                echo '</select>';
                echo '</li>';
            }
            break;
        case 'special-landing-slider':
            $argument = array(
                'textarea_name' => 'array[text-special-landing-slider][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-special-landing-slider');
            echo '<li class="item secter-special-landing-slider-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            wp_editor('', $editor_id, $argument);
            echo '</li>';
            break;
        case 'special-landing-article':
            $argument = array(
                'textarea_name' => 'array[text-special-landing-article][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-special-landing-article');
            echo '<li class="item secter-text-special-landing-article-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-special-landing-article" type="text" placeholder="Title artickle" name="array[title-special-landing-article][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-article][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-special-landing-article" type="text" placeholder="Link" name="array[link-special-landing-article][]">';
            echo '</li>';
            break;
        case 'industry-clusters-article':
            $argument = array(
                'textarea_name' => 'array[text-industry-clusters-article][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-industry-clusters-article');
            echo '<li class="item secter-text-industry-clusters-article-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-industry-clusters-article" type="text" placeholder="Title artickle" name="array[title-industry-clusters-article][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-industry-clusters-article][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-industry-clusters-article" type="text" placeholder="Link" name="array[link-industry-clusters-article][]">';
            echo '</li>';
            break;
        case 'business-resources-article':
            $argument = array(
                'textarea_name' => 'array[text-business-resources-article][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-business-resources-article');
            echo '<li class="item secter-text-business-resources-article-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-business-resources-article" type="text" placeholder="Title artickle" name="array[title-business-resources-article][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-business-resources-article][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-business-resources-article" type="text" placeholder="Link" name="array[link-business-resources-article][]">';
            echo '</li>';
            break;
        case 'programs-article':
            $argument = array(
                'textarea_name' => 'array[text-programs-article][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-programs-article');
            echo '<li class="item secter-text-programs-article-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-programs-article" type="text" placeholder="Title artickle" name="array[title-programs-article][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-programs-article][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-programs-article" type="text" placeholder="Link" name="array[link-programs-article][]">';
            echo '</li>';
            break;
        case 'single_choose_sect-article':
            $argument = array(
                'textarea_name' => 'array[text-single_choose_sect-article][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-single_choose_sect-article');
            echo '<li class="item secter-text-single_choose_sect-article-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<input class="title-single_choose_sect-article" type="text" placeholder="Title artickle" name="array[title-single_choose_sect-article][]">';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-single_choose_sect-article][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '<input class="link-single_choose_sect-article" type="text" placeholder="Link" name="array[link-single_choose_sect-article][]">';
            echo '</li>';
            break;
        case 'industry-clusters-data':
            $argument = array(
                'textarea_name' => 'array[text-industry-clusters-data][]',
                'quicktags' => 0,
                'drag_drop_upload' => false,
                'editor_class' => 'text-industry-clusters-data');
            echo '<li class="item secter-text-industry-clusters-data-item-editor ui-state-default">';
            echo '<div class="delete-item-button"><input type="button" class="delete-item" value="delete"></div>';
            echo '<div class="block-uploader">';
            echo '<div class="progress_file_upload"><progress></progress><span>Uploading ...</span></div>';
            echo '<input class="link-image" type="text" placeholder="Link for image" name="array[link-image-industry-clusters-data][]">';
            echo '<div class="image-uploader-block"><img src="#" class="image-uploader"></div>';
            echo '<input class="file_upload" type="file" accept="image/jpeg,image/png"><div class="clear"></div>';
            echo '</div>';
            wp_editor('', $editor_id, $argument);
            echo '</li>';
            break;
        default:
            break;
    }
    wp_die();
}

add_action('add_meta_boxes', 'secter_extra_fields', 1);

function secter_extra_fields()
{
    global $post;
    $template = get_page_template_slug($post->ID);
    add_meta_box('extra_fields_for_featured_properties', 'Extra', 'extra_fields_box_func_for_featured_properties', 'featured_properties', 'normal', 'high');
    add_meta_box('extra_fields_for_town', 'Extra', 'extra_fields_box_func_for_town', 'town', 'normal', 'high');
    add_meta_box('extra_fields_for_programs', 'Extra', 'extra_fields_box_func_for_programs', 'programs', 'normal', 'high');
    if ($template != 'home.php' &&
        $template != 'choose-sect.php' &&
        $template != 'real-estate.php' &&
        $template != 'industry-clusters.php' &&
        $template != 'search.php' &&
        $template != '' &&
        $template != 'calendar.php' &&
        $template != 'contact.php' &&
        $template != 'sitemap.php' &&
        $template != 'business-resources.php' &&
        $template != 'news.php' &&
        $template != 'programs.php'
    ) {
        add_meta_box('extra_fields_for_page', 'Extra', 'extra_fields_box_func_for_page', 'page', 'normal', 'high');
    }
}

function extra_fields_box_func_for_featured_properties($post)
{
    $link = get_post_meta($post->ID, 'link_for_pdf', 1);
    ?>
    <div class="block-uploader">
        <div class="progress_file_upload">
            <progress></progress>
            <span>Uploading ...</span></div>
        <input class="link-image" type="text" placeholder="Link for PDF" name="link_for_pdf"
               value="<?php echo $link; ?>">
        <input class="file_upload" type="file" accept="application/pdf">
        <div class="clear"></div>
    </div>
<?php }

function extra_fields_box_func_for_town($post)
{
    $link = get_post_meta($post->ID, 'logo_town', 1);
    ?>
    <p>Add link for image</p>
    <div class="block-uploader">
        <div class="progress_file_upload">
            <progress></progress>
            <span>Uploading ...</span></div>
        <input class="link-image" type="text" placeholder="Link for background" name="logo_town"
               value="<?php echo $link; ?>">
        <div class="image-uploader-block"><img src="<?php echo $link; ?>" class="image-uploader"></div>
        <input class="file_upload" type="file" accept="image/jpeg,image/png">
        <div class="clear"></div>
    </div>
    <p>Choose sidebar</p>
    <?php
    global $wpdb;
    $slug = get_post_meta($post->ID, 'sidebar_slug', 1);
    $res = $wpdb->get_results("SELECT slug, name FROM wp_terms WHERE term_id IN (SELECT term_id FROM wp_term_taxonomy WHERE taxonomy='nav_menu')");
    echo '<select name="sidebar_slug">';
    echo '<option value=""></option>';
    foreach ($res as $sidebar) {
        if ($sidebar->slug == $slug)
            echo '<option value="' . $sidebar->slug . '" selected="selected">' . $sidebar->name . '</option>';
        else
            echo '<option value="' . $sidebar->slug . '">' . $sidebar->name . '</option>';
    }
    echo '</select>';
}

function extra_fields_box_func_for_programs($post)
{
    $link = get_post_meta($post->ID, 'logo_programs', 1);
    ?>
    <p>Add link for image</p>
    <div class="block-uploader">
        <div class="progress_file_upload">
            <progress></progress>
            <span>Uploading ...</span></div>
        <input class="link-image" type="text" placeholder="Link for background" name="logo_programs"
               value="<?php echo $link; ?>">
        <div class="image-uploader-block"><img src="<?php echo $link; ?>" class="image-uploader"></div>
        <input class="file_upload" type="file" accept="image/jpeg,image/png">
        <div class="clear"></div>
    </div>
    <p>Choose sidebar</p>
    <?php
    global $wpdb;
    $slug = get_post_meta($post->ID, 'sidebar_slug', 1);
    $res = $wpdb->get_results("SELECT slug, name FROM wp_terms WHERE term_id IN (SELECT term_id FROM wp_term_taxonomy WHERE taxonomy='nav_menu')");
    echo '<select name="sidebar_slug">';
    echo '<option value=""></option>';
    foreach ($res as $sidebar) {
        if ($sidebar->slug == $slug)
            echo '<option value="' . $sidebar->slug . '" selected="selected">' . $sidebar->name . '</option>';
        else
            echo '<option value="' . $sidebar->slug . '">' . $sidebar->name . '</option>';
    }
    echo '</select>';
}

function extra_fields_box_func_for_page($post)
{
    echo '<p>Choose sidebar</p>';
    global $wpdb;
    $slug = get_post_meta($post->ID, 'sidebar_slug', 1);
    $res = $wpdb->get_results("SELECT slug, name FROM wp_terms WHERE term_id IN (SELECT term_id FROM wp_term_taxonomy WHERE taxonomy='nav_menu')");
    echo '<select name="sidebar_slug">';
    echo '<option value=""></option>';
    foreach ($res as $sidebar) {
        if ($sidebar->slug == $slug)
            echo '<option value="' . $sidebar->slug . '" selected="selected">' . $sidebar->name . '</option>';
        else
            echo '<option value="' . $sidebar->slug . '">' . $sidebar->name . '</option>';
    }
    echo '</select>';
}

add_action('create_page-tag', 'save_extra_category_fields_for_homepage');
add_action('edited_page-tag', 'save_extra_category_fields_for_homepage');

function save_extra_category_fields_for_homepage($term_id)
{
    if (isset($_POST['search']))
        update_term_meta($term_id, 'search', $_POST['search']);
    else
        delete_term_meta($term_id, 'search');
}

add_action('page-tag_edit_form_fields', 'extra_category_fields_for_homepage');
add_action('page-tag_add_form_fields', 'extra_category_fields_for_homepage');
function extra_category_fields_for_homepage($term)
{
    $search = get_term_meta($term->term_id, 'search', true); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label>Choose this tag for search on homepage</label></th>
        <td>
            <input type="checkbox" value="1" name="search" <?php checked($search, '1'); ?>>
        </td>
    </tr>
<?php }

add_action('wp_ajax_nopriv_login-user', 'login_user');

function login_user()
{
    if (is_user_logged_in()) wp_send_json_error(array('message' => 'You are already logged in'));
    $params = array();
    parse_str($_POST['data'], $params);
    $nonce = isset($params['nonce-login']) ? $params['nonce-login'] : '';
    if (!wp_verify_nonce($nonce, 'login_me_nonce')) wp_send_json_error(array('message' => 'Data sent from the side of the page'));
    $creds = array(
        'user_login' => (isset($params['log']) ? $params['log'] : false),
        'user_password' => (isset($params['pwd']) ? $params['pwd'] : false),
        'remember' => (isset($params['rememberme']) ? $params['rememberme'] : false)
    );
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) wp_send_json_error(array('message' => 'Wrong username/email or password'));
    else wp_send_json_success(array('message' => 'Hello ' . $user->display_name . '. Loading ...', 'reload' => $params['reload']));
}

add_action('wp_ajax_nopriv_register-user', 'register_user');

function register_user()
{
    if (is_user_logged_in()) wp_send_json_error(array('message' => 'You are already logged in'));
    $params = array();
    parse_str($_POST['data'], $params);
    $nonce = isset($params['nonce-register']) ? $params['nonce-register'] : '';
    if (!wp_verify_nonce($nonce, 'register_me_nonce')) wp_send_json_error(array('message' => 'Data sent from the side of the page'));
    if (empty($params['log'])) wp_send_json_error(array('message' => 'Username is empty'));
    if (username_exists($params['log'])) wp_send_json_error(array('message' => 'Username In Use'));
    if (empty($params['email'])) wp_send_json_error(array('message' => 'E-mail is empty'));
    if (!is_email($params['email'])) wp_send_json_error(array('message' => 'E-mail is not valid'));
    if (email_exists($params['email'])) wp_send_json_error(array('message' => 'That E-mail is registered to user'));
    if ($params['pwd'] != $params['conf-pwd']) wp_send_json_error(array('message' => 'Passwords do not match'));
    if (strlen($params['pwd']) < 6) wp_send_json_error(array('message' => 'the password is weak, and at least 6 characters'));
    $userdata = array(
        'user_login' => $params['log'],
        'user_pass' => $params['pwd'],
        'user_email' => $params['email'],
        'show_admin_bar_front' => 'false'
    );
    $user_id = wp_insert_user($userdata);
    if (is_wp_error($user_id)) wp_send_json_error(array('message' => 'Sorry, something went wrong: Please try again later'));
    else wp_send_json_success(array('message' => 'Hello ' . $params['log'] . ' =)'));
}

add_action('wp_ajax_nopriv_forgot-user', 'forgot_user');

function forgot_user()
{
    if (is_user_logged_in()) wp_send_json_error(array('message' => 'You are already logged in'));
    $params = array();
    parse_str($_POST['data'], $params);
    $nonce = isset($params['nonce-forget']) ? $params['nonce-forget'] : '';
    if (!wp_verify_nonce($nonce, 'forget_me_nonce')) wp_send_json_error(array('message' => 'Data sent from the side of the page'));
    if (empty($params['email'])) wp_send_json_error(array('message' => 'E-mail is empty'));
    if (!is_email($params['email'])) wp_send_json_error(array('message' => 'E-mail is not valid'));
    if (!email_exists($params['email'])) wp_send_json_error(array('message' => 'E-mail is not exists'));
    $user_id = get_user_by('email', $params['email']);
    if (!$user_id) wp_send_json_error(array('message' => 'Sorry, something went wrong: Please try again later'));
    else {
        $password = wp_generate_password(12);
        wp_set_password($password, (int)$user_id);
        $subject = 'Your new password';
        $sender = get_option('name');
        $message = 'Your new password is: ' . $password;
        $headers[] = 'MIME-Version: 1.0' . "\r\n";
        $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers[] = "X-Mailer: PHP \r\n";
        $headers[] = 'From: ' . $sender . ' < ' . $params['email'] . '>' . "\r\n";
        if (!wp_mail($params['email'], $subject, $message, $headers))
            wp_send_json_error(array('message' => 'Sorry, something went wrong: Please try again later'));
        else
            wp_send_json_success(array('message' => 'Please check your email'));
    }
}

add_action('init', 'blockusers_init');
function blockusers_init()
{
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url());
        exit;
    }
}

add_action('admin_menu', 'register_secter_custom_menu_page');

function register_secter_custom_menu_page()
{
    add_menu_page('Map', 'Map', 'manage_options', 'map', 'secter_map_plugin', 'dashicons-id', 6);
}


function secter_map_plugin()
{
    wp_enqueue_media();
    wp_enqueue_script('admin-custom-script-for-map', get_template_directory_uri() . '/assets/js/admin-script-for-map.js', array('jquery', 'jquery-ui-draggable', 'jquery-ui-tabs'), false, false);
    wp_enqueue_style('admin-custom-style-for-map', get_template_directory_uri() . '/assets/css-lib/admin-style-for-map.css');
    get_template_part('map/map');
}