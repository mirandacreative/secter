<?php /* Template name: About Us */ ?>
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
                                    <h1 class="title">About Us</h1>
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
                                    <?php foreach ($content['text-about-us'] as $key => $text): ?>
                                        <div class="main-block">
                                            <h2><?php echo $content['title-about-us'][$key]; ?></h2>
                                            <div class="text-block">
                                                <?php echo secter_the_content($text); ?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
