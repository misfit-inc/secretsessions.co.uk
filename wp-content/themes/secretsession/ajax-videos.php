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
$IS_VARIFIED = $_POST['IS_VARIFIED'];
$username = $_POST['username'];
$page = 6 * $_POST['page'];
$videos = $wpdb->get_results("select * from videos where user_id=$user_id order by id desc  limit $page,6;");
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
            <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>" title="">
                <span>play video</span>
                <img src="<?php echo $new_image_path; ?>" alt="" class="img-responsive">
            </a>
            <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>" class="title"
               title=""><?php echo stripslashes($vid->video_title) ?></a>

            <p>by <?php echo stripslashes($username); ?></p>
        </div>
    </div>
<?php } ?>

	