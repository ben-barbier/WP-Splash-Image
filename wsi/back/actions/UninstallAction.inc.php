<?php

// Vérification du token de sécurité.
check_admin_referer('uninstall','nonce_uninstall_field');

// Liste des tables qui seront supprimées
$list_tables = WsiCommons::getWsiTablesList();
// Liste des options qui seront supprimées
$list_options = WsiCommons::getWsiOptionsList();

$uninstalled_message .= '<p>';

foreach($list_tables as $table) {
	$deleted_table = MainManager::getInstance()->drop_wsi_table($table);
	if($deleted_table) {
		$uninstalled_message .= '<font color="green">';
		$uninstalled_message .= sprintf(__('Table \'%s\' has been deleted.', 'wp-splash-image'), "<strong><em>{$table}</em></strong>");
		$uninstalled_message .= '</font><br />';
	} else {
		$uninstalled_message .= '<font color="red">';
		$uninstalled_message .= sprintf(__('Error deleting Table \'%s\'.', 'wp-splash-image'), "<strong><em>{$table}</em></strong>");
		$uninstalled_message .= '</font><br />';
	}
}

foreach($list_options as $option) {
	$delete_option = MainManager::getInstance()->delete_wsi_option($option);
	if($delete_option) {
		$uninstalled_message .= '<font color="green">';
		$uninstalled_message .= sprintf(__('Option \'%s\' has been deleted.', 'wp-splash-image'), "<strong><em>{$option}</em></strong>");
		$uninstalled_message .= '</font><br />';
	} else {
		$uninstalled_message .= '<font color="red">';
		$uninstalled_message .= sprintf(__('Error deleting option \'%s\'.', 'wp-splash-image'), "<strong><em>{$option}</em></strong>");
		$uninstalled_message .= '</font><br />';
	}
}

$uninstalled_message .= '</p>';

?>