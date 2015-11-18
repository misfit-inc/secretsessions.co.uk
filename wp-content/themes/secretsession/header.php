<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package    WordPress
 * @subpackage Twenty_Fifteen
 * @since      Secret Session 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<title>
		<?php global $page, $paged; wp_title( '|', true, 'right' );
	
		
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'cebolang' ), max( $paged, $page ) );
		?>
	</title>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon_red.ico"
		  type="image/x-icon">
	<!-- fonts css -->
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/fonts.css" rel="stylesheet">
	<!-- bootstrap css -->
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<!-- global css -->
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/global.css" rel="stylesheet">
	<!-- media queries css -->
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/responsive.css" rel="stylesheet">
	<!-- flexslider css -->
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/flexslider.css" rel="stylesheet">
	<!--[if lte IE 8]>
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/ie.css" rel="stylesheet" type="text/css">
	<![endif]-->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link href="<?php echo get_bloginfo('template_url'); ?>/css/developer.css" rel="stylesheet">
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<script src="<?php echo get_bloginfo('template_url'); ?>/js/jquery.min.js"></script>
	
	
	
	<?php wp_head(); ?>
</head>
<body <?php body_class( $class ); ?> >
<script>
<!--
 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-62890879-1', 'auto');
 ga('send', 'pageview');
-->
</script>
<style type="text/css" media="screen">
	html {
		margin-top: 0px !important;
	}

	* html body {
		margin-top: 0px !important;
	}

	@media screen and ( max-width: 782px ) {
		html {
			margin-top: 0px !important;
		}

		* html body {
			margin-top: 0px !important;
		}
	}

	@media only screen and (max-width: 766px) {
		html {
			margin-top: 0px !important;
		}

		* html body {
			margin-top: 0px !important;
		}
	}

	@media only screen and (min-width: 767px) and (max-width: 768px) {
		html {
			margin-top: 0px !important;
		}

		* html body {
			margin-top: 0px !important;
		}

	}

</style>
<div class="header">
	<div class="header_cont">
		<a href="<?php echo get_site_url(); ?>" class="logo " title="">Secret Session</a>
		<a href="javascript:void(0);" class="open-menu-btn" title="">Menu</a>
	</div>
</div>
<!-- overlay menu -->
<div class="overlay_menu">
	<div class="container">
		<div class="menu_left_mobile">
			<div class="row top_content">
				<div class="col-md-6 col-sm-6">
					<?php if (has_nav_menu('primary')) : ?>
						<?php
						// Primary navigation menu.
						wp_nav_menu(array( 'menu_class' => '', 'theme_location' => '', ));
						?>
					<?php endif; ?>
				</div>
				<div class="col-md-6 col-sm-6">
					<ul>
						<?php if (is_user_logged_in()) {
							global $current_user;
							$user_id       = $current_user->data->ID;// Get user Id
							$user_url_name = get_cimyFieldValue($user_id, 'URL_NAME');
							if ( !empty($user_url_name)) {
								$user_link = home_url("artist/$user_url_name");
							} else {
								$user_link = get_permalink(get_page_by_path('user-profile-view'));
							}
							?>
							<li><a href="<?php echo get_permalink(get_page_by_path('edit-profile')); ?>" title="">Edit
									Profile</a></li>
							<li><a href="<?php echo $user_link; ?>" title="">View
									Profile</a></li>
							<li><a href="<?php echo wp_logout_url(); ?> " title="">Logout</a></li>
						<?php } else { ?>
							<li><a href="<?php echo get_page_link(5); ?>" title="">Login</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="menu_right_mobile">
			<div class="row bottom_content">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<ul class="social_icon">
						<li><a href="https://www.facebook.com/SecretSessions" title="" target="_blank">Facebook</a></li>
						<li><a href="https://twitter.com/secret_sessions" title="" target="_blank">Twitter</a></li>
						<li class="nopadding"><a href="http://instagram.com/secret_sessions" title="" target="_blank">Instagram</a>
						</li>
					</ul>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12">
					<p class="copyright">© Secret Sessions 2015. <span>All content © their respective owners</span></p>
				</div>
			</div>
		</div>
	</div>
</div>
