
<!-- --------------- -->
<!-- Uninstall Form  -->
<!-- --------------- -->

<div id="uninstall" class="overlay" style="display:none;background-image:url(<?php echo WsiCommons::getURL(); ?>/style/petrol.png);color:#fff;width:620px;height:530px;margin:40px;">
	<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
		<?php wp_nonce_field('uninstall','nonce_uninstall_field'); ?>
		<input type="hidden" name="action" value="uninstall" />
		<div class="wrap"> 
			<h3><?php echo __('Uninstall WP-Splash-Image', 'wp-splash-image'); ?></h3>
			<p><?php echo __('Deactivating WP-Splash-Image plugin does not remove any data that may have been created, such as the stats options. To completely remove this plugin, you can uninstall it here.', 'wp-splash-image'); ?></p>
			<p style="color: red">
				<strong><?php echo __('WARNING:', 'wp-splash-image'); ?></strong><br />
				<?php echo __('Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.', 'wp-splash-image'); ?>
			</p>

			<p style="color: red"><strong><?php echo __('The following WordPress tables will be DELETED:', 'wp-splash-image'); ?></strong><br /></p>
			<table class="widefat">
				<thead><tr><th><?php echo __('WordPress tables', 'wp-splash-image'); ?></th></tr></thead>
				<tr>
					<td valign="top" style="color: black;">
						<ol style="height:45px;overflow:auto;padding-left:40px">
							<?php foreach(WsiCommons::getWsiTablesList() as $table) {
								echo "<li>$table</li>";
							} ?>
						</ol>
					</td>
				</tr>
			</table>

			<p style="color: red"><strong><?php echo __('The following WordPress options will be DELETED:', 'wp-splash-image'); ?></strong><br /></p>
			<table class="widefat">
				<thead><tr><th><?php echo __('WordPress options', 'wp-splash-image'); ?></th></tr></thead>
				<tr>
					<td valign="top" style="color: black;">
						<ol style="height:25px;overflow:auto;padding-left:40px">
							<?php foreach(WsiCommons::getWsiOptionsList() as $option) {
								echo "<li>$option</li>";
							} ?>
						</ol>
					</td>
				</tr>
			</table>

			<br />
			<p style="text-align: center;">
				<input type="submit" class="button"
					value="<?php echo __('UNINSTALL WP-Splash Image', 'wp-splash-image'); ?>" 
					onclick="return confirm('<?php echo __('You Are About To Uninstall WP-Splash-Image From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.', 'wp-splash-image'); ?>')" />
			</p>
		</div> 
	</form>
</div>