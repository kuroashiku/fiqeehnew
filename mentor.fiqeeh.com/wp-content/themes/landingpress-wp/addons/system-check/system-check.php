<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !function_exists('landingpress_system_check_params') ) {

	add_action( 'admin_menu', 'landingpress_system_check_admin_menu', 25 );
	function landingpress_system_check_admin_menu() {
		if ( class_exists('EDD_Theme_Updater_Admin') ) {
			add_submenu_page( 'landingpress', esc_html__( 'System Check', 'landingpress-wp' ), esc_html__( 'System Check', 'landingpress-wp' ), 'edit_theme_options', 'landingpress-system-check', 'landingpress_system_check_theme_page');
		}
		else {
			add_theme_page( esc_html__( 'System Check', 'landingpress-wp' ), esc_html__( 'System Check', 'landingpress-wp' ), 'edit_theme_options', 'landingpress-system-check', 'landingpress_system_check_theme_page');
		}
	}

	function landingpress_system_check_params() {
		global $wpdb, $wp_rewrite;

		$systemchecks = array();

		$check = array( 'title' => esc_html__( 'Theme License', 'landingpress-wp' ) );

		$license_key = trim( get_option( LANDINGPRESS_THEME_SLUG . '_license_key' ) );
		global $landingpress_updater;
		if ( $license_key ) {
			$message = $landingpress_updater->check_license();
		}
		$license_status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );

		if ( $license_status == 'valid' ) {
			$check['data'] = strtoupper( $license_status );
			$check['alert'] = 'success';
			$check['description'] = '<a href="'.admin_url('admin.php?page=landingpress').'">'.esc_html__( 'Klik di sini untuk cek lisensi Anda.', 'landingpress-wp' ).'</a>';
		}
		else {
			$check['data'] = strtoupper( $license_status );
			$check['alert'] = 'danger';
			$check['description'] = '<a href="'.admin_url('admin.php?page=landingpress').'">'.esc_html__( 'Klik di sini untuk cek lisensi Anda.', 'landingpress-wp' ).'</a>';
		}
		$systemchecks['license'] = $check;

		if ( class_exists('LandingPressKit_Elementor_Init') ) {
			LandingPressKit_Elementor_Init::get_info_data(true);
			$check = array( 'title' => esc_html__( 'Template Library', 'landingpress-wp' ) );
			$library_data = get_option( 'elementor_landingpress_info_library' );
			$library_template = 0;
			$library_block = 0;
			if ( isset( $library_data['templates'] ) && !empty($library_data['templates']) ) {
				foreach ( $library_data['templates'] as $template ) {
					if ( $template['type'] == 'page' ) {
						$library_template++;
					}
					elseif ( $template['type'] == 'block' ) {
						$library_block++;
					}
				}
			}
			if ( $library_template || $library_block ) {
				$check['data'] = ( $library_template ? $library_template.' templates' : '' ).( $library_template && $library_block ? ', ' : '' ).( $library_block ? $library_block.' blocks/sections' : '' );
				$check['alert'] = 'success';
				$check['description'] = '';
			}
			else {
				$check['data'] = 'tidak ada template yang tersedia, silahkan hubungi support!';
				$check['alert'] = 'danger';
				$check['description'] = '';
			}
			$systemchecks['library'] = $check;
		}

		$check = array( 'title' => esc_html__( 'PHP Memory Limit', 'landingpress-wp' ) );
		$phpmemory = @ini_get( 'memory_limit' );
		$phpmemory_num = str_replace( 'M', '', $phpmemory );
		$check['data'] = $phpmemory;
		if ( $phpmemory_num > 0 && $phpmemory_num >= 64 ) {
			$check['alert'] = 'success';
			$check['description'] = esc_html__( 'Keren! PHP Memory Limit (dari sisi hosting/server) di website Anda melebihi limit minumum 64M yang dianjurkan supaya semua fitur berjalan dengan baik.', 'landingpress-wp' );
		}
		else {
			$check['alert'] = 'warning';
			$check['description'] = esc_html__( 'Kami sangat merekomendasikan Anda untuk menaikkan PHP Memory Limit (dari sisi hosting/server) menjadi minimum 64M ke atas, direkomendasikan 256M, supaya semua fitur berjalan dengan baik.', 'landingpress-wp' );
		}
		$systemchecks['phpmemory'] = $check;

		$check = array( 'title' => esc_html__( 'WordPress Memory Limit', 'landingpress-wp' ) );
		$wpmemory = WP_MEMORY_LIMIT;
		$wpmemory_num = str_replace( 'M', '', $wpmemory );
		$check['data'] = $wpmemory;
		if ( $wpmemory_num > 0 && $wpmemory_num >= 64 ) {
			$check['alert'] = 'success';
			$check['description'] = esc_html__( 'Keren! WordPress Memory Limit (dari sisi WordPress) di website Anda melebihi limit minumum 64M yang dianjurkan supaya semua fitur berjalan dengan baik.', 'landingpress-wp' );
		}
		else {
			$check['alert'] = 'warning';
			$check['description'] = esc_html__( 'Kami sangat merekomendasikan Anda untuk menaikkan WordPress Memory Limit (melalui parameter WP_MEMORY_LIMIT di wp-config.php file) menjadi minimum 64M ke atas, direkomendasikan 256M, supaya semua fitur berjalan dengan baik.', 'landingpress-wp' ).'<br/><a target="_blank" href="https://member.landingpress.net/06-tipstrick-03-wp-memory-limit/?utm_source=lp-system-chec&utm_campaign=landingpress-tutorial&utm_medium=wp-dash">'.esc_html__( 'Lihat Video Tutorial Menaikkan WordPress Memory Limit di Member Area', 'landingpress-wp' ).'</a>';
		}
		$systemchecks['wpmemory'] = $check;

		$check = array( 'title' => esc_html__( 'PHP Version', 'landingpress-wp' ) );
		if ( function_exists( 'phpversion' ) ) {
			$phpversion = phpversion();
			$check['data'] = $phpversion;
			if ( version_compare( $phpversion, '5.6', '>=' ) ) {
				$check['alert'] = 'success';
				$check['description'] = esc_html__( 'Keren! Server Anda telah menggunakan PHP dengan versi yang kami rekomendasikan', 'landingpress-wp' );
			}
			elseif ( version_compare( $phpversion, '5.4', '<' ) ) {
				$check['alert'] = 'danger';
				$check['description'] = esc_html__( 'Maaf, server Anda masih menggunakan PHP dengan versi di bawah 5.4. Beberapa fitur, termasuk Page Builder tidak bisa diaktifkan. Kami mewajibkan Anda untuk menggunakan PHP dengan versi 5.4 ke atas, sangat direkomendasikan menggunakan versi 5.6 ke atas.', 'landingpress-wp' );
			}
			else {
				$check['alert'] = 'warning';
				$check['description'] = esc_html__( 'Kami sangat merekomendasikan Anda untuk menggunakan PHP dengan versi 5.6 ke atas untuk hasil terbaik.', 'landingpress-wp' );
			}
		}
		else {
			$check['alert'] = 'warning';
			$check['description'] = esc_html__( 'Maaf, kami tidak bisa cek versi PHP yang digunakan.', 'landingpress-wp' );
		}
		$systemchecks['phpversion'] = $check;

		$check = array( 'title' => esc_html__( 'WordPress Version', 'landingpress-wp' ) );
		$wpversion = get_bloginfo('version');
		$check['data'] = $wpversion;
		if ( version_compare( $wpversion, '4.6', '>=' ) ) {
			$check['alert'] = 'success';
			$check['description'] = esc_html__( 'Pastikan Anda selalu menggunakan WordPress versi terbaru.', 'landingpress-wp' );
		}
		else {
			$check['alert'] = 'warning';
			$check['description'] = esc_html__( 'Kami sangat merekomendasikan Anda untuk segera update WordPress Anda dengan versi terbaru.', 'landingpress-wp' );
		}
		$systemchecks['wpversion'] = $check;

		$check = array( 'title' => esc_html__( 'Web Server', 'landingpress-wp' ), 'description' => '' );
		$webserver = esc_html( $_SERVER['SERVER_SOFTWARE'] );
		$check['data'] = $webserver;
		if ( strpos(strtolower($webserver), 'nginx') === false ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
			$check['description'] = esc_html__( 'Anda menggunakan NGINX web server. Secara teknis, NGINX lebih cepat dibanding web server lainnya. Akan tetapi perlu diperhatikan bahwa NGINX tidak support mod_rewrite untuk permalink via .htaccess, sehingga Anda harus memastikan NGINX configuration sudah tepat.', 'landingpress-wp' );
		}
		$systemchecks['webserver'] = $check;

		if ( strpos(strtolower($webserver), 'nginx') === false ) {
			$check = array( 'title' => esc_html__( 'Mod Rewrite', 'landingpress-wp' ), 'description' => '' );
			if ( function_exists( 'apache_get_modules' ) ) {
				$modrewrite = in_array( 'mod_rewrite', apache_get_modules() );
			}
			else {
				$modrewrite = false;
			}
			if ( $modrewrite ) {
				$check['data'] = esc_html__( 'detected', 'landingpress-wp' );
				$check['alert'] = 'success';
			}
			else {
				$check['data'] = esc_html__( 'not detected', 'landingpress-wp' );
				$check['alert'] = 'warning';
				$check['description'] = esc_html__( 'Mohon abaikan pesan ini jika website WordPress Anda tetap berfungsi dengan baik.', 'landingpress-wp' );
			}
			$systemchecks['modrewrite'] = $check;
		}

		$check = array( 'title' => esc_html__( 'Permalink Structure', 'landingpress-wp' ), 'description' => '' );
		$permalink = $wp_rewrite->permalink_structure;
		$check['data'] = $permalink;
		if ( $permalink ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['permalink'] = $check;

		$check = array( 'title' => esc_html__( 'MySQL Version', 'landingpress-wp' ), 'description' => '' );
		if ( $wpdb->use_mysqli ) {
			$ver = mysqli_get_server_info( $wpdb->dbh );
		} 
		else {
			$ver = mysql_get_server_info();
		}
		if ( ! empty( $wpdb->is_mysql ) && ! stristr( $ver, 'MariaDB' ) ) {
			$mysqlversion = $wpdb->db_version();
			$check['data'] = $mysqlversion;
			if ( version_compare( $mysqlversion, '5.5', '>=' ) ) {
				$check['alert'] = 'success';
				$check['description'] = esc_html__( 'Keren! Server Anda sudah menggunakan database MySQL dengan versi di atas 5.5.', 'landingpress-wp' );
			}
			else {
				$check['alert'] = 'danger';
				$check['description'] = esc_html__( 'Kami sangat merekomendasikan Anda untuk menggunakan database MySQL dengan versi 5.5 ke atas untuk hasil terbaik.', 'landingpress-wp' );
			}
		}
		else {
			$check['data'] = esc_html__( 'not detected', 'landingpress-wp' );
			$check['alert'] = 'warning';
			$check['description'] = esc_html__( 'Mohon maaf, kami tidak bisa mendeteksi versi MySQL di server Anda. Mohon abaikan pesan ini jika website WordPress Anda tetap berfungsi dengan baik.', 'landingpress-wp' );

		}
		$systemchecks['mysqlversion'] = $check;

		$check = array( 'title' => esc_html__( 'GD Library', 'landingpress-wp' ), 'description' => '' );
		$gdlibrary = extension_loaded( 'gd' ) ? esc_html__( 'detected', 'landingpress-wp' ) : esc_html__( 'not detected', 'landingpress-wp' );
		$check['data'] = $gdlibrary;
		if ( $gdlibrary == esc_html__( 'detected', 'landingpress-wp' ) ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'danger';
		}
		$check['description'] = esc_html__( 'GD Library diperlukan supaya WordPress bisa resize gambar yang di-upload ke website.', 'landingpress-wp' );
		$systemchecks['gdlibrary'] = $check;

		$check = array( 'title' => esc_html__( 'Max Upload Size', 'landingpress-wp' ), 'description' => '' );
		$maxuploadsize = wp_max_upload_size();
		$check['data'] = size_format( $maxuploadsize );
		if ( $maxuploadsize > 10000000 ) {
			$check['alert'] = 'success';
		}
		elseif ( $maxuploadsize > 2500000 ) {
			$check['alert'] = 'danger';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['maxuploadsize'] = $check;

		$check = array( 'title' => esc_html__( 'PHP Post Max Size', 'landingpress-wp' ), 'description' => '' );
		$postmaxsize = ini_get( 'post_max_size' );
		$check['data'] = $postmaxsize;
		if ( $postmaxsize ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['postmaxsize'] = $check;

		$check = array( 'title' => esc_html__( 'PHP Max Input Vars', 'landingpress-wp' ), 'description' => '' );
		$maxinputvars = ini_get( 'max_input_vars' );
		$check['data'] = $maxinputvars;
		if ( $maxinputvars ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['maxinputvars'] = $check;

		$check = array( 'title' => esc_html__( 'PHP Max Execution Time', 'landingpress-wp' ), 'description' => '' );
		$maxexectime = ini_get( 'max_execution_time' );
		$check['data'] = $maxexectime;
		if ( $maxexectime > 15 ) {
			$check['alert'] = 'success';
		}
		elseif ( $maxexectime < 5 ) {
			$check['alert'] = 'danger';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['maxexectime'] = $check;

		$check = array( 'title' => esc_html__( 'cURL Version', 'landingpress-wp' ), 'description' => '' );
		if ( function_exists( 'curl_version' ) ) {
			$curlversion = curl_version();
			$check['data'] = $curlversion['version'].', '.$curlversion['ssl_version'];
			$check['alert'] = 'success';
		} 
		else {
			$check['data'] = esc_html__( 'not available', 'landingpress-wp' );
			$check['alert'] = 'warning';
		}
		$systemchecks['curlversion'] = $check;

		$check = array( 'title' => esc_html__( 'WP Remote Get', 'landingpress-wp' ), 'description' => '' );
		$response = wp_safe_remote_get( 'https://woocommerce.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );
		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
			$check['data'] = esc_html__( 'Yes', 'landingpress-wp' );
			$check['alert'] = 'success';
		} 
		else {
			if ( is_wp_error( $response ) ) {
				$check['data'] = sprintf( esc_html__( 'Error: %s', 'landingpress-wp' ), $response->get_error_message() );
			} 
			else {
				$check['data'] = sprintf( esc_html__( 'Status code: %s', 'landingpress-wp' ), $response['response']['code'] );
			}
			$check['alert'] = 'danger';
			$check['description'] = esc_html__( 'wp_remote_get() gagal. Beberapa fitur mungkin tidak bekerja dengan baik, seperti Youtube oEmbed ataupun fitur yang membutuhkan koneksi API pihak ketiga. Hubungi support hosting Anda.', 'landingpress-wp' );
		}
		$systemchecks['remoteget'] = $check;

		$check = array( 'title' => esc_html__( 'Home URL', 'landingpress-wp' ), 'description' => '' );
		$homeurl = get_home_url();
		$check['data'] = $homeurl;
		$check['alert'] = 'success';
		$systemchecks['wordpressurl'] = $check;

		$check = array( 'title' => esc_html__( 'Site URL', 'landingpress-wp' ), 'description' => '' );
		$siteurl = get_site_url();
		$check['data'] = $siteurl;
		if ( $siteurl == $homeurl ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['siteurl'] = $check;

		$check = array( 'title' => esc_html__( 'WordPress Multisite', 'landingpress-wp' ), 'description' => '' );
		$multisite = is_multisite() ? esc_html__( 'Yes', 'landingpress-wp' ) : esc_html__( 'No', 'landingpress-wp' );
		$check['data'] = $multisite;
		if ( $multisite == esc_html__( 'No', 'landingpress-wp' ) ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['multisite'] = $check;

		$check = array( 'title' => esc_html__( 'WordPress Debug Mode', 'landingpress-wp' ), 'description' => '' );
		$wpdebug = WP_DEBUG ? esc_html__( 'Active', 'landingpress-wp' ) : esc_html__( 'Inactive', 'landingpress-wp' );
		$check['data'] = $wpdebug;
		if ( $wpdebug == esc_html__( 'Inactive', 'landingpress-wp' ) ) {
			$check['alert'] = 'success';
		}
		else {
			$check['alert'] = 'warning';
		}
		$systemchecks['wpdebug'] = $check;

		$check = array( 'title' => esc_html__( 'Timezone', 'landingpress-wp' ), 'description' => '' );
		$timezone = get_option( 'timezone_string' );
		if ( ! $timezone ) {
			$timezone = get_option( 'gmt_offset' );
		}
		$check['data'] = $timezone;
		$check['alert'] = 'success';
		$systemchecks['timezone'] = $check;

		$check = array( 'title' => esc_html__( 'Language', 'landingpress-wp' ), 'description' => '' );
		$language = get_bloginfo( 'language' );
		$check['data'] = $language;
		$check['alert'] = 'success';
		$systemchecks['language'] = $check;

		return $systemchecks;
	}

	function landingpress_system_check_icon( $alert ) {
		if ( $alert == 'success' ) {
			$icon = 'dashicons dashicons-thumbs-up';
		}
		elseif ( $alert == 'warning' ) {
			$icon = 'dashicons dashicons-warning';
		}
		elseif ( $alert == 'danger' ) {
			$icon = 'dashicons dashicons-dismiss';
		}
		else {
			$icon = 'dashicons dashicons-yes';
		}
		return $icon;
	}

	function landingpress_system_check_theme_page() {
		$systemchecks = landingpress_system_check_params();
		?>
		<style type="text/css">
			.system-alert-success {
				color: #3c763d;
			}
			.system-alert-info {
				color: #31708f;
			}
			.system-alert-warning {
				color: #8a6d3b;
			}
			.system-alert-danger {
				color: #a94442;
			}
		</style>
		<div class="wrap">
			<h2>System Check</h2>
			<table class="form-table">
				<tbody>
					<?php if ( !empty( $systemchecks ) ) : ?>
						<?php foreach ( $systemchecks as $systemcheck ) : ?>
							<?php printf( '<tr><th scope="row"><label>%1$s</label></th><td><p class="system-alert-%2$s"><i class="%3$s"></i> <strong>%4$s</strong></p><p class="description">%5$s</p></td></tr>', $systemcheck['title'], $systemcheck['alert'], landingpress_system_check_icon($systemcheck['alert']), $systemcheck['data'], $systemcheck['description'] ); ?> 
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

}
