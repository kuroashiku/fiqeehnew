<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Whatsapp_Popup extends Widget_Base {

	public function get_name() {
		return 'lp_whatsapp_popup';
	}

	public function get_title() {
		return __( 'LP - WhatsApp Form Popup / Lightbox', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	public function get_script_depends() {
		return [ 'magnific-popup' ];
	}

	public function get_style_depends() {
		return [ 'magnific-popup' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'landingpress-wp' ),
			'sm' => __( 'Small', 'landingpress-wp' ),
			'md' => __( 'Medium', 'landingpress-wp' ),
			'lg' => __( 'Large', 'landingpress-wp' ),
			'xl' => __( 'Extra Large', 'landingpress-wp' ),
		];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => __( 'Type', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'landingpress-wp' ),
					'info' => __( 'Info', 'landingpress-wp' ),
					'success' => __( 'Success', 'landingpress-wp' ),
					'warning' => __( 'Warning', 'landingpress-wp' ),
					'danger' => __( 'Danger', 'landingpress-wp' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click here', 'landingpress-wp' ),
				'placeholder' => __( 'Click here', 'landingpress-wp' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'landingpress-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'landingpress-wp' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'landingpress-wp' ),
					'right' => __( 'After', 'landingpress-wp' ),
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'landingpress-wp' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'landingpress-wp' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'landingpress-wp' ),
				'separator' => 'before',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form',
			[
				'label' => __( 'WhatsApp Form', 'landingpress-wp' ),
			]
		);

		$description = __( 'Widget ini <strong><u>tidak menyimpan data</u></strong> ke database supaya tetap fast loading.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Fokus widget ini adalah untuk pemain link WhatsApp yang ingin <strong><u>transisi</u></strong> ke form WhatsApp.', 'landingpress-wp' );

		$this->add_control(
			'important_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'phone',
			[
				'label' => __( 'Phone Number', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0812345678',
				'placeholder' => '0812345678',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'message',
			[
				'label' => __( 'Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '6',
				'default' => "Halo, saya ingin pesan %product% dengan data sebagai berikut: \nNama: %name% \nAlamat: %address% %extra% \nMohon segera diproses ya. \nTerimakasih.",
				'placeholder' => "Halo, saya ingin pesan %product% dengan data sebagai berikut: \nNama: %name% \nAlamat: %address% %extra% \nMohon segera diproses ya. \nTerimakasih.",
				'label_block' => true,
			]
		);

		$this->add_control(
			'message_params',
			[
				'raw' => __( 'Available parameters: <br/><strong><u>%product%, %name%, %address%, %extra%</u></strong>.', 'landingpress-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'whatsapp_method',
			[
				'label' => __( 'Method', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Link API WhatsApp', 'landingpress-wp' ),
					'deeplink' => __( 'Deeplink (Mobile Only)', 'landingpress-wp' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_display',
			[
				'label' => __( 'Form Display', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Boxed', 'landingpress-wp' ),
					'fullwidth' => __( 'Full Width', 'landingpress-wp' ),
				],
				'separator' => 'before',
			]
		);

		// $this->add_control(
		// 	'form_width',
		// 	[
		// 		'label' => __( 'Form Width', 'landingpress-wp' ),
		// 		'type' => Controls_Manager::SLIDER,
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 300,
		// 				'max' => 1600,
		// 			],
		// 		],
		// 		'size_units' => [ 'px' ],
		// 		'default' => [
		// 			'size' => '300',
		// 			'unit' => 'px',
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea, .elementor-lp-form-wrapper .contact-form input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper .contact-form input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper .contact-form textarea, {{WRAPPER}} .elementor-lp-form-wrapper.elementor-button-width-input input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper.elementor-button-width-input button' => 'min-width: {{SIZE}}{{UNIT}};',
		// 		],
		// 		'condition' => [
		// 			'form_display' => [ 'default' ],
		// 		],
		// 		'show_label' => true,
		// 		'separator' => 'none',
		// 	]
		// );

		$this->add_control(
			'form_labels',
			[
				'label' => __( 'Form Labels', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'landingpress-wp' ),
				'label_off' => __( 'Hide', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'form_placeholders',
			[
				'label' => __( 'Form Placeholders', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'landingpress-wp' ),
				'label_off' => __( 'Hide', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'field_product_label',
			[
				'label' => __( 'Product Title', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Produk', 'landingpress-wp' ),
				'placeholder' => __( 'Produk', 'landingpress-wp' ),
				'separator' => 'before',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label'			=> __( 'Product Name/Option', 'landingpress-wp' ),
				'type' 			=> Controls_Manager::TEXT,
				'placeholder' 	=> __( 'Product Name/Option', 'landingpress-wp' ),
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'product',
			[
				'label' 		=> __( 'Product Name/Option', 'landingpress-wp' ),
				'type' 			=> Controls_Manager::REPEATER,
				'show_label' 	=> true,
				'default' 		=> [
					[
						'name' 		=> 'Product 1, Option 1',
					],
					[
						'name' 		=> 'Product 2, Option 2',
					],
					[
						'name' 		=> 'Product 3, Option 3',
					],
				],
				'fields' 		=> $repeater->get_controls(),
				'title_field' 	=> '{{{ name }}}',
			]
		);

		$this->add_control(
			'product_position',
			[
				'label' => __( 'Product Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top' => 'Top',
					'bottom' => 'Bottom',
				],
			]
		);

		$this->add_control(
			'hide_product',
			[
				'label' => __( 'Hide Product', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'field_name_label',
			[
				'label' => __( 'Name Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Nama', 'landingpress-wp' ),
				'placeholder' => __( 'Nama', 'landingpress-wp' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_name_placeholder',
			[
				'label' => __( 'Name Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Nama', 'landingpress-wp' ),
				'placeholder' => __( 'Nama', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders' => 'yes',
				],
			]
		);

		$this->add_control(
			'field_address_label',
			[
				'label' => __( 'Address Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Alamat', 'landingpress-wp' ),
				'placeholder' => __( 'Alamat', 'landingpress-wp' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_address_placeholder',
			[
				'label' => __( 'Address Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Alamat', 'landingpress-wp' ),
				'placeholder' => __( 'Alamat', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders' => 'yes',
				],
			]
		);

		$this->add_control(
			'hide_address',
			[
				'label' => __( 'Hide Address', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'field_extra_label',
			[
				'label' => __( 'Extra Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Kecamatan', 'landingpress-wp' ),
				'placeholder' => __( 'Kecamatan', 'landingpress-wp' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_extra_placeholder',
			[
				'label' => __( 'Extra Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Kecamatan', 'landingpress-wp' ),
				'placeholder' => __( 'Kecamatan', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders' => 'yes',
				],
			]
		);

		$this->add_control(
			'hide_extra',
			[
				'label' => __( 'Hide Extra', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'field_submit_text',
			[
				'label' => __( 'Button Text', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Chat WhatsApp', 'landingpress-wp' ),
				'placeholder' => __( 'Chat WhatsApp', 'landingpress-wp' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_submit_align',
			[
				'label' => __( 'Button Alignment', 'landingpress-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-left',
					],
					'fullwidth' => [
						'title' => __( 'Justified', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-justify',
					],
					'right' => [
						'title' => __( 'Right', 'landingpress-wp' ),
						'icon' => 'eicon-text-align-right',
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'landingpress-wp' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.elementor-button:hover svg, {{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} a.elementor-button:focus svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'landingpress-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$selector = '.elementor-popup-form-whatsapp';

		$this->start_controls_section(
			'section_popup_style',
			[
				'label' => __( 'Popup Container', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'popup_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'popup_close_color',
			[
				'label' => __( 'Popup Close Icon Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_label_style',
			[
				'label' => __( 'Popup Label (If Available)', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'popup_label_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'popup_label_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => $selector.' .elementor-lp-form-wrapper label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_input_style',
			[
				'label' => __( 'Popup Input', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'popup_input_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'popup_input_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'popup_input_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'popup_input_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					$selector.' .elementor-lp-form-wrapper input[type="text"], '.$selector.' .elementor-lp-form-wrapper input[type="email"], '.$selector.' .elementor-lp-form-wrapper textarea, '.$selector.' .elementor-lp-form-wrapper select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'popup_input_text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					$selector.' .elementor-lp-form-wrapper input[type="text"], '.$selector.' .elementor-lp-form-wrapper input[type="email"], '.$selector.' .elementor-lp-form-wrapper textarea, '.$selector.' .elementor-lp-form-wrapper select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'popup_input_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => $selector.' .elementor-lp-form-wrapper input[type="text"], '.$selector.' .elementor-lp-form-wrapper input[type="email"], '.$selector.' .elementor-lp-form-wrapper textarea, '.$selector.' .elementor-lp-form-wrapper select',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_button_style',
			[
				'label' => __( 'Popup Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_popup_button_style' );

		$this->start_controls_tab(
			'tab_popup_button_normal',
			[
				'label' => __( 'Normal', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'popup_button_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'popup_button_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => Global_Colors::COLOR_ACCENT,
			]
		);

		$this->add_control(
			'popup_button_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'popup_button_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					$selector.' .elementor-lp-form-wrapper input[type="submit"], '.$selector.' .elementor-lp-form-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'popup_button_text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					$selector.' .elementor-lp-form-wrapper input[type="submit"], '.$selector.' .elementor-lp-form-wrapper button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_popup_button_hover',
			[
				'label' => __( 'Hover', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'popup_button_hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'popup_button_background_hover_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'popup_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'popup_button_hover_animation',
			[
				'label' => __( 'Animation', 'landingpress-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'popup_button_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => $selector.' .elementor-lp-form-wrapper input[type="submit"], '.$selector.' .elementor-lp-form-wrapper button',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$unique_id = $this->get_id();
		if (empty($unique_id) && function_exists('wp_generate_password')) {
			$unique_id = wp_generate_password(6, false, false);
		}

		$selector = 'elementor-popup-form-'.$unique_id;

		$this->add_render_attribute( 'popup_wrapper', 'id', $selector );
		$this->add_render_attribute( 'popup_wrapper', 'class', 'mfp-hide' );
		$this->add_render_attribute( 'popup_wrapper', 'class', 'elementor-popup-block-white' );
		$this->add_render_attribute( 'popup_wrapper', 'class', 'elementor-popup-form-whatsapp' );

		$popup_style = '';

		$popup_wrapper_style = '';
		if (!empty($settings['popup_background_color'])) {
			$popup_wrapper_style .= 'background: '.$settings['popup_background_color'].' !important; ';
		}
		if (!empty($popup_wrapper_style)) {
			$popup_style .= '#'.$selector.' {'.$popup_wrapper_style.'}';
		}

		$popup_close_style = '';
		if (!empty($settings['popup_close_color'])) {
			$popup_close_style .= 'color: '.$settings['popup_close_color'].' !important; ';
		}
		if (!empty($popup_close_style)) {
			$popup_style .= '#'.$selector.' .mfp-close {'.$popup_close_style.'}';
		}

		$popup_label_style = '';
		if (!empty($settings['popup_label_text_color'])) {
			$popup_label_style .= 'color: '.$settings['popup_label_text_color'].' !important; ';
		}
		if (!empty($popup_label_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper label {'.$popup_label_style.'}';
		}

		$popup_input_style = '';
		if (!empty($settings['popup_input_text_color'])) {
			$popup_input_style .= 'color: '.$settings['popup_input_text_color'].' !important; ';
		}
		if (!empty($settings['popup_input_background_color'])) {
			$popup_input_style .= 'background: '.$settings['popup_input_background_color'].' !important; ';
		}
		if (!empty($settings['popup_input_border_color'])) {
			$popup_input_style .= 'border: 1px solid '.$settings['popup_input_border_color'].' !important; ';
		}
		if (!empty($popup_input_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper input[type="text"], #'.$selector.' .elementor-lp-form-wrapper input[type="email"], #'.$selector.' .elementor-lp-form-wrapper textarea, #'.$selector.' .elementor-lp-form-wrapper select {'.$popup_input_style.'}';
		}

		$popup_button_style = '';
		if (!empty($settings['popup_button_text_color'])) {
			$popup_button_style .= 'color: '.$settings['popup_button_text_color'].' !important; ';
		}
		if (!empty($settings['popup_button_background_color'])) {
			$popup_button_style .= 'background: '.$settings['popup_button_background_color'].' !important; ';
		} else {
			$popup_button_style .= 'background: '.Global_Colors::COLOR_ACCENT.' !important; ';
		}
		if (!empty($settings['popup_button_border_color'])) {
			$popup_button_style .= 'border: 1px solid '.$settings['popup_button_border_color'].' !important; ';
		}
		if (!empty($popup_button_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper input[type="submit"], #'.$selector.' .elementor-lp-form-wrapper button {'.$popup_button_style.'}';
		}

		$popup_button_hover_style = '';
		if (!empty($settings['popup_button_hover_color'])) {
			$popup_button_hover_style .= 'color: '.$settings['popup_button_hover_color'].' !important; ';
		}
		if (!empty($settings['popup_button_background_hover_color'])) {
			$popup_button_hover_style .= 'background: '.$settings['popup_button_background_hover_color'].' !important; ';
		}
		if (!empty($settings['popup_button_hover_border_color'])) {
			$popup_button_hover_style .= 'border: 1px solid '.$settings['popup_button_hover_border_color'].' !important; ';
		}
		if (!empty($popup_button_hover_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper input[type="submit"]:hover, #'.$selector.' .elementor-lp-form-wrapper button:hover {'.$popup_button_hover_style.'}';
		}

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		// if ( ! empty( $settings['align'] ) ) {
		// 	$this->add_render_attribute( 'wrapper', 'class', 'elementor-align-' . $settings['align'] );
		// }

		$this->add_render_attribute( 'button', 'class', 'elementor-popup-with-form' );
		$this->add_render_attribute( 'button', 'href', '#'.$selector );
		$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( isset($settings['hover_animation']) && $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		if ( $settings['floating'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-sticky-' . $settings['floating'] );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon' );

		$labels_class = ! $settings['form_labels'] ? 'elementor-screen-only' : '';

		$this->add_render_attribute( 'form_wrapper', 'class', 'elementor-lp-form-wrapper' );
		if ( ! empty( $settings['form_display'] ) ) {
			$this->add_render_attribute( 'form_wrapper', 'class', 'elementor-lp-form-display-' . $settings['form_display'] );
		}
		if ( ! empty( $settings['field_submit_align'] ) ) {
			$this->add_render_attribute( 'form_wrapper', 'class', 'elementor-lp-form-button-align-' . $settings['field_submit_align'] );
		}

		$this->add_render_attribute( 'form', 'method', 'get' );
		$this->add_render_attribute( 'form', 'class', 'lp-form lp-whatsapp-form' );
		$this->add_render_attribute( 'form', 'id', 'lp-whatsapp-form-'.$this->get_id() );

		$field_product_id = 'lp-form-product-'.$this->get_id();
		$field_product_class = 'lp-form-product';
		$field_product_label = $settings['field_product_label'];
		$this->add_render_attribute( 'field_product', 'name', $field_product_class );
		$this->add_render_attribute( 'field_product', 'class', $field_product_class );
		$this->add_render_attribute( 'field_product', 'id', $field_product_id );
		if ( ! $settings['hide_product'] ) {
			$this->add_render_attribute( 'field_product_label', 'for', $field_product_id );
			$this->add_render_attribute( 'field_product_label', 'class', '' );
		}
		else {
			$this->add_render_attribute( 'field_product', 'type', 'hidden' );
			$this->add_render_attribute( 'field_product', 'value', 'produk' );
		}

		$field_name_id = 'lp-form-name-'.$this->get_id();
		$field_name_class = 'lp-form-name';
		$field_name_label = $settings['field_name_label'];
		$field_name_placeholder = $settings['form_placeholders'] ? $settings['field_name_placeholder'] : '';
		$field_name_value = '';
		$this->add_render_attribute( 'field_name_label', 'for', $field_name_id );
		$this->add_render_attribute( 'field_name_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_name', 'type', 'text' );
		$this->add_render_attribute( 'field_name', 'name', $field_name_class );
		$this->add_render_attribute( 'field_name', 'class', $field_name_class );
		$this->add_render_attribute( 'field_name', 'id', $field_name_id );
		$this->add_render_attribute( 'field_name', 'placeholder', $field_name_placeholder );
		$this->add_render_attribute( 'field_name', 'required', '1' );
		$this->add_render_attribute( 'field_name', 'value', $field_name_value );

		$field_address_id = 'lp-form-address-'.$this->get_id();
		$field_address_class = 'lp-form-address';
		$this->add_render_attribute( 'field_address', 'name', $field_address_class );
		$this->add_render_attribute( 'field_address', 'class', $field_address_class );
		$this->add_render_attribute( 'field_address', 'id', $field_address_id );
		if ( ! $settings['hide_address'] ) {
			$field_address_label = $settings['field_address_label'];
			$field_address_placeholder = $settings['form_placeholders'] ? $settings['field_address_placeholder'] : '';
			$field_address_value = '';
			$this->add_render_attribute( 'field_address_label', 'for', $field_address_id );
			$this->add_render_attribute( 'field_address_label', 'class', $labels_class );
			$this->add_render_attribute( 'field_address', 'rows', '4' );
			$this->add_render_attribute( 'field_address', 'placeholder', $field_address_placeholder );
			$this->add_render_attribute( 'field_address', 'required', '1' );
		}
		else {
			$this->add_render_attribute( 'field_address', 'type', 'hidden' );
			$this->add_render_attribute( 'field_address', 'value', 'hide' );
		}

		$field_extra_id = 'lp-form-extra-'.$this->get_id();
		$field_extra_class = 'lp-form-extra';
		$this->add_render_attribute( 'field_extra', 'name', $field_extra_class );
		$this->add_render_attribute( 'field_extra', 'class', $field_extra_class );
		$this->add_render_attribute( 'field_extra', 'id', $field_extra_id );
		if ( ! $settings['hide_extra'] ) {
			$field_extra_label = $settings['field_extra_label'];
			$field_extra_placeholder = $settings['form_placeholders'] ? $settings['field_extra_placeholder'] : '';
			$field_extra_value = '';
			$this->add_render_attribute( 'field_extra_label', 'for', $field_extra_id );
			$this->add_render_attribute( 'field_extra_label', 'class', $labels_class );
			$this->add_render_attribute( 'field_extra', 'type', 'text' );
			$this->add_render_attribute( 'field_extra', 'placeholder', $field_extra_placeholder );
			$this->add_render_attribute( 'field_extra', 'required', '1' );
			$this->add_render_attribute( 'field_extra', 'value', $field_extra_value );
		}
		else {
			$this->add_render_attribute( 'field_extra', 'type', 'hidden' );
			$this->add_render_attribute( 'field_extra', 'value', 'hide' );
		}

		$field_submit_text = $settings['field_submit_text'];
		if ( !$field_submit_text ) {
			$field_submit_text = __( 'Chat WhatsApp', 'landingpress-wp' );
		}

		$this->add_render_attribute( 'field_button', 'type', 'submit' );
		$this->add_render_attribute( 'field_button', 'class', 'lp-form-button' );

		if ( $settings['whatsapp_method'] !== 'deeplink' ) {
			$url = 'https://api.whatsapp.com/send';
		}
		else {
			$url = 'whatsapp://send';
		}

		$phone = trim( $settings['phone'] );
		$phone = preg_replace('/^8/','08', $phone);
		$phone = preg_replace('/[^0-9]/', '', $phone);
		$phone = preg_replace('/^620/','62', $phone);
		$phone = preg_replace('/^0/','62', $phone);

		$message = trim( $settings['message'] );

		$url = $url.'?phone='.esc_attr( $phone ).'&text='.rawurlencode( $message );

		$this->add_render_attribute( 'form', 'data-waurl', $url );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
<style type="text/css">
.mfp-bg,.mfp-wrap{position:fixed;left:0;top:0}.mfp-bg,.mfp-container,.mfp-wrap{height:100%;width:100%}.mfp-arrow:after,.mfp-arrow:before,.mfp-container:before,.mfp-figure:after{content:''}.mfp-bg{z-index:1042;overflow:hidden;background:#0b0b0b;opacity:.8}.mfp-wrap{z-index:1043;outline:0!important;-webkit-backface-visibility:hidden}.mfp-container{text-align:center;position:absolute;left:0;top:0;padding:0 8px;box-sizing:border-box}.mfp-container:before{display:inline-block;height:100%;vertical-align:middle}.mfp-align-top .mfp-container:before{display:none}.mfp-content{position:relative;display:inline-block;vertical-align:middle;margin:0 auto;text-align:left;z-index:1045}.mfp-ajax-holder .mfp-content,.mfp-inline-holder .mfp-content{width:100%;cursor:auto}.mfp-ajax-cur{cursor:progress}.mfp-zoom-out-cur,.mfp-zoom-out-cur .mfp-image-holder .mfp-close{cursor:-moz-zoom-out;cursor:-webkit-zoom-out;cursor:zoom-out}.mfp-zoom{cursor:pointer;cursor:-webkit-zoom-in;cursor:-moz-zoom-in;cursor:zoom-in}.mfp-auto-cursor .mfp-content{cursor:auto}.mfp-arrow,.mfp-close,.mfp-counter,.mfp-preloader{-webkit-user-select:none;-moz-user-select:none;user-select:none}.mfp-loading.mfp-figure{display:none}.mfp-hide{display:none!important}.mfp-preloader{color:#CCC;position:absolute;top:50%;width:auto;text-align:center;margin-top:-.8em;left:8px;right:8px;z-index:1044}.mfp-preloader a{color:#CCC}.mfp-close,.mfp-preloader a:hover{color:#FFF}.mfp-s-error .mfp-content,.mfp-s-ready .mfp-preloader{display:none}button.mfp-arrow,button.mfp-close{overflow:visible;cursor:pointer;background:0 0;border:0;-webkit-appearance:none;display:block;outline:0;padding:0;z-index:1046;box-shadow:none;touch-action:manipulation}.mfp-figure:after,.mfp-iframe-scaler iframe{box-shadow:0 0 8px rgba(0,0,0,.6);position:absolute;left:0}button::-moz-focus-inner{padding:0;border:0}.mfp-close{width:44px;height:44px;line-height:44px;position:absolute;right:0;top:0;text-decoration:none;text-align:center;opacity:.65;padding:0 0 18px 10px;font-style:normal;font-size:28px;font-family:Arial,Baskerville,monospace}.mfp-close:focus,.mfp-close:hover{opacity:1}.mfp-close:active{top:1px}.mfp-close-btn-in .mfp-close{color:#333}.mfp-iframe-holder .mfp-close,.mfp-image-holder .mfp-close{color:#FFF;right:-6px;text-align:right;padding-right:6px;width:100%}.mfp-counter{position:absolute;top:0;right:0;color:#CCC;font-size:12px;line-height:18px;white-space:nowrap}.mfp-figure,img.mfp-img{line-height:0}.mfp-arrow{position:absolute;opacity:.65;margin:-55px 0 0;top:50%;padding:0;width:90px;height:110px;-webkit-tap-highlight-color:transparent}.mfp-arrow:active{margin-top:-54px}.mfp-arrow:focus,.mfp-arrow:hover{opacity:1}.mfp-arrow:after,.mfp-arrow:before{display:block;width:0;height:0;position:absolute;left:0;top:0;margin-top:35px;margin-left:35px;border:inset transparent}.mfp-arrow:after{border-top-width:13px;border-bottom-width:13px;top:8px}.mfp-arrow:before{border-top-width:21px;border-bottom-width:21px;opacity:.7}.mfp-arrow-left{left:0}.mfp-arrow-left:after{border-right:17px solid #FFF;margin-left:31px}.mfp-arrow-left:before{margin-left:25px;border-right:27px solid #3F3F3F}.mfp-arrow-right{right:0}.mfp-arrow-right:after{border-left:17px solid #FFF;margin-left:39px}.mfp-arrow-right:before{border-left:27px solid #3F3F3F}.mfp-iframe-holder{padding-top:40px;padding-bottom:40px}.mfp-iframe-holder .mfp-content{line-height:0;width:100%;max-width:900px}.mfp-image-holder .mfp-content,img.mfp-img{max-width:100%}.mfp-iframe-holder .mfp-close{top:-40px}.mfp-iframe-scaler{width:100%;height:0;overflow:hidden;padding-top:56.25%}.mfp-iframe-scaler iframe{display:block;top:0;width:100%;height:100%;background:#000}.mfp-figure:after,img.mfp-img{width:auto;height:auto;display:block}img.mfp-img{box-sizing:border-box;padding:40px 0;margin:0 auto}.mfp-figure:after{top:40px;bottom:40px;right:0;z-index:-1;background:#444}.mfp-figure small{color:#BDBDBD;display:block;font-size:12px;line-height:14px}.mfp-figure figure{margin:0}.mfp-bottom-bar{margin-top:-36px;position:absolute;top:100%;left:0;width:100%;cursor:auto}.mfp-title{text-align:left;line-height:18px;color:#F3F3F3;word-wrap:break-word;padding-right:36px}.mfp-gallery .mfp-image-holder .mfp-figure{cursor:pointer}@media screen and (max-width:800px) and (orientation:landscape),screen and (max-height:300px){.mfp-img-mobile .mfp-image-holder{padding-left:0;padding-right:0}.mfp-img-mobile img.mfp-img{padding:0}.mfp-img-mobile .mfp-figure:after{top:0;bottom:0}.mfp-img-mobile .mfp-figure small{display:inline;margin-left:5px}.mfp-img-mobile .mfp-bottom-bar{background:rgba(0,0,0,.6);bottom:0;margin:0;top:auto;padding:3px 5px;position:fixed;box-sizing:border-box}.mfp-img-mobile .mfp-bottom-bar:empty{padding:0}.mfp-img-mobile .mfp-counter{right:5px;top:3px}.mfp-img-mobile .mfp-close{top:0;right:0;width:35px;height:35px;line-height:35px;background:rgba(0,0,0,.6);position:fixed;text-align:center;padding:0}}@media all and (max-width:900px){.mfp-arrow{-webkit-transform:scale(.75);transform:scale(.75)}.mfp-arrow-left{-webkit-transform-origin:0;transform-origin:0}.mfp-arrow-right{-webkit-transform-origin:100%;transform-origin:100%}.mfp-container{padding-left:6px;padding-right:6px}}		
</style>
<?php endif; ?>
		<div <?php echo $this->get_render_attribute_string( 'popup_wrapper' ); ?>>
			<?php if (!empty($popup_style)) : ?>
				<style type="text/css"><?php echo $popup_style; ?></style>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'form_wrapper' ); ?>>
				<form  <?php echo $this->get_render_attribute_string( 'form' ); ?>>
					<div class="lp-form-fields-wrapper">
						<?php if ( ! $settings['hide_product'] && $settings['product_position'] != 'bottom' ) : ?>
						<div class="lp-form-field-product">
							<label <?php echo $this->get_render_attribute_string( 'field_product_label' ); ?>>
								<?php echo $field_product_label; ?>
							</label>
							<?php if ( ! empty( $settings['product'] ) ) : $i = 0; ?>
								<select <?php echo $this->get_render_attribute_string( 'field_product' ); ?>>
									<?php foreach ( $settings['product'] as $product ) : $i++; ?>
										<option value="<?php echo $product['name']; ?>" <?php if ($i==1) echo 'selected="selected"'; ?>><?php echo $product['name']; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						</div>
						<?php endif; ?>
						<div class="lp-form-field-name">
							<label <?php echo $this->get_render_attribute_string( 'field_name_label' ); ?>>
								<?php echo $field_name_label; ?>
							</label>
							<input <?php echo $this->get_render_attribute_string( 'field_name' ); ?>>
						</div>
						<?php if ( ! $settings['hide_address'] ) : ?>
						<div class="lp-form-field-address">
							<label <?php echo $this->get_render_attribute_string( 'field_address_label' ); ?>>
								<?php echo $field_address_label; ?>
							</label>
							<textarea <?php echo $this->get_render_attribute_string( 'field_address' ); ?>><?php echo $field_address_value; ?></textarea>
						</div>
						<?php else : ?>
							<input <?php echo $this->get_render_attribute_string( 'field_address' ); ?>>
						<?php endif; ?>
						<?php if ( ! $settings['hide_extra'] ) : ?>
						<div class="lp-form-field-extra">
							<label <?php echo $this->get_render_attribute_string( 'field_extra_label' ); ?>>
								<?php echo $field_extra_label; ?>
							</label>
							<input <?php echo $this->get_render_attribute_string( 'field_extra' ); ?>>
						</div>
						<?php else : ?>
							<input <?php echo $this->get_render_attribute_string( 'field_extra' ); ?>>
						<?php endif; ?>
						<?php if ( ! $settings['hide_product'] && $settings['product_position'] == 'bottom' ) : ?>
						<div class="lp-form-field-product">
							<label <?php echo $this->get_render_attribute_string( 'field_product_label' ); ?>>
								<?php echo $field_product_label; ?>
							</label>
							<?php if ( ! empty( $settings['product'] ) ) : $i = 0; ?>
								<select <?php echo $this->get_render_attribute_string( 'field_product' ); ?>>
									<?php foreach ( $settings['product'] as $product ) : $i++; ?>
										<option value="<?php echo $product['name']; ?>" <?php if ($i==1) echo 'selected="selected"'; ?>><?php echo $product['name']; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						</div>
						<?php endif; ?>
						<?php if ( $settings['hide_product'] ) : ?>
							<input <?php echo $this->get_render_attribute_string( 'field_product' ); ?>>
						<?php endif; ?>
						<div class="lp-form-field-submit">
							<button <?php echo $this->get_render_attribute_string( 'field_button' ); ?>>
								<?php echo $field_submit_text; ?>
							</button>
						</div>
					</div>
				</form>		
			</div>
		</div>
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var wa_form = document.getElementById('lp-whatsapp-form-<?php echo $this->get_id(); ?>');
    wa_form.addEventListener('submit', function(event) {
      event.preventDefault();
      event.stopPropagation();
    }, false);
  }, false);
})();
</script>
		<?php 
	}

	protected function content_template() {
	}

	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		if ( ! $is_new && empty( $settings['icon_align'] ) ) {
			// @todo: remove when deprecated
			// added as bc in 2.6
			//old default
			$settings['icon_align'] = $this->get_settings( 'icon_align' );
		}

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
		</span>
		<?php
	}

	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
	}
}
