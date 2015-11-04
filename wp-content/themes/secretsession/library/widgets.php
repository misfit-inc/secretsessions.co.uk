<?php

/* ---------------------------------------------------- */
/*	Comment Widget
/* ---------------------------------------------------- */

class Comment_Widget extends WP_Widget {

	function Comment_Widget() {
		$widget_ops = array( 'classname' => 'commentwidget', 'description' => __('Add the big latest comment', 'misfitlang') );
		$this->WP_Widget( 'commentwidget', __('Scribe Latest Comment', 'misfitlang'), $widget_ops );
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = esc_attr( $instance['title'] );

		?>

		<br>
		

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = esc_attr( $instance['title'] );

		echo $before_widget;

		if($title)
			echo $before_title . $title . $after_title;

		
		?>
			<?php $comments = get_comments('status=approve&number=1'); ?>
							<?php foreach ($comments as $comment) { ?>
							    <?php
							        $title = get_the_title($comment->comment_post_ID);
							  
							        echo '<div class="whosaid"><p>Recently ' . ($comment->comment_author) . ''; ?><?php _e(' said: ', 'misfitlang'); ?></p><span class="icon-right-quote" aria-hidden="true"></span></div><p class="quoter"> "<?php
							        echo wp_html_excerpt( $comment->comment_content, 112 ); ?>…"</p>
							        
							        <div class="saidmore"><p><a href="<?php echo get_permalink($comment->comment_post_ID); ?>"
							           rel="external nofollow" title="<?php echo $title; ?>"><?php _e('Read The Post ', 'misfitlang'); ?></a></p></div>
							   
							<?php }  ?>
							
						

		
		<?php
		

		echo $after_widget;
	}

}

add_action( 'widgets_init', create_function('', "register_widget('Comment_Widget');") );


/* ---------------------------------------------------- */
/*	Twitter Info
/* ---------------------------------------------------- */

class twitter_Widget extends WP_Widget {

	function twitter_Widget() {
		$widget_ops = array( 'classname' => 'twitterwidget', 'description' => __('Add twitter in the sidebar, but be sure to add your credentials first in the options panel', 'misfitlang') );
		$this->WP_Widget( 'twitterwidget', __('Scribe Twitter Widget', 'misfitlang'), $widget_ops );
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = esc_attr( $instance['title'] );

		?>
		
		<br>
		
		<span style="border-radius: 4px; background: #eee; padding: 8px; margin: 0 0 10px 0; display: block;"><?php _e( 'Be sure to add your credentials in the options panel', 'misfitlang'); ?></span>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

		

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = esc_attr( $instance['title'] );

		echo $before_widget;

		if($title)
			echo $before_title . $title . $after_title;

		
		?>
		
		<div class="twitter">
				<div id="tweetlings">
		
					<div class="container">
						
						
						<div class="tweet">
						
						
						<div id="paging">
					      <div class="widget query"></div>
					      <!--<div class="controls">
					        <button class="prev" type="button" disabled>&larr;</button>
					        <span class="pagenum"></span>
					        <button class="next" type="button" disabled>&rarr;</button>
					      </div>-->
					    </div>
								
						
						</div>
						
					</div>
					
				</div>	
			</div>
		<?php
		

		echo $after_widget;
	}

}

add_action( 'widgets_init', create_function('', "register_widget('twitter_Widget');") );



/* ---------------------------------------------------- */
/*	Instagram Info
/* ---------------------------------------------------- */

class insta_Widget extends WP_Widget {

	function insta_Widget() {
		$widget_ops = array( 'classname' => 'instawidget', 'description' => __('Add instagram in the sidebar, but be sure to add your credentials first in the options panel', 'misfitlang') );
		$this->WP_Widget( 'instawidget', __('Scribe Instagram Widget', 'misfitlang'), $widget_ops );
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = esc_attr( $instance['title'] );

		?>
		
		<br>
		
		<span style="border-radius: 4px; background: #eee; padding: 8px; margin: 0 0 10px 0; display: block;"><?php _e( 'Be sure to add your credentials in the options panel', 'misfitlang'); ?></span>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

		

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = esc_attr( $instance['title'] );

		echo $before_widget;

		if($title)
			echo $before_title . $title . $after_title;

		
		?>
			
			<div id="instafeed"></div>

		
		<?php
		

		echo $after_widget;
	}

}

add_action( 'widgets_init', create_function('', "register_widget('insta_Widget');") );




/* ---------------------------------------------------- */
/*	Product Info
/* ---------------------------------------------------- */

class prod_Widget extends WP_Widget {

	function prod_Widget() {
		$widget_ops = array( 'classname' => 'prodwidget', 'description' => __('Featured product. This is a woocommerce install feature. Please install woocommerce to use this.', 'misfitlang') );
		$this->WP_Widget( 'prodwidget', __('Scribe Product Widget', 'misfitlang'), $widget_ops );
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = esc_attr( $instance['title'] );

		?>
		
		<br>
		
		<span style="border-radius: 4px; background: #eee; padding: 8px; margin: 0 0 10px 0; display: block;"><?php _e( 'Be sure to make the product featured by, going to products & clicking the star', 'misfitlang'); ?></span>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

		

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = esc_attr( $instance['title'] );

		echo $before_widget;

		if($title)
			echo $before_title . $title . $after_title;

		
		 $my_query = new WP_Query( array(
				'post_status' => 'publish',
				'post_type' => 'product',
				'meta_key' => '_featured',
				'meta_value' => 'yes',
				'posts_per_page' => 1
				) );

				if ($my_query ->have_posts()) : while ($my_query ->have_posts()) : $my_query ->the_post();$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); $id = get_the_ID(); ?>

					<div class="showcase">
					
					<a href="<?php the_permalink(); ?>" class="dropanchor"><img src="<?php echo $imgsrc[0]; ?>" alt="<?php the_title(); ?>"/></a>
					
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					
					<a href="<?php global $woocommerce; $cart_url = $woocommerce->cart->get_cart_url(); echo $cart_url; ?>?add-to-cart=<?php echo $id; ?>" class="button"><?php _e('Buy', 'misfitlang'); ?></a>
					<a href="<?php the_permalink(); ?>" class="button"><?php _e('Preview', 'misfitlang'); ?></a>
				
				</div>
				
				
				
				<?php endwhile; endif;

		
		

		echo $after_widget;
	}

}

add_action( 'widgets_init', create_function('', "register_widget('prod_Widget');") );





/* ---------------------------------------------------- */
/*	Social Icons
/* ---------------------------------------------------- */

class social_Widget extends WP_Widget {

	function social_Widget() {
		$widget_ops = array( 'classname' => 'socialwidget', 'description' => __('Featured product. This is a woocommerce install feature. Please install woocommerce to use this.', 'misfitlang') );
		$this->WP_Widget( 'socialwidget', __('Scribe Social Icons Widget', 'misfitlang'), $widget_ops );
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = esc_attr( $instance['title'] );

		?>
		
		<br>
		
		<span style="border-radius: 4px; background: #eee; padding: 8px; margin: 0 0 10px 0; display: block;"><?php _e( 'Be sure to add your social info in the options panel', 'misfitlang'); ?></span>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

		

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = esc_attr( $instance['title'] );

		

	
		
		 ?>
		 	
		 	
		 		<div class="socializer">
				
				<ul>
					
					
						<?php if(get_option('misfit_facebook')) { ?>
						<li><a href="http://facebook.com/<?php echo get_option('misfit_facebook'); ?>" target="_blank" class="flaticon-facebook51"></a></li>
						<?php } ?>
						<?php if(get_option('misfit_twitter')) { ?>
						<li><a href="http://twitter.com/<?php echo get_option('misfit_twitter'); ?>" target="_blank" class="flaticon-twitter44"></a></li>
						<?php } ?>
						<?php if(get_option('misfit_pinterest')) { ?>
						<li><a href="http://www.pinterest.com/<?php echo get_option('misfit_pinterest'); ?>" target="_blank" class="flaticon-pinterest31"></a></li>
						<?php } ?>
						<?php if(get_option('misfit_dribbble')) { ?>
						<li><a href="https://dribbble.com/<?php echo get_option('misfit_dribbble'); ?>" target="_blank" class="flaticon-dribbble14"></a></li>
						<?php } ?>
						<?php if(get_option('misfit_googleplus')) { ?>
						<li><a href="https://plus.google.com/+<?php echo get_option('misfit_googleplus'); ?>" target="_blank" class="flaticon-google115"></a></li>
						<?php } ?>
						<?php if(get_option('misfit_instagram')) { ?>
						<li><a href="https://instagram.com/<?php echo get_option('misfit_instagram'); ?>" target="_blank" class="flaticon-instagram7"></a></li>	
						<?php } ?>
						<?php if(get_option('misfit_behance')) { ?>
						<li style="margin-left: 5px;"><a href="https://behance.net/<?php echo get_option('misfit_behance'); ?>" target="_blank" class="flaticon-behance2"></a></li>	
						<?php } ?>

					<span style="display: block;" class="clear"></span>
				</ul>
			
			</div>

		 	
		 	
		 	
		 <?php		
		

		
	}

}

add_action( 'widgets_init', create_function('', "register_widget('social_Widget');") );



