<?php
/*Template Name: terms
 * 
 * @package WordPress
 * @subpackage Secret Session
 * @since Secret Session
 */
$type = 'terms-privacy';// custom content type
$args = array('post_type' => $type, 'post_status' => 'publish');
$my_query = null;
?>
<?php get_header(); ?>
<?php
$my_query = new WP_Query($args);//  WP db object
if ($my_query->have_posts()) {
    $my_query->the_post();
    $ourterms = get_custom_field('ourterms');
    $privacyolumn = get_custom_field('privacyolumn');
    ?>
    <div id="wrapper">
        <div class="container">
            <div class="row privacy_terms">
                <div class="col-md-6 col-sm-6">
                    <?php echo $privacyolumn ?>
                </div>
                <div class="col-md-6 col-sm-6">
					<?php echo $ourterms ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php get_footer(); ?>