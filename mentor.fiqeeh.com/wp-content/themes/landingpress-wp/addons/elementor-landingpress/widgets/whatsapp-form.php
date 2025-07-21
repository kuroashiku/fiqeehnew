<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Whatsapp_Form extends Widget_Base {

	public function get_name() {
		return 'lp_whatsapp_form';
	}

	public function get_title() {
		return __( 'LP - WhatsApp Form', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function register_controls() {

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

		$this->add_control(
			'form_width',
			[
				'label' => __( 'Form Width', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1600,
					],
				],
				'size_units' => [ 'px' ],
				'default' => [
					'size' => '300',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea, .elementor-lp-form-wrapper .contact-form input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper .contact-form input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper .contact-form textarea, {{WRAPPER}} .elementor-lp-form-wrapper.elementor-button-width-input input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper.elementor-button-width-input button' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_display' => [ 'default' ],
				],
				'show_label' => true,
				'separator' => 'none',
			]
		);

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
			'section_label_style',
			[
				'label' => __( 'Form Label (If Available)', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-lp-form-wrapper label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			[
				'label' => __( 'Form Input / Textarea', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea',
			]
		);

		$this->add_control(
			'input_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'input_border',
				'label' => __( 'Border', 'landingpress-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea',
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Form Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper button',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'landingpress-wp' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper button',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'landingpress-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-lp-form-wrapper button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-lp-form-wrapper button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-lp-form-wrapper button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animation', 'landingpress-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

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
}
