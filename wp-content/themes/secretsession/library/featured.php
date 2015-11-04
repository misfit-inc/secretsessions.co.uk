<!-- featured area with optional portions -->


<div class="heightset">
	<div class="fixer"></div>
 	<div class="checker"></div>        		
</div>



<div class="introspacer"> 

	<div class="homecontainer">
		

		
		<section class="home-intro" style="background-image: url(<?php echo get_option('misfit_single_image'); ?>);">
		<?php if(get_option('misfit_hometype') == "1" ) { ?>  	
	    <a id="prevslide" class="load-item"><i class="flaticon-previous11"></i></a>
		<a id="nextslide" class="load-item"><i class="flaticon-previous11"></i></a>
		<?php } ?>
		<?php if(is_home() && get_option('misfit_hometype') == "2" ) { ?>  
		<a id="big-video" href="#" class="mute"></a>
		<a id="big-video" href="#" class="muted"></a>
		<?php } ?>
    	<div class="home-intro-copy">
    	
    	
    	<?php if(get_option('misfit_hometype') == "2" ) { ?> 
    	
    		<?php if(get_option('misfit_vid_lineone')) { ?>
    		<h1 class="slabtextdone"><?php echo get_option('misfit_vid_lineone'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_vid_smalline')) { ?>
    		<h1 class="slabtextdone little"><?php echo get_option('misfit_vid_smalline'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_vid_bigline')) { ?>
    		<h1 class="slabtextdone big"><?php echo get_option('misfit_vid_bigline'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_vid_linetwo')) { ?>
    		<h1 class="slabtextdone"><?php echo get_option('misfit_vid_linetwo'); ?></h1>
    		<?php } ?>
    	
    	<?php } elseif(get_option('misfit_hometype') == "1" ) { ?> 	
    		
    		<?php if(get_option('misfit_slide_lineone')) { ?>
    		<h1 class="slabtextdone"><?php echo get_option('misfit_slide_lineone'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_slide_smalline')) { ?>
    		<h1 class="slabtextdone little"><?php echo get_option('misfit_slide_smalline'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_slide_bigline')) { ?>
    		<h1 class="slabtextdone big"><?php echo get_option('misfit_slide_bigline'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_slide_linetwo')) { ?>
    		<h1 class="slabtextdone"><?php echo get_option('misfit_slide_linetwo'); ?></h1>
    		<?php } ?>
    	
    	<?php } else { ?>
    		
    		<?php if(get_option('misfit_single_lineone')) { ?>
    		<h1 class="slabtextdone"><?php echo get_option('misfit_single_lineone'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_single_smalline')) { ?>
    		<h1 class="slabtextdone little"><?php echo get_option('misfit_single_smalline'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_single_bigline')) { ?>
    		<h1 class="slabtextdone big"><?php echo get_option('misfit_single_bigline'); ?></h1>
    		<?php } ?>
    		<?php if(get_option('misfit_single_linetwo')) { ?>
    		<h1 class="slabtextdone"><?php echo get_option('misfit_single_linetwo'); ?></h1>
    		<?php } ?>
    	
    	<?php } ?>
    	</div>
    	
    	

    	

    </section>

	</div>
	
</div>