<?php /*Template name: Home*/ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php $content = unserialize(get_the_content()); ?>
        <div class="banner">
            <div class="container-fluid">
                <div class="row">
                    <div id="main-slider" class="nivoSlider">
                        <?php foreach ($content['slides'] as $slide): ?>
                            <img src="<?php echo $slide; ?>"
                                 data-transition="fade"/>
                        <?php endforeach; ?>
                    </div>
                    <script type="text/javascript">
                        jQuery(window).load(function () {
                            jQuery('#main-slider').nivoSlider({
                                effect: 'sliceDown',
                                prevText: '<img src="/wp-content/themes/Secter/assets/images/arrow.png">',
                                nextText: '<img src="/wp-content/themes/Secter/assets/images/arrow.png">',
                                pauseTime: 5000,
                                controlNav: true,
                                pauseOnHover: false
                            });
                        });
                    </script>
                    <div class="inner-banner">
                        <h2>INNOVATION</h2>
                        <span class="slogan">Begins in Southeastern Connecticut</span>
                        <form id="search-field" method="get" action="/search-result/">
                            <div class="inner-search-field">
                                <button type="button" id="left-scroll-search-words" class="scroll"></button>
                                <div class="search-field">
                                    <input type="text" placeholder="Start Exploring" class="search-word"
                                           autocomplete="off"
                                           name="search-word">
                                </div>
                                <button type="button" id="right-scroll-search-words" class="scroll"></button>
                            </div>
                            <input type="submit" class="submit" value="">
                            <div class="clearfix"></div>
                            <div id="list-of-not-used-tags"></div>
                        </form>
                        <div class="offer-words animated">
                            <button type="button" id="left-scroll" class="scroll"></button>
                            <div class="list-offer-words" style="left: 0;">
                                <?php $tags = get_terms(array('taxonomy' => 'page-tag', 'meta_query' => array(array('key' => 'search', 'value' => '1')))); ?>
                                <?php $used_tags = array(); ?>
                                <?php foreach ($tags as $key => $tag): ?>
                                    <?php if ($key < 10): ?>
                                        <?php echo '<input id=' . $tag->term_id . ' class="offer-word" type="button" value="' . $tag->name . '">'; ?>
                                        <?php $used_tags[] = $tag->term_id; ?>
                                    <?php else: ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php $not_used_tags = get_terms(array('taxonomy' => 'page-tag', 'exclude' => $used_tags)); ?>
                                <input type="hidden" value='<?php echo json_encode($not_used_tags); ?>'
                                       id="not-used-tags">
                            </div>
                            <button type="button" id="right-scroll" class="scroll"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='right-expertise-and-solution'>
            <div class="container">
                <div class="row">
                    <h2>THE RIGHT EXPERTISE.THE RIGHT SOLUTIONS</h2>
                    <div class="items">
                        <?php foreach ($content['title-right-expertise'] as $key => $text): ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="item animated">
                                    <h3><?php echo $text; ?></h3>
                                    <?php secter_the_content($content['text-right-expertise'][$key]); ?>
                                    <a href="<?php echo $content['link-right-expertise'][$key]; ?>">LEARN MORE</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="success-stories">
            <h2>Success Stories</h2>
            <div class="col-sm-6 left-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="item">
                                <div class="img-block">
                                    <img src="<?php echo $content['link-image-success-stories'][0]; ?>"
                                         alt="<?php echo $content['title-success-stories'][0]; ?>">
                                </div>
                                <div class="caption">
                                    <div class="blur"></div>
                                    <div class="caption-text">
                                        <a class="name"
                                           href="<?php echo $content['link-success-stories'][0]; ?>"><?php echo $content['title-success-stories'][0]; ?></a>
                                        <?php secter_the_content($content['text-success-stories'][0]); ?>
                                        <a class="read-more" href="<?php echo $content['link-success-stories'][0]; ?>">Read</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="img-block">
                                    <img src="<?php echo $content['link-image-success-stories'][1]; ?>"
                                         alt="<?php echo $content['title-success-stories'][1]; ?>">
                                </div>
                                <div class="caption">
                                    <div class="blur"></div>
                                    <div class="caption-text">
                                        <a class="name"
                                           href="<?php echo $content['link-success-stories'][1]; ?>"><?php echo $content['title-success-stories'][1]; ?></a>
                                        <?php secter_the_content($content['text-success-stories'][1]); ?>
                                        <a class="read-more" href="<?php echo $content['link-success-stories'][1]; ?>">Read</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="item">
                                <div class="img-block">
                                    <img src="<?php echo $content['link-image-success-stories'][2]; ?>"
                                         alt="<?php echo $content['title-success-stories'][2]; ?>">
                                </div>
                                <div class="caption">
                                    <div class="blur"></div>
                                    <div class="caption-text">
                                        <a class="name"
                                           href="<?php echo $content['link-success-stories'][2]; ?>"><?php echo $content['title-success-stories'][2]; ?></a>
                                        <?php secter_the_content($content['text-success-stories'][2]); ?>
                                        <a class="read-more" href="<?php echo $content['link-success-stories'][2]; ?>">Read</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="img-block">
                                    <img src="<?php echo $content['link-image-success-stories'][3]; ?>"
                                         alt="<?php echo $content['title-success-stories'][3]; ?>">
                                </div>
                                <div class="caption">
                                    <div class="blur"></div>
                                    <div class="caption-text">
                                        <a class="name"
                                           href="<?php echo $content['link-success-stories'][3]; ?>"><?php echo $content['title-success-stories'][3]; ?></a>
                                        <?php secter_the_content($content['text-success-stories'][3]); ?>
                                        <a class="read-more" href="<?php echo $content['link-success-stories'][3]; ?>">Read</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 right-block">
                <div class="row">
                    <div class="item">
                        <div class="img-block">
                            <img src="<?php echo $content['link-image-success-stories'][4]; ?>"
                                 alt="<?php echo $content['title-success-stories'][4]; ?>">
                        </div>
                        <div class="caption">
                            <div class="blur"></div>
                            <div class="caption-text">
                                <a class="name"
                                   href="<?php echo $content['link-success-stories'][4]; ?>"><?php echo $content['title-success-stories'][4]; ?></a>
                                <?php secter_the_content($content['text-success-stories'][4]); ?>
                                <a class="read-more" href="<?php echo $content['link-success-stories'][4]; ?>">Read</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php $query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 5)); ?>
        <?php if ($query->have_posts()): ?>
            <div class="last-news">
                <div class="container">
                    <div class="news-block">
                        <span class="left-triangle triangle"></span>
                        <span class="left-triangle inner-triangle"></span>
                        <div class="inner-news-block">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="row">
                                    <h2>News Feed</h2>
                                    <div id="slider-news" class="nivoSlider">
                                        <?php foreach ($query->posts as $key => $value): ?>
                                            <img src="#" data-transition="fade" title="#unic-iq-<?php echo $key; ?>"/>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php $key = 0; ?>
                                    <?php while ($query->have_posts()): ?>
                                        <?php $query->the_post(); ?>
                                        <div id="unic-iq-<?php echo $key; ?>" class="nivo-html-caption">
                                            <div class="news animated fadeIn">
                                                <?php the_excerpt(); ?>
                                                <a href="<?php the_permalink(); ?>">Read more</a>
                                            </div>
                                        </div>
                                        <?php $key++; ?>
                                    <?php endwhile; ?>
                                    <script type="text/javascript">
                                        jQuery('#slider-news').nivoSlider({
                                            effect: 'sliceDown',
                                            prevText: '',
                                            nextText: '',
                                            pauseTime: 5000,
                                            animSpeed: 0,
                                            controlNav: true,
                                            pauseOnHover: false,
                                            afterLoad: function () {
                                                jQuery('.last-news .nivo-controlNav').ready(function () {
                                                    jQuery('.last-news .news-control').append(jQuery('.last-news .nivo-controlNav'));
                                                });
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <span class="right-triangle triangle"></span>
                        <span class="right-triangle inner-triangle"></span>
                    </div>
                    <div class="news-control"></div>
                </div>
            </div>
        <?php endif; ?>
        <div class="comprehensive-information">
            <div class="container">
                <div class="row">
                    <h2>COMPREHENSIVE INFORMATION TO HELP YOUR BUSINESS</h2>
                    <?php foreach ($content['title-comprehensive-information'] as $key => $text): ?>
                        <div class="col-sm-4 col-xs-6">
                            <div class="item">
                                <div class="img-block">
                                    <img src="<?php echo $content['link-image-comprehensive-information'][$key]; ?>"
                                         alt="<?php echo $text; ?>">
                                    <img class="animated secter-fadeInDown"
                                         src="<?php echo $content['link-image-comprehensive-information-hover'][$key]; ?>"
                                         alt="<?php echo $text; ?>-hover">
                                </div>
                                <a href="#" class="title"><?php echo $text; ?></a>
                                <?php secter_the_content($content['text-comprehensive-information'][$key]); ?>
                                <a class="animated link"
                                   href="<?php echo $content['link-comprehensive-information'][$key]; ?>">Learn</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php get_template_part('town', 'template'); ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
