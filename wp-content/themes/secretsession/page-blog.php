<?php
/*
Template Name: Blog
 *
 * @package WordPress
 * @subpackage Secret Session
 * @since Secret Session
 */
get_header();

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

?>

<?php 
    $query = new WP_Query(
        array (
            'post_type' => 'post',
            'showposts' => '1'
        )
    );
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full");  
    $category = get_the_category();    
?>   
<div class="blog-hero" style="background-image: url(<?php echo $imgsrc[0]; ?>);">
    <div class="container">     
        <span class="hero-cat"><?php echo $category[0]->cat_name; ?></span>
        <h1><?php the_title(); ?></h1>
        <span class="hero-aut">by <?php the_author(); ?></span><br>
        <span class="hero-date"><?php the_time('m/d/Y'); ?></span>
    </div>
</div>
<?php endwhile; endif; wp_reset_postdata(); ?>

<div class="clear"></div>

<div class="blog-posts">

    <div style="border-bottom: 1px solid #e4d9d9; padding-bottom: 50px;">
        <div class="blog-content">
            <?php 
                $query = new WP_Query(
                    array (
                        'post_type' => 'post',
                        'showposts' => '1'
                    )
                );
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
            ?> 
                <div class="text-container">
                    <?php the_excerpt(); ?>
                </div>

            <a href="<?php the_permalink(); ?>" class="blog-readmore">Read More</a>

            <ul>
                <li class="fb-share"><a href="#">Share</a><span>200</span></li>
                <li class="tweet"><a href="#">Tweet</a><span>100</span></li>
                <li>Share the love</li>
            </ul>
            <?php endwhile; endif; wp_reset_postdata(); ?>
        </div>
    </div>

    <div class="recent-posts">
        <h2>Recent Posts</h2>

        <?php 
            $query = new WP_Query(
                array (
                    'post_type' => 'post',
                    'showposts' => '5',
                    'offset' => '1'
                )
            );
            $counter = 1;
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full");  
            $category = get_the_category();   
            if ($counter == 1) {
        ?> 
            <div class="recent-whole" style="background-image: url(<?php echo $imgsrc[0]; ?>);">
                <div class="recent-whole-texts">    
                    <span class="recent-cat"><?php echo $category[0]->cat_name; ?></span>
                    <h3><?php the_title(); ?></h3>
                    <span class="hero-aut">by <?php the_author(); ?></span><br>
                    <span class="hero-date"><?php the_time('m/d/Y'); ?></span>
                </div>    

                <div class="read-container">
                    <a href="<?php the_permalink(); ?>">Read</a>
                </div>
            </div>
        <?php } else if (($counter > 1) && ($counter % 2 == 0)) { ?>    
            <div class="recent-half1 recent-half" style="background-image: url(<?php echo $imgsrc[0]; ?>);">
                <div class="recent-whole-texts">    
                    <span class="recent-cat"><?php echo $category[0]->cat_name; ?></span>
                    <h3><?php the_title(); ?></h3>
                    <span class="hero-aut">by <?php the_author(); ?></span><br>
                    <span class="hero-date"><?php the_time('m/d/Y'); ?></span>
                </div>    

                <div class="read-container">
                    <a href="<?php the_permalink(); ?>">Read</a>
                </div>
            </div>
        <?php } else { ?>    
            <div class="recent-half2 recent-half" style="background-image: url(<?php echo $imgsrc[0]; ?>);">
                <div class="recent-whole-texts">    
                    <span class="recent-cat"><?php echo $category[0]->cat_name; ?></span>
                    <h3><?php the_title(); ?></h3>
                    <span class="hero-aut">by <?php the_author(); ?></span><br>
                    <span class="hero-date"><?php the_time('m/d/Y'); ?></span>
                </div>    

                <div class="read-container">
                    <a href="<?php the_permalink(); ?>">Read</a>
                </div>
            </div>

        <?php } $counter++; endwhile; endif; wp_reset_postdata(); ?>

        <div class="clear"></div>

        <a href="#" class="show-recent-posts">Show more</a>
    </div>

</div>

<div class="blog-sidebar">

    <div style="border-bottom: 1px solid #e4d9d9; padding: 50px 0;">    
        <div class="blog-social">
            <h3>Follow</h3>

            <ul>
                <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/fb-follow.png"></a></li>
                <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/twitter-follow.png"></a></li>
                <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/instagram-follow.png"></a></li>
            </ul>
        </div>
    </div>    

    <div style="border-bottom: 1px solid #e4d9d9; padding: 50px 0;">
        <div class="blog-categories">
            <h3>Categories</h3>

            <ul>
                <li><a href="#">Category 1</a></li>
                <li><a href="#">Category 2</a></li>
                <li><a href="#">Category 3</a></li>
                <li><a href="#">Category 4</a></li>
                <li><a href="#">Category 5</a></li>
                <li><a href="#">Category 6</a></li>
                <li><a href="#">Category 7</a></li>
            </ul>

            <a href="#" class="show-categories">Show more</a>
        </div>
    </div>

    <div class="blog-newsletter">
        <h3>Newsletter</h3>

        <form action="#" method="get">
            <input type="text" name="name" id="name" placeholder="Name">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="submit" value="Submit" id="submit-newsletter">
        </form>
    </div>

</div>

<div class="clear"></div>

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

<script type="text/javascript">
$(document).ready(function(){
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