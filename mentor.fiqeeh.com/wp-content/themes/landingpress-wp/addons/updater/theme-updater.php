<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD LandingPress
 * @version 1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
global $landingpress_updater;
$landingpress_updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => LANDINGPRESS_URL, 
		'item_name'      => LANDINGPRESS_THEME_NAME, 
		'item_id'        => LANDINGPRESS_THEME_ID, 
		'theme_slug'     => LANDINGPRESS_THEME_SLUG, 
		'version'        => LANDINGPRESS_THEME_VERSION, 
		'author'         => 'LandingPress', 
		'download_id'    => LANDINGPRESS_THEME_ID, 
		'renew_url'      => '', 
		'beta'           => false, 
	),

	// Strings
	$strings = array(
		'menu-title'                => __( 'Theme License', 'landingpress-wp' ),
		'page-title'                => __( 'Selamat Datang Di LandingPress', 'landingpress-wp' ),
		'theme-license'             => __( 'Theme License', 'landingpress-wp' ),
		'enter-key'                 => __( 'Silahkan masukkan kode lisensi Anda.', 'landingpress-wp' ),
		'enter-key-placeholder'     => __( 'masukkan kode lisensi di sini', 'landingpress-wp' ),
		'license-key'               => __( 'Kode Lisensi Anda', 'landingpress-wp' ),
		'license-action'            => __( 'License Action', 'landingpress-wp' ),
		'deactivate-license'        => __( 'Deactivate', 'landingpress-wp' ),
		'activate-license'          => __( 'Activate', 'landingpress-wp' ),
		'change-license'            => __( 'Ganti Lisensi', 'landingpress-wp' ),
		'status-unknown'            => __( 'Status lisensi tidak diketahui.', 'landingpress-wp' ),
		'renew'                     => __( 'Perpanjang Lisensi', 'landingpress-wp' ),
		'unlimited'                 => __( 'unlimited', 'landingpress-wp' ),
		'license-key-is-active'     => __( 'Kode lisensi AKTIF.', 'landingpress-wp' ),
		'expires%s'                 => __( 'Kadaluarsa %s.', 'landingpress-wp' ),
		'expires-never'             => __( 'Lisensi LIFETIME.', 'landingpress-wp' ),
		'%1$s/%2$-sites'            => __( 'Anda sudah mengaktifkan lisensi ini untuk %1$s website dari limit %2$s website yang tersedia.', 'landingpress-wp' ),
		'license-key-expired-%s'    => __( 'Kode lisensi kadaluarsa %s.', 'landingpress-wp' ),
		'license-key-expired'       => __( 'Kode lisensi telah kadaluarsa.', 'landingpress-wp' ),
		'license-keys-do-not-match' => __( 'Kode lisensi TIDAK COCOK.', 'landingpress-wp' ),
		'license-is-inactive'       => __( 'Lisensi TIDAK AKTIF.', 'landingpress-wp' ),
		'license-key-is-disabled'   => __( 'Kode lisensi telah dinonaktifkan.', 'landingpress-wp' ),
		'site-is-inactive'          => __( 'Lisensi tidak aktif di website ini.', 'landingpress-wp' ),
		'license-status-unknown'    => __( 'Status lisensi tidak diketahui.', 'landingpress-wp' ),
		'update-notice'             => __( "Dengan mengupdate LandingPress WordPress Theme ini, Anda bisa saja kehilangan modifikasi yang Ada lakukan di theme ini, khususnya jika Anda sudah melakukan modifikasi di theme ini. Klik 'Cancel' untuk batal, 'OK' untuk update.", 'landingpress-wp' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'landingpress-wp' ),
	)

);
