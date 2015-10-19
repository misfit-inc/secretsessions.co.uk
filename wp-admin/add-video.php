<?php
    /**
     * Dashboard Administration Screen
     *
     * @package    WordPress
     * @subpackage Administration
     */

    /** Load WordPress Bootstrap */
    require_once( dirname( __FILE__ ) . '/admin.php' );

    /** Load WordPress dashboard API */

    wp_enqueue_script( 'dashboard' );
    if ( current_user_can( 'edit_theme_options' ) ) wp_enqueue_script( 'customize-loader' );
    if ( current_user_can( 'install_plugins' ) ) wp_enqueue_script( 'plugin-install' );
    if ( current_user_can( 'upload_files' ) ) wp_enqueue_script( 'media-upload' );
    add_thickbox();

    if ( wp_is_mobile() ) wp_enqueue_script( 'jquery-touch-punch' );
    $title = __( 'Videos' );
    $parent_file = 'Videos.php';

    $help = '<p>' . __( 'Welcome to your WordPress Dashboard! This is the screen you will see when you log in to your site, and gives you access to all the site management features of WordPress. You can get help for any screen by clicking the Help tab in the upper corner.' ) . '</p>';
// Not using chaining here, so as to be parseable by PHP4.
    $screen = get_current_screen();
    $screen->add_help_tab( array ( 'id' => 'overview' , 'title' => __( 'Overview' ) , 'content' => $help , ) );

// Help tabs

    $help = '<p>' . __( 'The left-hand navigation menu provides links to all of the WordPress administration screens, with submenu items displayed on hover. You can minimize this menu to a narrow icon strip by clicking on the Collapse Menu arrow at the bottom.' ) . '</p>';
    $help .= '<p>' . __( 'Links in the Toolbar at the top of the screen connect your dashboard and the front end of your site, and provide access to your profile and helpful WordPress information.' ) . '</p>';

    $screen->add_help_tab( array ( 'id' => 'help-navigation' , 'title' => __( 'Navigation' ) , 'content' => $help , ) );

    $help = '<p>' . __( 'You can use the following controls to arrange your Dashboard screen to suit your workflow. This is true on most other administration screens as well.' ) . '</p>';
    $help .= '<p>' . __( '<strong>Screen Options</strong> - Use the Screen Options tab to choose which Dashboard boxes to show.' ) . '</p>';
    $help .= '<p>' . __( '<strong>Drag and Drop</strong> - To rearrange the boxes, drag and drop by clicking on the title bar of the selected box and releasing when you see a gray dotted-line rectangle appear in the location you want to place the box.' ) . '</p>';
    $help .= '<p>' . __( '<strong>Box Controls</strong> - Click the title bar of the box to expand or collapse it. Some boxes added by plugins may have configurable content, and will show a &#8220;Configure&#8221; link in the title bar if you hover over it.' ) . '</p>';

    $screen->add_help_tab( array ( 'id' => 'help-layout' , 'title' => __( 'Layout' ) , 'content' => $help , ) );

    $help = '<p>' . __( 'The boxes on your Dashboard screen are:' ) . '</p>';
    if ( current_user_can( 'edit_posts' ) ) $help .= '<p>' . __( '<strong>At A Glance</strong> - Displays a summary of the content on your site and identifies which theme and version of WordPress you are using.' ) . '</p>';
    $help .= '<p>' . __( '<strong>Activity</strong> - Shows the upcoming scheduled posts, recently published posts, and the most recent comments on your posts and allows you to moderate them.' ) . '</p>';
    if ( is_blog_admin() && current_user_can( 'edit_posts' ) ) $help .= '<p>' . __( "<strong>Quick Draft</strong> - Allows you to create a new post and save it as a draft. Also displays links to the 5 most recent draft posts you've started." ) . '</p>';
    if ( ! is_multisite() && current_user_can( 'install_plugins' ) ) $help .= '<p>' . __( '<strong>WordPress News</strong> - Latest news from the official WordPress project, the <a href="https://planet.wordpress.org/">WordPress Planet</a>, and popular and recent plugins.' ) . '</p>'; else
        $help .= '<p>' . __( '<strong>WordPress News</strong> - Latest news from the official WordPress project, the <a href="https://planet.wordpress.org/">WordPress Planet</a>.' ) . '</p>';
    if ( current_user_can( 'edit_theme_options' ) ) $help .= '<p>' . __( '<strong>Welcome</strong> - Shows links for some of the most common tasks when setting up a new site.' ) . '</p>';

    $screen->add_help_tab( array ( 'id' => 'help-content' , 'title' => __( 'Content' ) , 'content' => $help , ) );

    unset( $help );

    $screen->set_help_sidebar( '<p><strong>' . __( 'For more information:' ) . '</strong></p>' . '<p>' . __( '<a href="http://codex.wordpress.org/Dashboard_Screen" target="_blank">Documentation on Dashboard</a>' ) . '</p>' . '<p>' . __( '<a href="https://wordpress.org/support/" target="_blank">Support Forums</a>' ) . '</p>' );
    $error = '';
    $args = array ( 'blog_id' => $GLOBALS[ 'blog_id' ] , 'role' => '' , 'meta_key' => '' , 'meta_value' => '' , 'meta_compare' => '' , 'meta_query' => array () , 'include' => array () , 'exclude' => array () , 'orderby' => 'login' , 'order' => 'ASC' , 'offset' => '' , 'search' => '' , 'number' => '' , 'count_total' => FALSE , 'fields' => 'ID	' , 'who' => '' );
    $users_ids = get_users( $args );
    if ( isset( $_POST[ 'youtube' ] ) ) {
        $link 			=	$_POST[ 'youtube' ];
        $title			=	$_POST[ 'title' ];
        $user_id_select	=	$_POST[ 'user' ];
        $ss_artist_name = $_POST[ 'artist_name' ];
        if ( empty( $link ) ) {
            $error .= '<p class="error"><b>ERROR</b>:Video link is required for all the videos.</p>';
        }
        if ( empty( $ss_artist_name ) && ( $user_name === 0 ) ) {
            $error .= '<p class="error"><b>ERROR</b>:Artist name is required for all the videos.</p>';
        }
        if ( empty( $title ) ) {
            $error .= '<p class="error"><b>ERROR</b>:Video title is required for all the videos.</p>';
        }
        if ( empty( $_FILES[ 'videoImage' ][ 'name' ] ) ) {
            $error .= '<p class="error"><b>ERROR</b>:Video image is required for all the videos.</p>';
        } else {
            $size = $_FILES[ 'videoImage' ][ 'size' ];
            if ( $size > 2097152 ) {
                $error .= '<p class="error"><b>ERROR</b>:Uploaded file is more the 2mb.</p>';
            }
        }
        if ( filter_var( $link , FILTER_VALIDATE_URL ) ) {
            $parse = parse_url( $link );
            if ( $parse[ 'host' ] != 'www.youtube.com' ) {
                $error .= '<p class="error"><b>ERROR</b>:Only youtube url is allowed for video</p>';
            }
        } else {
            $error .= '<p class="error"><b>ERROR</b>:Only youtube link is allowed for video</p>';
        }
        if ( empty( $error ) ) {
            $values = array ();
            $time = time();
            $upload_overrides = array ( 'test_form' => FALSE );
            $uploadedfile[ 'name' ] = $_FILES[ 'videoImage' ][ 'name' ];
            $uploadedfile[ 'type' ] = $_FILES[ 'videoImage' ][ 'type' ];
            $uploadedfile[ 'tmp_name' ] = $_FILES[ 'videoImage' ][ 'tmp_name' ];
            $uploadedfile[ 'error' ] = $_FILES[ 'videoImage' ][ 'error' ];
            $uploadedfile[ 'size' ] = $_FILES[ 'videoImage' ][ 'size' ];
            $video_image = wp_handle_upload( $uploadedfile , $upload_overrides );
            $url = $video_image[ 'url' ];
            $parts = parse_url( $url );
            $str = $parts[ 'path' ];
            $rootPath = $_SERVER[ 'DOCUMENT_ROOT' ];
            $image_path = $rootPath . $str;
            $arg1 = pathinfo( $image_path );
            $new_path = $arg1[ 'dirname' ] . '/show_video_small_' . $arg1[ 'basename' ];
            if ( ! file_exists( $new_path ) ) {
                $params = array ( 'width' => 380 , 'height' => 214 , 'aspect_ratio' => TRUE , 'rgb' => '0x000000' , 'crop' => TRUE );
                img_resize( $image_path , $new_path , $params );
            }
            $video[ 'title' ] = $title;
            $video[ 'link' ] = $link;
            $video[ 'image' ] = $video_image[ 'url' ];
            $video[ 'image_path' ] = $video_image[ 'file' ];
            $query = "INSERT INTO videos (user_id, video_link, video_image,video_title,image_path,is_admin_added,ss_artist_name,timedate) VALUES
					('%d', '%s','%s','%s','%s','%d','%s','%d')";
            array_push( $values , $user_id_select , $link , $video_image[ 'url' ] , $title , $video_image[ 'file' ] , 1 , $ss_artist_name , $time );
            $video_query = $wpdb->prepare( "$query " , $values );
            $wpdb->query( $video_query );
			$_SESSION['msg']	=	'Video successfully added';
            wp_redirect( get_admin_url() . 'secret-sessions.php' );
            exit;
        }
    }
    include( ABSPATH . 'wp-admin/admin-header.php' );
?>
    <div class="wrap"><h2>
            Add video
        </h2>

        <form action="" method="post" name="createuser" id="createuser" class="validate" novalidate="novalidate"
              enctype="multipart/form-data">


            <table class="form-table">
                <tbody>
                <tr class="form-field form-required">
                    <th scope="row">&nbsp;</th>
                    <td><?php echo '<p>' . $error . '</p>'; ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="user_login">Video Tiltle <span
                                class="description">(required)</span></label></th>
                    <td><input name="title" type="text" id="user_login" value="" aria-required="true"></td>
                </tr>
                <tr class="form-field ">
                    <th scope="row"><label for="user_login">Artist Name<span class="description"></span></label></th>
                    <td><input name="artist_name" type="text" id="user_login" value=""></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="email">Youtube link <span class="description">(required)</span></label>
                    </th>
                    <td><input name="youtube" type="text" id="email" value=""></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="email">Select User<span class="description"></span></label></th>
                    <td>
                        <select name="user" id="user">
                            <option value="0">Select user</option>
                            <?php
                                if ( count( $users_ids ) > 0 ) {
                                    foreach ( $users_ids as $id ) {
                                        ?>
                                        <option
                                        value="<?php echo $id ?>"><?php echo character_limiter( get_cimyFieldValue( $id , 'NAME' ) , 15 ); ?></option><?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label for="first_name">Video image (Max size 2mb) </label></th>
                    <td><input name="videoImage" type="file" id="first_name" value=""></td>
                </tr>
                </tbody>
            </table>


            <p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary"
                                     value="Add video "></p>
        </form>
    </div>
<?php
    require( ABSPATH . 'wp-admin/admin-footer.php' );
