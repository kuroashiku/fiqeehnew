<?php
namespace ElementorLandingPress;

use ElementorLandingPress\Widgets\LP_Navigation_Menu;
use ElementorLandingPress\Widgets\LP_Posts_Grid;
use ElementorLandingPress\Widgets\LP_Contact_Form;
use ElementorLandingPress\Widgets\LP_Confirmation_Form;
use ElementorLandingPress\Widgets\LP_Whatsapp_Form;
use ElementorLandingPress\Widgets\LP_Whatsapp_Popup;
use ElementorLandingPress\Widgets\LP_Slider_Image;
use ElementorLandingPress\Widgets\LP_Slider_Content;
use ElementorLandingPress\Widgets\LP_Video_Youtube;
use ElementorLandingPress\Widgets\LP_Button;
use ElementorLandingPress\Widgets\LP_Button_Whatsapp;
use ElementorLandingPress\Widgets\LP_Button_Video;
use ElementorLandingPress\Widgets\LP_Image;
use ElementorLandingPress\Widgets\LP_Image_Video;
use ElementorLandingPress\Widgets\LP_Countdown_Simple;
use ElementorLandingPress\Widgets\LP_Countdown_Evergreen;
use ElementorLandingPress\Widgets\LP_Optin;
use ElementorLandingPress\Widgets\LP_Optin_2steps;
use ElementorLandingPress\Widgets\LP_FB_Comments;
use ElementorLandingPress\Widgets\LP_WC_Products;
use ElementorLandingPress\Widgets\LP_WC_Products_On_Sale;
use ElementorLandingPress\Widgets\LP_WC_Products_Best_Selling;
use ElementorLandingPress\Widgets\LP_WC_Product_Categories;
use ElementorLandingPress\Widgets\LP_WC_Product_AddToCart;
use ElementorLandingPress\Widgets\LP_Wuoy_Buy_Button;
use ElementorLandingPress\Widgets\LP_Wuoy_Content_Protection;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Addons Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Addons {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/init', [ $this, 'on_init' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'on_categories_registered' ], 1 );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ], 1 );
		add_filter( 'landingpress_customize_controls', [ $this, 'customize_controls' ], 20 );
		add_action( 'wp_head', [ $this, 'custom_header_footer_config' ] );
		add_filter( 'wp_enqueue_scripts', [ $this, 'custom_header_footer_css' ] );
		add_action( 'landingpress_page_before', [ $this, 'custom_header_elementor' ] );
		add_action( 'landingpress_page_after', [ $this, 'custom_footer_elementor' ] );
		add_action( 'admin_action_elementor', [ $this, 'register_wc_hooks' ], 9 );
	}

	/**
	 * On Init
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_init() {
	}

	/**
	 * On Categories Registered
	 *
	 * @since 3.0.0
	 *
	 * @access public
	 */
	public function on_categories_registered( $elements_manager ) {
		$elements_manager->add_category(
			'landingpress',
			[
				'title' => __( 'LandingPress', 'landingpress-wp' ),
				'icon' => 'font',
			]
		);
		$elements_manager->add_category(
			'landingpress-woocommerce',
			[
				'title' => __( 'LandingPress WooCommerce', 'landingpress-wp' ),
				'icon' => 'font',
			]
		);
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		$widget_dir = 'widgets';
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/navigation-menu.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/posts-grid.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/contact-form.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/confirmation-form.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/whatsapp-form.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/whatsapp-popup.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/slider-image.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/slider-content.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/video-youtube.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/button-whatsapp.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/image-video.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/countdown-simple.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/countdown-evergreen.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/optin.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/fb-comments.php' );
		if ( function_exists( 'WC' ) ) {
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/wc-products.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/wc-products-on-sale.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/wc-products-best-sellings.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/wc-product-categories.php' );
		}
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/button-video.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/optin-2steps.php' );
		if ( function_exists( 'WC' ) ) {
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/wc-product-addtocart.php' );
		}
		if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/image.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/'.$widget_dir.'/button.php' );
		}
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button() );
		}
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Whatsapp() );
		if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Image() );
		}
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Image_Video() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Video_Youtube() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Video() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Countdown_Simple() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Countdown_Evergreen() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Optin() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Optin_2steps() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Slider_Image() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Slider_Content() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Whatsapp_Form() );
		if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Whatsapp_Popup() );
		}
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Contact_Form() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Confirmation_Form() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Navigation_Menu() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Posts_Grid() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_FB_Comments() );
		if ( function_exists( 'WC' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Products() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Products_On_Sale() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Products_Best_Selling() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Product_Categories() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Product_AddToCart() );
		}
	}

	public function customize_controls( $controls ) {
		if ( did_action( 'elementor/loaded' )  ) {
			$templates_local = \Elementor\Plugin::$instance->templates_manager->get_source( 'local' );
			$templates = $templates_local->get_items();
			$options_header = array( '' => esc_html__( 'No Custom Header', 'landingpress-wp' ) );
			$options_footer = array( '' => esc_html__( 'No Custom Footer', 'landingpress-wp' ) );
			foreach ( $templates as $template ) {
				$template_id = $template['template_id'];
				$options_header[$template_id] = $template['title'].' ('.$template['type'].')';
				$options_footer[$template_id] = $template['title'].' ('.$template['type'].')';
			}
			$controls[] = array(
				'type'     => 'heading',
				'setting'  => 'landingpress_heading_page_header',
				'label'    => esc_html__( 'Custom Header/Footer', 'landingpress-wp' ),
				'description' => 'Anda bisa juga menampilkan header / footer custom yang dibuat di Elementor Library. Sangat cocok untuk layout halaman tipe "Full Width".',
				'section'  => 'landingpress_pagelayout',
			);
			$controls[] = array(
				'type'     => 'select',
				'setting'  => 'landingpress_page_header_elementor',
				'label'    => esc_html__( 'Custom Header From Elementor Library', 'landingpress-wp' ),
				'section'  => 'landingpress_pagelayout',
				'choices'  => $options_header,
			);
			$controls[] = array(
				'type'     => 'select',
				'setting'  => 'landingpress_page_footer_elementor',
				'label'    => esc_html__( 'Custom Footer From Elementor Library', 'landingpress-wp' ),
				'section'  => 'landingpress_pagelayout',
				'choices'  => $options_footer,
			);
		}
		return $controls;
	}

	public function custom_header_footer_config() {
		global $landingpress_page_header_elementor_id, $landingpress_page_footer_elementor_id;
		$landingpress_page_header_elementor_id = get_theme_mod('landingpress_page_header_elementor');
		$landingpress_page_footer_elementor_id = get_theme_mod('landingpress_page_footer_elementor');
		if ( is_singular('post') || is_page() ) {
			$id = get_queried_object_id();
			$custom_header = get_post_meta( $id, '_landingpress_page_header_custom', true );
			if ( $custom_header == 'disable' ) {
				$landingpress_page_header_elementor_id = '';
			}
			elseif ( $custom_header == 'custom' ) {
				$landingpress_page_header_elementor_id = get_post_meta( $id, '_landingpress_page_header_elementor', true );
			}
			$custom_footer = get_post_meta( $id, '_landingpress_page_footer_custom', true );
			if ( $custom_footer == 'disable' ) {
				$landingpress_page_footer_elementor_id = '';
			}
			elseif ( $custom_footer == 'custom' ) {
				$landingpress_page_footer_elementor_id = get_post_meta( $id, '_landingpress_page_footer_elementor', true );
			}
		}
	}

	public function custom_header_footer_css() {
		if ( did_action( 'elementor/loaded' )  ) {
			global $landingpress_page_header_elementor_id, $landingpress_page_footer_elementor_id;
			if ( $id = $landingpress_page_header_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					$meta = get_post_meta( $id, '_elementor_css', true );
					if ( isset( $meta['css'] ) ) {
						wp_add_inline_style( 'elementor-frontend', $meta['css'] );
					}
				}
			}
			if ( $id = $landingpress_page_footer_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					$meta = get_post_meta( $id, '_elementor_css', true );
					if ( isset( $meta['css'] ) ) {
						wp_add_inline_style( 'elementor-frontend', $meta['css'] );
					}
				}
			}
		}
	}

	public function custom_header_elementor() {
		if ( did_action( 'elementor/loaded' )  ) {
			global $landingpress_page_header_elementor_id;
			if ( $id = $landingpress_page_header_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
				}
			}
		}
	}

	public function custom_footer_elementor() {
		if ( did_action( 'elementor/loaded' )  ) {
			global $landingpress_page_footer_elementor_id;
			if ( $id = $landingpress_page_footer_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
				}
			}
		}
	}

	public function register_wc_hooks() {
		if ( ! class_exists('woocommerce') ) {
			return;
		}
		wc()->frontend_includes();
	}

}

new Addons();
