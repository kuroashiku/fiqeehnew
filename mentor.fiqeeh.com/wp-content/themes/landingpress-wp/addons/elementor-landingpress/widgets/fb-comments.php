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

class LP_FB_Comments extends Widget_Base {

	public function get_name() {
		return 'fb_comments';
	}

	public function get_title() {
		return __( 'LP - Facebook Comments', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	public function is_reload_preview_required() {
		return true;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Facebook Comments membutuhkan FB App ID untuk dapat berjalan.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika Anda tidak memasukkan FB App ID milik Anda sendiri, maka fitur ini akan menggunakan FB App ID milik LandingPress.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Pastikan "Disable Development Mode" di FB App ID yang Anda gunakan..', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= '<a href="https://developers.facebook.com/docs/apps/register" target="blank">'.__( 'Baca Selengkapnya', 'landingpress-wp' ).'</a>';

		$this->add_control(
			'menu_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_products',
			[
				'label' => __( 'Facebook Comments', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'app_id',
			[
				'label' => __( 'Facebook App ID', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '', 'landingpress-wp' ),
				'default' => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'href_type',
			[
				'label' => __( 'Associated URL', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'current',
				'options' => [
					'current' => __( 'Current Page', 'landingpress-wp' ),
					'custom' => __( 'Custom URL', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'href',
			[
				'label' => __( 'Custom URL', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'http://', 'landingpress-wp' ),
				'default' => '',
				'label_block' => true,
				'show_label' => true,
				'condition' => [
					'href_type' => 'custom',
				],
			]
		);

		$options = array();
		for ($i=1; $i <=20; $i++) { 
			$options[$i] = $i;
		}

		$this->add_control(
			'numposts',
			[
				'label' => __( 'Number of Comments', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '10',
				'options' => $options,
			]
		);

		$this->add_control(
			'order_by',
			[
				'label' => __( 'Order by', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'social',
				'options' => [
					'social' => 'social',
					'reverse_time' => 'reverse_time',
					'time' => 'time',
				],
			]
		);

		$this->add_control(
			'colorscheme',
			[
				'label' => __( 'Color Scheme', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light' => __( 'Light', 'landingpress-wp' ),
					'dark' => __( 'Dark', 'landingpress-wp' ),
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! $settings['app_id'] ) {
			$settings['app_id'] = '289006448233273';
		}

		$href = $settings['href_type'] == 'custom' ? $settings['href'] : get_permalink();

		$colorscheme = $settings['colorscheme'] ? $settings['colorscheme'] : 'light';
		$numposts = $settings['numposts'] ? $settings['numposts'] : '10';
		$order_by = $settings['order_by'] ? $settings['order_by'] : 'social';

		?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=<?php echo trim($settings['app_id']);?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-comments" data-href="<?php echo $href; ?>" data-numposts="<?php echo $numposts; ?>" data-width="100%" data-colorscheme="<?php echo $colorscheme; ?>" data-order-by="<?php echo $order_by; ?>"></div>
		<?php 
	}

	protected function content_template() {}
}
