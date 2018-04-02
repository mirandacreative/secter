<?php /*Template name: Single Industry Clusters */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php $content = unserialize(get_the_content()); ?>
        <div class="industry-cluster">
            <div class="banner">
                <img src="<?php the_post_thumbnail_url(); ?>"
                     alt="<?php the_title(); ?>">
                <div class="relative-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <span class="title">Industry clusters</span>
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
                                    <h1 class="title"><?php the_title(); ?></h1>
                                    <div class="main-block">
                                        <?php secter_the_content($content['text-industry-clusters-main']); ?>
                                    </div>
                                    <?php if (count($content['text-industry-clusters-data']) > 0): ?>
                                        <div class="second-block">
                                            <h2 class="sub-title"><?php echo $content['subtitle-special-block-industry-clusters']; ?></h2>
                                            <div class="list-items">
                                                <?php foreach ($content['text-industry-clusters-data'] as $key => $text): ?>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="item">
                                                            <img
                                                                src="<?php echo $content['link-image-industry-clusters-data'][$key]; ?>">
                                                            <div class="text-block">
                                                                <?php secter_the_content($text); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('town', 'template'); ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>