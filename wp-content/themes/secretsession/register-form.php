<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
<<<<<<< HEAD
 * @package WordPress
 * @subpackage Secret Session
 * @auther shakir blouch
*/
	?>
<div class="row">
    <div class="register-error"><?php $template->the_errors(); ?></div>
    <h1 class="main_title">Sign up</h1>

    <form name="registerform" id="registerform<?php $template->the_instance(); ?>"
          action="<?php $template->the_action_url('register'); ?>" method="post">
        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3 text-center">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="cimy_uef_NAME" id="cimy_uef_3" value="" placeholder="">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="user_login"
                       id="user_login<?php $template->the_instance(); ?>"
                       value="<?php $template->the_posted_value('user_login'); ?>" placeholder="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <?php if (isset($_GET['email']) && ($_GET['email'] != '')) { ?>
                    <input type="text" value="<?php echo $_GET['email'] ?>" readonly="readonly" class="form-control"
                           name="user_email" id="user_email<?php $template->the_instance(); ?>" placeholder="">
                <?php } else { ?>
                    <input type="text" value="<?php $template->the_posted_value('user_email'); ?>" class="form-control"
                           name="user_email" id="user_email<?php $template->the_instance(); ?>" placeholder="">
                <?php } ?>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" value="" name="cimy_uef_wp_PASSWORD" id="cimy_uef_wp_1" class="form-control"
                       placeholder=".......">
            </div>
            <button type="submit" class="">Submit</button>
            <input type="hidden" name="redirect_to" value="<?php echo get_page_link(5); ?>"/>
            <input type="hidden" name="instance" value="<?php $template->the_instance(); ?>"/>
            <input type="hidden" name="action" value="register"/>

        </div>
    </form>
</div>
