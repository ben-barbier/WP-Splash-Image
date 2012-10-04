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
$configBean->setSplash_active(              $_POST['splash_active']=='on');
$configBean->setWsi_first_load_mode_active( $_POST['wsi_first_load_mode_active']=='on');
$siBean->setWsi_close_on_esc_function(      $_POST['wsi_close_on_esc_function']=='on');
$siBean->setWsi_close_on_click_function(    $_POST['wsi_close_on_click_function']=='on');
$siBean->setWsi_hide_cross(                 $_POST['wsi_hide_cross']=='on');
$siBean->setWsi_disable_shadow_border(      $_POST['wsi_disable_shadow_border']=='on');
$siBean->setWsi_youtube_autoplay(           $_POST['wsi_youtube_autoplay']=='on');
$siBean->setWsi_youtube_loop(               $_POST['wsi_youtube_loop']=='on');
$siBean->setWsi_fixed_splash(               $_POST['wsi_fixed_splash']=='on');
$siBean->setWsi_display_always(             $_POST['wsi_display_always']=='on');
$siBean->setWsi_hide_on_mobile_devices(     $_POST['wsi_hide_on_mobile_devices']=='on');

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