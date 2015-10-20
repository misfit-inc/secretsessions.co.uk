<?php
/*Template Name: discover
 * 
 * @package WordPress
 * @subpackage Secret Session
 * @since Secret Session
 */
$page	=	0;
$limit	=	12;
$class	=	'';
$videos	=	ss_search_video($page, $limit);
?>
<?php get_header(); ?>
<!-- wrapper start -->
<div id="wrapper">
    <!-- container -->
    <div class="container">
        <!-- toggle -->
        <div class="row text-center">
            <ul class="nav_toggle">
                <li><a href="<?php echo get_permalink(get_page_by_path('discover-artist')) ?>">Artists</a></li>
                <li class="nopadding"><a href="<?php echo get_permalink(get_page_by_path('discover')) ?>"
                                         class="active">Videos</a></li>
            </ul>
        </div>
        <!-- search bar -->
        <form action="<?php echo get_permalink(get_page_by_path('discover')); ?>" method="post" id="search_form">
            <div class="discover_search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search_field"
                           value="<?php if (isset($_POST['search_field'])) echo $_POST['search_field'] ?>"
                           placeholder="Search for video by name">
                    <input type="hidden" name="genre" value=""/>
                    <input type="hidden" name="alphabatic" value=""/>
                    <input type="hidden" name="shuffle" value=""/>
                    <span class="input-group-btn">
                        <button class="search_ico" type="submit"></button>
                    </span>
                </div>
            </div>
        </form>
        <!-- filters -->
        <div class="filter_genre">
            <?php $genres = array('All', 'Acoustic', 'Electronic', 'Folk', 'Indie', 'Jazz', 'Pop', 'Rock', 'Urban', 'World');
            foreach ($genres as $genre) {
                if (isset($_GET['genre']) && ($_GET['genre'] == $genre)) {
                    $class = 'class="active"';
                } else {
                    $class = '';
                }
                echo '<a ' . $class . ' href="' . add_query_arg('genre',$genre,get_permalink(get_page_by_path('discover'))) . '">' . $genre . '</a>';
            }
            $class = '';
            ?>
        </div>
        <!-- pagination -->
        <div class="filter_alphabet">
            <?php
            if (isset($_GET['alpha']) && ($_GET['alpha'] == 'all')) {
                $class = 'class="active"';
            } else {
                $class = '';
            }
            ?>
            <a <?php echo $class; ?> href="<?php echo add_query_arg('alpha','all' ,get_permalink(get_page_by_path('discover'))); ?>"
                                     title="">All</a>
            <?php
            $class = '';
            foreach (range('A', 'Z') as $char) {
                if (isset($_GET['alpha']) && ($_GET['alpha'] == $char)) {
                    $class = 'class="active"';
                } else {
                    $class = '';
                }
                echo '<a ' . $class . ' href="' . add_query_arg('alpha',$char ,get_permalink(get_page_by_path('discover'))). '" title="">' . $char . '</a>';
            }
            $class = '';
            ?>
        </div>
        <!-- shuffle -->
        <ul class="shuffle">
            <?php
            if (isset($_GET['shuffle'])) {
                if (($_GET['shuffle'] == 0)) {
                    $class = 'class="active"';
                } else {
                    $class = '';
                }
            }
            ?>
            <li><a <?php echo $class; ?>
                    href="<?php	echo add_query_arg('shuffle','2',get_permalink(get_page_by_path('discover'))); ?>">A>Z</a></li>
            <?php
            $class = '';
            if (isset($_GET['shuffle'])) {
                if (($_GET['shuffle'] == 1)) {
                    $class = 'class="active"';
                } else {
                    $class = '';
                }
            }
            ?>
            <li><a <?php echo $class ?> href="<?php	echo add_query_arg('shuffle','1' ,get_permalink(get_page_by_path('discover'))); ?>">Shuffle
                    results</a></li>
        </ul>
        <!-- videos start -->
        <div class="row" id="videos_row">
            <?php
            $_SESSION['not_in'] = '0,';
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
                echo '<p class="no_videos_found"> No videos meet your search criteria</p>';
            }
            ?>
        </div>
        <!-- videos end -->
        <?php
        if (count($videos) > 0) {
            ?>
            <div class="loader"></div>
            <a href="javascript:void(0);" class="show_more">Show more</a>
            <div id="errorVideo"></div>
        <?php
        }
        ?>
    </div>
</div>
<!-- wrapper end -->
<script>
    $(document).ready(function () {
        var searchForm = {
            <?php
            if(isset($_GET['genre'])&&(!empty($_GET['genre']))) { ?>
            'genre': "<?php echo $_GET['genre'];?>",
            <?php } ?>
            <?php
            if(isset($_GET['alpha'])&&(!empty($_GET['alpha']))) { ?>
            'alpha': "<?php echo $_GET['alpha'];?>",
            <?php } ?>
            <?php
            if(isset($_POST['search_field'])&&(!empty($_POST['search_field']))) { ?>
            'search_field': "<?php echo $_POST['search_field'];?>",
            <?php } ?>
            <?php
            if(isset($_GET['shuffle'])&&(!empty($_GET['shuffle']))) { ?>
            'shuffle': "<?php echo $_GET['shuffle'];?>",
            'not_in': "<?php echo $_SESSION['not_in'];?>",
            <?php } ?>
            'page': 1,
            'limit':    <?php echo $limit;?>
        };
        jQuery("a.show_more").live("click", function () {
            jQuery('.loader').show();
            jQuery('a.show_more').hide();
            $.ajax({
                type: "POST",
                url: "<?php echo get_bloginfo('template_url'); ?>/ajax-search-videos.php",
                data: searchForm,
                success: function (msg) {
                    if (msg == 1) {
                        jQuery('.show_more').hide();
                        $("#errorVideo").html('<p class="no_videos_found">There are no more videos to show</p>');
                    } else {
                        searchForm.page = searchForm.page + 1;
                        $("#videos_row").append(msg);
                        jQuery('a.show_more').show();
                    }
                    jQuery('.loader').hide();
                }
            });
        });
    });

</script>


<?php get_footer(); ?>
