<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <div class="single-news">
            <div class="banner">
                <img src="<?php echo get_option('link_for_background_category'); ?>" alt="<?php the_title(); ?>">
                <div class="relative-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-offset-8 col-md-4">
                                <div class="row">
                                    <span>News</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="article">
                                <img class="thumbnail-img" src="<?php the_post_thumbnail_url(get_the_id()); ?>"
                                     alt="<?php the_title(); ?>">
                                <h1 class="title"><?php the_title(); ?></h1>
                                <span class="time"><?php the_time('F j, Y') ?></span>
                                <div class="text-block"><?php the_content(); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="sidebar">
                                    <?php dynamic_sidebar('news-sidebar'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>