<?php

// Vérification du token de sécurité.
check_admin_referer('uninstall','nonce_uninstall_field');

// Liste des options qui seront supprimées
$list_options = WsiCommons::getOptionsList();

$uninstalled_message .= '<p>';
foreach($list_options as $option) {
	$delete_option = delete_option($option);
	if($delete_option) {
		$uninstalled_message .= '<font color="green">';
		$uninstalled_message .= sprintf(__('Setting Key \'%s\' has been deleted.', 'wp-splash-image'), "<strong><em>{$option}</em></strong>");
		$uninstalled_message .= '</font><br />';
	} else {
		$uninstalled_message .= '<font color="red">';
		$uninstalled_message .= sprintf(__('Error deleting Setting Key \'%s\'.', 'wp-splash-image'), "<strong><em>{$option}</em></strong>");
		$uninstalled_message .= '</font><br />';
	}
}
$uninstalled_message .= '</p>';

// Find uninstall URL
$deactivate_url = 'plugins.php?action=deactivate&plugin=wsi%2Fwp-splash-image.php&plugin_status=all&paged=1';
if(function_exists('wp_nonce_url')) {
	$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_wsi/wp-splash-image.php');
}

?>