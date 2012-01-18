<!-- WP Splash-Image -->
<script type="text/javascript">
$j(document).ready(function () {
	$j("#splashLink").overlay({
		mask: {
			color: '#<?php echo get_option('splash_color'); ?>',
			opacity: <?php echo (get_option('wsi_opacity')/100); ?> 
		},
		load: true // Lance la Splash Image à l'ouverture			
		<?php if ($siBean->isWsi_close_esc_function()=='true') { echo(',closeOnClick: false'); } ?>
		<?php if ($siBean->isWsi_fixed_splash()=='true')  { echo(',fixed: true');  } ?>
		<?php if ($siBean->isWsi_fixed_splash()=='false') { echo(',fixed: false'); } ?>
	});
});
</script>
<!-- /WP Splash-Image -->