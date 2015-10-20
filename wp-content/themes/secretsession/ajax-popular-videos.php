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
$user_id = $_POST['user_id'];
$limit = $_POST['limit'];
$page = $limit * $_POST['page'];
if ($user_id == 0) {
    $ss_data_query = 'SELECT * from secretsession';
    $ss_data = $wpdb->get_row($ss_data_query);
    if ($ss_data) {
        $ss_name = $ss_data->name;
        $ss_image = $ss_data->image_url;
    } else {
        $ss_name = 'Secret Session';
        $ss_image = get_bloginfo('template_url') . '/images/ss_logo.jpg';
    }
}
$videos = $wpdb->get_results("SELECT videos.*,(select count(*) from video_like where video_like.video_id = videos.id) as likes FROM videos where videos.is_admin_added=1 order by likes desc limit $page, $limit");
foreach ($videos as $vid) {
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
               title="show video">
                <span>play video</span>
                <img src="<?php echo $new_image_path; ?>" alt="" class="img-responsive">
            </a>
            <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>" class="title"
               title="">
                <?php
                if (strlen($vid->video_title) > 30)
                    echo stripslashes(substr($vid->video_title, 0, 30)) . '...';
                else
                    echo stripslashes($vid->video_title);
                ?>
            </a>
            <p>by
				<?php
                    if ( $vid->user_id != 0 ) {
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
                            <?php echo stripslashes(get_cimyFieldValue( $vid->user_id , 'NAME' )); ?>
                        </a>
                    <?php
                    } else {
                        ?>
                        <?php echo stripslashes($vid->ss_artist_name); ?>
                    <?php
                    }
                ?>
            </p>
        </div>
    </div>
<?php
}
?>

	