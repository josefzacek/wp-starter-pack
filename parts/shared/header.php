<header>
	<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<?php bloginfo( 'description' ); ?>
	<?php get_search_form(); ?>
	
	
	
   <a href="<?php echo home_url(); ?>"> 
    	<img src="<?php bloginfo('template_url'); ?>/images/IMAGE-HERE" alt="">
   </a>
    
   <nav>
   	<?php
       		$defaults = array('container' => false);
		wp_nav_menu(); 
	?>        
    </nav>
</header>
