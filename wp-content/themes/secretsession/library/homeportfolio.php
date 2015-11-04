<?php $counter = 1; query_posts('post_type=project'); if(have_posts()) : while(have_posts()) : the_post(); $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); ?>
			
						<div class="post count<?php echo $counter; ?><?php if(!$imgsrc) { ?> noimage<?php } ?>">
	
							<div class="whyhello">
								
								<p class="date"><?php the_time('d m y') ?></p>
								
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							
							</div>
							
							
							<div class="dearfriend">
								
								<div class="p-lining">
								
									<p class="date"><?php the_time('m d y') ?></p>
									
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									
									<p class="auth"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a></p>
									
									<h4 class="cats">In <?php $project_terms = wp_get_object_terms($post->ID, 'type'); if(!empty($project_terms)) { if(!is_wp_error( $project_terms )) { echo ''; $count = 0; foreach($project_terms as $term){ if($count > 0) { echo ', '; } echo '<a href="'.get_term_link($term->slug, 'type'). '">'.$term->name. '</a>';  $count++; }  } } ?></h4>
									
								</div>
								
								<a href="<?php the_permalink(); ?>" class="letsgo"><i class="flaticon-back28"></i></a>
								
								
							</div>
							
							<?php if($imgsrc) { ?>
							
							<div class="innerpost" style="background-image: url(<?php echo $imgsrc[0]; ?>);"></div>
							
							<?php } ?>
						
						</div>
					
					<?php $counter++;  endwhile; endif; wp_reset_query(); ?>	