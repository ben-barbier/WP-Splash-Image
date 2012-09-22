<script type="text/javascript">
	var $j = jQuery.noConflict();
</script>

<!-- WP Splash-Image -->
<script type="text/javascript">
$j(document).ready(function () {
	$j("#splashLink").overlay({
		mask: {
			color: '#<?php echo $_GET["color"]; ?>',
			opacity: 0.<?php echo $_GET['opacity']; ?> 
		},
		load: true, // Lance la Splash Image à l'ouverture			
		fixed: true
	});
});
</script>
<!-- /WP Splash-Image -->

<!-- WP Splash-Image -->
<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
<div class="simple_overlay" style="text-align:center;color:#<?php echo $_GET["color"]; ?>;margin-top:15px;height:<?php echo $_GET['height']; ?>px;width:<?php echo $_GET['width']; ?>px;" id="miesSPLASH">
	<a href="http://wordpress.org/extend/plugins/wsi/" target="_blank">
		<img style="height:<?php echo $_GET['height']; ?>px;width:<?php echo $_GET['width']; ?>px;" src="http://plugins.svn.wordpress.org/wsi/assets/banner-772x250.png" />
	</a>
</div>

<script type="text/javascript">
	$j(document).ready(function () {
		setTimeout("$j('#miesSPLASH').fadeOut()",5000);
		setTimeout("$j('#exposeMask').fadeOut()",5000);
	});
</script>
<!-- /WP Splash-Image -->