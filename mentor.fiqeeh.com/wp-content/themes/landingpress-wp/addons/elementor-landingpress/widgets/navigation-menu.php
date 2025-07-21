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

class LP_Navigation_Menu extends Widget_Base {

	public function get_name() {
		return 'lp_navigation_menu';
	}

	public function get_title() {
		return __( 'LP - Navigation Menu', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-menu-bar';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'LandingPress memiliki dua tipe di widget ini, yaitu Simple Menu dan WP Nav Menu..', 'landingpress-wp' );

		$description .= '<br><br>';
		$description .= __( 'Silahkan gunakan tipe <strong>Simple Menu</strong> untuk membuat navigation menu yang sederhana, cocok untuk <strong><u>standalone landing page</u></strong> ataupun <strong><u>one page website</u></strong>.', 'landingpress-wp' );

		$description .= '<br><br>';
		$description .= __( 'Silahkan gunakan tipe <strong>WP Nav Menu</strong> untuk membuat navigation menu dengan multi-level menu (dropdown) dan menu yang isinya bisa di-setup dari halaman Menus di dashboard admin WordPress.', 'landingpress-wp' );

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
			'section_menu_items',
			[
				'label' => __( 'Menu Items', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menu_type',
			[
				'label' => __( 'Menu Type', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Simple Menu', 'landingpress-wp' ),
					'wp_nav_menu' => __( 'WP Nav Menu', 'landingpress-wp' ),
				],
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'menu_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Menu Label', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'menu_link',
			[
				'label' => __( 'Link', 'landingpress-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menus',
			[
				'label' => __( 'Menu Items', 'landingpress-wp' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'default' => [
					[
						'menu_label' => __( 'Menu 1', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 2', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 3', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 4', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 5', 'landingpress-wp' ),
						'menu_link' => '#',
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ menu_label }}}',
				'condition' => [
					'menu_type' => '',
				],
			]
		);

		$menus = wp_get_nav_menus();
		$options = array( '' => __( 'Select Menu', 'landingpress-wp' ) );
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		if ( ! empty( $options ) ) {
			$this->add_control(
				'wp_nav_menu',
				[
					'label' => __( 'WP Nav Menu', 'landingpress-wp' ),
					'type' => Controls_Manager::SELECT,
					'options' => $options,
					'default' => '',
					'label_block' => true,
					'description' => sprintf( __( 'Silahkan ke halaman <a href="%s" target="_blank">Menus</a> di dashboard admin WordPress untuk mengatur menu yang akan digunakan.', 'landingpress-wp' ), admin_url( 'nav-menus.php' ) ),
					'condition' => [
						'menu_type' => 'wp_nav_menu',
					],
				]
			);
		} 
		else {
			$this->add_control(
				'wp_nav_menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'Tidak ada WP Nav Menu di website Anda.', 'landingpress-wp' ) . '</strong><br>' . sprintf( __( 'Silahkan ke halaman <a href="%s" target="_blank">Menus</a> di dashboard admin WordPress untuk membuat menu yang akan digunakan.', 'landingpress-wp' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => [
						'menu_type' => 'wp_nav_menu',
					],
				]
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_logo',
			[
				'label' => __( 'Menu Logo', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'logo_image',
			[
				'label' => __( 'Logo Image', 'landingpress-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => get_template_directory_uri().'/assets/images/logo.png',
				],
			]
		);

		$this->add_control(
			'logo_link',
			[
				'label' => __( 'Logo Link', 'landingpress-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'landingpress-wp' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_sticky',
			[
				'label' => __( 'Sticky Menu', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'sticky_menu',
			[
				'label' => __( 'Sticky Menu', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menus_style',
			[
				'label' => __( 'Menu Items', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_menus_style' );

		$this->start_controls_tab(
			'tab_menus_normal',
			[
				'label' => __( 'Normal', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menus_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lp-navmenu-items li a, {{WRAPPER}} .lp-navmenu-items li a:visited, {{WRAPPER}} .lp-navmenu-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lp-navmenu-items, {{WRAPPER}} .lp-navmenu-items li' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menus_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .lp-navmenu-items li a, {{WRAPPER}} .lp-navmenu-items li a:visited',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menus_hover',
			[
				'label' => __( 'Hover', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menus_text_hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-navmenu-items li a:hover, {{WRAPPER}} .lp-navmenu-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'submenu_background',
			[
				'label' => __( 'Submenu Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lp-navmenu-items ul' => 'background: {{VALUE}};',
				],
				'condition' => [
					'menu_type' => 'wp_nav_menu',
				],
			]
		);

		$this->add_control(
			'submenu_border',
			[
				'label' => __( 'Submenu Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lp-navmenu-items ul, {{WRAPPER}} .lp-navmenu-items ul li' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'menu_type' => 'wp_nav_menu',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_sticky_style',
			[
				'label' => __( 'Sticky Menu', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sticky_menu!' => '',
				],
			]
		);

		$this->add_control(
			'menu_sticky_background',
			[
				'label' => __( 'Sticky Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .is-sticky .lp-navmenu-wrapper.lp-navmenu-sticky' => 'background: {{VALUE}};',
				],
				'condition' => [
					'sticky_menu!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$menu_type = $settings['menu_type'];
		$menus_data = array();
		if ( $menu_type !== 'wp_nav_menu' ) {
			$menus_count = 0;
			if ( !empty( $settings['menus'] ) ) {
				foreach ( $settings['menus'] as $menu ) {
					$menu_label = $menu['menu_label'];
					$menu_link = $menu['menu_link']['url'] ? $menu['menu_link']['url'] : '#';
					$menu_target = $menu['menu_link']['is_external'] ? ' target="_blank"' : '';
					$menus_data[] = sprintf( '<li><a href="%s" %s>%s</a></li>', $menu_link, $menu_target, $menu_label );
					$menus_count++;
				}
			}
		}
		$menu_logo = '';
		if ( $settings['logo_image']['url'] ) {
			$menu_logo = '<img src="'.$settings['logo_image']['url'].'" alt="" />';
			if ( $settings['logo_link']['url'] ) {
				$menu_log_target = $settings['logo_link']['is_external'] ? ' target="_blank"' : '';
				$menu_logo = '<a href="'.$settings['logo_link']['url'].'" '.$menu_log_target.'>'.$menu_logo.'</a>';
			}
		}
		if ( $menu_logo ) {
			$menu_logo = '<div class="lp-navmenu-logo">'.$menu_logo.'</div>';
		}
		?>
		<div class="lp-navmenu-wrapper <?php if ( isset( $settings['sticky_menu'] ) && $settings['sticky_menu'] == 'yes' ) echo 'lp-navmenu-sticky'; ?>">
			<?php echo $menu_logo; ?>
			<?php if ( $menu_type == 'wp_nav_menu' ) : ?>
				<?php if (!empty($settings['wp_nav_menu'])) : ?>
					<div class="lp-navmenu-button">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
					</div>
					<?php 
					wp_nav_menu( 
						array(
							'menu' => $settings['wp_nav_menu'],
							'container' => '',
							'menu_id' => 'lp-navmenu-items-'.$this->get_id(),
							'menu_class' => 'lp-navmenu-items',
							'fallback_cb' => '',
						)
					); 
					?>
				<?php endif; ?>
			<?php else : ?>
				<?php if (!empty($menus_data)) : ?>
					<div class="lp-navmenu-button">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
					</div>
					<ul class="lp-navmenu-items">
						<?php echo implode( '', $menus_data ); ?>
					</ul>
				<?php endif; ?>
			<?php endif; ?>
			<div style="clear:both;"></div>
		</div>
		<?php 
	}

	protected function content_template() {
	}
}
