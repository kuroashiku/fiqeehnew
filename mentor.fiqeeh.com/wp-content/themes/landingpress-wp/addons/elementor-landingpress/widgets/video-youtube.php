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

class LP_Video_Youtube extends Widget_Base {

	public function get_name() {
		return 'lp_video_youtube';
	}

	public function get_title() {
		return __( 'LP - Youtube Video', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Youtube Video', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your YouTube link', 'landingpress-wp' ),
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'169' => '16:9',
					'43' => '4:3',
					'32' => '3:2',
				],
				'default' => '169',
				'prefix_class' => 'elementor-aspect-ratio-',
			]
		);

		$this->add_control(
			'heading_youtube',
			[
				'label' => __( 'Video Options', 'landingpress-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// YouTube
		$this->add_control(
			'yt_autoplay',
			[
				'label' => __( 'Autoplay', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'no' => __( 'No', 'landingpress-wp' ),
					'yes' => __( 'Yes', 'landingpress-wp' ),
				],
				'default' => 'no',
			]
		);

		$this->add_control(
			'yt_rel',
			[
				'label' => __( 'Suggested Videos', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'no' => __( 'Hide', 'landingpress-wp' ),
					'yes' => __( 'Show', 'landingpress-wp' ),
				],
				'default' => 'no',
			]
		);

		$this->add_control(
			'yt_controls',
			[
				'label' => __( 'Player Control', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'yes' => __( 'Show', 'landingpress-wp' ),
					'no' => __( 'Hide', 'landingpress-wp' ),
				],
				'default' => 'yes',
			]
		);

		$this->add_control(
			'yt_showinfo',
			[
				'label' => __( 'Player Title & Actions', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'yes' => __( 'Show', 'landingpress-wp' ),
					'no' => __( 'Hide', 'landingpress-wp' ),
				],
				'default' => 'yes',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'landingpress-wp' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'youtube',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$video_link = $settings['link'];

		if ( empty( $video_link ) )
			return;

		$embed_id = $this->get_embed_id( $video_link );

		if ( empty( $embed_id ) )
			return;

		$params = [];

		$youtube_options = [ 'autoplay', 'rel', 'controls', 'showinfo' ];

		foreach ( $youtube_options as $option ) {
			$value = ( 'yes' === $settings[ 'yt_' . $option ] ) ? '1' : '0';
			$params[ $option ] = $value;
		}

		$params['wmode'] = 'opaque';

		$youtube_src = add_query_arg( $params, 'https://www.youtube.com/embed/'.$embed_id );

		$video_width = 750;
		if ( $settings['aspect_ratio'] == '32' ) {
			$video_height = absint( $video_width * 2 / 3 ); 
		}
		elseif ( $settings['aspect_ratio'] == '43' ) {
			$video_height = absint( $video_width * 3 / 4 ); 
		}
		else {
			$video_height = absint( $video_width * 9 / 16 ); 
		}

		?>
		<div class="lp-video-container">
			<iframe width="<?php echo $video_width; ?>" height="<?php echo $video_height; ?>" src="<?php echo esc_url( $youtube_src ); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<?php 
	}

	public function get_embed_id( $url ) {
		$pattern = "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#";
		$result = preg_match($pattern, $url, $matches);
		if ( false !== $result && isset( $matches[0] ) ) {
			return $matches[0];
		}
		return false;
	}

	protected function content_template() {}
}
