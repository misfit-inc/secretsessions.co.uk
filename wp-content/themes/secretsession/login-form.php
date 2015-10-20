<!-- login container -->
<div id="login">
    <div class="container top_cont">
        <!-- login -->
        <div class="row">
            <form name="loginform" id="loginform<?php $template->the_instance(); ?>"
                  action="<?php $template->the_action_url('login'); ?>" method="post">
                <div class="col-md-6 col-md-offset-3 text-center tablet_cont">
                    <div class="login_cont">
                        <?php
                        if (isset($_POST['action']) && ($_POST['action'] != '')) {
                            if (($_POST['log'] == '') && ($_POST['pwd'] == '')) {
                                echo '<p class="error"><b>ERROR</b>:The username field is empty.<br>';
                                echo '<b>ERROR</b>:The password field is empty.</p>';
                            }
                        }
                        ?>
                        <?php
                        echo strrev(implode(strrev(''), explode('?', strrev($template->the_errors()), 2)));
                        ?>
                        <h1 class="main_title">Login to Secret Sessions</h1>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="log"
                                   id="user_login<?php $template->the_instance(); ?>" placeholder=""
                                   value="<?php $template->the_posted_value('log'); ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>"
                                   class="form-control" placeholder="......." autocomplete="off"/>
                        </div>
                        <button type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>"
                                class="">Sign me in
                        </button>
                        <input type="hidden" name="redirect_to" value="<?php echo get_site_url(); ?>"/>
                        <input type="hidden" name="instance" value="<?php $template->the_instance(); ?>"/>
                        <input type="hidden" name="action" value="login"/>
                        <a href="<?php echo get_site_url(); ?>?page_id=5&action=lostpassword" class="forgot_password">Help!
                            I've Forgotten my password</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- footer -->
    <div class="login_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <!-- footer logo -->
                    <div class="login_footer_logo pull-left">
                        <span class="login_ftr_ss_logo"></span>

                        <p>For the love of music</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <!-- social icons -->
                    <ul class="login_ftr_social_icons pull-right">
                        <li><a class="login_fb_ico" href="#" title=""></a></li>
                        <li><a class="login_twitter_ico" href="#" title=""></a></li>
                        <li class="nopadding"><a class="login_insta_ico" href="#" title=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- wrapper end -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/bootstrap.js"></script>
<!-- placeholder js for ie8 -->
<script src="<?php echo get_bloginfo('template_url'); ?>/js/placeholders.min.js"></script>
<!-- menu overlay js -->
<script src="<?php echo get_bloginfo('template_url'); ?>/js/fullscreennav.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/browser-detect.js"></script>
<script>
    $(function () {
        str = $('.error').text().split("?").join("");
        str.split('?').join('');
        str = str.split("Lost your password").join("");
        str.split('Lost your password').join('');
        $('.error').text(str);
        $(".overlay_menu").fullScreenNav();
        $(".open-menu-btn").click(function () {
            classes = $(".overlay_menu").attr("class");
            if (classes.indexOf("open") >= 0) {
                $('body').addClass('stop-scrolling');
                document.ontouchmove = function (e) {
                    e.preventDefault();
                }
            } else {
                $('body').removeClass('stop-scrolling');
                document.ontouchmove = function (e) {
                    return true;
                }
            }
        });
    });
</script>
<!-- Page Scrolling Js -->
<script src="<?php echo get_bloginfo('template_url'); ?>/js/page-scrolling.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.fadeInUp').addClass("hidden").viewportChecker({
            classToAdd: 'visible animated fadeInUp', // Class to add to the elements when they are visible
            offset: 100
        });
    });
</script>
</body>
</html>
