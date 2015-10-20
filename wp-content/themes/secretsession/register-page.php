<?php
/**
 * Template Name: Register
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * <<<<<<< HEAD
 * @subpackage Secret Session
 * @author  shakir blouch
 * =======
 * @subpackage Twenty_Fifteen
 * @since Secret Session 1.0
 * >>>>>>> HOME-VIDEO-03
 */
	if (isset($_GET['email']) && ($_GET['email'] != '')) {
		$user_data = $wpdb->get_row($wpdb->prepare("select id from wp_invitations where invited_email=%s", sanitize($_GET['email'])));
		if(!$user_data){
			wp_redirect(home_url()); exit;
		}
	}else{
		wp_redirect(home_url()); exit;
	}
	if ( is_user_logged_in() ) {
		?>
		<script>
			window.location.href = '<?php echo home_url( '/' );?>';
		</script>
		<?php
		exit; }
get_header();
?>
    <!-- wrapper start -->
    <div id="wrapper">
        <div class="container" id="signup">
            <?php
            // Start the loop.
            while (have_posts()) : the_post();
                // Include the page content template.
                get_template_part('content', 'page');
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                // End the loop.
            endwhile;
            ?>
        </div>
    </div>
    <!-- wrapper end -->
<?php get_footer(); ?>