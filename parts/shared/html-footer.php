
	<?php wp_footer(); ?>
	
	<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/scripts.js"></script>
	
	
	<!--	fits slideshow on load	-->
	<script>  
   		jQuery(window).bind("load", function(){ jQuery(window).resize(); });  
	</script>
	
	</body>
</html>
