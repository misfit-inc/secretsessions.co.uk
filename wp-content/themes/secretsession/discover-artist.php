<?php
/*Template Name: discover-artist
 * 
 * @package WordPress
 * @subpackage Secret Session
 * @since Secret Session
 */
$page = 0;
$limit = 30;
$class = '';
$artsits = ss_search_artist($page, $limit);
//echo '<pre>';print_r($artsits); exit;
?>
<?php get_header(); ?>
<!-- wrapper start -->
<div id="wrapper">
    <!-- container -->
    <div class="container">
        <!-- toggle -->
        <div class="row text-center">
            <ul class="nav_toggle">
                <li><a href="<?php echo get_permalink(get_page_by_path('discover-artist')) ?>"
                       class="active">Artists</a></li>
                <li class="nopadding"><a href="<?php echo get_permalink(get_page_by_path('discover')) ?>">Videos</a>
                </li>
            </ul>
        </div>
        <!-- search bar -->
        <form action="<?php echo get_permalink(get_page_by_path('discover-artist')); ?>" method="post" id="search_form">
            <div class="discover_search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search_field"
                           value="<?php if (isset($_POST['search_field'])) echo $_POST['search_field'] ?>"
                           placeholder="Search for artist by name">
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
                echo '<a ' . $class . ' href="' .add_query_arg('genre',$genre,get_permalink(get_page_by_path('discover-artist'))). '">' . $genre . '</a>';
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
            <a <?php echo $class; ?>
                href="<?php	echo add_query_arg('alpha','all',get_permalink(get_page_by_path('discover-artist'))); ?>" title="">All</a>
            <?php
            $class = '';
            foreach (range('A', 'Z') as $char) {
                if (isset($_GET['alpha']) && ($_GET['alpha'] == $char)) {
                    $class = 'class="active"';
                } else {
                    $class = '';
                }
                echo '<a ' . $class . ' href="' . add_query_arg('alpha',$char ,get_permalink(get_page_by_path('discover-artist'))).'" title="">' . $char . '</a>';
            }
            ?>
        </div>
        <!-- shuffle -->
        <ul class="shuffle">
            <?php
            $class = '';
            if (isset($_GET['shuffle'])) {
                if (($_GET['shuffle'] == 0)) {
                    $class = 'class="active"';
                } else {
                    $class = '';
                }
            }
            ?>
            <li><a <?php echo $class; ?>
                    href="<?php	echo add_query_arg('shuffle','2' ,get_permalink(get_page_by_path('discover-artist'))); ?>">A>Z</a></li>
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
            <li><a <?php echo $class ?>
                    href="<?php	echo add_query_arg('shuffle','1' ,get_permalink(get_page_by_path('discover-artist'))); ?>">Shuffle
                    results</a></li>
        </ul>
        <!-- artists start -->
        <div class="row" id="videos_row">
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
                            <a href="<?php	echo $user_link; ?>"
                               class="title" title="view profile">
                                <?php echo get_cimyFieldValue($id_user->USER_ID, 'NAME') ?>
                            </a>

                            <p><?php echo '&nbsp;' . get_gener($id_user->USER_ID); ?></p>
                            <?php $IS_VARIFIED = get_cimyFieldValue($id_user->USER_ID, 'IS_VARIFIED'); ?>
                            <?php if (isset($IS_VARIFIED) && ($IS_VARIFIED == 'YES')) { ?>
                                <span class="verified"></span>
                            <?php } ?>

                        </div>
                    </div>
                <?php
                }
            } else {
                echo '<p class="no_videos_found"> No artists meet your search criteria</p>';
            }?>
        </div>
        <!-- artists end -->
        <?php
        if (count($artsits) > 0) {
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
                url: "<?php echo get_bloginfo('template_url'); ?>/ajax-search-artist.php",
                data: searchForm,
                success: function (msg) {
                    if (msg == 1) {
                        jQuery('.show_more').hide();
                        $("#errorVideo").html('<p class="no_videos_found">There are no more artists to show</p>');
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
