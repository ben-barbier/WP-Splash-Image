=== WP Splash Image ===
Contributors: agent022
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C
Tags: Splash, Image, LightBox, Picture, Video, HTML, Start, Open
Requires at least: 3.1
Tested up to: 3.3.1
Stable tag: 1.9.0
 
WP Splash Image is a plugin for Wordpress to display picture, video or html code with a lightbox effect at the opening of the blog.
 
== Description ==

**WP Splash Image** is a plugin for Wordpress to display picture, video (youtube, yahoo video, dailymotion, metacafe, your own swf file) or html code with a lightbox effect at the opening of the blog.

== Installation ==
 
You can use the built in installer and upgrader, or you can install the plugin manually.

1. You can either use the automatic plugin installer or your FTP program to upload it to your wp-content/plugins directory the top-level folder. Don't just upload all the php files and put them in /wp-content/plugins/.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Visit your WP-Splash-Image options.
1. Configure any options as desired, and then enable the plugin.
1. That's it!

If you have to upgrade manually simply repeat the installation steps and re-enable the plugin.

== Frequently Asked Questions ==

= What's next ? =

* (1.10.0) Show WSI before loading the page.
* (2.0.0) Add "Upload picture" option.
* (3.0.0) Manage WSI date ranges.

Others:

* Update Documentation
* Add option for "exclude" some pages (for flash conflict for exemple)
* Add an information box indicating whether a new version of WSI exists.
* Customize the borders (facebook style, ...)
* Manage reporting (number of views, number of clicks, ...)
* Improve compatibility with akismet infos.
* Add an event system to know when to start WSI (ex: when site is loading, when comment is send ...)

= Hy, can you add an option for open the Splash image ONLY on the first / Home page? =

**NO !**   
If we use WSI with the standards options ("Test mode activated:" = not check), the splah screen will appear once by user (I use a top in HTTP Session) everywhere on your website (when you enter on the site).   
If the user close his browser and if he returns on your website, the WSI returns come back.   
I'll working to an option for "exclude" some pages.   
For exemple, we can use this option for have no confict with some pages with flash.

= None of the tabs not working. What's happend ? =
I worked on the loading javascript scripts using the [best practices](http://codex.wordpress.org/Function_Reference/wp_enqueue_script) described in the codex.   
However, all the wordpress plugins that do not use these best practices for loading scripts, some problems may actually occur.   
Try disabling your other plugins to determine the one (or ones) that cause problems and reactivating one by one.

If we have too many plugins, find it problematic can be really difficult, here's a hint:

1. Go to the configuration page of WSI.
1. View the source of the page.
1. Search "jQuery".

For information, WSI uses: http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=3.0 (through [wp_register_script() and wp_enqueue_script()](http://codex.wordpress.org/Function_Reference/wp_enqueue_script).   
If you see other jquery, look what plugin they are stored and try to disable the plugin.

Good luck.

= I have a problem with others javascripts functions of my theme. What can I do for resolve it ? =

Use code `<?php wp_head(); ?>` before your others scripts imports like `<script type="text/javascript" src="<?php bloginfo('template_directory');?>/scripts/jquery.cycle.all.min.js"></script>`.

= In my blog, nothing happens. Idea? =

Yes, verify if `<?php wp_head(); ?>` and `<?php wp_footer(); ?>` exist in your theme...    
These two methods are necessary for the proper functioning of WSI.

= Sometimes, my splash image is not well centered. Idea ? =
Yes, verify if "Splash height" and "Splash width" properties are properly filled.

== Screenshots ==
 
1. Administration
2. Menu
3. Splash Image
 
== Changelog ==

= 1.9.0 =
* Add "Fixed" option to fix the splashcreen to scrollbars.
* Add "Default value" manager. 
* Fix Background color problem.

= 1.8.0 =
* Add "Idle time" manager (before re-emergence of wsi).

= 1.7.0 =
* Switch from "JQueryTools" (http://flowplayer.org/tools/) to "JQueryUI" (http://jqueryui.com/) for admin tabs management.
* JQuery used is now "Wordpress version" - 1.7.1 on WP 3.3 (frontend and backend).

= 1.6.0 =
* Add Bug Repport when the user use the feedback form.

= 1.5.1 =
* Fix known incompatibility with plugin "Dynamic Content Gallery (v3.3.5)".
* Update fields filter.

= 1.5.0 =
* Refactoring.

= 1.4.0 =
* XSS Secure (Thanks to Julio de [Boiteaweb.fr](http://www.boiteaweb.fr/) for his help).
* Add Security token (nonce management).
* Fix "Parse error: syntax error, unexpected $end" message error on front end.
* Compatible with short_open_tag disabled (php.ini).

= 1.3.4 =
* Update color picker (fix FireFox compatibility problem).
* Add fields filter.

= 1.3.3 =
* Now we can used splash image greater than 999px x 999px.
* Update backoffice display of picture tab.
* Add "fill picture size" option for complete "Splash height" and "Splash width" properties from picture size.

= 1.3.2 =
* Add "autoplay" and "loop" functions for Youtube videos.

= 1.3.1 =
* Add "disable shadow border" option (useful for images with transparent edges).

= 1.3.0 =
* Update plugin to PHP5 (Object Oriented Design).

= 1.2.4 =
* Correct little display problem on Chrome

= 1.2.3 =
* Correct Range Input display problem

= 1.2.2 =
* Correct the bug with "HTML" options and "\" added.

= 1.2.1 =
* Add option for choise the picture link destination (_blank or _self) 

= 1.2.0 =
* Add uninstall option

= 1.1.2 =
* Improvement in include JS  method in front end (OK in back end).
* Improvement in include CSS method in front end (OK in back end).

= 1.1.1 =
* Correct "Hide Cross" bug (compatibility jquery)

= 1.1.0 =
* Add background opacity selector

= 1.0.1 =
* Correct date-input display & behavior bug
* Add Correct French translation
* Adding a warning when the current date is not between the dates of validities.
* Compatibility with [Mystique](http://wordpress.org/extend/themes/mystique) (pb with footer and settings)

= 1.0.0 =
* Add Video Splash
* Add HTML Splah
* Modify IHM (http://flowplayer.org/tools/index.html)

= 0.9.2 =
* Little bugfix (Jquery compatibility) : Thank you to Andre Arends for his info.

= 0.9.1 =
* Add Documentation in plugin

= 0.9 =
* Add link to wsi settings in plugins page.
* Add link to donate in plugins page.
* Add feedback fields validator
* Add optional picture link URL
* Add the ability to close 'ESC' function
* Add the ability to hide the close icon

= 0.8 =
* add feedback form

= 0.7 =
* add option for close automaticly the splash image
* Restrict the range of selectable dates

= 0.6.1 =
* CSS Bug Fix

= 0.6 =
* Improvement made for I18N

= 0.5 =
* Use colorpicker of http://blog.meta100.com/post/600571131/mcolorpicker

= 0.4 =
* Compatibility with Wordpress 3.0 : OK

= 0.3 =
* Add screenshots.

= 0.2 =
* Add test mode
* Add dates validities
* Image size configurable (with calandar)
* Background color configurable (with color picker)
* Mise en place de l'I18N (FR/EN)
 
= 0.1 =
* Init
* popup by jquery
* Image configurable
* Activation configurable

== Upgrade Notice ==

= 1.2.4 =
* RAS

= 1.2.3 =
* RAS

= 1.2.2 =
* RAS

= 1.2.1 =
* RAS

= 1.2.0 =
* RAS

= 1.1.2 =
* RAS

= 1.1.1 =
* RAS

= 1.1.0 =
* RAS

= 1.0.1 =
* RAS

= 1.0.0 =
* RAS

= 0.9.2 =
* RAS

= 0.9.1 =
* RAS

= 0.9 =
* RAS

= 0.8 =
* RAS

= 0.7 =
* RAS

= 0.6.1 =
* RAS

= 0.6 =
* RAS

= 0.5 =
* RAS

= 0.4 =
* RAS

= 0.3 =
* RAS

= 0.2 =
* RAS

= 0.1 =
* Init

`<?php code(); // goes in backticks ?>`