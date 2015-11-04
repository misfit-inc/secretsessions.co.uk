<script>window.jQuery || document.write('<script src="<?php bloginfo ('template_url'); ?>/js/jquery.min.js"><\/script>')</script>
<script src="<?php bloginfo ('template_url'); ?>/js/jquery-ui.js"></script>
<script src="<?php bloginfo ('template_url'); ?>/js/jquery-ui.min.js"></script>
<script src="<?php bloginfo ('template_url'); ?>/js/video.js"></script>
<script src="<?php bloginfo ('template_url'); ?>/js/bigvideo.js"></script>
<script>
    $(function() {
        var BV = new $.BigVideo({useFlashForFirefox:false});
		BV.init();
		
		<?php if(get_option('misfit_ambient') == "true") { ?>
		
		
        if (Modernizr.touch) {
            BV.show('<?php echo get_option('misfit_vidfallback'); ?>');
        } else {
            BV.show('<?php echo get_option('misfit_mp4'); ?>',{ambient:true,altSource:'<?php echo get_option('misfit_ogg'); ?>'});
        }
        
        <?php } else { ?>
        
        if (Modernizr.touch) {
            BV.show('<?php echo get_option('misfit_vidfallback'); ?>');
        } else {
            BV.show('<?php echo get_option('misfit_mp4'); ?>',{doLoop:true, altSource:'<?php echo get_option('misfit_ogg'); ?>'});
        }
        
        BV.getPlayer().volume(.4)
		
		// Use this to toggle
		$('.mute').click(function(e){
		e.preventDefault();
		     BV.getPlayer().volume(0);
		     $(this).css("display", "none");
		     $('.muted').css("display", "block");          
		});
		
		$('.muted').click(function(e){
		e.preventDefault();
		     BV.getPlayer().volume(.4);
		     $(this).css("display", "none"); 
		     $('.mute').css("display", "block");            
		});
		
		<?php } ?>
        
    });
</script>
