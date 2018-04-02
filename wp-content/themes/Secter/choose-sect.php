<?php /*Template name: Choose Sect */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php $content = unserialize(get_the_content()); ?>
        <div class="special-landing">
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
            <div class="main-block">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="col-sm-10">
                                <div class="row">
                                    <h2><?php echo $content['main-block-title']; ?></h2>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <h3><?php echo $content['main-block-subtitle']; ?></h3>
                            <div
                                class="text-block"><?php secter_the_content($content['text-special-landing-main']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider">
                <div class="container">
                    <div class="row">
                        <div class="owl-carousel owl-theme" id="owl-carousel">
                            <?php foreach ($content['text-special-landing-slider'] as $key => $text): ?>
                                <div class="item">
                                    <h2># <?php echo($key + 1); ?></h2>
                                    <div class="text-block">
                                        <?php secter_the_content($text); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery("#owl-carousel").owlCarousel({
                    itemsCustom: [
                        [0, 1],
                        [450, 1],
                        [768, 2],
                        [992, 3]
                    ],
                    navigation: true,
                    navigationText: ["<span></span>", "<span></span>"],
                    afterInit: function () {
                        jQuery('.slider .owl-controls').ready(function () {
                            jQuery('.slider .owl-carousel').before(jQuery('.slider .owl-controls'));
                        });
                        var minHeight = parseInt(jQuery('.owl-item').eq(0).css('height'));
                        jQuery('.owl-item').each(function () {
                            var thisHeight = parseInt(jQuery(this).css('height'));
                            minHeight = (minHeight <= thisHeight ? minHeight : thisHeight);
                        });
                        jQuery('.owl-wrapper-outer').css('height', minHeight + 'px');
                    },
                    afterUpdate: function () {
                        var minHeight = parseInt(jQuery('.owl-item').eq(0).css('height'));
                        jQuery('.owl-item').each(function () {
                            var thisHeight = parseInt(jQuery(this).css('height'));
                            minHeight = (minHeight <= thisHeight ? minHeight : thisHeight);
                        });
                        jQuery('.owl-wrapper-outer').css('height', minHeight + 'px');
                    }
                });
            </script>
        </div>
        <?php $featured_properties = new WP_Query(array('post_type' => 'featured_properties', 'posts_per_page' => 3)); ?>
        <?php if ($featured_properties->have_posts()) : ?>
            <div class="featured-properties">
                <div class="container">
                    <div class="row">
                        <h2>Featured Properties</h2>
                        <div class="item-list">
                            <?php while ($featured_properties->have_posts()): ?>
                                <?php $featured_properties->the_post(); ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="item">
                                        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                        <div class="text-block">
                                            <?php the_content(); ?>
                                        </div>
                                        <a class="pdf"
                                           href="<?php echo get_post_meta(get_the_ID(), 'link_for_pdf', true); ?>"
                                           target="_blank">PDF</a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="special-item">
                                    <img class="logo"
                                         src="<?php echo $content['link-image-special-landing-featured-properties']; ?>"
                                         alt="<?php echo $content['title-special-landing-featured-properties']; ?>">
                                    <h3><?php echo $content['title-special-landing-featured-properties']; ?></h3>
                                    <div
                                        class="text-block"><?php secter_the_content($content['text-special-landing-featured-properties']); ?></div>
                                    <a href="<?php echo $content['link-special-landing-featured-properties']; ?>"
                                       class="learn-more">learn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        <div class="article-block">
            <div class="container">
                <div class="row">
                    <div class="list-item">
                        <?php foreach ($content['text-special-landing-article'] as $key => $text): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="item">
                                    <div class="title-block">
                                        <a href="<?php echo $content['link-special-landing-article'][$key]; ?>">
                                            <h2><?php echo $content['title-special-landing-article'][$key]; ?></h2></a>
                                    </div>
                                    <div class="image-block">
                                        <img src="<?php echo $content['link-image-article'][$key]; ?>"
                                             alt="<?php echo $content['title-special-landing-article'][$key]; ?>">
                                    </div>
                                    <div class="text-block"><?php secter_the_content($text); ?></div>
                                    <a class="learn-more"
                                       href="<?php echo $content['link-special-landing-article'][$key]; ?>">Learn
                                        more</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('town', 'template'); ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>