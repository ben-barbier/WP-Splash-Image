<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
<div class="simple_overlay" style="text-align:center;color:#<?php echo $_POST["splash_color"]; ?>;margin-top:15px;height:<?php echo $_POST['splash_image_height']; ?>px;width:<?php echo $_POST['splash_image_width']; ?>px;" id="miesSPLASH">
	
	<?php switch ($_POST['wsi_type']) {
	    case "picture": ?>

			<?php if($_POST['wsi_picture_link_url']!="") { echo ('<a href="'.$_POST['wsi_picture_link_url'].'" target="_'.$_POST['wsi_picture_link_target'].'">'); } ?>
			<img style="height:<?php echo $_POST['splash_image_height']; ?>px;width:<?php echo $_POST['splash_image_width']; ?>px;" src="<?php echo $_POST['url_splash_image']; ?>" />
			<?php if($_POST['wsi_picture_link_url']!="") { echo('</a>'); } ?>
		
	    <?php break; case "youtube": ?>

			<object width="<?php echo $_POST['splash_image_width']; ?>" height="<?php echo $_POST['splash_image_height']; ?>">
				<param name="movie" value="http://www.youtube.com/v/<?php echo $_POST['wsi_youtube']; ?>&hl=en_US&fs=1&rel=0" />
				<param name="allowFullScreen" value="true" />
				<param name="allowscriptaccess" value="always" />
				<embed src="http://www.youtube.com/v/<?php echo $_POST['wsi_youtube']; ?>&hl=en_US&fs=1&rel=0<?php if($_POST['wsi_youtube_autoplay']=='true'){ ?>&autoplay=1<?php } if($_POST['wsi_youtube_loop']=='true'){ ?>&loop=1<?php } ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $_POST['splash_image_width']; ?>" height="<?php echo $_POST['splash_image_height']; ?>"></embed>
			</object>
			    
		<?php break; case "yahoo": ?>
		
			<object width="<?php echo $_POST['splash_image_width']; ?>" height="<?php echo $_POST['splash_image_height']; ?>"><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" />
				<param name="allowFullScreen" value="true" />
				<param name="AllowScriptAccess" VALUE="always" />
				<param name="bgcolor" value="#000000" />
				<param name="flashVars" value="id=20476969&vid=<?php echo $_POST['wsi_yahoo']; ?>&lang=en_US&embed=1" />
				<embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" type="application/x-shockwave-flash" width="<?php echo $_POST['splash_image_width']; ?>" height="<?php echo $_POST['splash_image_height']; ?>" allowFullScreen="true" AllowScriptAccess="always" bgcolor="#000000" flashVars="id=20476969&vid=<?php echo $_POST['wsi_yahoo']; ?>&lang=en_US&embed=1" ></embed>
			</object>
		
		<?php break; case "dailymotion": ?>
		
			<object width="<?php echo $_POST['splash_image_width']; ?>" height="<?php echo $_POST['splash_image_height']; ?>">
				<param name="movie" value="http://www.dailymotion.com/swf/video/<?php echo $_POST['wsi_dailymotion']; ?>" />
				<param name="allowFullScreen" value="true" />
				<param name="allowScriptAccess" value="always" />
				<embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/<?php echo $_POST['wsi_dailymotion']; ?>" width="<?php echo $_POST['splash_image_width']; ?>" height="<?php echo $_POST['splash_image_height']; ?>" allowfullscreen="true" allowscriptaccess="always"></embed>
			</object>
			
		<?php break; case "metacafe": ?>
				
			<embed 
				src="http://www.metacafe.com/fplayer/<?php echo $_POST['wsi_metacafe']; ?>/.swf" 
				width="<?php echo $_POST['splash_image_width']; ?>" 
				height="<?php echo $_POST['splash_image_height']; ?>" 
				wmode="transparent" 
				pluginspage="http://www.macromedia.com/go/getflashplayer" 
				type="application/x-shockwave-flash" 
				allowFullScreen="true" 
				allowScriptAccess="always" 
				name="Metacafe_<?php echo $_POST['wsi_metacafe']; ?>"></embed>
		
		<?php break; case "swf": ?>
			
			<object id='player' name='player' width='<?php echo $_POST['splash_image_width']; ?>' height='<?php echo $_POST['splash_image_height']; ?>' >
				<param name='FileName' value='<?php echo $_POST['wsi_swf']; ?>'> 
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
					src='<?php echo $_POST['wsi_swf']; ?>' 
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
					width='<?php echo $_POST['splash_image_width']; ?>' 
					height='<?php echo $_POST['splash_image_height']; ?>' 
					enablefullscreencontrols='1'> 
				</embed> 
			</object>
			
		<?php break; case "html": ?>
		
			<?php echo stripslashes($_POST['wsi_html']); ?>
			
		<?php break; case "include": ?>
		
			<iframe 
				height="<?php echo $_POST['splash_image_height']; ?>" 
				width="<?php echo $_POST['splash_image_width']; ?>" 
				src="<?php echo stripslashes($_POST['wsi_include_url']); ?>">
			</iframe>
		
	<?php } ?>

</div>

<script type="text/javascript">

    jQuerySplash(document).ready(function () {

		<?/* Splash Image */?>

		jQuerySplash("#splashLink").overlay({
			mask: {
				color: '#<?php echo $_POST["splash_color"]; ?>',
				opacity: <?php echo $_POST['wsi_opacity']/100; ?> 
			}
			,load: true // Lance la Splash Image à l'ouverture
			,closeOnEsc: <?php echo $_POST["wsi_close_on_esc_function"]; ?>
			,closeOnClick: <?php echo $_POST["wsi_close_on_click_function"]; ?> 
			,fixed: <?php echo $_POST["wsi_fixed_splash"]; ?>
		});

		<?/* Autoclose de la Splash Image */?>
		<?php if ($_POST["wsi_display_time"] > 0) { ?>
			setTimeout("jQuerySplash('#miesSPLASH').fadeOut()",<?php echo $_POST["wsi_display_time"]; ?>000);
			setTimeout("jQuerySplash('#exposeMask').fadeOut()",<?php echo $_POST["wsi_display_time"]; ?>000);
		<?php } ?>

		<?/* On masque la croix en haut à droite si besoin */?>
		<?php if($_POST['wsi_hide_cross']=='true') { ?>
			jQuerySplash('.simple_overlay .close').css('display','none');
		<?php } ?>
		
		<?/* On masque la bordure d'ombre si besoin */?>
		<?php if($_POST['wsi_disable_shadow_border']=='true') { ?>
			jQuerySplash('.simple_overlay').css('-moz-box-shadow','none');
			jQuerySplash('.simple_overlay').css('-webkit-box-shadow','none');
			jQuerySplash('.simple_overlay').css('box-shadow','none');
		<?php } ?>

		<?/* On modifie la marge supperieur si elle est precisee */?>
		<?php if($_POST['wsi_margin_top']!='') { ?>
			jQuerySplash('.simple_overlay').css('margin-top','<?php echo $_POST["wsi_margin_top"]; ?>px');
		<?php } ?>
		
	});
	
</script>
