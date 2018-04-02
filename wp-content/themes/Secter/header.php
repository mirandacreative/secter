<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/us_LA/sdk.js#xfbml=1&version=v2.8&appId=280538405619410";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
<body>
<div id="fb-root"></div>
<div id="preloader"></div>
<div id="<?php global $post;
echo $post->post_name; ?>">
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="inner-header">
                    <div class="col-md-12 col-sm-7">
                        <div class="row">
                            <div class="top-menu">
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'top_menu',
                                    'container' => 'nav',
                                    'container_class' => 'secter-navbar',
                                    'container_id' => 'top-menu',
                                    'items_wrap' => new_wp_nav_menu_top()
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="row">
                            <div class="logo-header">
                                <a href="/">
                                    <img src="/wp-content/themes/Secter/assets/images/secter-logo.jpg" class="tablet">
                                </a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12">
                        <div class="row">
                            <div class="header-menu">
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'header_menu',
                                    'container' => 'nav',
                                    'container_class' => 'secter-navbar',
                                    'container_id' => 'header-menu',
                                    'items_wrap' => new_wp_nav_menu_header()
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <span class="hamburger-button"></span>
                    <span class="search-button-mob"></span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="hamburger-menu"></div>
        <form id="search-field-header-mob" class="animated bounceInLeft" method="get" action="/search-result/">
            <div class="search-field">
                <input type="text" placeholder="Start Exploring" name="search-word" autocomplete="off"
                       class="search-word">
            </div>
            <input type="submit" class="submit" value="">
            <div class="clearfix"></div>
        </form>
        <?php if (!is_user_logged_in()): ?>
            <div class="black-layer"></div>
            <div class="registration-box">
                <span class="close-all-layers"></span>
                <div class="inner-box">
                    <img src="/wp-content/themes/Secter/assets/images/secter-logo.jpg" alt="logo-modal-form">
                    <span class="label label-danger message"></span>
                    <span class="label label-success message"></span>
                    <form id="registerform" method="post">
                        <span class="title">Create an Account</span>
                        <p class="login-username">
                            <input name="log" type="text" placeholder="User Name" id="user_login" class="input"
                                   autocomplete="off">
                        </p>
                        <p class="email-username">
                            <input name="email" type="text" placeholder="Email" id="user_email" class="input"
                                   autocomplete="off">
                        </p>
                        <span class="text">Notifications and newsletters you subscribe to will be sent here. Your privacy is important to us.</span>
                        <p class="password">
                            <input name="pwd" type="password" placeholder="Password" id="user_pass" class="input"
                                   autocomplete="off">
                        </p>
                        <span class="text">Must be at least 6 characters</span>
                        <p class="conf-password">
                            <input name="conf-pwd" type="password" placeholder="Confirm Password" id="user_conf_pass"
                                   class="input"
                                   autocomplete="off">
                        </p>
                        <p class="register-submit">
                            <input type="submit" id="wp-submit" class="button button-primary" value="Create an Account">
                        </p>
                        <input type="hidden" name="nonce-register"
                               value="<?php echo wp_create_nonce('register_me_nonce'); ?>"/>
                        <span class="private-policy">By connecting your account, you agree you have read and consent to the <a
                                href="#">Terms of Service and Privacy Policy</a></span>
                    </form>
                </div>
            </div>
            <div class="login-box">
                <span class="close-all-layers"></span>
                <div class="inner-box">
                    <img src="/wp-content/themes/Secter/assets/images/secter-logo.jpg" alt="logo-modal-form">
                    <span class="label label-danger message"></span>
                    <span class="label label-success message"></span>
                    <form id="loginform" method="post">
                        <span class="title">Login</span>
                        <span
                            class="text">Log in to SECTER so you can comment, share, and get your news by email.</span>
                        <p class="login-username">
                            <input name="log" type="text" placeholder="User Name or Email" id="user_login" class="input"
                                   autocomplete="off">
                        </p>
                        <p class="login-password">
                            <input name="pwd" type="password" placeholder="Password" id="user_pass" class="input"
                                   autocomplete="off">
                        </p>
                        <p class="login-submit">
                            <input type="submit" id="wp-submit" class="button button-primary" value="login">
                        </p>
                        <p class="forgetmenot">
                            <label for="rememberme">
                                <input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me
                            </label>
                            <a href="#" class="forget-pwd">I forgot my password</a>
                        </p>
                        <input type="hidden" name="nonce-login"
                               value="<?php echo wp_create_nonce('login_me_nonce'); ?>"/>
                        <input type="hidden" name="reload" value="<?php echo get_permalink(); ?>"/>
                    </form>
                    <form id="forgotform" method="post">
                        <span class="title">Forgot password</span>
                        <p class="login-username">
                            <input name="email" type="text" placeholder="Your email" id="user_email" class="input"
                                   autocomplete="off">
                        </p>
                        <p class="forget-submit">
                            <input type="submit" id="wp-submit" class="button button-primary" value="forgot">
                        </p>
                        <p class="forgetmenot">
                            <a href="#" class="forget-pwd">login</a>
                        </p>
                        <input type="hidden" name="nonce-forget"
                               value="<?php echo wp_create_nonce('forget_me_nonce'); ?>"/>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </header>