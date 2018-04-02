<?php /* Template Name: Calendar */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <div class="banner">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
            <div class="relative-block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-8 col-md-4">
                            <div class="row">
                                <h1 class="title"><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div id="tabs-calendar">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#first" aria-controls="first" role="tab" data-toggle="tab"
                                   aria-expanded="true">Events calendar<span class="arrow-open-close"></span></a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#second" aria-controls="second" role="tab" data-toggle="tab"
                                   aria-expanded="false">Core calendar<span class="arrow-open-close"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="first">
                                <?php echo do_shortcode('[Spider_Calendar id="1" theme="13" default="month" select="month,list,week,day"]'); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="second">
                                <script class="ai1ec-widget-placeholder" data-widget="ai1ec_superwidget"
                                        data-display_filters="true" data-cat_ids="10,74"
                                        data-city_ids="43,45,39,48,49,38,50,52,53,54,40,55,35,36,57,58,59,37,60,62,64,65,66,67,69,70,41">
                                    jQuery(window).load(function () {
                                        var load_core_calendar = false;
                                        jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                            if (load_core_calendar == false) {
                                                var d = document, s = d.createElement('script'),
                                                    i = 'ai1ec-script';
                                                if (d.getElementById(i))return;
                                                s.async = 1;
                                                s.id = i;
                                                s.src = '//live-timely-11aad1b966.time.ly/?ai1ec_js_widget';
                                                d.getElementsByTagName('head')[0].appendChild(s);
                                            }
                                        });
                                    });
                                </script>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
