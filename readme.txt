=== WP Splash Image ===
Contributors: agent022
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C
Tags: Splash, Image, LightBox, Picture, Video, HTML, Start, Open, Screen, Welcome, Message, popup, pop-up
Requires at least: 3.3
Tested up to: 4.2.2
Stable tag: 3.0.1

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

* (3.0.X) Fix users requests (no new features before it).
* (3.1.0) Add feature to upload images.

Others:

* Update Documentation.
* Add option for "exclude" some pages (for flash conflict for exemple).
* Manage reporting (number of views, number of clicks, ...).
* Add an event system to know when to start WSI (ex: when site is loading, when comment is send ...).
* Customize the borders (facebook style, ...).

= Hey, can you add an option for open the Splash image ONLY on the first / Home page? =

**NO !**  
If we use WSI with the standards options, the splah screen will appear once by user everywhere on your website (WSI save the last display time in user HTTP Session).
If the user close his browser and if he returns on your website, the WSI come back.  
I'll working to an option to "exclude" some pages.
For exemple, we can use this future option to have no confict with some pages with flash.

= Can I use the splash screen once only when first loading to the site, and not repeating with each page I visit? =

**Yes, we can ! ;-)**
We can use the Idle Time to select the time of inactivity between 2 splash screen.
For example, if the "idle time" is "30", the user come on your website and see the splash screen.
If he navigate on your website, he don't show the splash screen a second time.
But if he wait 30 minutes with no click, the splash screen come a second time if he returns to the website.

= I have a problem with other javascripts functions of my theme. What can I do to resolve it ? =

Use code `<?php wp_head(); ?>` before your others scripts imports like `<script type="text/javascript" src="<?php bloginfo('template_directory');?>/scripts/jquery.cycle.all.min.js"></script>`.

= In my blog, nothing happens. Idea? =

Yes, verify if `<?php wp_head(); ?>` and `<?php wp_footer(); ?>` exists in your theme...   
These two methods are necessary for the correct functioning of WSI.

List of plugins not working with WP-Splah-Image :
* [nivo-slider-for-wordpress](http://wordpress.org/extend/plugins/nivo-slider-for-wordpress/)

= Sometimes, my splash image is not centered. Idea ? =
Yes, verify if "Splash height" and "Splash width" properties are correctly entered.

= Despite all this information, my problem persists... What to do ? =
1. In the case of an update, try uninstall / reinstall the plugin.
1. If that does not work, create a ticket in the [support page](http://wordpress.org/support/plugin/wsi).
1. Also send me a message from the plugin (menu feedback) taking care to check the "Send Info" option.

*If the problem is in the plugin administration page :*
1. Disable all your other plugins and test again.
1. If it works, enable one plugin and test again.
1. Repeat until you identify the plugin that is not compatible with wsi.
1. Once identified, send me the name and the version of the non compatible plugin via the [support page](http://wordpress.org/support/plugin/wsi).
If there is still a problem in the admin page even after disabling all your plugins, it may be your theme is causing the problem.
Send me the name and the version of the non compatible theme via the [support page](http://wordpress.org/support/plugin/wsi).

*If the problem concerns the display of the WSI into your website :*
You can also email me the source code of the page on which you expect to see the splash image (feedback@dark-sides.com).

== Screenshots ==

1. Administration
2. Menu
3. Splash Image
4. Dates settings
5. Closure methods setting
6. Style setting

== Changelog ==

= 3.0.1 =
* Fix plugin contiguration for PHP < 5.4

= 3.0.0 =
* Update plugin compatibility to wordpress 4.2.2
* Change admin design (with [MaterializeCSS](http://materializecss.com/))
* Optimize jQuery integration
* Update translations
* Add [Gitter](https://gitter.im/ben-barbier/WP-Splash-Image) integration
* Change wordpress banner

= 2.7.2 =
* Change display time to new input type "number" (no limit).

= 2.7.1 =
* Update wsi close methods.
* Display server time.

= 2.7.0 =
* Add option to hide splash image on mobile devices.

= 2.6.6 =
* Manage jQuery-tools files versions (for refresh browsers cache).

= 2.6.5 =
* Fix jQuery problem on admin page (let wordpress manage the jquery-ui-tabs).

= 2.6.4 =
* Fix jQuery problem with some themes (before the fix, the splash image don't display in some themes).

= 2.6.3 =
* Add Youtube code info

= 2.6.2 =
* Fix dates problem. Now they can be null.

= 2.6.1 =
* Fix problem with jQuery 1.8.2 (now, WSI integrate is own version of jQuery in JqueryTools).

= 2.6.0 =
* Replace old HTML editor by new WYSIWYG wordpress editor (http://codex.wordpress.org/Function_Reference/wp_editor)

= 2.5.5 =
* Add a new option to manage the border-top of the splash image.

= 2.5.4 =
* Fix HTML include problem (increase the HTML content field size from 255 to 4294967295 (LONGTEXT) caracters max).

= 2.5.3 =
* Fix YouTube "Live Preview" error (don't display).
* Fix "Display time : 0" = don't close automaticly the splash image in "Live Preview" (Before the fix, the splash image is immediatly close in "Live Preview").

= 2.5.2 =
* Remove uninstall button. The uninstall function is now manage by "uninstall.php" file (automatic).
* Fix install error with WP since 3.1 (wsi tables non created).

= 2.5.1 =
* Fix install error (unexpected T_PAAMAYIM_NEKUDOTAYIM).

= 2.5.0 =
* Update persistance method (use new tables). -> http://codex.wordpress.org/Creating_Tables_with_Plugins
* Add "demo" button to display splah image in wsi settings page
* Replace "Test mode" by "Display always" mode

= 2.4.0 =
* Work on incompatibility with "WP super cache" (it desactivate sessions and splash screen display all the time). I've set the session in cookie to fix it (tkx to Emmanuel Barraud of [laclefnumerique.com](http://www.laclefnumerique.com/) for his help).

= 2.3.2 =
* Add Turkish translation (tkx to [Murat DURGUN](http://www.lanwifi.net/))

= 2.3.1 =
* Fix HTML Tab content (tkx to [Synchro](http://wordpress.org/support/topic/plugin-wp-splash-image-adds-excess-slashes-in-html-tab) for his comment).

= 2.3.0 =
* Add a new tab "Include".
* On load plugin, the active tab is open.
* Add Tabs icons.

= 2.2.3 =
* Update back office fields in HTML5 input types (http://www.w3schools.com/html5/html5_form_input_types.asp)

= 2.2.2 =
* Add icon "Pay me a beer".

= 2.2.1 =
* Fix css folder problem on v2.2.0.

= 2.2.0 =
* Update tooltip style.
* Add Settings on plugin page.

= 2.1.0 =
* Add 1rst mode load (show WSI before loading the page).

= 2.0.1 =
* Fix Picture link target list selected problem (tkx to Beee for his comment).
* Update Github link.

= 2.0.0 =
* Start GitHub source management
* Centralize Data access (DAO layer)
* Fix uninstall problem (on last step)
* Add an information box indicating whether a new version of WSI exists.
* Fix HTML problem (leave escape carac filter).

= 1.9.1 =
* Improve compatibility with wordpress infos messages.

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
* XSS Secure - Thanks to Julio ([Boiteaweb.fr](http://www.boiteaweb.fr/)) for his help.
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
* Adding a warning when the current date is not between the validity dates.
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
* add option to close automatically the splash image
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

`<?php code(); // goes in backticks ?>`
