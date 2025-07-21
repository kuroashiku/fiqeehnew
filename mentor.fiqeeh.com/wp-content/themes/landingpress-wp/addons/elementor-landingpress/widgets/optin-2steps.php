<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Optin_2steps extends Widget_Base {

	public function get_name() {
		return 'optin_2steps';
	}

	public function get_title() {
		return __( 'LP - 2 Steps Opt-in Form / Opt-in Popup', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
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
			'section_optin_description',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Anda bisa menggunakan widget ini untuk memasukkan kode HTML opt-in form dari pihak ketiga dalam mode <strong><u>tanpa styling (raw)</u></strong>, sehingga bisa kita styling (percantik) di sini.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Namun, jika Anda mempunyai kode HTML opt-in form dari pihak ketiga dengan styling tersendiri, jangan gunakan widget ini, langsung gunakan widget <strong><u>HTML</u></strong> saja.', 'landingpress-wp' );

		$this->add_control(
			'optin_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin',
			[
				'label' => __( 'Opt-in Form Popup', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_heading',
			[
				'label' => __( 'Heading', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '2',
				'default' => __( 'Title on your opt-in popup', 'landingpress-wp' ),
				'placeholder' => __( 'Title on your opt-in popup', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_subheading',
			[
				'label' => __( 'Subheading', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '2',
				'default' => '',
				'placeholder' => __( 'Description on your opt-in popup', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin',
			[
				'label' => __( 'Opt-in Form Code', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => __( 'Enter your optin form code here', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_display',
			[
				'label' => __( 'Form Display', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'default' => __( 'Default', 'landingpress-wp' ),
					'fullwidth' => __( 'Full Width', 'landingpress-wp' ),
					'inline' => __( 'Inline', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'optin_button_width',
			[
				'label' => __( 'Form Button Width', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'default' => __( 'Default', 'landingpress-wp' ),
					'input' => __( 'Input Width', 'landingpress-wp' ),
				],
			]
		);

		$this->end_controls_section();

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

		$selector = '.elementor-popup-form-popup';

		$this->start_controls_section(
			'section_optin_style',
			[
				'label' => __( 'Popup Container', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_container_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'optin_container_close_color',
			[
				'label' => __( 'Popup Close Icon Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_label_style',
			[
				'label' => __( 'Popup Label (If Available)', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_label_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'optin_label_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => $selector.' .elementor-lp-form-wrapper label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_input_style',
			[
				'label' => __( 'Popup Input', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_input_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'optin_input_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'optin_input_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'optin_input_border_radius',
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
			'optin_input_text_padding',
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
				'name' => 'optin_input_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => $selector.' .elementor-lp-form-wrapper input[type="text"], '.$selector.' .elementor-lp-form-wrapper input[type="email"], '.$selector.' .elementor-lp-form-wrapper textarea, '.$selector.' .elementor-lp-form-wrapper select',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_button_style',
			[
				'label' => __( 'Popup Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_optin_button_style' );

		$this->start_controls_tab(
			'tab_optin_button_normal',
			[
				'label' => __( 'Normal', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_button_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'optin_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => Global_Colors::COLOR_ACCENT,
			]
		);

		$this->add_control(
			'optin_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'optin_border_radius',
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
			'optin_text_padding',
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
			'tab_optin_button_hover',
			[
				'label' => __( 'Hover', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'optin_button_background_hover_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'optin_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'optin_hover_animation',
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
				'name' => 'optin_typography',
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
		$this->add_render_attribute( 'popup_wrapper', 'class', 'elementor-popup-form-popup' );

		$popup_style = '';

		$popup_wrapper_style = '';
		if (!empty($settings['optin_container_background_color'])) {
			$popup_wrapper_style .= 'background: '.$settings['optin_container_background_color'].' !important; ';
		}
		if (!empty($popup_wrapper_style)) {
			$popup_style .= '#'.$selector.' {'.$popup_wrapper_style.'}';
		}

		$popup_close_style = '';
		if (!empty($settings['optin_container_close_color'])) {
			$popup_close_style .= 'color: '.$settings['optin_container_close_color'].' !important; ';
		}
		if (!empty($popup_close_style)) {
			$popup_style .= '#'.$selector.' .mfp-close {'.$popup_close_style.'}';
		}

		$popup_label_style = '';
		if (!empty($settings['optin_label_text_color'])) {
			$popup_label_style .= 'color: '.$settings['optin_label_text_color'].' !important; ';
		}
		if (!empty($popup_label_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper label {'.$popup_label_style.'}';
		}

		$popup_input_style = '';
		if (!empty($settings['optin_input_text_color'])) {
			$popup_input_style .= 'color: '.$settings['optin_input_text_color'].' !important; ';
		}
		if (!empty($settings['optin_input_background_color'])) {
			$popup_input_style .= 'background: '.$settings['optin_input_background_color'].' !important; ';
		}
		if (!empty($settings['optin_input_border_color'])) {
			$popup_input_style .= 'border: 1px solid '.$settings['optin_input_border_color'].' !important; ';
		}
		if (!empty($popup_input_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper input[type="text"], #'.$selector.' .elementor-lp-form-wrapper input[type="email"], #'.$selector.' .elementor-lp-form-wrapper textarea, #'.$selector.' .elementor-lp-form-wrapper select {'.$popup_input_style.'}';
		}

		$popup_button_style = '';
		if (!empty($settings['optin_button_text_color'])) {
			$popup_button_style .= 'color: '.$settings['optin_button_text_color'].' !important; ';
		}
		if (!empty($settings['optin_background_color'])) {
			$popup_button_style .= 'background: '.$settings['optin_background_color'].' !important; ';
		} else {
			$popup_button_style .= 'background: '.Global_Colors::COLOR_ACCENT.' !important; ';
		}
		if (!empty($settings['optin_border_color'])) {
			$popup_button_style .= 'border: 1px solid '.$settings['optin_border_color'].' !important; ';
		}
		if (!empty($popup_button_style)) {
			$popup_style .= '#'.$selector.' .elementor-lp-form-wrapper input[type="submit"], #'.$selector.' .elementor-lp-form-wrapper button {'.$popup_button_style.'}';
		}

		$popup_button_hover_style = '';
		if (!empty($settings['optin_hover_color'])) {
			$popup_button_hover_style .= 'color: '.$settings['optin_hover_color'].' !important; ';
		}
		if (!empty($settings['optin_button_background_hover_color'])) {
			$popup_button_hover_style .= 'background: '.$settings['optin_button_background_hover_color'].' !important; ';
		}
		if (!empty($settings['optin_button_hover_border_color'])) {
			$popup_button_hover_style .= 'border: 1px solid '.$settings['optin_button_hover_border_color'].' !important; ';
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

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon' );

		$this->add_render_attribute( 'optin_wrapper', 'class', 'elementor-lp-form-wrapper' );
		if ( ! empty( $settings['optin_display'] ) ) {
			$this->add_render_attribute( 'optin_wrapper', 'class', 'elementor-lp-form-display-' . $settings['optin_display'] );
		}
		if ( ! empty( $settings['optin_button_width'] ) ) {
			$this->add_render_attribute( 'optin_wrapper', 'class', 'elementor-button-width-' . $settings['optin_button_width'] );
		}

		$optin = $settings['optin'];
		if ( $optin ) {
			$optin = preg_replace( '@<(script|style|noscript)[^>]*?>.*?</\\1>@si', '', $optin );
			if ( strpos( $optin, 'kirimemail' ) !== false ) {
				$optin = str_replace( array( '<link rel="stylesheet" media="all" href="https://aplikasi.kirim.email/assets/css/form.css" />', 'col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2' ), '', $optin );
				echo '
				<style>
					.elementor-lp-form-wrapper .footnote {
						margin:20px 0 0;
						padding:0;
						font-size:12px;
					}
					.elementor-lp-form-wrapper .kirimemail-form-headline {
						margin:0;
						padding:0;
					}
					.elementor-lp-form-wrapper .kirimemail-form-description {
						margin:0 0 20px;
						padding:0;
					}
				</style>';
			}
		}

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
			<div <?php echo $this->get_render_attribute_string( 'optin_wrapper' ); ?>>
				<?php if ( ! empty( $settings['optin_heading'] ) ) : ?>
					<h2><?php echo $settings['optin_heading']; ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $settings['optin_subheading'] ) ) : ?>
					<p><?php echo $settings['optin_subheading']; ?></p>
				<?php endif; ?>
				<?php echo do_shortcode( $optin ); ?>
			</div>
		</div>
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
