<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Secret Session
 * @author  shakir blouch
 */

get_header(); ?>
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
    <!-- wrapper end -->
<?php get_footer(); ?>