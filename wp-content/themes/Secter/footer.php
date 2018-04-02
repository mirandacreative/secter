<footer>
    <div class="special-footer-block">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="events-list">
                            <?php global $wpdb; ?>
                            <?php $results = $wpdb->get_results('SELECT * FROM `wp_spidercalendar_event` ORDER BY id DESC LIMIT 3') ?>
                            <h2>Events</h2>
                            <?php foreach ($results as $result): ?>
                                <div class="item">
                                    <div class="date-event">
                                        <span class="month"><?php echo date("M", strtotime($result->date)); ?></span>
                                        <span class="day"><?php echo date("j", strtotime($result->date)); ?></span>
                                    </div>
                                    <a href="#" data-time="<?php echo $result->time; ?>"
                                       data-content="<?php echo $result->text_for_date; ?>"
                                       class="link"><?php echo $result->title; ?></a>
                                </div>
                            <?php endforeach; ?>
                            <div class="black-layer"></div>
                            <div class="content-layer">
                                <span class="time"></span>
                                <span class="close-all-layers"></span>
                                <div class="clearfix"></div>
                                <h2 class="title"></h2>
                                <div class="content"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="row">
                        <div class="facebook-footer-widget">
                            <div class="fb-page" data-href="https://www.facebook.com/secternlc" data-tabs="timeline"
                                 data-width="280"
                                 data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
                                 data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/secternlc" class="fb-xfbml-parse-ignore"><a
                                        href="https://www.facebook.com/secternlc">Southeastern CT Enterprise Region</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row">
                        <form id="newsletter-form" method="post">
                            <h2>Newsletter</h2>
                            <div class="form">
                                <span class="name">Full name</span>
                                <input class="field" type="text" name="name" required/>
                            </div>
                            <div class="form">
                                <span class="email">Your Email</span>
                                <input class="field" type="email" name="email" required/>
                            </div>
                            <input type="submit" class="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="top-footer-menu">
        <div class="container">
            <div class="row">
                <?php wp_nav_menu(array(
                    'theme_location' => 'top_footer_menu',
                    'container' => 'nav',
                    'container_class' => 'secter-navbar',
                    'container_id' => 'top-footer-menu',
                    'items_wrap' => new_wp_nav_menu_footer_top()
                )); ?>
            </div>
        </div>
    </div>
    <div class="body-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="row">
                        <div class="logo-footer">
                            <?php dynamic_sidebar('left-footer-sidebar'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="center-block-body-footer">
                            <?php dynamic_sidebar('center-footer-sidebar'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="right-block-body-footer">
                            <?php dynamic_sidebar('right-footer-sidebar'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer-menu">
        <div class="container">
            <div class="row">
                <?php wp_nav_menu(array(
                    'theme_location' => 'bottom_footer_menu',
                    'container' => 'nav',
                    'container_class' => 'secter-navbar',
                    'container_id' => 'bottom-footer-menu',
                    'items_wrap' => new_wp_nav_menu_footer_top()
                )); ?>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
    <a href="#" id='to-top' class="arrow-up">
        <span></span>
    </a>
</footer>
</div>
</body>
</html>
