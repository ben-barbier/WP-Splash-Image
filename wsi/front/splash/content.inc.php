<!-- WP Splash-Image -->
<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
<div class="simple_overlay" style="text-align:center;color:#FFFFFF;margin-top:15px;height:<?php echo $siBean->getSplash_image_height(); ?>px;width:<?php echo $siBean->getSplash_image_width(); ?>px;" id="miesSPLASH">
		
<?php switch ($siBean->getWsi_type()) {
    case "picture": ?>

		<?php if($siBean->getWsi_picture_link_url()!="") { echo ('<a href="'.$siBean->getWsi_picture_link_url().'" target="_'.$siBean->getWsi_picture_link_target().'">'); } ?>
		<img style="height:<?php echo $siBean->getSplash_image_height(); ?>px;width:<?php echo $siBean->getSplash_image_width(); ?>px;" src="<?php echo $siBean->getUrl_splash_image(); ?>" />
		<?php if($siBean->getWsi_picture_link_url()!="") { echo('</a>'); } ?>
	
    <?php break; case "youtube": ?>

		<object width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>">
			<param name="movie" value="http://www.youtube.com/v/<?php echo $siBean->getWsi_youtube(); ?>&hl=<?php echo get_locale(); ?>&fs=1&rel=0" />
			<param name="allowFullScreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<embed src="http://www.youtube.com/v/<?php echo $siBean->getWsi_youtube(); ?>&hl=<?php echo get_locale(); ?>&fs=1&rel=0<?php if($siBean->isWsi_youtube_autoplay()=='true'){ ?>&autoplay=1<?php } if($siBean->isWsi_youtube_loop()=='true'){ ?>&loop=1<?php } ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>"></embed>
		</object>
		    
	<?php break; case "yahoo": ?>
	
		<object width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>"><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" />
			<param name="allowFullScreen" value="true" />
			<param name="AllowScriptAccess" VALUE="always" />
			<param name="bgcolor" value="#000000" />
			<param name="flashVars" value="id=20476969&vid=<?php echo $siBean->getWsi_yahoo(); ?>&lang=<?php echo get_locale(); ?>&embed=1" />
			<embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" type="application/x-shockwave-flash" width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>" allowFullScreen="true" AllowScriptAccess="always" bgcolor="#000000" flashVars="id=20476969&vid=<?php echo $siBean->getWsi_yahoo(); ?>&lang=<?php echo get_locale(); ?>&embed=1" ></embed>
		</object>
	
	<?php break; case "dailymotion": ?>
	
		<object width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>">
			<param name="movie" value="http://www.dailymotion.com/swf/video/<?php echo $siBean->getWsi_dailymotion(); ?>" />
			<param name="allowFullScreen" value="true" />
			<param name="allowScriptAccess" value="always" />
			<embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/<?php echo $siBean->getWsi_dailymotion(); ?>" width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>" allowfullscreen="true" allowscriptaccess="always"></embed>
		</object>
		
	<?php break; case "metacafe": ?>
			
		<embed 
			src="http://www.metacafe.com/fplayer/<?php echo $siBean->getWsi_metacafe(); ?>/.swf" 
			width="<?php echo $siBean->getSplash_image_width(); ?>" 
			height="<?php echo $siBean->getSplash_image_height(); ?>" 
			wmode="transparent" 
			pluginspage="http://www.macromedia.com/go/getflashplayer" 
			type="application/x-shockwave-flash" 
			allowFullScreen="true" 
			allowScriptAccess="always" 
			name="Metacafe_<?php echo $siBean->getWsi_metacafe(); ?>"></embed>
	
	<?php break; case "swf": ?>
		
		<object id='player' name='player' width='<?php echo $siBean->getSplash_image_width(); ?>' height='<?php echo $siBean->getSplash_image_height(); ?>' >
			<param name='FileName' value='<?php echo $siBean->getWsi_swf(); ?>'> 
			<param name='ShowControls' value='TRUE'> 
			<param name='AutoStart' value='FALSE'> 
			<param name='AnimationAtStart' value='TRUE'> 
			<param name='ShowDisplay' value='FALSE'> 
			<param name='TransparentAtStart' value='FALSE'> 
			<param name='ShowStatusbar' value='TRUE'> 
			<param name='enableContextMenu' value='FALSE'> 
			<param name='AllowChangeDisplaySize' value='TRUE'> 
			<param name='AutoSize' value='FALSE'> 
			<param name='EnableFullScreenControls' value='TRUE'> 
			<embed type='video/x-ms-asf-plugin' 
				src='<?php echo $siBean->getWsi_swf(); ?>' 
				name='player' 
				autostart='0' 
				showcontrols='1' 
				showdisplay='0' 
				showstatusbar='1' 
				animationatstart='1' 
				transparentatstart='0' 
				allowchangedisplaysize='1' 
				autosize='0' 
				displaysize='0' 
				enablecontextmenu='0' 
				windowless='1' 
				width='<?php echo $siBean->getSplash_image_width(); ?>' 
				height='<?php echo $siBean->getSplash_image_height(); ?>' 
				enablefullscreencontrols='1'> 
			</embed> 
		</object>
		
	<?php break; case "html": ?>
	
		<?php echo stripslashes($siBean->getWsi_html()); ?>
		
	<?php break; case "include": ?>
	
		<iframe 
			height="<?php echo $siBean->getSplash_image_height(); ?>" 
			width="<?php echo $siBean->getSplash_image_width(); ?>" 
			src="<?php echo stripslashes($siBean->getWsi_include_url()); ?>">
		</iframe>
	
<?php } ?>
	
</div>

<?/* Autoclose de la Splash Image */?>
<?php if ($siBean->getWsi_display_time() > 0) { ?>
<script type="text/javascript">
$jwsi(document).ready(function () {
	setTimeout("$jwsi('#miesSPLASH').fadeOut()",<?php echo ($siBean->getWsi_display_time()*1000); ?>);
	setTimeout("$jwsi('#exposeMask').fadeOut()",<?php echo ($siBean->getWsi_display_time()*1000); ?>);
});
</script>
<?php } ?>

<?/* On masque la croix en haut à droite si besoin */?>
<?php if($siBean->isWsi_hide_cross()=='true') { ?>
<script type="text/javascript">
$jwsi(document).ready(function () {
	$jwsi('.simple_overlay .close').css('display','none');
});
</script>
<?php } ?>

<?/* On masque la bordure d'ombre si besoin */?>
<?php if($siBean->isWsi_disable_shadow_border()=='true') { ?>
<script type="text/javascript">
$jwsi(document).ready(function () {
	$jwsi('.simple_overlay').css('-moz-box-shadow','none');
	$jwsi('.simple_overlay').css('-webkit-box-shadow','none'); 
	$jwsi('.simple_overlay').css('box-shadow','none');
});
</script>
<?php } ?>

<?/* On modifie la marge supperieur si elle est precisee */?>
<?php if($siBean->getWsi_margin_top()!='') { ?>
<script type="text/javascript">
$jwsi(document).ready(function () {
	$jwsi('.simple_overlay').css('margin-top','<?php echo $siBean->getWsi_margin_top(); ?>px');
});
</script>
<?php } ?>

<!-- /WP Splash-Image -->