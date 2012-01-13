<?php

// Vérification du token de sécurité.
check_admin_referer('uninstall','nonce_uninstall_field');

// Liste des options qui seront supprimées
$list_options = WsiCommons::getOptionsList();

$uninstalled_message .= '<p>';
foreach($list_options as $option) {
	$delete_option = SplashImageManager::getInstance()->delete($option);
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

?>