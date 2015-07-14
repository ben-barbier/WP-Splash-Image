
<!-- Infos -->
<?php //echo $this->get_system_info(); ?>

<?php

    function selectActiveTab($type, $index) {

        // Chargement des onglets
        $index_tab = array();
        $index_tab["picture"]     = 0;
        $index_tab["youtube"]     = 1;
        $index_tab["yahoo"]       = 1;
        $index_tab["dailymotion"] = 1;
        $index_tab["metacafe"]    = 1;
        $index_tab["swf"]         = 1;
        $index_tab["html"]        = 2;
        $index_tab["include"]     = 3;

        foreach ($index_tab as $key => $value){
            if ($key == $type && $value == $index) {
                return 'class="active"';
                break;
            }
        }

    }

?>

<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
	<?php wp_nonce_field('update','nonce_update_field'); ?>
	<input type="hidden" name="action" value="update" />
	<?php /* TODO: lorsqu'il y aura plusieurs splash screen, gérer cet ID */ ?>
	<input type="hidden" name="id" value="1" />

	<p>
	    <div class="switch">
	        <label>
				<?php echo __('Splash image activated','wp-splash-image'); ?> :
	            <input type="checkbox"
	                name="splash_active"
	                id="splash_active"
	                <?php if($configBean->isSplash_active()=='true') {echo("checked='checked'");} ?> />
	            <span class="lever"></span>
	        </label>
	    </div>
	</p>

    <p>
        <input type="checkbox"
               name="wsi_first_load_mode_active"
               id="wsi_first_load_mode_active"
            <?php if($configBean->isWsi_first_load_mode_active()=='true') {echo("checked='checked'");} ?> />
        <label for="wsi_first_load_mode_active">
            <?php echo __('First load mode activated','wp-splash-image'); ?>
            <a class="modal-trigger" href="#wsi_first_load_mode_info_modal">
			<img id="wsi_first_load_mode_info"
                  alt="<?php echo __('Info','wp-splash-image'); ?>"
                  src="<?php echo WsiCommons::getURL(); ?>/style/info-16px.png" />
			</a>
            <div id="wsi_first_load_mode_info_modal" class="modal">
				<div class="modal-content">
	                You can display the WSI <strong>when your website is completely loaded</strong> without any modification.
	                If you want to display the WSI <strong>before</strong> the page, you need to enable
	                the "First load mode" option and add the code :
					<br /><br />
					<code>&lt;?php do_action('wsi_first_load_mode'); ?&gt;</code>
					<br /><br />
	                after the <code>&lt;body&gt;</code> tag of your theme (<?php echo WsiCommons::getCurrentTheme(); ?>).
				</div>
				<div class="modal-footer">
			    	<a href="#!" class=" modal-action modal-close btn-flat"><?php echo __('Close','wp-splash-image'); ?></a>
			    </div>
            </div>
        </label>
    </p>

    <p>
        <input type="checkbox"
               name="wsi_hide_on_mobile_devices"
               id="wsi_hide_on_mobile_devices"
            <?php if($siBean->isWsi_hide_on_mobile_devices()=='true') {echo("checked='checked'");} ?> />
        <label for="wsi_hide_on_mobile_devices"><?php echo __('Hide Splash image on mobile devices','wp-splash-image'); ?></label>
    </p>

	<!-- Tabs -->
    <div id="tabs-container" class="card-panel">
        <div>
            <ul class="tabs">
                <li class="tab col s3"><a <?php echo selectActiveTab($siBean->getWsi_type(), 0); ?> href="#tab_picture"><i class="material-icons tabs-icon">photo</i><?php echo __('Picture'); ?></a></li>
                <li class="tab col s3"><a <?php echo selectActiveTab($siBean->getWsi_type(), 1); ?> href="#tab_video"><i class="material-icons tabs-icon">movie</i><?php echo __('Video'); ?></a></li>
                <li class="tab col s3"><a <?php echo selectActiveTab($siBean->getWsi_type(), 2); ?> href="#tab_HTML"><i class="material-icons tabs-icon">code</i><?php echo __('HTML'); ?></a></li>
                <li class="tab col s3"><a <?php echo selectActiveTab($siBean->getWsi_type(), 3); ?> href="#tab_include"><i class="material-icons tabs-icon">description</i><?php echo __('Include'); ?></a></li>
            </ul>
        </div>
        <?php require("tabs/PictureTab.inc.php"); ?>
        <?php require("tabs/VideoTab.inc.php"); ?>
        <?php require("tabs/HtmlTab.inc.php"); ?>
        <?php require("tabs/IncludeTab.inc.php"); ?>
    </div>
	<!-- /Tabs -->

	<ul class="collapsible" data-collapsible="accordion">
	    <li>
	    	<div class="collapsible-header">
				<i class="material-icons">alarm</i>
				<?php echo __('Dates','wp-splash-image'); ?>

				<div id="box_datepickers_warning">
				    <span class="warning"><?php echo __('Warning','wp-splash-image'); ?></span>
					<?php echo __('WSI does not currently work.','wp-splash-image'); ?>
					<?php echo __('Check if dates are OK.','wp-splash-image'); ?>
				</div>

			</div>
	    	<div class="collapsible-body">

				<p>
			        <?php echo __('Start date','wp-splash-image'); ?> :
			        <input type="date"
			            name="datepicker_start"
			            id="datepicker_start"
			            class="datepicker"
			            value="<?php echo ($siBean->getDatepicker_start()!=null)?date_create($siBean->getDatepicker_start())->format('Y-m-d'):''; ?>" />
			            <?php echo __('(stay empty if not required)','wp-splash-image'); ?>
			    </p>

			    <p>
			        <?php echo __('End date','wp-splash-image'); ?> :
			        <input type="date"
			            name="datepicker_end"
			            id="datepicker_end"
			            class="datepicker"
			            value="<?php echo ($siBean->getDatepicker_end()!=null)?date_create($siBean->getDatepicker_end())->format('Y-m-d'):''; ?>" />
			            <?php echo __('(stay empty if not required)','wp-splash-image'); ?>
			    </p>

				<p>
			    	<?php echo __('Server date','wp-splash-image'); ?> : <?php echo date("Y-m-d H:i:s"); ?>
				</p>

			</div>
	    </li>
	    <li>
	    	<div class="collapsible-header">
				<i class="material-icons">highlight_off</i>
				<?php echo __('Closure methods','wp-splash-image'); ?>
			</div>
	    	<div class="collapsible-body">

				<p>
					<input type="checkbox"
						name="wsi_close_on_esc_function"
						id="wsi_close_on_esc_function"
						<?php if($siBean->isWsi_close_on_esc_function()=='true') {echo("checked='checked'");} ?> />
					<label for="wsi_close_on_esc_function"><?php echo __('Close on press','wp-splash-image'); ?> <img alt="ESC" src="<?php echo WsiCommons::getURL(); ?>/style/esc_button.png" class="esc_button"> <?php echo __('button','wp-splash-image'); ?></label>
				</p>

				<p>
					<input type="checkbox"
						name="wsi_close_on_click_function"
						id="wsi_close_on_click_function"
						<?php if($siBean->isWsi_close_on_click_function()=='true') {echo("checked='checked'");} ?> />
					<label for="wsi_close_on_click_function"><?php echo __('Close on click over the splash image','wp-splash-image'); ?></label>
				</p>

				<p>
					<input type="checkbox"
						name="wsi_hide_cross"
						id="wsi_hide_cross"
						<?php if($siBean->isWsi_hide_cross()=='true') {echo("checked='checked'");} ?> />
					<label for="wsi_hide_cross"><?php echo __('Hide','wp-splash-image'); ?>&nbsp;<img src="<?php echo WsiCommons::getURL(); ?>/style/jqueryTools/close.png" class="little_cross" /></label>
				</p>

			</div>
	    </li>
	    <li>
	    	<div class="collapsible-header">
				<i class="material-icons">color_lens</i>
				<?php echo __('Style','wp-splash-image'); ?>
			</div>
	    	<div class="collapsible-body">

				<p>
			        <?php echo __("Splash height",'wp-splash-image'); ?> :
			        <input
			            type="number"
			            min="210"
			            name="splash_image_height"
			            id="splash_image_height"
			            size="6" maxlength="4"
			            value="<?php echo $siBean->getSplash_image_height(); ?>" />&nbsp;px (min = 210px)
			    </p>

			    <p>
			        <?php echo __("Splash width",'wp-splash-image'); ?> :
			        <input
			            type="number"
			            name="splash_image_width"
			            id="splash_image_width"
			            size="6" maxlength="4"
			            value="<?php echo $siBean->getSplash_image_width(); ?>" />&nbsp;px
			    </p>

			    <p>
			        <?php echo __("Splash margin-top",'wp-splash-image'); ?> :
			        <input
			            type="number"
			            name="wsi_margin_top"
			            id="wsi_margin_top"
			            min="-10000"
			            max="10000"
			            value="<?php echo $siBean->getWsi_margin_top(); ?>" />&nbsp;px
			            (<?php echo __('leave empty for WSI manages the position.','wp-splash-image'); ?>)
			    </p>

			    <p>
			        <?php echo __('Background color','wp-splash-image'); ?> : #
			        <input
			            type="text"
			            name="splash_color"
			            id="splash_color"
			            size="6" maxlength="6"
			            value="<?php echo $siBean->getSplash_color(); ?>" />
			        <span id="splash_color_demo"></span>
			        <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/Tools/ColorPicker_Tool" target="_blank"><?php echo __('Color Picker Online'); ?></a>

			    </p>

			    <p class="range-field">
			        <?php echo __('Background opacity','wp-splash-image'); ?> :
			        <input type="range" name="wsi_opacity" min="0" max="100" value="<?php echo $siBean->getWsi_opacity(); ?>" />&nbsp;%
			    </p>

			    <p>
			        <?php echo __('Display time','wp-splash-image'); ?> :
			        <input type="number" name="wsi_display_time" min="0" value="<?php echo $siBean->getWsi_display_time(); ?>" />&nbsp;
			        <?php echo __('seconds','wp-splash-image'); ?>&nbsp;
			        <?php echo __("(0 don't close automaticly the splash image)",'wp-splash-image'); ?>
			    </p>

			    <p>
			        <input type="checkbox"
			               name="wsi_disable_shadow_border"
			               id="wsi_disable_shadow_border"
			            <?php if($siBean->isWsi_disable_shadow_border()=='true') {echo("checked='checked'");} ?> />
			        <label for="wsi_disable_shadow_border"><?php echo __('Disable shadow border','wp-splash-image'); ?> (<?php echo __('useful for images with transparent edges','wp-splash-image'); ?>)</label>
			    </p>

			    <p>
			        <input type="checkbox"
			               name="wsi_fixed_splash"
			               id="wsi_fixed_splash"
			            <?php if($siBean->isWsi_fixed_splash()=='true') {echo("checked='checked'");} ?> />
			        <label for="wsi_fixed_splash"><?php echo __('Splash screen leaves in the same position while the screen is scrolled','wp-splash-image'); ?> (<?php echo __('useful for images with big size','wp-splash-image'); ?>)</label>
			    </p>

			    <p>
			        <input type="checkbox"
			            name="wsi_display_always"
			            id="wsi_display_always"
			            <?php if($siBean->isWsi_display_always()=='true') {echo("checked='checked'");} ?> />
			        <label for="wsi_display_always"><?php echo __('Display the splash image on each pages for each users (not recommended for comfort of users).','wp-splash-image'); ?></label>
			    </p>

			    <p id="block_idle_time">
			        <?php echo __('Idle time','wp-splash-image'); ?> :
			        <input type="number"
			            min="1"
			            name="wsi_idle_time"
			            size="6" maxlength="4"
			            value="<?php echo $siBean->getWsi_idle_time(); ?>" />&nbsp;
			            <?php echo __('minutes of user inactivity before re-emergence of wsi.','wp-splash-image'); ?>&nbsp;
			    </p>

			</div>
	    </li>
	</ul>

	<p class="submit">
		<button type="submit" class="waves-effect waves-light btn">
            <?php echo __('Update'); ?>
            <i class="material-icons right">save</i>
        </button>
		<button type="button" id="live_preview_button" class="waves-effect waves-light btn">
            <?php echo __( 'Live Preview' ); ?>
            <i class="material-icons right">visibility</i>
        </button>
	</p>
	<div id="live_preview_div"></div>

</form>
