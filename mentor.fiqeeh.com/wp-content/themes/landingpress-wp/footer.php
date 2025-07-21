<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
			<?php do_action( 'landingpress_site_content_after' ); ?>
		</div>
	</div>
	<?php if ( landingpress_is_footerwidgets_active() ) : ?>
		<?php if ( ! get_theme_mod( 'landingpress_footer_widgets_hide' ) ) : ?>
			<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
				<div id="footer-widgets" class="site-footer-widgets">
					<div class="container">
						<div class="footer-col">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
						<div class="footer-col">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
						<div class="footer-col">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
</div><?php // .site-inner ?>
<?php if ( landingpress_is_footer_active() ) : ?>
	<footer id="colophon" class="site-footer">
		<div class="container">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav id="footer-navigation" class="footer-navigation">
					<?php echo landingpress_get_nav_menu( array( 'theme_location' => 'footer', 'depth' => 1, 'fallback_cb' => '' ) ); ?>
				</nav>
			<?php endif; ?>
			<div class="site-info">
				<?php if ( get_theme_mod( 'landingpress_footer_text' ) ) : ?>
					<?php echo get_theme_mod( 'landingpress_footer_text' ); ?>
				<?php else : ?>
					<?php echo 'Copyright &copy; '.date('Y').' '.get_bloginfo('name'); ?>
				<?php endif; ?>
			</div>
		</div>
	</footer>
<?php endif; ?>
</div><?php // .site-container ?>
<?php do_action( 'landingpress_page_after' ); ?>
</div><?php // .site-canvas ?>
<?php wp_footer(); ?>
</body>
</html>
