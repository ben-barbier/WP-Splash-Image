
<!-- ------------------- -->
<!-- Documentation Form  -->
<!-- ------------------- -->

<div id="info" class="overlay" style="display:none;background-image:url(<?php echo WsiCommons::getURL(); ?>/style/petrol.png);color:#fff;width:620px;height:530px;margin:40px;">
	<div style="font-weight:bold;font-size:20px;margin-bottom:10px;">Infos :</div>
	<img src="<?php echo WsiCommons::getURL(); ?>/style/info_legende.jpg" style="float:left;margin-right:15px;" />
	WP Splash Image display picture if 3 conditions are OK: <br />
	<ul style="list-style-type:disc;list-style-position:inside;">
		<li><span class="plugin_title"><?php echo __('Splash image activated','wp-splash-image'); ?></span> is checked</li>
		<li>Current date is less than or equal to <span class="plugin_title"><?php echo __('End date','wp-splash-image'); ?></span>.</li>
		<li>Current date is greater than or equal to <span class="plugin_title"><?php echo __('Start date','wp-splash-image'); ?></span>.</li>
	</ul>
	<span class="plugin_number">1)</span>
	We can change the <span class="plugin_title"><?php echo __('Background color','wp-splash-image'); ?></span> with the color code.<br />
	If you click on the background, you'll quit the splash image except if <span class="plugin_title"><?php echo __('Close esc function','wp-splash-image'); ?></span> is checked.
	<br /><br />
	<span class="plugin_number">2)</span>
	The <img src="<?php echo WsiCommons::getURL(); ?>/style/jqueryTools/close.png" class="little_cross" /> can be <span class="plugin_title"><?php echo __('Hide','wp-splash-image'); ?></span>.
	We can use this option with :
	<ul style="list-style-type:disc;list-style-position:inside;">
		<li><span class="plugin_title"><?php echo __('Close esc function','wp-splash-image'); ?></span></li>
		<li><span class="plugin_title"><?php echo __("Picture link URL",'wp-splash-image'); ?></span></li>
	</ul>
	for advertisment for exemple.
	<br />
	<span class="plugin_number">3)</span>
	For the picture, we can specify the
	<span class="plugin_title"><?php echo __("Picture height",'wp-splash-image'); ?></span>
	and the
	<span class="plugin_title"><?php echo __("Picture width",'wp-splash-image'); ?></span>.
	<br />
	If we fill the <span class="plugin_title"><?php echo __('Display time','wp-splash-image'); ?></span> field, the splash screen disappear after this value (in second).
	<br />
	<p>
		<?php echo __('For information:','wp-splash-image'); ?> <a target="_blank" href="http://fr.wikipedia.org/wiki/Splash_screen">Splash Screen</a>
	</p>
</div>