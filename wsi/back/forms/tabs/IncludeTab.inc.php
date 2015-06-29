<div id="tab_include" class="tab">

    <p id="box_include" class="box_type">
        <input type="radio"
               id="radio_include"
               name="wsi_type"
               class="with-gap"
               value="include" <?php if($siBean->getWsi_type()=="include") echo('checked="checked"') ?> />
        <label for="radio_include"><?php echo __("Include URL",'wp-splash-image'); ?> : </label>
        <input type="url"
            name="wsi_include_url"
            id="wsi_include_url"
            size="80"
            value="<?php echo $siBean->getWsi_include_url(); ?>" />
    </p>


<!--	<table id="box_include" class="box_type">-->
<!--		<tr>-->
<!--			<td><input type="radio" id="radio_include" name="wsi_type" value="include" --><?php //if($siBean->getWsi_type()=="include") echo('checked="checked"') ?><!-- /></td>-->
<!--			<td><span>--><?php //echo __("Include URL:",'wp-splash-image'); ?><!--</span></td>-->
<!--			<td><input -->
<!--				type="url" -->
<!--				name="wsi_include_url"-->
<!--				id="wsi_include_url"-->
<!--				size="80" -->
<!--				value="--><?php //echo $siBean->getWsi_include_url(); ?><!--" /></td>-->
<!--		</tr>-->
<!--	</table>-->
</div>
