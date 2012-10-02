<div id="tab_video">
	<table>
		<tr id="box_youtube" class="box_type">
			<td><input type="radio" id="radio_youtube" name="wsi_type" value="youtube" <?php if($siBean->getWsi_type()=="youtube") echo('checked="checked"') ?> /></td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/youtube.png" alt="" /></td>
			<td>
				<span>
					<?php echo __('Youtube code'); ?>			
					<img id="wsi_youtube_info" alt="<?php echo __('Info','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/info-16px.png" />:
				</span>
				<div class="tooltipLarge_youtubeURL">
					<img id="wsi_youtube_info" alt="<?php echo __('Youtube code info','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/youtube-url.png" />
					<?php echo __('This is the youtube video code.','wp-splash-image'); ?>
				</div>
			</td>
			<td>
				<input type="text" name="wsi_youtube" id="wsi_youtube" value="<?php echo $siBean->getWsi_youtube(); ?>" />
				&nbsp;&nbsp;&nbsp;
				<span><?php echo __('Autoplay'); ?>:</span>
				<input 
					type="checkbox" 
					name="wsi_youtube_autoplay" 
					id="wsi_youtube_autoplay" 
					<?php if($siBean->isWsi_youtube_autoplay()=='true') {echo("checked='checked'");} ?> />
				&nbsp;&nbsp;&nbsp;
				<span><?php echo __('Loop'); ?>:</span>
				<input 
					type="checkbox" 
					name="wsi_youtube_loop" 
					id="wsi_youtube_loop" 
					<?php if($siBean->isWsi_youtube_loop()=='true') {echo("checked='checked'");} ?> />
			</td>
		</tr>
		<tr id="box_yahoo" class="box_type">
			<td><input type="radio" id="radio_yahoo" name="wsi_type" value="yahoo" <?php if($siBean->getWsi_type()=="yahoo") echo('checked="checked"') ?> /></td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/yahoo.png" alt="" /></td>
			<td><span><?php echo __('Yahoo video code'); ?>:</span></td>
			<td><input type="text" name="wsi_yahoo" id="wsi_yahoo" value="<?php echo $siBean->getWsi_yahoo(); ?>" /></td>
		</tr>
		<tr id="box_dailymotion" class="box_type">
			<td><input type="radio" id="radio_dailymotion" name="wsi_type" value="dailymotion" <?php if($siBean->getWsi_type()=="dailymotion") echo('checked="checked"') ?> /></td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/dailymotion.png" alt="" /></td>
			<td><span><?php echo __('Dailymotion code'); ?>:</span></td>
			<td><input type="text" name="wsi_dailymotion" id="wsi_dailymotion" value="<?php echo $siBean->getWsi_dailymotion(); ?>" /></td>
		</tr>
		<tr id="box_metacafe" class="box_type">
			<td><input type="radio" id="radio_metacafe" name="wsi_type" value="metacafe" <?php if($siBean->getWsi_type()=="metacafe") echo('checked="checked"') ?> /></td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/metacafe.png" alt="" /></td>
			<td><span><?php echo __('Metacafe code'); ?>:</span></td>
			<td><input type="text" name="wsi_metacafe" id="wsi_metacafe" value="<?php echo $siBean->getWsi_metacafe(); ?>" /></td>
		</tr>
		<tr id="box_swf" class="box_type">
			<td><input type="radio" id="radio_swf" name="wsi_type" value="swf" <?php if($siBean->getWsi_type()=="swf") echo('checked="checked"') ?> /></td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/swf.png" alt="" /></td>
			<td><span><?php echo __('Video Flash (URL)'); ?>:</span></td>
			<td><input size="70" type="text" name="wsi_swf" id="wsi_swf" value="<?php echo $siBean->getWsi_swf(); ?>" /></td>
		</tr>
	</table>
</div>