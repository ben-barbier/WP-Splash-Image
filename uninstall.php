<?php

	/**
	 * This file remove tables and options of WSI.
	 */

	// if(!defined(WP_UNINSTALL_PLUGIN)) exit();
	if(!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

	include 'wsi/DAO/MainManager.class.php';
	include 'wsi/DAO/ConfigManager.class.php';
	include 'wsi/DAO/SplashImageManager.class.php';
	include 'wsi/WsiCommons.class.php';

	// Liste des tables qui seront supprimées
	$list_tables = WsiCommons::getWsiTablesList();
	foreach($list_tables as $table) { MainManager::getInstance()->drop_wsi_table($table); }

	// Liste des options qui seront supprimées
	$list_options = WsiCommons::getWsiOptionsList();
	foreach($list_options as $option) { MainManager::getInstance()->delete_wsi_option($option); }

?>