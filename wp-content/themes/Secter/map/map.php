<?php
if (isset($_POST['publish'])) {
    unset($_POST['publish']);
    if (update_option('map-for-secter', serialize($_POST)))
        echo '<p style="margin:10px; font-size:24px; color: lawngreen;">The changes have been saved</p>';
}
$data = get_option('map-for-secter');
$data = unserialize($data); ?>
<form class="city_editor" method="POST">
    <input type="submit" name="publish" id="publish" class="button button-primary button-large"
           value="Save">
    <div class="city_background">
        <a href="#" id="insert-my-media" class="button">Set background</a>
        <input type="hidden" name="background-img" id="background-img" value="<?php echo $data['background-img']; ?>">
        <input type="hidden" name="background-origin-height" id="background-origin-height"
               value="<?php echo $data['background-origin-height']; ?>">
        <input type="hidden" name="background-img-width-to-height" id="background-img-width-to-height"
               value="<?php echo $data['background-img-width-to-height']; ?>">
    </div>
    <div class="city_editors clear">
        <ul class="list-citys">
            <?php foreach ($data['title-city'] as $key => $value): ?>
                <li class="city_seting">
                    <span class="delete_item_seting"></span>
                    <div>
                        <span class="title_param">Title:</span>
                        <span class="value_param">
                        <input type="text" value="<?php echo $data['title-city'][$key]; ?>" class="change_value_city"
                               name="title-city[]">
                    </span>
                    </div>
                    <div>
                        <span class="title_param">Link:</span>
                        <span class="value_param">
                        <input type="text" value="<?php echo $data['link-city'][$key]; ?>" class="change_value_city"
                               name="link-city[]">
                    </span>
                    </div>
                    <div>
                        <input type="hidden" value="<?php echo $data['top_in_proc'][$key]; ?>" class="change_value_city"
                               name="top_in_proc[]"/>
                        <input type="hidden" value="<?php echo $data['left_in_proc'][$key]; ?>"
                               class="change_value_city"
                               name="left_in_proc[]"/>
                        <input type="hidden" value="<?php echo $data['top'][$key]; ?>" class="change_value_city"
                               name="top[]"/>
                        <input type="hidden" value="<?php echo $data['left'][$key]; ?>" class="change_value_city"
                               name="left[]"/>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="button_add_menu">
            <div class="add_new_item">
                <input type="button" id="add_new_item" class="button" value="Add city">
            </div>
        </div>
        <div id="tabs">
            <div class="container_block-1-with-padding">
                <div class="container_for_position container_block-1 clear"
                     style="height: <?php echo(1170 / $data['background-img-width-to-height']); ?>px; background: url('<?php echo $data['background-img']; ?>') center center / cover no-repeat;">
                    <?php foreach ($data['title-city'] as $key => $value): ?>
                        <a href="#" class="item-city"
                           style="left: <?php echo $data['left'][$key]; ?>px; top: <?php echo $data['top'][$key]; ?>px; position: absolute; width: auto; height: auto;"><?php echo(empty($value) ? 'Enter title' : $value); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</form>