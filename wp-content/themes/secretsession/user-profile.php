<?php
/**
 * Template Name: User Profile
 *
 * Allow users to update their profiles from Frontend.
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Secret Session
 * @author  shakir blouch
 */
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}
global $current_user, $wp_roles, $wpdb;
get_currentuserinfo();// get user Info
$error = '';
$gener = array();
$user_id = $current_user->data->ID;// Get user Id
$result = $wpdb->get_results("SELECT * FROM wp_cimy_uef_fields");
$allowed = array('gif', 'png', 'jpg', 'jpeg');
foreach ($result as $print) {
    $extra_field[$print->NAME] = $print->ID;
}
if (isset($_POST['edit_profile'])) {
    $_POST = sanitize($_POST);
    $error = secret_session_validate_user_data();
    if (empty($error)) {
        secret_session_save_user_data();
    }
}
get_header();
$user_data = $wpdb->get_results("SELECT wp_cimy_uef_data.*,wp_cimy_uef_fields.NAME FROM wp_cimy_uef_data JOIN wp_cimy_uef_fields ON wp_cimy_uef_fields.ID=wp_cimy_uef_data.FIELD_ID where USER_ID=" . $user_id);
foreach ($user_data as $key => $val) {
    $user_data_1[$val->NAME] = $val->VALUE;
}
?>
    <!-- wrapper start -->
    <div id="wrapper">
    <div class="artist_cover">
        <?php if (isset($user_data_1['COVER_PHOTO']) && ($user_data_1['COVER_PHOTO'] != '')) { ?>
            <img width="100%" src="<?php echo $user_data_1['COVER_PHOTO'] ?>" alt="" class="img-responsive">
        <?php } else { ?>
            <img width="100%" src="<?php echo get_bloginfo('template_url'); ?>/images/BlackBoxBlank.jpg" alt=""
                 class="img-responsive">
        <?php } ?>
    </div>
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<center><p class="message">' . $_SESSION['msg'] . '</p></center>';
        unset($_SESSION['msg']);
    }
    echo '<center>' . $error . '</center>';
    ?>
    <div class="container" id="edit_profile">
        <form action="" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
<?php
	$field_id = get_cimyFieldValue_fun( 'URL_NAME' );
	$url_set = $wpdb->get_row("SELECT count(ID) as num,VALUE FROM wp_cimy_uef_data where FIELD_ID=$field_id and USER_ID=$user_id");
	$url_set_count	=	$url_set->num;
	if($url_set_count > 0){
		$readonly	=	'readonly="readonly"';
	}else{
		$readonly	=	'';
	}
?>
                        <label>Artist name:<br><span class="small_text">(Your artist name will be added to the URL for your profile page (e.g. secretsessions.co.uk/artist/the-beatles). Once you have published your profile, this cannot be edited)</span></label>
                        <input type="text" class="form-control" id=""
                               value="<?php if (isset($_POST['artist_name'])) {
                                   echo $_POST['artist_name'];
                               } else {
                                   echo $user_data_1['NAME'];
                               } ?>" name="artist_name" <?php echo $readonly?> />
                    </div>
                    <div class="form-group">
                        <label>Artist bio:</label>
                        <textarea id='bio' class="form-control" placeholder="(max 300 characters)"
                                  name="DESCRIPTION_USER"><?php if (isset($_POST['DESCRIPTION_USER'])) {
                                echo stripslashes($_POST['DESCRIPTION_USER']);
                            } else {
                                echo stripslashes(@$user_data_1['DESCRIPTION_USER']);
                            } ?></textarea>
                        <span id="finalcount"></span>
                    </div>

                    <div class="form-group upload cover_photo">
                        <label>Cover photo <span
                                class="small_text">(max size 2mb min 1100 pixels wide)</span></label>
         <span class="btn-file">Upload<input type="file" class="file_class" id="cover_photo" name="cover_photo"/>
        </span><span id="cover_photo_span" class="file_name"></span>
                        <?php if (isset($user_data_1['COVER_PHOTO']) && ($user_data_1['COVER_PHOTO'] != '')) { ?>
                            <img width="20%" src="<?php echo $user_data_1['COVER_PHOTO'] ?>" alt=""
                                 class="img-responsive">
                        <?php } ?>
                    </div>


                    <div class="form-group upload">
                        <label>Profile photo <span class="small_text">(max size 2mb min 220 pixels wide)</span></label>
         <span class="btn-file">Upload<input class="file_class" id="profile_photo" type="file" name="profile_photo"/>
        </span><span id="profile_photo_span" class="file_name"></span>
                        <?php if (isset($user_data_1['PROFILE_PHOTO']) && ($user_data_1['PROFILE_PHOTO'] != '')) { ?>
                        	<input type="hidden" value="1" name="profile_photo_set" />
                            <img width="20%" src="<?php echo $user_data_1['PROFILE_PHOTO'] ?>" alt=""
                                 class="img-responsive">
                        <?php } ?>
                    </div>

                    <div id="outer_video">
                        <div id="1" class="clone">

                            <div class="form-group">
                                <label>Video Title:</label>
                                <input type="text" class="form-control" id="" name="title[]"/>
                            </div>

                            <div class="form-group">
                                <label>YouTube link:</label>
                                <input type="text" class="form-control" id="" name="youtube[]"/>
                            </div>

                            <div class="form-group upload">
                                <label>Video image<span class="small_text"> (max size 2mb)</span></label>
             <span class="btn-file">
             Upload <input type="file" name="videoImage[]" class="file_class" id="youtube_1"/>
            </span><span id="youtube_1_span" class="file_name"></span>
                            </div>
                        </div>
                    </div>
                    <div class="button_group">
                        <button type="button" id="addVideo" class="btn_save">Add another video</button>
                        <a href="<?php echo get_permalink(get_page_by_path('edit-videos')) ?>">
                            <button type="button" class="btn_save">Edit videos</button>
                        </a>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_POST['edit_profile'])) {
                if (isset($_POST['genre'])) {
                    $gener = @$_POST['genre'];
                } else {
                    $gener = array();
                }

            } else {
                if (@$user_data_1['POP'] == "YES") {
                    $gener[] = 'POP';
                }
                if (@$user_data_1['FOLK'] == "YES") {
                    $gener[] = 'FOLK';
                }
                if (@$user_data_1['ROCK'] == "YES") {
                    $gener[] = 'ROCK';
                }
                if (@$user_data_1['INDIE'] == "YES") {
                    $gener[] = 'INDIE';
                }
                if (@$user_data_1['ELECTRONIC'] == "YES") {
                    $gener[] = 'ELECTRONIC';
                }
                if (@$user_data_1['URBAN'] == "YES") {
                    $gener[] = 'URBAN';
                }
                if (@$user_data_1['ACOUSTIC'] == "YES") {
                    $gener[] = 'ACOUSTIC';
                }
                if (@$user_data_1['JAZZ'] == "YES") {
                    $gener[] = 'JAZZ';
                }
                if (@$user_data_1['WORLD'] == "YES") {
                    $gener[] = 'WORLD';
                }
            }
            ?>
            <div class="genre">
                <h2>Genre:</h2>
    <span>
    <label class="label_check " for="Pop">
        <input type="checkbox" name="genre[]" id="Pop"
               value="POP" <?php if (in_array('POP', $gener)) { ?> checked="checked"<?php } ?>/>Pop</label>
    </span>
    <span>
    <label class="label_check " for="Folk">
        <input type="checkbox" name="genre[]" id="Folk"
               value="FOLK" <?php if (in_array('FOLK', $gener)) { ?> checked="checked"<?php } ?>  />Folk</label>
    </span>
    <span>
    <label class="label_check" for="Rock">
        <input type="checkbox" name="genre[]" id="Rock"
               value="ROCK" <?php if (in_array('ROCK', $gener)) { ?> checked="checked"<?php } ?>  />Rock</label>
    </span>
    <span>
    <label class="label_check" for="Indie">
        <input type="checkbox" name="genre[]" id="Indie"
               value="INDIE"<?php if (in_array('INDIE', $gener)) { ?> checked="checked"<?php } ?>  />Indie</label>
    </span>
    <span>
    <label class="label_check" for="Elecronic">
        <input type="checkbox" name="genre[]" id="Elecronic"
               value="ELECTRONIC"<?php if (in_array('ELECTRONIC', $gener)) { ?> checked="checked"<?php } ?> />Elecronic</label>
    </span>
    <span>
    <label class="label_check" for="Urban">
        <input type="checkbox" name="genre[]" id="Urban"
               value="URBAN" <?php if (in_array('URBAN', $gener)) { ?> checked="checked"<?php } ?>  />Urban</label>
    </span>
    <span>
    <label class="label_check" for="Accoustic">
        <input type="checkbox" name="genre[]" id="Accoustic"
               value="ACOUSTIC" <?php if (in_array('ACOUSTIC', $gener)) { ?> checked="checked"<?php } ?>/>Acoustic</label>
    </span>
    <span>
    <label class="label_check" for="Jazz">
        <input type="checkbox" name="genre[]" id="Jazz"
               value="JAZZ" <?php if (in_array('JAZZ', $gener)) { ?> checked="checked"<?php } ?> />Jazz</label>
    </span>
    <span>
    <label class="label_check" for="World">
        <input type="checkbox" name="genre[]" id="World"
               value="WORLD" <?php if (in_array('WORLD', $gener)) { ?> checked="checked"<?php } ?> />World</label>
    </span>
            </div>
            <div class="form-horizontal social_network_code">
                <div class="form-group">
                    <div class="col-md-3 col-sm-5">
                        <label>Twitter URL:<br><span class="small_text">(e.g. https://twitter.com/TwitterHandle)</span></label>
                    </div>
                    <div class="col-md-9 col-sm-7">
                        <input type="text" class="form-control" id=""
                               value="<?php if (isset($_POST['twitter'])) {
                                   echo $_POST['twitter'];
                               } else {
                                   echo htmlspecialchars($user_data_1['TWITTER_EMDED_CODE']);
                               } ?>" name="twitter" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3 col-sm-5">
                        <label>Soundcloud embed code:</label>
                    </div>
                    <div class="col-md-9 col-sm-7">
                        <input type="text" class="form-control" id="" name="soundcloud"
                               value="<?php if (isset($_POST['soundcloud'])) {
                                   echo $_POST['soundcloud'];
                               } else {
                                   echo(($user_data_1['SOUNDCLOUD_EMBED']));
                               } ?>" placeholder="">
                    </div>
                </div>
            </div>
            <div class="pull-right button_group">
                <button type="submit" name="edit_profile" class="btn_publish">Publish</button>
            </div>
        </form>
    </div>
    </div>
    <!-- wrapper end -->
    <script>
        var video_count = 0;
        $(function () {
			var characters = 300;
			$("#finalcount").html("<strong>"+  characters+"</strong> characters remaining");			
            $("#bio").keyup(function () {
				if($(this).val().length > characters){
					$(this).val($(this).val().substr(0, characters));
				}
				var remaining = characters -  $(this).val().length;
				$("#finalcount").html("<strong>"+  remaining+"</strong> characters remaining");
				$('#finalcount').css('color', 'red');
            }).keyup();
        });
        function setupLabel() {
            if ($('.label_check input').length) {
                $('.label_check').each(function () {
                    $(this).removeClass('c_on');
                });
                $('.label_check input:checked').each(function () {
                    $(this).parent('label').addClass('c_on');
                });
                var total = $('input[name="genre[]"]:checked').length;
                if (total > 1) {
                    $('.label_check').addClass('disabled');
                    $('input[type=checkbox]').attr('disabled', 'true');
                    $('input[type=checkbox]').each(function () {
                        if (this.checked) {
                            $(this).removeAttr("disabled");
                            $(this).parent('label').removeClass('disabled');
                        }
                    });
                } else {
                    $('input[type=checkbox]').removeAttr('disabled');
                    $('.label_check').removeClass('disabled');
                }
            }
            ;
        }
        ;
        $(document).ready(function () {
            $('#addVideo').click(function () {
                video_count++;
                if (video_count > 19) {
                    return;
                }
                var html = '<div class="form-group"><label>Video Title:</label><input type="text" class="form-control" id="" name="title[]"/></div><div class="form-group"><label>YouTube link:</label><input type="text" class="form-control" id="" name="youtube[]"></div><div class="form-group upload"><label>Video image (min size 2mb)</label><span class="btn-file">Upload <input class="file_class" id="youtube_' + (video_count + 2) + '" type="file" name="videoImage[]"></span><span id="youtube_' + (video_count + 2) + '_span" class="file_name"></span></div>';
                $('#outer_video').append(html);
            });
            $('body').addClass('has-js');
            $('.label_check').click(function () {
                setupLabel();
            });
            setupLabel();
            $(document).on('change', '.file_class', function () {
                id = this.id + '_span';
                $('#' + id).html(this.value.replace(/C:\\fakepath\\/i, ''));
            });

        });
    </script>
<?php get_footer(); ?>