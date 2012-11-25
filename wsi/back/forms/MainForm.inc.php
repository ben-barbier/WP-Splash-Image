<h3><?php echo __('Configuration','wp-splash-image'); ?> :</h3>

<!-- Infos -->
<?php //echo $this->get_system_info(); ?>

<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
	<?php wp_nonce_field('update','nonce_update_field'); ?>
	<input type="hidden" name="action" value="update" />
	<?php /* TODO: lorsqu'il y aura plusieurs splash screen, gérer cet ID */ ?>
	<input type="hidden" name="id" value="1" />
	<table>
		<tr>
			<td><?php echo __('Splash image activated','wp-splash-image'); ?> : </td>
			<td><input 
				type="checkbox" 
				name="splash_active" 
				id="splash_active" 
				<?php if($configBean->isSplash_active()=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
		<tr>
		<td><?php echo __('First load mode activated','wp-splash-image'); ?> : </td>
			<td><input 
				type="checkbox" 
				name="wsi_first_load_mode_active"
				id="wsi_first_load_mode_active" 
				<?php if($configBean->isWsi_first_load_mode_active()=='true') {echo("checked='checked'");} ?> />
				
				<img id="wsi_first_load_mode_info" alt="<?php echo __('Info','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/info-16px.png" />	
				<div class="tooltipLarge">
					You can display the WSI <strong>after</strong> the page without any modification.
					If you want to display the WSI <strong>before</strong> the page, you must enable
					the "First load mode" option and add the code <code>&lt;?php do_action('wsi_first_load_mode'); ?&gt;</code>
					after the <code>&lt;body&gt;</code> tag of your current theme <br />(<?php echo WsiCommons::getCurrentTheme(); ?>).
				</div>
				
			</td>
		</tr>
		<tr>
			<td><?php echo __('Hide Splash image on mobile devices','wp-splash-image'); ?> : </td>
			<td><input 
				type="checkbox" 
				name="wsi_hide_on_mobile_devices" 
				id="wsi_hide_on_mobile_devices" 
				<?php if($siBean->isWsi_hide_on_mobile_devices()=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
	</table>
	<br />
	<!-- Tabs --> 
	<div id="tabs">
		<ul> 
			<li><a href="#tab_picture"><img src="<?php echo WsiCommons::getURL(); ?>/style/tabs/picture.png" /><?php echo __('Picture'); ?></a></li> 
			<li><a href="#tab_video"><img src="<?php echo WsiCommons::getURL(); ?>/style/tabs/video.png" /><?php echo __('Video'); ?></a></li> 
			<li><a href="#tab_HTML"><img src="<?php echo WsiCommons::getURL(); ?>/style/tabs/html.png" /><?php echo __('HTML'); ?></a></li>
			<li><a href="#tab_include"><img src="<?php echo WsiCommons::getURL(); ?>/style/tabs/file.gif" /><?php echo __('Include'); ?></a></li>  
		</ul> 
		<div class="panes">
			<?php require("tabs/PictureTab.inc.php"); ?>
			<?php require("tabs/VideoTab.inc.php"); ?>
			<?php require("tabs/HtmlTab.inc.php"); ?>
			<?php require("tabs/IncludeTab.inc.php"); ?>
		</div>
	</div>
	<!-- /Tabs --> 
	<h3><?php echo __('Dates','wp-splash-image'); ?> :</h3>
	<table>
		<tr id="block_start_date">
			<td><?php echo __('Start date','wp-splash-image'); ?> : </td>
			<td><input 
				type="date" 
				name="datepicker_start" 
				id="datepicker_start" 
				value="<?php echo ($siBean->getDatepicker_start()!=null)?date_create($siBean->getDatepicker_start())->format('Y-m-d'):''; ?>" />&nbsp;
				<?php echo __('(stay empty if not required)','wp-splash-image'); ?></td>
			<td style="width:15px;"></td>
			<td rowspan="3" style="padding:10px;border:2px solid #FF0000;display:none;background-color:#ff8b88" id="box_datepickers_warning">
				<span class="warning"><?php echo __('Warning','wp-splash-image'); ?></span><br />
				<?php echo __('WSI does not currently work.','wp-splash-image'); ?><br />
				<?php echo __('Check if dates are OK.','wp-splash-image'); ?>
			</td>
		</tr>
		<tr id="block_end_date">
			<td><?php echo __('End date','wp-splash-image'); ?> : </td>
			<td><input 
				type="date" 
				name="datepicker_end" 
				id="datepicker_end" 
				value="<?php echo ($siBean->getDatepicker_end()!=null)?date_create($siBean->getDatepicker_end())->format('Y-m-d'):''; ?>" />&nbsp;
				<?php echo __('(stay empty if not required)','wp-splash-image'); ?></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td><?php echo __('Server date','wp-splash-image'); ?> : </td>
			<td>&nbsp;<?php echo date("Y-m-d H:i:s"); ?></td>
			<td colspan="2"></td>
		</tr>
	</table>
	
	<h3><?php echo __('Closure methods','wp-splash-image'); ?> :</h3>
	<table>
		<tr>
			<td><?php echo __('Close on press','wp-splash-image'); ?> <img alt="ESC" src="<?php echo WsiCommons::getURL(); ?>/style/esc_button.png" class="esc_button"> <?php echo __('button','wp-splash-image'); ?> : </td>
			<td><input 
				type="checkbox" 
				name="wsi_close_on_esc_function" 
				id="wsi_close_on_esc_function" 
				<?php if($siBean->isWsi_close_on_esc_function()=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
		<tr>
			<td><?php echo __('Close on click over the splash image','wp-splash-image'); ?> : </td>
			<td><input 
				type="checkbox" 
				name="wsi_close_on_click_function" 
				id="wsi_close_on_click_function" 
				<?php if($siBean->isWsi_close_on_click_function()=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
		<tr>
			<td><?php echo __('Hide','wp-splash-image'); ?>&nbsp;<img src="<?php echo WsiCommons::getURL(); ?>/style/jqueryTools/close.png" class="little_cross" /> : </td>
			<td><input 
				type="checkbox" 
				name="wsi_hide_cross" 
				id="wsi_hide_cross" 
				<?php if($siBean->isWsi_hide_cross()=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
	</table>
	
	<h3><?php echo __('Style','wp-splash-image'); ?> :</h3>
	<table>
		<tr>
			<td><?php echo __('Disable shadow border','wp-splash-image'); ?> : </td>
			<td><input
				type="checkbox" 
				name="wsi_disable_shadow_border" 
				id="wsi_disable_shadow_border" 
				<?php if($siBean->isWsi_disable_shadow_border()=='true') {echo("checked='checked'");} ?> />
				(<?php echo __('useful for images with transparent edges','wp-splash-image'); ?>)</td>
		</tr>
		<tr>
			<td><?php echo __('Fixed mode','wp-splash-image'); ?> : </td>
			<td><input
				type="checkbox" 
				name="wsi_fixed_splash" 
				id="wsi_fixed_splash" 
				<?php if($siBean->isWsi_fixed_splash()=='true') {echo("checked='checked'");} ?> />
				<?php echo __('fix the splashcreen to scrollbars','wp-splash-image'); ?>
				(<?php echo __('useful for images with big size','wp-splash-image'); ?>)</td>
		</tr>
		<tr>
			<td><?php echo __("Splash height",'wp-splash-image'); ?> : </td>
			<td><input
				type="number"
				min="210"
				name="splash_image_height"
				id="splash_image_height"
				size="6" maxlength="4"
				value="<?php echo $siBean->getSplash_image_height(); ?>" />&nbsp;px (min = 210px)</td>
		</tr>
		<tr>
			<td><?php echo __("Splash width",'wp-splash-image'); ?> : </td>
			<td><input
				type="number"
				name="splash_image_width"
				id="splash_image_width"
				size="6" maxlength="4"
				value="<?php echo $siBean->getSplash_image_width(); ?>" />&nbsp;px</td>
		</tr>
		<tr>
			<td><?php echo __("Splash margin-top",'wp-splash-image'); ?> : </td>
			<td><input
				type="number"
				name="wsi_margin_top"
				id="wsi_margin_top"
				min="-10000"
				max="10000"
				value="<?php echo $siBean->getWsi_margin_top(); ?>" />&nbsp;px
				(<?php echo __('leave empty for WSI manages the position.','wp-splash-image'); ?>)</td>
		</tr>
		<tr>
			<td><?php echo __('Background color','wp-splash-image'); ?> : </td>
			<td>
				<table style="border-spacing: 0px;">
					<tr>
						<td>#<input
							type="text"
							name="splash_color"
							id="splash_color"
							size="6" maxlength="6"
							value="<?php echo $siBean->getSplash_color(); ?>" /></td>
						<td><div id="splash_color_demo"></div></td>
						<td><a href="http://www.w3schools.com/tags/ref_colorpicker.asp"><?php echo __('Color Picker Online'); ?></a></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><?php echo __('Background opacity','wp-splash-image'); ?> : </td>
			<td colspan="3">
				<input type="range" name="wsi_opacity" min="0" max="100" value="<?php echo $siBean->getWsi_opacity(); ?>" />&nbsp;%
			</td>
		</tr>
		<tr>
			<td><?php echo __('Display time','wp-splash-image'); ?> : </td>
			<td colspan="3" style="white-space: nowrap;">
				<input type="number" name="wsi_display_time" min="0" value="<?php echo $siBean->getWsi_display_time(); ?>" />&nbsp;
				<?php echo __('seconds','wp-splash-image'); ?>&nbsp;
				<?php echo __("(0 don't close automaticly the splash image)",'wp-splash-image'); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo __('Display always','wp-splash-image'); ?> : </td>
			<td><input
				type="checkbox" 
				name="wsi_display_always" 
				id="wsi_display_always" 
				<?php if($siBean->isWsi_display_always()=='true') {echo("checked='checked'");} ?> />
				<?php echo __('Display the splash image on each pages for each users (not recommended for comfort of users).','wp-splash-image'); ?>
			</td>
		</tr>
		<tr id="block_idle_time">
			<td><?php echo __('Idle time','wp-splash-image'); ?> : </td>
			<td colspan="3" style="white-space: nowrap;">
				<input
					type="number"
					min="1"
					name="wsi_idle_time"
					size="6" maxlength="4"
					value="<?php echo $siBean->getWsi_idle_time(); ?>" />&nbsp;
					<?php echo __('minutes of user inactivity before re-emergence of wsi.','wp-splash-image'); ?>&nbsp;
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php echo __('Update'); ?>" />
		<input id="live_preview_button" type="button" value="<?php echo __( 'Live Preview' ); ?>" />
	</p>
	<div id="live_preview_div"></div>

</form>