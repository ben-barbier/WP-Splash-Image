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
update_option('splash_active',             ($_POST['splash_active'])?'true':'false');
update_option('splash_test_active',        ($_POST['splash_test_active'])?'true':'false');
update_option('wsi_close_esc_function',    ($_POST['wsi_close_esc_function'])?'true':'false');
update_option('wsi_hide_cross',            ($_POST['wsi_hide_cross'])?'true':'false');
update_option('wsi_disable_shadow_border', ($_POST['wsi_disable_shadow_border'])?'true':'false');
update_option('wsi_youtube_autoplay',      ($_POST['wsi_youtube_autoplay'])?'true':'false');
update_option('wsi_youtube_loop',          ($_POST['wsi_youtube_loop'])?'true':'false');
update_option('wsi_fixed_splash',          ($_POST['wsi_fixed_splash'])?'true':'false');

// Valeurs des onglets
update_option('wsi_youtube',     $_POST['wsi_youtube']);
update_option('wsi_yahoo',       $_POST['wsi_yahoo']);
update_option('wsi_dailymotion', $_POST['wsi_dailymotion']);
update_option('wsi_metacafe',    $_POST['wsi_metacafe']);
update_option('wsi_swf',         $_POST['wsi_swf']);
update_option('wsi_html',        $_POST['wsi_html']);

?>