<?php /* Template name: Towns */ ?>
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
                                    <?php $town = new WP_Query(array('post_type' => 'town', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC')); ?>
                                    <?php if ($town->have_posts()): ?>
                                        <div class="select-town-block">
                                            <h2>Find a Town</h2>
                                            <div class="town-selected">Select a town<span></span></div>
                                            <ul>
                                                <?php while ($town->have_posts()): ?>
                                                    <?php $town->the_post(); ?>
                                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                            <script type="text/javascript">
                                                jQuery(".select-town-block ul").mCustomScrollbar({
                                                    theme: "dark"
                                                });
                                            </script>
                                        </div>
                                    <?php endif; ?>
                                    <?php wp_reset_postdata(); ?>
                                    <h1><?php the_title(); ?></h1>
                                    <div class="main-block">
                                        <?php secter_the_content($content['text-towns-main']); ?>
                                    </div>
                                    <div class="second-block">
                                        <?php foreach ($content['text-towns'] as $key => $text): ?>
                                            <div class="text-block">
                                                <h2><?php echo $content['title-towns'][$key]; ?></h2>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <img src="<?php echo $content['link-image-towns'][$key]; ?>"
                                                             alt="<?php echo $content['title-towns'][$key]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="inner-text">
                                                            <?php echo secter_the_content($text); ?>
                                                            <?php if (!empty($content['link-towns'][$key]) && !empty($content['title-link-towns'][$key])): ?>
                                                                <a href="<?php echo $content['link-towns'][$key]; ?>"
                                                                   class="link"><?php echo $content['title-link-towns'][$key]; ?></a>
                                                            <?php endif; ?>
                                                            <?php if (!empty($content['website-towns'][$key]) && !empty($content['website-title-towns'][$key])): ?>
                                                                <a href="<?php echo $content['website-towns'][$key]; ?>"
                                                                   class="website"><?php echo $content['website-title-towns'][$key]; ?></a>
                                                            <?php endif; ?>
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
        <?php get_template_part('town', 'template'); ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>