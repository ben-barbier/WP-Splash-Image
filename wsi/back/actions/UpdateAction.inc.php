<?php

// Vérification du token de sécurité.
check_admin_referer('update','nonce_update_field');

// On met à jour la base de données (table: options) avec la fonction de wp: update
$siBean = new SplashImageBean();
$configBean = new ConfigBean();

$siBean->setId( $_POST['id'] );

$siBean->setUrl_splash_image(        $_POST['url_splash_image']);
$siBean->setSplash_image_width(      $_POST['splash_image_width']);
$siBean->setSplash_image_height(     $_POST['splash_image_height']);
$siBean->setWsi_margin_top(          $_POST['wsi_margin_top']);
$siBean->setSplash_color(            $_POST['splash_color']);
$siBean->setWsi_display_time(        $_POST['wsi_display_time']);
$siBean->setWsi_picture_link_url(    $_POST['wsi_picture_link_url']);
$siBean->setWsi_picture_link_target( $_POST['wsi_picture_link_target']);
$siBean->setWsi_include_url(         $_POST['wsi_include_url']);
$siBean->setWsi_type(                $_POST['wsi_type']);
$siBean->setWsi_opacity(             $_POST['wsi_opacity']);
$siBean->setWsi_idle_time(           $_POST['wsi_idle_time']);

// Dates management
$siBean->setDatepicker_start( $_POST['datepicker_start']);
$siBean->setDatepicker_end(   $_POST['datepicker_end']);

// Booleans management
$configBean->setSplash_active(              isset($_POST['splash_active']));
$configBean->setWsi_first_load_mode_active( isset($_POST['wsi_first_load_mode_active']));
$siBean->setWsi_close_on_esc_function(      isset($_POST['wsi_close_on_esc_function']));
$siBean->setWsi_close_on_click_function(    isset($_POST['wsi_close_on_click_function']));
$siBean->setWsi_hide_cross(                 isset($_POST['wsi_hide_cross']));
$siBean->setWsi_disable_shadow_border(      isset($_POST['wsi_disable_shadow_border']));
$siBean->setWsi_youtube_autoplay(           isset($_POST['wsi_youtube_autoplay']));
$siBean->setWsi_youtube_loop(               isset($_POST['wsi_youtube_loop']));
$siBean->setWsi_fixed_splash(               isset($_POST['wsi_fixed_splash']));
$siBean->setWsi_display_always(             isset($_POST['wsi_display_always']));
$siBean->setWsi_hide_on_mobile_devices(     isset($_POST['wsi_hide_on_mobile_devices']));

// Valeurs des onglets
$siBean->setWsi_youtube(     $_POST['wsi_youtube']);
$siBean->setWsi_yahoo(       $_POST['wsi_yahoo']);
$siBean->setWsi_dailymotion( $_POST['wsi_dailymotion']);
$siBean->setWsi_metacafe(    $_POST['wsi_metacafe']);
$siBean->setWsi_swf(         $_POST['wsi_swf']);

// Remove slash in HTML code.
$siBean->setWsi_html( stripslashes($_POST['wsi_html']));

ConfigManager::getInstance()->save($configBean);
SplashImageManager::getInstance()->save($siBean);

?>