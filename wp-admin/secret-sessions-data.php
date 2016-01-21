<?php
    /**
     * Dashboard Administration Screen
     *
     * @package    WordPress
     * @subpackage Administration
     * @author     "shakirblouch <shakirblouch@putitout.co.uk> "
     *
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
    $parent_file = 'secret-sessions.php';

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
    $ss_data_query = 'SELECT * from secretsession';
    $ss_data = $wpdb->get_row( $ss_data_query );
    if ( isset( $_POST[ 'title' ] ) ) {
		$allowed = array ( 'gif' , 'png' , 'jpg' , 'jpeg' );
		$_POST	=	sanitize($_POST);
        $title = $_POST[ 'title' ];
        $ss_video = $_POST[ 'ss_video' ];
        $static_dynamic = $_POST[ 'static_dynamic' ];
        if ( empty( $title ) ) {
            $error .= '<p class="error"><b>ERROR</b>:Secret sessions title is required.</p>';
        }
        if ( empty( $ss_video ) ) {
            $error .= '<p class="error"><b>ERROR</b>:You tube video url is required.</p>';
        }else{
			if ( filter_var( $ss_video , FILTER_VALIDATE_URL ) ) {
				$parse = parse_url( $ss_video );
				if ( $parse[ 'host' ] != 'www.youtube.com' ) {
					$error .= '<p class="error"><b>ERROR</b>:Only youtube url is allowed for video</p>';
				}
			} else {
				$error .= '<p class="error"><b>ERROR</b>:Only youtube link is allowed for video</p>';
			}
		}
        if ( count( $ss_data ) == 0 ) {
            if ( empty( $_FILES[ 'videoImage' ][ 'name' ] ) ) {
                $error .= '<p class="error"><b>ERROR</b>:secret sessions image is required.</p>';
            } else {
                $size = $_FILES[ 'videoImage' ][ 'size' ];
                if ( $size > 2097152 ) {
                    $error .= '<p class="error"><b>ERROR</b>:Uploaded file is more the 2mb.</p>';
                }
            }
            if ( empty( $_FILES[ 'desktop_image' ][ 'name' ] ) ) {
                $error .= '<p class="error"><b>ERROR</b>:Desktop image for home page is required.</p>';
            }else{
				$filename = $_FILES[ 'desktop_image' ][ 'tmp_name' ];
				list( $width , $height ) = getimagesize( $filename );
				$filename = $_FILES[ 'desktop_image' ][ 'name' ];
				$ext = pathinfo( $filename , PATHINFO_EXTENSION );
				if ( ! in_array( strtolower( $ext ) , $allowed ) ) {
					$error .= '<p class="error"><b>ERROR</b>:Uploaded file type not allowed.</p>';
				} elseif ( $width < 1300 ) {
					$error .= '<p class="error"><b>ERROR</b>:your image needs to be at least 1300 pixels wide.</p>';
				}
			}
            if ( empty( $_FILES[ 'tablet_image' ][ 'name' ] ) ) {
                $error .= '<p class="error"><b>ERROR</b>:Tablet image for home page is required.</p>';
            }else{
				$filename = $_FILES[ 'tablet_image' ][ 'tmp_name' ];
				list( $width , $height ) = getimagesize( $filename );
				$filename = $_FILES[ 'tablet_image' ][ 'name' ];
				$ext = pathinfo( $filename , PATHINFO_EXTENSION );
				if ( ! in_array( strtolower( $ext ) , $allowed ) ) {
					$error .= '<p class="error"><b>ERROR</b>:Uploaded file type not allowed.</p>';
				} elseif ( $width < 900 ) {
					$error .= '<p class="error"><b>ERROR</b>:your image needs to be at least 900 pixels wide.</p>';
				}
			}
            if ( empty( $_FILES[ 'mobile_image' ][ 'name' ] ) ) {
                $error .= '<p class="error"><b>ERROR</b>:Mobile image for home page is required.</p>';
            }else{
				$filename = $_FILES[ 'mobile_image' ][ 'tmp_name' ];
				list( $width , $height ) = getimagesize( $filename );
				$filename = $_FILES[ 'mobile_image' ][ 'name' ];
				$ext = pathinfo( $filename , PATHINFO_EXTENSION );
				if ( ! in_array( strtolower( $ext ) , $allowed ) ) {
					$error .= '<p class="error"><b>ERROR</b>:Uploaded file type not allowed.</p>';
				} elseif ( $width < 320 ) {
					$error .= '<p class="error"><b>ERROR</b>:your image needs to be at least 400 pixels wide.</p>';
				}
			}
	    }

        if ( empty( $error ) ) {
            $values = array ();
            $time = time();
            if ( ! empty( $_FILES[ 'videoImage' ][ 'name' ] ) ) {
                $upload_overrides = array ( 'test_form' => FALSE );
                $uploadedfile[ 'name' ] = $_FILES[ 'videoImage' ][ 'name' ];
                $uploadedfile[ 'type' ] = $_FILES[ 'videoImage' ][ 'type' ];
                $uploadedfile[ 'tmp_name' ] = $_FILES[ 'videoImage' ][ 'tmp_name' ];
                $uploadedfile[ 'error' ] = $_FILES[ 'videoImage' ][ 'error' ];
                $uploadedfile[ 'size' ] = $_FILES[ 'videoImage' ][ 'size' ];
                $ss_image = wp_handle_upload( $uploadedfile , $upload_overrides );
                $url = $ss_image[ 'url' ];
                $parts = parse_url( $url );
                $str = $parts[ 'path' ];
                $rootPath = $_SERVER[ 'DOCUMENT_ROOT' ];
                $image_path = $rootPath . $str;
                $arg1 = pathinfo( $image_path );
                $new_path = $arg1[ 'dirname' ] . '/secret_session_small_' . $arg1[ 'basename' ];
                if ( ! file_exists( $new_path ) ) {
                    $params = array ( 'width' => 220 , 'height' => 220 , 'aspect_ratio' => true , 'rgb' => '0x000000' , 'crop' => true );
                    img_resize( $image_path , $new_path , $params );
                }
                $pars_url = parse_url( $ss_image[ 'url' ] );
                $pars_name = pathinfo( $pars_url[ 'path' ] );
                $ss_save_image = $pars_url[ 'scheme' ] . '://' . $pars_url[ 'host' ] . $pars_name[ 'dirname' ] . '/secret_session_small_' . $pars_name[ 'basename' ];
                $data_array[ 'image_url' ] = $ss_save_image;
                $data_array[ 'image_path' ] = $ss_image[ 'file' ];
            }

            if ( ! empty( $_FILES[ 'desktop_image' ][ 'name' ] ) ) {
                $upload_overrides = array ( 'test_form' => FALSE );
                $uploadedfile[ 'name' ] = $_FILES[ 'desktop_image' ][ 'name' ];
                $uploadedfile[ 'type' ] = $_FILES[ 'desktop_image' ][ 'type' ];
                $uploadedfile[ 'tmp_name' ] = $_FILES[ 'desktop_image' ][ 'tmp_name' ];
                $uploadedfile[ 'error' ] = $_FILES[ 'desktop_image' ][ 'error' ];
                $uploadedfile[ 'size' ] = $_FILES[ 'desktop_image' ][ 'size' ];
                $desktop_image = wp_handle_upload( $uploadedfile , $upload_overrides );
                $url = $desktop_image[ 'url' ];
                $parts = parse_url( $url );
                $str = $parts[ 'path' ];
                $rootPath = $_SERVER[ 'DOCUMENT_ROOT' ];
                $image_path = $rootPath . $str;
                $arg1 = pathinfo( $image_path );
                $new_path = $arg1[ 'dirname' ] . '/secret_session_small_' . $arg1[ 'basename' ];
                if ( ! file_exists( $new_path ) ) {
                    $params = array ( 'width' => 1263 , 'height' => 712 , 'aspect_ratio' => true , 'rgb' => '0x000000' , 'crop' => true );
                    img_resize( $image_path , $new_path , $params );
                }
                $pars_url = parse_url( $desktop_image[ 'url' ] );
                $pars_name = pathinfo( $pars_url[ 'path' ] );
                $desktop_save_image = $pars_url[ 'scheme' ] . '://' . $pars_url[ 'host' ] . $pars_name[ 'dirname' ] . '/secret_session_small_' . $pars_name[ 'basename' ];
                $data_array[ 'desktop_image_url' ] = $desktop_save_image;
                $data_array[ 'desktop_image_path' ] = $desktop_image[ 'file' ];
            }

            if ( ! empty( $_FILES[ 'tablet_image' ][ 'name' ] ) ) {
                $upload_overrides = array ( 'test_form' => FALSE );
                $uploadedfile[ 'name' ] = $_FILES[ 'tablet_image' ][ 'name' ];
                $uploadedfile[ 'type' ] = $_FILES[ 'tablet_image' ][ 'type' ];
                $uploadedfile[ 'tmp_name' ] = $_FILES[ 'tablet_image' ][ 'tmp_name' ];
                $uploadedfile[ 'error' ] = $_FILES[ 'tablet_image' ][ 'error' ];
                $uploadedfile[ 'size' ] = $_FILES[ 'tablet_image' ][ 'size' ];
               $tablet_image = wp_handle_upload( $uploadedfile , $upload_overrides );
                $url =$tablet_image[ 'url' ];
                $parts = parse_url( $url );
                $str = $parts[ 'path' ];
                $rootPath = $_SERVER[ 'DOCUMENT_ROOT' ];
                $image_path = $rootPath . $str;
                $arg1 = pathinfo( $image_path );
                $new_path = $arg1[ 'dirname' ] . '/secret_session_small_' . $arg1[ 'basename' ];
                if ( ! file_exists( $new_path ) ) {
                    $params = array ( 'width' => 860 , 'height' => 645 , 'aspect_ratio' => true , 'rgb' => '0x000000' , 'crop' => true );
                    img_resize( $image_path , $new_path , $params );
                }
                $pars_url = parse_url($tablet_image[ 'url' ] );
                $pars_name = pathinfo( $pars_url[ 'path' ] );
                $tablet_save_image = $pars_url[ 'scheme' ] . '://' . $pars_url[ 'host' ] . $pars_name[ 'dirname' ] . '/secret_session_small_' . $pars_name[ 'basename' ];
                $data_array[ 'tablet_image_url' ] = $tablet_save_image;
                $data_array[ 'tablet_image_path' ] =$tablet_image[ 'file' ];
            }

            if ( ! empty( $_FILES[ 'mobile_image' ][ 'name' ] ) ) {
                $upload_overrides = array ( 'test_form' => FALSE );
                $uploadedfile[ 'name' ] = $_FILES[ 'mobile_image' ][ 'name' ];
                $uploadedfile[ 'type' ] = $_FILES[ 'mobile_image' ][ 'type' ];
                $uploadedfile[ 'tmp_name' ] = $_FILES[ 'mobile_image' ][ 'tmp_name' ];
                $uploadedfile[ 'error' ] = $_FILES[ 'mobile_image' ][ 'error' ];
                $uploadedfile[ 'size' ] = $_FILES[ 'mobile_image' ][ 'size' ];
                $mobile_image = wp_handle_upload( $uploadedfile , $upload_overrides );
                $url = $mobile_image[ 'url' ];
                $parts = parse_url( $url );
                $str = $parts[ 'path' ];
                $rootPath = $_SERVER[ 'DOCUMENT_ROOT' ];
                $image_path = $rootPath . $str;
                $arg1 = pathinfo( $image_path );
                $new_path = $arg1[ 'dirname' ] . '/secret_session_small_' . $arg1[ 'basename' ];
                if ( ! file_exists( $new_path ) ) {
                    $params = array ( 'width' => 320 , 'height' => 361 , 'aspect_ratio' => true , 'rgb' => '0x000000' , 'crop' => true );
                    img_resize( $image_path , $new_path , $params );
                }
                $pars_url = parse_url( $mobile_image[ 'url' ] );
                $pars_name = pathinfo( $pars_url[ 'path' ] );
                $mobile_save_image = $pars_url[ 'scheme' ] . '://' . $pars_url[ 'host' ] . $pars_name[ 'dirname' ] . '/secret_session_small_' . $pars_name[ 'basename' ];
                $data_array[ 'mobile_image_url' ] = $mobile_save_image;
                $data_array[ 'mobile_image_path' ] = $mobile_image[ 'file' ];
            }

            if ( count( $ss_data ) > 0 ) {
                $table = "secretsession";
                $data_array[ 'name' ] = $title;
                $data_array[ 'timedate' ] = $time;
                $data_array[ 'static_dynamic' ] = $static_dynamic;
                $data_array[ 'ss_video' ] = $ss_video;
                $where = array ( 'id' => $ss_data->id );
                $wpdb->update( $table , $data_array , $where );
            } else {
                $query = "INSERT INTO secretsession (name, image_url,image_path,desktop_image_url,desktop_image_path,tablet_image_url,tablet_image_path,mobile_image_url,mobile_image_path,static_dynamic,ss_video,timedate) VALUES
						('%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%s','%d')";
                array_push( $values , $title , $ss_save_image , $ss_image[ 'file' ] ,$desktop_save_image , $desktop_image[ 'file' ] ,$tablet_save_image , $tablet_image[ 'file' ] ,$mobile_save_image , $mobile_image[ 'file' ] ,$static_dynamic,$ss_video, time() );
			    $video_query = $wpdb->prepare( "$query " , $values );
                $wpdb->query( $video_query );
            }
            wp_redirect( get_admin_url() . 'secret-sessions-data.php' );
            exit;
        }
    }
    include( ABSPATH . 'wp-admin/admin-header.php' );
?>
    <div class="wrap"><h2>
            Sesret Sessions Data
        </h2>

        <form action="" method="post" name="createuser" id="createuser" class="validate" novalidate="novalidate"
              enctype="multipart/form-data">
            <?php
                if ( count( $ss_data ) > 0 ) {
                    $ss_title = $ss_data->name;
                    $ss_video = $ss_data->ss_video;
                    $ss_image = $ss_data->image_url;
                    $ss_desktop_image = $ss_data->desktop_image_url;
                    $ss_tablet_image = $ss_data->tablet_image_url;
                    $ss_mobile_image = $ss_data->mobile_image_url;
                    $ss_video_flag	= $ss_data->static_dynamic;
                } else {
                    $ss_title = '';
                    $ss_image = '';
                    $ss_video = '';
                    $ss_desktop_image = '';
                    $ss_tablet_image = '';
                    $ss_mobile_image = '';
                    $ss_video_flag = 0;
                }
				if(isset($_POST['satic_dynamic'])){
                    $ss_video_flag = $_POST['satic_dynamic'];
				}
            ?>
            <table class="form-table">
                <tbody>
                <tr class="form-field form-required">
                    <th scope="row">&nbsp;</th>
                    <td><?php echo '<p>' . @$error . '</p>'; ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="user_login">Secret sessions name <span
                                class="description">(required)</span></label></th>
                    <td><input name="title" type="text" id="user_login"
                               value="<?php if ( isset( $_POST[ 'title' ] ) ) echo $_POST[ 'title' ]; else echo stripslashes($ss_title); ?>"
                               aria-required="true"></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><label for="first_name">secret sessions image (Max size 2mb) </label></th>
                    <td><input name="videoImage" type="file" id="first_name" value=""></td>
                </tr>
                <?php
                    if ( ! empty( $ss_image ) ) {
                        ?>
                        <tr class="form-field">
                            <th scope="row">&nbsp;</th>
                            <td><img src="<?php echo $ss_image ?>"/></td>
                        </tr>
                    <?php } ?>

                <tr class="form-field">
                    <th scope="row"><label for="desktop_image">Home Static image for desktop (Max size 2mb least 1300 pixels wide) </label></th>
                    <td><input name="desktop_image" type="file" id="first_name" value=""></td>
                </tr>
                <?php
                    if ( ! empty( $ss_desktop_image ) ) {
                        ?>
                        <tr class="form-field">
                            <th scope="row">&nbsp;</th>
                            <td><img width="30%" src="<?php echo $ss_desktop_image ?>"/></td>
                        </tr>
                    <?php } ?>
                <tr class="form-field">
                    <th scope="row"><label for="tablet_image">Home Static image for Tablet (Max size 2mb least 900 pixels wide) </label></th>
                    <td><input name="tablet_image" type="file" id="first_name" value=""></td>
                </tr>
                <?php
                    if ( ! empty( $ss_tablet_image ) ) {
                        ?>
                        <tr class="form-field">
                            <th scope="row">&nbsp;</th>
                            <td><img src="<?php echo $ss_tablet_image ?>"/></td>
                        </tr>
                    <?php } ?>

                <tr class="form-field">
                    <th scope="row"><label for="mobile_image">Home Static image for mobile (Max size 2mb least 400 pixels wide) </label></th>
                    <td><input name="mobile_image" type="file" id="first_name" value=""></td>
                </tr>
                <?php
                    if ( ! empty( $ss_mobile_image ) ) {
                        ?>
                        <tr class="form-field">
                            <th scope="row">&nbsp;</th>
                            <td><img src="<?php echo $ss_mobile_image ?>"/></td>
                        </tr>
                    <?php } ?>
                <tr class="form-field">
                    <th scope="row"><label for="ss_video">Home Video </label></th>
                    <td><input name="ss_video" type="text" id="user_login"
                               value="<?php if ( isset( $_POST[ 'ss_video' ] ) ) echo $_POST[ 'ss_video' ]; else echo $ss_video; ?>"
                               aria-required="true"></td>
                </tr>
                <tr class="">
                    <th scope="row"><label for="first_name">Home spining images </label></th>
                    <td>
                    	<label for="static_dynamic">Static </label>
                        <input type="radio" value="0" name="static_dynamic" <?php if($ss_video_flag==0){ ?> checked="checked" <?php } ?>/>
                    	<label for="static_dynamic">Dynamic</label>
                        <input type="radio" value="1" name="static_dynamic" <?php if($ss_video_flag==1){ ?> checked="checked" <?php } ?> />
                        <label for="static_dynamic">Slider</label>
                        <input type="radio" value="2" name="static_dynamic" <?php if($ss_video_flag==2){ ?> checked="checked" <?php } ?> />
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary"
                                     value="Update"></p>
        </form>
    </div>

<?php
    require( ABSPATH . 'wp-admin/admin-footer.php' );
