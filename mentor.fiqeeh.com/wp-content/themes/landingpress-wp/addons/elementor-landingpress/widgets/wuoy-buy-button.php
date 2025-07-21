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

class LP_Wuoy_Buy_Button extends Widget_Base {

	public function get_name() {
		return 'wuoymembership_buy_button';
	}

	public function get_title() {
		return __( 'LP WuoyMembership - Buy Button', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-button';
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

	public static function get_button_type() {
		return array(
			''					=> __('- Select -','landingpress-wp'),
			'jvzoo'				=> 'JVZoo Style',
			'beli-black'		=> __("Beli (Hitam)",'landingpress-wp'),
			'beli-yellow'		=> __("Beli (Kuning)",'landingpress-wp'),
			'beli-red'			=> __("Beli (Merah)",'landingpress-wp'),
			'daftar-black'		=> __("Daftar (Hitam)",'landingpress-wp'),
			'daftar-yellow'		=> __("Daftar (Kuning)",'landingpress-wp'),
			'daftar-red'		=> __("Daftar (Merah)",'landingpress-wp'),
			'download-black'	=> __("Download (Hitam)",'landingpress-wp'),
			'download-yellow'	=> __("Download (Kuning)",'landingpress-wp'),
			'download-red'		=> __("Download (Merah)",'landingpress-wp'),
			'gabung-black'		=> __("Gabung (Hitam)",'landingpress-wp'),
			'gabung-yellow'		=> __("Gabung (Kuning)",'landingpress-wp'),
			'gabung-red'		=> __("Gabung (Merah)",'landingpress-wp'),
		);
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products',
			[
				'label' => __( 'Buy Button', 'landingpress-wp' ),
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
			'button_type',
			[
				'label' => __( 'Button Type', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_button_type(),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		if ( !$settings['product'] ) {
			return;
		}
		$id = $settings['product'];
		$type = $settings['button_type'] ? $settings['button_type'] : 'jvzoo';
		$link = get_permalink( $id );
		$title = esc_attr( get_the_title( $id ) );
		$image = home_url( '?wmbutton='.$type.'&wmproduct='.$id ); 
		echo '<p class="aligncenter"><a href="'.$link.'"><img src="'.$image.'" border="0" alt="'.$title.'" /></a></p>';
	}

	protected function content_template() {}
}
