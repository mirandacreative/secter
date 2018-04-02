<?php /* Template name: Sitemap */ ?>
<?php get_header(); ?>
<div class="sitemap">
    <div class="container">
        <div class="row">
            <ul>
                <?php wp_list_pages(array('title_li' => '<h1>' . get_the_title() . '</h1>')); ?>
            </ul>
        </div>
    </div>
</div>
<?php get_footer(); ?>
