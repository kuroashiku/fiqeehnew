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

class LP_WC_Products_Best_Selling extends Widget_Base {

	public function get_name() {
		return 'woocommerce_products_best_selling_lp';
	}

	public function get_title() {
		return __( 'LP WooCommerce - Best Selling Products', 'landingpress-wp' );
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
				$categories[$term->slug] = $term->name;
			}
		}
		return $categories;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products',
			[
				'label' => __( 'Best Selling Products', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'landingpress-wp' ),
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

		$this->add_control(
			'per_page',
			[
				'label' => __( 'Number of Products', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => $options,
			]
		);

		$this->add_control(
			'paginate',
			[
				'label' => __( 'Pagination', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'landingpress-wp' ),
					'yes' => __( 'Yes', 'landingpress-wp' ),
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

		$shortcode_tag = 'best_selling_products';

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-woocommerce-lp' );

		if ( isset($settings['category']) && $settings['category'] ) {
			$this->add_render_attribute( 'shortcode', 'category', $settings['category'] );
		}

		if ( $settings['columns'] ) {
			$this->add_render_attribute( 'shortcode', 'columns', $settings['columns'] );
		}

		if ( $settings['per_page'] ) {
			$this->add_render_attribute( 'shortcode', 'per_page', $settings['per_page'] );
		}

		if ( 'yes' == $settings['paginate'] ) {
			$this->add_render_attribute( 'shortcode', 'paginate', 1 );
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
