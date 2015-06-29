<div id="tab_picture" class="tab">
	<table id="box_picture" class="box_type">
		<tr>
			<td rowspan="4">
                <input type="radio"
                       id="radio_picture"
                       name="wsi_type"
                       class="with-gap"
                       value="picture" <?php if($siBean->getWsi_type()=="picture") echo('checked="checked"') ?> />
                <label for="radio_picture"></label>
            </td>
			<td><span class="nowrap"><?php echo __("Picture URL:",'wp-splash-image'); ?></span></td>
			<td><input
				type="url"
				name="url_splash_image"
				id="url_splash_image"
				size="80"
				value="<?php echo $siBean->getUrl_splash_image(); ?>" /></td>
		</tr>
		<tr>
			<td><span class="nowrap"><?php echo __("Picture link URL",'wp-splash-image'); ?>:</span></td>
			<td><input
				type="url"
				name="wsi_picture_link_url"
				id="wsi_picture_link_url"
				size="50"
				value="<?php echo $siBean->getWsi_picture_link_url(); ?>" />
				<?php echo __('(stay empty if not required)','wp-splash-image'); ?></td>
		</tr>
		<tr>
			<td><span class="nowrap"><?php echo __("Picture link target",'wp-splash-image'); ?>:</span></td>
			<td>
				<select name="wsi_picture_link_target" id="wsi_picture_link_target" class="browser-default">
					<option value="self"  <?php if($siBean->getWsi_picture_link_target()=="self")  { ?>selected="selected"<?php } ?>>Self</option>
					<option value="blank" <?php if($siBean->getWsi_picture_link_target()=="blank") { ?>selected="selected"<?php } ?>>Blank</option>
				</select>
			</td>
		</tr>
	</table>
</div>
