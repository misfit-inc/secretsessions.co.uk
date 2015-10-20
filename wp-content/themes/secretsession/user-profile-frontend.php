<?php
	/**
	 * Template Name: User Profile view
	 *
	 * Allow users to update their profiles from Frontend.
	 * This is the template that displays all pages by default.
	 * Please note that this is the WordPress construct of pages and that
	 * other "pages" on your WordPress site will use a different template.
	 *
	 * @package    WordPress
	 * @subpackage Secret Session
	 * @author     shakir blouch
	 */
	$cur_url = (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$limit   = 6;
	if (isset($wp_query->query_vars['urlname'])) {
		$url_name = sanitize($wp_query->query_vars['urlname']);
		if ($url_name) {
			$field_id = get_cimyFieldValue_fun('URL_NAME');
			$sql      = $wpdb->prepare("SELECT count(ID) as num,USER_ID FROM wp_cimy_uef_data where
											FIELD_ID=%d and VALUE LIKE '%s'", array( $field_id, '%'.$url_name.'%' ));
			$result   = $wpdb->get_row($sql);
			$count    = $result->num;

			if ($count == 0) {
				$sql      = $wpdb->prepare("SELECT ID FROM  `wp_users` WHERE user_login LIKE  '%s'", array( '%'.$url_name.'%' ));
				$result   = $wpdb->get_row($sql);
				if(count($result)>0){
					$new_name	=	check_user_ulr($url_name,0,$result->ID);
					
					set_cimyFieldValue($result->ID,'URL_NAME',$new_name);
					$_GET['user_id'] = $result->ID;
				}else{
				wp_redirect(home_url());
				}
			} else {
				$_GET['user_id'] = $result->USER_ID;
			}
		}
	}
	global $current_user, $post;
	if (isset($_GET['user_id'])) {
		$user_id = ($_GET['user_id']);
	} else {
		if ( !is_user_logged_in()) {
			wp_redirect(home_url());
			exit;
		}
		$user_id = $current_user->data->ID;// Get user Id
	}
	$twitter_count  = getTweetCount($cur_url);
	$share_fb       = home_url().'/fbshare.php?Id='.$user_id;
	$facebook_share = file_get_contents('http://graph.facebook.com/?id='.$share_fb);
	$facebook_share = json_decode($facebook_share);
	if(!isset($facebook_share->shares)){
		$facebook_share->shares	=	0;
	}
	$facebook_share = $facebook_share->shares;
	$total_share    = 0;
	if ($twitter_count) {
		$total_share = $twitter_count;
		set_cimyFieldValue($user_id, 'TWEET_COUNT', $twitter_count);
	}

	if ($facebook_share) {
		$total_share = $total_share + $facebook_share;
		set_cimyFieldValue($user_id, 'FB_COUNT', $facebook_share);
	}
	$sql          = $wpdb->prepare("SELECT count(*) as total from videos where user_id=%d", array( $user_id ));
	$videos_count = $wpdb->get_results($sql);
	$sql          = $wpdb->prepare("select * from videos where user_id=%d order by id desc limit 0,%d", array( $user_id, $limit ));
	$videos       = $wpdb->get_results($sql);
	$sql          = $wpdb->prepare("SELECT wp_cimy_uef_data.*,wp_cimy_uef_fields.NAME FROM wp_cimy_uef_data
										JOIN wp_cimy_uef_fields ON wp_cimy_uef_fields.ID=wp_cimy_uef_data.FIELD_ID 
										where USER_ID=%d", array( $user_id ));
	$user         = $wpdb->get_results($sql);
	foreach ($user as $key => $val) {
		$user_data[$val->NAME] = $val->VALUE;
	}
	if ($user_data['TWITTER_EMDED_CODE'] != '') {
		$tw_name      = explode('com/', $user_data['TWITTER_EMDED_CODE']);
		$tw_data_text = 'I\'ve just discovered @'.$tw_name[1].' on @Secret_Sessions';
	} else {
		$tw_data_text = 'I\'ve just discovered this artist on @Secret_Sessions';
	}
	get_header(); ?>
<!-- wrapper start -->
<div id="wrapper">
<div class="artist_cover">
	<?php if (isset($user_data['COVER_PHOTO']) && ($user_data['COVER_PHOTO'] != '')) { ?>
		<img width="100%" src="<?php echo $user_data['COVER_PHOTO'] ?>" alt="" class="img-responsive">
	<?php } else { ?>
		<img width="100%" src="<?php echo get_bloginfo('template_url'); ?>/images/BlackBoxBlank.jpg" alt=""
			 class="img-responsive">
	<?php } ?>
</div>
<!-- artist detail -->
<div class="artist_profile_dtl">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-9">
				<h1 class="artist_name"><?php echo character_limiter($user_data['NAME'], 15); ?></h1>

				<p class="artist_bio"><?php echo stripslashes($user_data['DESCRIPTION_USER']); ?></p>

				<div class="fb_t_share clearfix">
					<div class="share_toggle">
						<a class="share_it_btn" href="javascript:toggleDiv('share_toggle');">
							<span class="share_it">Share it</span>
							<span class="total_share"><?php echo $total_share ?></span>
						</a>

						<div class="dropdown-menu" id="share_toggle">
							<div class="fb_share">
								<div id="fb-root"></div>
								<script>(function (d, s, id) {
										var js, fjs = d.getElementsByTagName(s)[0];
										if (d.getElementById(id)) return;
										js = d.createElement(s);
										js.id = id;
										js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=472104602947583";
										fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-share-button" data-href="<?php echo $share_fb ?>"
									 data-layout="button_count"></div>
							</div>
							<div class="tw_share">
								<a href="https://twitter.com/share" class="twitter-share-button"
								   data-url="<?php echo $cur_url; ?>" data-text="<?php echo $tw_data_text ?>">Tweet</a>
								<script>!function (d, s, id) {
										var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
										if (!d.getElementById(id)) {
											js = d.createElement(s);
											js.id = id;
											js.src = p + '://platform.twitter.com/widgets.js';
											fjs.parentNode.insertBefore(js, fjs);
										}
									}(document, 'script', 'twitter-wjs');</script>
							</div>
						</div>
					</div>
					<p>Share the love, share this artist</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-3">
				<div class="artist_profile_thumb">
					<?php if (isset($user_data['IS_VARIFIED']) && ($user_data['IS_VARIFIED'] == 'YES')) { ?>
						<span class="verified">Verified</span>
					<?php } ?>
					<?php if (isset($user_data['PROFILE_PHOTO']) && ($user_data['PROFILE_PHOTO'] != '')) { ?>
						<img width="100%" src="<?php echo $user_data['PROFILE_PHOTO'] ?>" alt=""
							 class="img-responsive">
					<?php } else { ?>
						<img src="<?php echo get_bloginfo('template_url'); ?>/images/Black_blank.jpg" alt=""
							 class="img-responsive">
					<?php } ?>
					<div class="artist_thumb_caption">
						<h3><?php echo character_limiter($user_data['NAME'], 15); ?></h3>

						<p><?php $genre = secretsession_get_gener($user_data);
								echo $genre; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- artists videos -->
<div class="featured_videos artists_videos">
	<div class="container">
		<h2><?php echo character_limiter($user_data['NAME'], 15);
			?> videos</h2>

		<div class="row" id="videos_row">
			<?php foreach ($videos as $vid) {
				$url        = $vid->video_image;
				$parts      = parse_url($url);
				$str        = $parts['path'];
				$rootPath   = $_SERVER['DOCUMENT_ROOT'];
				$image_path = $rootPath.$str;
				$arg1       = pathinfo($image_path);
				$new_path   = $arg1['dirname'].'/show_video_small_'.$arg1['basename'];
				if ( !file_exists($new_path)) {
					$params = array( 'width' => 380, 'height' => 214, 'aspect_ratio' => TRUE, 'rgb' => '0x000000', 'crop' => TRUE );
					img_resize($image_path, $new_path, $params);
				}
				$url_parts                 = explode('/', $url);
				$url_count                 = count($url_parts);
				$url_parts[$url_count - 1] = 'show_video_small_'.$url_parts[$url_count - 1];
				$new_image_path            = implode("/", $url_parts);
				?>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="video_thumb">
						<a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
						   title="show video">
							<span>play video</span>
							<img src="<?php echo $new_image_path ?>" alt="" class="img-responsive">
						</a>
						<a href="<?php echo add_query_arg('vid', $vid->id, get_permalink(get_page_by_path('show-video-2'))); ?>"
						   class="title" title="">
							<?php echo character_limiter($vid->video_title, 19); ?></a>

						<p>by <?php
								echo character_limiter($user_data['NAME'], 15);
							?></p>
					</div>
				</div>
			<?php } ?>

		</div>
		<div class="loader"></div>

		<a href="javascript:void(0);" class="show_more">Show more</a>
	</div>
</div>
<!-- sound cloud and twitter -->
<div class="social_cont">
	<div class="container">
		<div class="row">

			<?php
				if ($user_data['SOUNDCLOUD_EMBED'] != '') {
					?>
					<div class="col-md-6 col-sm-6 ">
						<h2>SoundCloud</h2>

						<div class="soundcloud">
							<iframe width="100%" height="450" scrolling="no" frameborder="no"
									src="https://w.soundcloud.com/player/?url=<?php echo urlencode($user_data['SOUNDCLOUD_EMBED']) ?>&amp;color=ff6600&amp;auto_play=false&amp;show_artwork=true"></iframe>
						</div>
					</div>

				<?php } ?>


			<?php
				if ($user_data['TWITTER_EMDED_CODE'] != '') {
					?>
					<div class="col-md-6 col-sm-6 twitter">
						<h2>Twitter</h2>

						<div class="row">
							<div class="col-md-3 col-sm-4 twitter_thumb">
								<?php if (isset($user_data['PROFILE_PHOTO']) && ($user_data['PROFILE_PHOTO'] != '')) { ?>
									<img width="100%" src="<?php echo $user_data['PROFILE_PHOTO'] ?>" alt=""
										 class="img-responsive">
								<?php } else { ?>
									<img src="<?php echo get_bloginfo('template_url'); ?>/images/Black_blank.jpg" alt=""
										 class="img-responsive">
								<?php } ?>
								<span class="twitter_ico"></span>
							</div>
							<div class="col-md-9 col-sm-8">
								<ul class="twitter_feed">
									<?php include('twitter.php'); ?>
								</ul>
							</div>
						</div>
					</div>
				<?php } ?>

		</div>
	</div>
</div>
<!-- other artists -->
<div class="selected_artists other_artists">
	<div class="container">
		<h2>Other artists you might like</h2>

		<div class="row">
			<?php
				$other_artest = secretsession_get_other_artist($user_id, $genre);
				if (count($other_artest) > 0) {
					$i = 0;
					foreach ($other_artest as $key => $user_data_1) {
						if ($user_data_1['PROFILE_PHOTO'] == '') {
							continue;
						}
						$i++;?>
						<div class="col-md-3 col-sm-3 col-xs-6 col-md-15">
							<div class="artist_thumb <?php if ($i == 5) {
								echo 'artist_last_thumb';
							} ?>">
								<?php
									$user_url_name = get_cimyFieldValue($key, 'URL_NAME');
									if ( !empty($user_url_name)) {
										$user_link = home_url("artist/$user_url_name");
									} else {
										$user_link = add_query_arg('user_id', $key, get_permalink(get_page_by_path('user-profile-view')));
									}
								?>
								<a href="<?php echo $user_link; ?>" title="">
									<span>view artist</span>
									<?php if (isset($user_data_1['PROFILE_PHOTO']) && ($user_data_1['PROFILE_PHOTO'] != '')) { ?>
										<img src="<?php echo $user_data_1['PROFILE_PHOTO'] ?>" alt=""
											 class="img-responsive">
									<?php } else { ?>
										<img src="<?php echo get_bloginfo('template_url'); ?>/images/Black_blank.jpg"
											 alt="" class="img-responsive">
									<?php } ?>
								</a>
								<a href="<?php echo $user_link; ?>" class="title"
								   title=""><?php echo $user_data_1['NAME']; ?></a>

								<p><?php echo '&nbsp;'.secretsession_get_gener($user_data_1); ?></p>
								<?php if (isset($user_data_1['IS_VARIFIED']) && ($user_data_1['IS_VARIFIED'] == 'YES')) { ?>
									<span class="verified"></span>
								<?php } ?>
							</div>
						</div>
					<?php
					}
				}
			?>

		</div>
	</div>
</div>
</div>
<!-- wrapper end -->
<script>
	jQuery(document).ready(function () {
		var postForm = { //Fetch form data
			'user_id': '<?php echo $user_id?>',
			'shares_count': '<?php echo $user_id?>',
			'page': 1,
			'username': '<?php if (strlen($user_data['NAME']) > 19) {echo substr($user_data['NAME'], 0, 19) . '...';}
									else {echo $user_data['NAME'];}
							 ?>',
			<?php if(isset($user_data['IS_VARIFIED'])&&($user_data['IS_VARIFIED']=='YES')){ ?>
			'IS_VARIFIED': 'YES'
			<?php }else{ ?>
			'IS_VARIFIED': 'NO'
			<?php } ?>
			//Store name fields value
		};
		jQuery("a.show_more").live("click", function () {
			jQuery('.loader').show();
			$.ajax({
				type: "POST",
				url: "<?php echo get_bloginfo('template_url'); ?>/ajax-videos.php",
				data: postForm,
				success: function (msg) {
					jQuery('.loader').hide();
					postForm.page = postForm.page + 1;
					$("#videos_row").append(msg);
				}
			});
		});
	});
</script>
<script type="text/javascript">
	function toggleDiv(divId) {
		jQuery("#" + divId).toggle();
	}
</script>


<?php get_footer(); ?>
