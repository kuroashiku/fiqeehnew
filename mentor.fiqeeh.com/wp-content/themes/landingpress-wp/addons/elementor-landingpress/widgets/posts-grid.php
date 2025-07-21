<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Posts_Grid extends Widget_Base {

	public function get_name() {
		return 'lp_posts_grid';
	}

	public function get_title() {
		return __( 'LP - Posts Grid', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	public static function get_post_categories() {
		$categories = array( '' => __( '- All Categories -', 'landingpress-wp' ) );
		$terms = get_terms( array( 'taxonomy' => 'category' ) );
		if ( !empty($terms) ) {
			foreach ( $terms as $term ) {
				$categories[$term->slug] = $term->name;
			}
		}
		return $categories;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_posts',
			[
				'label' => __( 'Posts', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_post_categories(),
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
				'default' => '3',
				'options' => $options,
			]
		);
		for ($i=7; $i <=24; $i++) { 
			$options[$i] = $i;
		}

		$this->add_control(
			'per_page',
			[
				'label' => __( 'Number of Posts', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '6',
				'options' => $options,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Published Date', 'landingpress-wp' ),
					'title' => __( 'Title', 'landingpress-wp' ),
					'rand' => __( 'Random', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __( 'DESC (high to low)', 'landingpress-wp' ),
					'ASC' => __( 'ASC (low to high)', 'landingpress-wp' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'		=> 'image', // Actually its `image_size`
				'label'		=> __( 'Thumbnail Size', 'landingpress-wp' ),
				'default'	=> 'post-thumbnail-medium',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_shorten',
			[
				'label' => __( 'One-line post title', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_words',
			[
				'label' => __( 'Number of words on post summary', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'words' => [
						'min' => 10,
						'max' => 55,
					],
				],
				'size_units' => [ 'words' ],
				'default' => [
					'size' => '25',
					'unit' => 'words',
				],
				'show_label' => true,
			]
		);

		$this->add_control(
			'readmore',
			[
				'label' => __( 'Read More Text', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More', 'landingpress-wp' ),
				'placeholder' => __( 'Read More', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Post Title', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-posts-grid-wrapper li h4 a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .lp-posts-grid-wrapper li h4 a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label' => __( 'Post Excerpt', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-posts-grid-wrapper li p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .lp-posts-grid-wrapper li p',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label' => __( 'Read More Link', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-posts-grid-wrapper li .readmore' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'readmore_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'selector' => '{{WRAPPER}} .lp-posts-grid-wrapper li .readmore',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$columns = absint( $settings['columns'] ) > 0 ? absint( $settings['columns'] ) : 3;
		$per_page = absint( $settings['per_page'] ) > 0 ? absint( $settings['per_page'] ) : 6;
		$orderby = $settings['orderby'] ? $settings['orderby'] : 'date';
		$order = $settings['order'] ? $settings['order'] : 'DESC';

		if ( get_query_var( 'paged' ) ) {
			$page = get_query_var( 'paged' );
		}
		elseif ( get_query_var( 'page' ) ) {
			$page = get_query_var( 'page' );
		}
		else {
			$page = 1;		
		}

		$offset = ( $page - 1 ) * $per_page;

		$args = array( 
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order,
			'page' =>  $page,
			'offset' =>  $offset,
			'ignore_sticky_posts' => 1,
		);
		if ( $settings['category'] ) {
			$args['category_name'] = $settings['category'];
		}

		$thumbnail = [];

		if ( isset($settings['image_size']) && $settings['image_size'] ) {
			$thumbnail['image_size'] = $settings['image_size'];
		}
		else {
			$thumbnail['image_size'] = 'post-thumbnail';
		}

		if ( isset($settings['image_custom_dimension']) ) {
			$thumbnail['image_custom_dimension'] = $settings['image_custom_dimension'];
		}

		$the_query = new \WP_Query( $args );
		if ( $the_query->have_posts() ) {
			echo '<div class="lp-posts-grid-wrapper lp-posts-grid-columns-'.$columns.' truncate-title-'.$settings['title_shorten'].'">';
			echo '<ul class="clearfix">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				echo '<li>';
				if ( has_post_thumbnail() ) {
					echo '<a href="'.get_permalink().'" title="">';
					$thumbnail['image'] = [ 'id' => get_post_thumbnail_id() ];
					echo Group_Control_Image_Size::get_attachment_image_html( $thumbnail );
					echo '</a>';
				}
				the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				if ( isset($settings['excerpt_words']['size']) && $settings['excerpt_words']['size'] ) {
					$excerpt_words = intval( $settings['excerpt_words']['size'] );
				}
				else {
					$excerpt_words = 25;
				}
				$excerpt = wp_trim_words( get_the_excerpt(), $excerpt_words, '&hellip;' );
				$excerpt = strip_tags( $excerpt );
				if ( $excerpt ) {
					echo '<p>'.$excerpt.'</p>';
				}
				if ( $settings['readmore'] ) {
					echo '<a class="readmore" href="'.get_permalink().'">'.$settings['readmore'].'</a>';
				}
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';
			if ( $settings['pagination'] == 'yes' ) {
				if( isset( $the_query->max_num_pages ) && $the_query->max_num_pages > 1 ) { 
					$big = 999999999; // need an unlikely integer
					$links = paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, $page ),
						'total' => $the_query->max_num_pages,
						'type' => 'list',
						'prev_next' => true,
						'prev_text' => esc_html__('&laquo; Previous', 'landingpress-wp'),
						'next_text' => esc_html__('Next &raquo;', 'landingpress-wp'),
					) );
					if ( $links )
						$links = '<nav class="lp-posts-grid-navigation posts-navigation">'.$links.'</nav>';
					echo $links;
				}
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		} 

	}

	protected function content_template() {
	}
}
