<?php /*Template name: Business resources */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php $content = unserialize(get_the_content()); ?>
        <div class="business-resources">
            <div class="banner">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <div class="relative-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-offset-7 col-md-5">
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
                            <?php if ($content['main-block-subtitle'] != ''): ?>
                                <h3><?php echo $content['main-block-subtitle']; ?></h3>
                            <?php endif; ?>
                            <?php if ($content['text-business-resources-main'] != ''): ?>
                                <div
                                    class="text-block"><?php secter_the_content($content['text-business-resources-main']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (count($content['text-business-resources-article']) > 0): ?>
            <div class="article-block">
                <div class="container">
                    <div class="row">
                        <div class="list-item">
                            <?php foreach ($content['text-business-resources-article'] as $key => $text): ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="item">
                                        <div class="image-block">
                                            <img
                                                src="<?php echo $content['link-image-business-resources-article'][$key]; ?>"
                                                alt="<?php echo $content['title-business-resources-article'][$key]; ?>">
                                        </div>
                                        <div class="content-block">
                                            <div class="title-block">
                                                <a href="<?php echo $content['link-business-resources-article'][$key]; ?>">
                                                    <h2><?php echo $content['title-business-resources-article'][$key]; ?></h2>
                                                </a>
                                            </div>
                                            <div class="text-block"><?php secter_the_content($text); ?></div>
                                            <div class="learn-more">
                                                <a href="<?php echo $content['link-business-resources-article'][$key]; ?>">Learn
                                                    more</a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php get_template_part('town', 'template'); ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>