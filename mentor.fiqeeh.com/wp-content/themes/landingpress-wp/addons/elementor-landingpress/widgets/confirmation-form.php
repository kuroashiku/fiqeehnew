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

class LP_Confirmation_Form extends Widget_Base {

	public function get_name() {
		return 'lp_confirmation_form';
	}

	public function get_title() {
		return __( 'LP - Payment Confirmation Form', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_important_description',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Widget ini akan mengirimkan data yang masuk ke email di bawah ini, tanpa menyimpannya di database website. Jangan lupa untuk melakukan testing di form ini untuk memastikan bahwa Anda <strong><u>bisa menerima email</u></strong> dari form ini.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika Anda mendapatkan pesan <strong><u>"technical error"</u></strong> ketika Anda melakukan testing di form ini, itu berarti ada masalah sehingga hosting tidak dapat mengirimkan email dari website Anda. Solusinya ada dua, yaitu: 1) hubungi support hosting 2) gunakan SMTP / API dari pihak ketiga untuk mengirim email dari website.', 'landingpress-wp' );

		$this->add_control(
			'important_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'form_email_to',
			[
				'label' => __( 'Email To', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => get_option( 'admin_email' ),
				'placeholder' => get_option( 'admin_email' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_email_subject',
			[
				'label' => __( 'Email Subject', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => sprintf( __( 'New payment confirmation from "%s" website', 'landingpress-wp' ), get_option( 'blogname' ) ),
				'placeholder' => sprintf( __( 'New payment confirmation from "%s" website', 'landingpress-wp' ), get_option( 'blogname' ) ),
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$description2 = __( 'Jika ingin menyimpan data yang masuk ke dalam database, untuk berjaga-jaga jika email di website bermasalah misalnya, silahkan install plugin tambahan yaitu <strong><u>Contact Form DB</u></strong> melalui menu <strong><u>LandingPress - Install Plugin</u></strong>', 'landingpress-wp' );

		$this->add_control(
			'important_description2',
			[
				'raw' => $description2,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form',
			[
				'label' => __( 'Payment Confirmation Form', 'landingpress-wp' ),
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
					'{{WRAPPER}} .elementor-lp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper textarea, .elementor-lp-form-wrapper .contact-form input[type="text"], {{WRAPPER}} .elementor-lp-form-wrapper .contact-form input[type="email"], {{WRAPPER}} .elementor-lp-form-wrapper .contact-form textarea, {{WRAPPER}} .elementor-lp-form-wrapper.elementor-button-width-input input[type="submit"], {{WRAPPER}} .elementor-lp-form-wrapper.elementor-button-width-input button, {{WRAPPER}} .elementor-lp-form-wrapper.elementor-lp-form-button-align-fullwidth button' => 'min-width: {{SIZE}}{{UNIT}};',
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
			'form_email_success',
			[
				'label' => __( 'Success Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your payment confirmation was successfully sent.', 'landingpress-wp' ),
				'placeholder' => __( 'Your payment confirmation was successfully sent.', 'landingpress-wp' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_email_invalid',
			[
				'label' => __( 'Validation Error Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'There were one or more errors while submitting the payment confirmation form.', 'landingpress-wp' ),
				'placeholder' => __( 'There were one or more errors while submitting the payment confirmation form.', 'landingpress-wp' ),
				'label_block' => true,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'form_email_error',
			[
				'label' => __( 'Technical Error Message (NOT SENT)', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'There were technical error while submitting the payment confirmation form. Sorry for the inconvenience.', 'landingpress-wp' ),
				'placeholder' => __( 'There were technical error while submitting payment confirmation the form. Sorry for the inconvenience.', 'landingpress-wp' ),
				'label_block' => true,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'form_redirect',
			[
				'label' => __( 'Redirect URL', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 'http://',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_order',
			[
				'label' => __( 'Your Order ID #', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'form_order_show',
			[
				'label' => __( 'Show', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'landingpress-wp' ),
				'label_off' => __( 'Hide', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'field_order_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Order ID #', 'landingpress-wp' ),
				'placeholder' => __( 'Your Order ID #', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_order_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Order ID #', 'landingpress-wp' ),
				'placeholder' => __( 'Your Order ID #', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		// $this->add_control(
		// 	'field_order_invalid',
		// 	[
		// 		'label' => __( 'Invalid Message', 'landingpress-wp' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => __( 'Please enter order ID', 'landingpress-wp' ),
		// 		'placeholder' => __( 'Please enter order ID', 'landingpress-wp' ),
		// 		'label_block' => true,
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_name',
			[
				'label' => __( 'Your Name', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_name_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Name', 'landingpress-wp' ),
				'placeholder' => __( 'Your Name', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_name_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Name', 'landingpress-wp' ),
				'placeholder' => __( 'Your Name', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		$this->add_control(
			'field_name_invalid',
			[
				'label' => __( 'Invalid Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Please enter your name', 'landingpress-wp' ),
				'placeholder' => __( 'Please enter your name', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_phone',
			[
				'label' => __( 'Your Phone', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'form_phone_show',
			[
				'label' => __( 'Show', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'landingpress-wp' ),
				'label_off' => __( 'Hide', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'field_phone_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Phone Number', 'landingpress-wp' ),
				'placeholder' => __( 'Your Phone Number', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_phone_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Phone Number', 'landingpress-wp' ),
				'placeholder' => __( 'Your Phone Number', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		$this->add_control(
			'field_phone_invalid',
			[
				'label' => __( 'Invalid Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Please enter your phone number', 'landingpress-wp' ),
				'placeholder' => __( 'Please enter your phone number', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_email',
			[
				'label' => __( 'Your Email', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'form_email_show',
			[
				'label' => __( 'Show', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'landingpress-wp' ),
				'label_off' => __( 'Hide', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'field_email_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Email', 'landingpress-wp' ),
				'placeholder' => __( 'Your Email', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_email_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Your Email', 'landingpress-wp' ),
				'placeholder' => __( 'Your Email', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		$this->add_control(
			'field_email_invalid',
			[
				'label' => __( 'Invalid Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Please enter your valid email address', 'landingpress-wp' ),
				'placeholder' => __( 'Please enter your valid email address', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_bank',
			[
				'label' => __( 'Bank', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_bank_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Bank', 'landingpress-wp' ),
				'placeholder' => __( 'Bank', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_bank_choices',
			[
				'label' => __( 'Choices (separated by comma)', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Mandiri,BCA,BNI,BRI', 'landingpress-wp' ),
				'placeholder' => __( 'Mandiri,BCA,BNI,BRI', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_date',
			[
				'label' => __( 'Date Of Transfer', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_date_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Date Of Transfer', 'landingpress-wp' ),
				'placeholder' => __( 'Date Of Transfer', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_date_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Date Of Transfer', 'landingpress-wp' ),
				'placeholder' => __( 'Date Of Transfer', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		$this->add_control(
			'field_date_invalid',
			[
				'label' => __( 'Invalid Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Please enter your date of transfer', 'landingpress-wp' ),
				'placeholder' => __( 'Please enter your date of transfer', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_amount',
			[
				'label' => __( 'Amount Of Transfer', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_amount_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Amount Of Transfer', 'landingpress-wp' ),
				'placeholder' => __( 'Amount Of Transfer', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_amount_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Amount Of Transfer', 'landingpress-wp' ),
				'placeholder' => __( 'Amount Of Transfer', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		$this->add_control(
			'field_amount_invalid',
			[
				'label' => __( 'Invalid Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Please enter your amount of transfer', 'landingpress-wp' ),
				'placeholder' => __( 'Please enter your amount of transfer', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_prof',
			[
				'label' => __( 'Proof of Payment', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_proof_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Proof of Payment', 'landingpress-wp' ),
				'placeholder' => __( 'Proof of Payment', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_proof_invalid',
			[
				'label' => __( 'Invalid Message', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Please upload your proof of payment', 'landingpress-wp' ),
				'placeholder' => __( 'Please upload your proof of payment', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_notes',
			[
				'label' => __( 'Notes', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_notes_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Notes', 'landingpress-wp' ),
				'placeholder' => __( 'Notes', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_notes_placeholder',
			[
				'label' => __( 'Placeholder', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Notes', 'landingpress-wp' ),
				'placeholder' => __( 'Notes', 'landingpress-wp' ),
				'condition' => [
					'form_placeholders!' => '',
				],
			]
		);

		// $this->add_control(
		// 	'field_notes_invalid',
		// 	[
		// 		'label' => __( 'Invalid Message', 'landingpress-wp' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => __( 'Please enter your message', 'landingpress-wp' ),
		// 		'placeholder' => __( 'Please enter your message', 'landingpress-wp' ),
		// 		'label_block' => true,
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_submit',
			[
				'label' => __( 'Submit Button', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_submit_text',
			[
				'label' => __( 'Text', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Submit', 'landingpress-wp' ),
				'placeholder' => __( 'Submit', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'field_submit_align',
			[
				'label' => __( 'Alignment', 'landingpress-wp' ),
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

	protected function upload_proof( $post_id = '', $attachment_post_data = array() ) {
		// Make sure the right files were submitted
		if (
			empty( $_FILES )
			|| ! isset( $_FILES['lp-form-proof'] )
			|| isset( $_FILES['lp-form-proof']['error'] ) && 0 !== $_FILES['lp-form-proof']['error']
		) {
			return;
		}

		// Filter out empty array values
		$files = array_filter( $_FILES['lp-form-proof'] );

		// Make sure files were submitted at all
		if ( empty( $files ) ) {
			return;
		}

		// Make sure to include the WordPress media uploader API if it's not (front-end)
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
		}

		// Upload the file and send back the attachment post ID
		return media_handle_upload( 'lp-form-proof', $post_id, $attachment_post_data );
	}

	protected function render() {
		$settings = $this->get_settings();

		$form_email_success = __( 'Your payment confirmation was successfully sent.', 'landingpress-wp' );
		if ( trim( $settings['form_email_success'] ) ) {
			$form_email_success = $settings['form_email_success'];
		}

		$form_email_error = __( 'There were technical error while submitting the payment confirmation form. Sorry for the inconvenience.', 'landingpress-wp' );
		if ( trim( $settings['form_email_error'] ) ) {
			$form_email_error = $settings['form_email_error'];
		}

		$form_email_invalid = __( 'There were one or more errors while submitting the payment confirmation form.', 'landingpress-wp' );
		if ( trim( $settings['form_email_invalid'] ) ) {
			$form_email_invalid = $settings['form_email_invalid'];
		}

		$labels_class = ! $settings['form_labels'] ? 'elementor-screen-only' : '';

		$field_order_label = $settings['field_order_label'];
		$field_order_placeholder = $settings['form_placeholders'] ? $settings['field_order_placeholder'] : '';
		$field_order_invalid = isset($settings['field_order_invalid']) && $settings['field_order_invalid'] ? $settings['field_order_invalid'] : __( 'Please enter your order ID', 'landingpress-wp' );
		$field_order_invalid_status = false;
		$field_order_value = '';

		$field_name_label = $settings['field_name_label'];
		$field_name_placeholder = $settings['form_placeholders'] ? $settings['field_name_placeholder'] : '';
		$field_name_invalid = $settings['field_name_invalid'] ? $settings['field_name_invalid'] : __( 'Please enter your name', 'landingpress-wp' );
		$field_name_invalid_status = false;
		$field_name_value = '';

		$field_phone_label = $settings['field_phone_label'];
		$field_phone_placeholder = $settings['form_placeholders'] ? $settings['field_phone_placeholder'] : '';
		$field_phone_invalid = $settings['field_phone_invalid'] ? $settings['field_phone_invalid'] : __( 'Please enter your phone number', 'landingpress-wp' );
		$field_phone_invalid_status = false;
		$field_phone_value = '';

		$field_email_label = $settings['field_email_label'];
		$field_email_placeholder = $settings['form_placeholders'] ? $settings['field_email_placeholder'] : '';
		$field_email_invalid = $settings['field_email_invalid'] ? $settings['field_email_invalid'] : __( 'Please enter your valid email address', 'landingpress-wp' );
		$field_email_invalid_status = false;
		$field_email_value = '';

		$field_bank_label = $settings['field_bank_label'];
		// $field_bank_placeholder = $settings['form_placeholders'] ? $settings['field_bank_placeholder'] : '';
		$field_bank_invalid = isset( $settings['field_bank_invalid'] ) && $settings['field_bank_invalid'] ? $settings['field_bank_invalid'] : __( 'Please enter your bank of payment', 'landingpress-wp' );
		$field_bank_invalid_status = false;
		$field_bank_value = '';
		$field_bank_choices = trim( $settings['field_bank_choices'] ) ? explode( ',', $settings['field_bank_choices'] ) : array('Mandiri','BCA','BNI','BRI');

		$field_date_label = $settings['field_date_label'];
		$field_date_placeholder = $settings['form_placeholders'] ? $settings['field_date_placeholder'] : '';
		$field_date_invalid = $settings['field_date_invalid'] ? $settings['field_date_invalid'] : __( 'Please enter your date of transfer', 'landingpress-wp' );
		$field_date_invalid_status = false;
		$field_date_value = '';

		$field_amount_label = $settings['field_amount_label'];
		$field_amount_placeholder = $settings['form_placeholders'] ? $settings['field_amount_placeholder'] : '';
		$field_amount_invalid = $settings['field_amount_invalid'] ? $settings['field_amount_invalid'] : __( 'Please enter your amount of transfer', 'landingpress-wp' );
		$field_amount_invalid_status = false;
		$field_amount_value = '';

		$field_proof_label = $settings['field_proof_label'];
		// $field_proof_placeholder = $settings['form_placeholders'] ? $settings['field_proof_placeholder'] : '';
		$field_proof_invalid = $settings['field_proof_invalid'] ? $settings['field_proof_invalid'] : __( 'Please enter your proof of payment', 'landingpress-wp' );
		$field_proof_invalid_status = false;
		$field_proof_value = '';

		$field_notes_label = $settings['field_notes_label'];
		$field_notes_placeholder = $settings['form_placeholders'] ? $settings['field_notes_placeholder'] : '';
		$field_notes_invalid = isset($settings['field_notes_invalid']) && $settings['field_notes_invalid'] ? $settings['field_notes_invalid'] : __( 'Please enter your notes', 'landingpress-wp' );
		$field_notes_invalid_status = false;
		$field_notes_value = '';

		$field_important_value = '';

		$field_submit_text = $settings['field_submit_text'];
		if ( !$field_submit_text ) {
			$field_submit_text = __( 'Submit', 'landingpress-wp' );
		}

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-wrapper' );
		if ( ! empty( $settings['form_display'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-display-' . $settings['form_display'] );
		}
		if ( ! empty( $settings['field_submit_align'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-button-align-' . $settings['field_submit_align'] );
		}

		$form_success = false;
		$form_invalid = false;
		$form_error = false;

		global $landingpress_elementor_form;
		if ( isset( $landingpress_elementor_form[$this->get_id()] ) && 'message_sent' == $landingpress_elementor_form[$this->get_id()] ) {
			$message_sent = true;
			$form_success = true;
			$form_invalid = false;
			$form_error = false;
			$field_order_value = '';
			$field_name_value = '';
			$field_phone_value = '';
			$field_email_value = '';
			$field_date_value = '';
			$field_amount_value = '';
			$field_proof_value = '';
			$field_notes_value = '';
			$field_important_value = '';
			if ( trim( $settings['form_redirect'] ) ) {
				$redirect = esc_url( $settings['form_redirect'] );
				echo '<meta http-equiv="refresh" content="0; '.$redirect.'" />';
			}
		} 
		else {
			if ( isset( $_POST['lp-form-id'] ) && $_POST['lp-form-id'] === $this->get_id() ) {
				// var_dump( $_POST );
				// var_dump( $_FILES );

				$form_email_to = get_option( 'admin_email' );
				if ( trim( $settings['form_email_to'] ) ) {
					$form_email_to = $settings['form_email_to'];
				}

				$form_email_subject = sprintf( __( 'New payment confirmation from "%s" website', 'landingpress-wp' ), get_option( 'blogname' ) );
				if ( trim( $settings['form_email_subject'] ) ) {
					$form_email_subject = $settings['form_email_subject'];
				}

				$form_email_from = 'noreply@'.str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
				$form_email_from_name = get_option( 'blogname' );

				if ( $settings['form_order_show'] ) {
					$field_order_value = isset( $_POST['lp-form-order'] ) ? esc_html( $_POST['lp-form-order'] ) : '';
					if ( !$field_order_value ) {
						$field_order_invalid_status = true;
						$form_invalid = true;
					}
				}

				$field_name_value = isset( $_POST['lp-form-name'] ) ? esc_html( $_POST['lp-form-name'] ) : '';
				if ( !$field_name_value ) {
					$field_name_invalid_status = true;
					$form_invalid = true;
				}

				if ( $settings['form_phone_show'] ) {
					$field_phone_value = isset( $_POST['lp-form-phone'] ) ? esc_html( $_POST['lp-form-phone'] ) : '';
					if ( !$field_phone_value ) {
						$field_phone_invalid_status = true;
						$form_invalid = true;
					}
				}

				if ( $settings['form_email_show'] ) {
					$field_email_value = isset( $_POST['lp-form-email'] ) ? esc_html( $_POST['lp-form-email'] ) : '';
					if ( !$field_email_value ) {
						// $field_email_invalid_status = true;
						// $form_invalid = true;
					}
					else {
						if ( function_exists('is_email') && ! is_email( $field_email_value ) ) {
							$field_email_invalid_status = true;
							$form_invalid = true;
						}
					}
				}

				$field_bank_value = isset( $_POST['lp-form-bank'] ) ? esc_html( $_POST['lp-form-bank'] ) : '';
				if ( !$field_bank_value ) {
					$field_bank_invalid_status = true;
					$form_invalid = true;
				}

				$field_date_value = isset( $_POST['lp-form-date'] ) ? esc_html( $_POST['lp-form-date'] ) : '';
				if ( !$field_date_value ) {
					$field_date_invalid_status = true;
					$form_invalid = true;
				}

				$field_amount_value = isset( $_POST['lp-form-amount'] ) ? esc_html( $_POST['lp-form-amount'] ) : '';
				if ( !$field_amount_value ) {
					$field_amount_invalid_status = true;
					$form_invalid = true;
				}

				$proof_id = $this->upload_proof();
				if ( $proof_id ) {
					$field_proof_value = wp_get_attachment_url( $proof_id );
				}
				else {
					$field_proof_invalid_status = true;
					$form_invalid = true;
				}

				$field_notes_value = isset( $_POST['lp-form-notes'] ) ? esc_html( $_POST['lp-form-notes'] ) : '';
				// if ( !$field_notes_value ) {
				// 	$field_notes_invalid_status = true;
				// 	$form_invalid = true;
				// }

				$field_important_value = isset( $_POST['lp-form-important'] ) ? esc_html( $_POST['lp-form-important'] ) : '';
				if ( $field_important_value ) {
					$form_invalid = true;
				}

				if ( !$form_invalid ) {

					$ipaddress = '';
					if ( isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] )
						$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
					else if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] )
						$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
					else if( isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'] )
						$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
					else if( isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'] )
						$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
					else if( isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED'] )
						$ipaddress = $_SERVER['HTTP_FORWARDED'];
					else if( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] )
						$ipaddress = $_SERVER['REMOTE_ADDR'];
					else
						$ipaddress = 'UNKNOWN';
					$useragent = $_SERVER['HTTP_USER_AGENT'];

					$message_headers = array();
					$message_headers[] = 'From: '.$form_email_from_name.' <' . $form_email_from . '>';
					$message_headers[] = 'Reply-To: '.$field_email_value;

					$message_body = '';
					if ( $field_order_value ) {
						$message_body .= __( 'Order ID #:', 'landingpress-wp' ) . " \r\n". $field_order_value . "\r\n\r\n";
					}
					$message_body .= __( 'Name:', 'landingpress-wp' ) . " \r\n". $field_name_value . "\r\n\r\n" ;
					if ( $field_phone_value ) {
						$message_body .= __( 'Phone:', 'landingpress-wp' ) . " \r\n". $field_phone_value . "\r\n\r\n";
					}
					if ( $field_email_value ) {
						$message_body .= __( 'Email:', 'landingpress-wp' ) . " \r\n". $field_email_value . "\r\n\r\n";
					}
					$message_body .= __( 'Bank:', 'landingpress-wp' ) . " \r\n". $field_bank_value . "\r\n\r\n";
					$message_body .= __( 'Date of Transfer:', 'landingpress-wp' ) . " \r\n". $field_date_value . "\r\n\r\n";
					$message_body .= __( 'Amount of Transfer:', 'landingpress-wp' ) . " \r\n". $field_amount_value . "\r\n\r\n";
					if ( $field_proof_value ) {
						$message_body .= __( 'Proof of Payment:', 'landingpress-wp' ) . " \r\n". $field_proof_value . "\r\n\r\n";
					}
					if ( $field_notes_value ) {
						$message_body .= __( 'Notes:', 'landingpress-wp' ) . " \r\n". $field_notes_value . "\r\n\r\n";
					}
					$message_body .= __( 'IP Address:', 'landingpress-wp' ) . " ". $ipaddress . "\r\n";
					$message_body .= __( 'User Agent:', 'landingpress-wp' ) . " ". $useragent . "\r\n";
					if ( isset( $_POST['lp-form-post-id'] ) && $post_id = esc_html( $_POST['lp-form-post-id'] ) ) {
						$message_body .= __( 'Page:', 'landingpress-wp' ) . " ". get_permalink($post_id) . "\r\n";
					}

					$message_sent = wp_mail( $form_email_to, $form_email_subject, $message_body, $message_headers );

					$cfdb_posted_data = array(
						__( 'Order ID #:', 'landingpress-wp' ) => $field_order_value,
						__( 'Name:', 'landingpress-wp' ) => $field_name_value,
						__( 'Phone:', 'landingpress-wp' ) => $field_phone_value,
						__( 'Email:', 'landingpress-wp' ) => $field_email_value,
						__( 'Bank:', 'landingpress-wp' ) => $field_bank_value,
						__( 'Date of Transfer:', 'landingpress-wp' ) => $field_date_value,
						__( 'Amount of Transfer:', 'landingpress-wp' ) => $field_amount_value,
						__( 'Proof of Payment:', 'landingpress-wp' ) => $field_proof_value,
						__( 'Notes:', 'landingpress-wp' ) => $field_notes_value,
						__( 'Page Title:', 'landingpress-wp' ) => get_the_title(),
						__( 'Page ID:', 'landingpress-wp' ) => get_the_ID(),
						__( 'Widget ID:', 'landingpress-wp' ) => $this->get_id(),
						__( 'IP Address:', 'landingpress-wp' ) => $ipaddress,
						// __( 'User Agent:', 'landingpress-wp' ) => $useragent,
					);
					$cfdb_uploaded_files = array();
					$cfdb_data = (object) array(
						'title' => 'Payment Confirmation Form',
						'posted_data' => $cfdb_posted_data,
						'uploaded_files' => $cfdb_uploaded_files,
					);

					// Call hook to submit data
					do_action_ref_array('cfdb_submit', array(&$cfdb_data));

					if( $message_sent == true ) {
						$landingpress_elementor_form[$this->get_id()] = 'message_sent';
						$form_success = true;
						$field_order_value = '';
						$field_name_value = '';
						$field_phone_value = '';
						$field_email_value = '';
						$field_date_value = '';
						$field_amount_value = '';
						$field_proof_value = '';
						$field_notes_value = '';
						$field_important_value = '';
						if ( trim( $settings['form_redirect'] ) ) {
							$redirect = esc_url( $settings['form_redirect'] );
							echo '<meta http-equiv="refresh" content="0; '.$redirect.'" />';
						}
					}
					else {
						$form_error = true;
					}

				}
			}
		}
		
		$this->add_render_attribute( 'field_order_label', 'for', 'lp-form-order-'.$this->get_id() );
		$this->add_render_attribute( 'field_order_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_order', 'type', 'text' );
		$this->add_render_attribute( 'field_order', 'name', 'lp-form-order' );
		$this->add_render_attribute( 'field_order', 'id', 'lp-form-order-'.$this->get_id() );
		$this->add_render_attribute( 'field_order', 'placeholder', $field_order_placeholder );
		// $this->add_render_attribute( 'field_order', 'required', '1' );
		$this->add_render_attribute( 'field_order', 'value', $field_order_value );

		$this->add_render_attribute( 'field_name_label', 'for', 'lp-form-name-'.$this->get_id() );
		$this->add_render_attribute( 'field_name_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_name', 'type', 'text' );
		$this->add_render_attribute( 'field_name', 'name', 'lp-form-name' );
		$this->add_render_attribute( 'field_name', 'id', 'lp-form-name-'.$this->get_id() );
		$this->add_render_attribute( 'field_name', 'placeholder', $field_name_placeholder );
		$this->add_render_attribute( 'field_name', 'required', '1' );
		$this->add_render_attribute( 'field_name', 'value', $field_name_value );

		$this->add_render_attribute( 'field_phone_label', 'for', 'lp-form-phone-'.$this->get_id() );
		$this->add_render_attribute( 'field_phone_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_phone', 'type', 'text' );
		$this->add_render_attribute( 'field_phone', 'name', 'lp-form-phone' );
		$this->add_render_attribute( 'field_phone', 'id', 'lp-form-phone-'.$this->get_id() );
		$this->add_render_attribute( 'field_phone', 'placeholder', $field_phone_placeholder );
		$this->add_render_attribute( 'field_phone', 'required', '1' );
		$this->add_render_attribute( 'field_phone', 'value', $field_phone_value );

		$this->add_render_attribute( 'field_email_label', 'for', 'lp-form-email-'.$this->get_id() );
		$this->add_render_attribute( 'field_email_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_email', 'type', 'email' );
		$this->add_render_attribute( 'field_email', 'name', 'lp-form-email' );
		$this->add_render_attribute( 'field_email', 'id', 'lp-form-email-'.$this->get_id() );
		$this->add_render_attribute( 'field_email', 'placeholder', $field_email_placeholder );
		// $this->add_render_attribute( 'field_email', 'required', '1' );
		$this->add_render_attribute( 'field_email', 'value', $field_email_value );

		$this->add_render_attribute( 'field_bank_label', 'for', 'lp-form-bank-'.$this->get_id() );
		// $this->add_render_attribute( 'field_bank_label', 'class', $labels_class );
		// $this->add_render_attribute( 'field_bank', 'type', 'text' );
		$this->add_render_attribute( 'field_bank', 'name', 'lp-form-bank' );
		$this->add_render_attribute( 'field_bank', 'id', 'lp-form-bank-'.$this->get_id() );
		// $this->add_render_attribute( 'field_proof', 'placeholder', $field_bank_placeholder );
		$this->add_render_attribute( 'field_bank', 'required', '1' );
		// $this->add_render_attribute( 'field_bank', 'value', $field_bank_value );

		$this->add_render_attribute( 'field_date_label', 'for', 'lp-form-date-'.$this->get_id() );
		$this->add_render_attribute( 'field_date_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_date', 'type', 'text' );
		$this->add_render_attribute( 'field_date', 'name', 'lp-form-date' );
		$this->add_render_attribute( 'field_date', 'id', 'lp-form-date-'.$this->get_id() );
		$this->add_render_attribute( 'field_date', 'placeholder', $field_date_placeholder );
		$this->add_render_attribute( 'field_date', 'required', '1' );
		$this->add_render_attribute( 'field_date', 'value', $field_date_value );

		$this->add_render_attribute( 'field_amount_label', 'for', 'lp-form-amount-'.$this->get_id() );
		$this->add_render_attribute( 'field_amount_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_amount', 'type', 'text' );
		$this->add_render_attribute( 'field_amount', 'name', 'lp-form-amount' );
		$this->add_render_attribute( 'field_amount', 'id', 'lp-form-amount-'.$this->get_id() );
		$this->add_render_attribute( 'field_amount', 'placeholder', $field_amount_placeholder );
		$this->add_render_attribute( 'field_amount', 'required', '1' );
		$this->add_render_attribute( 'field_amount', 'value', $field_amount_value );

		$this->add_render_attribute( 'field_proof_label', 'for', 'lp-form-proof-'.$this->get_id() );
		// $this->add_render_attribute( 'field_proof_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_proof', 'type', 'file' );
		$this->add_render_attribute( 'field_proof', 'name', 'lp-form-proof' );
		$this->add_render_attribute( 'field_proof', 'id', 'lp-form-proof-'.$this->get_id() );
		// $this->add_render_attribute( 'field_proof', 'placeholder', $field_proof_placeholder );
		$this->add_render_attribute( 'field_proof', 'required', '1' );
		$this->add_render_attribute( 'field_proof', 'value', $field_proof_value );

		$this->add_render_attribute( 'field_notes_label', 'for', 'lp-form-notes-'.$this->get_id() );
		$this->add_render_attribute( 'field_notes_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_notes', 'rows', '4' );
		$this->add_render_attribute( 'field_notes', 'name', 'lp-form-notes' );
		$this->add_render_attribute( 'field_notes', 'id', 'lp-form-notes-'.$this->get_id() );
		$this->add_render_attribute( 'field_notes', 'placeholder', $field_notes_placeholder );
		// $this->add_render_attribute( 'field_notes', 'required', '1' );

		$this->add_render_attribute( 'button', 'type', 'submit' );
		$this->add_render_attribute( 'button', 'class', 'lp-form-button' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $form_success ) : ?>
				<div class="lp-form-alert lp-form-alert-success">
					<?php echo $form_email_success; ?>
				</div>
			<?php endif; ?>
			<?php if ( $form_invalid ) : ?>
				<div class="lp-form-alert lp-form-alert-error">
					<?php echo $form_email_invalid; ?>
				</div>
			<?php endif; ?>
			<?php if ( $form_error ) : ?>
				<div class="lp-form-alert lp-form-alert-error">
					<?php echo $form_email_error; ?>
				</div>
			<?php endif; ?>
			<?php if ( ! $form_success ) : ?>
			<form class="lp-form" method="post" enctype="multipart/form-data" encoding="multipart/form-data">
				<input type="hidden" name="lp-form-id" value="<?php echo $this->get_id() ?>" />
				<input type="hidden" name="lp-form-post-id" value="<?php echo get_the_ID() ?>" />
				<div class="lp-form-fields-wrapper">
					<?php if ( $settings['form_order_show'] ) : ?>
						<div class="lp-form-field-order">
							<label <?php echo $this->get_render_attribute_string( 'field_order_label' ); ?>>
								<?php echo $field_order_label; ?>
							</label>
							<input <?php echo $this->get_render_attribute_string( 'field_order' ); ?>>
							<?php if ( $field_order_invalid_status ) : ?>
								<div class="lp-form-error"><?php echo $field_order_invalid; ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="lp-form-field-name">
						<label <?php echo $this->get_render_attribute_string( 'field_name_label' ); ?>>
							<?php echo $field_name_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_name' ); ?>>
						<?php if ( $field_name_invalid_status ) : ?>
							<div class="lp-form-error"><?php echo $field_name_invalid; ?></div>
						<?php endif; ?>
					</div>
					<?php if ( $settings['form_phone_show'] ) : ?>
						<div class="lp-form-field-phone">
							<label <?php echo $this->get_render_attribute_string( 'field_phone_label' ); ?>>
								<?php echo $field_phone_label; ?>
							</label>
							<input <?php echo $this->get_render_attribute_string( 'field_phone' ); ?>>
							<?php if ( $field_phone_invalid_status ) : ?>
								<div class="lp-form-error"><?php echo $field_phone_invalid; ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ( $settings['form_email_show'] ) : ?>
						<div class="lp-form-field-email">
							<label <?php echo $this->get_render_attribute_string( 'field_email_label' ); ?>>
								<?php echo $field_email_label; ?>
							</label>
							<input <?php echo $this->get_render_attribute_string( 'field_email' ); ?>>
							<?php if ( $field_email_invalid_status ) : ?>
								<div class="lp-form-error"><?php echo $field_email_invalid; ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="lp-form-field-bank">
						<label <?php echo $this->get_render_attribute_string( 'field_bank_label' ); ?>>
							<?php echo $field_bank_label; ?>
						</label>
						<select <?php echo $this->get_render_attribute_string( 'field_bank' ); ?>>
							<?php foreach ($field_bank_choices as $bank) : ?>
								<option value="<?php echo $bank; ?>"><?php echo $bank; ?></option>
							<?php endforeach; ?>
						</select>
						<?php if ( $field_bank_invalid_status ) : ?>
							<div class="lp-form-error"><?php echo $field_bank_invalid; ?></div>
						<?php endif; ?>
					</div>
					<div class="lp-form-field-date">
						<label <?php echo $this->get_render_attribute_string( 'field_date_label' ); ?>>
							<?php echo $field_date_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_date' ); ?>>
						<?php if ( $field_date_invalid_status ) : ?>
							<div class="lp-form-error"><?php echo $field_date_invalid; ?></div>
						<?php endif; ?>
					</div>
					<div class="lp-form-field-amount">
						<label <?php echo $this->get_render_attribute_string( 'field_amount_label' ); ?>>
							<?php echo $field_amount_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_amount' ); ?>>
						<?php if ( $field_amount_invalid_status ) : ?>
							<div class="lp-form-error"><?php echo $field_amount_invalid; ?></div>
						<?php endif; ?>
					</div>
					<div class="lp-form-field-proof">
						<label <?php echo $this->get_render_attribute_string( 'field_proof_label' ); ?>>
							<?php echo $field_proof_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_proof' ); ?>>
						<?php if ( $field_proof_invalid_status ) : ?>
							<div class="lp-form-error"><?php echo $field_proof_invalid; ?></div>
						<?php endif; ?>
					</div>
					<div class="lp-form-field-notes">
						<label <?php echo $this->get_render_attribute_string( 'field_notes_label' ); ?>>
							<?php echo $field_notes_label; ?>
						</label>
						<textarea <?php echo $this->get_render_attribute_string( 'field_notes' ); ?>><?php echo $field_notes_value; ?></textarea>
						<?php if ( $field_notes_invalid_status ) : ?>
							<div class="lp-form-error"><?php echo $field_notes_invalid; ?></div>
						<?php endif; ?>
					</div>
					<div class="lp-form-field-important">
						<label for="lp-form-important-<?php echo $this->get_id() ?>" class="<?php echo $labels_class; ?>">Important</label>
						<input type="text" name="lp-form-important" id="lp-form-important-<?php echo $this->get_id() ?>" class="" placeholder="Important">
					</div>
					<div class="lp-form-field-submit">
						<button <?php echo $this->get_render_attribute_string( 'button' ); ?>>
							<?php echo $field_submit_text; ?>
						</button>
					</div>
				</div>
			</form>		
			<?php endif; ?>
		</div>
		<?php 
	}

	protected function content_template() {
	}
}
