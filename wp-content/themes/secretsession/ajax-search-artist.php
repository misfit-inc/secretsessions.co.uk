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
$page = $_POST['page'] * $limit;


//$query = "select ID as USER_ID from wp_users order by ID desc limit $page,$limit";
		$profile_field_id = get_field_id('PROFILE_PHOTO');
		$query            = "select wp_users.ID as USER_ID from wp_users JOIN wp_cimy_uef_data ON wp_users.ID = wp_cimy_uef_data.USER_ID where FIELD_ID=$profile_field_id and VALUE!=''  order by wp_users.ID desc limit $page,$limit";

if (isset($_POST['search_field']) && (!empty($_POST['search_field']))) {
    $field_id = get_field_id('NAME');
    $query = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID=$field_id and VALUE like '%%%s%%' limit $page,$limit", $_POST['search_field']);
}
if (isset($_POST['genre']) && (!empty($_POST['genre']))) {
    if (strtolower($_POST['genre']) != 'all') {
        $field_id = get_field_id($_POST['genre']);
        $query = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID='%d' and VALUE='YES' limit $page,$limit", strtoupper($field_id));
    }
}
if (isset($_POST['alpha']) && (!empty($_POST['alpha']))) {
    if (strtolower($_POST['alpha']) != 'all') {
        $field_id = get_field_id('NAME');
        $query = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID=$field_id and VALUE like '%s' limit $page,$limit", $_POST['alpha'] . '%');
    }
}
if (isset($_POST['shuffle'])) {
    if (($_POST['shuffle'] == 1)) {
        $not_in = rtrim($_SESSION['not_in'], ',');
//        $query = "select id as USER_ID from wp_users where id not in ('$not_in') order by RAND() limit $page,$limit";
			$query  = "select wp_users.ID as USER_ID from wp_users JOIN wp_cimy_uef_data ON wp_users.ID = wp_cimy_uef_data.USER_ID where FIELD_ID=$profile_field_id and VALUE!='' and wp_users.id not in ('$not_in') order by RAND() limit $page,$limit";

    } else {
        $field_id = get_field_id('NAME');
        $query = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID='%d' order by VALUE ASC limit $page,$limit", $field_id);

    }
}
$artsits = $wpdb->get_results($query); ?>



<?php $i = 0;
if (count($artsits) > 0) {
    foreach ($artsits as $id_user) {
        $profile = get_cimyFieldValue($id_user->USER_ID, 'PROFILE_PHOTO');
		if (empty($profile)) continue;
        $_SESSION['not_in'] .= "$id_user->USER_ID,";
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
                        <img src="<?php echo get_bloginfo('template_url'); ?>/images/Black_blank.jpg" alt=""
                             class="img-responsive">
                    <?php } ?>
                </a>
				<?php
                $user_url_name	=	get_cimyFieldValue( $id_user->USER_ID , 'URL_NAME' ); 
                if(!empty($user_url_name)){
                    $user_link	=	home_url("artist/$user_url_name");
                }else{
                    $user_link	=	add_query_arg('user_id',$id_user->USER_ID,get_permalink(get_page_by_path('user-profile-view')));
                }
                ?>
                <a href="<?php	echo $user_link; ?>"
                   class="title" title="view profile">
                    <?php echo get_cimyFieldValue($id_user->USER_ID, 'NAME') ?>
                </a>

                <p><?php echo get_gener($id_user->USER_ID) ?></p>
            </div>
        </div>
    <?php
    }
} else {
    echo 1;
}