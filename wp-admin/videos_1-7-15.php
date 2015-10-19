<?php
/**
 * Dashboard Administration Screen
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

/** Load WordPress dashboard API */

wp_enqueue_script( 'dashboard' );
if ( current_user_can( 'edit_theme_options' ) )
	wp_enqueue_script( 'customize-loader' );
if ( current_user_can( 'install_plugins' ) )
	wp_enqueue_script( 'plugin-install' );
if ( current_user_can( 'upload_files' ) )
	wp_enqueue_script( 'media-upload' );
add_thickbox();

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );
$title = __('Videos');
$parent_file = 'Videos.php';

$help = '<p>' . __( 'Welcome to your WordPress Dashboard! This is the screen you will see when you log in to your site, and gives you access to all the site management features of WordPress. You can get help for any screen by clicking the Help tab in the upper corner.' ) . '</p>';
// Not using chaining here, so as to be parseable by PHP4.
$screen = get_current_screen();
$screen->add_help_tab( array(
	'id'      => 'overview',
	'title'   => __( 'Overview' ),
	'content' => $help,
) );

// Help tabs

$help  = '<p>' . __( 'The left-hand navigation menu provides links to all of the WordPress administration screens, with submenu items displayed on hover. You can minimize this menu to a narrow icon strip by clicking on the Collapse Menu arrow at the bottom.' ) . '</p>';
$help .= '<p>' . __( 'Links in the Toolbar at the top of the screen connect your dashboard and the front end of your site, and provide access to your profile and helpful WordPress information.' ) . '</p>';

$screen->add_help_tab( array(
	'id'      => 'help-navigation',
	'title'   => __( 'Navigation' ),
	'content' => $help,
) );

$help  = '<p>' . __( 'You can use the following controls to arrange your Dashboard screen to suit your workflow. This is true on most other administration screens as well.' ) . '</p>';
$help .= '<p>' . __( '<strong>Screen Options</strong> - Use the Screen Options tab to choose which Dashboard boxes to show.' ) . '</p>';
$help .= '<p>' . __( '<strong>Drag and Drop</strong> - To rearrange the boxes, drag and drop by clicking on the title bar of the selected box and releasing when you see a gray dotted-line rectangle appear in the location you want to place the box.' ) . '</p>';
$help .= '<p>' . __( '<strong>Box Controls</strong> - Click the title bar of the box to expand or collapse it. Some boxes added by plugins may have configurable content, and will show a &#8220;Configure&#8221; link in the title bar if you hover over it.' ) . '</p>';

$screen->add_help_tab( array(
	'id'      => 'help-layout',
	'title'   => __( 'Layout' ),
	'content' => $help,
) );

$help  = '<p>' . __( 'The boxes on your Dashboard screen are:' ) . '</p>';
if ( current_user_can( 'edit_posts' ) )
	$help .= '<p>' . __( '<strong>At A Glance</strong> - Displays a summary of the content on your site and identifies which theme and version of WordPress you are using.' ) . '</p>';
	$help .= '<p>' . __( '<strong>Activity</strong> - Shows the upcoming scheduled posts, recently published posts, and the most recent comments on your posts and allows you to moderate them.' ) . '</p>';
if ( is_blog_admin() && current_user_can( 'edit_posts' ) )
	$help .= '<p>' . __( "<strong>Quick Draft</strong> - Allows you to create a new post and save it as a draft. Also displays links to the 5 most recent draft posts you've started." ) . '</p>';
if ( ! is_multisite() && current_user_can( 'install_plugins' ) )
	$help .= '<p>' . __( '<strong>WordPress News</strong> - Latest news from the official WordPress project, the <a href="https://planet.wordpress.org/">WordPress Planet</a>, and popular and recent plugins.' ) . '</p>';
else
	$help .= '<p>' . __( '<strong>WordPress News</strong> - Latest news from the official WordPress project, the <a href="https://planet.wordpress.org/">WordPress Planet</a>.' ) . '</p>';
if ( current_user_can( 'edit_theme_options' ) )
	$help .= '<p>' . __( '<strong>Welcome</strong> - Shows links for some of the most common tasks when setting up a new site.' ) . '</p>';

$screen->add_help_tab( array(
	'id'      => 'help-content',
	'title'   => __( 'Content' ),
	'content' => $help,
) );

unset( $help );

$screen->set_help_sidebar(
	'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
	'<p>' . __( '<a href="http://codex.wordpress.org/Dashboard_Screen" target="_blank">Documentation on Dashboard</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://wordpress.org/support/" target="_blank">Support Forums</a>' ) . '</p>'
);

include( ABSPATH . 'wp-admin/admin-header.php' );
	$start=0;
	$limit=20;
	$videos_count	=	$wpdb->get_results ("SELECT count(*) as total from videos");
	$videos_count	=	$videos_count[0]->total;
	$feature_videos	=	$wpdb->get_results ("SELECT count(*) as total from videos where is_featured=1");
	$feature_count	=	$feature_videos[0]->total;
	$liked_videos	=	$wpdb->get_results ("SELECT count(*) as total from videos where is_liked=1");
	$liked_count	=	$liked_videos[0]->total;
	$query			=	"SELECT  videos.*,(select count(*) from video_like where video_like.video_id = videos.id)  as likes FROM videos";
	
	$admin_like_sorted				=	'sortable';
	$admin_like_sort_order			=	'asc';
	$admin_like_url					=	admin_url( 'videos.php?orderby=liked&order=desc');
	if(isset($_GET['orderby'])&&($_GET['orderby']=='liked')){
		$admin_like_sorted			=	'sorted';
		if(isset($_GET['order'])&&($_GET['order']=='asc')){
			$admin_like_url			=	admin_url( 'videos.php?orderby=liked&order=desc');
			$admin_like_sort_order	=	'asc';
		}
		if(isset($_GET['order'])&&($_GET['order']=='desc')){
			$admin_like_url			=	admin_url( 'videos.php?orderby=liked&order=asc');
			$admin_like_sort_order	=	'desc';
		}
	}


	$like_sorted				=	'sortable';
	$like_sort_order			=	'asc';
	$like_url					=	admin_url( 'videos.php?orderby=like&order=desc');
	if(isset($_GET['orderby'])&&($_GET['orderby']=='like')){
		$like_sorted			=	'sorted';
		if(isset($_GET['order'])&&($_GET['order']=='asc')){
			$like_url			=	admin_url( 'videos.php?orderby=like&order=desc');
			$like_sort_order	=	'asc';
		}
		if(isset($_GET['order'])&&($_GET['order']=='desc')){
			$like_url			=	admin_url( 'videos.php?orderby=like&order=asc');
			$like_sort_order	=	'desc';
		}
	}
	$featured_sorted			=	'sortable';
	$featured_sort_order		=	'asc';
	$featured_url				=	admin_url( 'videos.php?orderby=featured&order=desc');
	if(isset($_GET['orderby'])&&($_GET['orderby']=='featured')){
		$featured_sorted			=	'sorted';
		if(isset($_GET['order'])&&($_GET['order']=='asc')){
			$featured_url			=	admin_url( 'videos.php?orderby=featured&order=desc');
			$featured_sort_order	=	'asc';
		}
		if(isset($_GET['order'])&&($_GET['order']=='desc')){
			$featured_url			=	admin_url( 'videos.php?orderby=featured&order=asc');
			$featured_sort_order	=	'desc';
		}
	}
	$order_by_field	=	'id';
	$order			=	'desc';
	$url = admin_url( 'videos.php');
	if(isset($_GET['orderby'])){
		if($_GET['orderby']=='id'){
			$order_by_field	=	'id';
			$url	.=	'?orderby=id';
		}
		if($_GET['orderby']=='like'){
			$order_by_field	=	'likes';
			$url	.=	'?orderby=like';
		}
		if($_GET['orderby']=='featured'){
			$order_by_field	=	'is_featured';
			$url	.=	'?orderby=featured';
		}
		if($_GET['orderby']=='liked'){
			$order_by_field	=	'is_liked';
			$url	.=	'?orderby=liked';
		}
		if($_GET['order']=='asc'){
			$url	.=	'&order=asc';
			$order	=	'asc';
		}
		if($_GET['order']=='desc'){
			$url	.=	'&order=desc';
			$order	 =	'desc';
		}
	}else{
		$url = admin_url( 'videos.php?orderby=id&order=desc');
	}


	if(isset($_GET['pager'])) {
		if($_GET['pager']=='all'){
			$id		=	1;
			$sql	=	"SELECT  videos.*,(select count(*) from video_like where video_like.video_id = videos.id)  as likes FROM videos order by $order_by_field $order ";
		}else{
			$id		=	$_GET['pager'];
			$start	=	($id-1)*$limit;
			$sql	=	"SELECT  videos.*,(select count(*) from video_like where video_like.video_id = videos.id)  as likes FROM videos order by $order_by_field $order limit $start, $limit";
		}
	}else{
		$id=1;
			$sql	=	"SELECT  videos.*,(select count(*) from video_like where video_like.video_id = videos.id)  as likes FROM videos order by $order_by_field $order limit $start, $limit";
	}


	$sql	=	
	$videos			=	$wpdb->get_results($sql);
	$rows			=	$videos_count;
	$total=ceil($rows/$limit);
	
	
?><br />
<p><a href="<?php echo $url?>&pager=all">Show All videos</a></p>
 <table class="wp-list-table widefat fixed posts">
    <thead>
        <tr>
            <th style="" class="manage-column" id="" scope="col">Title</th>
            <th style="" class="manage-column" id="" scope="col">Link</th>
            <th style="" class="manage-column" id="" scope="col">Image</th>

            <th style="" class="manage-column column-share <?php echo $admin_like_sorted?> <?php echo $admin_like_sort_order?>" id="share" scope="col">
                <a href="<?php echo $admin_like_url?>">
                    <span>liked</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>

            <th style="" class="manage-column column-share <?php echo $featured_sorted?> <?php echo $featured_sort_order?>" id="share" scope="col">
                <a href="<?php echo $featured_url?>">
                    <span>Featured</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>

            <th style="" class="manage-column column-share <?php echo $like_sorted?> <?php echo $like_sort_order?>" id="share" scope="col">
                <a href="<?php echo $like_url?>">
                    <span>Numbers of likes</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
        </tr>
        <tfoot>
            <tr>
                <td colspan="3"><center>
                <style>
                .pagi{
					display:block;
					padding:5px;
					float:left;
					font-size:15px;
					text-align:left;
				}
                </style>
<?php
		if(isset($_GET['pager'])){
			if($_GET['pager']!='all'){
				for($i=1;$i<=$total;$i++){
					if($i==$id) {
						echo "<a class='active pagi' href='#'><span>".$i."</span></a>";
					}else{
						echo '<a  class="pagi" href="'.$url.'&pager='.$i.'"><span>'.$i.'</span></a>';
					}
				}
			}
		}else{
			for($i=1;$i<=$total;$i++){
				if($i==$id) {
					echo "<a class='active pagi' href='#'><span>".$i."</span></a>";
				}else{
					echo '<a  class="pagi" href="'.$url.'&pager='.$i.'"><span>'.$i.'</span></a>';
				}
			}
		}
?>
                </center></td>
            </tr>
        </tfoot>
      </thead>
    <tbody id="the-list">
	<?php foreach($videos as $vid){ ?>
        <tr id="post-53" class="post-53 type-sescret_session_home status-publish hentry alternate iedit author-self level-0">
            <td class="post-title page-title column-title"><strong><?php echo $vid->video_title?></strong>
                <div class="row-actions">
                    <span class="inline hide-if-no-js">
                        <a href="<?php echo get_admin_url().'video.php?action=delete&vid='.$vid->id.'&pager='.$id?>" title="Delete video">Delete</a>|
                    </span>



					<?php	if($vid->is_liked=='1'){ ?>
                        <span >
                            <a class="submitdelete" title="Remove Featured" href="<?php echo get_admin_url().'video.php?action=rliked&vid='.$vid->id.'&pager='.$id?>">Remove liked</a>|
                        </span>
                    <?php }elseif($liked_count<18){ ?>
                        <span >
                            <a class="submitdelete" title="Make Featured" href="<?php echo get_admin_url().'video.php?action=liked&vid='.$vid->id.'&pager='.$id?>">Make Most liked</a>|
                        </span>
                    <?php }else{ ?>
                        <span style="color:red;">
                            18 videos allowed in liked
                        </span>
					<?php } ?>                      


					<?php	if($vid->is_featured=='1'){ ?>
                        <span >
                            <a class="submitdelete" title="Remove Featured" href="<?php echo get_admin_url().'video.php?action=rfeature&vid='.$vid->id.'&pager='.$id?>">Remove featured</a>|
                        </span>
                    <?php }elseif($feature_count<3){ ?>
                        <span >
                            <a class="submitdelete" title="Make Featured" href="<?php echo get_admin_url().'video.php?action=feature&vid='.$vid->id.'&pager='.$id?>">Make featured</a>|
                        </span>
                    <?php }else{ ?>
                        <span style="color:red;">
                            3 videos allowed in featured
                        </span>
					<?php } ?>                    
                </div>
            </td>
            <td class="date column-date"><?php echo $vid->video_link?></td>
            <td class="date column-date"><img style="width:60%;"  src="<?php echo $vid->video_image ?>" alt="" class="img-responsive"></td>
            <td class="date column-date"><?php
            if($vid->is_liked=='1'){
				echo 'Liked';
			}else{
				echo 'Not liked';
			}
			?></td>
            <td class="date column-date"><?php
            if($vid->is_featured=='1'){
				echo 'Featured';
			}else{
				echo 'Not featured';
			}
			?></td>
            <td class="date column-date"><?php echo $vid->likes?></td>
        </tr>
	<?php } ?> 
    </tbody>
  </table>
  
<?php
require( ABSPATH . 'wp-admin/admin-footer.php' );
