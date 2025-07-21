<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'customize_register', 'landingpress_wc_customize_settings' );
function landingpress_wc_customize_settings( $wp_customize ) {

	$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
	if ( ! in_array( $status, array( 'valid', 'expired' ) ) ) {
		return;
	}

	$wp_customize->add_panel( 'landingpress_wc', array(
		'title'    => esc_html__( 'LandingPress WooCommerce', 'landingpress-wp' ),
		'priority' => 7
	) );

	$wp_customize->add_section( 'landingpress_wc_fb_pixel', array(
		'title'    => esc_html__( 'Facebook Pixel', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 3
	) );

	$wp_customize->add_section( 'landingpress_wc_adwords', array(
		'title'    => esc_html__( 'Google Ads (AdWords)', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 4
	) );

	$wp_customize->add_section( 'landingpress_wc_colors', array(
		'title'    => esc_html__( 'Basic Colors', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 5
	) );

	$wp_customize->add_section( 'landingpress_wc_shop', array(
		'title'    => esc_html__( 'Shop Page', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 10
	) );

	$wp_customize->add_section( 'landingpress_wc_product', array(
		'title'    => esc_html__( 'Single Product Page', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 20
	) );

	$wp_customize->add_section( 'landingpress_wc_cart', array(
		'title'    => esc_html__( 'Cart Page', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 30
	) );

	$wp_customize->add_section( 'landingpress_wc_checkout', array(
		'title'    => esc_html__( 'Checkout Page', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 40
	) );

	$wp_customize->add_section( 'landingpress_wc_myaccount', array(
		'title'    => esc_html__( 'My Account Page', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 50
	) );

	$wp_customize->add_section( 'landingpress_wc_optimization', array(
		'title'    => esc_html__( 'Optimization', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 60,
	) );

	$wp_customize->add_section( 'landingpress_wc_kodeunik', array(
		'title'    => esc_html__( 'Kode Unik Checkout', 'landingpress-wp' ),
		'description' => esc_html__( 'Fitur "Kode Unik" ini sangat bermanfaat untuk Anda yang berjualan online di market lokal dengan metode pembayaran bank transer, untuk mempermudah melakukan verifikasi pembayaran dari customer.', 'landingpress-wp' ),
		'panel'    => 'landingpress_wc',
		'priority' => 110
	) );

}

add_filter( 'landingpress_customize_controls', 'landingpress_wc_customize_controls' );
function landingpress_wc_customize_controls( $controls ) {

	$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
	if ( ! in_array( $status, array( 'valid', 'expired' ) ) ) {
		return $controls;
	}
	
	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_minicart',
		'label'    => esc_html__( 'Show minicart icon', 'landingpress-wp' ),
		'section'  => 'landingpress_header_menu',
		'default'  => '1',
		'priority' => 5,
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_color_saleflash',
		'label'    => esc_html__( 'Sale Flash', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_saleflash',
		'label'    => esc_html__( 'Sale Flash Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce span.onsale { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_color_price',
		'label'    => esc_html__( 'Price', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_price',
		'label'    => esc_html__( 'Price Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_color_button',
		'label'    => esc_html__( 'Button', 'landingpress-wp' ),
		'description' => 'Button adalah <em>secondary button</em> di WooCommerce yang dipakai untuk addtocart button di halaman Shop dan beberapa tempat lainnya.',
		'section'  => 'landingpress_wc_colors',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_background',
		'label'    => esc_html__( 'Button Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_text',
		'label'    => esc_html__( 'Button Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_background_hover',
		'label'    => esc_html__( 'Button Background Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_text_hover',
		'label'    => esc_html__( 'Button Text Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_color_button_alt',
		'label'    => esc_html__( 'Button ALT', 'landingpress-wp' ),
		'description' => 'Button ALT adalah <em>primary button</em> di WooCommerce yang dipakai untuk addtocart button di halaman Single Product dan beberapa tempat lainnya.',
		'section'  => 'landingpress_wc_colors',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_alt_background',
		'label'    => esc_html__( 'Button ALT Background Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_alt_text',
		'label'    => esc_html__( 'Button ALT Text Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_alt_background_hover',
		'label'    => esc_html__( 'Button ALT Background Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_color_button_alt_text_hover',
		'label'    => esc_html__( 'Button ALT Text Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_colors',
		'default'  => '',
		'style'    => '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover { color: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_shop_sidebar',
		'label'    => esc_html__( 'Show Sidebar', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menampilkan sidebar di halaman Shop dan Product Category.',
		'section'  => 'landingpress_wc_shop',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_sidebar',
		'label'    => esc_html__( 'Show Sidebar', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_shop_elements',
		'label'    => esc_html__( 'Shop Page Elements', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
	);

	$options = array( '' => 'Select ...' );
	for ($i=1; $i <=6; $i++) { 
		$options[$i] = $i;
	}
	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'landingpress_wc_shop_columns',
		'label'    => esc_html__( 'Number of Product Columns per Row', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
		'choices'  => $options,
	);

	for ($i=7; $i <=24; $i++) { 
		$options[$i] = $i;
	}
	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'landingpress_wc_shop_number',
		'label'    => esc_html__( 'Number of Products per Page', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
		'choices'  => $options,
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_breadcrumb_disable',
		'label'    => esc_html__( 'Hide Breadcrumb', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_page_title_disable',
		'label'    => esc_html__( 'Hide Page Title', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_result_count_disable',
		'label'    => esc_html__( 'Hide Result Count', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_catalog_ordering_disable',
		'label'    => esc_html__( 'Hide Catalog Ordering', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_saleflash_disable',
		'label'    => esc_html__( 'Hide Sale Flash', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_title_disable',
		'label'    => esc_html__( 'Hide Product Title', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_rating_disable',
		'label'    => esc_html__( 'Hide Product Rating', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_price_disable',
		'label'    => esc_html__( 'Hide Product Price', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_shop_addtocart',
		'label'    => esc_html__( 'AddToCart Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_shop_addtocart_enable',
		'label'    => esc_html__( 'Show AddToCart Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_shop',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_shop_text_addtocart',
		'label'    => sprintf( esc_html__( 'Change Button Text: "%s"', 'landingpress-wp' ), esc_html__( 'Add to cart', 'landingpress-wp' ) ),
		'section'  => 'landingpress_wc_shop',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_shop_text_selectoptions',
		'label'    => sprintf( esc_html__( 'Change Button Text: "%s"', 'landingpress-wp' ), esc_html__( 'Select options', 'landingpress-wp' ) ),
		'section'  => 'landingpress_wc_shop',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_shop_text_readmore',
		'label'    => sprintf( esc_html__( 'Change Button Text: "%s"', 'landingpress-wp' ), esc_html__( 'Read more', 'landingpress-wp' ) ),
		'section'  => 'landingpress_wc_shop',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_sidebar',
		'label'    => esc_html__( 'Show Sidebar', 'landingpress-wp' ),
		'description' => 'Gunakan opsi ini untuk menampilkan sidebar di halaman Single Product.',
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_sidebar',
		'label'    => esc_html__( 'Show Sidebar', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_elements',
		'label'    => esc_html__( 'Single Product Elements', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_breadcrumb_disable',
		'label'    => esc_html__( 'Hide Breadcrumb', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_saleflash_disable',
		'label'    => esc_html__( 'Hide Sale Flash', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_title_disable',
		'label'    => esc_html__( 'Hide Product Title', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_rating_disable',
		'label'    => esc_html__( 'Hide Product Rating', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_price_disable',
		'label'    => esc_html__( 'Hide Product Price', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_excerpt_disable',
		'label'    => esc_html__( 'Hide Product Short Description', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_meta_disable',
		'label'    => esc_html__( 'Hide Meta (Categories / Tags / SKU)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_gallery',
		'label'    => esc_html__( 'Product Image Gallery', 'landingpress-wp' ),
		'description' => 'Perhatian, opsi untuk product image gallery berikut ini tidak bisa berjalan di live preview.',
		'section'  => 'landingpress_wc_product',
	);

	if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
		// $options = array( '' => 'Select ...' );
		// for ($i=1; $i <=5; $i++) { 
		// 	$options[$i] = $i;
		// }
		// $controls[] = array(
		// 	'type'     => 'select',
		// 	'setting'  => 'landingpress_wc_product_thumb_columns',
		// 	'label'    => esc_html__( 'Number of Thumbnails per Row', 'landingpress-wp' ),
		// 	'section'  => 'landingpress_wc_product',
		// 	'default'  => '',
		// 	'choices'  => $options,
		// );
	}
	else {
		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'landingpress_wc_product_gallery_slider_disable',
			'label'    => esc_html__( 'Hide Product Gallery Slider', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_product',
			'default'  => '',
		);
		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'landingpress_wc_product_gallery_zoom_disable',
			'label'    => esc_html__( 'Hide Product Gallery Zoom', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_product',
			'default'  => '',
		);
	}

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_sticky',
		'label'    => esc_html__( 'Sticky Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_sticky_addtocart',
		'label'    => esc_html__( 'Activate Sticky Button For AddToCart / Whatsapp Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_addtocart',
		'label'    => esc_html__( 'AddToCart Button & Quantity', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_quantity_disable',
		'label'    => esc_html__( 'Hide Quantity Input', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_addtocart_disable',
		'label'    => esc_html__( 'Hide AddToCart Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_wc_product_addtocart_style',
		'label'    => esc_html__( 'AddToCart Button Style', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => 'standard',
		'choices'  => array(
			'standard' => esc_html__( 'Standard', 'landingpress-wp' ),
			'fullwidth' => esc_html__( 'Full Width', 'landingpress-wp' ),
		),
		'style'    => array( 
			'standard' => '',
			'fullwidth' => '.woocommerce div.product form.cart .button.single_add_to_cart_button { clear: both; display:block; width: 100%; } .woocommerce div.product .lp-product-cta-quantity-yes form.cart .quantity:not(.hidden) + .button.single_add_to_cart_button { clear: none; float: right; width: calc(100% - 70px); }',
		),
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_product_text_addtocart',
		'label'    => esc_html__( 'AddToCart Button Text', 'landingpress-wp' ),
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Add to cart', 'landingpress-wp' ),
		),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_product_addtocart_color',
		'label'    => esc_html__( 'AddToCart Button Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
		'style'    => '.woocommerce div.product form.cart .button.single_add_to_cart_button { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_product_addtocart_color_hover',
		'label'    => esc_html__( 'AddToCart Button Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
		'style'    => '.woocommerce div.product form.cart .button.single_add_to_cart_button:hover { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_whatsapp',
		'label'    => esc_html__( 'Whatsapp Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_whatsapp_enable',
		'label'    => esc_html__( 'Show Whatsapp Button', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_whatsapp_target',
		'label'    => esc_html__( 'Open Whatsapp Button in new window', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_wc_product_whatsapp_style',
		'label'    => esc_html__( 'Whatsapp Button Style', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => 'standard',
		'choices'  => array(
			'standard' => esc_html__( 'Standard', 'landingpress-wp' ),
			'fullwidth' => esc_html__( 'Full Width', 'landingpress-wp' ),
		),
		'style'    => array( 
			'standard' => '',
			'fullwidth' => '.woocommerce div.product .button.single_add_to_cart_whatsapp { clear: both; display:block; width: 100%; }',
		),
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_product_whatsapp_text',
		'label'    => esc_html__( 'Whatsapp Button Text', 'landingpress-wp' ),
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Buy via Whatsapp', 'landingpress-wp' ),
		),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_product_whatsapp_color',
		'label'    => esc_html__( 'Whatsapp Button Color', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
		'style'    => '.woocommerce div.product .button.single_add_to_cart_whatsapp { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'landingpress_wc_product_whatsapp_color_hover',
		'label'    => esc_html__( 'Whatsapp Button Color (Hover)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
		'style'    => '.woocommerce div.product .button.single_add_to_cart_whatsapp:hover { background: [value] }',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_product_whatsapp_phone',
		'label'    => esc_html__( 'Whatsapp Phone Number', 'landingpress-wp' ),
		'input_attrs' => array(
			'placeholder' => '0812345678',
		),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'landingpress_wc_product_whatsapp_message',
		'label'    => esc_html__( 'Whatsapp Message Format', 'landingpress-wp' ),
		'description' =>  esc_html__( 'Anda bisa menggunakan beberapa parameter berikut di format pesan Whatsapp: [site_title], [product_title], [product_price], [product_sku], [product_categories], [product_tags], [product_url]', 'landingpress-wp' ),
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Hai sis, saya mau pesan [product_title]. Terimakasih.', 'landingpress-wp' ),
		),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'radio',
		'setting'  => 'landingpress_wc_product_whatsapp_method',
		'label'    => esc_html__( 'Whatsapp Method', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => 'api',
		'choices'  => array(
			'api' => esc_html__( 'Link API WhatsApp', 'landingpress-wp' ),
			'deeplink' => esc_html__( 'Deeplink (Mobile Only)', 'landingpress-wp' ),
		),
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_tabs',
		'label'    => esc_html__( 'Product Tabs', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_description_disable',
		'label'    => esc_html__( 'Hide Product Description', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_attributes_disable',
		'label'    => esc_html__( 'Hide Product Attributes', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_reviews_disable',
		'label'    => esc_html__( 'Hide Product Reviews', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_upsells',
		'label'    => esc_html__( 'Upsells Products', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_upsells_disable',
		'label'    => esc_html__( 'Hide Upsells Products', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_related',
		'label'    => esc_html__( 'Related Products', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_product_related_disable',
		'label'    => esc_html__( 'Hide Related Products', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_product',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_cart_crosssells',
		'label'    => esc_html__( 'Cross-sells Products', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_cart',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_cart_crosssells_disable',
		'label'    => esc_html__( 'Hide Cross-sells Products', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_cart',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_cart_text',
		'label'    => esc_html__( 'Button Text', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_cart',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_cart_text_checkout',
		'label'    => sprintf( esc_html__( 'Change Button Text: "%s"', 'landingpress-wp' ), esc_html__( 'Proceed to Checkout', 'landingpress-wp' ) ),
		'section'  => 'landingpress_wc_cart',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_checkout_text',
		'label'    => esc_html__( 'Button Text', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_checkout',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_checkout_text_order',
		'label'    => sprintf( esc_html__( 'Change Button Text: "%s"', 'landingpress-wp' ), esc_html__( 'Place order', 'landingpress-wp' ) ),
		'section'  => 'landingpress_wc_checkout',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_checkout_icon_paypal',
		'label'    => esc_html__( 'Paypal Icon', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_checkout',
	);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'landingpress_wc_checkout_icon_paypal',
		'label'    => esc_html__( 'Custom Paypal Icon', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_checkout',
		'default'  => '',
	);

	if ( ! landingpress_is_facebookcommerce_active() ) {

		$controls[] = array(
			'type'     => 'heading',
			'setting'  => 'landingpress_heading_wc_fb_pixel_disable',
			'label'    => esc_html__( 'Facebook Pixel Status', 'landingpress-wp' ),
			'description' => esc_html__( 'Gunakan opsi ini untuk mematikan Facebook Pixel event dari LandingPress di halaman WooCommerce. Opsi ini berguna jika Anda ingin menggunakan WordPress Plugin lain (PixelSuite misalnya) untuk mengatur Facebook Pixel event di WooCommerce', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'landingpress_wc_fb_pixel_disable',
			'label'    => esc_html__( 'Disable LandingPress WooCommerce Facebook Pixel', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
			'default'  => '',
		);

		$controls[] = array(
			'type'     => 'heading',
			'setting'  => 'landingpress_heading_wc_fb_pixel_catalog',
			'label'    => esc_html__( 'Product Catalog', 'landingpress-wp' ),
			'description' => esc_html__( 'Jika Anda tidak menggunakan fitur Product Catalog di Facebook dan tidak ingin mendapatkan pesan "Cant Match Product" di Facebook Pixel Helper, silahkan gunakan opsi di bawah ini', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'landingpress_wc_fb_pixel_contentids_disable',
			'label'    => esc_html__( 'Disable "content_ids" pixel parameter', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
			'default'  => '',
		);

		$controls[] = array(
			'type'     => 'heading',
			'setting'  => 'landingpress_heading_wc_fb_pixel_purchase_pending',
			'label'    => esc_html__( 'WooCommerce Thank You Page - Bank Transfer Payment', 'landingpress-wp' ),
			'description' => esc_html__( 'Gunakan opsi ini untuk mengatur Facebook Pixel event untuk order yang menggunakan payment gateway "Bank Transfer" dengan status order "on-hold" dan "pending".', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
		);

		$controls[] = array(
			'type'     => 'radio',
			'setting'  => 'landingpress_wc_fb_pixel_purchase_pending',
			'label'    => esc_html__( 'Facebook Pixel Event Name', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
			'default'  => '',
			'choices'  => array(
				'' => 'AddPaymentInfo',
				'Purchase' => 'Purchase',
			),
		);

	}
	else {
		$controls[] = array(
			'type'     => 'warning',
			'setting'  => 'landingpress_heading_wc_fb_pixel_warning',
			'label'    => esc_html__( 'Plugin Facebook For WooCommerce Aktif', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
		);

		$controls[] = array(
			'type'     => 'heading',
			'setting'  => 'landingpress_heading_wc_fb_pixel_warning2',
			'label'    => '',
			'description' => esc_html__( 'Saat ini Anda menggunakan plugin Facebook For WooCommerce, sehingga fitur Facebook Pixel dari LandingPress untuk WooCommerce secara otomatis dinonaktifkan untuk mengindari konflik dan double pixel output. Akan tetapi, fungsi Facebook Pixel dari LandingPress di halaman lainnya tetap jalan normal seperti biasa.', 'landingpress-wp' ),
			'section'  => 'landingpress_wc_fb_pixel',
		);
	}

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_product_whatsapp_fbevent',
		'label'    => esc_html__( 'Whatsapp Button', 'landingpress-wp' ),
		'description' => esc_html__( 'Gunakan opsi ini untuk mengatur Facebook Pixel event untuk tombol Whatsapp di halaman produk.', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_fb_pixel',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_product_whatsapp_fbevent',
		'label'    => esc_html__( 'Facebook Pixel Event Name', 'landingpress-wp' ),
		'input_attrs' => array(
			'placeholder' => esc_html__( 'AddToCart', 'landingpress-wp' ),
		),
		'section'  => 'landingpress_wc_fb_pixel',
	);

	$controls[] = array(
		'type'     => 'warning',
		'setting'  => 'landingpress_heading_wc_adwords_warning',
		'label'    => esc_html__( 'Saat LandingPress versi ini dirilis, ada dua versi dashboard Google Ads (AdWords), versi baru (beta) dan versi lama. LandingPress support kedua versi tersebut. Silahkan disesuaikan.', 'landingpress-wp' ),
		'description' => '',
		'section'  => 'landingpress_wc_adwords',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_adwords_new',
		'label'    => esc_html__( 'WooCommerce Thank You Page - Google Ads (AdWords) Conversion (BARU)', 'landingpress-wp' ),
		'description' => 'Jika Anda ingin menggunakan kode conversion di Google Ads (AdWords) versi baru (beta), silahkan masukkan parameternya di bawah ini. Pastikan sudah memasukkan Adwords Google Site Tag ID di LandingPress.',
		'section'  => 'landingpress_wc_adwords',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_adwords_send_to',
		'label'    => 'send_to',
		'section'  => 'landingpress_wc_adwords',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_adwords_old',
		'label'    => esc_html__( 'WooCommerce Thank You Page - Google Ads (AdWords) Conversion (LAMA)', 'landingpress-wp' ),
		'description' => 'Jika Anda ingin menggunakan kode conversion di Google Ads (AdWords) versi lama, silahkan masukkan parameternya di bawah ini.',
		'section'  => 'landingpress_wc_adwords',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_google_conversion_id',
		'label'    => 'google_conversion_id',
		'section'  => 'landingpress_wc_adwords',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_google_conversion_label',
		'label'    => 'google_conversion_label',
		'section'  => 'landingpress_wc_adwords',
	);

	$controls[] = array(
		'type'     => 'warning',
		'setting'  => 'landingpress_heading_wc_optimization',
		'label'    => esc_html__( 'Fitur di bawah ini ada yang kemungkinan tidak berjalan baik dengan beberapa plugin tertentu. Jika ada masalah, silahkan coba nonaktifkan fitur yang ada di bawah ini.', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_optimization_cartfragments',
		'label'    => esc_html__( 'Cart Fragments', 'landingpress-wp' ),
		'description' => esc_html__( 'Dengan fitur ini, kita bisa menonaktifkan fitur cart fragments di WooCommerce yang seringkali lambat di shared hosting. Cart fragments ini dipakai di beberapa fitur WooCommerce seperti misalnya minicart dan widget shopping cart.', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_optimization_cartfragments_disable',
		'label'    => esc_html__( 'Disable Cart Fragments', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_optimization_minicart_count_disable',
		'label'    => esc_html__( 'Disable Cart Count on Header Minicart', 'landingpress-wp' ),
		'description' => esc_html__( 'Gunakan fitur ini jika Anda menonaktifkan cart fragment dan menggunakan static page cache dengan plugin cache apapun.', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_optimization',
		'default'  => '',
	);

	// $controls[] = array(
	// 	'type'     => 'heading',
	// 	'setting'  => 'landingpress_heading_wc_optimization_cart',
	// 	'label'    => esc_html__( 'Cart Page', 'landingpress-wp' ),
	// 	'description' => esc_html__( 'Dengan fitur ini, visitor dapat langsung melakukan Checkout di halaman Cart page.', 'landingpress-wp' ),
	// 	'section'  => 'landingpress_wc_optimization',
	// 	'default'  => '',
	// );

	// $controls[] = array(
	// 	'type'     => 'checkbox',
	// 	'setting'  => 'landingpress_wc_optimization_cartcheckout',
	// 	'label'    => esc_html__( 'Show Checkout Form on Cart Page', 'landingpress-wp' ),
	// 	'section'  => 'landingpress_wc_optimization',
	// 	'default'  => '',
	// );

	$controls[] = array(
		'type'     => 'heading',
		'setting'  => 'landingpress_heading_wc_optimization_checkout',
		'label'    => esc_html__( 'Checkout Page', 'landingpress-wp' ),
		'description' => esc_html__( 'Dengan fitur ini, ketika orang klik tombol AddToCart, akan langsung diarahkan ke halaman Checkout, tanpa lewat halaman Cart terlebih dahulu.', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_optimization_directcheckout',
		'label'    => esc_html__( 'Direct Checkout (Skip Cart Page)', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_optimization',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'checkbox',
		'setting'  => 'landingpress_wc_kodeunik_enable',
		'label'    => esc_html__( 'Aktifkan fitur Kode Unik (3 angka acak) di halaman Checkout', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_kodeunik',
		'default'  => '',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_kodeunik_label',
		'label'    => esc_html__( 'Label', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_kodeunik',
		'description' => esc_html__( 'Teks yang muncul di halaman checkout. Default: Kode Unik', 'landingpress-wp' ),
	);

	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'landingpress_wc_kodeunik_mode',
		'label'    => esc_html__( 'Mode Kode Unik', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_kodeunik',
		'default'  => 'min',
		'choices'  => array(
			'min' => esc_html__( 'Pengurangan (Minus)', 'landingpress-wp' ),
			'plus' => esc_html__( 'Penambahan (Plus)', 'landingpress-wp' ),
		),
		'description' => esc_html__( 'Mode pengurangan = diskon tambahan', 'landingpress-wp' ).'<br/>'.__( 'Mode penambahan = biaya tambahan', 'landingpress-wp' ),
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_kodeunik_min',
		'label'    => esc_html__( 'Angka Minimum Kode Unik', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_kodeunik',
	);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'landingpress_wc_kodeunik_max',
		'label'    => esc_html__( 'Angka Maksimum Kode Unik', 'landingpress-wp' ),
		'section'  => 'landingpress_wc_kodeunik',
	);

	return $controls;
}

add_action( 'after_setup_theme', 'landingpress_wc_theme_support' );
function landingpress_wc_theme_support() {
    add_theme_support( 'woocommerce' );
}

add_filter('landingpress_is_sidebar_active', 'landingpress_wc_sidebar_inactive');
function landingpress_wc_sidebar_inactive( $value ) {
	if ( is_cart() || is_checkout() || is_account_page() ) {
		return false;
	}
	if ( is_woocommerce() ) {
		if ( is_product() ) {
			if ( get_theme_mod( 'landingpress_wc_product_sidebar' ) ) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			if ( get_theme_mod( 'landingpress_wc_shop_sidebar' ) ) {
				return true;
			}
			else {
				return false;
			}
		}
	}
	return $value;
}

remove_filter('wp_nav_menu_items','landingpress_header_searchform', 10, 2);
add_filter('wp_nav_menu_items','landingpress_wc_header_searchform', 10, 2);
function landingpress_wc_header_searchform($items, $args) {
	if( get_theme_mod('landingpress_menu_search', '1') && $args->theme_location == 'header' ) {
		$form = get_search_form( false );
		$form = str_replace( ' role="search"', '', $form );
		$form = str_replace( 'placeholder="Search &hellip;"', 'placeholder="Search product &hellip;"', $form );
		$form = str_replace( '</form>', '<input type="hidden" name="post_type" value="product" /></form>', $form );
		$items .= '<li class="header-searchform">' . $form . '</li>';
	}
	return $items;
}

add_filter('woocommerce_add_to_cart_fragments', 'landingpress_header_minicart_count');
function landingpress_header_minicart_count( $fragments ) {
	if ( ! get_theme_mod( 'landingpress_wc_optimization_cartfragments_disable' ) ) {
		$fragments['.minicart-count'] = '<span class="minicart-count">'. WC()->cart->get_cart_contents_count() .'</span>';
	}
	return $fragments;
}

add_action( 'wp_head', 'landingpress_wc_kode_unik_set' );
function landingpress_wc_kode_unik_set() {
	if ( !is_cart() && !is_checkout() ) {
		WC()->session->set( 'landingpress_wc_kodeunik', 0 );
	}
}

add_action( 'woocommerce_cart_calculate_fees', 'landingpress_wc_kode_unik' );
function landingpress_wc_kode_unik() {
	if ( get_theme_mod('landingpress_wc_kodeunik_enable') ) {
		$min = get_theme_mod('landingpress_wc_kodeunik_min');
		$max = get_theme_mod('landingpress_wc_kodeunik_max');
		if ( $min && $max && $max > $min ) {
			$cost_min = $min;
			$cost_max = $max;
		}
		elseif ( $min && $max && $min > $max ) {
			$cost_min = $max;
			$cost_max = $min;
		}
		elseif ( $min && !$max ) {
			$cost_min = $min;
			$cost_max = 999;
		}
		elseif ( !$min && $max ) {
			if ( $max > 100 ) {
				$cost_min = 100;
			}
			else {
				$cost_min = 10;
			}
			$cost_max = $max;
		}
		else {
			$cost_min = 100;
			$cost_max = 999;
		}
		$mode = get_theme_mod('landingpress_wc_kodeunik_mode');
		if ( WC()->cart->subtotal != 0){
			$label = get_theme_mod('landingpress_wc_kodeunik_label');
			if ( !$label ) {
				$label = esc_html__( 'Kode Unik', 'landingpress-wp' );
			}
			$cost = WC()->session->get( 'landingpress_wc_kodeunik' );
			if ( !$cost ) {
				$cost = rand( $cost_min, $cost_max );
				WC()->session->set( 'landingpress_wc_kodeunik', $cost );
			}
			if( $cost ) {
				if ( $mode != 'plus' ) {
					$cost = -1*$cost;
				}
				WC()->cart->add_fee( $label, $cost);
			}
		}
	}
}

function landingpress_is_facebookcommerce_active() {
	if ( ! class_exists( 'WC_Facebookcommerce' ) ) 
		return false; 
	$fbwoo = get_option('woocommerce_facebookcommerce_settings');
	if ( isset($fbwoo['fb_api_key']) && $fbwoo['fb_api_key'] && isset($fbwoo['fb_product_catalog_id']) && $fbwoo['fb_product_catalog_id'] ) {
		return true;
	}
	else {
		return false;
	}
}

add_filter( 'landingpress_facebook_pixel_ids', 'landingpress_facebook_pixel_ids_facebookcommerce');
function landingpress_facebook_pixel_ids_facebookcommerce( $fb_pixel_ids ) {
	if ( class_exists( 'WC_Facebookcommerce' ) ) {
		$fbwoo = get_option('woocommerce_facebookcommerce_settings');
		if ( isset($fbwoo['fb_pixel_id']) && $fbwoo['fb_pixel_id'] && isset($fbwoo['fb_api_key']) && $fbwoo['fb_api_key'] && isset($fbwoo['fb_product_catalog_id']) && $fbwoo['fb_product_catalog_id'] ) {
			$fb_pixel_id = $fbwoo['fb_pixel_id'];
			if ( isset( $fb_pixel_ids[$fb_pixel_id] ) ) {
				unset( $fb_pixel_ids[$fb_pixel_id] );
			}
		}
	}
	return $fb_pixel_ids;
}

add_filter( 'landingpress_facebook_pixel_event', 'landingpress_wc_facebook_pixel_set_event' );
function landingpress_wc_facebook_pixel_set_event( $event ) {
	if ( is_product() || is_cart() || is_checkout() ) {
		$event = 'PageView';
	}
	return $event;
}

add_filter( 'wp_footer', 'landingpress_wc_facebook_pixel_event_viewcontent' );
function landingpress_wc_facebook_pixel_event_viewcontent() {
	if ( get_theme_mod( 'landingpress_wc_fb_pixel_disable' ) ) {
		return;
	}
	if ( landingpress_is_facebookcommerce_active() ) {
		return;
	}
	$fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	if ( empty( $fb_pixel_ids ) ) {
		return;
	}
	if ( is_product() ) {
		$fb_event = 'ViewContent';
		$fb_custom_event = '';
		global $product;
		$product_price = $product->get_price();
		$product_id = $product->get_ID();
		$fb_data = array();
		$fb_data['source'] = 'landingpress-woocommerce';
		$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
		$fb_data['campaign_url'] = get_queried_object()->post_name;
		$fb_data['content_name'] = get_the_title();
		$fb_data['value'] = number_format((float)$product_price, 2, '.', '');
		$fb_data['currency'] = get_woocommerce_currency();
		if ( !get_theme_mod('landingpress_wc_fb_pixel_contentids_disable') ) {
			$fb_data['content_ids'] = array( 'wc_post_id_'.strval( $product_id ) );
			if ( in_array( $product->get_type(), array( 'variable', 'variable-subscription' ) ) ) {
				$fb_data['content_type'] = 'product_group';
			}
			else {
				$fb_data['content_type'] = 'product';
			}
		}
		$fb_events = array();
		$fb_events[] = array( 
			'event' => $fb_event,
			'custom_event' => $fb_custom_event,
			'data' => $fb_data,
		);
		landingpress_facebook_pixel_set_events( $fb_events );
	}
}

add_action( 'woocommerce_after_cart', 'landingpress_wc_facebook_pixel_event_cart' );
function landingpress_wc_facebook_pixel_event_cart() {
	if ( get_theme_mod( 'landingpress_wc_fb_pixel_disable' ) ) {
		return;
	}
	if ( landingpress_is_facebookcommerce_active() ) {
		return;
	}
	$fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	if ( empty( $fb_pixel_ids ) ) {
		return;
	}
	$cart = WC()->cart->get_cart();
	$product_ids = array();
	foreach ($cart as $item) {
		$product_ids[] = 'wc_post_id_'.strval( $item['data']->get_id() );
	}
	if ( !empty( $product_ids ) ) {
		$fb_event = 'AddToCart';
		$fb_custom_event = '';
		$fb_data = array();
		$fb_data['source'] = 'landingpress-woocommerce';
		$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
		$fb_data['num_items'] = WC()->cart->get_cart_contents_count();
		if ( !get_theme_mod('landingpress_wc_fb_pixel_contentids_disable') ) {
			$fb_data['content_ids'] = json_encode($product_ids);
			$fb_data['content_type'] = 'product';
		}
		$fb_data['value'] = WC()->cart->total;
		$fb_data['currency'] = get_woocommerce_currency();
		$fb_events = array();
		$fb_events[] = array( 
			'event' => $fb_event,
			'custom_event' => $fb_custom_event,
			'data' => $fb_data,
		);
		landingpress_facebook_pixel_set_events( $fb_events );
	}
}

add_action( 'woocommerce_after_checkout_form', 'landingpress_wc_facebook_pixel_event_checkout' );
function landingpress_wc_facebook_pixel_event_checkout() {
	if ( get_theme_mod( 'landingpress_wc_fb_pixel_disable' ) ) {
		return;
	}
	if ( landingpress_is_facebookcommerce_active() ) {
		return;
	}
	$fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	if ( empty( $fb_pixel_ids ) ) {
		return;
	}
	$cart = WC()->cart->get_cart();
	$product_ids = array();
	foreach ($cart as $item) {
		$product_ids[] = 'wc_post_id_'.strval( $item['data']->get_id() );
	}
	if ( !empty( $product_ids ) ) {
		$fb_event = 'InitiateCheckout';
		$fb_custom_event = '';
		$fb_data = array();
		$fb_data['source'] = 'landingpress-woocommerce';
		$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
		$fb_data['num_items'] = WC()->cart->get_cart_contents_count();
		if ( !get_theme_mod('landingpress_wc_fb_pixel_contentids_disable') ) {
			$fb_data['content_ids'] = json_encode($product_ids);
			$fb_data['content_type'] = 'product';
		}
		$fb_data['value'] = WC()->cart->total;
		$fb_data['currency'] = get_woocommerce_currency();
		$fb_events = array();
		$fb_events[] = array( 
			'event' => $fb_event,
			'custom_event' => $fb_custom_event,
			'data' => $fb_data,
		);
		landingpress_facebook_pixel_set_events( $fb_events );
	}
}

add_action( 'woocommerce_thankyou', 'landingpress_wc_facebook_pixel_event_purchase' );
function landingpress_wc_facebook_pixel_event_purchase( $order_id = false ) {
	if ( get_theme_mod( 'landingpress_wc_fb_pixel_disable' ) ) {
		return;
	}
	if ( landingpress_is_facebookcommerce_active() ) {
		return;
	}
	$fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	if ( empty( $fb_pixel_ids ) ) {
		return;
	}
	if ( !$order_id ) {
		return;
	}
	$order = new WC_Order( $order_id );
	$product_ids = array();
	foreach ( $order->get_items() as $item ) {
		$product_ids[] = 'wc_post_id_'.strval( $item['product_id'] );
	}
	if ( !empty( $product_ids ) ) {
		$order_status = $order->get_status();
		$payment_method = $order->get_payment_method();
		$total = $order->get_total();
		if ( 'completed' == $order_status || 'processing' == $order_status ) {
			$fb_event = 'Purchase';
		}
		elseif ( 'on-hold' == $order_status || 'pending' == $order_status ) {
			if ( get_theme_mod('landingpress_wc_fb_pixel_purchase_pending') ) {
				$fb_event = 'Purchase';
			}
			else {
				$fb_event = 'AddPaymentInfo';
			}
		}
		$fb_custom_event = '';
		$fb_data = array();
		$fb_data['order_status'] = $order_status;
		$fb_data['payment_method'] = $payment_method;
		$fb_data['source'] = 'landingpress-woocommerce';
		$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
		if ( !get_theme_mod('landingpress_wc_fb_pixel_contentids_disable') ) {
			$fb_data['content_ids'] = json_encode($product_ids);
			$fb_data['content_type'] = 'product';
		}
		$fb_data['value'] = $total;
		$fb_data['currency'] = get_woocommerce_currency();
		$fb_events = array();
		$fb_events[] = array( 
			'event' => $fb_event,
			'custom_event' => $fb_custom_event,
			'data' => $fb_data,
		);
		landingpress_facebook_pixel_set_events( $fb_events );
	}
}

add_action( 'woocommerce_add_to_cart', 'landingpress_wc_facebook_pixel_event_add_to_cart' );
function landingpress_wc_facebook_pixel_event_add_to_cart() {
	if ( get_theme_mod( 'landingpress_wc_fb_pixel_disable' ) ) {
		return;
	}
	if ( landingpress_is_facebookcommerce_active() ) {
		return;
	}
	/* it is too early to check fb_pixel_ids */
	// $fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	// if ( empty( $fb_pixel_ids ) ) {
	// 	return;
	// }
	$cart = WC()->cart->get_cart();
	$product_ids = array();
	foreach ($cart as $item) {
		$product_ids[] = 'wc_post_id_'.strval( $item['data']->get_id() );
	}
	if ( !empty( $product_ids ) ) {
		$fb_event = 'AddToCart';
		$fb_custom_event = '';
		$fb_data = array();
		$fb_data['source'] = 'landingpress-woocommerce';
		$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
		$fb_data['num_items'] = WC()->cart->get_cart_contents_count();
		if ( !get_theme_mod('landingpress_wc_fb_pixel_contentids_disable') ) {
			$fb_data['content_ids'] = json_encode($product_ids);
			$fb_data['content_type'] = 'product';
		}
		$fb_data['value'] = WC()->cart->total;
		$fb_data['currency'] = get_woocommerce_currency();
		$fb_events = array();
		$fb_events[] = array( 
			'event' => $fb_event,
			'custom_event' => $fb_custom_event,
			'data' => $fb_data,
		);
		landingpress_facebook_pixel_set_events( $fb_events );
	}
}

add_action( 'wp', 'landingpress_wc_setup_shop_page' );
function landingpress_wc_setup_shop_page() {
	add_filter( 'loop_shop_columns', 'landingpress_wc_shop_columns', 20 );
	add_filter( 'body_class', 'landingpress_wc_body_class_product_columns' );
	if( get_theme_mod( 'landingpress_wc_shop_breadcrumb_disable' ) ) {
		if ( !is_product() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		}
	}
	if( get_theme_mod( 'landingpress_wc_shop_page_title_disable' ) ) {
		if ( !is_product() && !is_search() && !is_tax() ) {
			add_filter( 'woocommerce_show_page_title', '__return_false' );
		}
	}
	if( get_theme_mod( 'landingpress_wc_shop_result_count_disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}
	if( get_theme_mod( 'landingpress_wc_shop_catalog_ordering_disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}
	if( get_theme_mod( 'landingpress_wc_shop_saleflash_disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	}
	if( get_theme_mod( 'landingpress_wc_shop_title_disable' ) ) {
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	}
	if( get_theme_mod( 'landingpress_wc_shop_rating_disable' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}
	if( get_theme_mod( 'landingpress_wc_shop_price_disable' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	}
	if( !get_theme_mod( 'landingpress_wc_shop_addtocart_enable' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}
}

add_filter( 'loop_shop_per_page', 'landingpress_wc_shop_products_per_page', 20 );
function landingpress_wc_shop_products_per_page( $number ) {
	$per_page = intval( get_theme_mod( 'landingpress_wc_shop_number' ) );
	if ( $per_page < 1 ) $per_page = 12;
	return $per_page;
}
function landingpress_wc_shop_columns( $columns ) {
	$columns = intval( get_theme_mod( 'landingpress_wc_shop_columns' ) );
	if ( $columns < 1 ) $columns = 4;
	if ( $columns > 6 ) $columns = 6;
	return $columns;
}
function landingpress_wc_body_class_product_columns( $classes ) {
	if ( is_woocommerce() && ! is_product() ) {
		$columns = apply_filters( 'loop_shop_columns', 4 );
		if ( $columns < 1 ) $columns = 4;
		if ( $columns > 6 ) $columns = 6;
		$classes[] = 'columns-' . $columns;
	}
	return $classes;
}

if ( get_theme_mod('landingpress_wc_optimization_directcheckout') ) {
	add_filter('pre_option_woocommerce_cart_redirect_after_add', 'landingpress_wc_direct_checkout_force' ); 
	add_filter('pre_option_woocommerce_enable_ajax_add_to_cart', 'landingpress_wc_direct_checkout_force' ); 
	function landingpress_wc_direct_checkout_force( $option ) {
		return 'no';
	}
	add_filter('add_to_cart_redirect', 'landingpress_wc_direct_checkout_redirect');
	function landingpress_wc_direct_checkout_redirect() {
		$checkout_url = WC()->cart->get_checkout_url();
		return $checkout_url;
	}
	add_action( 'wp_head', 'landingpress_wc_direct_checkout_style', 100 );	
	function landingpress_wc_direct_checkout_style() { 
	    echo '<style>.woocommerce-checkout .woocommerce-message, .woocommerce-checkout .woocommerce-error { display:none !important; }</style>'; 
	}; 
}

add_action( 'wp', 'landingpress_wc_setup_product_page' );
function landingpress_wc_setup_product_page() {
	if( get_theme_mod( 'landingpress_wc_product_breadcrumb_disable' ) ) {
		if ( is_product() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		}
	}
	if( get_theme_mod( 'landingpress_wc_product_saleflash_disable' ) ) {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	}
	// add_filter( 'woocommerce_product_thumbnails_columns', 'landingpress_wc_product_thumb_columns', 20 );
	if( get_theme_mod( 'landingpress_wc_product_title_disable' ) ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	}
	if( get_theme_mod( 'landingpress_wc_product_rating_disable' ) ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	}
	if( get_theme_mod( 'landingpress_wc_product_price_disable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	}
	if( get_theme_mod( 'landingpress_wc_product_excerpt_disable' ) ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	}
	add_action( 'woocommerce_single_product_summary', 'landingpress_wc_product_cta_open', 29 );
	if( get_theme_mod( 'landingpress_wc_product_addtocart_disable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	}
	if( get_theme_mod( 'landingpress_wc_product_whatsapp_enable' ) ) {
		add_action( 'woocommerce_single_product_summary', 'landingpress_wc_product_whatsapp_button', 31 );
	}
	add_action( 'woocommerce_single_product_summary', 'landingpress_wc_product_cta_close', 32 );
	if( get_theme_mod( 'landingpress_wc_product_meta_disable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	}
	if( get_theme_mod( 'landingpress_wc_product_upsells_disable' ) ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	}
	if( get_theme_mod( 'landingpress_wc_product_related_disable' ) ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	}
	add_filter( 'woocommerce_product_description_heading', '__return_false' );
}

function landingpress_wc_product_thumb_columns( $columns ) {
	$columns = intval( get_theme_mod( 'landingpress_wc_product_thumb_columns' ) );
	if ( $columns < 1 ) $columns = 4;
	if ( $columns > 5 ) $columns = 5;
	return $columns;
}

function landingpress_wc_product_cta_open() {
	if ( get_theme_mod('landingpress_wc_product_quantity_disable') ) {
		echo '<div class="lp-product-cta lp-product-cta-quantity-no">';
	}
	else {
		echo '<div class="lp-product-cta lp-product-cta-quantity-yes">';
	}
}

function landingpress_wc_product_cta_close() {
	echo '</div>';
}

function landingpress_wc_product_whatsapp_button() {
	global $product;
	$product_price = $product->get_price();
	$product_id = $product->get_ID();
	$fb_data = array();
	$fb_data['source'] = 'landingpress-woocommerce-button';
	$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
	$fb_data['campaign_url'] = get_queried_object()->post_name;
	$fb_data['content_name'] = get_the_title();
	$fb_data['value'] = number_format((float)$product_price, 2, '.', '');
	$fb_data['currency'] = get_woocommerce_currency();
	if ( landingpress_is_facebookcommerce_active() ) {
		$fb_data['content_ids'] = array( 'wc_post_id_'.strval( $product_id ) );
		if ( in_array( $product->get_type(), array( 'variable', 'variable-subscription' ) ) ) {
			$fb_data['content_type'] = 'product_group';
		}
		else {
			$fb_data['content_type'] = 'product';
		}
	}
	else {
		if ( !get_theme_mod('landingpress_wc_fb_pixel_contentids_disable') ) {
			$fb_data['content_ids'] = array( 'wc_post_id_'.strval( $product_id ) );
			if ( in_array( $product->get_type(), array( 'variable', 'variable-subscription' ) ) ) {
				$fb_data['content_type'] = 'product_group';
			}
			else {
				$fb_data['content_type'] = 'product';
			}
		}
	}
	$wa_text = get_theme_mod('landingpress_wc_product_whatsapp_text');
	if ( !trim($wa_text) ) {
		$wa_text = esc_html__( 'Buy via Whatsapp', 'landingpress-wp' );
	}
	$wa_phone = get_theme_mod('landingpress_wc_product_whatsapp_phone');
	if ( !trim($wa_phone) ) {
		$wa_phone = '0812345678';
	}
	$wa_phone = preg_replace('/[^0-9]/', '', $wa_phone);
	$wa_phone = preg_replace('/^620/','62', $wa_phone);
	$wa_phone = preg_replace('/^0/','62', $wa_phone);
	$wa_message = get_theme_mod('landingpress_wc_product_whatsapp_message');
	if ( !trim($wa_message) ) {
		$wa_message = esc_html__( 'Hai sis, saya mau pesan [product_title]. Terimakasih.', 'landingpress-wp' );
		// $wa_message = 'Hai sis, saya mau pesan [product_title] harga [product_price] sku [product_sku] cats [product_categories] tags [product_tags]. Terimakasih.';
	}
	if (strpos($wa_message, '[webname]') !== false) {
		$wa_message = str_replace( '[webname]', get_bloginfo( 'name' ), $wa_message );
	}
	if (strpos($wa_message, '[site_title]') !== false) {
		$wa_message = str_replace( '[site_title]', get_bloginfo( 'name' ), $wa_message );
	}
	if (strpos($wa_message, '[productname]') !== false) {
		$wa_message = str_replace( '[productname]', get_the_title(), $wa_message );
	}
	if (strpos($wa_message, '[product_title]') !== false) {
		$wa_message = str_replace( '[product_title]', get_the_title(), $wa_message );
	}
	if (strpos($wa_message, '[product_price]') !== false) {
		$price = wc_price( $product_price );
		$price = strip_tags( $price );
		$wa_message = str_replace( '[product_price]', $price, $wa_message );
	}
	if (strpos($wa_message, '[product_sku]') !== false) {
		$sku = get_post_meta( $product_id, '_sku', true );
		$wa_message = str_replace( '[product_sku]', $sku, $wa_message );
	}
	if (strpos($wa_message, '[product_categories]') !== false) {
		$cats_array = array();
		$cats = '';
		$terms = wp_get_post_terms( $product_id, 'product_cat' );
		foreach ($terms as $term) {
			$cats_array[] = $term->name;
		}
		$cats = implode(', ', $cats_array);
		// $cats = strtolower( $cats );
		$wa_message = str_replace( '[product_categories]', $cats, $wa_message );
	}
	if (strpos($wa_message, '[product_tags]') !== false) {
		$tags_array = array();
		$tags = '';
		$terms = wp_get_post_terms( $product_id, 'product_tag' );
		foreach ($terms as $term) {
			$tags_array[] = $term->name;
		}
		$tags = implode(', ', $tags_array);
		// $tags = strtolower( $tags );
		$wa_message = str_replace( '[product_tags]', $tags, $wa_message );
	}
	if (strpos($wa_message, '[product_url]') !== false) {
		$product_url = get_permalink( $product_id );
		$wa_message = str_replace( '[product_url]', $product_url, $wa_message );
	}
	if ( get_theme_mod('landingpress_wc_product_whatsapp_method') !== 'deeplink' ) {
		$wa_link = 'https://api.whatsapp.com/send?phone='.$wa_phone.'&text='.rawurlencode($wa_message);
	}
	else {
		$wa_link = 'whatsapp://send?phone='.$wa_phone.'&text='.rawurlencode($wa_message);
	}
	$wa_fbevent = get_theme_mod('landingpress_wc_product_whatsapp_fbevent');
	if ( !trim($wa_fbevent) ) {
		$fbevent = ' data-fbevent="AddToCart" ';
		$fbcustomevent = '';
	}
	elseif ( trim($wa_fbevent) == 'Lead' ) {
		$fbevent = ' data-fbevent="Lead" ';
		$fbcustomevent = '';
	}
	else {
		$fbevent = '';
		$fbcustomevent = ' data-fbcustomevent="'.trim($wa_fbevent).'" ';
	}
	$target = get_theme_mod( 'landingpress_wc_product_whatsapp_target' ) ? ' target="_blank" ' : '';
	echo '<a href="'.$wa_link.'" '.$fbevent.$fbcustomevent.' data-fbdata=\''.json_encode($fb_data).'\' class="button alt single_add_to_cart_whatsapp" '.$target.'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg> '.$wa_text.'</a>';
}

add_filter( 'woocommerce_product_tabs', 'landingpress_wc_product_tabs', 99 );
function landingpress_wc_product_tabs( $tabs ) {
	if( get_theme_mod( 'landingpress_wc_product_description_disable' ) ) {
		unset( $tabs['description'] );
	}
	if( get_theme_mod( 'landingpress_wc_product_attributes_disable' ) ) {
		unset( $tabs['additional_information'] );
	}
	if( get_theme_mod( 'landingpress_wc_product_reviews_disable' ) ) {
	    unset( $tabs['reviews'] );
	}
    return $tabs;
}

add_filter( 'woocommerce_output_related_products_args', 'landingpress_wc_related_products_args' );
add_filter( 'woocommerce_related_products_args', 'landingpress_wc_related_products_args' );
function landingpress_wc_related_products_args() {
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 4,
		'columns' => 4,
		'orderby' => 'rand',
	);
	return $args;
}

add_filter( 'woocommerce_upsells_columns', 'landingpress_wc_upsells_columns' );
function landingpress_wc_upsells_columns( $columns ) {
	return 4;
}

add_filter( 'woocommerce_upsells_total', 'landingpress_wc_upsells_total' );
function landingpress_wc_upsells_total( $total ) {
	return 4;
}

if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
	function woocommerce_upsell_display( $posts_per_page = 4, $columns = 4, $orderby = 'rand' ) {
		$posts_per_page = 4;
		wc_get_template( 'single-product/up-sells.php', array(
			'posts_per_page'  => $posts_per_page,
			'orderby'    => $orderby,
			'columns'    => $columns
		) );
	}
}

add_action( 'wp', 'landingpress_wc_setup_cart_page' );
function landingpress_wc_setup_cart_page() {
	if( get_theme_mod( 'landingpress_wc_cart_crosssells_disable' ) ) {
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	}
}

// add_action( 'wp', 'landingpress_wc_setup_checkout_page' );
function landingpress_wc_setup_checkout_page() {
	if ( is_checkout() ) {
		add_filter('landingpress_is_menu_active', '__return_false');
		add_filter('landingpress_is_footerwidgets_active', '__return_false');
	}
}

function landingpress_wc_product_post_class( $classes ) {
	if ( 'product' == get_post_type() ) {
		$classes[] = 'product';
	}
	return $classes;
}

add_filter( 'woocommerce_product_add_to_cart_text' , 'landingpress_wc_product_add_to_cart_text' );
function landingpress_wc_product_add_to_cart_text( $text ) {
	global $product;
	if ( method_exists( $product, 'get_type' ) ) {
		$product_type = $product->get_type();
	} 
	else {
		$product_type = $product->product_type;
	}
	switch ( $product_type ) {
		case 'external':
			return $text;
		break;
		case 'grouped':
			return $text;
		break;
		case 'simple':
			if ( $text_new = get_theme_mod('landingpress_wc_shop_text_addtocart') ) {
				return $text_new;
			}
			return $text;
		break;
		case 'variable':
			if ( $text_new = get_theme_mod('landingpress_wc_shop_text_selectoptions') ) {
				return $text_new;
			}
			return $text;
		break;
		default:
			if ( $text_new = get_theme_mod('landingpress_wc_shop_text_readmore') ) {
				return $text_new;
			}
			return $text;
	}
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'landingpress_wc_product_single_add_to_cart_text' ); 
function landingpress_wc_product_single_add_to_cart_text( $text ) {
	if ( $text_new = get_theme_mod('landingpress_wc_product_text_addtocart') ) {
		return $text_new;
	}
	return $text;
}

add_filter( 'woocommerce_order_button_text', 'landingpress_wc_checkout_order_button_text' ); 
function landingpress_wc_checkout_order_button_text( $text ) {
	if ( $text_new = get_theme_mod('landingpress_wc_checkout_text_order') ) {
		return $text_new;
	}
	return $text;
}

function woocommerce_button_proceed_to_checkout() {
	if ( $text_new = get_theme_mod('landingpress_wc_cart_text_checkout') ) {
		echo '<a href="'.esc_url( wc_get_checkout_url() ).'" class="checkout-button button alt wc-forward">'.$text_new.'</a>';
	}
	else {
		wc_get_template( 'cart/proceed-to-checkout-button.php' );
	}
}

add_filter( 'woocommerce_paypal_icon', 'landingpress_wc_checkout_icon_paypal' );
function landingpress_wc_checkout_icon_paypal( $icon ) {
	if ( $icon_new = get_theme_mod('landingpress_wc_checkout_icon_paypal') ) {
		return $icon_new;
	}
	return $icon;
}

add_filter( 'body_class', 'landingpress_wc_body_class_sticky_addtocart' );
function landingpress_wc_body_class_sticky_addtocart( $classes ) {
	if ( get_theme_mod('landingpress_wc_product_sticky_addtocart') ) {
		if ( is_product() ) {
			$classes[] = 'sticky-addtocart-yes';
		}
	}
	return $classes;
}

add_action( 'wp_footer', 'landingpress_wc_footer_sticky_addtocart' );
function landingpress_wc_footer_sticky_addtocart() {
	if ( is_product() ) {
		echo '<div class="woocommerce woocommerce-sticky-addtocart"><div class="product"></div></div>';
	}
}

add_action( 'woocommerce_thankyou', 'landingpress_wc_adwords_conversion_event' );
function landingpress_wc_adwords_conversion_event( $order_id = false ) {
	global $landingpress_wc_thankyou_order_id;
	if( $order_id ) {
		$landingpress_wc_thankyou_order_id = $order_id;
		$send_to = get_theme_mod( 'landingpress_wc_adwords_send_to' );
		if ( $send_to ) {
			$order = new WC_Order( $order_id );
			$adwords_events = array();
			$adwords_events[$send_to] = array(
				'send_to' => $send_to,
				'value' => $order->get_total(),
				'currency' => get_woocommerce_currency(),
				'transaction_id' => $order_id,
			);
			landingpress_adwords_set_events( $adwords_events );
		}
	}
}

add_action( 'wp_footer', 'landingpress_wc_wp_footer_adwords_conversion_event_old', 100 );
function landingpress_wc_wp_footer_adwords_conversion_event_old() {
	global $landingpress_wc_thankyou_order_id;
	if( $landingpress_wc_thankyou_order_id ) {
		$order_id = $landingpress_wc_thankyou_order_id;
		$conv_id = trim( get_theme_mod( 'landingpress_wc_google_conversion_id' ) );
		$conv_label = trim( get_theme_mod( 'landingpress_wc_google_conversion_label' ) );

		if ( ! $conv_id ) {
			return;
		}
		if ( ! $conv_label ) {
			return;
		}

		$order = new WC_Order( $order_id );
		$status = $order->get_status();

		// on-hold, pending, processing, completed, cancelled, refunded, failed
		$ga_purchase = false;
		if ( 'completed' == $status || 'processing' == $status ) {
			$ga_purchase = true;
		}
		elseif ( 'on-hold' == $status || 'pending' == $status ) {
			$ga_purchase = true;
		}
		if ( $ga_purchase ) {
			$value = $order->get_total();
			$currency = get_woocommerce_currency();
?>
<!-- Google Code for WooCommerce Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = <?php echo $conv_id; ?>;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "<?php echo $conv_label; ?>";
var google_conversion_value = <?php echo $value; ?>;
var google_conversion_currency = "<?php echo $currency; ?>";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/<?php echo $conv_id; ?>/?value=<?php echo $value; ?>&amp;currency_code=<?php echo $currency; ?>&amp;label=<?php echo $conv_label; ?>&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php 
		}
	}
}

add_action( 'admin_head-post.php', 'landingpress_cmb_meta_boxes_scripts_wcpages' );
add_action( 'admin_head-post-new.php', 'landingpress_cmb_meta_boxes_scripts_wcpages' );
function landingpress_cmb_meta_boxes_scripts_wcpages() {
	global $post;
	$post_id = $post->ID;
	$shop_page_id = get_option( 'woocommerce_shop_page_id' ); 
	$cart_page_id = get_option( 'woocommerce_cart_page_id' ); 
	$checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	if ( $post_id == $shop_page_id || $post_id == $cart_page_id || $post_id == $checkout_page_id || $post_id == $myaccount_page_id ) {
    ?>
	<script type="text/javascript">
	/*<![CDATA[*/
	jQuery(document).ready(function($){
		if ( $('#landingpress-facebook-pixel').length ) {
			$('#landingpress-facebook-pixel').hide();
		}
	});
	/*]]>*/
	</script>
	<?php 
	}
}

add_filter( 'woocommerce_continue_shopping_redirect', 'landingpress_wc_continue_shopping_redirect' );
function landingpress_wc_continue_shopping_redirect( $redirect ) {
	return wc_get_page_permalink( 'shop' );
}

add_action( 'wp_enqueue_scripts', 'landingpress_wc_disable_cart_fragments', 20 );
function landingpress_wc_disable_cart_fragments() {
	if ( is_cart() || is_checkout() ) {
		return;
	}
	if ( get_theme_mod( 'landingpress_wc_optimization_cartfragments_disable' ) ) {
		wp_dequeue_script('wc-cart-fragments');
	}
}

// add_filter( 'the_content', 'landingpress_wc_optimization_cartcheckout_content', 0 );
// function landingpress_wc_optimization_cartcheckout_content( $content ) {
// 	if ( ! get_theme_mod( 'landingpress_wc_optimization_cartcheckout') ) {
// 		return $content;
// 	}
// 	if ( ! is_cart() ) {
// 		return $content;
// 	}
// 	$content = str_replace( '[woocommerce_cart]', '[woocommerce_cart][woocommerce_checkout]', $content );
// 	return $content;
// }

add_action( 'edit_form_top', 'landingpress_wc_show_page_notice', 20 );
function landingpress_wc_show_page_notice( $post ) {
	$shop_page_id = wc_get_page_id( 'shop' );
	if ( $shop_page_id > 0 ) {
		if ( $post && absint( $shop_page_id ) === absint( $post->ID ) ) {
			echo '<div class="notice notice-warning">';
			echo '<p>' . wp_kses_post( __( 'Halaman ini adalah halaman "Shop" utama dari WooCommerce.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( '<strong>Halaman ini TIDAK BISA dan/atau JANGAN diedit dengan page builder</strong>, termasuk Elementor, karena dapat mengganggu performa dari WooCommerce itu sendiri.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( 'Jika ingin membuat halaman "Shop" yang menarik dengan page builder, silahkan BUAT HALAMAN BARU, bukan dengan cara edit halaman ini.', 'landingpress-wp' ) ) . '</p>';
			echo '</div>';
		}
	}
	else {
		echo '<div class="notice notice-error">';
		echo '<p>' . sprintf( wp_kses_post( __( 'Halaman "Shop" utama dari WooCommerce belum di-setup, WooCommerce tidak akan dapat berjalan dengan baik. <a href="%s">Create default WooCommerce pages</a>.', 'landingpress-wp' ) ), admin_url( 'admin.php?page=wc-status&tab=tools' ) ) . '</p>';
		echo '</div>';
	}
	$cart_page_id = wc_get_page_id( 'cart' );
	if ( $cart_page_id > 0 ) {
		if ( $post && absint( $cart_page_id ) === absint( $post->ID ) ) {
			echo '<div class="notice notice-warning">';
			echo '<p>' . wp_kses_post( __( 'Halaman ini adalah halaman "Cart" utama dari WooCommerce.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( '<strong>Halaman ini sebaiknya JANGAN diedit dengan page builder</strong>, termasuk Elementor, karena dapat memperlambat halaman "Cart" itu sendiri.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( 'Dan pastikan shortcode <code>[woocommerce_cart]</code> terpasang di halaman ini supaya halaman "Cart" berfungsi dengan baik.', 'landingpress-wp' ) ) . '</p>';
			echo '</div>';
		}
	}
	else {
		echo '<div class="notice notice-error">';
		echo '<p>' . sprintf( wp_kses_post( __( 'Halaman "Cart" utama dari WooCommerce belum di-setup, WooCommerce tidak akan dapat berjalan dengan baik. <a href="%s">Create default WooCommerce pages</a>.', 'landingpress-wp' ) ), admin_url( 'admin.php?page=wc-status&tab=tools' ) ) . '</p>';
		echo '</div>';
	}
	$checkout_page_id = wc_get_page_id( 'checkout' );
	if ( $checkout_page_id > 0 ) {
		if ( $post && absint( $checkout_page_id ) === absint( $post->ID ) ) {
			echo '<div class="notice notice-warning">';
			echo '<p>' . wp_kses_post( __( 'Halaman ini adalah halaman "Checkout" utama dari WooCommerce.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( '<strong>Halaman ini sebaiknya JANGAN diedit dengan page builder</strong>, termasuk Elementor, karena dapat memperlambat halaman "Checkout" itu sendiri.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( 'Dan pastikan shortcode <code>[woocommerce_checkout]</code> terpasang di halaman ini supaya halaman "Checkout" berfungsi dengan baik.', 'landingpress-wp' ) ) . '</p>';
			echo '</div>';
		}
	}
	else {
		echo '<div class="notice notice-error">';
		echo '<p>' . sprintf( wp_kses_post( __( 'Halaman "Checkout" utama dari WooCommerce belum di-setup, WooCommerce tidak akan dapat berjalan dengan baik. <a href="%s">Create default WooCommerce pages</a>.', 'landingpress-wp' ) ), admin_url( 'admin.php?page=wc-status&tab=tools' ) ) . '</p>';
		echo '</div>';
	}
	$myaccount_page_id = wc_get_page_id( 'myaccount' );
	if ( $myaccount_page_id > 0 ) {
		if ( $post && absint( $myaccount_page_id ) === absint( $post->ID ) ) {
			echo '<div class="notice notice-warning">';
			echo '<p>' . wp_kses_post( __( 'Halaman ini adalah halaman "My Account" utama dari WooCommerce.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( '<strong>Halaman ini sebaiknya JANGAN diedit dengan page builder</strong>, termasuk Elementor, karena dapat memperlambat halaman "My Account" itu sendiri.', 'landingpress-wp' ) ) . '</p>';
			echo '<p>' . wp_kses_post( __( 'Dan pastikan shortcode <code>[woocommerce_my_account]</code> terpasang di halaman ini supaya halaman "My Account" berfungsi dengan baik.', 'landingpress-wp' ) ) . '</p>';
			echo '</div>';
		}
	}
	else {
		echo '<div class="notice notice-error">';
		echo '<p>' . sprintf( wp_kses_post( __( 'Halaman "My Account" utama dari WooCommerce belum di-setup, WooCommerce tidak akan dapat berjalan dengan baik. <a href="%s">Create default WooCommerce pages</a>.', 'landingpress-wp' ) ), admin_url( 'admin.php?page=wc-status&tab=tools' ) ) . '</p>';
		echo '</div>';
	}
}
