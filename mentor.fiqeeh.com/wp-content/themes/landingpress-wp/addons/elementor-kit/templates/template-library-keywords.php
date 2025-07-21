<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-landingpresskit-template-library-keywords">
<#
	if ( ! _.isEmpty( keywords ) ) {
#>
<select class="landingpresskit-library-keywords">
	<option value=""><?php esc_html_e( 'Show All', 'landingpress-wp' ); ?></option>
	<# _.each( keywords, function( title, slug ) { #>
	<option value="{{ title }}">{{ title }}</option>
	<# } ); #>
</select>
<#
	}
#>
</script>
