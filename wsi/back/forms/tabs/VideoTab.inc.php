<div id="tab_video" class="tab">
	<table>
		<tr id="box_youtube" class="box_type">
			<td>
                <input type="radio"
                       id="radio_youtube"
                       name="wsi_type"
                       class="with-gap"
                       value="youtube" <?php if($siBean->getWsi_type()=="youtube") echo('checked="checked"') ?> />
                <label for="radio_youtube"></label>
            </td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/youtube.png" alt="" /></td>
			<td>
				<span>
					<?php echo __('Youtube code'); ?>
					<a class="modal-trigger" href="#wsi_youtube_info_modal">
						<img id="wsi_youtube_info" alt="<?php echo __('Info','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/info-16px.png" />
					</a>:
				</span>
				<div id="wsi_youtube_info_modal" class="modal">
					<div class="modal-content">
						<div style="width: 350px;">
							<img alt="<?php echo __('Youtube code info','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/youtube-url.png" />
							<div style="float: right;"><?php echo __('This is the youtube video code.','wp-splash-image'); ?></div>
						</div>
					</div>
					<div class="modal-footer">
				    	<a href="#!" class=" modal-action modal-close btn-flat"><?php echo __('Close','wp-splash-image'); ?></a>
				    </div>
				</div>
			</td>
			<td>
				<input type="text"
                       name="wsi_youtube"
                       id="wsi_youtube"
                       class="video-code"
                       value="<?php echo $siBean->getWsi_youtube(); ?>" />
				&nbsp;&nbsp;&nbsp;
				<input
					type="checkbox"
					name="wsi_youtube_autoplay"
					id="wsi_youtube_autoplay"
					<?php if($siBean->isWsi_youtube_autoplay()=='true') {echo("checked='checked'");} ?> />
                <label for="wsi_youtube_autoplay"><?php echo __('Autoplay'); ?></label>
				&nbsp;&nbsp;&nbsp;
				<input
					type="checkbox"
					name="wsi_youtube_loop"
					id="wsi_youtube_loop"
					<?php if($siBean->isWsi_youtube_loop()=='true') {echo("checked='checked'");} ?> />
                <label for="wsi_youtube_loop"><?php echo __('Loop'); ?></label>
			</td>
		</tr>
		<tr id="box_yahoo" class="box_type">
			<td>
                <input type="radio"
                       id="radio_yahoo"
                       name="wsi_type"
                       class="with-gap"
                       value="yahoo" <?php if($siBean->getWsi_type()=="yahoo") echo('checked="checked"') ?> />
                <label for="radio_yahoo"></label>
            </td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/yahoo.png" alt="" /></td>
			<td><span><?php echo __('Yahoo video code'); ?>:</span></td>
			<td><input type="text" name="wsi_yahoo" id="wsi_yahoo" class="video-code" value="<?php echo $siBean->getWsi_yahoo(); ?>" /></td>
		</tr>
		<tr id="box_dailymotion" class="box_type">
			<td>
                <input type="radio"
                       id="radio_dailymotion"
                       name="wsi_type"
                       class="with-gap"
                       value="dailymotion" <?php if($siBean->getWsi_type()=="dailymotion") echo('checked="checked"') ?> />
                <label for="radio_dailymotion"></label>
            </td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/dailymotion.png" alt="" /></td>
			<td><span><?php echo __('Dailymotion code'); ?>:</span></td>
			<td><input type="text" name="wsi_dailymotion" id="wsi_dailymotion" class="video-code" value="<?php echo $siBean->getWsi_dailymotion(); ?>" /></td>
		</tr>
		<tr id="box_metacafe" class="box_type">
			<td>
                <input type="radio"
                       id="radio_metacafe"
                       name="wsi_type"
                       class="with-gap"
                       value="metacafe" <?php if($siBean->getWsi_type()=="metacafe") echo('checked="checked"') ?> />
                <label for="radio_metacafe"></label>
            </td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/metacafe.png" alt="" /></td>
			<td><span><?php echo __('Metacafe code'); ?>:</span></td>
			<td><input type="text" name="wsi_metacafe" id="wsi_metacafe" class="video-code" value="<?php echo $siBean->getWsi_metacafe(); ?>" /></td>
		</tr>
		<tr id="box_swf" class="box_type">
			<td>
                <input type="radio"
                       id="radio_swf"
                       name="wsi_type"
                       class="with-gap"
                       value="swf" <?php if($siBean->getWsi_type()=="swf") echo('checked="checked"') ?> />
                <label for="radio_swf"></label>
            </td>
			<td><img src="<?php echo WsiCommons::getURL(); ?>/style/swf.png" alt="" /></td>
			<td><span><?php echo __('Video Flash (URL)'); ?>:</span></td>
			<td><input size="70" type="text" name="wsi_swf" id="wsi_swf" value="<?php echo $siBean->getWsi_swf(); ?>" /></td>
		</tr>
	</table>
</div>
