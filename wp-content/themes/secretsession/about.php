<?php
	/*Template Name: about
	 *
	 * @package WordPress
	 * @subpackage Secret Session
	 * @since Secret Session
	 */
	$type     = 'about';// custom content type
	$args     = array( 'post_type' => $type, 'post_status' => 'publish' );
	$my_query = NULL;
	$my_query = new WP_Query($args);//  WP db object
	if ($my_query->have_posts()) {
		$my_query->the_post();
		$url = get_custom_field('about_video_link');
		parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars); // get video id fro iframe
		$video_id    = $my_array_of_vars['v'];// video id
		$excerpt     = get_the_excerpt();
		$post_id     = get_the_ID();
		$description = apply_filters('the_content', get_post_field('post_content', $post_id));
		?>
		<script src="http://www.youtube.com/player_api"></script>
		<?php get_header(); ?>
		<div id="wrapper">
			<!-- container -->
			<div class="container about_cont">
				<h1><?php echo ucfirst(get_the_title()) ?></h1>
				<div class="watch_ss_video">
					<a href="javascript:void(0);" style="display:none" title="" id="watch_btn">watch</a>
					<div class="play_video_area" id="player" style="display:none">
					</div>
				</div>
				<div class="row ">
					<div class="col-md-6 col-sm-6"></div>
					<div class="col-md-6 col-sm-6">
						<div class="about_content">
							<?php
								echo $description
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var aboutPage = {
				is_mobile: false,
				width: false,
				height: false,
				player: false
			};
			function onPlayerReady(event) {
				if (aboutPage.is_mobile == false) {
					//event.target.playVideo();
				}
			}
			// when video ends or paused
			function onPlayerStateChange(event) {
				if (event.data === 0) {
					// $(".play_video_area").hide(); //When Video ends
					$('#watch_btn').css('z-index', 1);
				}
				if (event.data === 2) {
					if (aboutPage.is_mobile == false) {
						// $(".play_video_area").hide(); //When Video Paused
						$('#watch_btn').css('z-index', 1);
					}
				}
			}
			// Change ifram width and hieght when window size changed
			function setWidthHight() {
				aboutPage.width = $('.watch_ss_video').width(); // getting width
				aboutPage.height = Math.round((aboutPage.width / 16) * 9);
				document.getElementById('player').width = aboutPage.width;		// changing ifram width
				document.getElementById('player').height = aboutPage.height;		// changing ifram hieght
			}
			// when window resize
			$(window).resize(function () {
				setWidthHight();
			});

			$(document).ready(function () {
				// check for desktop or mobie
				if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
					aboutPage.is_mobile = true;
				}
				// when click on watch button to palay the video
				$('#watch_btn').click(function () {
					$('#watch_btn').css('z-index', 0);
					aboutPage.width = $('.watch_ss_video').width(); // getting width of window
					aboutPage.height = Math.round((aboutPage.width / 16) * 9);
					aboutPage.height = aboutPage.height;
					aboutPage.player = new YT.Player('player', {
						height: aboutPage.height,
						width: aboutPage.width,
						enablejsapi: 1,
						origin: '<?php echo home_url();?>',
						playerVars: {'autoplay': 0, 'rel': 0, 'modestbranding': 1, 'showinfo': 0, 'fs': 1},
						videoId: '<?php echo $video_id;?>',
						events: {
							'onReady': onPlayerReady,
							'onStateChange': onPlayerStateChange
						}
					});// end of object
					$(".play_video_area").show();		// Show video ifram
					$('#watch_btn').unbind("click");	//  unbind the iframe reloading from API
					// Bind to play agaian from whar the video stoped only for desktop
					$("#watch_btn").bind("click", function () {
						$('#watch_btn').css('z-index', 0);
						if (aboutPage.is_mobile == false) {
						}
						$(".play_video_area").show(); // show video iframe
					});
				});

			});
			$(window).load(function () {
				$("#watch_btn").trigger("click");
			});    </script>
	<?php } 
	get_footer(); ?>