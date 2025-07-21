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

class LP_Wuoy_Content_Protection extends Widget_Base {

	public function get_name() {
		return 'wuoymembership_content_protection';
	}

	public function get_title() {
		return __( 'LP WuoyMembership - Content Protection', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-align-left';
	}

	public function get_categories() {
		return [ 'landingpress-wuoymembership' ];
	}

	public static function get_products() {
		$products = array( '' => __( '- Select -', 'landingpress-wp' ) );
		$posts = get_posts( array( 'post_type' => 'wuoyproduct', 'posts_per_page' => 100 ) );
		if ( !empty($posts) ) {
			foreach ( $posts as $post ) {
				$products[$post->ID] = $post->post_title;
			}
		}
		return $products;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products',
			[
				'label' => __( 'Content Protection', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'product',
			[
				'label' => __( 'Product', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_products(),
			]
		);

		$this->add_control(
			'editor',
			[
				'label' => '',
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'landingpress-wp' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Text Editor', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
				'selectors' => [
					'{{WRAPPER}} .elementor-text-editor' => 'text-align: {{VALUE}};',
				],
			]
		);

	    $this->add_control(
	        'text_color',
	        [
	            'label' => __( 'Text Color', 'landingpress-wp' ),
	            'type' => Controls_Manager::COLOR,
	            'default' => '',
	            'selectors' => [
	                '{{WRAPPER}}' => 'color: {{VALUE}};',
	            ],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
	        ]
	    );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$editor_content = $settings['editor'];

		if ( $settings['product'] && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$editor_content = '[wuoyMember-content-protection product='.$settings['product'].']'.$editor_content.'[/wuoyMember-content-protection]';
		}

		$editor_content = $this->parse_text_editor( $editor_content );

		?>
		<div class="elementor-text-editor elementor-clearfix"><?php echo $editor_content; ?></div>
		<?php
	}

	public function render_plain_content() {
		$settings = $this->get_settings();
		echo '[wuoyMember-content-protection product='.$settings['product'].']'.$settings['editor'].'[/wuoyMember-content-protection]';
	}

}
