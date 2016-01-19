<?php
/*
Template Name: home page 1
 *
 * @package WordPress
 * @subpackage Secret Session
 * @since Secret Session
 */
get_header();
?>

<div id="wrapper">
<?php
$user_limit = 5;
$user_page = 0 * $user_limit;
$video_limit = 3;
$video_page = 0 * $video_limit;
$liked_video_limit = 6;
$liked_video_page = 0 * $video_limit;
$type = 'sescret_session_home';// custom content type
$args = array('post_type' => $type, 'post_status' => 'publish');
$videos = $wpdb->get_results("select * from videos where is_featured=1 order by id desc  limit $video_page,$video_limit;");
$liked_videos = $wpdb->get_results("select * from videos where is_liked=1 order by id desc  limit $liked_video_page,$liked_video_limit;");
$my_query = NULL;
$my_query = new WP_Query($args);//  WP db object



$field_id = get_cimyFieldValue_fun('SHOW_ON_HOME');
$sql = "SELECT wp_cimy_uef_data.USER_ID FROM wp_cimy_uef_data
								 where wp_cimy_uef_data.FIELD_ID=$field_id and wp_cimy_uef_data.VALUE = 'YES' Limit $user_page,$user_limit";
$feature_user_id = $wpdb->get_results($sql);
$sql = "SELECT * FROM secretsession";
$home_images = $wpdb->get_row($sql);
if (count($home_images) > 0) {
    $dynamic_static = $home_images->static_dynamic;
    if ($dynamic_static == 0) {
        $url = $home_images->ss_video; // youtube video link
        parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars); // get video id fro iframe
        $video_id = $my_array_of_vars['v'];// video id
        ?>
        <script src="http://www.youtube.com/player_api"></script>
        <div class="top_watch_area">
            <!-- desktop placeholder -->
            <div class="placeholder_desktop video_placeholder">
                <img id="desktop_image" src="<?php echo $home_images->desktop_image_url; ?>"
                     class="img-responsive" alt="">
            </div>
            <!-- tablet placeholder -->
            <div class="placeholder_tablet video_placeholder">
                <img id="tab_image" src="<?php echo $home_images->tablet_image_url; ?>"
                     class="img-responsive" alt="">
            </div>
            <!-- Mobile placeholder -->
            <div class="placeholder_phone video_placeholder">
                <img id="Mobile_image" src="<?php echo $home_images->mobile_image_url; ?>"
                     class="img-responsive" alt="">
            </div>
            <div class="watch_info">
                <a href="javascript:void(0)" class="watch_btn" title="">watch</a>

                <p class="dtl">A music discovery platform that puts artists and their fans in control. Turning musical talent into industry success.</p>
            </div>
            <div class="play_video_area" id="player">
            </div>
        </div>
    <?php
    } else {
        ?>
        <div id="thumb-grid" class="thumb-grid-hover">
            <ul id="side">
                <?php
                $field_id = get_cimyFieldValue_fun('PROFILE_PHOTO');
                $sql = "SELECT * FROM wp_cimy_uef_data where FIELD_ID=$field_id and VALUE!='' ORDER BY RAND() limit 0,64";
                $profile_images = $wpdb->get_results($sql);
                $i = 0;
                foreach ($profile_images as $artist_image) {
                    if (getimagesize($artist_image->VALUE) !== FALSE) {
                        ?>
                        <?php $i++; ?>
                        <li class="thumb">
                            <?php
                            $user_url_name = get_cimyFieldValue($artist_image->USER_ID, 'URL_NAME');
                            if (!empty($user_url_name)) {
                                $user_link = home_url("artist/$user_url_name");
                            } else {
                                $user_link = add_query_arg('user_id', $artist_image->USER_ID, get_permalink(get_page_by_path('user-profile-view')));
                            }
                            ?>
                            <a id="ac_<?php echo $artist_image->USER_ID . '_' . $i; ?>"
                               href="<?php echo $user_link; ?>">
                                <span id="<?php echo $artist_image->USER_ID . '_' . $i; ?>"
                                      class="spanhide">view artist</span>
                                <img src="<?php echo $artist_image->VALUE; ?>" alt="">
                            </a>
                        </li>
                    <?php
                    
					}
                }
                ?>
            </ul>
        </div>
        <!-- <div class="hero-slider">
            <div class="flexslider">
                <ul class="slides">
                    <?php
                        $query = new WP_Query('post_type=homepage-slides');
                        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full");
                    ?>
                    <li>
                        <div class="image-slide" style="background-image: url(<?php if ($imgsrc[0]) { echo $imgsrc[0]; } else { bloginfo('template_url'); ?>/images/no-image.jpg<?php } ?>);">
                            <div class="hero-text">
                                <h1><?php the_title(); ?></h1>
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </li>
                    <?php endwhile; endif; wp_reset_postdata(); ?>
                </ul>
            </div>    
        </div> -->    
        
    <?php
    }
}
?>

<!-- featured videos -->
<!-- <div class="featured_videos">
    <div class="container">
        <h2 class="">New Videos</h2>

        <div class="row" id="videos_row">
            <?php
            if (count($videos) > 0) {
                foreach ($videos as $vid) {
                    $url = $vid->video_image;
                    $parts = parse_url($url);
                    $str = $parts['path'];
                    $rootPath = $_SERVER['DOCUMENT_ROOT'];
                    $image_path = $rootPath . $str;
                    $arg1 = pathinfo($image_path);
                    $new_path = $arg1['dirname'] . '/show_video_small_' . $arg1['basename'];
                    if (!file_exists($new_path)) {
                        $params = array('width' => 380, 'height' => 214, 'aspect_ratio' => true, 'rgb' => '0x000000', 'crop' => true);
                        img_resize($image_path, $new_path, $params);
                    }
                    $url_parts = explode('/', $url);
                    $url_count = count($url_parts);
                    $url_parts[$url_count - 1] = 'show_video_small_' . $url_parts[$url_count - 1];
                    $new_image_path = implode("/", $url_parts);

                    ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="video_thumb">
                            <a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
                               title="">
                                <span>play video</span>
                                <img src="<?php echo $new_image_path; ?>" alt="" class="img-responsive">
                            </a>
                            <a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
                               class="title" title=""><?php
                                echo stripslashes(character_limiter($vid->video_title, 15));
                                ?></a>

                            <p>by

                                <?php
                                if ($vid->user_id != 0) {
                                    ?>
                                    <?php
                                    $user_url_name = get_cimyFieldValue($vid->user_id, 'URL_NAME');
                                    if (!empty($user_url_name)) {
                                        $user_link = home_url("artist/$user_url_name");
                                    } else {
                                        $user_link = add_query_arg('user_id', $vid->user_id, get_permalink(get_page_by_path('user-profile-view')));
                                    }
                                    ?>
                                    <a href="<?php echo $user_link; ?>"
                                       class="artist_name" title="">
                                        <?php echo stripslashes(character_limiter(get_cimyFieldValue($vid->user_id, 'NAME'), 15)); ?>
                                    </a>
                                <?php
                                } else {
                                    ?>
                                    <?php echo stripslashes(character_limiter($vid->ss_artist_name, 15)); ?>
                                <?php
                                }
                                ?>

                            </p>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <!-- <div class="loader" id="loader"></div>
         <a href="javascript:void(0);" class="show_more" id="show_more">Show more</a>-->
    <!-- </div>
</div>  -->

<!-- selected artists -->
<div class="selected_artists most_share_artist">
    <div class="container">
        <h2 class="">Featured Artists</h2>

        <div class="row fadeInUp" id="more_artist">
            <?php $i = 0;
            if (count($feature_user_id) > 0) {
                foreach ($feature_user_id as $id_user) {
                    $profile = get_cimyFieldValue($id_user->USER_ID, 'PROFILE_PHOTO');
					if (empty($profile)) continue;
                    ?>
                    <div class="col-md-3 col-sm-3 col-xs-6 col-md-15">
                        <div class="artist_thumb">
                            <?php
                            $user_url_name = get_cimyFieldValue($id_user->USER_ID, 'URL_NAME');
                            if (!empty($user_url_name)) {
                                $user_link = home_url("artist/$user_url_name");
                            } else {
                                $user_link = add_query_arg('user_id', $id_user->USER_ID, get_permalink(get_page_by_path('user-profile-view')));
                            }
                            ?>

                            <a href="<?php echo $user_link; ?>"
                               title="">
                                <span>view artist</span>
                                <?php if (!empty($profile)) { ?>
                                    <img src="<?php echo $profile ?>" alt="" class="img-responsive">
                                <?php } else { ?>
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/images/Black_blank.jpg"
                                         alt="" class="img-responsive">
                                <?php } ?>
                            </a>
                            <?php
                            $user_url_name = get_cimyFieldValue($id_user->USER_ID, 'URL_NAME');
                            if (!empty($user_url_name)) {
                                $user_link = home_url("artist/$user_url_name");
                            } else {
                                $user_link = add_query_arg('user_id', $id_user->USER_ID, get_permalink(get_page_by_path('user-profile-view')));
                            }
                            ?>
                            <a href="<?php echo $user_link; ?>"
                               class="title"
                               title=""><?php echo character_limiter(get_cimyFieldValue($id_user->USER_ID, 'NAME'), 15); ?></a>

                            <p><?php $genre = get_gener($id_user->USER_ID);
                                if ($genre) {
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
            ?>
        </div>
        <div class="loader" id="loader_artist"></div>
        <a href="javascript:void(0);" class="show_more" id="show_more_artist">Show more</a>
    </div>
</div>

<!-- news -->
<div class="news">
    <div class="container">
        <h2 class="">News</h2>
        
        <div class="row" id="news_row">
            <?php 
                $query = new WP_Query(
                    array(
                        'post_type' => 'post',
                        'showposts' => 2
                    )
                );
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full");
            ?>
                <div class="news_thumb col-sm-6">
                    <a href="<?php the_permalink(); ?>">
                        <div class="news_image" style="background-image: url(<?php if ($imgsrc[0]) { echo $imgsrc[0]; } else { bloginfo('template_url'); ?>/images/no-image.jpg<?php } ?>);"></div>
                    </a>    

                    <a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br>
                    <span><?php the_time('jS F Y'); ?></span>
                    <p><?php echo excerpt(10); ?></p>

                    <div class="read_more_container">
                        <a class="read_more" href="<?php the_permalink(); ?>">read more</a>
                    </div>
                </div>
            <?php endwhile; endif; wp_reset_postdata(); ?>    
            
        </div>   
        <div class="loader" id="loader_news"></div>
        <a href="javascript:void(0);" class="show_more" id="show_more_news">Show more</a>
    </div>
</div>

<!-- featured videos -->
<div class="featured_videos">
    <div class="container">
        <h2 class="">New Videos</h2>

        <div class="row" id="videos_row">
            <?php
            if (count($videos) > 0) {
                foreach ($videos as $vid) {
                    $url = $vid->video_image;
                    $parts = parse_url($url);
                    $str = $parts['path'];
                    $rootPath = $_SERVER['DOCUMENT_ROOT'];
                    $image_path = $rootPath . $str;
                    $arg1 = pathinfo($image_path);
                    $new_path = $arg1['dirname'] . '/show_video_small_' . $arg1['basename'];
                    if (!file_exists($new_path)) {
                        $params = array('width' => 380, 'height' => 214, 'aspect_ratio' => true, 'rgb' => '0x000000', 'crop' => true);
                        img_resize($image_path, $new_path, $params);
                    }
                    $url_parts = explode('/', $url);
                    $url_count = count($url_parts);
                    $url_parts[$url_count - 1] = 'show_video_small_' . $url_parts[$url_count - 1];
                    $new_image_path = implode("/", $url_parts);

                    ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="video_thumb">
                            <a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
                               title="">
                                <span>play video</span>
                                <img src="<?php echo $new_image_path; ?>" alt="" class="img-responsive">
                            </a>
                            <a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
                               class="title" title=""><?php
                                echo stripslashes(character_limiter($vid->video_title, 15));
                                ?></a>

                            <p>by

                                <?php
                                if ($vid->user_id != 0) {
                                    ?>
                                    <?php
                                    $user_url_name = get_cimyFieldValue($vid->user_id, 'URL_NAME');
                                    if (!empty($user_url_name)) {
                                        $user_link = home_url("artist/$user_url_name");
                                    } else {
                                        $user_link = add_query_arg('user_id', $vid->user_id, get_permalink(get_page_by_path('user-profile-view')));
                                    }
                                    ?>
                                    <a href="<?php echo $user_link; ?>"
                                       class="artist_name" title="">
                                        <?php echo stripslashes(character_limiter(get_cimyFieldValue($vid->user_id, 'NAME'), 15)); ?>
                                    </a>
                                <?php
                                } else {
                                    ?>
                                    <?php echo stripslashes(character_limiter($vid->ss_artist_name, 15)); ?>
                                <?php
                                }
                                ?>

                            </p>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
         <div class="loader" id="loader"></div>
         <a href="javascript:void(0);" class="show_more" id="show_more">Show more</a>
    </div>
</div> 

<!-- featured videos -->
<!-- <div class="featured_videos">
    <div class="container">
        <h2 class="">Most Liked</h2>

        <div class="row" id="liked_videos_row">
            <?php
            if (count($liked_videos) > 0) {
                foreach ($liked_videos as $vid) {
                    $url = $vid->video_image;
                    $parts = parse_url($url);
                    $str = $parts['path'];
                    $rootPath = $_SERVER['DOCUMENT_ROOT'];
                    $image_path = $rootPath . $str;
                    $arg1 = pathinfo($image_path);
                    $new_path = $arg1['dirname'] . '/show_video_small_' . $arg1['basename'];
                    if (!file_exists($new_path)) {
                        $params = array('width' => 380, 'height' => 214, 'aspect_ratio' => true, 'rgb' => '0x000000', 'crop' => true);
                        img_resize($image_path, $new_path, $params);
                    }
                    $url_parts = explode('/', $url);
                    $url_count = count($url_parts);
                    $url_parts[$url_count - 1] = 'show_video_small_' . $url_parts[$url_count - 1];
                    $new_image_path = implode("/", $url_parts);
                    ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="video_thumb">
                            <a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
                               title="">
                                <span>play video</span>
                                <img src="<?php echo $new_image_path; ?>" alt="" class="img-responsive">
                            </a>
                            <a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
                               class="title" title=""><?php
                                if (strlen($vid->video_title) > 30) echo stripslashes(substr($vid->video_title, 0, 30)) . '...'; else
                                    echo stripslashes(character_limiter($vid->video_title, 15));
                                ?></a>

                            <p>by
                                <?php
                                if ($vid->user_id != 0) {
                                    ?>
                                    <?php
                                    $user_url_name = get_cimyFieldValue($vid->user_id, 'URL_NAME');
                                    if (!empty($user_url_name)) {
                                        $user_link = home_url("artist/$user_url_name");
                                    } else {
                                        $user_link = add_query_arg('user_id', $vid->user_id, get_permalink(get_page_by_path('user-profile-view')));
                                    }
                                    ?>
                                    <a href="<?php echo $user_link; ?>"
                                       class="artist_name" title="">
                                        <?php echo stripslashes(character_limiter(get_cimyFieldValue($vid->user_id, 'NAME'), 15)); ?>
                                    </a>
                                <?php
                                } else {
                                    ?>
                                    <?php echo stripslashes(character_limiter($vid->ss_artist_name, 15)); ?>
                                <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <div class="loader" id="liked_loader"></div>
        <a href="javascript:void(0);" class="show_more" id="liked_show_more">Show more</a>
    </div>
</div> -->
</div>
<!-- wrapper end -->
<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/gridrotator.js"></script>
<script>
    //Global variables
    var home_var = { //Fetch form data
        'width': $(window).width(),
        'height': '',
        'page': 1,
        'is_mobile': false,	// detact mobile or tablet variable
    };
    // autoplay video function
    function onPlayerReady(event) {
        if (home_var.is_mobile == false) {
            event.target.playVideo();
        }
    }
    // when video ends or paused
    function onPlayerStateChange(event) {
        if (event.data === 0) {
            // $(".play_video_area").hide(); //When Video ends
        }
        if (event.data === 2) {
            if (home_var.is_mobile == false) {
                //   $(".play_video_area").hide(); //When Video Paused
            }
        }
    }
    // Change ifram width and hieght when window size changed
    function setWidthHight() {
		home_var.width	=	$(window).width();
		home_var.height	=	Math.round((home_var.width/16)*9);
        document.getElementById('player').width = home_var.width;		// changing ifram width
        document.getElementById('player').height = home_var.height// changing ifram hieght
    }
    // when window resize
    $(document).ready(function () {
        <?php
    if(count($home_images)>0){
            $dynamic_static		=	$home_images->static_dynamic;
            if($dynamic_static==0){ ?>
        $(window).resize(function () {
            setWidthHight();
        });
        // when click on watch button to palay the video
        $('.watch_btn').click(function () {
            $(".play_video_area").show();		// Show video ifram
			$(".video_placeholder").hide();	// Show video ifram
			$(".watch_info").remove();		// Show video ifram
			setTimeout( function() { $(".top_watch_area").css("background", "#f5f0f0"); }, 2000);
			

            // You tube object for ifram
			home_var.height	=	Math.round((home_var.width/16)*9);
            player = new YT.Player('player', {
                height: home_var.height,
                width: home_var.width,
                enablejsapi: 1,
                origin: '<?php echo home_url();?>',
                playerVars: {'autoplay': 1, 'rel': 0, 'modestbranding': 1, 'showinfo': 0, 'fs': 1},
                videoId: '<?php echo $video_id;?>',
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });// end of object
        });
        <?php }else{
        ?>
        jQuery('#thumb-grid').gridrotator({
            rows: 4,
            columns: 8,
            animType: 'fadeInOut',
            interval: 2000,
            w1024: {
                rows: 5,
                columns: 6
            },
            w768: {
                rows: 3,
                columns: 5
            },
            w480: {
                rows: 6,
                columns: 4
            },
            w320: {
                rows: 7,
                columns: 4
            },
            w240: {
                rows: 7,
                columns: 3
            },
            preventClick: false
        });
        <?php
        }

}

    ?>


        // check for desktop or mobie
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            home_var.is_mobile = true;
        }
        // hover on home main image
        $('.top_watch_area').hover(function () {
            $('.watch_info').fadeIn(500)
        }, function () {
            $('.watch_info').fadeOut(500)
        })
        var postForm = { //Fetch form data
            'page': 1,
            'page_artist': 1,
            'page_number': 1,
            'limit': 0,
            //Store name fields value
        };
        jQuery("#show_more").live("click", function () {
            postForm.limit = '<?php echo $video_limit?>';
            jQuery('#loader').show();
            jQuery('#show_more').hide();
            $.ajax({
                type: "POST",
                url: "<?php echo get_bloginfo('template_url'); ?>/feature-ajax-videos.php",
                data: postForm,
                success: function (msg) {
                    jQuery('.loader').hide();
                    postForm.page = postForm.page + 1;
                    $("#videos_row").append(msg);
                }
            });
        });


        jQuery("#liked_show_more").live("click", function () {
            postForm.limit = '<?php echo $liked_video_limit?>';
            jQuery('#liked_loader').show();
            postForm.page_number = postForm.page_number + 1;
            if (postForm.page_number == 3) {
                jQuery('#liked_show_more').hide();
            }
            $.ajax({
                type: "POST",
                url: "<?php echo get_bloginfo('template_url'); ?>/liked-ajax-videos.php",
                data: postForm,
                success: function (msg) {
                    jQuery('#liked_loader').hide();
                    postForm.page = postForm.page + 1;
                    $("#liked_videos_row").append(msg);
                }
            });
        });

        jQuery("#show_more_artist").live("click", function () {
            jQuery('#loader_artist').show();
            postForm.limit = '<?php echo $user_limit?>';
            $.ajax({
                type: "POST",
                url: "<?php echo get_bloginfo('template_url'); ?>/feature-ajax-artist.php",
                data: postForm,
                success: function (msg) {
                    jQuery('#loader_artist').hide();
                    postForm.page_artist = postForm.page_artist + 1;
                    $("#more_artist").append(msg);
                }
            });
        });

    });

</script>
<?php get_footer(); ?>
