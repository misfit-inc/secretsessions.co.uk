<?php
/**
 * Template Name: edit videos
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
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (isset($_GET['delete']) && ($_GET['delete'] != '')) {
    $wpdb->query($wpdb->prepare("DELETE FROM videos WHERE id = %d", $_GET['delete']));
    $redirect_url = explode('?delete', $url);
    $_SESSION['msg'] = 'Video Deleted successfully ';
    wp_redirect($redirect_url[0]);
    exit;
}
if (isset($_POST['video_edit'])) {
    if (!function_exists('wp_handle_upload')) require_once(ABSPATH . 'wp-admin/includes/file.php');
    $error = '';
    $allowed = array('gif', 'png', 'jpg', 'jpeg');
    $post = $_POST;
    $link = $post['link_video'];
    if ($link != '') {
        if (filter_var($link, FILTER_VALIDATE_URL)) {
            $parse = parse_url($link);
            if ($parse['host'] != 'www.youtube.com') {
                $error .= '<p class="error"><b>ERROR</b>:Only youtube url is allowed for video</p>';
            } else {
                $data['video_link'] = $link;
            }
        } else {
            $error .= '<p class="error"><b>ERROR</b>:Only youtube link is allowed for video</p>';
        }
    }
    $video_title = $post['title_video'];
    if ($video_title != '') {
        $data['video_title'] = $video_title;
    }
    if (isset($_FILES['image_video']['name']) && ($_FILES['image_video']['name'] != '')) {
        $filename = $_FILES['image_video']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), $allowed)) {
            $error .= '<p class="error"><b>ERROR</b>:Uploaded file type not allowed.</p>';
        } else {
            $size = $_FILES['image_video']['size'];
            if ($size > 2097152) {
                $error .= '<p class="error"><b>ERROR</b>:Uploaded file is more the 2mb.</p>';
            } else {
                $upload_overrides = array('test_form' => false);
                if ($error == '') {
                    $cover_photo = wp_handle_upload($_FILES['image_video'], $upload_overrides);
                    $data['video_image'] = $cover_photo['url'];
					$url_image = $cover_photo['url'];
					$parts = parse_url($url_image);
					$str = $parts['path'];
					$rootPath = $_SERVER['DOCUMENT_ROOT'];
					$image_path = $rootPath . $str;
					$arg1 = pathinfo($image_path);
					$new_path = $arg1['dirname'] . '/show_video_small_'. $arg1['basename'];
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
                }
            }
        }
    }
    $where['id'] = $post['video_id'];
    $table = 'videos';
    if (isset($data) && ($error == '')) {
        $wpdb->update($table, $data, $where);
        $_SESSION['msg'] = 'Video Updated seccessfully';
        wp_redirect($url);
        exit;
    }
}
$start = 0;
$limit = 20;
if (isset($_GET['pager'])) {
    $id = $_GET['pager'];
    $start = ($id - 1) * $limit;
} else {
    $id = 1;
}
$user_id = $current_user->data->ID;// Get user Id
$videos_count = $wpdb->get_results("SELECT count(*) as total from videos where user_id=$user_id;");
$videos_count = $videos_count[0]->total;
$videos = $wpdb->get_results("select * from videos where user_id=$user_id order by id desc limit $start, $limit");
$rows = $videos_count;
if (count($videos) <= 0) {
	unset($_SESSION['msg']);
    wp_redirect(get_permalink(get_page_by_path('edit-profile')));
    exit;
}

$total = ceil($rows / $limit);
$user = $wpdb->get_results("SELECT wp_cimy_uef_data.*,wp_cimy_uef_fields.NAME FROM wp_cimy_uef_data JOIN wp_cimy_uef_fields ON wp_cimy_uef_fields.ID=wp_cimy_uef_data.FIELD_ID where USER_ID=" . $user_id);
foreach ($user as $key => $val) {
    $user_data[$val->NAME] = $val->VALUE;
}
get_header();
?>
    <!-- wrapper start -->
    <div id="wrapper">
        <!-- artists videos -->
        <div class="featured_videos edit_videos">
            <div class="container">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo '<center><p class="message">' . $_SESSION['msg'] . '</p></center>';
                    unset($_SESSION['msg']);
                }
                echo '<center>' . $error . '</center>';
                ?>
                <h2>Edit Videos
                    <a href="<?php echo get_permalink(get_page_by_path('edit-profile')); ?>" class="back_btn pull-right">Back to edit profile</a>
                </h2>

                <div class="row" id="videos_row">
                    <?php foreach ($videos as $vid) { 

                    $image_url = $vid->video_image;
                    $parts = parse_url($image_url);
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
                    $url_parts = explode('/', $image_url);
                    $url_count = count($url_parts);
                    $url_parts[$url_count - 1] = 'show_video_small_'.$url_parts[$url_count - 1];
                    $new_image_path = implode("/", $url_parts);
					?>
                        <form action="<?php echo $url; ?>" method="post" enctype="multipart/form-data"
                              id="edit_video_form_<?php echo $vid->id; ?>">
                            <input type="hidden" name="video_edit"/>
                            <input type="hidden" name="video_id" value="<?php echo $vid->id; ?>"/>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="edit_video_thumb">
                                    <img src="<?php echo $new_image_path; ?>" alt=""
                                         class="img-responsive">
                                    <input type="text" class="form-control" name="title_video"
                                           value="<?php echo $vid->video_title ?>"/>
                                    <input type="text" class="form-control" name="link_video"
                                           value="<?php echo $vid->video_link ?>"/>

                                    <div class="upload_image">
                                <span class="btn-file">
                                    Upload image <input type="file" id="image_<?php echo $vid->id; ?>"
                                                        class="file_class" name="image_video">
                                </span><span id="image_<?php echo $vid->id; ?>_span" class="file_name"></span>
                                    </div>
                                    <div class="button_group">
                                    
                                    
                                        <a onClick="if(confirm('Are you sure you want to delete the video?')) window.location = '<?php echo add_query_arg('delete', $vid->id, $url); ?>';"
                                           href="javascript:void(0);">
                                            <button type="button" class="btn_publish">Delete video</button>
                                        </a>
                                        <button type="submit" id="<?php echo $vid->id ?>" class="btn_save video_edit">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
                <!-- pagination -->
                <ul class="pagination_videos pull-right">
                    <?php
                    for ($i = 1; $i <= $total; $i++) {
                        if ($i == $id) {
                            echo "<li><a class='active' href='#'>" . $i . "</a></li>";
                        } else {
                            echo '<li><a href="' . get_permalink(72) . '&pager=' . $i . '">' . $i . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- wrapper end -->
    <script>
        $(document).ready(function () {
            $(document).on('change', '.file_class', function () {
                id = this.id + '_span';
                $('#' + id).html(this.value.replace(/C:\\fakepath\\/i, ''));
            });


            /*		$('.video_edit').on('click',function(){
             id	=	this.id;
             $('#checkbox_'+id).prop('checked', true);
             $( "#edit_video_form" ).submit();
             });
             */
        });
    </script>

<?php get_footer(); ?>