<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$menu_logo = get_theme_mod( 'landingpress_menu_logo' );
$menu_cart = class_exists( 'woocommerce' ) && get_theme_mod('landingpress_wc_minicart', '1') ? true : false;
$menu_cart_count = class_exists( 'woocommerce' ) && get_theme_mod('landingpress_wc_optimization_minicart_count_disable') ? false : true;
$menu_class = $menu_logo ? ' main-navigation-logo-yes' : ' main-navigation-logo-no';
$menu_class .= $menu_cart ? ' main-navigation-cart-yes' : ' main-navigation-cart-no';
?>
<nav id="site-navigation" class="main-navigation <?php echo $menu_class; ?>">
	<div class="container">
		<div class="menu-overlay"></div>
		<button class="menu-toggle" aria-controls="header-menu" aria-expanded="false"><span class="menu-toggle-text">MENU</span><span class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg></span></button>
		<?php if ( $menu_logo ) : ?>
			<a class="menu-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( $menu_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
		<?php endif; ?>
		<?php if ( $menu_cart ) : ?>
			<?php $wc_cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : WC()->cart->get_cart_url(); ?>
			<a class="menu-minicart" href="<?php echo esc_url( $wc_cart_url ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg> 
				<?php if ( $menu_cart_count ) : ?> 
					<span class="minicart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				<?php else : ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg> <span class="minicart-text"><?php esc_html_e( 'Cart', 'landingpress-wp' ); ?></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
		<?php 
		echo landingpress_get_nav_menu( array( 
			'theme_location' => 'header', 
			'container_class' => 'header-menu-container', 
			'menu_id' => 'header-menu', 
			'menu_class' => 'header-menu menu nav-menu clearfix', 
			'fallback_cb' => '',
		) ); 
		?>
	</div>
</nav>
