<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } else { do_action( 'wp_body_open' ); } ?>
<?php do_action( 'landingpress_body_before' ); ?>
<div class="site-canvas">
<?php do_action( 'landingpress_page_before' ); ?>
<div id="page" class="site-container">
<?php if ( get_theme_mod('landingpress_menu_placement') == 'before' && landingpress_is_menu_active() && has_nav_menu( 'header' ) ) : ?>
	<?php get_template_part( 'block-menu' ); ?>
<?php endif; ?>
<?php if ( landingpress_is_header_active() ) : ?>
	<?php get_template_part( 'block-header' ); ?>
<?php endif; ?>
<div class="site-inner">
	<?php if ( get_theme_mod('landingpress_menu_placement') != 'before' && landingpress_is_menu_active() && has_nav_menu( 'header' ) ) : ?>
		<?php get_template_part( 'block-menu' ); ?>
	<?php endif; ?>
	<div id="content" class="site-content">
		<div class="container">
			<?php do_action( 'landingpress_site_content_before' ); ?>
