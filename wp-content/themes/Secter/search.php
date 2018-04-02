<?php /* Template name: Search */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <div class="search">
            <div class="banner">
                <div class="search-count">
                    <?php $args = array('post_type' => 'page', 'posts_per_page' => -1, 'meta_query' => array(
                        array('key' => '_wp_page_template', 'value' => 'featured-properties.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'industry-clusters.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'news.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'search.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'home.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'business-resources.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'programs.php', 'compare' => '!='),
                        array('key' => '_wp_page_template', 'value' => 'calendar.php', 'compare' => '!=')
                    )); ?>
                    <?php if ($_GET['search-word'] != '' or $_GET['search-word'] != null) add_filter('posts_where', 'change_SQL_query_WP_for_search'); ?>
                    <?php $args['tax_query'] = array('relation' => 'or', array('taxonomy' => 'page-tag', 'field' => 'term_id', 'terms' => $_GET['search-tag']), array('taxonomy' => 'page-tag', 'field' => 'name', 'terms' => $_GET['search-word'])); ?>
                    <?php $query = new WP_Query($args); ?>
                    <?php if ($query->have_posts() or $_GET['search-word'] != '' or $_GET['search-word'] != null): ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="count">
                                            <span>(<?php echo count($query->posts); ?>)</span>
                                        </div>
                                        <div class="text-block-search-count">
                                            <span class="search-for">SEARCH RESULTS FOR:</span>
                                            <span class="search-word"><?php echo $_GET['search-word']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
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
            <div class="content">
                <div class="container">
                    <div class="row">
                        <?php $args = array('post_type' => 'page', 'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1, 'posts_per_page' => get_option('posts_per_page'), 'meta_query' => array(
                            array('key' => '_wp_page_template', 'value' => 'featured-properties.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'industry-clusters.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'news.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'search.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'home.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'business-resources.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'programs.php', 'compare' => '!='),
                            array('key' => '_wp_page_template', 'value' => 'calendar.php', 'compare' => '!=')
                        )); ?>
                        <?php if ($_GET['search-word'] != '' or $_GET['search-word'] != null) add_filter('posts_where', 'change_SQL_query_WP_for_search'); ?>
                        <?php $args['tax_query'] = array('relation' => 'or', array('taxonomy' => 'page-tag', 'field' => 'term_id', 'terms' => $_GET['search-tag']), array('taxonomy' => 'page-tag', 'field' => 'name', 'terms' => $_GET['search-word'])); ?>
                        <?php $query = new WP_Query($args); ?>
                        <?php if ($query->have_posts() or $_GET['search-word'] != '' or $_GET['search-word'] != null): ?>
                            <?php while ($query->have_posts()): ?>
                                <?php $query->the_post(); ?>
                                <article id="<?php the_ID(); ?>">
                                    <a href="<?php the_permalink(); ?>" target="_blank"><h2
                                            class="title"><?php the_title(); ?></h2></a>
                                    <div class="excerpt">
                                        <?php $content = get_the_content(); ?>
                                        <?php if (is_array(unserialize($content))) : ?>
                                            <?php $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(unserialize($content))); ?>
                                            <?php $arrOut = iterator_to_array($iterator, false); ?>
                                            <?php echo wp_strip_all_tags($arrOut[0]); ?>
                                        <?php else: ?>
                                            <?php the_excerpt(); ?>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="read-more">READ MORE</a>
                                </article>
                            <?php endwhile; ?>
                            <div class="pagination">
                                <?php echo paginate_links(array('total' => $query->max_num_pages, 'prev_text' => '', 'next_text' => '')); ?>
                            </div>
                        <?php else: ?>
                            <div class="empty">
                                <h2>Noting found</h2>
                            </div>
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
