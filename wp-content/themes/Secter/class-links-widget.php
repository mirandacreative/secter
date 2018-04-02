<?php class custom_links extends WP_Widget
{
    function __construct()
    {
        parent::__construct('links', 'Links', array('description' => "Add or remove links widget, that you want to show"));
    }

    public function widget($args, $instance)
    {
        $title = $instance['title'];
        $links = unserialize($instance['links']);
        $nofollow = unserialize($instance['nofollow']);
        $title_link = unserialize($instance['title-links']);
        $target = unserialize($instance['target']);
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
        echo '<ul>';
        foreach ($links as $key => $link) {
            echo '<li><a href="' . $link . '" rel="' . $nofollow[$key] . '" target="' . $target[$key] . '">' . $title_link[$key] . '</a></li>';
        }
        echo '</ul>' . $args['after_widget'];
    }

    public function form($instance)
    {
        wp_enqueue_script('admin-custom-links-widget', get_template_directory_uri() . '/assets/js/admin-custom-links-widget.js', array('jquery')); ?>
        <style>
            .custom-widget-links label {
                width: 100%;
                display: block;
            }

            .custom-widget-links p {
                clear: both;
            }

            .custom-widget-links .item-element {
                padding: 10px 0;
                clear: both;
            }

            .custom-widget-links span {
                float: left;
                width: 50px;
                clear: both;
            }

            .custom-widget-links p select,
            .custom-widget-links p input {
                width: calc(100% - 50px);
                float: left;
            }
        </style>
        <div class="custom-widget-links">
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text"
                   value="<?php echo $instance['title']; ?>">
            <label><?php echo 'Custom links'; ?></label>
            <?php $links = unserialize($instance['links']); ?>
            <?php $nofollow = unserialize($instance['nofollow']); ?>
            <?php $title_link = unserialize($instance['title-links']); ?>
            <?php $target = unserialize($instance['target']); ?>
            <div class="item-element">
                <p><span>Link</span><input class="widefat"
                                           name="<?php echo $this->get_field_name('links[]'); ?>"
                                           type="text"
                                           value="<?php echo $links[0]; ?>"></p>
                <p><span>rel</span><select name="<?php echo $this->get_field_name('nofollow[]'); ?>">
                        <option value=""></option>
                        <option <?php selected($nofollow[0], 'nofollow') ?> value="nofollow">nofollow</option>
                    </select></p>
                <p><span>target</span><select name="<?php echo $this->get_field_name('target[]'); ?>">
                        <option <?php selected($target[0], '_blank') ?> value="_blank">_blank</option>
                        <option <?php selected($target[0], '_self') ?> value="_self">_self</option>
                        <option <?php selected($target[0], '_parent') ?> value="_parent">_parent</option>
                        <option <?php selected($target[0], '_top') ?> value="_top">_top</option>
                    </select></p>
                <p><span>Title link</span><input class="widefat"
                                                 name="<?php echo $this->get_field_name('title-links[]'); ?>"
                                                 type="text"
                                                 value="<?php echo $title_link[0]; ?>"></p>
            </div>
            <input type="hidden" class="hidden-input-links"
                   value="<input class='widefat' name='<?php echo $this->get_field_name('links[]'); ?>' type='text'>"/>
            <input type="hidden" class="hidden-input-select"
                   value="<select name='<?php echo $this->get_field_name('nofollow[]'); ?>'><option value=''></option><option value='nofollow'>nofollow</option></select>"/>
            <input type="hidden" class="hidden-input-title"
                   value="<input class='widefat' name='<?php echo $this->get_field_name('title-links[]'); ?>' type='text'>"/>
            <input type="hidden" class="hidden-input-target"
                   value='<select name="<?php echo $this->get_field_name('target[]'); ?>"><option value="_blank">_blank</option><option value="_self">_self</option><option value="_parent">_parent</option><option value="_top">_top</option></select>'/>
            <?php foreach ($links as $key => $link): ?>
                <?php if ($key != 0): ?>
                    <div class="item-element">
                        <p><span>Link</span><input class="widefat"
                                                   name="<?php echo $this->get_field_name('links[]'); ?>"
                                                   type="text"
                                                   value="<?php echo $link; ?>"></p>
                        <p><span>rel</span><select name="<?php echo $this->get_field_name('nofollow[]'); ?>">
                                <option value=""></option>
                                <option <?php selected($nofollow[$key], 'nofollow') ?> value="nofollow">nofollow
                                </option>
                            </select></p>
                        <p><span>target</span><select name="<?php echo $this->get_field_name('target[]'); ?>">
                                <option <?php selected($target[$key], '_blank') ?> value="_blank">_blank</option>
                                <option <?php selected($target[$key], '_self') ?> value="_self">_self</option>
                                <option <?php selected($target[$key], '_parent') ?> value="_parent">_parent</option>
                                <option <?php selected($target[$key], '_top') ?> value="_top">_top</option>
                            </select></p>
                        <p><span>Title link</span><input class="widefat"
                                                         name="<?php echo $this->get_field_name('title-links[]'); ?>"
                                                         type="text"
                                                         value="<?php echo $title_link[$key]; ?>"></p>
                        <button type="button" class="delete-link">Delete</button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="button" class="add-link">Add link</button>
        </div>
    <?php }

    public function update($new_instance)
    {
        $instance['title'] = $new_instance['title'];
        $instance['links'] = serialize($new_instance['links']);
        $instance['nofollow'] = serialize($new_instance['nofollow']);
        $instance['title-links'] = serialize($new_instance['title-links']);
        $instance['target'] = serialize($new_instance['target']);
        return $instance;
    }
}

function register_secter_custom_links_widget()
{
    register_widget('custom_links');
}

add_action('widgets_init', 'register_secter_custom_links_widget'); ?>