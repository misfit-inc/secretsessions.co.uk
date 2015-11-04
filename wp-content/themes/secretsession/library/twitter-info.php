<script src="<?php bloginfo ('template_url'); ?>/twitter/jquery.tweet.js" type="text/javascript"></script>
<script type="text/javascript">
	    	
	<?php $foo = get_bloginfo('template_url');
		  $blah = parse_url($foo); ?>
		jQuery(function($){
	        var options = {
	          username: "<?php echo get_option('misfit_twitter'); ?>",
		          modpath: '<?php echo $blah[path]; ?>/twitter/',
		          page: 1,
		          avatar_size: 32,
		          count: 1,
		          fetch: 5, // 1 + count
		          loading_text: "loading …"
	        };

	        var widget = $("#paging .widget"),
	          next = $("#paging .next"),
	          prev = $("#paging .prev");

	        var enable = function(el, yes) {
	          yes ? $(el).removeAttr('disabled') :
	                $(el).attr('disabled', true);
	        };

	        var stepClick = function(incr) {
	          return function() {
	            options.page = options.page + incr;
	            enable(this, false);
	            widget.tweet(options);
	          };
	        };

	        next.bind("checkstate", function() {
	          enable(this, widget.find("li").length == options.count)
	        }).click(stepClick(1));

	        prev.bind("checkstate", function() {
	          enable(this, options.page > 1)
	        }).click(stepClick(-1));

	        widget.tweet(options).bind("loaded", function() { next.add(prev).trigger("checkstate"); });
	      });
	      
</script>
