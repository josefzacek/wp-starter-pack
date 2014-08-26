<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */
	// Register Sidebar
	/*
	function sidebar_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Todays Menu' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Dnesni nabidka' ),
			'before_widget' => '<div id="todays-offer">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'News' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Aktuality' ),
			'before_widget' => '<div class="aside-news-inner">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'sidebar_widgets_init' );
	*/
	
	/* custom login logo */
	function my_login_logo() { ?>
	    <style type="text/css">
	        body.login div#login h1 a {
	        	background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/IMAGE_NAME_HERE);
			background-size:auto;
			width:auto;
	        	height: 97px;
	        }
	    </style>
	 <?php }
        add_action( 'login_enqueue_scripts', 'my_login_logo' );

	function my_login_logo_url() {
    	return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'my_login_logo_url' );

	function my_login_logo_url_title() {
	    return 'Neenan Cycling';
	}
	add_filter( 'login_headertitle', 'my_login_logo_url_title' );



	// remove <p> tag around images 
	function filter_ptags_on_images($content){
   		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
	add_filter('the_content', 'filter_ptags_on_images');

	// remove default wordpress gallery formating
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	// add data-lightbox="gallery" to wp gallery for use with lightbox
	add_filter('wp_get_attachment_link', 'rc_add_rel_attribute');
	function rc_add_rel_attribute($link) {
		global $post;
		return str_replace('<a href', '<a data-lightbox="gallery" href', $link);
	}
	
	// remove theme editor from apperance -> themes
	function remove_editor_menu() {
	  remove_action('admin_menu', '_add_themes_utility_last', 101);
	}
	add_action('_admin_menu', 'remove_editor_menu', 1);
	
	// add custom color to WYSIWYG editor 
	function my_mce4_options( $init ) {
	$default_colours = '
	    "000000", "Black",        "993300", "Burnt orange", "333300", "Dark olive",   "003300", "Dark green",   "003366", "Dark azure",   "000080", "Navy Blue",      "333399", "Indigo",       "333333", "Very dark gray", 
	    "800000", "Maroon",       "FF6600", "Orange",       "808000", "Olive",        "008000", "Green",        "008080", "Teal",         "0000FF", "Blue",           "666699", "Grayish blue", "808080", "Gray", 
	    "FF0000", "Red",          "FF9900", "Amber",        "99CC00", "Yellow green", "339966", "Sea green",    "33CCCC", "Turquoise",    "3366FF", "Royal blue",     "800080", "Purple",       "999999", "Medium gray", 
	    "FF00FF", "Magenta",      "FFCC00", "Gold",         "FFFF00", "Yellow",       "00FF00", "Lime",         "00FFFF", "Aqua",         "00CCFF", "Sky blue",       "993366", "Brown",        "C0C0C0", "Silver", 
	    "FF99CC", "Pink",         "FFCC99", "Peach",        "FFFF99", "Light yellow", "CCFFCC", "Pale green",   "CCFFFF", "Pale cyan",    "99CCFF", "Light sky blue", "CC99FF", "Plum",         "FFFFFF", "White"
	';
	$custom_colours = '
	    "CC911B", "Custom Gold", "294B8E", "Custom Blue"
	';
	$init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']'; // build colour grid default+custom colors
	$init['textcolor_rows'] = 6; // enable 6th row for custom colours in grid
	return $init;
	}
	add_filter('tiny_mce_before_init', 'my_mce4_options');
	
	/* ================================= remove featured image and page attributes meta box ================================= */

	add_action( 'add_meta_boxes', 'my_remove_post_meta_boxes' );

	function my_remove_post_meta_boxes() {
	
		
		/* Featured image meta box. */
		remove_meta_box( 'postimagediv', 'page', 'side' );
	
		/* Page attributes meta box. */
		//remove_meta_box( 'pageparentdiv', 'page', 'side' );
	}



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		wp_enqueue_script( 'jquery' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}	

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}
