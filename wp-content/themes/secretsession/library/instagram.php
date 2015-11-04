<script type="text/javascript" src="<?php bloginfo ('template_url'); ?>/js/instafeed.min.js"></script>
<script type="text/javascript">
var userFeed = new Instafeed({
    get: 'user',
    resolution: 'low_resolution',
    userId: <?php echo get_option('misfit_instagramid'); ?>,
    limit: 6,
    accessToken: '<?php echo get_option('misfit_instagramtok'); ?>'
});
userFeed.run();
</script>