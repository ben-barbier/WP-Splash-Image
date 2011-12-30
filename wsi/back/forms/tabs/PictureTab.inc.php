<div id="tab_picture">
	<table id="box_picture" class="box_type">
		<tr>
			<td rowspan="4"><input type="radio" id="radio_picture" name="wsi_type" value="picture" <?php if(get_option('wsi_type')=="picture") echo('checked="checked"') ?> /></td>
			<td><span><?php echo __("Picture URL:",'wp-splash-image'); ?></span></td>
			<td><input 
				type="text" 
				name="url_splash_image"
				id="url_splash_image"
				size="80" 
				value="<?php echo esc_attr(get_option('url_splash_image')); ?>" /></td>
		</tr>
		<tr>
			<td><span><?php echo __("Picture link URL",'wp-splash-image'); ?>:</span></td>
			<td><input 
				type="text" 
				name="wsi_picture_link_url" 
				size="50" 
				value="<?php echo esc_attr(get_option('wsi_picture_link_url')); ?>" />
				<?php echo __('(stay empty if not required)','wp-splash-image'); ?></td>
		</tr>
		<tr>
			<td><span><?php echo __("Picture link target",'wp-splash-image'); ?>:</span></td>
			<td>
				<select name="wsi_picture_link_target" value="<?php echo esc_attr(get_option('wsi_picture_link_target')); ?>">
					<option value="self">Self</option>
					<option value="blank">Blank</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span><?php echo __("Fill picture size",'wp-splash-image'); ?>:</span></td>
			<td>
				<input type="button" value="<?php echo __('Fill'); ?>" id="fill_picture_size_button" />
				<!-- This picture is here only for fill the picture size by script -->
				<img src="" id="img_splash_image" style="display:none;" />
			</td>
		</tr>
	</table>
</div> 