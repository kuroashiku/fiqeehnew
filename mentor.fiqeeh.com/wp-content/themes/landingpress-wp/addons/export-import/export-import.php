<?php
/**
 * This function incorporates code from the Customizer Export/Import plugin.
 * 
 * The Customizer Export/Import, Copyright The Beaver Builder Team,
 * is licensed under the terms of the GNU GPL, Version 2 (or later).
 * 
 * @link https://wordpress.org/plugins/customizer-export-import/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'customize_register', 'landingpress_exportimport_register' );
function landingpress_exportimport_register( $wp_customize ) {

	class LandingPress_Customize_Export_Import_Control extends WP_Customize_Control {
		public function render_content() {
			?>
			<style>
			.wpbei-form { position: absolute; left: -99999px; }
			.wpbei-hr { margin: 20px 0px 10px; }
			.wpbei-import-file { width: 100%; margin: 10px 0 20px; padding: 0; font-size: 12px; }
			.wpbei-uploading { display: none; margin: 10px 0 20px; padding: 0; font-size: 12px; }
			</style>
			<span class="customize-control-title">
				<?php esc_html_e( 'Export Theme Settings', 'landingpress-wp' ); ?>
			</span>
			<input type="button" class="button" name="wpbei-export-button" value="<?php esc_attr_e( 'Export', 'landingpress-wp' ); ?>" />

			<hr class="wpbei-hr" />

			<span class="customize-control-title">
				<?php esc_html_e( 'Import Theme Settings', 'landingpress-wp' ); ?>
			</span>
			<div class="wpbei-import-controls">
				<input type="file" name="wpbei-import-file" class="wpbei-import-file" />
				<?php wp_nonce_field( 'wpbei-importing', 'wpbei-import' ); ?>
			</div>
			<div class="wpbei-uploading"><?php esc_html_e( 'Uploading...', 'landingpress-wp' ); ?></div>
			<input type="button" class="button" name="wpbei-import-button" value="<?php esc_attr_e( 'Import', 'landingpress-wp' ); ?>" />
			<script type="text/javascript">
			( function( $ ) {
				var LandingPress_Export_Import = {
					init: function() {
						$( 'input[name=wpbei-export-button]' ).on( 'click', LandingPress_Export_Import._export );
						$( 'input[name=wpbei-import-button]' ).on( 'click', LandingPress_Export_Import._import );
					},
					_export: function() {
						window.location.href = '<?php echo admin_url( 'customize.php' ); ?>?wpbei-export=<?php echo wp_create_nonce('wpbei-exporting'); ?>';
					},
					_import: function() {
						var win			= $( window ),
							body		= $( 'body' ),
							form		= $( '<form class="wpbei-form" method="POST" enctype="multipart/form-data"></form>' ),
							controls	= $( '.wpbei-import-controls' ),
							file		= $( 'input[name=wpbei-import-file]' ),
							message		= $( '.wpbei-uploading' );
						
						if ( '' == file.val() ) {
							alert( '<?php esc_attr_e( 'Please choose a file to import.', 'landingpress-wp' ); ?>' );
						}
						else {
							win.off( 'beforeunload' );
							body.append( form );
							form.append( controls );
							message.show();
							form.submit();
						}
					}
				};
				$( LandingPress_Export_Import.init );
			})( jQuery );
			</script>
			<?php 
		}
	}

	$wp_customize->add_section( 'landingpress_exportimport_section', array(
		'title'	   => esc_html__( 'Export / Import Settings', 'landingpress-wp' ),
		'priority' => 10000000
	));
	$wp_customize->add_setting( 'landingpress_exportimport_setting', array(
		'default' => '',
		'type'	  => 'none',
		'sanitize_callback' => 'landingpress_sanitize_checkbox',
	));
	$wp_customize->add_control( new LandingPress_Customize_Export_Import_Control( 
		$wp_customize, 
		'landingpress_exportimport_setting', 
		array(
			'section'	=> 'landingpress_exportimport_section',
			'priority'	=> 1
		)
	));
}

add_action( 'customize_register', 'landingpress_exportimport_init', 999999 );
function landingpress_exportimport_init( $wp_customize ) {
	if ( current_user_can( 'edit_theme_options' ) ) {
		if ( isset( $_REQUEST['wpbei-export'] ) ) {
			landingpress_exportimport_export( $wp_customize );
		}
		if ( isset( $_REQUEST['wpbei-import'] ) && isset( $_FILES['wpbei-import-file'] ) ) {
			landingpress_exportimport_import( $wp_customize );
		}
	}
}

function landingpress_exportimport_export( $wp_customize ) {
	if ( ! wp_verify_nonce( $_REQUEST['wpbei-export'], 'wpbei-exporting' ) ) {
		return;
	}
	
	$theme		= get_stylesheet();
	// $template	= get_template();
	$template	= 'landingpress-themes';
	$charset	= get_option( 'blog_charset' );
	$mods		= get_theme_mods();
	$data		= array(
					  'template'  => $template,
					  'mods'	  => $mods ? $mods : array(),
					  'options'	  => array()
				  );
	$core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);
	
	// Get options from the Customizer API.
	$settings = $wp_customize->settings();

	foreach ( $settings as $key => $setting ) {
		
		if ( 'option' == $setting->type ) {
			
			// Don't save widget data.
			if ( stristr( $key, 'widget_' ) ) {
				continue;
			}
			
			// Don't save sidebar data.
			if ( stristr( $key, 'sidebars_' ) ) {
				continue;
			}
			
			// Don't save core options.
			if ( in_array( $key, $core_options ) ) {
				continue;
			}
			
			$data['options'][ $key ] = $setting->value();
		}
	}
				  
	// Plugin developers can specify additional option keys to export.
	$option_keys = apply_filters( 'wpbei_export_option_keys', array() );
	
	foreach ( $option_keys as $option_key ) {
		
		$option_value = get_option( $option_key );
		
		if ( $option_value ) {
			$data['options'][ $option_key ] = $option_value;
		}
	}
	
	// Set the download headers.
	header( 'Content-disposition: attachment; filename=landingpress-' . $theme . '-'.date("Ymd-His").'.txt' );
	header( 'Content-Type: application/octet-stream; charset=' . $charset );
	
	// Json encode the export data.
	echo json_encode( $data );
	
	// Start the download.
	die();
}

function landingpress_exportimport_import( $wp_customize ) {
	// Make sure we have a valid nonce.
	if ( ! wp_verify_nonce( $_REQUEST['wpbei-import'], 'wpbei-importing' ) ) {
		return;
	}
	
	// Make sure WordPress upload support is loaded.
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	
	// Load the export/import option class.
	class LandingPress_Export_Import_Option extends WP_Customize_Setting {
		public function import( $value ) {
			$this->update( $value );	
		}
	}

	// Setup global vars.
	global $wp_customize;
	global $wpbei_error;
	
	// Setup internal vars.
	$wpbei_error	 = false;
	// $template	 = get_template();
	$template	 = 'landingpress-themes';
	$overrides   = array( 'test_form' => FALSE );
	$file        = wp_handle_upload( $_FILES['wpbei-import-file'], $overrides );

	// Make sure we have an uploaded file.
	if ( isset( $file['error'] ) ) {
		$wpbei_error = $file['error'];
		return;
	}
	if ( ! file_exists( $file['file'] ) ) {
		$wpbei_error = esc_html__( 'Error importing settings! Please try again.', 'landingpress-wp' );
		return;
	}
	
	// Get the upload data.
	$raw  = file_get_contents( $file['file'] );
	$data = json_decode( $raw, true );
	
	// Remove the uploaded file.
	unlink( $file['file'] );
	
	// Data checks.
	if ( 'array' != gettype( $data ) ) {
		$wpbei_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'landingpress-wp' );
		return;
	}
	if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
		$wpbei_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'landingpress-wp' );
		return;
	}
	if ( $data['template'] != $template ) {
		$wpbei_error = esc_html__( 'Error importing settings! The settings you uploaded are not for the current theme.', 'landingpress-wp' );
		return;
	}
	
	// Import custom options.
	if ( isset( $data['options'] ) ) {
		
		foreach ( $data['options'] as $option_key => $option_value ) {
			
			$option = new LandingPress_Export_Import_Option( $wp_customize, $option_key, array(
				'default'		=> '',
				'type'			=> 'option',
				'capability'	=> 'edit_theme_options'
			) );
			
			$option->import( $option_value );
		}
	}
	
	// Call the customize_save action.
	do_action( 'customize_save', $wp_customize );
	
	// Loop through the mods.
	foreach ( $data['mods'] as $key => $val ) {
		
		// Call the customize_save_ dynamic action.
		do_action( 'customize_save_' . $key, $wp_customize );
		
		// Save the mod.
		set_theme_mod( $key, $val );
	}
	
	// Call the customize_save_after action.
	do_action( 'customize_save_after', $wp_customize );
}

add_action( 'customize_controls_print_scripts', 'landingpress_exportimport_controls_print_scripts' );
function landingpress_exportimport_controls_print_scripts() {
	global $wpbei_error;
	if ( $wpbei_error ) {
		echo '<script> alert("' . $wpbei_error . '"); </script>';
	}
}
