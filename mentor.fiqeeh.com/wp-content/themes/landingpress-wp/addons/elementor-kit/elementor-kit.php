<?php
/**
 * Plugin Name: LandingPressKit Elementor
 * Plugin URI: https://www.landingpresskit.co/
 * Description: LandingPressKit Elementor
 * Version: 0.5.0
 * Author: LandingPressKit
 * Author URI: https://www.landingpresskit.co/
 * 
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * 
 * This plugin incorporates codes from:
 * 
 * 1) Elementor
 * Copyright Elementor
 * GPL v3 license
 * @link https://github.com/elementor/elementor
 * 
 * 2) JetThemeCore
 * Copyright Zemez
 * GPL v2 license
 * @link https://crocoblock.com/plugins/jetthemecore/
 * 
 * 3) LandingPress
 * Copyright LandingPress
 * GPL v3 license
 * @link https://www.landingpress.net
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'LandingPressKit_Elementor_Init' ) ) {

class LandingPressKit_Elementor_Init {

	public static $api_url = 'http://api3.landingpress.net/';

	private static $instance;

	public static function get_instance() {
		return null === self::$instance ? ( self::$instance = new self ) : self::$instance;
	}

	public function __construct() {
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ), 0 );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );
		add_action( 'elementor/editor/footer', array( $this, 'print_templates' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_styles' ) );
		add_action( 'wp_ajax_landingpresskit_get_templates', array( $this, 'get_templates' ) );
		add_action( 'elementor/ajax/register_actions', array( $this, 'register_ajax_actions' ), 20 );
	}

	public function editor_scripts() {

		wp_enqueue_script(
			'landingpresskit-editor',
			ADDONS_URL . 'elementor-kit/assets/js/editor.js',
			array( 'jquery', 'underscore', 'backbone-marionette' ),
			LANDINGPRESS_THEME_VERSION,
			true
		);

		wp_localize_script( 'landingpresskit-editor', 'LandingPressKitData', apply_filters(
			'landingpresskit/assets/editor/localize',
			array(
				'modalRegions'  => array(
					'modalHeader'  => '.dialog-header',
					'modalContent' => '.dialog-message',
				),
				'tabs' => $this->get_tabs(),
				'defaultTab' => 'landingpresskit_page',
			)
		) );

	}

	public function editor_styles() {

		wp_enqueue_style(
			'landingpresskit-editor',
			ADDONS_URL . 'elementor-kit/assets/css/editor.css',
			array(),
			LANDINGPRESS_THEME_VERSION
		);

	}

	public function print_templates() {

		foreach ( glob( ADDONS_PATH . 'elementor-kit/templates/*.php' ) as $file ) {
			include_once( $file );
		}

	}

	public function preview_styles() {

		wp_enqueue_style(
			'landingpresskit-preview',
			ADDONS_URL . 'elementor-kit/assets/css/preview.css',
			array(),
			LANDINGPRESS_THEME_VERSION
		);

	}

	public function get_templates() {

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error();
		}

		$tab     = $_GET['tab'];
		$tabs    = $this->get_tabs();

		$result = array(
			'templates'  => array(),
			'categories' => array(),
			'keywords'   => array(),
		);

		$library_data = $this->get_library_data();

		$templates = array();
		$categories = array();
		$keywords = array();

		if ( ! empty( $library_data['templates'] ) ) {
			foreach ( $library_data['templates'] as $template_data ) {
				$template_data['template_id'] = $template_data['id'];
				$template_data['source'] = 'landingpresskit-api';
				if ( !isset( $template_data['categories'] ) && isset( $template_data['subtype'] ) && $template_data['subtype'] ) {
					$template_data['categories'] = is_array( $template_data['subtype'] ) ? $template_data['subtype'] : array( $template_data['subtype'] );
				}
				$template_data['subtype'] = $template_data['type'];
				if ( $tab == 'landingpresskit_page' && $template_data['type'] == 'page' ) {
					$template_data['type'] = 'landingpresskit_page';
					$templates[] = $template_data;
				}
				elseif ( $tab == 'landingpresskit_block' && $template_data['type'] == 'block' ) {
					$template_data['type'] = 'landingpresskit_block';
					$templates[] = $template_data;
				}
			}
		}

		if ( $tab == 'landingpresskit_page' ) {
			if ( isset( $library_data['categories_page'] ) ) {
				$categories = $library_data['categories_page'];
			}
			if ( isset( $library_data['keywords_page'] ) ) {
				$keywords = $library_data['keywords_page'];
			}
		}
		elseif ( $tab == 'landingpresskit_block' ) {
			if ( isset( $library_data['categories_block'] ) ) {
				$categories = $library_data['categories_block'];
			}
			else {
				if ( isset( $library_data['categories'] ) ) {
					$categories = $library_data['categories'];
				}
			}
			if ( isset( $library_data['keywords_block'] ) ) {
				$keywords = $library_data['keywords_block'];
			}
		}

		if ( ! empty( $templates ) ) {
			$result['templates']  = array_merge( $result['templates'], $templates );
		}

		if ( ! empty( $categories ) ) {
			$result['categories']  = array_merge( $result['categories'], $categories );
		}

		if ( ! empty( $keywords ) ) {
			$result['keywords']  = array_merge( $result['keywords'], $keywords );
		}

		wp_send_json_success( $result );

	}

	public function register_ajax_actions( $ajax ) {

		if ( ! isset( $_POST['actions'] ) ) {
			return;
		}

		$actions     = json_decode( stripslashes( $_REQUEST['actions'] ), true );
		$data        = false;

		foreach ( $actions as $id => $action_data ) {
			if ( ! isset( $action_data['get_template_data'] ) ) {
				$data = $action_data;
			}
		}

		if ( ! $data ) {
			return;
		}

		if ( ! isset( $data['data'] ) ) {
			return;
		}

		if ( ! isset( $data['data']['source'] ) ) {
			return;
		}

		if ( $data['data']['source'] != 'landingpresskit-api' ) {
			return;
		}

		$ajax->register_ajax_action( 'get_template_data', function( $data ) {
			return $this->get_template_data_array( $data );
		} );

	}

	private function get_tabs() {
		$tabs = array (
			'landingpresskit_page' => array (
				'title' => 'Pages',
				'data' => array (),
				'sources'  => array( 'landingpresskit-api' ),
				'settings' => array (
					'show_title' => true,
					'show_keywords' => true,
				),
			),
			'landingpresskit_block' => array (
				'title' => 'Blocks',
				'data' => array (),
				'sources'  => array( 'landingpresskit-api' ),
				'settings' => array (
					'show_title' => true,
					'show_keywords' => true,
				),
			),
		);
		return $tabs;
	}

	public static function get_info_data( $force_update = false ) {
		$cache_key = 'elementor_landingpress_info_api_data_' . ELEMENTOR_VERSION;

		$info_data = get_transient( $cache_key );

		if ( $force_update || false === $info_data ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_get( self::$api_url.'elementor/info/', [
				'timeout' => $timeout,
				'body' => [
					// Which API version is used.
					'api_version' => ELEMENTOR_VERSION,
					// Which language to return.
					'site_lang' => get_bloginfo( 'language' ),
				],
			] );

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

				return false;
			}

			$info_data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $info_data ) || ! is_array( $info_data ) ) {
				set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

				return false;
			}

			if ( isset( $info_data['library'] ) ) {
				update_option( 'elementor_landingpress_info_library', $info_data['library'], 'no' );

				unset( $info_data['library'] );
			}

			set_transient( $cache_key, $info_data, 12 * HOUR_IN_SECONDS );
		}

		return $info_data;
	}

	public static function get_library_data( $force_update = false ) {
		self::get_info_data( $force_update );

		$library_data = get_option( 'elementor_landingpress_info_library' );

		if ( empty( $library_data ) ) {
			return [];
		}

		$library_data = apply_filters( 'landingpress_elementor_library_data', $library_data );

		return $library_data;
	}

	private function get_template_data_array( $data ) {

		if ( ! current_user_can( 'edit_posts' ) ) {
			return false;
		}

		if ( empty( $data['template_id'] ) ) {
			return false;
		}

		$source_name = isset( $data['source'] ) ? esc_attr( $data['source'] ) : '';

		if ( ! $source_name ) {
			return false;
		}

		if ( $source_name != 'landingpresskit-api' ) {
			return false;
		}

		if ( empty( $data['tab'] ) ) {
			return false;
		}

		$template = $this->get_item( $data['template_id'] );

		return $template;
	}

	private function get_item( $template_id ) {
		$template_content = apply_filters( 'landingpress_elementor_library_content', null, $template_id );

		if ( $template_content === null ) {

			$license = trim( get_option( LANDINGPRESS_THEME_SLUG . '_license_key' ) );
			if ( !$license ) {
				return new \WP_Error( 'license_error', 'Your license is missing' );
			}

			$license_status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
			if ( $license_status != 'valid' ) {
				return new \WP_Error( 'license_status_error', 'Your license status is not valid' );
			}

			$response = wp_remote_get( self::$api_url . 'elementor/content/', [
				'timeout' => 40,
					'body' => array(
					// Which API version is used.
					'api_version' => ELEMENTOR_VERSION,
					// Which language to return.
					'site_lang' => get_bloginfo( 'language' ),
					'template_id'	=> $template_id,
					'url'			=> home_url('/'),
					'license'		=> $license,
					'item_name'		=> urlencode( LANDINGPRESS_THEME_NAME ),
				),
			] );

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			$response_code = (int) wp_remote_retrieve_response_code( $response );

			if ( 200 !== $response_code ) {
				return new \WP_Error( 'response_code_error', sprintf( 'The request returned with a status code of %s.', $response_code ) );
			}

			$template_content = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( isset( $template_content['error'] ) ) {
				return new \WP_Error( 'response_error', $template_content['error'] );
			}

			if ( empty( $template_content['data'] ) && empty( $template_content['content'] ) ) {
				return new \WP_Error( 'template_data_error', 'An invalid data was returned.' );
			}

			if ( ! empty( $template_content['data'] ) ) {
				$template_content['content'] = $template_content['data'];
				unset( $template_content['data'] );
			}

		}

		$content       = isset( $template_content['content'] ) ? $template_content['content'] : '';
		$type          = isset( $template_content['type'] ) ? $template_content['type'] : '';
		$page_settings = isset( $template_content['page_settings'] ) ? $template_content['page_settings'] : array();

		if ( ! empty( $content ) ) {
			$content = $this->replace_elements_ids( $content );
			$content = $this->process_export_import_content( $content, 'on_import' );
		}

		return array(
			'page_settings' => $page_settings,
			'type'          => $type,
			'content'       => $content,
		);

	}

	private function replace_elements_ids( $content ) {
		return \Elementor\Plugin::$instance->db->iterate_data( $content, function( $element ) {
			$element['id'] = dechex( rand() );
			return $element;
		} );
	}

	private function process_export_import_content( $content, $method ) {
		return \Elementor\Plugin::$instance->db->iterate_data(
			$content, function( $element_data ) use ( $method ) {
				$element = \Elementor\Plugin::$instance->elements_manager->create_element_instance( $element_data );

				// If the widget/element isn't exist, like a plugin that creates a widget but deactivated
				if ( ! $element ) {
					return null;
				}

				return $this->process_element_export_import_content( $element, $method );
			}
		);
	}

	private function process_element_export_import_content( $element, $method ) {

		$element_data = $element->get_data();

		if ( method_exists( $element, $method ) ) {
			// TODO: Use the internal element data without parameters.
			$element_data = $element->{$method}( $element_data );
		}

		foreach ( $element->get_controls() as $control ) {
			$control_class = \Elementor\Plugin::$instance->controls_manager->get_control( $control['type'] );

			// If the control isn't exist, like a plugin that creates the control but deactivated.
			if ( ! $control_class ) {
				return $element_data;
			}

			if ( method_exists( $control_class, $method ) ) {
				$element_data['settings'][ $control['name'] ] = $control_class->{$method}( $element->get_settings( $control['name'] ), $control );
			}
		}

		return $element_data;
	}

}

}

LandingPressKit_Elementor_Init::get_instance();
