<?php
require_once('wp-config.php');
global $wpdb;
$url		=	(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$url_name	=	'/';
if(isset($_REQUEST['Id'])){
	$user_id	=		$_REQUEST['Id'];
	$url_name	.=	'artist/'.get_cimyFieldValue($user_id,'URL_NAME');
}
$url	=	$url.$url_name;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="<?php echo get_cimyFieldValue($user_id,'NAME');?>"/>
<meta property="og:image" content="<?php echo get_cimyFieldValue($user_id,'PROFILE_PHOTO');?>"/>
<meta property="og:site_name" content="Secret Session"/>
<meta property="og:description" content=""/>
<title>Secret Session doucumrnty</title>
</head>
<body>
<?php echo $url; exit;?>
<script>
window.location.href = "<?php echo $redirect?>";
</script>
</body>
</html>