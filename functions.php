<?php

/**
 * Adds functionality(features) to the theme.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package UW Theme
 */

// check if uwmadison events plugin is already installed
function check_acf_plugin() {
	if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>It looks like you have the <b>Advanced Custom Fields</b> plugin activated. The <abbr>UW</abbr> Theme bundles Advanced Custom Fields Pro. The theme will not work if the Advanced Custom Fields plugin is also active; please deactivate it.</p></div>';
		});
	}
	if ( is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>It looks like you have the <b>Advanced Custom Fields Pro</b> plugin activated. The <abbr>UW</abbr> Theme bundles Advanced Custom Fields Pro. While the theme will still work if the Advanced Custom Fields Pro plugin is installed, it’s best to deactivate it.</p></div>';
		});
	}
	if ( is_plugin_active('uw-madison-events-calendar/uwmadison_events.php') ) {
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>It looks like you have the <b><abbr>UW</abbr> Events</b> plugin activated. The <abbr>UW</abbr> Theme bundles this plugin. It’s best to deactive the plugin and rely on the version used in the theme.</p></div>';
		});
	}
	return;
}
add_action( 'admin_init', 'check_acf_plugin' );


/**
 * Add Advanced Custom Fields(ACF) to theme. No need to activate this plugin
 * @link https://www.advancedcustomfields.com/
*/
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path( $path ) {

		// update path
		$path = get_template_directory() . '/advanced-custom-fields-pro/';

		// return
		return $path;

}

add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

		// update path
		$dir = get_template_directory_uri() . '/advanced-custom-fields-pro/';

		// return
		return $dir;

}
include_once( get_template_directory() . '/advanced-custom-fields-pro/acf.php' );


// saving acf-json for child themes
add_filter('acf/settings/save_json', function() {
	return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
	$paths = array(get_template_directory() . '/acf-json');

	if(is_child_theme())
	{
		$paths = array(
            get_stylesheet_directory() . '/acf-json',
            get_template_directory() . '/acf-json'
        );
	}

	return $paths;
});

/**
 * File includes
 *
 * The array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 */
$uwmadison_includes = array(
	'lib/custom-acf.php',
	'lib/customizer.php',   // Theme customizer
	'lib/custom-fields.php', // Advanced Custom Fields
	'lib/template-tags.php', // Custom template tags
	'lib/shortcodes.php', // Custom shortcodes
	'lib/aria-walker-nav-menu.php', // WAI-ARIA Navigation Menu
	'lib/custom-post-types-taxonomies.php', // Custom Post Types
	'lib/page-builder.php',
	'lib/breadcrumbs.php',
	'lib/tool-page-converter.php',
	'lib/vendor/uw-madison-events-calendar/uwmadison_events.php'
);

foreach ($uwmadison_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'uw-theme'), $file), E_USER_ERROR);
	}

	require_once $filepath;
}
unset($file, $filepath);

if ( WP_DEBUG ) {
	@ini_set( 'display_errors', 1 );

	add_action('wp_footer', 'show_template');

	function show_template() {
			 global $template;
					 echo '<!--'.$template.'-->';
	}
} else {
	function remove_wp_version() {
		return '';
	}
	add_filter('the_generator', 'remove_wp_version');
}

/**
 * Theme only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/lib/back-compat.php';
}


if ( ! function_exists( 'uwmadison_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own uwmadison_setup() function to override in a child theme.
	 *
	 */
	function uwmadison_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on this theme, use a find and replace
		 * to change 'uw-theme' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'uw-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * @link http://codex.wordpress.org/Post_Thumbnails
		 * @link http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
		 * @link http://codex.wordpress.org/Function_Reference/add_image_size
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		/*
		 * Register wp_nav_menu() menus
		 * This theme uses wp_nav_menu() in two locations.
		 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus( array(
			'main_menu' => esc_html__( 'Main Menu', 'uw-theme' ),
			'utility_menu'  => esc_html__( 'Utility Links Menu', 'uw-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// add custom image size
		add_image_size( 'uw-hero', 1600, 500, true );
		add_image_size( 'uw-2panel-slider', 600, 400, true );
		add_image_size( 'uw-3x2', 900, 600, true );
		add_image_size( 'uw-headshot', 400, 400, true );

		// add edit_theme_options to Editor role
		$editor_role = get_role( 'editor' );
		$editor_role->add_cap( 'edit_theme_options' );
	}
endif;
add_action( 'after_setup_theme', 'uwmadison_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @link https://codex.wordpress.org/Content_Width
 */
function uwmadison_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uwmadison_width', 640 );
}
add_action( 'after_setup_theme', 'uwmadison_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists( 'uwmadison_widgets_init' ) ) :
	/**
	 * Register our widgetized sidebar.
	 *
	 * @return void
	 */
	function uwmadison_widgets_init() {

		register_sidebar( array(
			'name' => __( 'Blog Sidebar', 'uw-theme' ),
			'id' => 'sidebar-blog',
			'before_widget' => '<aside id="%1$s" class="widget uw-content-box %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		register_sidebar( array(
			'name' => __( 'Archive Sidebar', 'uw-theme' ),
			'id' => 'sidebar-archive',
			'before_widget' => '<aside id="%1$s" class="widget uw-content-box %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

	}
endif;
add_action( 'widgets_init', 'uwmadison_widgets_init' );


if ( ! function_exists( 'set_uwmadison_body_classes' ) ) :
	/**
	 * Adds classes to the array of body classes.
	 * - column number
	 * - column order
	 * - background color
	 * - author type
	 * - singular post
	 * Applies the uwmadison_layout_classes() filter
	 *
	 * @since UW-Madison 1.0
	 */
	function set_uwmadison_body_classes( $classes ) {
		global $post;

		// set body background color option class
		$body_bgcolor_class = (get_theme_mod('uwmadison_body_bg','uw-white-bg') == "uw-white-bg") ? "uw-white-bg" : "uw-light-gray-bg";
		$classes[] = $body_bgcolor_class;

		// set author class
		if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
			$classes[] = 'single-author';

		// set singular class
		if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
			$classes[] = 'singular';

		// apply filter
		$classes = apply_filters( 'uwmadison_body_classes', $classes );

		return $classes;
	}
endif;
add_filter( 'body_class', 'set_uwmadison_body_classes' );


// Google Fonts
if ( ! function_exists( 'uwmadison_add_google_fonts' ) ) :
	/**
	 * Adds Google fonts for DoIT Starter. This enqueues the fonts as an alternative to
	 * including the link in header.php.
	 *
	 * Create your own uwmadison_fonts_url() function to override in a child theme.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function uwmadison_add_google_fonts() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
		 * Use one of these font blocks for each google font you wish to use.
		 */
		// if ( 'off' !== _x( 'on', 'Josefin Sans font: on or off', 'uw-theme' ) ) {
		// 	 /* translators: If there are characters in your language that are not supported by Josefin Sans, translate this to 'off'. Do not translate into your own language. */
		// 	$fonts[] = 'Josefin Sans:400,600,700,400italic';
		// }

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;


if ( ! function_exists( 'uwmadison_widgets_classes' ) ) :
	/**
	 * Add the uw-content-box class to sidebar widgets
	 *
	 * @param Array $params The widget's params
	 * @return Array The filtered params
	 **/
	function uwmadison_widgets_classes($params) {
		global $widget_classes;

		if ( $params[0]['name'] == "Main Sidebar" ) {
			$before_widget_string = $params[0]['before_widget'];
			$params[0]['before_widget'] = str_replace('class="', 'class="uw-content-box ' . $widget_classes[$params[0]['widget_id']], $before_widget_string);
		}

		return $params;
	}
	add_filter( 'dynamic_sidebar_params', 'uwmadison_widgets_classes', 10);
endif; // uwmadison_widgets_classes


if ( ! function_exists( 'uwmadison_auto_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis.
	 *
	 * To override this in a child theme, remove the filter and add your own
	 * function tied to the excerpt_more filter hook.
	 */
	function uwmadison_auto_excerpt_more( $more ) {
		return ' &hellip;';
	}
endif;
add_filter( 'excerpt_more', 'uwmadison_auto_excerpt_more' );


if ( ! function_exists( 'uwmadison_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 35 words.
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function uwmadison_custom_excerpt_length( $length ) {
			return 35;
	}
endif;
add_filter( 'excerpt_length', 'uwmadison_custom_excerpt_length', 999 );


/**
 * Adds the excerpt to pages
 *
 * @return void
 **/
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
		 add_post_type_support( 'page', 'excerpt' );
}


if ( ! function_exists( 'uwmadison_page_menu_args' ) ) :
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 */
	function uwmadison_page_menu_args( $args ) {
		$args['show_home'] = true;
		$args['menu_class'] = $args['container_class'];
		return $args;
	}
endif;
add_filter( 'wp_page_menu_args', 'uwmadison_page_menu_args' );


if ( ! function_exists( 'uwmadison_scripts' ) ) :

	/**
	 * Enqueues scripts and styles.
	 *
	 */
	function uwmadison_scripts() {
		// enqueue UW fonts
		wp_register_style( 'uwmadison-fonts', get_template_directory_uri() . '/dist/fonts/uw160/fonts.css', false, '1.0.0-beta.3' );
		wp_enqueue_style( 'uwmadison-fonts' );

		// Add custom fonts, used in the main stylesheet.
		wp_register_style( 'uwmadison-google-fonts', uwmadison_add_google_fonts(), false, '1.0.0-beta.3' );
		wp_enqueue_style( 'uwmadison-google-fonts' );


		wp_register_script( 'uwmadison-ie', get_template_directory_uri() . '/dist/js/polyfills/classList.js', false, '1.0.0-beta.3', true );
		wp_enqueue_script( 'uwmadison-ie' );
		wp_script_add_data( 'uwmadison-ie', 'conditional', 'lt IE 10' );

		// deregister WP's jQuery; register jQuery 2 for Foundation dependency
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_template_directory_uri() . '/dist/js/jquery/jquery.min.js' , false, '2.2.4', true );

		// Theme assets.
		if ( !WP_DEBUG ) {
			wp_register_style( 'uwmadison-style', get_template_directory_uri() . '/dist/main.min.css' , false, '1.0.0-beta.3' );
			wp_enqueue_style( 'uwmadison-style' );
			wp_register_script( 'uwmadison-script', get_template_directory_uri() . '/dist/main.min.js', array('jquery'), '1.0.0-beta.3', true );
			wp_enqueue_script( 'uwmadison-script' );
		} else {
			wp_register_style( 'uwmadison-style', get_template_directory_uri() . '/dist/main.css' , false, '1.0.0-beta.3' );
			wp_enqueue_style( 'uwmadison-style' );
			wp_register_script( 'uwmadison-script', get_template_directory_uri() . '/dist/main.js', array('jquery'), '1.0.0-beta.3', true );
			wp_enqueue_script( 'uwmadison-script' );
		}

		// Load the Internet Explorer specific stylesheet.
		wp_register_style( 'uwmadison-ie', get_template_directory_uri() . '/dist/css/ie.css', array( 'uwmadison-style' ), '1.0.0-beta.3' );
		wp_enqueue_style( 'uwmadison-ie' );
		wp_style_add_data( 'uwmadison-ie', 'conditional', 'lt IE 10' );

		if (is_single() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

	}

endif;
add_action( 'wp_enqueue_scripts', 'uwmadison_scripts' );


/**
 * Test if the site is using search or not
 *
 * @return boolean
 **/
function site_uses_search() {
	return get_theme_mod('uwmadison_use_search', false);
}


/**
 * Returns the GCSE ID isf set or false of not
 *
 * @return String GCSE ID or false
 **/
function gcse_id() {
	return get_theme_mod('uwmadison_google_cse_id', false);
}


/**
 * Test if the site is using a GCSE or not
 *
 * @return boolean
 **/
function site_uses_google_search() {
	return site_uses_search() && gcse_id();
}


/**
 * Test if the site has a main menu
 *
 * @return boolean
 **/
function has_main_menu() {
	$use_fallback_menu = get_theme_mod('uwmadison_menu_pages_fallback', false);
	return has_nav_menu('main_menu') || ($use_fallback_menu && !has_nav_menu('main_menu'));
}


/**
 * Test if the site has a secondary menu
 *
 * @return boolean
 **/
function has_secondary_menu() {
	$use_fallback_menu = get_theme_mod('uwmadison_menu_pages_fallback', false);
	return has_nav_menu('utility_menu');
}


/**
 * Test if the site should use the fallback menu function
 *
 * @return boolean
 **/
function uses_fallback_menu() {
	$use_fallback_menu = get_theme_mod('uwmadison_menu_pages_fallback', false);
	return !has_nav_menu('main_menu') && $use_fallback_menu;
}


/**
 * Test if the site has any menus
 *
 * @return boolean
 **/
function has_any_menus() {
	return has_main_menu() || has_secondary_menu();
}

/**
 * Filter out search query param if site is using GCSE
 * so we avoid an unnecessary query
 *
 * @return void
 **/
function filter_search_query( $query, $error = true ) {
	$gcse_id = site_uses_google_search();
	if ( is_search() && $gcse_id ) {
		$query->query_vars['s'] = false;
		$query->query['s'] = false;
	}
}
add_action( 'parse_query', 'filter_search_query' );


if ( ! function_exists( 'uwmadison_search_join' ) ) :

	/**
	 * Extends WP native search to join on terms tables
	 *
	 * @return String JOIN SQL part
	 **/
	function uwmadison_search_join( $join ){
		global $wpdb;
		if( is_search() && !site_uses_google_search() ) {
			$join .= "LEFT JOIN " . $wpdb->term_relationships. "
							ON " . $wpdb->posts . ".ID = ". $wpdb->term_relationships . ".object_id
							LEFT JOIN " . $wpdb->term_taxonomy . "
							ON " . $wpdb->term_taxonomy . ".term_taxonomy_id = " . $wpdb->term_relationships . ".term_taxonomy_id
							LEFT JOIN " . $wpdb->terms . "
							ON " . $wpdb->terms . ".term_id = " . $wpdb->term_taxonomy . ".term_id
							LEFT JOIN " . $wpdb->postmeta . "
							ON " . $wpdb->posts . ".ID = " . $wpdb->postmeta . ".post_id";
		}
		return $join;
	}

endif;
if (!is_admin()){ add_filter('posts_join', 'uwmadison_search_join' ); }


if ( ! function_exists( 'uwmadison_search_where' ) ) :
	/**
	 * Extends WP native search to also search against category and tag terms
	 *
	 * @return String WHERE SQL part
	 **/
	function uwmadison_search_where( $where ){
		global $wpdb;
		$s = $wpdb->esc_like(get_query_var( 's' ));
		if( is_search() && !site_uses_google_search() ) {
			$where = preg_replace(
							"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
							"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1 AND ("
									.$wpdb->postmeta.".meta_key LIKE '%text_block_content' OR "
									.$wpdb->postmeta.".meta_key LIKE '%quote_text' OR "
									.$wpdb->postmeta.".meta_key LIKE '%accordion_panel_title' OR "
									.$wpdb->postmeta.".meta_key LIKE '%accordion_panel_body' OR "
									.$wpdb->postmeta.".meta_key LIKE '%tab_title' OR "
									.$wpdb->postmeta.".meta_key LIKE '%tab_body' OR "
									.$wpdb->postmeta.".meta_key LIKE '%alternating_content_headline' OR "
									.$wpdb->postmeta.".meta_key LIKE '%alternating_content_text' OR "
									.$wpdb->postmeta.".meta_key LIKE '%link_display_name'
								))", $where );
			$where .= " OR " . $wpdb->terms . ".name LIKE '%$s%' AND " . $wpdb->term_taxonomy . ".taxonomy IN ('category','post_tag','uw_staff_type','uw_document_type')";
		}
		return $where;
	}

endif;
if (!is_admin()){ add_filter('posts_where', 'uwmadison_search_where' ); }


/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
		global $wpdb;

		if ( is_search() ) {
			return "DISTINCT";
		}

		return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


if ( ! function_exists( 'add_google_analytics' ) ) :

	/**
	 * Add GA tracking code in footer
	 *
	 * @return void
	 **/
	function add_google_analytics() {
		if ( is_user_logged_in() )
			return false;

		$ga_tracking_id = get_theme_mod('uwmadison_ga_tracking_id', false);

		if (!$ga_tracking_id)
			return false;
		?>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo $ga_tracking_id ?>', 'auto');
			ga('send', 'pageview');
		</script>

	<?php }

endif;
add_action('wp_footer', 'add_google_analytics');

/**
 * return whether the site is using breadcrumbs or not
 *
 * @return boolean
 **/
function site_uses_breadcrumbs() {
	return get_theme_mod('uwmadison_breadcrumbs', true);
}


/**
 * get_svg function grabs symbol from SVG/XML object, processes, and returns for embedding in HTML.
 **/
function get_svg($symbol_id, array $args = array()) {

	// Create XML object that will be used by get_svg function throughout theme.
	$oSVGXML = simplexml_load_file(get_template_directory() . '/dist/images/uw-icons.svg');

	// Add or override whatever SVG attributes you want simply by including them in the args array.
	// SVG attributes in SVG file override defaults below.
	// Then function parameters override attributes in SVG file.
	// Some examples of $args array keys are: title, role, width, length, class, and addclasses
	// Two array keys are special and are added to the SVG as child nodes (or override existing nodes): title and desc
	// global $oSVGXML;
	// Set up defaults
	$aDefault = array(
		'version'=>'1.1',
		'title'=>'This image needs a title.',
		'role'=>'img'
	);
	$oSVG = $oSVGXML->xpath("//*[@id='" . $symbol_id . "']");
	$oXML = $oSVG[0];
	// Get nodes/attributes that can override or add to defaults
	$aSymbolDefaults = array();
	if (property_exists($oXML, 'title')) {
		$aSymbolDefaults['title'] = (string)$oXML->title;
	}
	if (isset($oXML['role'])) {
		$aSymbolDefaults['role'] = $oXML['role'];
	}
	$aDefaultSymbol = array_merge($aDefault, $aSymbolDefaults);
	// Get function parameters that can override or add to defaults and svg symbol
	$aDefaultSymbolParms = array_merge($aDefaultSymbol, $args);
	// Alter svg/xml based on final array
	foreach($aDefaultSymbolParms as $key => $value) {
		if (strtolower($key) == "title") {
			$oXML->title = $value;
		} elseif (strtolower($key) == "desc") {
			$oXML->desc = $value;
		} elseif (strtolower($key) == "addclasses") {
			// Process this later
		}	else {
			$oXML[$key] = $value;
		}
	}
	if (array_key_exists('addclasses', $aDefaultSymbolParms)) {
		if (strlen($oXML['class']) >= 1) {
			$oXML['class'] = $oXML['class'] . ' ' . $aDefaultSymbolParms['addclasses'];
		} else {
			$oXML['class'] = $aDefaultSymbolParms['addclasses'];
		}
	}
	// If there is a title, add aria-labelledby
	if (property_exists($oXML, 'title')) {
		if (isset($oXML->title['id'])) {
			$oXML['aria-labelledby'] = (string)$oXML->title['id'];
		} else {
			$sGeneratedID = uniqid('dynid');
			$oXML->title['id'] = $sGeneratedID;
			$oXML['aria-labelledby'] = $sGeneratedID;
		}
	}
	// If there is a desc, add aria-describedby
	if (property_exists($oXML, 'desc')) {
		if (isset($oXML->desc['id'])) {
			$oXML['aria-describedby'] = (string)$oXML->desc['id'];
		} else {
			$sGeneratedID = uniqid('dynid');
			$oXML->desc['id'] = $sGeneratedID;
			$oXML['aria-describedby'] = $sGeneratedID;
		}
	}
	// Return svg result for embedding in html
	return(str_ireplace(' id="'.$symbol_id.'"','',str_ireplace('</symbol>','</svg>',str_ireplace('<symbol ','<svg ',$oXML->asXML()))));
}


if ( ! function_exists( 'news_oembed_filter' ) ) :

	/**
	 * Wrap oembeds in a div for use as a responsive hook
	 *
	 * @return String The oembed markup
	 **/
	function news_oembed_filter($html, $url, $attr, $post_ID) {
		if ( strpos($url, "soundcloud") ) {
			$css_classes = "uw-oembed-soundcloud";
		} elseif ( strpos($url, "youtube") ) {
			$css_classes = " uw-oembed-video uw-oembed-video-youtube";
		} elseif ( strpos($url, "vimeo") ) {
			$css_classes = " uw-oembed-video uw-oembed-video-vimeo";
		} elseif ( strpos($url, "twitter") ) {
			$css_classes = " uw-oembed-twitter";
		} elseif ( strpos($url, "instagram") ) {
			$css_classes = " uw-oembed-instagram";
		} elseif ( strpos($url, "vine") ) {
			$css_classes = " uw-oembed-vine";
		} else {
			$css_classes = "";
		}
		$return = '<div class="uw-oembed'. $css_classes . '">'.$html.'</div>';
		return $return;
	}

endif;
add_filter( 'embed_oembed_html', 'news_oembed_filter', 10, 4 ) ;


if ( ! function_exists( 'uwmadison_posts_pagination' ) ) :
	/**
	 * filter posts pagination template
	 *
	 * @return String template markup
	 * @author
	 **/
	function uwmadison_posts_pagination( $template, $class) {

		if ("pagination" != $class && "page-links" != $class)
			return $template;

		$links = paginate_links(
			array(
				'mid_size' => 2,
				'type' => 'array',
				'prev_text' => 'Previous <span class="show-for-sr">page</span>',
				'next_text' => 'Next <span class="show-for-sr">page</span>'
			)
		);

		$new_template = '<div class="pagination-container"><ul class="pagination" role="navigation" aria-label="Pagination">';

		foreach ($links as $key => $link) {
			$li_classes = array();
			$li_start = '';
			if (strpos($link,"prev page-numbers") !== false)
				$li_classes[] = "pagination-previous";
			if (strpos($link,"next page-numbers") !== false)
				$li_classes[] = "pagination-next";
			if (strpos($link,"page-numbers current") !== false) {
				$li_classes[] = "current";
				$link = "<span class=\"show-for-sr\">You're on page</span> " . strip_tags($link);
			}
			if (!empty($li_classes)) {
				$li_start .= '<li class="' . join(" ", $li_classes) . '">';
			} else {
				$li_start .= '<li>';
			}
			if (strpos($link,"page-numbers dots") !== false) {
				$li_start = '<li class="ellipsis" aria-hidden="true">';
				$link = '';
			}
			$new_template .= $li_start;
			$new_template .= $link;
			$new_template .= '</li>';
		}
		$new_template .= '</ul></div>';
		return $new_template;
	}
endif;
add_filter( 'navigation_markup_template', 'uwmadison_posts_pagination', 10 ,2 );


/**
 * Remove TinyMCE buttons from full toolbar in ACF wysiwygs
 *
 * @return Array
 **/
function uwmadison_wysiwyg_toolbars($toolbars)
 {
 		// define array of buttons to remove from the full toolbar
		$remove_from_full = array('forecolor');
		foreach ($remove_from_full as $value) {
			// search second row first; it's more likely where we'll remove buttons from
			if( ($key = array_search($value, $toolbars['Full' ][2])) !== false ) {
			  unset( $toolbars['Full' ][2][$key] );
			} elseif( ($key = array_search($value, $toolbars['Full' ][1])) !== false ) {
			  unset( $toolbars['Full' ][1][$key] );
			}
		}
		return $toolbars;
 }
add_filter('acf/fields/wysiwyg/toolbars','uwmadison_wysiwyg_toolbars');


/**
 * Rename theme modifications after activation if options
 * for the new theme name have not been set yet (aside from
 * the default 2 — the two registered menus)
 *
 * @return void
 **/
function copy_theme_mods () {
	$old_options = get_option("theme_mods_uw-theme");
	$new_options = get_option("theme_mods_uw-theme");
	if ( !empty($old_options) && isset($new_options) && count($new_options) == 2) {
		update_option( 'theme_mods_uw-theme', $old_options );
	}
}
add_action('after_switch_theme', 'copy_theme_mods');


if ( ! function_exists( 'uwmadison_archive_title' ) ) :

	/**
	 * Modifies the archive title output to strip words like
	 * 'Archive', 'Category', and 'Tag'.
	 *
	 **/
	function uwmadison_archive_title( $title ) {
	    if ( is_category() ) {
	        $title = single_cat_title( '', false );
	    } elseif ( is_tag() ) {
	        $title = single_tag_title( '', false );
	    } elseif ( is_author() ) {
	        $title = '<span class="vcard">' . get_the_author() . '</span>';
	    } elseif ( is_post_type_archive() ) {
	        $title = post_type_archive_title( '', false );
	    } elseif ( is_tax() ) {
	        $title = single_term_title( '', false );
	    }

	    return $title;
	}

endif;
add_filter( 'get_the_archive_title', 'uwmadison_archive_title' );


if ( ! function_exists( 'uwmadison_add_custom_types' ) ) :

	/**
	 * Modifies the archive query to include any custom post types
	 *
	 **/
	function uwmadison_add_custom_types( $query ) {
	  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
	    if ( !is_post_type_archive() && $query->is_archive() ) {
	      $post_types = get_post_types( '', 'names' );
	      $query->set( 'post_type', $post_types);
	      return $query;
	    }
	  }
	}

endif;
add_filter( 'pre_get_posts', 'uwmadison_add_custom_types' );


if ( ! function_exists( 'uwmadison_customize_tmce' ) ) :

	/**
	 * Limit TMCE block formats to p,h2-6
	 *
	 * @return Array The TMCE options arrays
	 **/
	function uwmadison_customize_tmce($options) {
	  $options['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
	  return $options;
	}

endif;
add_filter('tiny_mce_before_init', 'uwmadison_customize_tmce');


if ( ! function_exists( 'uwmadison_page_title' ) ) :

	/**
	 * Add UW–Madison to end of page titles
	 *
	 * @return Array The TMCE options arrays
	 **/
	function uwmadison_page_title( $title ) {
		if ( isset($title['site']) ) {
			$title['site'] .= " - UW–Madison";
		} else {
			$title['site'] = "UW–Madison";
		}
	  return $title;
	}

endif;
add_filter( 'document_title_parts', 'uwmadison_page_title', 999, 1 );


/**
 * Loads select field with child theme's custom post types in latest_posts acf
 *
 **/

function load_custom_posts( $field ) {
    //only show custom public post types
    $args = array(
        'public'   => true,
        '_builtin' => false
    );
    $post_types = get_post_types( $args );
	// exclude uw_staff from selection
	unset($post_types['uw_staff']);
    $field['choices'] = array(
        'Custom Posts' => $post_types
    );
    return $field;
}
//filter by field's name
add_filter('acf/load_field/name=custom_post_type', 'load_custom_posts');

