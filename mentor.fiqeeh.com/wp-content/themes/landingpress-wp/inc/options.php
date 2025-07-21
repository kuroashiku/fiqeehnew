<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'customize_register', 'landingpress_customize_settings' );
function landingpress_customize_settings( $wp_customize ) {

	$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
	if ( ! in_array( $status, array( 'valid', 'expired' ) ) ) {
		return;
	}
	
	// title_tagline = 20
	// colors = 40
	// header_image = 60
	// background_image = 80
	// static_front_page = 120

	$wp_customize->get_section( 'background_image' )->priority = 25;
	$wp_customize->get_section( 'background_image' )->title = esc_html__( 'Background', 'landingpress-wp' );
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

	$wp_customize->add_panel( 'landingpress', array(
		'title'    => esc_html__( 'LandingPress', 'landingpress-wp' ),
		'priority' => 5
	) );

	$wp_customize->add_section( 'landingpress_pagelayout', array(
		'title'    => esc_html__( 'Page Layout', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 2
	) );

	$wp_customize->add_section( 'landingpress_pagebuilder', array(
		'title'    => esc_html__( 'Page Builder - Elementor', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 2
	) );

	$wp_customize->add_section( 'landingpress_facebook_pixel', array(
		'title'    => esc_html__( 'Facebook Pixel', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 3
	) );

	$wp_customize->add_section( 'landingpress_tiktok_pixel', array(
		'title'    => esc_html__( 'Tiktok Pixel', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 3
	) );

	$wp_customize->add_section( 'landingpress_google_adwords', array(
		'title'    => esc_html__( 'Google Ads (AdWords)', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 3
	) );

	$wp_customize->add_section( 'landingpress_google_analytics', array(
		'title'    => esc_html__( 'Google Analytics', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 3
	) );

	$wp_customize->add_section( 'landingpress_google_tag_manager', array(
		'title'    => esc_html__( 'Google Tag Manager (GTM)', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 3
	) );

	$wp_customize->add_section( 'landingpress_opengraph', array(
		'title'    => esc_html__( 'Facebook Sharing (OpenGraph)', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 4
	) );

	$wp_customize->add_section( 'landingpress_fonts', array(
		'title'    => esc_html__( 'Basic Fonts', 'landingpress-wp' ),
		'description' => 'LandingPress menyediakan 800+ Google Fonts yang diurutkan berdasarkan popularitas.',
		'panel'    => 'landingpress',
		'priority' => 5
	) );

	$wp_customize->get_section( 'colors' )->title = esc_html__( 'Basic Colors', 'landingpress-wp' );
	$wp_customize->get_section( 'colors' )->panel = 'landingpress';
	$wp_customize->get_section( 'colors' )->priority = 10;

	$wp_customize->add_section( 'landingpress_customcss', array(
		'title'    => esc_html__( 'Custom CSS', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 15
	) );

	$wp_customize->add_section( 'landingpress_header_script', array(
		'title'    => esc_html__( 'Header Script', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 20
	) );

	$wp_customize->get_section( 'header_image' )->panel = 'landingpress';
	$wp_customize->get_section( 'header_image' )->priority = 25;
	$wp_customize->remove_control( 'header_textcolor' );
	$wp_customize->remove_control( 'display_header_text' );
	$wp_customize->get_control( 'header_image' )->section = 'landingpress_header';
	$wp_customize->get_control( 'header_image' )->priority = 5;

	$wp_customize->add_section( 'landingpress_header', array(
		'title'    => esc_html__( 'Header', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 30
	) );

	$wp_customize->add_section( 'landingpress_header_menu', array(
		'title'    => esc_html__( 'Header Menu', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 35
	) );

	$wp_customize->add_section( 'landingpress_breadcrumb', array(
		'title'    => esc_html__( 'Breadcrumb', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 40
	) );


	$wp_customize->add_section( 'landingpress_template_home', array(
		'title'    => esc_html__( 'Home / Front Page', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 100
	) );

	$wp_customize->add_section( 'landingpress_template_archive', array(
		'title'    => esc_html__( 'Blog / Archive Page', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 105
	) );

	$wp_customize->add_section( 'landingpress_template_post', array(
		'title'    => esc_html__( 'Post Type - Post', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 110
	) );

	$wp_customize->add_section( 'landingpress_template_page', array(
		'title'    => esc_html__( 'Post Type - Page', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 115
	) );

	$wp_customize->add_section( 'landingpress_template_attachment', array(
		'title'    => esc_html__( 'Post Type - Attachment', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 120
	) );

	$wp_customize->add_section( 'landingpress_template_comments', array(
		'title'    => esc_html__( 'Comments', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 125
	) );

	$wp_customize->add_section( 'landingpress_template_sidebar', array(
		'title'    => esc_html__( 'Sidebar', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 130
	) );

	$wp_customize->add_section( 'landingpress_footer_widgets', array(
		'title'    => esc_html__( 'Footer Widgets', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 200
	) );

	$wp_customize->add_section( 'landingpress_footer', array(
		'title'    => esc_html__( 'Footer', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 205
	) );

	$wp_customize->add_section( 'landingpress_footer_script', array(
		'title'    => esc_html__( 'Footer Script', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 210
	) );

	$wp_customize->add_section( 'landingpress_backtotop', array(
		'title'    => esc_html__( 'Back To Top Icon', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 220
	) );

	$wp_customize->add_section( 'landingpress_optimization', array(
		'title'    => esc_html__( 'Optimization', 'landingpress-wp' ),
		'panel'    => 'landingpress',
		'priority' => 300,
	) );

}

add_action( 'customize_register', 'landingpress_customize_settings_exportimport', 99 );
function landingpress_customize_settings_exportimport( $wp_customize ) {
	if ( function_exists('landingpress_exportimport_register') ) {
		$wp_customize->get_section( 'landingpress_exportimport_section' )->panel = 'landingpress';
	}
}

add_filter( 'landingpress_customize_controls', 'landingpress_customize_controls' );
function landingpress_customize_controls( $controls ) {

	$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
	if ( ! in_array( $status, array( 'valid', 'expired' ) ) ) {
		return $controls;
	}
	
	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_page_layout',
		'label'    => esc_html__( 'Page Layout', 'landingpress-wp' ),
		'description' => 'Layout tipe Boxed sering dipakai di website tipe personal, sedangkan tipe Full Width sering dipakai di website tipe korporat.',
		'section'  => 'landingpress_pagelayout',
	);

	$controls[] = array(
		'type'     => 'radio-buttonset',
		'setting'  => 'landingpress_page_layout',
		'label'    => esc_html__( 'Page Layout', 'landingpress-wp' ),
		'section'  => 'landingpress_pagelayout',
		'default'  => 'boxed',
		'choices'  => array(
			'boxed' => esc_html__( 'Boxed', 'landingpress-wp' ),
			'fullwidth' => esc_html__( 'Full Width', 'landingpress-wp' ),
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_page_width',
		'label'    => esc_html__( 'Page Width', 'landingpress-wp' ),
		'description' => 'Lebar halaman standard adalah 960px. Anda bisa merubahnya menjadi lebih kecil/besar (min 500px, maks 1200px).',
		'section'  => 'landingpress_pagelayout',
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'landingpress_page_width',
		'label'    => esc_html__( 'Page Width', 'landingpress-wp' ),
		'section'  => 'landingpress_pagelayout',
		'choices'  => array(
			'min' => 500,
			'max' => 1200,
			'step' => 10,
		),
	);

	// $controls[] = array(
	// 	'type'     => 'heading',
	// 	'setting'  => 'landingpress_heading_pagebuilder_elementor',
	// 	'label'    => esc_html__( 'Elementor LandingPress', 'landingpress-wp' ),
	// 	'description' => 'Anda bisa menggunakan opsi ini untuk mematikan Elementor LandingPress, misalnya ketika:<br/> 1. Anda tidak membutuhkan Elementor.<br/> 2. Anda ingin bisa menggunakan Elementor versi asli, bukan versi LandingPress.',
	// 	'section'  => 'landingpress_pagebuilder',
	// );

	// $controls[] = array(
	// 	'type'     => 'checkbox',
	// 	'setting'  => 'landingpress_pagebuilder_elementor_disable',
	// 	'label'    => esc_html__( 'DISABLE Elementor LandingPress', 'landingpress-wp' ),
	// 	'section'  => 'landingpress_pagebuilder',
	// );

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_facebook_pixel_id',
		'label'    => esc_html__( 'Facebook Pixel ID', 'landingpress-wp' ),
		'description' => 'Silahkan masukkan Facebook Pixel ID yang utama untuk semua halaman di sini. Harap memasukkan Pixel ID saja (berupa angka), bukan semua source code pixel.',
		'section'  => 'landingpress_facebook_pixel',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_facebook_pixel_id',
		'label'    => esc_html__( 'Facebook Pixel ID', 'landingpress-wp' ),
		'section'  => 'landingpress_facebook_pixel',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_facebook_pixel_noscript',
		'label'    => esc_html__( 'include Facebook Pixel <noscript> code', 'landingpress-wp' ),
		'section'  => 'landingpress_facebook_pixel',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_facebook_pixel_ids',
		'label'    => esc_html__( 'Multiple Facebook Pixel', 'landingpress-wp' ),
		'description' => 'Anda bisa menggunakan opsi ini jika ingin menggunakan Facebook Pixel lebih dari satu di semua halaman.',
		'section'  => 'landingpress_facebook_pixel',
	);

	for ($i=1; $i <= 5 ; $i++) { 
		$controls[] = array(
			'type'     => 'text',
			'setting'  => 'landingpress_facebook_pixel_id_'.$i,
			'label'    => esc_html__( 'Multiple Facebook Pixel ID #'.$i, 'landingpress-wp' ),
			'section'  => 'landingpress_facebook_pixel',
		);
	}

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_tiktok_pixel_id',
		'label'    => esc_html__( 'Tiktok Pixel ID', 'landingpress-wp' ),
		'description' => 'Silahkan masukkan Tiktok Pixel ID yang utama untuk semua halaman di sini. Harap memasukkan Pixel ID saja, bukan semua source code pixel.',
		'section'  => 'landingpress_tiktok_pixel',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_tiktok_pixel_id',
		'label'    => esc_html__( 'Tiktok Pixel ID', 'landingpress-wp' ),
		'section'  => 'landingpress_tiktok_pixel',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_tiktok_pixel_ids',
		'label'    => esc_html__( 'Multiple Tiktok Pixel', 'landingpress-wp' ),
		'description' => 'Anda bisa menggunakan opsi ini jika ingin menggunakan Tiktok Pixel lebih dari satu di semua halaman.',
		'section'  => 'landingpress_tiktok_pixel',
	);

	for ($i=1; $i <= 5 ; $i++) { 
		$controls[] = array(
			'type'     => 'text',
			'setting'  => 'landingpress_tiktok_pixel_id_'.$i,
			'label'    => esc_html__( 'Multiple Tiktok Pixel ID #'.$i, 'landingpress-wp' ),
			'section'  => 'landingpress_tiktok_pixel',
		);
	}

	$controls[] = array(
		'type'     => 'warning',
		'setting'  => 'landingpress_heading_adwords_warning',
		'label'    => esc_html__( 'Saat LandingPress versi ini dirilis, ada dua versi dashboard Google Ads (AdWords), versi baru (beta) dan versi lama. LandingPress support kedua versi tersebut. Silahkan disesuaikan.', 'landingpress-wp' ),
		'description' => '',
		'section'  => 'landingpress_google_adwords',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_adwords_global_site_tag',
		'label'    => esc_html__( 'Google Ads (AdWords) Global Site Tag (BARU)', 'landingpress-wp' ),
		'description' => 'Jika Anda ingin menggunakan Google Ads (AdWords) versi baru (beta), silahkan masukkan Google Ads (AdWords) Global Site Tag ID di bawah ini.',
		'section'  => 'landingpress_google_adwords',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_adwords_global_site_tag_id',
		'label'    => esc_html__( 'Google Ads (AdWords) Global Site Tag ID', 'landingpress-wp' ),
		'section'  => 'landingpress_google_adwords',
		'input_attrs' => array(
			'placeholder' => 'AW-XXXXXXXX',
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_adwords_global_site_tag_ids',
		'label'    => esc_html__( 'Multiple Google Ads (AdWords) Global Site Tag (BARU)', 'landingpress-wp' ),
		'description' => 'Anda bisa menggunakan opsi ini jika ingin menggunakan Global Site Tag lebih dari satu di semua halaman.',
		'section'  => 'landingpress_google_adwords',
	);

	for ($i=1; $i <= 5 ; $i++) { 
		$controls[] = array(
			'type'     => 'text',
			'setting'  => 'landingpress_adwords_global_site_tag_id_'.$i,
			'label'    => esc_html__( 'Multiple Google Ads (AdWords) Global Site Tag ID #'.$i, 'landingpress-wp' ),
			'section'  => 'landingpress_google_adwords',
			'input_attrs' => array(
				'placeholder' => 'AW-XXXXXXXX',
			),
		);
	}

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_adwords_remarketing_id',
		'label'    => esc_html__( 'Google Ads (AdWords) Remarketing Tag (LAMA)', 'landingpress-wp' ),
		'description' => 'Jika Anda ingin menggunakan kode Google Ads (AdWords) Remarketing Tag di Google Ads (AdWords) versi lama, silahkan masukkan <strong>google_conversion_id</strong> di bawah ini.',
		'section'  => 'landingpress_google_adwords',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_adwords_remarketing_id',
		'label'    => esc_html__( 'google_conversion_id', 'landingpress-wp' ),
		'section'  => 'landingpress_google_adwords',
		'input_attrs' => array(
			'placeholder' => 'isi parameter google_conversion_id',
		)
	);

	$controls[] = array(
		'type'     => 'warning',
		'setting'  => 'landingpress_warning_google_tag_manager_id',
		'label'    => '',
		'description' => 'Penting untuk diingat, Google Tag Manager (GTM) ini tidak cocok untuk semua orang, khususnya jika Anda termasuk orang yang "males" ngoprek teknis GTM.<br/><br/> Jika hanya ingin menggunakan GTM untuk Facebook Pixel, tidak perlu harus pakai GTM, fitur Facebook Pixel di LandingPress sudah komplit banget.<br/><br/> Silahkan gunakan GTM jika Anda sudah pernah menggunakan GTM dan/atau Anda siap ngoprek teknis GTM.',
		'section'  => 'landingpress_google_tag_manager',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_google_tag_manager_id',
		'label'    => esc_html__( 'Google Tag Manager ID', 'landingpress-wp' ),
		'section'  => 'landingpress_google_tag_manager',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_google_tag_manager_id',
		'label'    => esc_html__( 'Google Tag Manager ID', 'landingpress-wp' ),
		'section'  => 'landingpress_google_tag_manager',
		'input_attrs' => array(
			'placeholder' => 'GTM-XXXXXX',
		)
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_google_tag_manager_noscript',
		'label'    => esc_html__( 'include GTM <noscript> code (optional)', 'landingpress-wp' ),
		'section'  => 'landingpress_google_tag_manager',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_google_analytics_id',
		'label'    => esc_html__( 'Google Analytics ID', 'landingpress-wp' ),
		'description' => 'Jika Anda ingin menggunakan Google Analytics, silahkan masukkan Google Analytics ID di bawah ini. Contohnya:<br/>"G-XXXXXXXX" atau "UA-XXXXXXXX" (tanpa tanda petik).',
		'section'  => 'landingpress_google_analytics',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_google_analytics_id',
		'label'    => esc_html__( 'Google Analytics Tracking ID', 'landingpress-wp' ),
		'section'  => 'landingpress_google_analytics',
		'input_attrs' => array(
			'placeholder' => 'G-XXXXXXX / UA-XXXXXXX',
		)
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_google_analytics_tag',
		'label'    => esc_html__( 'Analytics Tracking Code', 'landingpress-wp' ),
		'section'  => 'landingpress_google_analytics',
		'default'  => 'new',
		'choices'  => array(
			'new' => esc_html__( 'New (gtag.js)', 'landingpress-wp' ),
			'old' => esc_html__( 'Previous (analytics.js)', 'landingpress-wp' ),
		),
		'active_callback' => 'landingpress_callback_google_analytics_ua',
	);

	$opengraph_plugin = '';
	if ( defined('WPSEO_VERSION') ) {
		$opengraph_plugin = 'Yoast WordPress SEO';
	}
	elseif ( defined('RANK_MATH_VERSION') ) {
		$opengraph_plugin = 'Rank Math SEO';
	}
	elseif ( class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		$opengraph_plugin = 'All In One SEO Pack';
	}

	if (!empty($opengraph_plugin)) {

		$controls[] = array(
			'type'     => 'warning',
			'setting'  => 'landingpress_warning_opengraph',
			'label'    => '',
			'description' => sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi Facebook Sharing (Open Graph) di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), $opengraph_plugin ).'<br/><br/>'.sprintf( esc_html__( 'Silahkan gunakan opsi Facebook Sharing (Open Graph) dari plugin %s.', 'landingpress-wp'), $opengraph_plugin ),
			'section'  => 'landingpress_opengraph',
		);

	}
	else {
		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'landingpress_opengraph_disable',
			'label'    => esc_html__( 'Disable OpenGraph output from LandingPress', 'landingpress-wp' ),
			'section'  => 'landingpress_opengraph',
			'default'  => '',
		);

		$controls[] = array(
			'type'     => 'image',
			'setting'  => 'landingpress_opengraph_image',
			'label'    => esc_html__( 'Default OpenGraph Image', 'landingpress-wp' ),
			'section'  => 'landingpress_opengraph',
			'default'  => '',
		);
	}

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_font_body',
		'label'    => esc_html__( 'Body Font', 'landingpress-wp' ),
		'description' => 'Body Font diaplikasikan untuk semua teks di semua halaman.',
		'section'  => 'landingpress_fonts',
	);

	$controls[] = array(
		'type'     => 'font',
		'setting'  => 'landingpress_font_body',
		'label'    => sprintf( 
						esc_html__( '%s Font Family', 'landingpress-wp' ), 
						esc_html__( 'Body', 'landingpress-wp' )
					),
		'section'  => 'landingpress_fonts',
		'selector' => 'body,.site-description',
	);

	$controls[] = array(
		'setting'  => 'landingpress_body_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Body', 'landingpress-wp' )
					),
		'section'  => 'landingpress_fonts',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => 'body { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_font_heading',
		'label'    => esc_html__( 'Heading Font', 'landingpress-wp' ),
		'description' => 'Heading Font diaplikasikan untuk semua heading (H1-H6) di semua halaman.',
		'section'  => 'landingpress_fonts',
	);

	$controls[] = array(
		'type'     => 'font',
		'setting'  => 'landingpress_font_heading',
		'label'    => sprintf( 
						esc_html__( '%s Font Family', 'landingpress-wp' ), 
						esc_html__( 'Heading', 'landingpress-wp' )
					),
		'section'  => 'landingpress_fonts',
		'selector' => 'h1,h2,h3,h4,h5,h6,.site-title',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_text_color',
		'label'    => esc_html__( 'Text Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'body, button, input, select, textarea { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_heading_color',
		'label'    => esc_html__( 'Heading Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'h1,h2,h3,h4,h5 { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_link_color',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'colors',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_link_color',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'a, a:visited { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_link_color_hover',
		'label'    => esc_html__( 'Link Color (Hover)', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'a:hover { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_form_color',
		'label'    => esc_html__( 'Basic Form Color', 'landingpress-wp' ),
		'section'  => 'colors',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_label_color',
		'label'    => esc_html__( 'Form Label - Text Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'label, .comment-form label { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_input_background',
		'label'    => esc_html__( 'Form Input/Textarea - Background Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], textarea { background-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_input_color',
		'label'    => esc_html__( 'Form Input/Textarea - Text Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], textarea { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_input_border',
		'label'    => esc_html__( 'Form Input/Textarea - Border Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], textarea { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_button_background',
		'label'    => esc_html__( 'Form Button - Background Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'button, input[type=button], input[type=reset], input[type=submit] { background-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_button_color',
		'label'    => esc_html__( 'Form Button - Text Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'button, input[type=button], input[type=reset], input[type=submit] { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_button_border',
		'label'    => esc_html__( 'Form Button - Border Color', 'landingpress-wp' ),
		'section'  => 'colors',
		'default'  => '',
		'style'    => 'button, input[type=button], input[type=reset], input[type=submit] { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_script_header',
		'label'    => esc_html__( 'Custom Header Script', 'landingpress-wp' ),
		'description' => 'Anda bisa menggunakan opsi ini untuk memasukkan custom script di bagian <code>&lt;head&gt;</code> di semua halaman. Cocok untuk script yang masih belum di-support penuh oleh LandingPress.',
		'section'  => 'landingpress_header_script',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_script_header',
		'label'    => esc_html__( 'Custom Header Script', 'landingpress-wp' ),
		'section'  => 'landingpress_header_script',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_script_header_after',
		'label'    => '',
		'description' => 'Perlu dicatat bahwa Customizer WordPress agak sensitif dengan custom script untuk alasan keamanan website. Jika custom script tersebut tidak berfungsi dengan baik saat dimasukkan di opsi ini, maka silahkan gunakan cara lain untuk memasukkan custom script tersebut.',
		'section'  => 'landingpress_header_script',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_hide',
		'label'    => esc_html__( 'Hide Header', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menyembunyikan header di semua halaman.',
		'section'  => 'landingpress_header',
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_header_hide',
		'label'    => esc_html__( 'Hide Header', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'default'  => '',
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_header_hide_mobile',
		'label'    => esc_html__( 'Hide Header On Mobile', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'description' => 'Gunakan opsi ini untuk menyembunyikan header di mobile (layar kecil).',
		'default'  => '',
		'priority' => 3,
		'style'    => array( 
			'on'   => ' @media (max-width: 500px) { .site-header { display: none !important; } } ',
			'off'  => '',
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_background',
		'label'    => esc_html__( 'Header Background Color', 'landingpress-wp' ),
		'description' => 'Header Background akan terlihat ketika Header Image masih loading atau tidak tersedia.',
		'section'  => 'landingpress_header',
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_header_background',
		'label'    => esc_html__( 'Header Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'default'  => '',
		'style'    => '.site-branding { background-color: [value] }',
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_header_image',
		'label'    => esc_html__( 'Header Image', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_header_background_overlay',
		'label'    => esc_html__( 'Header Background Image Overlay', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'default'  => '',
		'style'    => '.site-header-overlay { background-color: [value] }',
		'priority' => 6,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_header_placement',
		'label'    => esc_html__( 'Header Image Placement', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'priority' => 7,
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_header_placement',
		'label'    => esc_html__( 'Header Image Placement', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'default'  => 'background',
		'choices'  => array(
			'background' => esc_html__( 'Background Image (Behind header content)', 'landingpress-wp' ),
			'background_nologo' => esc_html__( 'Background Image (Without header content)', 'landingpress-wp' ),
			'image' => esc_html__( 'Image Only (Instead of header content)', 'landingpress-wp' ),
			'image_title_top' => esc_html__( 'Have header content placed before the image', 'landingpress-wp' ),
		),
		'priority' => 7,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_header_content',
		'label'    => esc_html__( 'Header Content', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'landingpress_header_logo',
		'label'    => esc_html__( 'Header Logo', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_header_text_color',
		'label'    => esc_html__( 'Header Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'default'  => '',
		'style'    => '.site-title, .site-title a, .site-title a:visited, .site-description { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'radio-buttonset',
		'setting'  => 'landingpress_header_alignment',
		'label'    => esc_html__( 'Header Alignment', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'choices'  => array(
			'left' => esc_html__( 'Left', 'landingpress-wp' ),
			'center' => esc_html__( 'Center', 'landingpress-wp' ),
			'right' => esc_html__( 'Right', 'landingpress-wp' ),
		),
		'style'  => array(
			'left' => '.site-branding{text-align:left;}',
			'center' => '.site-branding{text-align:center;}',
			'right' => '.site-branding{text-align:right;}',
		),
	);

	$controls[] = array(
		'setting'  => 'landingpress_site_title_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Site Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_header',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.site-title { font-size: [value]px }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_site_desc_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Site Description', 'landingpress-wp' )
					),
		'section'  => 'landingpress_header',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.site-description { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_header_padding',
		'label'    => esc_html__( 'Header Padding', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'landingpress_header_paddingtop',
		'label'    => esc_html__( 'Header Top Padding', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'choices'  => array(
			'min' => 0,
			'max' => 150,
			'step' => 5,
		),
		'style'    => '.site-branding { padding-top: [value]px }',
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'landingpress_header_paddingbottom',
		'label'    => esc_html__( 'Header Bottom Padding', 'landingpress-wp' ),
		'section'  => 'landingpress_header',
		'choices'  => array(
			'min' => 0,
			'max' => 150,
			'step' => 5,
		),
		'style'    => '.site-branding { padding-bottom: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_hide',
		'label'    => esc_html__( 'Hide Header Menu', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menyembunyikan header menu di semua halaman.',
		'section'  => 'landingpress_header_menu',
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_menu_hide',
		'label'    => esc_html__( 'Hide Header Menu', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'priority' => 3,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_placement',
		'label'    => esc_html__( 'Menu Placement', 'landingpress-wp' ),
		'description' => 'Header menu bisa ditampilkan setelah header (default) atau sebelum header, sesuai selera.',
		'section'  => 'landingpress_header_menu',
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_menu_placement',
		'label'    => esc_html__( 'Menu Placement', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => 'after',
		'choices'  => array(
			'after' => esc_html__( 'After Header', 'landingpress-wp' ),
			'before' => esc_html__( 'Before Header', 'landingpress-wp' ),
		),
		'priority' => 4,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_sticky',
		'label'    => esc_html__( 'Sticky Menu', 'landingpress-wp' ),
		'description' => 'Fitur sticky menu memungkinkan header menu tampil di atas saat visitor scroll halaman ke bawah.',
		'section'  => 'landingpress_header_menu',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_menu_sticky',
		'label'    => esc_html__( 'Sticky Menu', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '1',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_logo',
		'label'    => esc_html__( 'Menu Logo', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'landingpress_menu_logo',
		'label'    => esc_html__( 'Menu Logo', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_menu_logo_hide_desktop',
		'label'    => esc_html__( 'Hide Menu Logo on Desktop', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini jika ingin menu logo tampil di mobile dan tablet.',
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'priority' => 5,
		'style'    => array( 
			'on'   => ' @media (min-width: 769px) { a.menu-logo { display: none !important; } } ',
			'off'  => '',
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_list',
		'label'    => esc_html__( 'Menu List', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'radio-buttonset',
		'setting'  => 'landingpress_menu_alignment',
		'label'    => esc_html__( 'Menu Alignment', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => 'left',
		'choices'  => array(
			'left' => esc_html__( 'Left', 'landingpress-wp' ),
			'center' => esc_html__( 'Center', 'landingpress-wp' ),
			'right' => esc_html__( 'Right', 'landingpress-wp' ),
		),
		'style'  => array(
			'left' => '',
			'center' => '.main-navigation {text-align:center; } .main-navigation ul.menu{ display:inline-block;vertical-align:top;}',
			'right' => '.main-navigation {text-align:right; } .main-navigation ul.menu{ display:inline-block;vertical-align:top;}',
		),
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_extras',
		'label'    => esc_html__( 'Menu Extras', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_menu_search',
		'label'    => esc_html__( 'Show search form', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '1',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_padding',
		'label'    => esc_html__( 'Menu Padding', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
	);

	$controls[] = array(
		'type'     => 'slider',
		'setting'  => 'landingpress_menu_padding',
		'label'    => esc_html__( 'Menu Top & Bottom Padding', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'choices'  => array(
			'min' => 0,
			'max' => 100,
			'step' => 10,
		),
		'style'    => ' @media (min-width: 769px) { .main-navigation { padding-top:[value]px; padding-bottom:[value]px; } .is-sticky .main-navigation { padding-top:0; padding-bottom:0; } } ',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_menu_color',
		'label'    => esc_html__( 'Menu Colors & Fonts', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_menu_background',
		'label'    => esc_html__( 'Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'style'    => '.main-navigation, .main-navigation ul ul { background-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_menu_link_color',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'style'    => '.main-navigation li a, .main-navigation li a:visited, .menu-toggle, a.menu-minicart { color: [value] } .menu-bar { background : [value] } ',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_menu_link_color_hover',
		'label'    => esc_html__( 'Link Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'style'    => '.main-navigation li a:hover, a.menu-minicart:hover { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_menu_link_font_size',
		'label'    => esc_html__( 'Font Size', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.main-navigation li a { font-size: [value]px }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_menu_link_font_weight',
		'label'    => esc_html__( 'Font Weight', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'landingpress-wp' ),
			'bold' => esc_html__( 'Bold', 'landingpress-wp' ),
		),
		'style'  => array(
			'normal' => '.main-navigation li a { font-weight: normal; }',
			'bold' => '.main-navigation li a { font-weight: bold; }',
		),
	);

	$controls[] = array(
		'setting'  => 'landingpress_menu_link_font_transform',
		'label'    => esc_html__( 'Text Transform', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'landingpress-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'landingpress-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'landingpress-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'landingpress-wp' ),
		),
		'style'  => array(
			'none' => '.main-navigation li a { text-transform: none; }',
			'uppercase' => '.main-navigation li a { text-transform: uppercase; }',
			'lowercase' => '.main-navigation li a { text-transform: lowercase; }',
			'capitalize' => '.main-navigation li a { text-transform: capitalize; }',
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_mobile_menu_color',
		'label'    => esc_html__( 'Mobile Menu Colors', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_menu_background_mobile',
		'label'    => esc_html__( 'Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'style'    => ' @media (max-width: 768px) { .main-navigation .header-menu-container { background-color: [value] } }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_menu_link_color_mobile',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'style'    => ' @media (max-width: 768px) { .main-navigation li a, .main-navigation li a:visited { color: [value] !important; } }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_menu_link_color_hover_mobile',
		'label'    => esc_html__( 'Link Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '',
		'style'    => ' @media (max-width: 768px) { .main-navigation li a:hover, a.menu-minicart:hover { color: [value] !important; } }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_breadcrumb_hide',
		'label'    => esc_html__( 'Hide Breadcrumb', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menyembunyikan breadcrumb di semua halaman.',
		'section'  => 'landingpress_breadcrumb',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_breadcrumb_hide',
		'label'    => esc_html__( 'Hide Breadcrumb', 'landingpress-wp' ),
		'section'  => 'landingpress_breadcrumb',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_breadcrumb_text',
		'label'    => esc_html__( 'Breadcrumb Text', 'landingpress-wp' ),
		'section'  => 'landingpress_breadcrumb',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_breadcrumb_color',
		'label'    => esc_html__( 'Breadcrumb Color', 'landingpress-wp' ),
		'section'  => 'landingpress_breadcrumb',
		'default'  => '',
		'style'    => '.breadcrumb { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_breadcrumb_link_color',
		'label'    => esc_html__( 'Breadcrumb Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_breadcrumb',
		'default'  => '',
		'style'    => '.breadcrumb a, .breadcrumb a:visited { color: [value] }',
	);


	$controls[] = array(
		'setting'  => 'landingpress_breadcrumb_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Breadcrumb', 'landingpress-wp' )
					),
		'section'  => 'landingpress_breadcrumb',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.breadcrumb { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_footer_widgets_hide',
		'label'    => esc_html__( 'Hide Footer Widgets', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menyembunyikan footer widgets di semua halaman.',
		'section'  => 'landingpress_footer_widgets',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_footer_widgets_hide',
		'label'    => esc_html__( 'Hide Footer Widgets', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_footer_widgets_color',
		'label'    => esc_html__( 'Footer Widgets Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_widgets_background',
		'label'    => esc_html__( 'Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
		'style'    => '.site-footer-widgets { background-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_widgets_title_color',
		'label'    => esc_html__( 'Title Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
		'style'    => '.footer-widget.widget .widget-title { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_widgets_color',
		'label'    => esc_html__( 'Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
		'style'    => '.footer-widget.widget { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_widgets_link_color',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
		'style'    => '.footer-widget.widget a, .footer-widget.widget a:visited { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_widgets_link_color_hover',
		'label'    => esc_html__( 'Link Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
		'style'    => '.footer-widget.widget a:hover { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_widgets_line_color',
		'label'    => esc_html__( 'Line Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_widgets',
		'default'  => '',
		'style'    => '.footer-widget.widget .widget-title, .footer-widget.widget li, .footer-widget.widget ul ul { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_footer_hide',
		'label'    => esc_html__( 'Hide Footer', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menyembunyikan footer di semua halaman.',
		'section'  => 'landingpress_footer',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_footer_hide',
		'label'    => esc_html__( 'Hide Footer', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_footer_text',
		'label'    => esc_html__( 'Custom Footer Text', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk merubah teks di footer. Anda bisa menggunakan markup HTML standard seperti <code>&lt;a&gt;</code> (link), <code>&lt;strong&gt;</code> (cetak tebal), <code>&lt;em&gt;</code> (cetak miring), dll.',
		'section'  => 'landingpress_footer',
	);

	$controls[] = array(
		'type'     => 'textarea-html',
		'setting'  => 'landingpress_footer_text',
		'label'    => esc_html__( 'Custom Footer Text', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_footer_color',
		'label'    => esc_html__( 'Footer Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_background',
		'label'    => esc_html__( 'Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
		'default'  => '',
		'style'    => '.site-footer .container { background-color: [value] } .site-footer-widgets { border-radius: 0; } .site-inner { border-bottom-right-radius: 0; border-bottom-left-radius: 0; }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_text_color',
		'label'    => esc_html__( 'Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
		'default'  => '',
		'style'    => '.site-footer { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_link_color',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
		'default'  => '',
		'style'    => '.site-footer a, .site-footer a:visited { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_footer_link_color_hover',
		'label'    => esc_html__( 'Link Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_footer',
		'default'  => '',
		'style'    => '.site-footer a:hover { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_footer_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Footer', 'landingpress-wp' )
					),
		'section'  => 'landingpress_footer',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.site-footer, .site-footer .container { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_script_footer',
		'label'    => esc_html__( 'Custom Footer Script', 'landingpress-wp' ),
		'description' => 'Anda bisa menggunakan opsi ini untuk memasukkan custom script di bagian bawah sebelum<code>&lt;/body&gt;</code> di semua halaman. Cocok untuk script yang masih belum di-support penuh oleh LandingPress.',
		'section'  => 'landingpress_footer_script',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_script_footer',
		'label'    => esc_html__( 'Custom Footer Script', 'landingpress-wp' ),
		'section'  => 'landingpress_footer_script',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_script_footer_after',
		'label'    => '',
		'description' => 'Perlu dicatat bahwa Customizer WordPress agak sensitif dengan custom script untuk alasan keamanan website. Jika custom script tersebut tidak berfungsi dengan baik saat dimasukkan di opsi ini, maka silahkan gunakan cara lain untuk memasukkan custom script tersebut.',
		'section'  => 'landingpress_footer_script',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_backtotop_hide',
		'label'    => esc_html__( 'Hide Back To Top Icon', 'landingpress-wp' ),
		'section'  => 'landingpress_backtotop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_backtotop_bg',
		'label'    => esc_html__( 'Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_backtotop',
		'default'  => '',
		'style'    => '#back-to-top { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_backtotop_color',
		'label'    => esc_html__( 'Icon Color', 'landingpress-wp' ),
		'section'  => 'landingpress_backtotop',
		'default'  => '',
		'style'    => '#back-to-top { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_archive_layout',
		'label'    => esc_html__( 'Blog / Archive Layout', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => 'content-image',
		'choices'  => array(
			'content-image' => esc_html__( 'Full Content + Featured Image', 'landingpress-wp' ),
			'content' => esc_html__( 'Full Content', 'landingpress-wp' ),
			'excerpt-image' => esc_html__( 'Excerpt + Image', 'landingpress-wp' ),
			'excerpt' => esc_html__( 'Excerpt (No Image)', 'landingpress-wp' ),
			'thumb-left' => esc_html__( 'Excerpt + Left Thumbnail', 'landingpress-wp' ),
			'thumb-right' => esc_html__( 'Excerpt + Right Thumbnail', 'landingpress-wp' ),
			'thumb-medium-left' => esc_html__( 'Excerpt + Left Medium Thumbnail', 'landingpress-wp' ),
			'thumb-medium-right' => esc_html__( 'Excerpt + Right Medium Thumbnail', 'landingpress-wp' ),
			'gallery-2cols' => esc_html__( 'Excerpt + Image Gallery (2 Columns)', 'landingpress-wp' ),
			'gallery-3cols' => esc_html__( 'Excerpt + Image Gallery (3 Columns)', 'landingpress-wp' ),
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_archive_title',
		'label'    => esc_html__( 'Post Title', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_archive_title_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( 'Post Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.entry-blog .entry-title, .entry-blog .entry-title a, .entry-blog .entry-title a:visited { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_archive_title_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Post Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-blog .entry-title { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_archive_meta',
		'label'    => esc_html__( 'Post Meta', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_archive_meta',
		'label'    => esc_html__( 'Show post meta', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_archive_meta_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( 'Post Meta', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.entry-blog .entry-meta, .entry-blog .entry-meta a, .entry-blog .entry-meta a:visited { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_archive_meta_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Post Meta', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-blog .entry-meta { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_archive_content',
		'label'    => esc_html__( 'Post Content / Summary', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_archive_content_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( 'Post Content', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.entry-blog .entry-content { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_archive_content_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Post Content', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-blog .entry-content { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_morelink',
		'label'    => esc_html__( '"Continue Reading" Link', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_archive_morelink',
		'label'    => esc_html__( 'Show "Continue Reading" link on post summary', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_archive_morelink_text',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Continue reading &rarr;', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_archive',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_archive_morelink_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( '"Continue Reading"', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.entry-blog .more-link { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_archive_morelink_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( '"Continue Reading"', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-blog .more-link { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_pagination',
		'label'    => esc_html__( 'Pagination', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_pagination_background',
		'label'    => esc_html__( 'Pagination Background', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.posts-navigation li span, .posts-navigation li a, .page-links li span, .page-links li a { background-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_pagination_border',
		'label'    => esc_html__( 'Pagination Border', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.posts-navigation li span, .posts-navigation li a, .page-links li span, .page-links li a { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_pagination_text_color',
		'label'    => esc_html__( 'Pagination Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.posts-navigation li span, .page-links li span { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_pagination_link_color',
		'label'    => esc_html__( 'Pagination Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.posts-navigation li a, .page-links li a { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_post_image',
		'label'    => esc_html__( 'Featured Image', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_image',
		'label'    => esc_html__( 'Show featured image', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_post_title',
		'label'    => esc_html__( 'Post Title', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_post_title_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( 'Post Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_post',
		'default'  => '',
		'style'    => '.entry-post .entry-title, .entry-post .entry-title a, .entry-post .entry-title a:visited { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_post_title_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Post Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_post',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-post .entry-title { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_post_meta',
		'label'    => esc_html__( 'Post Meta', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_meta',
		'label'    => esc_html__( 'Show post meta', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_post_meta_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( 'Post Meta', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_archive',
		'default'  => '',
		'style'    => '.entry-post .entry-meta, .entry-post .entry-meta a, .entry-post .entry-meta a:visited { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_post_meta_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Post Meta', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_post',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-post .entry-meta { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_post_share',
		'label'    => esc_html__( 'Social share', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_share_before',
		'label'    => esc_html__( 'Show social share before content', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_share_after',
		'label'    => esc_html__( 'Show social share after content', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_post_share_label_color',
		'label'    => esc_html__( 'Social Share Label Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '',
		'style'    => '.share-label { color: [value]; border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_post_comment',
		'label'    => esc_html__( 'Comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_comments',
		'label'    => esc_html__( 'Show comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_post_related',
		'label'    => esc_html__( 'Related Posts', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_related',
		'label'    => esc_html__( 'Show related posts', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_post_related_image',
		'label'    => esc_html__( 'Show related post images', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '1',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_post_related_separator_color',
		'label'    => esc_html__( 'Related Post Separator Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_post',
		'default'  => '',
		'style'    => '.related-posts li { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_page_title',
		'label'    => esc_html__( 'Page Title', 'landingpress-wp' ),
		'section'  => 'landingpress_template_page',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_page_title_color',
		'label'    => sprintf( 
						esc_html__( '%s Text Color', 'landingpress-wp' ), 
						esc_html__( 'Page Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_page',
		'default'  => '',
		'style'    => '.entry-page .entry-title, .entry-page .entry-title a, .entry-page .entry-title a:visited { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_page_title_font_size',
		'label'    => sprintf( 
						esc_html__( '%s Font Size', 'landingpress-wp' ), 
						esc_html__( 'Page Title', 'landingpress-wp' )
					),
		'section'  => 'landingpress_template_page',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.entry-page .entry-title { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_page_share',
		'label'    => esc_html__( 'Social share', 'landingpress-wp' ),
		'section'  => 'landingpress_template_page',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_page_share_before',
		'label'    => esc_html__( 'Show social share before content', 'landingpress-wp' ),
		'section'  => 'landingpress_template_page',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_page_share_after',
		'label'    => esc_html__( 'Show social share after content', 'landingpress-wp' ),
		'section'  => 'landingpress_template_page',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_page_comment',
		'label'    => esc_html__( 'Comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_page',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_page_comments',
		'label'    => esc_html__( 'Show comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_page',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_attachment_share',
		'label'    => esc_html__( 'Social share', 'landingpress-wp' ),
		'section'  => 'landingpress_template_attachment',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_attachment_share_before',
		'label'    => esc_html__( 'Show social share before content', 'landingpress-wp' ),
		'section'  => 'landingpress_template_attachment',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_attachment_share_after',
		'label'    => esc_html__( 'Show social share after content', 'landingpress-wp' ),
		'section'  => 'landingpress_template_attachment',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_attachment_comment',
		'label'    => esc_html__( 'Comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_attachment',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_attachment_comments',
		'label'    => esc_html__( 'Show comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_attachment',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_comment_wp',
		'label'    => esc_html__( 'WordPress Comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_post_comments_box_border',
		'label'    => esc_html__( 'Comment Box Border Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_comments',
		'default'  => '',
		'style'    => '.comment-body { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_comment_fb',
		'label'    => esc_html__( 'Facebook Comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_comment_fb_show',
		'label'    => esc_html__( 'Show Facebook Comments', 'landingpress-wp' ),
		'section'  => 'landingpress_template_comments',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_fb_app_id',
		'label'    => esc_html__( 'FB App ID for Facebook Comment', 'landingpress-wp' ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_comment_fb_app_id',
		'label'    => '',
		'description' => 'Penting: Facebook Comments membutuhkan FB App ID untuk dapat berjalan. Jika Anda tidak memasukkan FB App ID milik Anda sendiri, maka fitur ini akan menggunakan FB App ID milik LandingPress. Pastikan "Disable Development Mode" di FB App ID yang Anda gunakan. <a href="https://developers.facebook.com/docs/apps/register" target="_blank">Baca Selengkapnya</a>',
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_comment_hide_default',
		'label'    => esc_html__( 'Hide default WordPress comments', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini jika hanya ingin menampilkan Facebook Comments saja.',
		'section'  => 'landingpress_template_comments',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_comment_form',
		'label'    => esc_html__( 'WordPress Comment Form', 'landingpress-wp' ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_comment_textarea_reverse',
		'label'    => esc_html__( 'Reverse Comment Textarea To Bottom', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini jika ingin menampilkan isian pesan di komentar setelah isian nama, email, dan website.',
		'section'  => 'landingpress_template_comments',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_comment_url_hide',
		'label'    => esc_html__( 'Hide Comment URL (Website) Field', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini jika ingin menyembunyikan isian URL (website) di form komentar.',
		'section'  => 'landingpress_template_comments',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_name',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Your Name', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_email',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Your Email', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_website',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Your Website', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_comment',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Your Comment', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_notes',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Your email address will not be published.', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_required',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Required fields are marked %s', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_title_reply',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Leave a Reply', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_title_reply_to',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Leave a Reply to %s', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_cancel_reply_link',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Cancel reply', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_comment_form_label_submit',
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'landingpress-wp' ), esc_html__( 'Post Comment', 'landingpress-wp' ) ),
		'section'  => 'landingpress_template_comments',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_sidebar_hide',
		'label'    => esc_html__( 'Hide Sidebar', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menyembunyikan sidebar di semua halaman.',
		'section'  => 'landingpress_template_sidebar',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_sidebar_hide',
		'label'    => esc_html__( 'Hide Sidebar', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_sidebar_position',
		'label'    => esc_html__( 'Sidebar Position', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk merubah posisi sidebar di bagian kanan atau kiri.',
		'section'  => 'landingpress_template_sidebar',
	);

	$controls[] = array(
		'type'     => 'radio-buttonset',
		'setting'  => 'landingpress_sidebar_position',
		'label'    => esc_html__( 'Sidebar Position', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => 'right',
		'choices'  => array(
			'right' => esc_html__( 'Right', 'landingpress-wp' ),
			'left' => esc_html__( 'Left', 'landingpress-wp' ),
		),
		'style'  => array(
			'right' => '',
			'left' => '#primary{float:right;}#secondary{float:left;}',
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_sidebar_width',
		'label'    => esc_html__( 'Sidebar Width', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk merubah lebar sidebar dibanding lebar konten menjadi lebih kecil/besar, sesuai selera.',
		'section'  => 'landingpress_template_sidebar',
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_sidebar_width',
		'label'    => esc_html__( 'Sidebar Width', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => 'default',
		'choices'  => array(
			'default' => esc_html__( 'Default', 'landingpress-wp' ),
			'15' => '15%',
			'20' => '20%',
			'25' => '25%',
			'30' => '30%',
			'35' => '35%',
			'40' => '40%',
			'45' => '45%',
			'50' => '50%',
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_sidebar_widgets_title',
		'label'    => esc_html__( 'Sidebar Widgets Title', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_sidebar_widgets_title_color',
		'label'    => esc_html__( 'Widget Title Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => '',
		'style'    => '.widget .widget-title { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_sidebar_widgets_title_font_size',
		'label'    => esc_html__( 'Widget Title Font Size', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.widget .widget-title { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_sidebar_widgets_text',
		'label'    => esc_html__( 'Sidebar Widgets Text', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_sidebar_widgets_color',
		'label'    => esc_html__( 'Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => '',
		'style'    => '.widget { color: [value] }',
	);

	$controls[] = array(
		'setting'  => 'landingpress_sidebar_widgets_font_size',
		'label'    => esc_html__( 'Widget Title Font Size', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 10,
			'max' => 50,
			'step' => 1,
			'unit' => 'px',
		),
		'style'    => '.widget { font-size: [value]px }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_sidebar_widgets_link_color',
		'label'    => esc_html__( 'Link Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => '',
		'style'    => '.widget a, .widget a:visited { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_sidebar_widgets_link_color_hover',
		'label'    => esc_html__( 'Link Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => '',
		'style'    => '.widget a:hover { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_sidebar_widgets_line_color',
		'label'    => esc_html__( 'Line Color', 'landingpress-wp' ),
		'section'  => 'landingpress_template_sidebar',
		'default'  => '',
		'style'    => '.widget .widget-title, .widget li, .widget ul ul { border-color: [value] }',
	);

	$controls[] = array(
		'type'     => 'warning',
		'setting'  => 'landingpress_heading_optimization',
		'label'    => esc_html__( 'Fitur di bawah ini ada yang kemungkinan tidak berjalan baik dengan beberapa plugin tertentu. Jika ada masalah, silahkan coba hapus centang di semua opsi di bawah ini', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_jquery',
		'label'    => esc_html__( 'Force jquery from head to bottom', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_defer',
		'label'    => esc_html__( 'Enable defer parsing of JavaScript', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wpversion',
		'label'    => esc_html__( 'Enable WP Core Version Header', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wprest',
		'label'    => esc_html__( 'Enable WP Core Rest API Link Header', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wpoembed',
		'label'    => esc_html__( 'Enable WP Core Oembed Discovery Link Header', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_xmlrpc',
		'label'    => esc_html__( 'Enable WP Core XMLRPC Header', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wlw',
		'label'    => esc_html__( 'Enable WP Core Windows Live Writer Header', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wpembed',
		'label'    => esc_html__( 'Enable WP Core Embed Script', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wpemoji',
		'label'    => esc_html__( 'Enable WP Core Emoji', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_wpresponsive',
		'label'    => esc_html__( 'Enable WP Core Responsive Images', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_optimization_lazyload_disable',
		'label'    => esc_html__( 'Disable WP Core Lazy Loading', 'landingpress-wp' ),
		'section'  => 'landingpress_optimization',
		'default'  => '',
	);

	// $controls[] = array(
	// 	'type'     => 'checkbox',
	// 	'setting'  => 'landingpress_optimization_version',
	// 	'label'    => esc_html__( 'Remove query strings from JavaScript & CSS', 'landingpress' ),
	// 	'section'  => 'landingpress_optimization',
	// 	'default'  => '',
	// );

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_site_content_before',
		'label'    => esc_html__( 'Ad - Before site content', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_sitewide',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_site_content_after',
		'label'    => esc_html__( 'Ad - After site content', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_sitewide',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_archive_row1_after',
		'label'    => esc_html__( 'Ad - After first post row', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_archive',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_archive_row2_after',
		'label'    => esc_html__( 'Ad - After second post row', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_archive',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_archive_row3_after',
		'label'    => esc_html__( 'Ad - After third post row', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_archive',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_post_content_before',
		'label'    => esc_html__( 'Ad - Before post content', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_post',
	);

	$controls[] = array(
		'type'     => 'textarea-unfiltered',
		'setting'  => 'landingpress_ad_post_content_after',
		'label'    => esc_html__( 'Ad - After post content', 'landingpress-wp' ),
		'section'  => 'landingpress_ads_post',
	);

	return $controls;
}

function landingpress_callback_google_analytics_ua() {
	$analytics_id = get_theme_mod('landingpress_google_analytics_id');
	$analytics_id = trim( $analytics_id );
	return ( !empty( $analytics_id ) && substr( $analytics_id, 0, 3 ) === "UA-" ? true : false );
}

add_action( 'admin_head', 'landingpress_check_update_again_here' );
function landingpress_check_update_again_here() {
	$screen = get_current_screen();
	if ( $screen->id == 'plugins' || $screen->id == 'themes' || $screen->id == 'options-general' || $screen->id == 'update-core' ) {
		$license_key = trim( get_option( LANDINGPRESS_THEME_SLUG . '_license_key' ) );
		global $landingpress_updater;
		if ( $license_key ) {
			$message = $landingpress_updater->check_license();
			if ( $message ) {
				delete_transient( LANDINGPRESS_THEME_SLUG . '_license_message' );
				set_transient( LANDINGPRESS_THEME_SLUG . '_license_message', $message, ( 60 * 60 * 24 ) );
			}
		}
	}
}
