<?php

// Vérification du token de sécurité.
check_admin_referer('update','nonce_update_field');

// On met à jour la base de données (table: options) avec la fonction de wp: update
$siBean = new SplashImageBean();

$siBean->setUrl_splash_image(        $_POST['url_splash_image']);
$siBean->setSplash_image_width(      $_POST['splash_image_width']);
$siBean->setSplash_image_height(     $_POST['splash_image_height']);
$siBean->setSplash_color(            $_POST['splash_color']);
$siBean->setDatepicker_start(        $_POST['datepicker_start']);
$siBean->setDatepicker_end(          $_POST['datepicker_end']);
$siBean->setWsi_display_time(        $_POST['wsi_display_time']);
$siBean->setWsi_picture_link_url(    $_POST['wsi_picture_link_url']);
$siBean->setWsi_picture_link_target( $_POST['wsi_picture_link_target']);
$siBean->setWsi_include_url(         $_POST['wsi_include_url']);
$siBean->setWsi_type(                $_POST['wsi_type']);
$siBean->setWsi_opacity(             $_POST['wsi_opacity']);
$siBean->setWsi_idle_time(           $_POST['wsi_idle_time']);

// Gestion des booleans
$siBean->setSplash_active(              $_POST['splash_active']);
$siBean->setSplash_test_active(         $_POST['splash_test_active']);
$siBean->setWsi_first_load_mode_active( $_POST['wsi_first_load_mode_active']);
$siBean->setWsi_close_esc_function(     $_POST['wsi_close_esc_function']);
$siBean->setWsi_hide_cross(             $_POST['wsi_hide_cross']);
$siBean->setWsi_disable_shadow_border(  $_POST['wsi_disable_shadow_border']);
$siBean->setWsi_youtube_autoplay(       $_POST['wsi_youtube_autoplay']);
$siBean->setWsi_youtube_loop(           $_POST['wsi_youtube_loop']);
$siBean->setWsi_fixed_splash(           $_POST['wsi_fixed_splash']);

// Valeurs des onglets
$siBean->setWsi_youtube(     $_POST['wsi_youtube']);
$siBean->setWsi_yahoo(       $_POST['wsi_yahoo']);
$siBean->setWsi_dailymotion( $_POST['wsi_dailymotion']);
$siBean->setWsi_metacafe(    $_POST['wsi_metacafe']);
$siBean->setWsi_swf(         $_POST['wsi_swf']);
$siBean->setWsi_html(        $_POST['wsi_html']);

SplashImageManager::getInstance()->save($siBean);

?>