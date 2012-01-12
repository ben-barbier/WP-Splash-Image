<!-- ----------------------- -->
<!-- Uninstall Confirm Form  -->
<!-- ----------------------- -->

<?php
// Find uninstall URL
$deactivate_url = 'plugins.php?action=deactivate&plugin=wsi%2Fwp-splash-image.php&plugin_status=all&paged=1';
if(function_exists('wp_nonce_url')) {
	$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_wsi/wp-splash-image.php');
}
?>

<a style="display:none;" id="uninstall_confirm_link" href="#" rel="#uninstall_confirm"></a>
<div id="uninstall_confirm" class="overlay" style="display:none;background-image:url(<?php echo WsiCommons::getURL(); ?>/style/petrol.png);color:#fff;width:595px;height:465px;padding:30px;z-index:2">
<div class="close" style="right:5px;top:5px;"></div>

	<h3 style="margin-left:15px;"><?php echo __('Uninstall WP-Splash-Image', 'wp-splash-image'); ?></h3>
	<div class="uninstallCheckList"><?php echo $uninstalled_message; ?></div>
	<br />
	<p style="text-align:center;">
		<strong><?php echo __('To finish the uninstallation and deactivate automatically WP-Splash-Image :', 'wp-splash-image'); ?></strong>
		<br /><br /><br />
		<input type="button" class="button" 
			value="<?php echo __('Click Here', 'wp-splash-image'); ?>" 
			onClick="javascript:window.open('<?php echo $deactivate_url; ?>','_self');" />
	</p>
	
</div>
<script type="text/javascript">
	jQuery(document).ready(function ($) {$("#uninstall_confirm_link").overlay({load:true});});
</script>