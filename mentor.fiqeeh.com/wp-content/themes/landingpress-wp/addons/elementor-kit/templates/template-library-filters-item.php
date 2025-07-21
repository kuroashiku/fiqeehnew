<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-landingpresskit-template-library-filters-item">
<label class="landingpresskit-template-library-filter-label">
	<input type="radio" value="{{ slug }}" <# if ( '' === slug ) { #> checked<# } #> name="landingpresskit-library-filter">
	<span>{{ title }}</span>
</label>
</script>
