<?php 

use Elementor\Plugin;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CustomElementorControls {

	public function __construct() {
		add_filter( 'elementor/widget/print_template', array( $this, 'print_template' ), 10, 2 );
		if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) && strpos( ELEMENTOR_VERSION, 'LP' ) === false ) {
			add_action( 'elementor/element/button/section_button/after_section_end', array( $this, 'add_sticky' ), 10, 2 );
			add_action( 'elementor/element/button_lp/section_button/after_section_end', array( $this, 'add_sticky' ), 10, 2 );
			add_action( 'elementor/element/button_whatsapp/section_button/after_section_end', array( $this, 'add_sticky' ), 10, 2 );
			add_action( 'elementor/element/button_video/section_button/after_section_end', array( $this, 'add_sticky' ), 10, 2 );
			add_action( 'elementor/element/optin_2steps/section_button/after_section_end', array( $this, 'add_sticky' ), 10, 2 );
			add_action( 'elementor/element/woocommerce_product_addtocart_lp/section_button/after_section_end', array( $this, 'add_sticky' ), 10, 2 );
			add_action( 'elementor/element/lp_whatsapp_popup/section_form/after_section_end', array( $this, 'add_sticky' ), 10, 2 );

			add_action( 'elementor/element/button/section_button/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/button_lp/section_button/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/button_whatsapp/section_button/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/button_video/section_button/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/optin_2steps/section_button/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/woocommerce_product_addtocart_lp/section_button/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/lp_whatsapp_popup/section_form/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );

			add_action( 'elementor/element/lp_whatsapp_form/section_form/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/lp_contact_form/section_field_submit/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/lp_confirmation_form/section_field_submit/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );

			add_action( 'elementor/element/image/section_image/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/image_lp/section_image/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );
			add_action( 'elementor/element/image_video/section_image/after_section_end', array( $this, 'add_tracking_click' ), 10, 2 );

			add_action( 'elementor/widget/before_render_content', array( $this, 'before_render_content' ) );

			add_action( 'elementor/element/video/section_video/before_section_start', array( $this, 'add_video_note' ), 10, 2 );

			add_action( 'elementor/element/google_maps/section_map/before_section_start', array( $this, 'add_google_maps_note' ), 10, 2 );
			add_action( 'elementor/element/google_maps/section_map/before_section_end', array( $this, 'add_google_maps_pointer' ), 10, 2 );
		}
	}

	public function get_allowed_attributes() {
		$allowed_attributes = array(
			'button' => 'button',
			'button_lp' => 'button',
			'button_whatsapp' => 'button',
			'button_video' => 'button',
			'optin_2steps' => 'button',
			'woocommerce_product_addtocart_lp' => 'button',
			'lp_whatsapp_popup' => 'form',
			'lp_whatsapp_form' => 'form',
			'lp_contact_form' => 'button', 
			'lp_confirmation_form' => 'button',
			'image' => 'link',
			'image_lp' => 'link',
			'image_video' => 'link',
		);

		return $allowed_attributes;
	}

	public function add_sticky( $element, $args ) {
		$element->start_controls_section(
			'section_sticky',
			[
				'label' => __( 'Sticky / Floating Button', 'landingpress-wp' ),
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan sticky / floating button, harap letakkan button ini di <strong><u>SECTION PALING BAWAH</u></strong> untuk mendapatkan hasil terbaik.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke tab <strong><u>Advanced - Responsive</u></strong> jika ingin menyembunyikan sticky button di tampilan DESKTOP.', 'landingpress-wp' );

		$element->add_control(
			'floating_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$element->add_control(
			'floating',
			[
				'label' => __( 'Sticky / Floating', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$element->end_controls_section();

		$element->start_controls_section(
			'section_sticky_style',
			[
				'label' => __( 'Sticky / Floating Button Container', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'floating!' => '',
				],
			]
		);

		$element->add_control(
			'floating_bg_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button-sticky-yes' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'floating!' => '',
				],
			]
		);

		$element->add_control(
			'floating_padding',
			[
				'label' => __( 'Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button-sticky-yes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'floating!' => '',
				],
			]
		);

		$element->end_controls_section();
	}

	public function add_tracking_click( $element, $args ) {

		$name = $element->get_name();

		$allowed_attributes = $this->get_allowed_attributes();

		$condition = [];
		if ( in_array( $name, ['image', 'image_lp'] ) ) {
			$condition = [
				'link_to' => 'custom',
			];
		}

		$element->start_controls_section(
			'section_fbpixel',
			[
				'label' => __( 'Facebook Pixel', 'landingpress-wp' ),
				'condition' => $condition,
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini, pastikan ada minimal satu <strong><u>Facebook Pixel ID</u></strong> yang aktif.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke <strong><u>WordPress Dashboard - Appearance - Customize - LandingPress - Facebook Pixel</u></strong> untuk memasukkan Facebook Pixel ID.', 'landingpress-wp' );

		$element->add_control(
			'fbevent_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$element->add_control(
			'fbevent',
			[
				'label' => __( 'Onclick FB Event', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No Event', 'landingpress-wp' ),
					'ViewContent' => 'ViewContent',
					'AddToCart' => 'AddToCart',
					'InitiateCheckout' => 'InitiateCheckout',
					'AddCustomerInfo' => 'AddCustomerInfo',
					'AddPaymentInfo' => 'AddPaymentInfo',
					'Purchase' => 'Purchase',
					'AddToWishlist' => 'AddToWishlist',
					'Lead' => 'Lead',
					'CompleteRegistration' => 'CompleteRegistration',
					'Contact' => 'Contact',
					'CustomizeProduct' => 'CustomizeProduct',
					'Donate' => 'Donate',
					'FindLocation' => 'FindLocation',
					'Schedule' => 'Schedule',
					'Search' => 'Search',
					'StartTrial' => 'StartTrial',
					'Subscribe' => 'Subscribe',
					'custom' => 'Custom Event',
				],
			]
		);

		$element->add_control(
			'fbcustomevent_desc',
			[
				'raw' => __( 'Jika pakai FB Custom Event, jangan lupa untuk membuat Custom Conversion dengan menggunakan custom event tersebut di FB Ads Manager supaya bisa dimunculkan di FB Ads Report.', 'landingpress-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
				'condition' => [
					'fbevent' => 'custom',
				],
			]
		);

		$element->add_control(
			'fbcustomevent',
			[
				'label' => __( 'Custom Event Name', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'fbevent' => 'custom',
				],
			]
		);

		$element->add_control(
			'fb_value_desc',
			[
				'raw' => __( 'TIDAK WAJIB! Silahkan masukkan harga produk sebagai value, jika Anda ingin menggunakan parameter value ini, misalnya untuk perhitungan ROAS di FB Ads Report.', 'landingpress-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_value',
			[
				'label' => 'value',
				'type' => Controls_Manager::TEXT,
				'default' => '0',
				'placeholder' => '0',
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_currency',
			[
				'label' => 'currency',
				'type' => Controls_Manager::SELECT,
				'default' => 'IDR',
				'options' => [
					'IDR' => 'IDR (Indonesian Rupiah)',
					'DZD' => 'DZD (Algerian Dinar)',
					'ARS' => 'ARS (Argentine Peso)',
					'AUD' => 'AUD (Australian Dollar)',
					'BDT' => 'BDT (Bangladeshi Taka)',
					'BOB' => 'BOB (Bolivian Boliviano)',
					'BRL' => 'BRL (Brazilian Real)',
					'GBP' => 'GBP (British Pound)',
					'CAD' => 'CAD (Canadian Dollar)',
					'CLP' => 'CLP (Chilean Peso)',
					'CNY' => 'CNY (Chinese Yuan)',
					'COP' => 'COP (Colombian Peso)',
					'CRC' => 'CRC (Costa Rican Colon)',
					'CZK' => 'CZK (Czech Koruna)',
					'DKK' => 'DKK (Danish Krone)',
					'EGP' => 'EGP (Egyptian Pounds)',
					'EUR' => 'EUR (Euro)',
					'GTQ' => 'GTQ (Guatemalan Quetza)',
					'HNL' => 'HNL (Honduran Lempira)',
					'HKD' => 'HKD (Hong Kong Dollar)',
					'HUF' => 'HUF (Hungarian Forint)',
					'ISK' => 'ISK (Iceland Krona)',
					'INR' => 'INR (Indian Rupee)',
					'ILS' => 'ILS (Israeli New Shekel)',
					'JPY' => 'JPY (Japanese Yen)',
					'KES' => 'KES (Kenyan Shilling)',
					'KRW' => 'KRW (Korean Won)',
					'MOP' => 'MOP (Macau Patacas)',
					'MYR' => 'MYR (Malaysian Ringgit)',
					'MXN' => 'MXN (Mexican Peso)',
					'NZD' => 'NZD (New Zealand Dollar)',
					'NIO' => 'NIO (Nicaraguan Cordoba)',
					'NGN' => 'NGN (Nigerian Naira)',
					'NOK' => 'NOK (Norwegian Krone)',
					'PKR' => 'PKR (Pakistani Rupee)',
					'PYG' => 'PYG (Paraguayan Guarani)',
					'PEN' => 'PEN (Peruvian Nuevo Sol)',
					'PHP' => 'PHP (Philippine Peso)',
					'PLN' => 'PLN (Polish Zloty)',
					'QAR' => 'QAR (Qatari Rials)',
					'RON' => 'RON (Romanian Leu)',
					'RUB' => 'RUB (Russian Ruble)',
					'SAR' => 'SAR (Saudi Arabian Riyal)',
					'SGD' => 'SGD (Singapore Dollar)',
					'ZAR' => 'ZAR (South African Rand)',
					'SEK' => 'SEK (Swedish Krona)',
					'CHF' => 'CHF (Swiss Franc)',
					'TWD' => 'TWD (Taiwan Dollar)',
					'THB' => 'THB (Thai Baht)',
					'TRY' => 'TRY (Turkish Lira)',
					'AED' => 'AED (Uae Dirham)',
					'USD' => 'USD (United States Dollar)',
					'UYU' => 'UYU (Uruguay Peso)',
					'VEF' => 'VEF (Venezuelan Bolivar)',
					'VND' => 'VND (Vietnamese Dong)',
				],
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_campaign_url',
			[
				'label' => 'campaign_url',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => get_post_field( 'post_name', get_the_ID() ),
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_content_ids_desc',
			[
				'raw' => __( 'TIDAK WAJIB! Silahkan pakai parameter <strong><u>content_ids</u></strong> hanya jika Anda ingin menggunakan parameter ini untuk <strong><u>FB Product Catalog</u></strong> dan Anda sudah tahu cara setup Product Catalog di FB Ads Manager.', 'landingpress-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_content_ids',
			[
				'label' => 'content_ids',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_content_type',
			[
				'label' => 'content_type',
				'type' => Controls_Manager::SELECT,
				'default' => 'product',
				'options' => [
					'product' => 'product',
					'product_group' => 'product_group',
				],
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->add_control(
			'fb_content_name',
			[
				'label' => 'content_name',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => get_the_title(),
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$element->end_controls_section();


		$element->start_controls_section(
			'section_ttpixel',
			[
				'label' => __( 'Tiktok Pixel', 'landingpress-wp' ),
				'condition' => $condition,
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini, pastikan ada minimal satu <strong><u>Tiktok Pixel ID</u></strong> yang aktif.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke <strong><u>WordPress Dashboard - Appearance - Customize - LandingPress - Tiktok Pixel</u></strong> untuk memasukkan Tiktok Pixel ID.', 'landingpress-wp' );

		$element->add_control(
			'ttevent_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$element->add_control(
			'ttevent',
			[
				'label' => __( 'Onclick Tiktok Event', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No Event', 'landingpress-wp' ),
					'ViewContent' => 'ViewContent',
					'AddToCart' => 'AddToCart',
					'InitiateCheckout' => 'InitiateCheckout',
					'PlaceAnOrder' => 'PlaceAnOrder',
					'CompletePayment' => 'CompletePayment',
					'AddPaymentInfo' => 'AddPaymentInfo',
					'AddToWishlist' => 'AddToWishlist',
					'ClickButton' => 'ClickButton',
					'Contact' => 'Contact',
					'Download' => 'Download',
					'Search' => 'Search',
					'Subscribe' => 'Subscribe',
					'SubmitForm' => 'SubmitForm',
					'CompleteRegistration' => 'CompleteRegistration',
				],
			]
		);

		$element->add_control(
			'tt_value_desc',
			[
				'raw' => __( 'TIDAK WAJIB! Silahkan isi parameter berikut jika Anda menggunakan fitur Return on Ad Spend (ROAS), Dynamic Showcase Ads (DSA), atau Value-Based Optimization (VBO) di Tiktok Ads.', 'landingpress-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_value',
			[
				'label' => 'value',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '0',
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_currency',
			[
				'label' => 'currency',
				'type' => Controls_Manager::SELECT,
				'default' => 'IDR',
				'options' => [
					'IDR' => 'IDR (Indonesian Rupiah)',
					'DZD' => 'DZD (Algerian Dinar)',
					'ARS' => 'ARS (Argentine Peso)',
					'AUD' => 'AUD (Australian Dollar)',
					'BHD' => 'BHD (Bahraini Dinar)',
					'BDT' => 'BDT (Bangladeshi Taka)',
					'BOB' => 'BOB (Bolivian Boliviano)',
					'BRL' => 'BRL (Brazilian Real)',
					'GBP' => 'GBP (British Pound)',
					'BIF' => 'BIF (Burundian Franc)',
					'KHR' => 'KHR (Cambodian Riel)',
					'CAD' => 'CAD (Canadian Dollar)',
					'CLP' => 'CLP (Chilean Peso)',
					'CNY' => 'CNY (Chinese Yuan)',
					'COP' => 'COP (Colombian Peso)',
					'CRC' => 'CRC (Costa Rican Colon)',
					'CZK' => 'CZK (Czech Koruna)',
					'DKK' => 'DKK (Danish Krone)',
					'EGP' => 'EGP (Egyptian Pounds)',
					'EUR' => 'EUR (Euro)',
					'GTQ' => 'GTQ (Guatemalan Quetza)',
					'HNL' => 'HNL (Honduran Lempira)',
					'HKD' => 'HKD (Hong Kong Dollar)',
					'HUF' => 'HUF (Hungarian Forint)',
					'ISK' => 'ISK (Iceland Krona)',
					'INR' => 'INR (Indian Rupee)',
					'ILS' => 'ILS (Israeli New Shekel)',
					'JPY' => 'JPY (Japanese Yen)',
					'KZT' => 'KZT (Kazakhstani Tenge)',
					'KES' => 'KES (Kenyan Shilling)',
					'KRW' => 'KRW (Korean Won)',
					'KWD' => 'KWD (Kuwaiti Dinar)',
					'MOP' => 'MOP (Macau Patacas)',
					'MYR' => 'MYR (Malaysian Ringgit)',
					'MXN' => 'MXN (Mexican Peso)',
					'MAD' => 'MAD (Moroccan Dirham)',
					'NZD' => 'NZD (New Zealand Dollar)',
					'NIO' => 'NIO (Nicaraguan Cordoba)',
					'NGN' => 'NGN (Nigerian Naira)',
					'NOK' => 'NOK (Norwegian Krone)',
					'OMR' => 'OMR (Omani Rial)',
					'PKR' => 'PKR (Pakistani Rupee)',
					'PYG' => 'PYG (Paraguayan Guarani)',
					'PEN' => 'PEN (Peruvian Nuevo Sol)',
					'PHP' => 'PHP (Philippine Peso)',
					'PLN' => 'PLN (Polish Zloty)',
					'QAR' => 'QAR (Qatari Rials)',
					'RON' => 'RON (Romanian Leu)',
					'RUB' => 'RUB (Russian Ruble)',
					'SAR' => 'SAR (Saudi Arabian Riyal)',
					'SGD' => 'SGD (Singapore Dollar)',
					'ZAR' => 'ZAR (South African Rand)',
					'SEK' => 'SEK (Swedish Krona)',
					'CHF' => 'CHF (Swiss Franc)',
					'TWD' => 'TWD (Taiwan Dollar)',
					'THB' => 'THB (Thai Baht)',
					'TRY' => 'TRY (Turkish Lira)',
					'AED' => 'AED (Uae Dirham)',
					'UAH' => 'UAH (Ukrainian Hryvnia)',
					'USD' => 'USD (United States Dollar)',
					'VES' => 'VES (Venezuelan Sovereign Bolívar)',
					'VND' => 'VND (Vietnamese Dong)',
				],
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_price',
			[
				'label' => 'price',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '0',
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_quantity',
			[
				'label' => 'quantity',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '1',
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_content_id',
			[
				'label' => 'content_id',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_content_type',
			[
				'label' => 'content_type',
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => '',
					'product' => 'product',
					'product_group' => 'product_group',
				],
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->add_control(
			'tt_content_name',
			[
				'label' => 'content_name',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'ttevent' => ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'],
				],
			]
		);

		$element->end_controls_section();

		$element->start_controls_section(
			'section_adwords',
			[
				'label' => __( 'Google Ads (AdWords)', 'landingpress-wp' ),
				'condition' => $condition,
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini dengan Google Ads (AdWords) versi baru (beta), pastikan ada minimal satu <strong><u>Google Ads (AdWords) Global Site Tag ID</u></strong> yang aktif.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini dengan Google Ads (AdWords) versi lama, harap masukkan kode adwords conversion untuk "onclick button" di <strong><u>Custom Footer Scripts</u></strong> di halaman ini.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke <strong><u>WordPress Dashboard - Appearance - Customize - LandingPress - Google Ads (AdWords)</u></strong> untuk memasukkan Google Ads (AdWords) Global Site Tag ID (versi baru) atau Google Ads (AdWords) Remarketing Tag (versi lama).', 'landingpress-wp' );

		$element->add_control(
			'grc_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$element->add_control(
			'grc',
			[
				'label' => __( 'Onclick AdWords Conversion', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$element->add_control(
			'aw_send_to',
			[
				'label' => 'send_to',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$element->add_control(
			'aw_value_desc',
			[
				'raw' => __( 'TIDAK WAJIB! Silahkan masukkan harga produk sebagai value, jika Anda ingin menggunakan fitur lain di Google Ads, seperti Target ROAS misalnya.', 'landingpress-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$element->add_control(
			'aw_value',
			[
				'label' => 'value',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '0',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$element->add_control(
			'aw_currency',
			[
				'label' => 'currency',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 'IDR',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$element->add_control(
			'aw_transaction_id',
			[
				'label' => 'transaction_id',
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$element->end_controls_section();
	}

	public function before_render_content( $element ) {

		$name = $element->get_name();

		$allowed_attributes = $this->get_allowed_attributes();
		$allowed_names = array_keys( $allowed_attributes );

		if ( ! in_array( $name, $allowed_names ) ) {
			return;
		}

		$attribute_name = $allowed_attributes[$name];

		// $data = $element->get_data();
		// $settings = $data['settings'];

		$settings = $element->get_settings_for_display();

		$allowed_tracking = false;
		if ( $attribute_name == 'link' ) {
			if ( isset($settings['link_to']) && $settings['link_to'] == 'custom' ) {
				$allowed_tracking = true;
			}
			if ( $name == 'image_video' ) {
				$allowed_tracking = true;
			}
		}
		else {
			$allowed_tracking = true;
		}

		if ( isset($settings['floating']) && $settings['floating'] ) {
			$element->add_render_attribute( 'wrapper', 'class', 'elementor-button-sticky-' . $settings['floating'] );
		}

		if ( $attribute_name == 'link' ) {
			$element->add_render_attribute( 'link', 'class', 'elementor-image-link' );
		}

		if ( $allowed_tracking ) {

			if ( $settings['fbevent'] ) {
				if ( $settings['fbevent'] == 'custom' ) {
					if ( $settings['fbcustomevent'] ) {
						$element->add_render_attribute( $attribute_name, 'data-fbcustomevent', $settings['fbcustomevent'] );
					}					
				}
				else {
					$element->add_render_attribute( $attribute_name, 'data-fbevent', $settings['fbevent'] );
				}
				$fb_data = [];
				$fb_data['source'] = 'landingpress-'.str_replace('_', '-', $name);
				$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
				if ( is_singular() ) {
					$fb_data['campaign_url'] = get_queried_object()->post_name;
					$fb_data['content_name'] = get_the_title();
				}
				if ( $settings['fbevent'] == 'Purchase' ) {
					$fb_data['value'] = '0';
					$fb_data['currency'] = 'IDR';
				}
				if ( trim($settings['fb_value']) ) {
					$fb_data['value'] = trim($settings['fb_value']);
				}
				else {
					$fb_data['value'] = '0.00';
				}
				if ( $settings['fb_currency'] ) {
					$fb_data['currency'] = trim($settings['fb_currency']);
				}
				else {
					$fb_data['currency'] = 'IDR';
				}
				if ( trim($settings['fb_content_name']) ) {
					$fb_data['content_name'] = trim($settings['fb_content_name']);
				}
				if ( trim($settings['fb_content_ids']) ) {
					$fb_data['content_ids'] = array_map( 'trim', explode( ',', $settings['fb_content_ids'] ) );
					if ( $settings['fb_content_type'] ) {
						$fb_data['content_type'] = trim($settings['fb_content_type']);
					}
					else {
						$fb_data['content_type'] = 'product';
					}
				}
				if ( trim($settings['fb_campaign_url']) ) {
					$fb_data['campaign_url'] = trim($settings['fb_campaign_url']);
				}
				$element->add_render_attribute( $attribute_name, 'data-fbdata', json_encode( $fb_data ) );
			}

			if ( $settings['ttevent'] ) {
				$element->add_render_attribute( $attribute_name, 'data-ttevent', $settings['ttevent'] );
				$tt_data = [];
				if ( $settings['fbevent'] == 'Purchase' ) {
					$tt_data['value'] = '0';
					$tt_data['currency'] = 'IDR';
				}
				$tt_value = floatval($settings['tt_value']);
				if ($tt_value > 0) {
					$tt_data['value'] = $tt_value;
					$tt_data['currency'] = $settings['tt_currency'] ? trim($settings['tt_currency']) : 'IDR';
				}
				$tt_price = floatval($settings['tt_price']);
				if ($tt_price > 0) {
					$tt_data['price'] = $tt_price;
					$tt_quantity = intval($settings['tt_quantity']);
					$tt_data['quantity'] = $tt_quantity > 0 ? $tt_quantity : 1;
				}
				if ( trim($settings['tt_content_name']) ) {
					$tt_data['content_name'] = trim($settings['tt_content_name']);
				}
				if ( trim($settings['tt_content_id']) ) {
					$tt_data['content_id'] = trim($settings['tt_content_id']);
				}
				if ( trim($settings['tt_content_type']) ) {
					$tt_data['content_type'] = trim($settings['tt_content_type']);
				}
				$element->add_render_attribute( $attribute_name, 'data-ttdata', json_encode( $tt_data ) );
			}

			if ( $settings['grc'] == 'yes' ) {
				$element->add_render_attribute( $attribute_name, 'data-grc', $settings['grc'] );
				$aw_data = [];
				if ( $settings['aw_send_to'] ) {
					$aw_data['send_to'] = trim($settings['aw_send_to']);
				}
				if ( $settings['aw_value'] ) {
					$aw_data['value'] = trim($settings['aw_value']);
				}
				if ( $settings['aw_currency'] ) {
					$aw_data['currency'] = trim($settings['aw_currency']);
				}
				if ( $settings['aw_transaction_id'] ) {
					$aw_data['transaction_id'] = trim($settings['aw_transaction_id']);
				}
				$element->add_render_attribute( $attribute_name, 'data-awdata', json_encode( $aw_data, JSON_UNESCAPED_SLASHES ) );
			}
		}
	}

	public function add_video_note( $element, $args ) {

		$element->start_controls_section(
			'section_important',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Jika Anda menggunakan shared hosting, kami tidak menyarankan Anda menggunakan widget ini karena <strong><u>bisa membuat halaman Anda menjadi lambat (SLOW LOADING)</u></strong> karena penggunaan oEmbed yang membutuhkan koneksi cURL setiap loading halaman tersebut.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Sebagai alternatif, silahkan Anda menggunakan <strong><u>LP - Youtube Video widget dari LandingPress</u></strong> supaya tetap fast loading.', 'landingpress-wp' );

		$element->add_control(
			'important_notes',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$element->end_controls_section();
	}

	public function add_google_maps_note( $element, $args ) {

		$element->start_controls_section(
			'section_important',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Widget Google Maps ini menggunakan iframe sehingga bisa berpotensi <strong><u>membuat halaman Anda menjadi sedikit lambat</u></strong>.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika Anda ingin pakai widget ini dan sangat concern dengan page speed, kami menyarankan Anda untuk menggunakan <strong><u>LazyLoad Iframe</u></strong> (plugin) supaya tetap fast loading.', 'landingpress-wp' );

		$element->add_control(
			'important_notes',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$element->end_controls_section();
	}

	public function add_google_maps_pointer( $element, $args ) {

		$element->add_control(
			'prevent_scroll',
			[
				'label' => __( 'Prevent Scroll', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} iframe' => 'pointer-events: none;',
				],
			]
		);
	}

	public function print_template( $template_content, $element ) {

		$name = $element->get_name();

		if ( $name == 'button' ) {
			$template_content = str_replace( '<div class="elementor-button-wrapper">', '<div class="elementor-button-wrapper elementor-button-sticky-{{ settings.floating }}">', $template_content );
		}

		return $template_content;
	}

}

new CustomElementorControls();
