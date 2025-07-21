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

class LP_WC_Product_Categories extends Widget_Base {

	public function get_name() {
		return 'woocommerce_product_categories_lp';
	}

	public function get_title() {
		return __( 'LP WooCommerce - Product Categories', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'landingpress-woocommerce' ];
	}

	public static function get_product_categories() {
		$categories = array( '' => __( '- All Categories -', 'landingpress-wp' ) );
		$terms = get_terms( array( 'taxonomy' => 'product_cat' ) );
		if ( !empty($terms) ) {
			foreach ( $terms as $term ) {
				$categories[$term->term_id] = $term->name;
			}
		}
		return $categories;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_product_categories',
			[
				'label' => __( 'Product Categories', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Parent Category', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_product_categories(),
			]
		);

		$options = array();
		for ($i=1; $i <=6; $i++) { 
			$options[$i] = $i;
		}

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns Per Row', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => $options,
			]
		);
		for ($i=7; $i <=24; $i++) { 
			$options[$i] = $i;
		}

		$options = array_merge( array( '-1' => __( 'All Categories', 'landingpress-wp' ) ), $options );
		$this->add_control(
			'limit',
			[
				'label' => __( 'Number of Categories', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => $options,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name' => __( 'Category Name', 'landingpress-wp' ),
					'term_id' => __( 'Category ID', 'landingpress-wp' ),
					'count' => __( 'Category Count', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC' => __( 'ASC (low to high)', 'landingpress-wp' ),
					'DESC' => __( 'DESC (high to low)', 'landingpress-wp' ),
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			if ( class_exists('woocommerce') && function_exists('landingpress_wc_setup_shop_page') ) {
				landingpress_wc_setup_shop_page();
			} 
			if ( class_exists('woocommerce') && function_exists('landingpress_wc_product_post_class') ) {
				add_filter( 'post_class', 'landingpress_wc_product_post_class', 20 ); 
			} 
		}

		$shortcode_tag = 'product_categories';

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-woocommerce-lp' );

		if ( isset($settings['category']) && $settings['category'] ) {
			$this->add_render_attribute( 'shortcode', 'parent', $settings['category'] );
		}

		if ( $settings['columns'] ) {
			$this->add_render_attribute( 'shortcode', 'columns', $settings['columns'] );
		}

		if ( $settings['limit'] ) {
			$this->add_render_attribute( 'shortcode', 'limit', $settings['limit'] );
		}

		if ( $settings['orderby'] ) {
			$this->add_render_attribute( 'shortcode', 'orderby', $settings['orderby'] );
		}

		if ( $settings['order'] ) {
			$this->add_render_attribute( 'shortcode', 'order', $settings['order'] );
		}

		remove_all_actions( 'woocommerce_before_shop_loop' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo do_shortcode( '['.$shortcode_tag.' ' . $this->get_render_attribute_string( 'shortcode' ) . ']' ); ?>
		</div>
		<?php
	}

	protected function content_template() {}
}
