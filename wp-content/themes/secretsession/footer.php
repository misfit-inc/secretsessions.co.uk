<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Secret Session
 * @author  shakir blouch
 */
?>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <!-- footer logo -->
                <div class="footer_logo pull-left">
                    <span class="ftr_ss_logo"></span>

                    <p>For the love of music</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <!-- social icons -->
                <ul class="ftr_social_icons pull-right">
                    <!--<li><a class="fb_ico" href="https://www.facebook.com/SecretSessions" title="" target="_blank"></a></li>-->
                    <li><a class="fb_ico" href="https://www.facebook.com/SecretSessions" title="" target="_blank"></a>
                    </li>
                    <li><a class="twitter_ico" href="https://twitter.com/secret_sessions" title="" target="_blank"></a>
                    </li>
                    <li class="nopadding"><a class="insta_ico" href="http://instagram.com/secret_sessions"
                                             target="_blank" title=""></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- common js -->
<script src="<?php echo get_bloginfo('template_url'); ?>/js/bootstrap.js"></script>
<!-- placeholder js for ie8 -->
<script src="<?php echo get_bloginfo('template_url'); ?>/js/placeholders.min.js"></script>
<!-- menu overlay js -->
<script src="<?php echo get_bloginfo('template_url'); ?>/js/fullscreennav.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/browser-detect.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/jquery.flexslider.js"></script>
<script type="text/javascript">
jQuery(window).load(function(){
    $('.flexslider').flexslider({
        animation: "slide"
    });
});
</script>
<script>
    jQuery(function () {


        $(".artist_thumb a ").mouseout(function () {
            $(this).css('background', '');
        }).mouseover(function () {
            $(this).css('background', '#000');
        });
        var homevar = { //Fetch form data
            'is_mobile': false,	// detact mobile or tablet variable
        };
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            homevar.is_mobile = true
        }
        if (homevar.is_mobile == true) {
            $(".video_thumb a ").on("mouseover", function () {
                var href = $(this).attr('href');
                window.location.href = href;
            });
            $(".artist_thumb a ").on("mouseover", function () {
                var href = $(this).attr('href');
                window.location.href = href;
            });
			$(document).on("mouseenter", ".thumb a", function() {
				var href = $(this).attr('href');
				var id = $(this).attr('id');
				id = id.replace("ac_", "");
						//window.location.href = href;
					setTimeout(function() {
						$('.spanhide').css('display', 'none !important');
						//window.location.href = href;
					}, 300);
			});
        }
			$(document).on("mouseenter", ".thumb a", function() {
				var href = $(this).attr('href');
				var id = $(this).attr('id');
				id = id.replace("ac_", "");
						//window.location.href = href;
					setTimeout(function() {
						$('.spanhide').css('display', 'none !important');
						//window.location.href = href;
					}, 300);
			});

        scrollTopPos = jQuery(document).scrollTop(); // for stop scrolling when menu will dispaly
        allowScrolling = true;
        $(document).scroll(function () {
            if (allowScrolling === false) {
                jQuery(document).scrollTop(scrollTopPos);
            }
        });
        jQuery(".overlay_menu").fullScreenNav(); // for menu overlay
        jQuery(".open-menu-btn").click(function () {
            classes = jQuery(".overlay_menu").attr("class");
            if (classes.indexOf("open") >= 0) {
                scrollTopPos = $(document).scrollTop();
                allowScrolling = false;// stop scrolling
                //jQuery('body').addClass('stop-scrolling');
                document.ontouchmove = function (e) {
                    e.preventDefault();
                }
            } else {
                allowScrolling = true; // allow scrolling
                //jQuery('body').removeClass('stop-scrolling');
                document.ontouchmove = function (e) {
                    return true;
                }
            }
        });
    });
});
</script>
</body>
</html>
