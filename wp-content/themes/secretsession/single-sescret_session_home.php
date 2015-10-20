<?php
/**
 * Sample template for displaying single sescret_session_home posts.
 * Save this file as as single-sescret_session_home.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */
get_header(); ?>
    <!-- wrapper start -->
    <div id="wrapper">
        <div class="container">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                <h2>Custom Fields</h2>
                <strong>Image:</strong> <img src="<?php print_custom_field('home_image:to_image_src'); ?>"/><br/>
            <?php endwhile; // end of the loop. ?>
        </div>
    </div>
<?php get_footer(); ?>