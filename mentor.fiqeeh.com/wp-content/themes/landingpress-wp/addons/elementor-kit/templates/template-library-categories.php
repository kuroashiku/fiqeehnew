<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-landingpresskit-template-library-categories">
<#
	if ( ! _.isEmpty( categories ) ) {
#>
<select class="landingpresskit-library-categories">
	<option value=""><?php esc_html_e( 'Show All', 'landingpress-wp' ); ?></option>
	<# _.each( categories, function( title, slug ) { #>
	<option value="{{ title }}">{{ title }}</option>
	<# } ); #>
</select>
<#
	}
#>
</script>
