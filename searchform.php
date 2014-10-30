<!--
use this template for custom search form
-->

<form action="<?php echo home_url( '/' ); ?>" method="get">
		<input type="text" placeholder="Search" name="s" id="search" value="<?php the_search_query(); ?>" required/>
		<input type="image" alt="Search" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/search-button.png" />
</form>
