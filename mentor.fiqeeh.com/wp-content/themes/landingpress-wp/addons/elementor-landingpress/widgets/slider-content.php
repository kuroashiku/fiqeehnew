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

class LP_Slider_Content extends Widget_Base {

	public function get_name() {
		return 'lp_slider_content';
	}

	public function get_title() {
		return __( 'LP - Content Slider', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-slideshow';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_slider',
			[
				'label' => __( 'Slider Items', 'landingpress-wp' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'slider_heading',
			[
				'label' => __( 'Heading', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slider Heading', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_description',
			[
				'label' => __( 'Description', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_button',
			[
				'label' => __( 'Button', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Me', 'landingpress-wp' ),
			]
		);

		$repeater->add_control(
			'slider_link',
			[
				'label' => __( 'Link', 'landingpress-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'landingpress-wp' ),
			]
		);

		$repeater->add_control(
			'slider_image',
			[
				'label' => __( 'Image', 'landingpress-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'slider',
			[
				'label' => __( 'Slider Items', 'landingpress-wp' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'default' => [
					[
						'slider_heading' => __( 'Slider 1 Heading', 'landingpress-wp' ),
						'slider_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
						'slider_button' => __( 'Click Me', 'landingpress-wp' ),
						'slider_link' => '#',
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'slider_heading' => __( 'Slider 2 Heading', 'landingpress-wp' ),
						'slider_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
						'slider_button' => __( 'Click Me', 'landingpress-wp' ),
						'slider_link' => '#',
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'slider_heading' => __( 'Slider 3 Heading', 'landingpress-wp' ),
						'slider_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
						'slider_button' => __( 'Click Me', 'landingpress-wp' ),
						'slider_link' => '#',
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ slider_heading }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'adaptive_height',
			[
				'label' => __( 'Adaptive Height', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'landingpress-wp' ),
					'yes' => __( 'Yes', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'image_stretch',
			[
				'label' => __( 'Image Stretch', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'landingpress-wp' ),
					'yes' => __( 'Yes', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'dots',
				'options' => [
					'arrows' => __( 'Arrows', 'landingpress-wp' ),
					'dots' => __( 'Dots', 'landingpress-wp' ),
					'both' => __( 'Arrows and Dots', 'landingpress-wp' ),
					'none' => __( 'None', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'landingpress-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => __( 'Effect', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'landingpress-wp' ),
					'fade' => __( 'Fade', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Animation Speed', 'landingpress-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => __( 'Slide Heading', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_heading_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-slider-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slide_heading_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .lp-slider-heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Slide Description', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_description_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-slider-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slide_description_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .lp-slider-description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Slide Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_button_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button, {{WRAPPER}} .elementor-button.lp-slider-button:hover, {{WRAPPER}} .elementor-button.lp-slider-button:focus, {{WRAPPER}} .elementor-button.lp-slider-button:visited' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-button.lp-slider-button' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slide_button_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'selector' => '{{WRAPPER}} .elementor-button.lp-slider-button',
			]
		);

		$this->add_control(
			'slide_button_border_width',
			[
				'label' => __( 'Border Width', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slide_button_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'slide_button_tabs' );

		$this->start_controls_tab( 'slide_button_normal', [ 'label' => __( 'Normal', 'landingpress-wp' ) ] );

		$this->add_control(
			'slide_button_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button, {{WRAPPER}} .elementor-button.lp-slider-button:visited' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button, {{WRAPPER}} .elementor-button.lp-slider-button:visited' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button, {{WRAPPER}} .elementor-button.lp-slider-button:visited' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'slide_button_hover', [ 'label' => __( 'Hover', 'landingpress-wp' ) ] );

		$this->add_control(
			'slide_button_hover_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_hover_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.lp-slider-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'landingpress-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'inside' => __( 'Inside', 'landingpress-wp' ),
					'outside' => __( 'Outside', 'landingpress-wp' ),
				],
				'prefix_class' => 'elementor-arrows-position-',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'landingpress-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'outside' => __( 'Outside', 'landingpress-wp' ),
					'inside' => __( 'Inside', 'landingpress-wp' ),
				],
				'prefix_class' => 'elementor-pagination-position-',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['slider'] ) )
			return;

		$slides = [];
		foreach ( $settings['slider'] as $slider ) {
			$slide_left = '';
			if ( $slide_heading = $slider['slider_heading'] ) {
				$slide_left .= '<div class="lp-slider-heading">'.$slide_heading.'</div>';
			}
			if ( $slider_description = $slider['slider_description'] ) {
				$slide_left .= '<div class="lp-slider-description">'.$slider_description.'</div>';
			}
			if ( $slider_button = $slider['slider_button'] ) {
				$slide_link = $slider['slider_link']['url'] ? esc_url( $slider['slider_link']['url'] ) : '#';
				$slide_left .= '<a href="'.$slide_link.'" class="lp-slider-button elementor-button elementor-size-sm">'.$slider_button.'</a>';
			}
			if ( $slide_left ) {
				$slide_left = '<div class="lp-slider-content">'.$slide_left.'</div>';
			}
			$slide_right = '';
			if ( $slide_image = $slider['slider_image']['url'] ) {
				$slide_right .= '<img class="swiper-slide-image" src="' . esc_url( $slide_image ) . '" alt="" />';
			}
			$slides[] = '<div class="swiper-slide"><div class="swiper-slide-inner">
			<div class="elementor-section-content-middle elementor-reverse-mobile">
				<div class="elementor-container elementor-column-gap-no">
					<div class="elementor-row">
						<div class="elementor-column elementor-col-50">
							<div class="elementor-column-wrap">
								'.$slide_left.'
							</div>
						</div>
						<div class="elementor-column elementor-col-50">
							<div class="elementor-column-wrap">
								'.$slide_right.'
							</div>
						</div>
					</div>
				</div>
			</div>
			</div></div>';
		}

		if ( empty( $slides ) ) {
			return;
		}

		$direction = function_exists('is_rtl') && is_rtl() ? 'rtl' : 'ltr';

		$slider_classes = [ 'lp-slider', 'lp-slider-swiper', 'swiper-wrapper' ];

		$show_dots = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		if ( 'yes' === $settings['image_stretch'] ) {
			$slider_classes[] = 'swiper-image-stretch';
		}

		$slides_count = count( $slides );

		$slider_options = [
			'autoplaySpeed' => absint( $settings['autoplay_speed'] ),
			'autoplay' => ( 'no' !== $settings['autoplay'] ? true : false ),
			'infinite' => ( 'no' !== $settings['infinite'] ? true : false ),
			'pauseOnHover' => ( 'no' !== $settings['pause_on_hover'] ? true : false ),
			'speed' => absint( $settings['speed'] ),
			'arrows' => ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ? true : false ),
			'dots' => ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ? true : false ),
			'fade' => ( 'slide' !== $settings['effect'] ? true : false ),
			'adaptiveHeight' => ( 'no' !== $settings['adaptive_height'] ? true : false ),
			'rtl' => ( is_rtl() ? true : false ),
		];

		$this->add_render_attribute( 'slider', [
			'class' => implode( ' ', $slider_classes ),
			'data-slider_options' => wp_json_encode( $slider_options ),
		] );

		$this->add_render_attribute( 'slider_wrapper', [
			'class' => 'lp-slider-wrapper swiper-container',
			'dir' => $direction,
		] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'slider_wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
				<?php echo implode( '', $slides ); ?>
			</div>
			<?php if ( 1 < $slides_count ) : ?>
				<?php if ( $show_dots ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
				<?php if ( $show_arrows ) : ?>
					<div class="elementor-swiper-button elementor-swiper-button-prev">
						<i class="eicon-chevron-left" aria-hidden="true"></i>
						<span class="elementor-screen-only"><?php _e( 'Previous', 'landingpress-wp' ); ?></span>
					</div>
					<div class="elementor-swiper-button elementor-swiper-button-next">
						<i class="eicon-chevron-right" aria-hidden="true"></i>
						<span class="elementor-screen-only"><?php _e( 'Next', 'landingpress-wp' ); ?></span>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function content_template() {
	}
}
