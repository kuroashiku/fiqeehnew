<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'cmb_meta_boxes', 'landingpress_cmb_meta_boxes' );
function landingpress_cmb_meta_boxes( array $meta_boxes ) {

	// _elementor_edit_mode = builder

	$fields = array(
		array( 
			'id' => '_landingpress_heading_page_layout', 
			'name' => '', 
			'desc' => esc_html__( 'Silahkan gunakan opsi berikut untuk menyembunyikan sidebar, header, footer, dan lain-lain di halaman ini saja.', 'landingpress-wp'), 
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_hide_sidebar',  
			'name' => esc_html__( 'Hide Sidebar', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_header',  
			'name' => esc_html__( 'Hide Header', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_menu',  
			'name' => esc_html__( 'Hide Header Menu', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_footerwidgets',  
			'name' => esc_html__( 'Hide Footer Widgets', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_footer',  
			'name' => esc_html__( 'Hide Footer', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_breadcrumb',  
			'name' => esc_html__( 'Hide Breadcrumb', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_title',  
			'name' => esc_html__( 'Hide Title', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_comments',  
			'name' => esc_html__( 'Hide Comments', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-layout',
		'title' => esc_html__( 'Page Layout Settings', 'landingpress-wp' ),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
		'hide_on' => array( 
			'page-template' => array( 
				'page_landingpress.php', 
				'page_landingpress_boxed.php', 
				'page_landingpress_slim.php',
				'elementor_canvas',
			) 
		),
	);

	$fields = array(
		array( 
			'id' => '_landingpress_heading_page_width', 
			'name' => '', 
			'desc' => esc_html__( 'Silahkan gunakan opsi berikut untuk merubah lebar halaman, dalam satuan pixel, di halaman ini saja.', 'landingpress-wp'), 
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_page_width',  
			'name' => esc_html__( 'Page Width', 'landingpress-wp' ), 
			'type' => 'select', 
			'options' => array( 
				'0' => esc_html__( 'default', 'landingpress-wp' ), 
				'500' => '500px', 
				'600' => '600px', 
				'700' => '700px', 
				'800' => '800px',
				'900' => '900px',
				'960' => '960px',
				'1000' => '1000px',
				'1100' => '1100px',
				'1140' => '1140px',
				'1200' => '1200px',
			) 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-page-width',
		'title' => esc_html__( 'Page Width', 'landingpress-wp' ),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
		'hide_on' => array( 
			'page-template' => array( 
				'page_landingpress.php', 
				'page_landingpress_hf.php', 
				'page_landingpress_slim.php',
				'page_landingpress_slim_hf.php',
				'elementor_canvas',
			) 
		),
	);

	$fbevents = array(
		'PageView' => 'PageView '.esc_html__( '(default)', 'landingpress-wp' ),
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
	);
	$fields = array(
		array( 
			'id' => '_landingpress_heading_facebook-event', 
			'name' => '', 
			'desc' => esc_html__( 'Silahkan pilih FB Pixel event yang khusus dijalankan saat loading halaman ini (bukan button-click). Pastikan sudah memasukkan FB Pixel ID di Appearance - Customize - LandingPress - Facebook Pixel.', 'landingpress-wp'),
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_facebook-event',  
			'name' => esc_html__( 'Facebook Pixel Event di Page Loading', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => $fbevents, 
		),
		array( 
			'id' => '_landingpress_facebook-custom-event', 
			'name' => esc_html__( 'Facebook Pixel Custom Event Name', 'landingpress-wp'), 
			'type' => 'text', 
			'cols' => 12, 
			'placeholder' => 'Contoh: LeadWA',
		),
		array( 
			'id' => '_landingpress_facebook-param-value', 
			'name' => 'value', 
			'type' => 'text', 
			'cols' => 6, 
			'placeholder' => '0 (harga produk, tidak wajib)',
		),
		array( 
			'id' => '_landingpress_facebook-param-currency', 
			'name' => 'currency', 
			'type' => 'select', 
			'options' => array(
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
			), 
			'cols' => 6, 
		),
		array( 
			'id' => '_landingpress_facebook-param-content_ids', 
			'name' => 'content_ids', 
			'type' => 'text', 
			'cols' => 4, 
			'placeholder' => 'tidak wajib (tingkat mahir)',
		),
		array( 
			'id' => '_landingpress_facebook-param-content_type', 
			'name' => 'content_type', 
			'type' => 'select', 
			'options' => array(
				'' => '',
				'product' => 'product',
				'product_group' => 'product_group',
			), 
			'cols' => 4, 
		),
		array( 
			'id' => '_landingpress_facebook-param-content_name', 
			'name' => 'content_name', 
			'type' => 'text', 
			'cols' => 4, 
			'placeholder' => 'tidak wajib (tingkat mahir)',
		),
		array( 
			'id' => '_landingpress_facebook-custom-params', 
			'name' => esc_html__( 'Facebook Pixel Custom Parameters', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'custom_param_key',  
					'name' => esc_html__( 'Parameter Key', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 6, 
					'placeholder' => 'ex: campaign_url (tidak wajib)',
				),
				array( 
					'id' => 'custom_param_value',  
					'name' => esc_html__( 'Parameter Value', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 6, 
					'placeholder' => '(tidak wajib)',
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Custom Parameter', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Custom Parameter' , 'landingpress-wp'),
		),
		array( 
			'id' => '_landingpress_facebook-pixels', 
			'name' => esc_html__( 'Multiple Facebook Pixel IDs', 'landingpress-wp'), 
			'desc' => '<p style="margin-top:-10px">'.esc_html__( 'Ingin pakai FB Pixel ID lebih dari satu khusus di halaman ini saja? Silahkan gunakan fitur ini.', 'landingpress-wp').'</p>', 
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'pixel_id',  
					'name' => esc_html__( 'Facebook Pixel ID', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 12, 
					'placeholder' => '123XXXXXXXXX (tidak wajib)',
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Facebook Pixel ID', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Facebook Pixel ID' , 'landingpress-wp'),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-facebook-pixel',
		'title' => esc_html__( 'Facebook Pixel Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$ttevents = array(
		'PageView' => 'PageView '.esc_html__( '(default)', 'landingpress-wp' ),
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
	);
	$fields = array(
		array( 
			'id' => '_landingpress_heading_tiktok-event', 
			'name' => '', 
			'desc' => esc_html__( 'Silahkan pilih Tiktok Pixel event yang khusus dijalankan saat loading halaman ini (bukan button-click). Pastikan sudah memasukkan Tiktok Pixel ID di Appearance - Customize - LandingPress - Tiktok Pixel.', 'landingpress-wp'),
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_tiktok-event',  
			'name' => esc_html__( 'Tiktok Pixel Event di Page Loading', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => $ttevents, 
		),
		array( 
			'id' => '_landingpress_heading_tiktok-parameter', 
			'name' => '', 
			'desc' => esc_html__( '[TIDAK WAJIB] Silahkan isi parameter berikut jika Anda menggunakan fitur Return on Ad Spend (ROAS), Dynamic Showcase Ads (DSA), atau Value-Based Optimization (VBO) di Tiktok Ads.', 'landingpress-wp'),
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_tiktok-param-value', 
			'name' => 'value', 
			'type' => 'number', 
			'cols' => 3, 
			'placeholder' => '0',
		),
		array( 
			'id' => '_landingpress_tiktok-param-currency', 
			'name' => 'currency', 
			'type' => 'select', 
			'options' => array(
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
			), 
			'cols' => 3, 
		),
		array( 
			'id' => '_landingpress_tiktok-param-price', 
			'name' => 'price', 
			'type' => 'number', 
			'cols' => 3, 
			'placeholder' => '0',
		),
		array( 
			'id' => '_landingpress_tiktok-param-quantity', 
			'name' => 'quantity', 
			'type' => 'number', 
			'cols' => 3, 
			'placeholder' => '1',
		),
		array( 
			'id' => '_landingpress_tiktok-param-content_id', 
			'name' => 'content_id', 
			'type' => 'text', 
			'cols' => 3, 
			'placeholder' => '',
		),
		array( 
			'id' => '_landingpress_tiktok-param-content_type', 
			'name' => 'content_type', 
			'type' => 'select', 
			'options' => array(
				'' => '',
				'product' => 'product',
				'product_group' => 'product_group',
			), 
			'cols' => 3, 
		),
		array( 
			'id' => '_landingpress_tiktok-param-content_name', 
			'name' => 'content_name', 
			'type' => 'text', 
			'cols' => 3, 
			'placeholder' => '',
		),
		// array( 
		// 	'id' => '_landingpress_tiktok-custom-params', 
		// 	'name' => esc_html__( 'Tiktok Pixel Custom Parameters', 'landingpress-wp'), 
		// 	'desc' => '', 
		// 	'type' => 'group', 'cols' => 12, 
		// 	'fields' => array(
		// 		array( 
		// 			'id' => 'custom_param_key',  
		// 			'name' => esc_html__( 'Parameter Key', 'landingpress-wp'), 
		// 			'type' => 'text', 
		// 			'cols' => 6, 
		// 			'placeholder' => 'ex: value (tidak wajib)',
		// 		),
		// 		array( 
		// 			'id' => 'custom_param_value',  
		// 			'name' => esc_html__( 'Parameter Value', 'landingpress-wp'), 
		// 			'type' => 'text', 
		// 			'cols' => 6, 
		// 			'placeholder' => '(tidak wajib)',
		// 		),
		// 	), 
		// 	'repeatable' => true, 
		// 	'repeatable_max' => 10, 
		// 	'sortable' => true, 
		// 	'string-repeat-field' => esc_html__( 'Add Custom Parameter', 'landingpress-wp'), 
		// 	'string-delete-field' => esc_html__( 'Delete Custom Parameter' , 'landingpress-wp'),
		// ),
		array( 
			'id' => '_landingpress_tiktok-pixels', 
			'name' => esc_html__( 'Multiple Tiktok Pixel IDs', 'landingpress-wp'), 
			'desc' => '<strong>'.esc_html__( 'Ingin pakai Tiktok Pixel ID lebih dari satu khusus di halaman ini saja? Silahkan gunakan fitur ini.', 'landingpress-wp').'</strong>', 
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'pixel_id',  
					'name' => esc_html__( 'Tiktok Pixel ID', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 12, 
					'placeholder' => 'CXXXXXXXXX (tidak wajib)',
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Tiktok Pixel ID', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Tiktok Pixel ID' , 'landingpress-wp'),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-tiktok-pixel',
		'title' => esc_html__( 'Tiktok Pixel Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_heading_adwords', 
			'name' => '', 
			'desc' => '<p>'.esc_html__( 'Silahkan gunakan opsi ini untuk memasukkan conversion tracking Google Ads yang khusus dijalankan saat loading halaman ini (bukan button-click).', 'landingpress-wp').'</p><p>'.esc_html__( 'Silahkan login ke akun Google Ads (AdWords), kemudian ke menu Tools - Measurement - Conversions untuk membuat Conversion Action baru.', 'landingpress-wp').'</p>',
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_adwords-conversions', 
			'name' => esc_html__( 'Google Ads (AdWords) Conversion Tracking di Page Loading', 'landingpress-wp'), 
			'desc' => '',
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'send_to',  
					'name' => 'send_to', 
					'type' => 'text', 
					'cols' => 3, 
					'placeholder' => 'AW-XXXXXX/YYYYYYYYYYY',
				),
				array( 
					'id' => 'value',  
					'name' => 'value', 
					'type' => 'text', 
					'cols' => 3, 
					'placeholder' => '0 (harga produk)',
				),
				array( 
					'id' => 'currency',  
					'name' => 'currency',  
					'type' => 'text', 
					'cols' => 3, 
					'placeholder' => 'IDR (mata uang)',
				),
				array( 
					'id' => 'transaction_id',  
					'name' => 'transaction_id',  
					'type' => 'text', 
					'cols' => 3, 
					'placeholder' => '(tidak wajib)',
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Conversion Tracking', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Conversion Tracking' , 'landingpress-wp'),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-adwords-conversion',
		'title' => esc_html__( 'Google Ads (AdWords) Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	if ( defined('WPSEO_VERSION') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_facebook_og', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi Facebook Sharing (Open Graph) di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Yoast WordPress SEO</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi Facebook Sharing (Open Graph) dari plugin %s.', 'landingpress-wp'), '<strong>Yoast WordPress SEO</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('RANK_MATH_VERSION') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_facebook_og', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi Facebook Sharing (Open Graph) di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Rank Math SEO</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi Facebook Sharing (Open Graph) dari plugin %s.', 'landingpress-wp'), '<strong>Rank Math SEO</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_facebook_og', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi Facebook Sharing (Open Graph) di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>All In One SEO Pack</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi Facebook Sharing (Open Graph) dari plugin %s.', 'landingpress-wp'), '<strong>All In One SEO Pack</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	else {
		// _yoast_wpseo_opengraph-title
		// _yoast_wpseo_opengraph-description
		// _yoast_wpseo_opengraph-image
		$fields = array(
			array( 
				'id' => '_landingpress_heading_facebook_og', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Silahkan gunakan opsi berikut untuk mengatur tampilan halaman ini ketika di-share di Facebook. Jika hasilnya tidak langsung terlihat, silahkan ke %s, masukkan URL halaman ini, klik Debug, klik Scrape Again untuk memaksa Facebook membuat versi terbaru dari halaman ini saat di-share.', 'landingpress-wp'), '<a href="https://developers.facebook.com/tools/debug/sharing/" target="_blank">Facebook Sharing Debug</a>' ).'</p>', 
				'type' => 'title' 
			),
			array( 
				'id' => '_landingpress_facebook-image', 
				'name' => esc_html__( 'Facebook Image', 'landingpress-wp'), 
				'type' => 'image' 
			),
			array( 
				'id' => '_landingpress_facebook-title', 
				'name' => esc_html__( 'Facebook Title', 'landingpress-wp'), 
				'type' => 'text' 
			),
			array( 
				'id' => '_landingpress_facebook-description', 
				'name' => esc_html__( 'Facebook Description', 'landingpress-wp'), 
				'type' => 'textarea' 
			),
		);
	}
	$meta_boxes[] = array(
		'id' => 'landingpress-facebook-sharing',
		'title' => esc_html__( 'Facebook Sharing (Open Graph) Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page', 'product' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	if ( defined('WPSEO_VERSION') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Yoast WordPress SEO</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi On-Page SEO dari plugin %s.', 'landingpress-wp'), '<strong>Yoast WordPress SEO</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('RANK_MATH_VERSION') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Rank Math SEO</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi On-Page SEO dari plugin %s.', 'landingpress-wp'), '<strong>Rank Math SEO</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>All-In-One SEO</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi On-Page SEO dari plugin %s.', 'landingpress-wp'), '<strong>All-In-One SEO</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('HeadSpace_Plugin') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Head Space</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi On-Page SEO dari plugin %s.', 'landingpress-wp'), '<strong>Head Space</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('Platinum_SEO_Pack') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Platinum SEO Pack</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi On-Page SEO dari plugin %s.', 'landingpress-wp'), '<strong>Platinum SEO Pack</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('SEO_Ultimate') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => '<p>'.sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>SEO Ultimate</strong>' ).'</p><p>'.sprintf( esc_html__( 'Silahkan gunakan opsi On-Page SEO dari plugin %s.', 'landingpress-wp'), '<strong>SEO Ultimate</strong>' ).'</p>', 
				'type' => 'title' 
			),
		);
	}
	else {
		// _yoast_wpseo_meta-robots-noindex
		// _yoast_wpseo_meta-robots-nofollow
		// _yoast_wpseo_title
		// _yoast_wpseo_metadesc
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => esc_html__( 'Silahkan gunakan opsi berikut untuk mengatur tampilan halaman ini di hasil pencarian search engine, misalnya Google. Hasil perubahannya tidak langsung terlihat, sepenuhnya dikontrol oleh masing-masing search engine.', 'landingpress-wp'), 
				'type' => 'title' 
			),
			array( 
				'id' => '_landingpress_meta-title', 
				'name' => esc_html__( 'Meta Title', 'landingpress-wp'), 
				'type' => 'text' 
			),
			array( 
				'id' => '_landingpress_meta-description', 
				'name' => esc_html__( 'Meta Description', 'landingpress-wp'), 
				'type' => 'textarea' 
			),
			array( 
				'id' => '_landingpress_meta-keywords', 
				'name' => esc_html__( 'Meta Keywords', 'landingpress-wp'), 
				'type' => 'text' 
			),
			array( 
				'id' => '_landingpress_meta-index', 
				'name' => esc_html__( 'Meta Robots Index', 'landingpress-wp'), 
				'type' => 'select', 
				'options' => array( 
					'index' => 'index', 
					'noindex' => 'noindex' 
				), 
				'allow_none' => false, 
				'cols' => 6 
			),
			array( 
				'id' => '_landingpress_meta-follow', 
				'name' => esc_html__( 'Meta Robots Follow', 'landingpress-wp'), 
				'type' => 'select', 
				'options' => array( 
					'follow' => 'follow', 
					'nofollow' => 'nofollow' 
				), 
				'allow_none' => false, 
				'cols' => 6 
			),
		);
	}
	$meta_boxes[] = array(
		'id' => 'landingpress-seo',
		'title' => esc_html__( 'On-Page SEO Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page', 'product' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_header_script', 
			'name' => esc_html__( 'Custom Header Script', 'landingpress-wp'), 
			'desc' => esc_html__( 'Silahkan gunakan opsi ini untuk memasukkan kode html/javascript yang akan dijalankan di halaman ini saja di bagian <head>.', 'landingpress-wp'), 
			'type' => 'textarea_code' 
		),
		array( 
			'id' => '_landingpress_footer_script', 
			'name' => esc_html__( 'Custom Footer Script', 'landingpress-wp'), 
			'desc' => esc_html__( 'Silahkan gunakan opsi ini untuk memasukkan kode html/javascript yang akan dijalankan di halaman ini saja di bagian bawah sebelum </body>.', 'landingpress-wp'), 
			'type' => 'textarea_code' 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-scripts',
		'title' => esc_html__( 'Header and Footer Scripts', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_redirect', 
			'name' => esc_html__( 'Redirect URL', 'landingpress-wp'), 
			'type' => 'text', 
			'placeholder' => 'https://', 
		),
		array( 
			'id' => '_landingpress_redirect_type', 
			'name' => esc_html__( 'Redirect Type', 'landingpress-wp'), 
			'type' => 'select', 
			'options' => array( 
				'301' => '301 - Moved Permanently',
				'302' => '302 - Moved Temporarily',
				'meta' => 'Meta Tag Redirect (Support FB Pixel, Analytics, GTM)',
				'javascript' => 'JavaScript Redirect (Support FB Pixel, Analytics, GTM)',
				'iframe' => 'Iframe (Support FB Pixel, Analytics, GTM)',
			), 
			'allow_none' => false, 
		),
		array( 
			'id' => '_landingpress_redirect_delay', 
			'name' => esc_html__( 'Delay Time', 'landingpress-wp'), 
			'desc' => esc_html__( 'Jika Anda pakai Facebook Pixel di halaman ini, harap gunakan delay minimal 2 detik untuk memakstikan pixel sudah terekam dengan baik.', 'landingpress-wp'), 
			'type' => 'select', 
			'options' => array( 
				'0' => 'no delay',
				'1' => '1 second',
				'2' => '2 seconds',
				'3' => '3 seconds',
				'4' => '4 seconds',
				'5' => '5 seconds',
			), 
			'allow_none' => true, 
		),
		array( 
			'id' => '_landingpress_redirect_message', 
			'name' => esc_html__( 'Loading Message', 'landingpress-wp'), 
			'type' => 'text', 
			'placeholder' => 'isi dengan tulisan yang muncul saat halaman ini masih loading...', 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-redirect',
		'title' => esc_html__( 'Redirect & Short Link Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page', 'product' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_page_header_custom', 
			'name' => esc_html__( 'Custom Header From Elementor Library', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => array( 
				'default' => 'default',
				'disable' => 'disable',
				'custom' => 'custom',
			), 
			'allow_none' => false, 
		),
		array( 
			'id' => '_landingpress_page_header_elementor', 
			'name' => esc_html__( 'Choose Header...', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'post_select', 
			'use_ajax' => false,
			'allow_none' => true,
			'query' => array( 
				'post_type' => 'elementor_library',
				'posts_per_page' => '-1',
				'orderby' => 'title',
				'order' => 'ASC',
			),
		),
		array( 
			'id' => '_landingpress_page_footer_custom', 
			'name' => esc_html__( 'Custom Footer From Elementor Library', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => array( 
				'default' => 'default',
				'disable' => 'disable',
				'custom' => 'custom',
			), 
			'allow_none' => false, 
		),
		array( 
			'id' => '_landingpress_page_footer_elementor', 
			'name' => esc_html__( 'Choose Footer...', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'post_select', 
			'use_ajax' => false,
			'allow_none' => true,
			'query' => array( 
				'post_type' => 'elementor_library',
				'posts_per_page' => '-1',
				'orderby' => 'title',
				'order' => 'ASC',
			),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-header-footer',
		'title' => esc_html__( 'Custom Header / Footer From Elementor', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	return $meta_boxes;

}

add_action( 'admin_head-post.php', 'landingpress_cmb_meta_boxes_scripts' );
add_action( 'admin_head-post-new.php', 'landingpress_cmb_meta_boxes_scripts' );
function landingpress_cmb_meta_boxes_scripts() {
    ?>
    <style type="text/css">
    .CMB_Title {
		margin-top: 0 !important;
		padding-top: 0 !important;
		padding-bottom: 0 !important;
    }
	.cmb_metabox .CMB_Group_Field>.field-title {
		font-size: 13px;
		font-weight: bold;
		margin-top: 0;
	}
    </style>
	<script type="text/javascript">
	/*<![CDATA[*/
	jQuery(document).ready(function($){
		if ( $('#_landingpress_facebook-event').length ) {
			var lp_fb_event = $('#_landingpress_facebook-event select').val();
			// console.log( 'lp_fb_event = ' + lp_fb_event );
			if ( lp_fb_event == 'custom' ) {
				$('#_landingpress_heading_facebook-custom-event').show();
				$('#_landingpress_facebook-custom-event').show();
			}
			else {
				$('#_landingpress_heading_facebook-custom-event').hide();
				$('#_landingpress_facebook-custom-event').hide();
			}
			if ( lp_fb_event != '' && lp_fb_event != 'PageView' ) {
				$('#_landingpress_facebook-param-value').show();
				$('#_landingpress_facebook-param-currency').show();
				$('#_landingpress_facebook-param-content_ids').show();
				$('#_landingpress_facebook-param-content_type').show();
				$('#_landingpress_facebook-param-content_name').show();
				$('#_landingpress_facebook-custom-params').show();
				$('#_landingpress_heading_facebook-param-value').show();
				$('#_landingpress_heading_facebook-content_ids').show();
				$('#_landingpress_heading_facebook-custom-params').show();
			}
			else {
				$('#_landingpress_facebook-param-value').hide();
				$('#_landingpress_facebook-param-currency').hide();
				$('#_landingpress_facebook-param-content_ids').hide();
				$('#_landingpress_facebook-param-content_type').hide();
				$('#_landingpress_facebook-param-content_name').hide();
				$('#_landingpress_facebook-custom-params').hide();
				$('#_landingpress_heading_facebook-param-value').hide();
				$('#_landingpress_heading_facebook-content_ids').hide();
				$('#_landingpress_heading_facebook-custom-params').hide();
			}
			$(document).on('change', '#_landingpress_facebook-event select', function() {
				lp_fb_event = $(this).find('option:selected').val();
				// console.log( 'lp_fb_event = ' + lp_fb_event );
				if ( lp_fb_event == 'custom' ) {
					$('#_landingpress_heading_facebook-custom-event').show();
					$('#_landingpress_facebook-custom-event').show();
				}
				else {
					$('#_landingpress_heading_facebook-custom-event').hide();
					$('#_landingpress_facebook-custom-event').hide();
				}
				if ( lp_fb_event != '' && lp_fb_event != 'PageView' ) {
					$('#_landingpress_facebook-param-value').show();
					$('#_landingpress_facebook-param-currency').show();
					$('#_landingpress_facebook-param-content_ids').show();
					$('#_landingpress_facebook-param-content_type').show();
					$('#_landingpress_facebook-param-content_name').show();
					$('#_landingpress_facebook-custom-params').show();
					$('#_landingpress_heading_facebook-param-value').show();
					$('#_landingpress_heading_facebook-content_ids').show();
					$('#_landingpress_heading_facebook-custom-params').show();
				}
				else {
					$('#_landingpress_facebook-param-value').hide();
					$('#_landingpress_facebook-param-currency').hide();
					$('#_landingpress_facebook-param-content_ids').hide();
					$('#_landingpress_facebook-param-content_type').hide();
					$('#_landingpress_facebook-param-content_name').hide();
					$('#_landingpress_facebook-custom-params').hide();
					$('#_landingpress_heading_facebook-param-value').hide();
					$('#_landingpress_heading_facebook-content_ids').hide();
					$('#_landingpress_heading_facebook-custom-params').hide();
				}
			});
		}
		if ( $('#_landingpress_tiktok-event').length ) {
			var lp_tt_event = $('#_landingpress_tiktok-event select').val();
			var lp_tt_event_param = [ "ViewContent", "AddToCart", "InitiateCheckout", "PlaceAnOrder", "CompletePayment" ];
			// console.log( 'lp_tt_event = ' + lp_tt_event );
			// console.log( $.inArray( lp_tt_event, lp_tt_event_param ) );
			if ( lp_tt_event != '' && lp_tt_event != 'PageView' && $.inArray( lp_tt_event, lp_tt_event_param ) !== -1 ) {
				$('#_landingpress_tiktok-param-value').show();
				$('#_landingpress_tiktok-param-currency').show();
				$('#_landingpress_tiktok-param-price').show();
				$('#_landingpress_tiktok-param-quantity').show();
				$('#_landingpress_tiktok-param-content_id').show();
				$('#_landingpress_tiktok-param-content_type').show();
				$('#_landingpress_tiktok-param-content_name').show();
				$('#_landingpress_tiktok-custom-params').show();
				$('#_landingpress_heading_tiktok-parameter').show();
				$('#_landingpress_heading_tiktok-custom-params').show();
			}
			else {
				$('#_landingpress_tiktok-param-value').hide();
				$('#_landingpress_tiktok-param-currency').hide();
				$('#_landingpress_tiktok-param-price').hide();
				$('#_landingpress_tiktok-param-quantity').hide();
				$('#_landingpress_tiktok-param-content_id').hide();
				$('#_landingpress_tiktok-param-content_type').hide();
				$('#_landingpress_tiktok-param-content_name').hide();
				$('#_landingpress_tiktok-custom-params').hide();
				$('#_landingpress_heading_tiktok-parameter').hide();
				$('#_landingpress_heading_tiktok-custom-params').hide();
			}
			$(document).on('change', '#_landingpress_tiktok-event select', function() {
				lp_tt_event = $(this).find('option:selected').val();
				// console.log( 'lp_tt_event = ' + lp_tt_event );
				// console.log( $.inArray( lp_tt_event, lp_tt_event_param ) );
				if ( lp_tt_event != '' && lp_tt_event != 'PageView' && $.inArray( lp_tt_event, lp_tt_event_param ) !== -1 ) {
					$('#_landingpress_tiktok-param-value').show();
					$('#_landingpress_tiktok-param-currency').show();
					$('#_landingpress_tiktok-param-price').show();
					$('#_landingpress_tiktok-param-quantity').show();
					$('#_landingpress_tiktok-param-content_id').show();
					$('#_landingpress_tiktok-param-content_type').show();
					$('#_landingpress_tiktok-param-content_name').show();
					$('#_landingpress_tiktok-custom-params').show();
					$('#_landingpress_heading_tiktok-parameter').show();
					$('#_landingpress_heading_tiktok-custom-params').show();
				}
				else {
					$('#_landingpress_tiktok-param-value').hide();
					$('#_landingpress_tiktok-param-currency').hide();
					$('#_landingpress_tiktok-param-price').hide();
					$('#_landingpress_tiktok-param-quantity').hide();
					$('#_landingpress_tiktok-param-content_id').hide();
					$('#_landingpress_tiktok-param-content_type').hide();
					$('#_landingpress_tiktok-param-content_name').hide();
					$('#_landingpress_tiktok-custom-params').hide();
					$('#_landingpress_heading_tiktok-parameter').hide();
					$('#_landingpress_heading_tiktok-custom-params').hide();
				}
			});
		}
		if ( $('#_landingpress_page_header_custom').length ) {
			var lp_header_custom = $('#_landingpress_page_header_custom select').val();
			if ( lp_header_custom == 'custom' ) {
				$('#_landingpress_page_header_elementor').show();
			}
			else {
				$('#_landingpress_page_header_elementor').hide();
			}
			$(document).on('change', '#_landingpress_page_header_custom select', function() {
				lp_header_custom = $(this).find('option:selected').val();
				if ( lp_header_custom == 'custom' ) {
					$('#_landingpress_page_header_elementor').show();
				}
				else {
					$('#_landingpress_page_header_elementor').hide();
				}
			});
			var lp_footer_custom = $('#_landingpress_page_footer_custom select').val();
			if ( lp_footer_custom == 'custom' ) {
				$('#_landingpress_page_footer_elementor').show();
			}
			else {
				$('#_landingpress_page_footer_elementor').hide();
			}
			$(document).on('change', '#_landingpress_page_footer_custom select', function() {
				lp_footer_custom = $(this).find('option:selected').val();
				if ( lp_footer_custom == 'custom' ) {
					$('#_landingpress_page_footer_elementor').show();
				}
				else {
					$('#_landingpress_page_footer_elementor').hide();
				}
			});
		}
		if ( $('#_landingpress_redirect_type').length ) {
			var lp_redirect_type = $('#_landingpress_redirect_type select').val();
			if ( lp_redirect_type == 'meta' || lp_redirect_type == 'javascript' ) {
				$('#_landingpress_redirect_delay').show();
				$('#_landingpress_redirect_message').show();
			}
			else {
				$('#_landingpress_redirect_delay').hide();
				$('#_landingpress_redirect_message').hide();
			}
			$(document).on('change', '#_landingpress_redirect_type select', function() {
				lp_redirect_type = $(this).find('option:selected').val();
				if ( lp_redirect_type == 'meta' || lp_redirect_type == 'javascript' ) {
					$('#_landingpress_redirect_delay').show();
					$('#_landingpress_redirect_message').show();
				}
				else {
					$('#_landingpress_redirect_delay').hide();
					$('#_landingpress_redirect_message').hide();
				}
			});
		}
	});
	/*]]>*/
	</script>
	<?php 
}
