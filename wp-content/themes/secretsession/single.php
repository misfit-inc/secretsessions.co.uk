<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Secret Session
 * @author  shakir blouch
 */

get_header(); 

if (is_singular('post')) {

    $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full");  
    $category = get_the_category();   

    if (have_posts()) : while (have_posts()) : the_post();

?>   
<div class="blog-hero" style="background-image: url(<?php if ($imgsrc[0]) { echo $imgsrc[0]; } else { bloginfo('template_url'); ?>/images/no-image.jpg<?php } ?>);">
    <div class="container">     
        <span class="hero-cat"><?php echo $category[0]->cat_name; ?></span>
        <h1><?php the_title(); ?></h1>
        <p class="hero-aut">by <span><?php the_author(); ?></span></p>
        <p class="hero-date"><?php the_time('m/d/y'); ?></p>
    </div>
</div>
<?php endwhile; endif; wp_reset_query(); ?>

<div class="clear"></div>

<div class="blog-posts">

    <!-- <ul>
        <li class="fb-share"><a href="#">Share</a><span>200</span></li>
        <li class="tweet"><a href="#">Tweet</a><span>100</span></li>
        <li>Share the love</li>
    </ul> -->
	
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
		<?php 
			
			$url = get_permalink();
			
			// FACEBOOK & TWITTER API
			
			$fb_api = file_get_contents('https://api.facebook.com/method/links.getStats?urls=' . $url . '&format=json');
			$fb_api = json_decode($fb_api, true);
			$fb_count = $fb_api[0]['share_count'];
			
			$tw_api = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
			$tw_api = json_decode($tw_api, true);
			$tw_count = $tw_api['count'];
			
			// URL ENCODER
			// https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&display=popup&ref=plugin&src=share_button
			// https://twitter.com/intent/tweet?url=https%3A%2F%2Fabout.twitter.com%2Fresources%2Fbuttons&text=Twitter%20Buttons%20%7C%20About
			
			$url_encode = urlencode($url);
			$title_encode = urlencode(get_the_title());
			
			$fb_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $url_encode;
			$tw_link = 'https://twitter.com/intent/tweet?url=' . $url_encode . '&text=' . $title_encode;
		?>
		
		<div class="blog-content">
            <div class="text-container">
                <?php the_content(); ?>

                <ul>
                    <li class="fb-share"><a target="_blank" href="<?php echo $fb_link; ?>">Share</a><span><?php echo $fb_count; ?></span></li>
                    <li class="tweet"><a target="_blank" href="<?php echo $tw_link; ?>">Tweet</a><span><?php echo $tw_count; ?></span></li>
                    <li>Share the love</li>
                </ul>
            </div>
        </div> 
    <?php endwhile; else: ?>
            
        <h1 class="no-posts">Sorry there are no posts available!</h1>       

    <?php endif; wp_reset_postdata(); ?> 

</div>

<div class="blog-sidebar">

    <div style="border-bottom: 1px solid #e4d9d9; padding: 50px 0;">
        <div class="blog-social">
            <h3>Follow</h3>

            <ul>
                <li><a href="https://www.facebook.com/SecretSessions" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/fb-follow.png"></a></li>
                <li><a href="https://twitter.com/secret_sessions" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/twitter-follow.png"></a></li>
                <li><a href="http://instagram.com/secret_sessions" target="target=_blank"><img src="<?php bloginfo('template_url'); ?>/images/instagram-follow.png"></a></li>
            </ul>
        </div>
    </div>    

    <div style="border-bottom: 1px solid #e4d9d9; padding: 50px 0;">
        <div class="blog-categories">
            <h3>Categories</h3>

            <!-- <ul>
                <li><a href="#">Category 1</a></li>
                <li><a href="#">Category 2</a></li>
                <li><a href="#">Category 3</a></li>
                <li><a href="#">Category 4</a></li>
                <li><a href="#">Category 5</a></li>
                <li><a href="#">Category 6</a></li>
                <li><a href="#">Category 7</a></li>
            </ul> -->

            <?php 
                $args = array('title_li' => __( ' ' ));
                wp_list_categories($args); 
            ?>

            <!-- <a href="#" class="show-categories">Show more</a> -->
        </div>
    </div>

    <div class="blog-newsletter">
        <h3>Newsletter</h3>

        <form action="#" method="get">
            <input type="text" name="name" id="name" placeholder="Name">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="submit" value="Submit" id="submit-newsletter">
        </form>
    </div>

</div>

<div class="clear"></div>

<div class="other-posts">

    <div class="container">

        <h2>Other posts you might like</h2>

        <div class="row">
            <?php 

                $query = new WP_Query(
                    array (
                        'post_type' => 'post',
                        'showposts' => '5',
                        'post__not_in' => array($post->ID)

                    )
                );
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 
            ?>
                <div class="col-md-3 col-sm-3 col-xs-6 col-md-15">
                    <div class="author-thumb">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo tt($imgsrc[0], 1000, 1000); ?>">
                        </a>
                        <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                        <p>by <span><?php the_author(); ?></span></p>
                        <p><?php the_time('m/d/y'); ?></p>
                    </div>
                </div>    
            
            <?php endwhile; else: ?>
            
                <h1 class="no-posts">Sorry there are no posts available!</h1>

            <?php endif; wp_reset_postdata(); ?>    
        </div>

    </div>

</div>

<?php } else { ?>
    <!-- wrapper start -->
    <div id="wrapper">
        <div class="container">
			<?php
            // Start the loop.
            while ( have_posts() ) : the_post();
    
                /*
                 * Include the post format-specific template for the content. If you want to
                 * use this in a child theme, then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                get_template_part( 'content', get_post_format() );
    
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
    
                // Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'secretsession' ) . '</span> ' .
                        '<span class="screen-reader-text">' . __( 'Next post:', 'secretsession' ) . '</span> ' .
                        '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'secretsession' ) . '</span> ' .
                        '<span class="screen-reader-text">' . __( 'Previous post:', 'secretsession' ) . '</span> ' .
                        '<span class="post-title">%title</span>',
                ) );
    
            // End the loop.
            endwhile;
            ?>
        </div>
    </div>
<?php } ?>
    <!-- wrapper end -->
<?php get_footer(); ?>
