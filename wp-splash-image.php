<?php
/*
Plugin Name: WP Splash Image
Plugin URI: http://wordpress.org/extend/plugins/wsi/
Description: WP Splash Image is a plugin for Wordpress to display an image with a lightbox type effect at the opening of the blog.
Version: 3.0.1
Author: Benjamin Barbier
Author URI: http://www.dark-sides.com/
Donate URI: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C
*/

include 'wsi/beans/ConfigBean.class.php';
include 'wsi/beans/SplashImageBean.class.php';
include 'wsi/DAO/MainManager.class.php';
include 'wsi/DAO/ConfigManager.class.php';
include 'wsi/DAO/SplashImageManager.class.php';
include 'wsi/WsiCommons.class.php';
include 'wsi/front/WsiFront.class.php';
include 'wsi/back/WsiBack.class.php';

define("WSI_DB_VERSION", "2.4");
define("JQUERY_TOOLS_FILES_VERSION", "3"); // Used to refresh browser cache

WsiBack::getInstance()->plug();
WsiFront::getInstance()->plug();

?>