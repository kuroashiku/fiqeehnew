<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Optin extends Widget_Base {

	public function get_name() {
		return 'optin';
	}

	public function get_title() {
		return __( 'LP - Opt-in Form', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	public function get_categories() {
		return [ 'landingpress' ];
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
				'label' => __( 'Opt-in Form', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin',
			[
				'label' => __( 'Opt-in Form Code', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => __( 'Enter your optin form code here', 'landingpress-wp' ),
				'show_label' => true,
			]
		);

		$this->add_control(
			'optin_display',
			[
				'label' => __( 'Display', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'landingpress-wp' ),
					'fullwidth' => __( 'Full Width', 'landingpress-wp' ),
					'inline' => __( 'Inline', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'optin_width',
			[
				'label' => __( 'Opt-in Width', 'landingpress-wp' ),
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
					'optin_display' => [ 'default' ],
				],
				'show_label' => true,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'button_width',
			[
				'label' => __( 'Button Width', 'landingpress-wp' ),
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
			'section_label_style',
			[
				'label' => __( 'Opt-in Label (If Available)', 'landingpress-wp' ),
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
				'label' => __( 'Opt-in Input', 'landingpress-wp' ),
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
				'label' => __( 'Opt-in Button', 'landingpress-wp' ),
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

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-wrapper' );
		if ( ! empty( $settings['optin_display'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-display-' . $settings['optin_display'] );
		}
		if ( ! empty( $settings['button_width'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-width-' . $settings['button_width'] );
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
			<?php echo do_shortcode( $optin ); ?>
		</div>
		<?php 
	}

	protected function content_template() {
	}
}
