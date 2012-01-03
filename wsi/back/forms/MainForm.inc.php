<h3><?php echo __('Configuration','wp-splash-image'); ?></h3>
<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
	<?php wp_nonce_field('update','nonce_update_field'); ?>
	<input type="hidden" name="action" value="update" />
	<table>
		<tr>
			<td><?php echo __('Splash image activated','wp-splash-image'); ?>:</td>
			<td><input 
				type="checkbox" 
				name="splash_active" 
				id="splash_active" 
				<?php if(get_option('splash_active')=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
		<tr id="block_splash_test_active">
			<td><?php echo __('Test mode activated:','wp-splash-image'); ?></td>
			<td><input 
				type="checkbox" 
				name="splash_test_active" 
				id="splash_test_active" 
				<?php if(get_option('splash_test_active')=='true') {echo("checked='checked'");} ?> />
				<?php echo __('(for tests only, open splash image whenever)','wp-splash-image'); ?></td>
		</tr>
	</table>	
	<br />
	<!-- Tabs --> 
	<div  id="tabs" style="width:850px;">
		<ul> 
			<li><a href="#tab_picture"><?php echo __('Picture'); ?></a></li> 
			<li><a href="#tab_video"><?php echo __('Video'); ?></a></li> 
			<li><a href="#tab_HTML"><?php echo __('HTML'); ?></a></li> 
		</ul> 
		<div class="panes">
			<?php require("tabs/PictureTab.inc.php"); ?>
			<?php require("tabs/VideoTab.inc.php"); ?>
			<?php require("tabs/HtmlTab.inc.php"); ?>
		</div>
	</div>
	<!-- /Tabs --> 
	<br />
	<table>
		<tr>
			<td><?php echo __('Close esc function','wp-splash-image'); ?>:</td>
			<td><input 
				type="checkbox" 
				name="wsi_close_esc_function" 
				<?php if(get_option('wsi_close_esc_function')=='true') {echo("checked='checked'");} ?> />
				(<?php echo __('if you click on background','wp-splash-image'); ?>)</td>
		</tr>
		<tr>
			<td><?php echo __('Hide','wp-splash-image'); ?>&nbsp;<img src="<?php echo WsiCommons::getURL(); ?>/style/close.png" class="little_cross" />&nbsp;:</td>
			<td><input 
				type="checkbox" 
				name="wsi_hide_cross" 
				<?php if(get_option('wsi_hide_cross')=='true') {echo("checked='checked'");} ?> /></td>
		</tr>
		<tr>
			<td><?php echo __('Disable shadow border','wp-splash-image'); ?>:</td>
			<td><input
				type="checkbox" 
				name="wsi_disable_shadow_border" 
				<?php if(get_option('wsi_disable_shadow_border')=='true') {echo("checked='checked'");} ?> />
				(<?php echo __('useful for images with transparent edges','wp-splash-image'); ?>)</td>
		</tr>
		<tr>
			<td><?php echo __("Splash height",'wp-splash-image'); ?>:</td>
			<td><input
				type="text"
				name="splash_image_height"
				id="splash_image_height"
				size="6" maxlength="4"
				value="<?php echo esc_attr(get_option('splash_image_height')); ?>" />&nbsp;px (min = 210px)</td>
		</tr>
		<tr>
			<td><?php echo __("Splash width",'wp-splash-image'); ?>:</td>
			<td><input
				type="text"
				name="splash_image_width"
				id="splash_image_width"
				size="6" maxlength="4"
				value="<?php echo esc_attr(get_option('splash_image_width')); ?>" />&nbsp;px</td>
		</tr>
		<tr>
			<td><?php echo __('Background color','wp-splash-image'); ?>:</td>
			<td>
				<table style="border-spacing: 0px;">
					<tr>
						<td>#<input
							type="text"
							name="splash_color"
							id="splash_color"
							size="6" maxlength="6"
							value="<?php echo esc_attr(get_option('splash_color')); ?>" /></td>
						<td><div id="splash_color_demo"></div></td>
						<td><a href="http://www.w3schools.com/tags/ref_colorpicker.asp"><?php echo __('Color Picker Online'); ?></a></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><?php echo __('Background opacity','wp-splash-image'); ?>:</td>
			<td colspan="3">
				<input type="range" name="wsi_opacity" min="0" max="100" value="<?php echo esc_attr(get_option('wsi_opacity')); ?>" />&nbsp;%
			</td>
		</tr>
		<tr>
			<td><?php echo __('Start date','wp-splash-image'); ?>:</td>
			<td><input 
				type="date" 
				name="datepicker_start" 
				id="datepicker_start" 
				value="<?php echo get_option('datepicker_start'); ?>" />&nbsp;
				<?php echo __('(stay empty if not required)','wp-splash-image'); ?></td>
			<td style="width:15px;"></td>
			<td rowspan="2" style="padding:10px;border:2px solid #FF0000;display:none;background-color:#ff8b88" id="box_datepickers_warning">
				<?php echo __('Warning: WSI does not currently work.','wp-splash-image'); ?><br />
				<?php echo __('Check if dates are OK.','wp-splash-image'); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo __('End date','wp-splash-image'); ?>:</td>
			<td><input 
				type="date" 
				name="datepicker_end" 
				id="datepicker_end" 
				value="<?php echo esc_attr(get_option('datepicker_end')); ?>" />&nbsp;
				<?php echo __('(stay empty if not required)','wp-splash-image'); ?></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td><?php echo __('Display time','wp-splash-image'); ?>:</td>
			<td colspan="3" style="white-space: nowrap;">
				<input type="range" name="wsi_display_time" min="0" max="30" value="<?php echo esc_attr(get_option('wsi_display_time')); ?>" />&nbsp;
				<?php echo __('seconds','wp-splash-image'); ?>&nbsp;
				<?php echo __("(0 don't close automaticly the splash image)",'wp-splash-image'); ?>
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" value="<?php echo __('Update Options','wp-splash-image'); ?>" /></p>
</form>