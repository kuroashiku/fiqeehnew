<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'manage_posts_columns', 'landingpress_show_id_column' );
add_action( 'manage_posts_custom_column', 'landingpress_show_id_value', 10, 2 );
add_filter( 'manage_pages_columns', 'landingpress_show_id_column' );
add_action( 'manage_pages_custom_column', 'landingpress_show_id_value', 10, 2 );
add_action( 'admin_head', 'landingpress_show_id_css' );

function landingpress_show_id_column( $cols ) {
	$cols['landingpress-show-id'] = 'ID';
	return $cols;
}

function landingpress_show_id_value( $column_name, $id ) {
	if ( $column_name == 'landingpress-show-id' ) {
		echo $id;
	}
}

function landingpress_show_id_css() {
?>
<style type="text/css">
	#landingpress-show-id {
		width: 40px;
	}
</style>
<?php
}

add_action( 'admin_footer', 'landingpress_update_info', 99999 );
function landingpress_update_info() {
	$screen = get_current_screen();
	$screen_id = isset($screen->id) ? $screen->id : '';
	if ( !in_array( $screen_id, array( 
		'toplevel_page_landingpress',
		'landingpress_page_landingpress-install-plugins',
		'landingpress_page_landingpress-system-check',
	) ) ) {
		return;
	}
?>
<style>
#productstashSelector {
	background: #1e88e5 !important;
}
</style>
<script>
	var ps_config = {
		productId : "1bca3173-8409-4f2f-93dd-e055fd4a776a"
	};
</script>
<script type="text/javascript" src="https://app.productstash.io/js/productstash-embed.js" defer="defer"></script>
<?php 
}
