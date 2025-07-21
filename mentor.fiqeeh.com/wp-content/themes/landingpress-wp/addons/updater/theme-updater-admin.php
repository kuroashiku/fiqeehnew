<?php
/**
 * Theme updater admin page and functions.
 *
 * @package EDD LandingPress
 * @version 1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EDD_Theme_Updater_Admin {

	/**
	 * Variables required for the theme updater
	 *
	 * @since 1.0.0
	 * @type string
	 */
	 protected $remote_api_url = null;
	 protected $theme_slug = null;
	 protected $version = null;
	 protected $author = null;
	 protected $download_id = null;
	 protected $renew_url = null;
	 protected $strings = null;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	function __construct( $config = array(), $strings = array() ) {

		$config = wp_parse_args( $config, array(
			'remote_api_url' => LANDINGPRESS_URL,
			'theme_slug' => get_template(),
			'item_name' => '',
			'license' => '',
			'version' => '',
			'author' => '',
			'download_id' => '',
			'renew_url' => '',
			'beta' => false,
		) );

		// Set config arguments
		$this->remote_api_url = $config['remote_api_url'];
		$this->item_name = $config['item_name'];
		$this->item_id = $config['item_id'];
		$this->theme_slug = sanitize_key( $config['theme_slug'] );
		$this->version = $config['version'];
		$this->author = $config['author'];
		$this->download_id = $config['download_id'];
		$this->renew_url = $config['renew_url'];
		$this->beta = $config['beta'];

		// Populate version fallback
		if ( '' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action( 'init', array( $this, 'updater' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'license_action' ), 20 );
		add_action( 'admin_menu', array( $this, 'license_menu' ) );
		add_action( 'add_option_' . $this->theme_slug . '_license_key', array( $this, 'activate_license' ), 20, 2 );
		add_action( 'update_option_' . $this->theme_slug . '_license_key', array( $this, 'activate_license' ), 20, 2 );
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );

	}

	/**
	 * Creates the updater class.
	 *
	 * since 1.0.0
	 */
	function updater() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		/* If there is no valid license key status, don't allow updates. */
		if ( get_option( $this->theme_slug . '_license_key_status', false) != 'valid' ) {
			return;
		}

		if ( !class_exists( 'EDD_Theme_Updater' ) ) {
			// Load our custom theme updater
			include( dirname( __FILE__ ) . '/theme-updater-class.php' );
		}

		new EDD_Theme_Updater(
			array(
				'remote_api_url' 	=> $this->remote_api_url,
				'version' 			=> $this->version,
				'license' 			=> trim( get_option( $this->theme_slug . '_license_key' ) ),
				'item_name' 		=> $this->item_name,
				'author'			=> $this->author,
				'beta'              => $this->beta
			),
			$this->strings
		);
	}

	/**
	 * Adds a menu item for the theme license under the appearance menu.
	 *
	 * since 1.0.0
	 */
	function license_menu() {

		$strings = $this->strings;

		add_menu_page(
			$strings['theme-license'],
			'LandingPress',
			'manage_options',
			'landingpress',
			array( $this, 'license_page' ),
			'data:image/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAyMDAxMDkwNC8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMTBweCIgaGVpZ2h0PSIzMTBweCIgdmlld0JveD0iMCAwIDMxMDAgMzEwMCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ieE1pZFlNaWQgbWVldCI+CjxnIGlkPSJsYXllcjEwMSIgZmlsbD0iI2ZmZmZmZiIgc3Ryb2tlPSJub25lIj4KIDxwYXRoIGQ9Ik0xMTA4IDI2MzUgbDIgLTQwNSAyOTUgMCAyOTUgMCAwIDk5IDAgOTkgLTc5IDg0IGMtNDQgNDUgLTE3NCAxODMgLTI4OCAzMDUgLTExNCAxMjEgLTIxMiAyMjIgLTIxOCAyMjIgLTcgMSAtOSAtMTM4IC03IC00MDR6Ii8+CiA8cGF0aCBkPSJNNDIwIDEzODcgbDAgLTc0MiAyOTMgLTI5MyBjMTYwIC0xNjAgMjk2IC0yOTIgMzAwIC0yOTIgNCAwIDYgMzMzIDUgNzQwIGwtMyA3NDEgNDY1IC0zIGM0NTcgLTMgNDY2IC0zIDUxMyAtMjUgMTIyIC01NyAxNzggLTEzOCAxODUgLTI2OSA1IC05NiAtMTMgLTE0MSAtNzkgLTE5OCAtNjkgLTU5IC0xMzUgLTc5IC0yNzYgLTg0IGwtMTIzIC00IDAgMjUxIDAgMjUxIC0zMDAgMCAtMzAwIDAgMCAtNTQ1IDAgLTU0NSAzNzggMCBjNDAwIDAgNDkzIDYgNjM3IDQ1IDI1NiA2NyA0NTkgMjIzIDU2MCA0MjggNjEgMTI0IDc3IDE4OSA4MiAzMzcgMTggNDUyIC0yMTkgNzc2IC02NTggOTA0IC0xNDYgNDIgLTIzNSA0NiAtOTc5IDQ2IGwtNzAwIDAgMCAtNzQzeiIvPgogPC9nPgoKPC9zdmc+',
			3
		);

		add_submenu_page(
			'landingpress',
			$strings['theme-license'],
			$strings['theme-license'],
			'manage_options',
			'landingpress',
			array( $this, 'license_page' )
		);

		// add_theme_page(
		// 	$strings['theme-license'],
		// 	$strings['theme-license'],
		// 	'manage_options',
		// 	$this->theme_slug . '-license',
		// 	array( $this, 'license_page' )
		// );
	}

	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * since 1.0.0
	 */
	function license_page() {

		$strings = $this->strings;

		$license = trim( get_option( $this->theme_slug . '_license_key' ) );

		if ( ! $license ) {
			$license_error = $strings['enter-key'];
		} 
		else {
			$license_error = $this->check_license();
		}

		$status = get_option( $this->theme_slug . '_license_key_status', false );
		if ( empty( $status ) ) {
			$status = 'unknown';
		}
		$status_label = strtoupper( str_replace( '_', ' ', $status ) );

		$license_data = get_option( $this->theme_slug . '_license_data' );
		$license_error = get_option( $this->theme_slug . '_license_error' );
		if ( isset( $_GET['landingpress_license'] ) && $_GET['landingpress_license'] == 'false' && isset( $_GET['license_error'] ) && ! empty( $_GET['license_error'] ) ) {
			$license_error = urldecode( stripslashes( $_GET['license_error'] ) );
		}
		?>
		<style>
		.landingpress-license-form {
			padding: 10px 20px;
			background: #fff;
			border-left: 4px solid #00a0d2;
			margin-top: 15px;
		}
		.landingpress-license-form input {
			height: 40px;
			line-height: 40px;
			padding: 0 10px;
			vertical-align: top;
			background: #f5f5f5;
		}
		.wp-core-ui .landingpress-license-form .button, .wp-core-ui .landingpress-license-form .button-primary, .wp-core-ui .landingpress-license-form .button-secondary {
			height: 40px;
			line-height: 40px;
			padding: 0 20px;
			vertical-align: top;
		}
		.landingpress-license-form a {
			text-decoration: none;
		}
		.landingpress-license-good {
			color: #3c763d;
		}
		.landingpress-license-bad {
			color: #a94442;
		}
		.landingpress-license-grey {
			color: #999;
		}
		.landingpress-license-row {
			overflow: hidden;
			margin: 10px 0 20px;
		}
		.landingpress-license-th {
			font-weight: bold;
		}
		@media (min-width: 768px) {
			.landingpress-license-row {
				overflow: hidden;
				margin: 0;
				padding: 20px 0;
				border-bottom: 1px solid rgba(0,0,0,0.125);
			}
			.landingpress-license-row-action {
				border-bottom: none;
			}
			.landingpress-license-th {
				width: 30%;
				float: left;
			}
			.landingpress-license-td {
				width: 70%;
				float: left;
			}
		}
		</style>
		<div class="wrap">
			<h2><?php echo ( isset( $strings['page-title'] ) ? esc_html( $strings['page-title'] ) : esc_html( $strings['theme-license'] ) ) ?></h2>
			<form method="post" action="options.php" class="landingpress-license-form">

				<?php settings_fields( $this->theme_slug . '-license' ); ?>
				<?php wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ); ?>

				<?php if ( empty( $license ) || ( ! empty( $license ) && in_array( $status, array( 'item_name_mismatch', 'invalid_item_id', 'missing', 'invalid' ) ) ) ) : ?>

				<h3><?php echo $strings['license-key']; ?></h3>

				<?php if ( $license ) : ?>
					<p>
						Kode lisensi saat ini: <strong><?php echo $this->get_hidden_license( $license ); ?></strong>
					</p>
				<?php endif; ?>

				<?php if ( $license_error ) : ?>
					<p>
						<span class="landingpress-license-bad"><strong>ERROR</strong> : <?php echo esc_html( $license_error ); ?></span>
					</p>
				<?php endif; ?>

				<p>
					<?php if ( $license && in_array( $status, array( 'valid', 'site_inactive' ) ) ) : ?>
						<input id="<?php echo $this->theme_slug; ?>_license_key" name="<?php echo $this->theme_slug; ?>_license_key_hidden" type="text" class="regular-text" value="<?php echo $this->get_hidden_license( $license ); ?>" disabled />
						<?php if ( 'valid' == $status ) : ?>
							<input type="submit" class="button button-primary" name="<?php echo $this->theme_slug; ?>_license_deactivate" value="<?php echo esc_attr( $strings['deactivate-license'] ); ?>"/>
						<?php else : ?>
							<input type="submit" class="button button-primary" name="<?php echo $this->theme_slug; ?>_license_activate" value="<?php echo esc_attr( $strings['activate-license'] ); ?>"/>
						<?php endif; ?>
					<?php else : ?>
						<input id="<?php echo $this->theme_slug; ?>_license_key" name="<?php echo $this->theme_slug; ?>_license_key" type="text" class="regular-text" value="" placeholder="<?php echo $strings['enter-key-placeholder']; ?>" />
						<input type="submit" class="button button-primary" name="submit" value="<?php echo esc_attr( $strings['activate-license'] ); ?>"/>
					<?php endif; ?>
				</p>

				<p>Kode lisensi LandingPress yang aktif dibutuhkan untuk mendapatkan update otomatis, support teknis, dan akses ke LandingPress template library.</p>

				<h3>Bagaimana Cara Mendapatkan Kode Lisensi?</h3>
				<p>
					<ol>
						<li>
							<b><a href="https://member.landingpress.net" target="_blank">Login ke member area</a></b>, jika Anda SUDAH pernah membeli LandingPress.
						</li>
						<li>
							<b><a href="https://get.landingpress.net" target="_blank">Beli LandingPress</a></b>, Jika Anda BELUM pernah membeli LandingPress.
						</li>
					</ol>
				</p>

			<?php else : ?>

				<div class="landingpress-license-table">
					<?php if ( ! empty( $license_error ) ) : ?>
					<div class="landingpress-license-row">
						<div class="landingpress-license-th">
							<span class="landingpress-license-bad">ERROR</span>
						</div>
						<div class="landingpress-license-td">
							<span class="landingpress-license-bad"><?php echo esc_html( $license_error ); ?></span>
						</div>
					</div>
					<?php endif; ?>
					<div class="landingpress-license-row">
						<div class="landingpress-license-th">
							Kode Lisensi
						</div>
						<div class="landingpress-license-td">
							<span class="landingpress-license-grey"><?php echo $this->get_hidden_license( $license ); ?></span>
							<?php if ( in_array( $status, array( 'valid', 'inactive', 'site_inactive', 'expired' ) ) ) : ?>
								<br/>
								<em style="display:block;padding-top: 10px;">Kode lisensi ini bersifat RAHASIA, jangan memberikan kode lisensi ke orang lain dan jangan memberikan akses admin website Anda ke sembarang orang yang belum Anda percaya. LandingPress berhak menonaktifkan lisensi yang terindikasi disebarluaskan ke orang lain.</em>
							<?php endif; ?>
						</div>
					</div>
					<div class="landingpress-license-row">
						<div class="landingpress-license-th">
							Status Lisensi
						</div>
						<div class="landingpress-license-td">
							<?php if ( in_array( $status, array( 'valid' ) ) ) : ?>
								<span class="landingpress-license-good"><?php echo esc_html( $status_label ); ?></span>
								<br/>
								<em style="display:block;padding-top: 10px;">Terimakasih telah menggunakan versi resmi LandingPress. Semoga bisnis online dan usaha Anda bisa semakin lancar, sukses, dan berkah.</em>
							<?php else : ?>
								<span class="landingpress-license-bad"><?php echo esc_html( $status_label ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( in_array( $status, array( 'valid', 'inactive', 'site_inactive', 'expired' ) ) ) : ?>
						<?php if ( isset( $license_data->item_name ) && $license_data->item_name ) : ?>
							<div class="landingpress-license-row">
								<div class="landingpress-license-th">
									Nama Produk
								</div>
								<div class="landingpress-license-td">
									<?php echo esc_html( str_replace( '+', ' ', $license_data->item_name ) ); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( isset( $license_data->item_name ) && $license_data->item_name ) : ?>
							<div class="landingpress-license-row">
								<div class="landingpress-license-th">
									Tipe Produk
								</div>
								<div class="landingpress-license-td">
									<?php if ( isset( $license_data->price_id ) && $license_data->price_id == 1 ) : ?>
										Personal License, 50 Website, Lifetime
									<?php elseif ( isset( $license_data->price_id ) && $license_data->price_id == 2 ) : ?>
										Personal License, 50 Website, 1 Tahun
									<?php else : ?>
										Personal License
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( isset( $license_data->customer_name ) && $license_data->customer_name ) : ?>
							<div class="landingpress-license-row">
								<div class="landingpress-license-th">
									Nama Pemegang Lisensi
								</div>
								<div class="landingpress-license-td">
									<?php echo esc_html( $license_data->customer_name ); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( isset( $license_data->customer_email ) && $license_data->customer_email ) : ?>
							<div class="landingpress-license-row">
								<div class="landingpress-license-th">
									Email Pemegang Lisensi
								</div>
								<div class="landingpress-license-td">
									<?php echo esc_html( $license_data->customer_email ); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( isset( $license_data->site_count ) && $license_data->site_count && isset( $license_data->license_limit ) && $license_data->license_limit ) : ?>
							<div class="landingpress-license-row">
								<div class="landingpress-license-th">
									Status Aktivasi
								</div>
								<div class="landingpress-license-td">
									<?php echo 'ada '.esc_html( $license_data->site_count ).' website aktif dari batas limit '.esc_html( $license_data->license_limit ).' website aktif'; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( isset( $license_data->expires ) && $license_data->expires ) : ?>
							<div class="landingpress-license-row">
								<div class="landingpress-license-th">
									Tanggal Kadaluarsa
								</div>
								<div class="landingpress-license-td">
									<?php if ( $license_data->expires == 'lifetime' ) : ?>
										<?php echo esc_html( strtoupper( $license_data->expires ) ); ?>
									<?php else : ?>
										<?php echo date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ); ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<div class="landingpress-license-row landingpress-license-row-action">
						<div class="landingpress-license-th">
							&nbsp;
						</div>
						<div class="landingpress-license-td">
							<?php if ( in_array( $status, array( 'valid' ) ) ) : ?>
								<input type="submit" class="button button-primary" name="<?php echo $this->theme_slug; ?>_license_deactivate" value="<?php echo esc_attr( $strings['deactivate-license'] ); ?>"/>
								&nbsp; 
								<input type="submit" class="button button-secondary" name="<?php echo $this->theme_slug; ?>_license_change" value="<?php echo esc_attr( $strings['change-license'] ); ?>"/>
							<?php elseif ( in_array( $status, array( 'inactive', 'site_inactive', 'unknown' ) ) ) : ?>
								<input type="submit" class="button button-primary" name="<?php echo $this->theme_slug; ?>_license_activate" value="<?php echo esc_attr( $strings['activate-license'] ); ?>"/>
								&nbsp; 
								<input type="submit" class="button button-secondary" name="<?php echo $this->theme_slug; ?>_license_change" value="<?php echo esc_attr( $strings['change-license'] ); ?>"/>
							<?php elseif ( in_array( $status, array( 'expired' ) ) ) : ?>
								<a class="button button-primary" href="<?php echo $this->get_renewal_link(); ?>" target="_blank"><?php echo esc_attr( $strings['renew'] ); ?></a>
								&nbsp; 
								<input type="submit" class="button button-secondary" name="<?php echo $this->theme_slug; ?>_license_change" value="<?php echo esc_attr( $strings['change-license'] ); ?>"/>
							<?php else : ?>
								<input type="submit" class="button button-primary" name="<?php echo $this->theme_slug; ?>_license_change" value="<?php echo esc_attr( $strings['change-license'] ); ?>"/>
							<?php endif; ?>
						</div>
					</div>
				</div>

			<?php endif; ?>

			</form>
		<?php
	}

	/**
	 * Hidden License Key
	 *
	 * since 1.0.0
	 */
	function get_hidden_license( $license ) {
		if ( !$license )
			return $license;
		$start = substr( $license, 0, 5 );
		$finish = substr( $license, -5 );
		$license = $start.'xxxxxxxxxxxxxxxxxxxx'.$finish;
		return $license;
	}

	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	function register_option() {
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_license_key',
			array( $this, 'sanitize_license' )
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * since 1.0.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	function sanitize_license( $new ) {
		$old = get_option( $this->theme_slug . '_license_key' );
		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( $this->theme_slug . '_license_key_status' );
			delete_option( $this->theme_slug . '_license_data' );
			delete_option( $this->theme_slug . '_license_error' );
		}
		return $new;
	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	 function get_api_response( $api_params ) {
		$response = wp_remote_post( $this->remote_api_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		return $response;
	 }

	/**
	 * Activates the license key.
	 *
	 * @since 1.0.0
	 */
	function activate_license() {
		$license = trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			// 'item_name'  => urlencode( $this->item_name ),
			'item_id'    => $this->item_id,
			'url'        => home_url()
		);
		$response = $this->get_api_response( $api_params );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'landingpress-wp' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			// if ( false === $license_data->success ) {
			// 	switch( $license_data->error ) {
			if ( 'valid' != $license_data->license ) {
				switch( $license_data->license ) {
					case 'expired' :
						$error = sprintf(
							__( 'Kode lisensi Anda telah kadaluarsa pada %s.', 'landingpress-wp' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;
					case 'revoked' :
						$error = __( 'Kode lisensi Anda telah dinonaktifkan dan tidak dapat dipergunakan lagi.', 'landingpress-wp' );
						break;
					case 'missing' :
						$error = __( 'Lisensi tidak valid.', 'landingpress-wp' );
						break;
					case 'invalid' :
						$error = __( 'Lisensi tidak valid.', 'landingpress-wp' );
						break;
					case 'site_inactive' :
						$error = __( 'Lisensi Anda sedang tidak aktif di website ini.', 'landingpress-wp' );
						break;
					case 'item_name_mismatch' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silahkan ganti dengan kode lisensi yang benar.', 'landingpress-wp' ), $this->item_name );
						break;
					case 'invalid_item_id' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silahkan ganti dengan kode lisensi yang benar.', 'landingpress-wp' ), $this->item_name );
						break;
					case 'no_activations_left':
						$error = __( 'Kode lisensi Anda telah mencapai batas limit aktivasi lisensi.', 'landingpress-wp' );
						break;
					default :
						$error = __( 'An error occurred, please try again.', 'landingpress-wp' );
						break;
				}
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi LandingPress', 'landingpress-wp' );
			}
			update_option( $this->theme_slug . '_license_error', $error );
		}
		else {
			delete_option( $this->theme_slug . '_license_error' );
		}
		if ( isset( $license_data ) && $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			update_option( $this->theme_slug . '_license_data', $license_data );
		}
		wp_redirect( admin_url( 'admin.php?page=landingpress' ) );
		exit();
	}

	/**
	 * Deactivates the license key.
	 *
	 * @since 1.0.0
	 */
	function deactivate_license() {
		$license = trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			// 'item_name'  => urlencode( $this->item_name ),
			'item_id'    => $this->item_id,
			'url'        => home_url()
		);
		$response = $this->get_api_response( $api_params );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'landingpress-wp' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( $license_data && ( $license_data->license == 'deactivated' ) ) {
				delete_option( $this->theme_slug . '_license_key' );
				delete_option( $this->theme_slug . '_license_key_status' );
				delete_option( $this->theme_slug . '_license_data' );
				delete_option( $this->theme_slug . '_license_error' );
			}
			else {
				$error = __( 'An error occurred, please try again.', 'landingpress-wp' );
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi LandingPress', 'landingpress-wp' );
			}
			$error = __( 'License deactivation failed!', 'landingpress-wp' ).' '.$error;
			$base_url = admin_url( 'admin.php?page=landingpress' );
			$redirect = add_query_arg( array( 'landingpress_license' => 'false', 'license_error' => urlencode( $error ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}
		wp_redirect( admin_url( 'admin.php?page=landingpress' ) );
		exit();
	}

	/**
	 * Change the license key.
	 *
	 * @since 1.0.0
	 */
	function change_license() {

		delete_option( $this->theme_slug . '_license_key' );
		delete_option( $this->theme_slug . '_license_key_status' );
		delete_option( $this->theme_slug . '_license_data' );
		delete_option( $this->theme_slug . '_license_error' );

		wp_redirect( admin_url( 'admin.php?page=landingpress' ) );
		exit();

	}

	/**
	 * Constructs a renewal link
	 *
	 * @since 1.0.0
	 */
	function get_renewal_link() {

		// If a renewal link was passed in the config, use that
		if ( '' != $this->renew_url ) {
			return $this->renew_url;
		}

		// If download_id was passed in the config, a renewal link can be constructed
		$license_key = trim( get_option( $this->theme_slug . '_license_key', false ) );
		if ( '' != $this->download_id && $license_key ) {
			$url = esc_url( $this->remote_api_url );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
			return $url;
		}

		// Otherwise return the remote_api_url
		return $this->remote_api_url;

	}



	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 1.0.0
	 */
	function license_action() {

		if ( isset( $_POST[ $this->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST[$this->theme_slug . '_license_deactivate'] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}

		if ( isset( $_POST[$this->theme_slug . '_license_change'] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->change_license();
			}
		}

	}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {
		$license = trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			// 'item_name'  => urlencode( $this->item_name ),
			'item_id'    => $this->item_id,
			'url'        => home_url()
		);
		$response = $this->get_api_response( $api_params );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'landingpress-wp' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( 'valid' != $license_data->license ) {
				switch( $license_data->license ) {
					case 'expired' :
						$error = sprintf(
							__( 'Kode lisensi Anda telah kadaluarsa pada %s.', 'landingpress-wp' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;
					case 'revoked' :
						$error = __( 'Kode lisensi Anda telah dinonaktifkan dan tidak dapat dipergunakan lagi.', 'landingpress-wp' );
						break;
					case 'missing' :
						$error = __( 'Lisensi tidak valid.', 'landingpress-wp' );
						break;
					case 'invalid' :
						$error = __( 'Lisensi tidak valid.', 'landingpress-wp' );
						break;
					case 'site_inactive' :
						$error = __( 'Lisensi Anda sedang tidak aktif di website ini.', 'landingpress-wp' );
						break;
					case 'item_name_mismatch' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silahkan ganti dengan kode lisensi yang benar.', 'landingpress-wp' ), $this->item_name );
						break;
					case 'invalid_item_id' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silahkan ganti dengan kode lisensi yang benar.', 'landingpress-wp' ), $this->item_name );
						break;
					case 'no_activations_left':
						$error = __( 'Kode lisensi Anda telah mencapai batas limit aktivasi lisensi.', 'landingpress-wp' );
						break;
					default :
						$error = __( 'An error occurred, please try again.', 'landingpress-wp' );
						break;
				}
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi LandingPress', 'landingpress-wp' );
			}
			update_option( $this->theme_slug . '_license_error', $error );
		}
		else {
			delete_option( $this->theme_slug . '_license_error' );
		}
		if ( isset( $license_data ) && $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			update_option( $this->theme_slug . '_license_data', $license_data );
		}
		return $error;
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
 			return $r;
 		}

 		// Decode the JSON response
 		$themes = json_decode( $r['body']['themes'] );

 		// Remove the active parent and child themes from the check
 		$parent = get_option( 'template' );
 		$child = get_option( 'stylesheet' );
 		unset( $themes->themes->$parent );
 		unset( $themes->themes->$child );

 		// Encode the updated JSON response
 		$r['body']['themes'] = json_encode( $themes );

 		return $r;
	}

}
