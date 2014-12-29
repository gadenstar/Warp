<?php
/**
 * Warp functions and definitions
 *
 * @package Warp
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'warp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function warp_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Warp, use a find and replace
	 * to change 'warp' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'warp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'warp' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'warp_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // warp_setup
add_action( 'after_setup_theme', 'warp_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function warp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'warp' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'warp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function warp_scripts() {
	wp_enqueue_style( 'uikit-style', get_template_directory_uri() . '/inc/css/uikit.min.css' );
	wp_enqueue_style( 'flat-style', get_template_directory_uri() . '/inc/css/uikit.almost-flat.min.css' );

	wp_enqueue_style( 'warp-style', get_stylesheet_uri() );

	wp_enqueue_script( "jquery" );

	wp_enqueue_script( 'uikit', get_template_directory_uri() . '/inc/js/uikit.min.js', array(), '20120206');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'warp_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/*
Plugin Name: DW Replace Open Sans
Plugin URI: http://devework.com/replace-open-sans.html
Description: 将WordPress 后台中的open-sans字体加载源从Google Fonts替换为360的CDN加载源。
Author: Jeff
Author URI: http://devework.com/
Version: 1.0
Text Domain: dw-replace-open-sans
*/
 
function devework_replace_open_sans() {
	wp_deregister_style('open-sans');
	wp_register_style( 'open-sans', '//fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600' );
	wp_enqueue_style( 'open-sans');
}
add_action( 'wp_enqueue_scripts', 'devework_replace_open_sans' );
add_action('admin_enqueue_scripts', 'devework_replace_open_sans');


function v7v3_get_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),
"cd.v7v3.com",$avatar);
    return $avatar;
}
add_filter( 'get_avatar', 'v7v3_get_avatar', 10, 3 );

/*
* 移除后台页面logo
*/

function annointed_admin_bar_remove() {
        global $wp_admin_bar;
 
        /* Remove their stuff */
        $wp_admin_bar->remove_menu('wp-logo');
}
 
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);