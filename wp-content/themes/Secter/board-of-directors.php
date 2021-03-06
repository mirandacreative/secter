<?php /* Template name: Board of Directors */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php $content = unserialize(get_the_content()); ?>
        <div class="about-us">
            <div class="banner">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <div class="relative-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <span class="title">About Us</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="wrapper">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="sidebar">
                                    <?php wp_nav_menu(array('menu' => get_post_meta(get_the_ID(), 'sidebar_slug', true))); ?>
                                </div>
                                <div class="mobile-sidebar">
                                    <div class="current-page"><?php the_title(); ?><span></span></div>
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="content">
                                    <h1><?php the_title(); ?></h1>
                                    <div class="main-block">
                                        <?php secter_the_content($content['text-board-of-directors-main']); ?>
                                    </div>
                                    <div class="second-block">
                                        <?php foreach ($content['text-board-of-directors'] as $key => $text): ?>
                                            <div class="text-block">
                                                <h2 class="mobile-title"><?php echo $content['title-board-of-directors'][$key]; ?></h2>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <img
                                                            src="<?php echo $content['link-image-board-of-directors'][$key]; ?>"
                                                            alt="<?php echo $content['title-board-of-directors'][$key]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="inner-text">
                                                            <h2 class="desktop-title"><?php echo $content['title-board-of-directors'][$key]; ?></h2>
                                                            <?php echo secter_the_content($text); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
