<?php /* Template name: Contact */ ?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php $content = unserialize(get_the_content()); ?>
        <div class="contact">
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
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-6">
                            <div class="row">
                                <div class="contact-data">
                                    <div class="element"><span>PHONE: <a href="tel:<?php echo $content['telephone-contact-form']; ?>"><?php echo $content['telephone-contact-form']; ?></a></span></div>
                                    <div class="element"><span>FAX: <?php echo $content['fax-contact-form']; ?></span></div>
                                    <div class="element"><span>EMAIL: <a href="mail:<?php echo $content['email-contact-form']; ?>"><?php echo $content['email-contact-form']; ?></a></span>
                                    </div>
                                    <div class="element location">
                                        <span class="marker"></span>
                                        <span class="text-location"><?php secter_the_content($content['address-contact-form']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="social-link">
                                    <ul>
                                        <li class="facebook"><a href="<?php echo $content['link-facebook-contact-form']; ?>"><?php echo $content['title-facebook-contact-form']; ?></a></li>
                                        <li class="twitter"><a href="<?php echo $content['link-twitter-contact-form']; ?>"><?php echo $content['title-twitter-contact-form']; ?></a></li>
                                        <li class="linkedin"><a href="<?php echo $content['link-linkedin-contact-form']; ?>"><?php echo $content['title-linkedin-contact-form']; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php get_template_part('town', 'template'); ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
