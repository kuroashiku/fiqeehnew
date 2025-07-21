<?php 

use Elementor\Plugin;
use Elementor\DB;
use Elementor\Utils;
use Elementor\Controls_Stack;
use Elementor\Core\Settings\Manager as SettingsManager;
use Elementor\Core\Settings\Page\Model;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CustomElementorExportImport {

	public function __construct() {
		if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) && strpos( ELEMENTOR_VERSION, 'LP' ) === false ) {
			add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );
			add_filter( 'page_row_actions', array( $this, 'post_row_actions' ), 10, 2 );
			add_action( 'admin_footer', array( $this, 'admin_import_template_form' ), 9999 );
			add_action( 'wp_ajax_custom_elementor_export_template', array( $this, 'handle_export_template' ) );
			add_action( 'wp_ajax_custom_elementor_import_template', array( $this, 'handle_import_template' ) );
		}
	}

	public function post_row_actions( $actions, \WP_Post $post ) {
		if ( self::is_base_templates_screen() ) {
			if ( Plugin::$instance->documents->get( $post->ID )->is_built_with_elementor() ) {
				$actions['custom-export-template'] = sprintf( '<a href="%1$s">%2$s</a>', $this->get_export_link( $post->ID ), __( 'Export Template', 'landingpress-wp' ) );
			}
		}

		return $actions;
	}

	public function admin_import_template_form() {
		if ( ! self::is_base_templates_screen() ) {
			return;
		}

		global $current_screen;
		$post_type = isset( $current_screen->post_type ) ? $current_screen->post_type : '';
		if ( empty( $post_type ) ) {
			return;
		}
		?>
		<div id="elementor-hidden-area">
			<a id="elementor-import-template-trigger" class="page-title-action"><?php echo __( 'Import Templates', 'landingpress-wp' ); ?></a>
			<div id="elementor-import-template-area" style="display: none; margin: 50px 0 30px; text-align: center;">
				<?php if ( class_exists( '\ZipArchive' ) ) : ?>
					<div id="elementor-import-template-title" style="font-size: 18px; color: #555d66;"><?php esc_attr_e( 'Choose an Elementor template JSON file or a .zip archive of Elementor templates.', 'landingpress-wp' ); ?></div>
				<?php else : ?>
					<div id="elementor-import-template-title" style="font-size: 18px; color: #555d66;"><?php esc_attr_e( 'Choose an Elementor template JSON file of Elementor template.', 'landingpress-wp' ); ?></div>
				<?php endif; ?>
				<form id="elementor-import-template-form" style="display: inline-block; margin-top: 30px; padding: 30px 50px; background-color: #fff; border: 1px solid #e5e5e5;" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" enctype="multipart/form-data">
					<input type="hidden" name="action" value="custom_elementor_import_template">
					<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
					<input type="hidden" name="_nonce" value="<?php echo wp_create_nonce( 'custom_elementor_ajax' ); ?>">
					<fieldset id="elementor-import-template-form-inputs">
						<?php if ( class_exists( '\ZipArchive' ) ) : ?>
							<input type="file" name="file" accept=".json,application/json,.zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed" required>
						<?php else : ?>
							<input type="file" name="file" accept=".json,application/json,application/octet-stream" required>
						<?php endif; ?>
						<input type="submit" class="button" value="<?php echo esc_attr__( 'Import Now', 'landingpress-wp' ); ?>">
					</fieldset>
				</form>
			</div>
		</div>
		<script type="text/javascript">
		window.onload = function() {
			if (window.jQuery) {
				var $importButton = jQuery( '#elementor-import-template-trigger' );
				var $importArea = jQuery( '#elementor-import-template-area' );
				if ( $importButton.length && $importArea.length ) {
					jQuery( '#wpbody-content' ).find( '.page-title-action:last' ).after( $importButton );
					jQuery( '#wpbody-content' ).find( '.page-title-action:last' ).after( $importArea );
					$importButton.on( 'click', function() {
						jQuery( '#elementor-import-template-area' ).toggle();
					} );
				}
			}
		}
		</script>
		<?php
	}

	public function handle_export_template() {
		$template_id = isset( $_REQUEST['template_id'] ) ? absint( $_REQUEST['template_id'] ) : 0;
		if ( ! $template_id ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $template_id ) ) {
			return;
		}

		if ( ! $this->verify_request_nonce() ) {
			$this->handle_direct_action_error( 'Access Denied' );
		}

		$file_data = $this->prepare_template_export( $template_id );

		if ( is_wp_error( $file_data ) ) {
			return $file_data;
		}

		$this->send_file_headers( $file_data['name'], strlen( $file_data['content'] ) );

		// Clear buffering just in case.
		@ob_end_clean();

		flush();

		// Output file contents.
		echo $file_data['content'];

		die;
	}

	public function handle_import_template() {
		$post_type = isset( $_REQUEST['post_type'] ) ? esc_attr( $_REQUEST['post_type'] ) : '';
		if ( ! $post_type ) {
			return;
		}

		if ( ! $this->verify_request_nonce() ) {
			$this->handle_direct_action_error( 'Access Denied' );
		}

		$result = $this->direct_import_template( $_FILES['file']['name'], $_FILES['file']['tmp_name'] );

		if ( is_wp_error( $result ) ) {
			$this->handle_direct_action_error( $result->get_error_message() );
		}
		else {
			$args = reset( $result );
			if ( 1 == count( $result ) ) {
				wp_safe_redirect( admin_url( 'post.php?post=' . $args['template_id'] . '&action=edit' ) );
			}
			else {
				if ( isset( $args['post_type'] ) ) {
					$post_type = $args['post_type'];
				}
				else {
					$post_type = get_post_type( $args['template_id'] );
				}
				wp_safe_redirect( admin_url( 'edit.php?post_type=' . $post_type ) );
			}
		}

		die;
	}

	private static function is_base_templates_screen( $post_type = '' ) {
		global $current_screen;

		if ( ! $current_screen ) {
			return false;
		}

		if ( 'edit' !== $current_screen->base ) {
			return false;
		}

		if ( ! empty( $post_type ) ) {
			if ( $post_type === $current_screen->post_type ) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			if ( 'elementor_library' === $current_screen->post_type ) {
				return false;
			}
			else {
				$cpt_support = get_option( 'elementor_cpt_support', [ 'page', 'post' ] );
				if ( ! empty( $cpt_support ) && in_array( $current_screen->post_type, $cpt_support ) ) {
					return true;
				}
				else {
					return false;
				}
			}
		}
	}

	private function get_export_link( $template_id ) {
		return add_query_arg(
			array(
				'action' => 'custom_elementor_export_template',
				'_nonce' => wp_create_nonce( 'custom_elementor_ajax' ),
				'template_id' => $template_id,
			),
			admin_url( 'admin-ajax.php' )
		);
	}

	private function direct_import_template( $name, $path ) {
		if ( empty( $path ) ) {
			return new \WP_Error( 'file_error', 'Please upload a file to import' );
		}

		$items = [];

		$file_extension = pathinfo( $name, PATHINFO_EXTENSION );

		if ( 'zip' === $file_extension ) {
			if ( ! class_exists( '\ZipArchive' ) ) {
				return new \WP_Error( 'zip_error', 'PHP Zip extension not loaded' );
			}

			$zip = new \ZipArchive();

			$wp_upload_dir = wp_upload_dir();

			$temp_path = $wp_upload_dir['basedir'] . '/' . self::TEMP_FILES_DIR . '/' . uniqid();

			$zip->open( $path );

			$valid_entries = [];

			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			for ( $i = 0; $i < $zip->numFiles; $i++ ) {
				$zipped_file_name = $zip->getNameIndex( $i );
				$zipped_extension = pathinfo( $zipped_file_name, PATHINFO_EXTENSION );
				if ( 'json' === $zipped_extension ) {
					$valid_entries[] = $zipped_file_name;
				}
			}

			if ( ! empty( $valid_entries ) ) {
				$zip->extractTo( $temp_path, $valid_entries );
			}

			$zip->close();

			$file_names = array_diff( scandir( $temp_path ), [ '.', '..' ] );

			foreach ( $file_names as $file_name ) {
				$full_file_name = $temp_path . '/' . $file_name;

				$import_result = $this->import_single_template( $full_file_name );

				unlink( $full_file_name );

				if ( is_wp_error( $import_result ) ) {
					return $import_result;
				}

				$items[] = $import_result;
			}

			rmdir( $temp_path );
		} else {
			$import_result = $this->import_single_template( $path );

			if ( is_wp_error( $import_result ) ) {
				return $import_result;
			}

			$items[] = $import_result;
		}

		return $items;
	}

	private function verify_request_nonce() {
		return ! empty( $_REQUEST['_nonce'] ) && wp_verify_nonce( $_REQUEST['_nonce'], 'custom_elementor_ajax' );
	}

	private function handle_direct_action_error( $message ) {
		_default_wp_die_handler( $message, 'Elementor Library' );
	}

	private function prepare_template_export( $template_id ) {
		$template_data = $this->get_data( [
			'template_id' => $template_id,
		] );

		if ( empty( $template_data['content'] ) ) {
			return new \WP_Error( 'empty_template', 'The template is empty' );
		}

		$template_data['content'] = $this->process_export_import_content( $template_data['content'], 'on_export' );

		if ( get_post_meta( $template_id, '_elementor_page_settings', true ) ) {
			$page = SettingsManager::get_settings_managers( 'page' )->get_model( $template_id );

			$page_settings_data = $this->process_element_export_import_content( $page, 'on_export' );

			if ( ! empty( $page_settings_data['settings'] ) ) {
				$template_data['page_settings'] = $page_settings_data['settings'];
			}
		}

		$export_data = [
			'version' => DB::DB_VERSION,
			'title' => get_the_title( $template_id ),
			'type' => 'page',
		];

		$export_data += $template_data;

		$post_type = get_post_type( $template_id );
		$post_type = str_replace( 'elementor_', '', $post_type );
		$post_slug = get_post_field( 'post_name', $template_id );

		return [
			'name' => 'elementor-' . $post_type . '-' . $template_id . '-' . $post_slug . '-' . gmdate( 'Ymd' ) . '.json',
			'content' => wp_json_encode( $export_data ),
		];
	}

	private function import_single_template( $file_name ) {
		$data = json_decode( file_get_contents( $file_name ), true );

		if ( empty( $data ) ) {
			return new \WP_Error( 'file_error', 'Invalid File' );
		}

		$content = $data['content'];

		if ( ! is_array( $content ) ) {
			return new \WP_Error( 'file_error', 'Invalid File' );
		}

		$content = $this->process_export_import_content( $content, 'on_import' );

		$page_settings = [];

		if ( ! empty( $data['page_settings'] ) ) {
			$page = new Model( [
				'id' => 0,
				'settings' => $data['page_settings'],
			] );

			$page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );

			if ( ! empty( $page_settings_data['settings'] ) ) {
				$page_settings = $page_settings_data['settings'];
			}
		}

		$template_id = $this->save_item( [
			'content' => $content,
			'title' => $data['title'],
			'type' => $data['type'],
			'page_settings' => $page_settings,
		] );

		if ( is_wp_error( $template_id ) ) {
			return $template_id;
		}

		return $this->get_item( $template_id );
	}

	private function get_data( array $args ) {
		$db = Plugin::$instance->db;

		$template_id = $args['template_id'];

		// TODO: Validate the data (in JS too!).
		if ( ! empty( $args['display'] ) ) {
			$content = $db->get_builder( $template_id );
		} else {
			$document = Plugin::$instance->documents->get( $template_id );
			$content = $document ? $document->get_elements_data() : [];
		}

		if ( ! empty( $content ) ) {
			$content = $this->replace_elements_ids( $content );
		}

		$data = [
			'content' => $content,
		];

		if ( ! empty( $args['with_page_settings'] ) ) {
			$page = SettingsManager::get_settings_managers( 'page' )->get_model( $args['template_id'] );

			$data['page_settings'] = $page->get_data( 'settings' );
		}

		return $data;
	}

	private function save_item( $template_data ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return new \WP_Error( 'save_error', __( 'Access denied.', 'landingpress-wp' ) );
		}

		$post_type = isset( $_POST['post_type'] ) ? esc_attr( $_POST['post_type'] ) : 'elementor_library';

		$defaults = [
			'title' => __( '(no title)', 'landingpress-wp' ),
			'page_settings' => [],
			'status' => current_user_can( 'publish_posts' ) ? 'publish' : 'pending',
		];

		$template_data = wp_parse_args( $template_data, $defaults );

		$document = Plugin::$instance->documents->create(
			$template_data['type'],
			[
				'post_title' => $template_data['title'],
				'post_status' => $template_data['status'],
				'post_type' => $post_type,
			]
		);

		if ( is_wp_error( $document ) ) {
			/**
			 * @var \WP_Error $document
			 */
			return $document;
		}

		if ( ! empty( $template_data['content'] ) ) {
			$template_data['content'] = $this->replace_elements_ids( $template_data['content'] );
		}

		$document->save( [
			'elements' => $template_data['content'],
			'settings' => $template_data['page_settings'],
		] );

		$template_id = $document->get_main_id();

		/**
		 * After template library save.
		 *
		 * Fires after Elementor template library was saved.
		 */
		do_action( 'elementor/template-library/after_save_template', $template_id, $template_data );

		/**
		 * After template library update.
		 *
		 * Fires after Elementor template library was updated.
		 */
		do_action( 'elementor/template-library/after_update_template', $template_id, $template_data );

		return $template_id;
	}

	private function get_item( $template_id ) {
		$post = get_post( $template_id );

		$data = [
			'template_id' => $post->ID,
			'source' => 'local',
			'type' => 'page',
			'title' => $post->post_title,
			'post_type' => get_post_type( $post->ID ),
		];

		return $data;
	}

	protected function replace_elements_ids( $content ) {
		return Plugin::$instance->db->iterate_data( $content, function( $element ) {
			$element['id'] = Utils::generate_random_string();

			return $element;
		} );
	}

	private function send_file_headers( $file_name, $file_size ) {
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename=' . $file_name );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		// header( 'Content-Length: ' . $file_size );
	}

	protected function process_export_import_content( $content, $method ) {
		return Plugin::$instance->db->iterate_data(
			$content, function( $element_data ) use ( $method ) {
				$element = Plugin::$instance->elements_manager->create_element_instance( $element_data );

				// If the widget/element isn't exist, like a plugin that creates a widget but deactivated
				if ( ! $element ) {
					return null;
				}

				return $this->process_element_export_import_content( $element, $method );
			}
		);
	}

	protected function process_element_export_import_content( Controls_Stack $element, $method ) {
		$element_data = $element->get_data();

		if ( method_exists( $element, $method ) ) {
			// TODO: Use the internal element data without parameters.
			$element_data = $element->{$method}( $element_data );
		}

		foreach ( $element->get_controls() as $control ) {
			$control_class = Plugin::$instance->controls_manager->get_control( $control['type'] );

			// If the control isn't exist, like a plugin that creates the control but deactivated.
			if ( ! $control_class ) {
				return $element_data;
			}

			if ( method_exists( $control_class, $method ) ) {
				$element_data['settings'][ $control['name'] ] = $control_class->{$method}( $element->get_settings( $control['name'] ), $control );
			}

			// On Export, check if the control has an argument 'export' => false.
			if ( 'on_export' === $method && isset( $control['export'] ) && false === $control['export'] ) {
				unset( $element_data['settings'][ $control['name'] ] );
			}
		}

		return $element_data;
	}

}

new CustomElementorExportImport();
