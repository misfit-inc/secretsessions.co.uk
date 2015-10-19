<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Secret Sessions</title>
</head>
<?php
$url	=	(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$heared_rl	=	explode('php?',$url);
print_r($heared_rl);
$paran	=	explode('_',$heared_rl[1]);
$like_url	.=	'?page_id='.$paran[0].'&user_id='.$paran[1];
header('Location:'.$like_url); exit;
$like_url	=	(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
   <a href="http://twitter.com/share" class="twitter-share-button"
      data-url="<?php echo 'http://secret-sessions.lotiv.com/artist.php?id=70_15'?>"
      data-via=""
      data-text="Secret Sessions"
      data-related="syedbalkhi:Founder of WPBeginner"
      data-count="vertical">Tweet</a>
<?php
$fb_url	=	urldecode('http://secret-sessions.lotiv.com/test.php?70_15');
?>
<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $fb_url?>&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=1982923141846320" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>
</html>
