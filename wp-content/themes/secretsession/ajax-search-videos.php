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
$query = "select * from videos order by id desc limit $page,$limit";
if (isset($_POST['search_field']) && (!empty($_POST['search_field']))) {
    $query = $wpdb->prepare("select * from videos  where video_title like '%%%s%%' limit $page,$limit", $_POST['search_field']);
}
if (isset($_POST['genre']) && (!empty($_POST['genre']))) {
    if (strtolower($_POST['genre']) != 'all') {
        $sql = "select id from wp_cimy_uef_fields  where NAME='%s'";
        $genre_id = $wpdb->get_row($wpdb->prepare("$sql ", array(strtoupper($_POST['genre']))));
        $genre_id = $genre_id->id;
        $query = "SELECT * from videos where user_id in (select wp_cimy_uef_data.USER_ID from wp_cimy_uef_data  where FIELD_ID='%d' and `VALUE`= '%s' group by wp_cimy_uef_data.USER_ID ) limit $page,$limit";
        $query = $wpdb->prepare("$query ", array($genre_id, 'YES'));
    }
}
if (isset($_POST['alpha']) && (!empty($_POST['alpha']))) {
    if (strtolower($_POST['alpha']) != 'all') {
        $query = $wpdb->prepare("select * from videos  where video_title like '%s' limit $page,$limit", $_POST['alpha'] . '%');
    }
}
if (isset($_POST['shuffle'])) {
    if (($_POST['shuffle'] == 1)) {
        $not_in = rtrim($_SESSION['not_in'], ',');
        $query = "select * from videos where id not in ('$not_in') order by RAND() limit $page,$limit";
    } else {
        $query = "select * from videos order by video_title ASC limit $page,$limit";
    }
}
$videos = $wpdb->get_results($query);
if (count($videos) > 0) {
                foreach ($videos as $vid) {
                    if (isset($_GET['shuffle']) && ($_GET['shuffle'] == 1)) {
                        $_SESSION['not_in'] .= "$vid->id,";
                    }

                    $url = $vid->video_image;
                    $parts = parse_url($url);
                    $str = $parts['path'];
                    $rootPath = $_SERVER['DOCUMENT_ROOT'];
                    $image_path = $rootPath . $str;
                    $arg1 = pathinfo($image_path);
                    $new_path = $arg1['dirname'] . '/show_video_small_' . $arg1['basename'];
                    if (!file_exists($new_path)) {
                        $params = array(
                            'width' => 380,
                            'height' => 214,
                            'aspect_ratio' => true,
                            'rgb' => '0x000000',
                            'crop' => true
                        );
                        img_resize($image_path, $new_path, $params);
                    }
                    $url_parts = explode('/', $url);
                    $url_count = count($url_parts);
                    $url_parts[$url_count - 1] = 'show_video_small_' . $url_parts[$url_count - 1];
                    $new_image_path = implode("/", $url_parts);

                    ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="video_thumb">
                            <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>"
                               title="">
                                <span>play video</span>
                                <img src="<?php echo $new_image_path ?>" alt="" class="img-responsive">
                            </a>
                            <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>" class="title" title=""><?php
                                    echo character_limiter(stripslashes($vid->video_title),15);
                                ?></a>

                            <p>by
                                <?php
                                if ($vid->user_id != 0) {
                                    ?>
									<?php
                                    $user_url_name	=	get_cimyFieldValue( $vid->user_id , 'URL_NAME' ); 
                                    if(!empty($user_url_name)){
                                        $user_link	=	home_url("artist/$user_url_name");
                                    }else{
                                        $user_link	=	add_query_arg('user_id',$vid->user_id,get_permalink(get_page_by_path('user-profile-view')));
                                    }
                                    ?>
                                    <a href="<?php	echo $user_link; ?>"
                                       class="artist_name" title="">
                                        <?php echo character_limiter(stripslashes(get_cimyFieldValue($vid->user_id, 'NAME')),15); ?>
                                    </a>
                                <?php
                                } else {
                                    ?>
                                    <?php echo character_limiter(stripslashes($vid->ss_artist_name)); ?>
                                <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
            } else {
    echo 1;
}
?>
