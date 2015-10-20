<?php
/**
* Template Name: Show video
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
	if ( !isset($_GET['vid']) ) {
		wp_redirect( home_url() );
		exit; 
	}else{
		$vid	=	sanitize( $_GET['vid'] );
	}
	$ajax_vid	=	$vid;
	$video_data	=	get_vido_data( $vid );
	if( !$video_data ) {
		wp_redirect( home_url() );
		exit; 
	}
	$video_id	=	$video_data->vid_id;
	$user_id	=	$video_data->user_id;
	if($user_id==0){
		$ss_data_query	=	'SELECT * from secretsession';
		$ss_data		=	$wpdb->get_row ($ss_data_query);
		if($ss_data){
			$ss_name	=	$ss_data->name;
			$ss_image	=	$ss_data->image_url;
		}else{
			$ss_name	=	'Secret Session';
			$ss_image	=	get_bloginfo('template_url').'/images/ss_logo.jpg';
		}
	}
	$like_url	=	(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if(isset($_GET['lke'])){
		do_like($vid);
		wp_redirect( str_replace('lke=','',$like_url)); exit; 
	}
	$video_like	=	get_video_like($vid);
	$like_count	=	$video_like->like_count;
	$you_liked	=	get_video_like_with_ip($vid);
	$you_liked_count	=	$you_liked->like_count;
	$url		=	$video_data->video_image;
	$parts 		=	parse_url($url);
	$str 		=	$parts['path'];
	$rootPath	=	$_SERVER['DOCUMENT_ROOT'];
	$image_path	=	$rootPath.$str;
	$arg1		=	pathinfo($image_path);
	$new_path	=	$arg1['dirname'].'/show_video_thumb_'.$arg1['basename'];
	if (!file_exists($new_path)) {
						$params = array(
							'width' => 1180,
							'height' => 810,
							'aspect_ratio' => true,
							'rgb' => '0x000000',
							'crop' => true
						);
		img_resize($image_path, $new_path, $params);
	}	
	$url_parts					=	explode('/', $url);
	$url_count					=	count($url_parts);
	$url_parts[$url_count-1]	=	'show_video_thumb_'.$url_parts[$url_count-1];
	$new_image_path				=	implode("/",$url_parts);
?><?php get_header(); ?>
<!-- You tube Api url -->
<style>

embed,
object {
  outline: 0;
  overflow: hidden
}
</style>
<script src="http://www.youtube.com/player_api"></script>
    <div id="wrapper">
        <div class="ss_video_section">
            <div class="container">
            <div class="watch_ss_video" id="videopause">
                <span class="watch_btn_new" style="display:none;" >watch</span>
                <!--<img id="video_image" src="<?php echo $new_image_path;?>" alt="" class="img-responsive">-->
                <div class="play_video_area" id="player" style="display:none">
                </div>
            </div>
                <div class="row">
                    <div class="col-md-9 col-sm-8 col-xs-9 video_detail">
<?php if( $you_liked_count > 0 ) { ?>
                        <a href="javascript:void(0);" class="fb_like" >
                            <span class="like_it">Liked</span>
                            <span class="total_like"><?php echo $like_count;?></span>
                        </a>                        
<?php	} else {	?>
                        <a href="javascript:void(0);" class="fb_like" id="doFbLike">
                            <span class="like_it" id="likeItSpan">like it</span>
                            <span class="total_like" id="likeCount"><?php echo $like_count;?></span>
                        </a>                        
<?php	}	?>
                        <h1 class="video_title"><?php
						if (strlen($video_data->video_title) > 30)
							echo stripslashes(substr($video_data->video_title, 0, 29)) . '...';
						else
							echo stripslashes($video_data->video_title);
						 ?></h1>
                        <span class="artist_name">

<?php
if($video_data->user_id!=0){
?>
					<?php
                    $user_url_name	=	get_cimyFieldValue( $video_data->user_id , 'URL_NAME' ); 
                    if(!empty($user_url_name)){
                        $user_link	=	home_url("artist/$user_url_name");
                    }else{
                        $user_link	=	add_query_arg('user_id',$video_data->user_id,get_permalink(get_page_by_path('user-profile-view')));
                    }
                    ?>
                        	<a href="<?php	echo $user_link; ?>">
								<?php echo character_limiter(get_cimyFieldValue($video_data->user_id,'NAME'),15);?>
                            </a>
<?php
}else{
?>
								<?php echo $video_data->ss_artist_name;?>
<?php
}
?>
                        </span>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-3">

<?php
if($video_data->user_id!=0){
?>

                        <div class="artist_profile_thumb">
                        <?php $IS_VARIFIED	=	get_cimyFieldValue($video_data->user_id,'IS_VARIFIED');?>
						<?php if(isset($IS_VARIFIED)&&($IS_VARIFIED=='YES')){ ?>
                                        <span class="verified">Verified</span>
                        <?php } ?>
						<?php
                        $user_url_name	=	get_cimyFieldValue( $video_data->user_id , 'URL_NAME' ); 
                        if(!empty($user_url_name)){
                            $user_link	=	home_url("artist/$user_url_name");
                        }else{
                            $user_link	=	add_query_arg('user_id',$video_data->user_id,get_permalink(get_page_by_path('user-profile-view')));
                        }
                        ?>
                        <a href="<?php	echo $user_link; ?>"  title="">
                            <img src="<?php echo  get_cimyFieldValue($video_data->user_id,'PROFILE_PHOTO');?>" alt="" class="img-responsive">
                        </a>
                            <div class="artist_thumb_caption">
                                <h3><a href="<?php	echo $user_link; ?>"  title=""><?php echo character_limiter(get_cimyFieldValue($video_data->user_id,'NAME'),15);?></a></h3>
                                <p><?php 
                                    $genre	=	get_gener($video_data->user_id);
                                    echo $genre;
                                ?></p>  
                            </div>
                        </div>
<?php
}else{
?>

                        <div class="artist_profile_thumb">
                            <img src="<?php echo $ss_image?>" alt="" class="img-responsive">
                            <div class="artist_thumb_caption">
                                <h3><?php echo $video_data->ss_artist_name;?></h3>
                                <p>&nbsp;</p>  
                            </div>
                        </div>
<?php
}
?>


                    </div>
                </div>
            </div>
        </div><!--ss_video_section-->
    <div class="featured_videos">

        <div class="container">
            <h2>Featured videos</h2>
            <div class="row" id="videos_row">
        <?php
		$limit				=	9; 
		$videos				=	$wpdb->get_results ("select * from videos where user_id=$video_data->user_id order by id desc  limit 0,$limit;");
		foreach($videos as $vid){ 
		$url		=	$vid->video_image;
		$parts 		=	parse_url($url);
		$str 		=	$parts['path'];
		$rootPath	=	$_SERVER['DOCUMENT_ROOT'];
		$image_path	=	$rootPath.$str;
		$arg1		=	pathinfo($image_path);
		$new_path	=	$arg1['dirname'].'/show_video_small_'.$arg1['basename'];
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
		$url_parts= explode('/', $url);
		$url_count	=	 count($url_parts);
		$url_parts[$url_count-1]	=	'show_video_small_'.$url_parts[$url_count-1];
		$new_image_path	=	 implode("/",$url_parts);
		?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="video_thumb">
                    <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>" title="show video"> 
                        <span>play video</span>
                        <img  src="<?php echo $new_image_path; ?>" alt="" class="img-responsive">
                    </a>          
                    <a href="<?php	echo add_query_arg('vid',$vid->id,get_permalink(get_page_by_path('show-video-2'))); ?>" class="title" title="">
					<?php echo stripslashes(character_limiter($vid->video_title,15));?>
                    </a>
                    <p>by 
<?php
if($vid->user_id!=0){
?>
<?php
$user_url_name	=	get_cimyFieldValue( $vid->user_id , 'URL_NAME' ); 
if(!empty($user_url_name)){
	$user_link	=	home_url("artist/$user_url_name");
}else{
	$user_link	=	add_query_arg('user_id',$vid->user_id,get_permalink(get_page_by_path('user-profile-view')));
}
?>
    <a href="<?php	echo $user_link; ?>"  class="artist_name" title="">
        <?php echo stripslashes(character_limiter(get_cimyFieldValue($vid->user_id, 'NAME'),15));?>
    </a>
<?php
}else{
?>
    	<?php echo stripslashes($vid->ss_artist_name);?>
<?php
}
?>
                    </p>
                    </div>
                </div>
		<?php } 
		?>
            </div>
<div class="loader"></div>
<a href="javascript:void(0);" class="show_more">Show more</a>
        </div>
        </div>
    </div><!--End of Wrapper-->
<script>
	var variables = { //Fetch form data
		'width'		:	$('.watch_ss_video').width(),
		'height'	:	$('.watch_ss_video').height(),
		'page'		:	1,
		'limit'		:	'<?php echo $limit;?>',
		'is_mobile'	: 	false,	// detact mobile or tablet variable
	};
	// autoplay video function
	function onPlayerReady(event) {
		if(variables.is_mobile==false){
			event.target.playVideo();
		}
	}
	// when video ends or paused
	function onPlayerStateChange(event) {        
		if(event.data === 0) {  
			//$(".play_video_area").hide(); //When Video ends
			$(".watch_ss_video a").css('z-index', 1);		
		}
		if(event.data === 2) {          
			if(variables.is_mobile==false){
				//$(".play_video_area").hide(); //When Video Paused
				$(".watch_ss_video a").css('z-index', 1);		
			} 
		}
	}
	// Change ifram width and hieght when window size changed 
	function	setWidthHight(){
		variables.width		=	$('.watch_ss_video').width();
		variables.height	=	Math.round((variables.width/16)*9);
		document.getElementById('player').width		=	variables.width;	// changing ifram width 
		document.getElementById('player').height	=	variables.height;	// changing ifram hieght 
	}
	// when window resize 
	$( window ).resize(function() { 
		setWidthHight();
	});	
	$(function() { 
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			variables.is_mobile	=	true
		}
		
		$('.watch_btn_new').click(function(){
			variables.height	=	Math.round((variables.width/16)*9);	
			player 				=	new YT.Player('player', {
			height					:	variables.height,
			width					:	variables.width,
			frameborder				:	0,
			webkitallowfullscreen	:	1,
			enablejsapi				:	1,
			origin					:	'<?php echo home_url();?>',
			playerVars				:	{'theme':'light','color':'white','autoplay': 1,'rel': 0, 'modestbranding':1, 'showinfo':0, 'fs':1,'autohide':1,'color':'white','theme':'dark','wmode':'transparent'},
			videoId					:	'<?php echo $video_id;?>',
			events					:	{
				'onReady'			:	onPlayerReady,
				'onStateChange'		:	onPlayerStateChange
			}
		});// end of object
		$(".play_video_area").show();				// Show video ifram 
		$(".watch_ss_video a").css('z-index', 0);		
		$('.watch_btn_new').unbind( "click" );		//  unbind the iframe reloading from API 
													// Bind to play agaian from whar the video stoped only for desktop
		$( ".watch_btn_new" ).bind( "click", function() {
			if(variables.is_mobile==false){
				player.playVideo();
			}
			$(".play_video_area").show();			// show video iframe
			$(".watch_ss_video a").css('z-index', 0);		
		});
		});
		jQuery( "a.show_more" ).live( "click", function() {
			jQuery('.loader').show();
		$.ajax({
				type: "POST",
				url: "<?php echo get_bloginfo('template_url'); ?>/ajax-show-videos.php",
				data: {page:variables.page,user_id:'<?php echo $user_id?>',limit:variables.limit},
				success: function(msg) {
					jQuery('.loader').hide();
					variables.page	=	variables.page+1;
					$( "#videos_row" ).append( msg );
				}
			});
		});
		$( "a#doFbLike" ).click(function() {
			$('#likeItSpan').html('Liked');
			$('#likeCount').html('<?php echo ($like_count+1)?>');
			var postForm = { //Fetch form data
					'video_id'		:	<?php echo $ajax_vid?>,
					 //Store name fields value
				};
		$.ajax({
				type: "POST",
				url: "<?php echo get_bloginfo('template_url'); ?>/ajax-video-like.php",
				data: postForm,
				success: function(msg) {
				}
			});
		});
	});
	window.onload = function () {
		setTimeout(function () {
		  $( ".watch_btn_new" ).trigger( "click" );
		}, 2000);	
	}	
</script>    
<?php	get_footer();	?>