<?php

// Vérification du token de sécurité.
check_admin_referer('update','nonce_update_field');

// On met à jour la base de données (table: options) avec la fonction de wp: update_option
update_option('url_splash_image',        $_POST['url_splash_image']);
update_option('splash_image_width',      $_POST['splash_image_width']);
update_option('splash_image_height',     $_POST['splash_image_height']);
update_option('splash_color',            $_POST['splash_color']);
update_option('datepicker_start',        $_POST['datepicker_start']);
update_option('datepicker_end',          $_POST['datepicker_end']);
update_option('wsi_display_time',        $_POST['wsi_display_time']);
update_option('wsi_picture_link_url',    $_POST['wsi_picture_link_url']);
update_option('wsi_picture_link_target', $_POST['wsi_picture_link_target']);
update_option('wsi_type',                $_POST['wsi_type']);
update_option('wsi_opacity',             $_POST['wsi_opacity']);
update_option('wsi_idle_time',           ($_POST['wsi_idle_time']=='')?0:$_POST['wsi_idle_time']);

// Gestion des booleans
if ($_POST['splash_active']) {$active='true';} else {$active='false';}
update_option('splash_active', $active);
if ($_POST['splash_test_active']) {$test_active='true';} else {$test_active='false';}
update_option('splash_test_active', $test_active);
if ($_POST['wsi_close_esc_function']) {$wsi_close_esc_function='true';} else {$wsi_close_esc_function='false';}
update_option('wsi_close_esc_function', $wsi_close_esc_function);
if ($_POST['wsi_hide_cross']) {$wsi_hide_cross='true';} else {$wsi_hide_cross='false';}
update_option('wsi_hide_cross', $wsi_hide_cross);
if ($_POST['wsi_disable_shadow_border']) {$wsi_disable_shadow_border='true';} else {$wsi_disable_shadow_border='false';}
update_option('wsi_disable_shadow_border', $wsi_disable_shadow_border);
if ($_POST['wsi_youtube_autoplay']) {$wsi_youtube_autoplay='true';} else {$wsi_youtube_autoplay='false';}
update_option('wsi_youtube_autoplay', $wsi_youtube_autoplay);
if ($_POST['wsi_youtube_loop']) {$wsi_youtube_loop='true';} else {$wsi_youtube_loop='false';}
update_option('wsi_youtube_loop', $wsi_youtube_loop);

// Valeurs des onglets
update_option('wsi_youtube',     $_POST['wsi_youtube']);
update_option('wsi_yahoo',       $_POST['wsi_yahoo']);
update_option('wsi_dailymotion', $_POST['wsi_dailymotion']);
update_option('wsi_metacafe',    $_POST['wsi_metacafe']);
update_option('wsi_swf',         $_POST['wsi_swf']);
update_option('wsi_html',        $_POST['wsi_html']);

?>