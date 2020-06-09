	<?php
function manu_plugin_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">
		<h1>Manu:Plugin</h1>
	</div>

	<?php
}
