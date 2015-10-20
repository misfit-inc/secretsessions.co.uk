<?php
/**
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
require_once('../../../wp-config.php');
global $current_user, $wp_roles, $wpdb;
$limit = $_POST['limit'];
$page = $limit * $_POST['page_artist'];
$field_id = get_cimyFieldValue_fun('SHOW_ON_HOME');
$sql = "SELECT wp_cimy_uef_data.USER_ID FROM wp_cimy_uef_data
								 where wp_cimy_uef_data.FIELD_ID=$field_id and wp_cimy_uef_data.VALUE = 'YES' Limit $page,$limit";
$feature_user_id = $wpdb->get_results($sql);
if (count($feature_user_id) > 0) {
    foreach ($feature_user_id as $id_user) {
        $profile = get_cimyFieldValue($id_user->USER_ID, 'PROFILE_PHOTO');
		if (empty($profile)) continue;
        ?>
        <div class="col-md-3 col-sm-3 col-xs-6 col-md-15">
            <div class="artist_thumb">
				<?php
                $user_url_name	=	get_cimyFieldValue( $id_user->USER_ID , 'URL_NAME' ); 
                if(!empty($user_url_name)){
                    $user_link	=	home_url("artist/$user_url_name");
                }else{
                    $user_link	=	add_query_arg('user_id',$id_user->USER_ID,get_permalink(get_page_by_path('user-profile-view')));
                }
                ?>
                <a href="<?php	echo $user_link; ?>"
                   title="">
                    <span>view artist</span>
                    <?php if (!empty($profile)) { ?>
                        <img src="<?php echo $profile ?>" alt="" class="img-responsive">
                    <?php } else { ?>
                        <img src="<?php echo get_bloginfo('template_url'); ?>/images/Black_blank.jpg"
                             alt="" class="img-responsive">
                    <?php } ?>
                </a>
                <a href="<?php	echo $user_link; ?>"
                   class="title"
                   title=""><?php echo get_cimyFieldValue($id_user->USER_ID, 'NAME'); ?></a>

                <p><?php $genre = get_gener( $id_user->USER_ID );
                                        if ( $genre ) {
                                            echo $genre;
                                        } else {
                                            echo '&nbsp;';
                                        }
                                    ?></p>
                <?php $IS_VARIFIED = get_cimyFieldValue($id_user->USER_ID, 'IS_VARIFIED'); ?>
                <?php if (isset($IS_VARIFIED) && ($IS_VARIFIED == 'YES')) { ?>
                    <span class="verified" id="verified" data-toggle="tooltip" data-placement="top"
                          title="Verified Artist"></span>
                <?php } ?>
            </div>
        </div>
        <?php
        //if($i==4) break;
        $i++;
    }
}