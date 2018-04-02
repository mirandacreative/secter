<?php get_header(); ?>
<?php $cat = get_category(get_query_var('cat')); ?>
    <div class="news-block">
        <div class="banner">
            <img src="<?php echo get_option('link_for_background_category'); ?>"
                 alt="<?php echo $cat->name; ?>">
            <div class="relative-block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-8 col-md-4">
                            <div class="row">
                                <h1 class="title"><?php echo $cat->name; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <?php if (have_posts()): ?>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="article-items">
                                    <?php while (have_posts()): ?>
                                        <?php the_post(); ?>
                                        <article class="col-md-4 col-sm-6 item">
                                            <img src="<?php the_post_thumbnail_url(get_the_id()); ?>"
                                                 alt="<?php the_title(); ?>">
                                            <h2><a class="title"
                                                   href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            <span class="time"><?php the_time('F j, Y') ?></span>
                                            <div class="text-block">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                    <script type="text/javascript">
                                        jQuery(window).load(function () {
                                            jQuery('.article-items').masonry({
                                                columnWidth: '.item',
                                                itemSelector: '.item'
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="pagination">
                                    <?php echo paginate_links(array('prev_text' => '', 'next_text' => '')); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
<?php get_footer(); ?>