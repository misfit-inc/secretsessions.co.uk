<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div id="login">
    <div class="container top_cont">
        <!-- login -->
        <div class="row">
            <form name="lostpasswordform" id="lostpasswordform<?php $template->the_instance(); ?>"
                  action="<?php $template->the_action_url('lostpassword'); ?>" method="post">
                <div class="col-md-6 col-md-offset-3 text-center tablet_cont">
                    <div class="login_cont forgot_pass">
                        <?php $template->the_errors(); ?>
                        <h1 class="main_title">Enter your email address</h1>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>"
                                   class="form-control" value="<?php $template->the_posted_value('user_login'); ?>"
                                   size="20"/>
                        </div>
                        <button type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>">Reset
                            password
                        </button>
                        <input type="hidden" name="redirect_to"
                               value="<?php $template->the_redirect_url('lostpassword'); ?>"/>
                        <input type="hidden" name="instance" value="<?php $template->the_instance(); ?>"/>
                        <input type="hidden" name="action" value="lostpassword"/>
                        <a href="<?php echo get_permalink(get_page_by_path('login')); ?>" class="forgot_password">Back
                            to login</a>
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
