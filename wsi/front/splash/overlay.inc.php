<!-- WP Splash-Image -->
<script type="text/javascript">
$jwsi(document).ready(function () {
	$jwsi("#splashLink").overlay({
		mask: {
			color: '#<?php echo $siBean->getSplash_color(); ?>',
			opacity: <?php echo ($siBean->getWsi_opacity()/100); ?> 
		}
		,load: true // Lance la Splash Image à l'ouverture
		,closeOnEsc: <?php echo $siBean->isWsi_close_on_esc_function(); ?>
		,closeOnClick: <?php echo $siBean->isWsi_close_on_click_function(); ?> 
		,fixed: <?php echo $siBean->isWsi_fixed_splash(); ?>
	});
});
</script>
<!-- /WP Splash-Image -->