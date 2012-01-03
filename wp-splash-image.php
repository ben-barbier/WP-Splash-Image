<?php
/*
Plugin Name: WP Splash Image
Plugin URI: http://wordpress.org/extend/plugins/wsi/
Description: WP Splash Image is a plugin for Wordpress to display an image with a lightbox type effect at the opening of the blog.
Version: 1.7.0
Author: Benjamin Barbier
Author URI: http://www.dark-sides.com/
Donate URI: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C
*/

include 'wsi/WsiCommons.class.php';
include 'wsi/front/WsiFront.class.php';
include 'wsi/back/WsiBack.class.php';

WsiBack::getInstance()->plug();
WsiFront::getInstance()->plug();

?>