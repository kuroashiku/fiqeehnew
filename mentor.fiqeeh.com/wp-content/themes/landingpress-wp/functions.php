<?php
/**
 * LandingPress functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'LANDINGPRESS_URL', 'http://member.landingpress.net' );
define( 'LANDINGPRESS_THEME_NAME', 'LandingPress WordPress Theme 3.0 (ID)' );
define( 'LANDINGPRESS_THEME_ID', 98382 );
define( 'LANDINGPRESS_THEME_SLUG', 'landingpress-wp' );
define( 'LANDINGPRESS_THEME_VERSION', '3.4.1' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 750; /* pixels */
}

if ( ! function_exists( 'landingpress_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function landingpress_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on LandingPress, use a find and replace
	 * to change 'landingpress' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'landingpress-wp', get_template_directory() . '/languages' );

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
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 570, 320, true );
	add_image_size( 'post-thumbnail-medium', 300, 200, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'header' => esc_html__( 'Header Menu', 'landingpress-wp' ),
		'footer' => esc_html__( 'Footer Menu', 'landingpress-wp' ),
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
	// add_theme_support( 'post-formats', array(
	// 	'aside', 'image', 'video', 'quote', 'link',
	// ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'landingpress_custom_background_args', array(
		'default-color' => '',
		'default-image' => '',
		'wp-head-callback' => '__return_false',
	) ) );

	add_theme_support( 'custom-header', apply_filters( 'landingpress_custom_header_args', array(
		'width'                  => 960,
		'height'                 => 300,
		'default-image'          => '',
		'default-text-color'     => '',
		'flex-width'             => true,
		'flex-height'            => true,
	) ) );

	add_editor_style();

	add_theme_support( 'wc-product-gallery-lightbox' );

	if ( ! get_theme_mod('landingpress_wc_product_gallery_slider_disable') ) {
		add_theme_support( 'wc-product-gallery-slider' );
	}
	else {
		remove_theme_support( 'wc-product-gallery-slider' );
	}

	if ( ! get_theme_mod('landingpress_wc_product_gallery_zoom_disable') ) {
		add_theme_support( 'wc-product-gallery-zoom' ); 
	}
	else {
		remove_theme_support( 'wc-product-gallery-zoom' ); 
	}

}
endif; // landingpress_setup
add_action( 'after_setup_theme', 'landingpress_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function landingpress_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'landingpress-wp' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	for ($i=1; $i <=3 ; $i++) { 
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer #%s', 'landingpress-wp' ), $i ),
			'id'            => 'footer-'.$i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	register_sidebar( array(
		'name'          => esc_html__( 'Header', 'landingpress-wp' ),
		'id'            => 'header',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'landingpress_widgets_init' );

add_action( 'admin_notices', 'landingpress_show_license_status', 1 );
function landingpress_show_license_status() {
	echo '<style>';
	echo '.landingpress-message {padding: 20px !important;}';
	echo '.landingpress-message-inner {overflow:hidden;}';
	echo '.landingpress-message-icon {float:left;width:35px;height:35px;padding-right:20px;}';
	echo '.landingpress-message-button {float:right;padding:3px 0 0 20px;}';
	echo '</style>';
	$screen = get_current_screen();
	if ( isset( $screen->id ) && 'toplevel_page_landingpress' == $screen->id ) {
		return;
	}
	$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
	if ( in_array( $status, array( 'valid' ) ) ) {
		return;
	}
	echo '<div class="error landingpress-message"><div class="landingpress-message-inner">';
	echo '<div class="landingpress-message-icon">';
	echo '<img src="'.get_template_directory_uri().'/assets/images/landingpress.png" width="35" height="35" alt=""/>';
	echo '</div>';
	echo '<div class="landingpress-message-button">';
	echo '<a href="'.admin_url('admin.php?page=landingpress').'" class="button button-primary">'.( 'expired' == $status ? esc_html__( 'Perpanjang LandingPress', 'landingpress-wp' ) : esc_html__( 'Aktifkan LandingPress', 'landingpress-wp' ) ).'</a>';
	echo '</div>';
	if ( 'expired' == $status ) {
		echo '<strong>'.esc_html__( 'Masa Aktif LandingPress WordPress Theme Telah Berakhir.', 'landingpress-wp' ).'</strong> '.esc_html__( 'Silahkan perpanjang lisensi LandingPress untuk mendapatkan update terbaru, support teknis, dan akses ke LandingPress template library.', 'landingpress-wp' );
	}
	else {
		echo '<strong>'.esc_html__( 'Selamat Datang di LandingPress WordPress Theme.', 'landingpress-wp' ).'</strong> '.esc_html__( 'Silahkan aktifkan lisensi LandingPress untuk mendapatkan update otomatis, support teknis, dan akses ke LandingPress template library.', 'landingpress-wp' );
	}
	echo '</div></div>';
}

add_action( 'admin_notices', 'landingpress_show_memory_status', 2 );
function landingpress_show_memory_status() {
	$screen = get_current_screen();
	$allowed_screens = array(
		'toplevel_page_landingpress',
		'landingpress_page_landingpress-install-plugins',
		'appearance_page_landingpress-wp-license',
		'update-core',
		'themes',
		'plugins'
	);
	if ( !isset( $screen->id ) ) {
		return;
	}
	if ( ! in_array( $screen->id, $allowed_screens ) ) {
		return;
	}
	echo '<style>';
	echo '.landingpress-message {padding: 20px !important;}';
	echo '.landingpress-message-inner {overflow:hidden;}';
	echo '.landingpress-message-icon {float:left;width:35px;height:35px;padding-right:20px;}';
	echo '.landingpress-message-button {float:right;padding:3px 0 0 20px;}';
	echo '.landingpress-message-error {color:#dc3232}';
	echo '</style>';
	$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
	if ( ! in_array( $status, array( 'valid' ) ) ) {
		return;
	}
	$phpmemory = @ini_get( 'memory_limit' );
	$wpmemory = WP_MEMORY_LIMIT;
	$wpmemory_num = str_replace( 'M', '', $wpmemory );
	if ( $wpmemory_num >= 64 ) {
		return;
	}
	echo '<div class="error landingpress-message"><div class="landingpress-message-inner">';
	echo '<div class="landingpress-message-icon">';
	echo '<img src="'.get_template_directory_uri().'/assets/images/landingpress.png" width="35" height="35" alt=""/>';
	echo '</div>';
	echo '<div class="landingpress-message-button">';
	echo '<a href="'.admin_url('admin.php?page=landingpress-system-check').'" class="button button-primary">'.esc_html__( 'System Check', 'landingpress-wp' ).'</a>';
	echo '</div>';
	echo '<strong>'.sprintf( esc_html__( 'PHP Memory Limit = %s', 'landingpress-wp' ), $phpmemory ).'<br/>'.sprintf( esc_html__( 'WordPress Memory Limit = %s', 'landingpress-wp' ), '<span class="landingpress-message-error">'.$wpmemory.'<span>' ).'</strong> <br>'.esc_html__( 'Kami sangat merekomendasikan Anda untuk menaikkan WordPress Memory Limit menjadi menjadi minimum 64M ke atas, direkomendasikan 256M, supaya semua fitur di WordPress bisa berjalan dengan baik.', 'landingpress-wp' );
	echo '</div></div>';
}

add_action( 'admin_notices', 'landingpress_show_wpdebug_status', 3 );
function landingpress_show_wpdebug_status() {
	$wpdebug = defined('WP_DEBUG') && WP_DEBUG ? true : false;
	if (!$wpdebug) {
		return false;
	}
	echo '<style>';
	echo '.landingpress-message {padding: 20px !important;}';
	echo '.landingpress-message-inner {overflow:hidden;}';
	echo '.landingpress-message-icon {float:left;width:35px;height:35px;padding-right:20px;}';
	echo '.landingpress-message-button {float:right;padding:3px 0 0 20px;}';
	echo '.landingpress-message-error {color:#dc3232}';
	echo '</style>';
	echo '<div class="error landingpress-message"><div class="landingpress-message-inner">';
	echo '<div class="landingpress-message-icon">';
	echo '<img src="'.get_template_directory_uri().'/assets/images/landingpress.png" width="35" height="35" alt=""/>';
	echo '</div>';
	echo '<strong>'.esc_html__( 'Status WP_DEBUG sedang aktif!', 'landingpress-wp' ).'</strong> '.esc_html__( 'WP_DEBUG seringkali digunakan oleh developer untuk melakukan debugging atau mencari permasalahan teknis yang terjadi di sebuah website WordPress. Harap non-aktif-kan WP_DEBUG kembali setelah selesai melakukan debugging, khususnya untuk website yang sedang aktif dipakai (live/production).', 'landingpress-wp' );
	echo '</div></div>';
}

function landingpress_register_scripts() {
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/assets/lib/magnific-popup/jquery.magnific.popup.min.css', array(), '1.1.1' );
	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/assets/lib/magnific-popup/jquery.magnific.popup.min.js', array('jquery'), '1.1.1', true );
	wp_register_script( 'landingpress', get_template_directory_uri() . '/assets/js/script.min.js', array('jquery'), LANDINGPRESS_THEME_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		if ( get_theme_mod( 'landingpress_'.get_post_type().'_comments', '1' ) ) {
			global $landingpress_comment_reply_js;
			$landingpress_comment_reply_js = true;
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'landingpress_register_scripts', 5 );

function landingpress_enqueue_scripts() {
	wp_enqueue_script( 'landingpress' );
}
add_action( 'wp_footer', 'landingpress_enqueue_scripts', 15 );

function landingpress_enqueue_styles() {
	$stylesheet_name = is_rtl() ? 'style-rtl.css' : 'style.css';
	if ( is_child_theme() ) {
		wp_enqueue_style( 'landingpress-parent', trailingslashit( get_template_directory_uri() ) . $stylesheet_name, array(), LANDINGPRESS_THEME_VERSION );
	}
	if ( is_rtl() ) {
		$stylesheet_uri = trailingslashit( get_template_directory_uri() ) . $stylesheet_name;
	}
	else {
		$stylesheet_uri = get_stylesheet_uri();
	}
	wp_enqueue_style( 'landingpress', $stylesheet_uri, array(), LANDINGPRESS_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'landingpress_enqueue_styles', 25 );

include_once( get_template_directory() . '/inc/upgrades.php' );

add_action( 'customize_register', 'landingpress_customize_controls_register', 5 );
function landingpress_customize_controls_register( $wp_customize ){
	require_once( get_template_directory() . '/inc/customize-controls.php' );
}
include_once( get_template_directory() . '/inc/customize.php' );
include_once( get_template_directory() . '/inc/options.php' );

include_once( get_template_directory() . '/inc/frontend.php' );
include_once( get_template_directory() . '/inc/breadcrumb.php' );
include_once( get_template_directory() . '/inc/admin.php' );

include_once( get_template_directory() . '/inc/tgmpa.php' );

include_once( get_template_directory() . '/inc/metabox.php' );

if ( class_exists( 'woocommerce') ) {
	include_once( get_template_directory() . '/inc/woocommerce.php' );
}

include_once( get_template_directory() . '/addons/addons.php' );
