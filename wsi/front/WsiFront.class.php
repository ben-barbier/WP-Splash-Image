<?php

/**
 * @author Benjamin Barbier
 *
 */
class WsiFront {

	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {}
	/**
	 * @return WsiFront
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new WsiFront();
		} return self::$_instance;
	}
	
	/**
	 * Plug : Hooks functions to actions and filters.
	 * This is the only function to use to set up the back.
	 */
	public function plug() {
		add_action ( 'init',              array(&$this, 'wp_splash_image_front_init'));
		add_action ( 'wp_head',           array(&$this, 'wsi_addSplashImageWpHead' ));
		add_action ( 'wp_footer',         array(&$this, 'wsi_addSplashImageWpFooter' ));
		add_action ( 'template_redirect', array(&$this, 'wsi_init_session'), 0 );
	}
	
	/**
	 * Cette fonction ouvre une session PHP si ce n'est pas déjà le cas dans le thème
	 */
	public function wsi_init_session() {
		$session_id = session_id();
		if(empty($session_id)) {
			session_start();
		}
	}
	
	/**
	 * Init du Front end
	 */
	public function wp_splash_image_front_init() {
	
		if (!is_admin()) {
	
			// Déclaration des styles de la partie front end.
			wp_register_style('overlay-basic', WsiCommons::getURL().'/style/overlay-basic.css'); /*Style pour la splash image */
	
			// Déclaration des scripts de la partie front end.
			wp_register_script('jquery.tools.front', WsiCommons::getURL().'/js/jquery.tools.min.wp-front.js'); /*[overlay, toolbox.expose]*/
	
			// JQuery (wordpress version)
			wp_enqueue_script('jquery');
			
			// JQuery Tools
			wp_enqueue_script('jquery.tools.front', false, array('jquery'));
			
			// Chargement des styles du front end.
			wp_enqueue_style('overlay-basic');
	
		}
		
	}
	
	/**
	 * Fontion utililée dans le blog (dans le head)
	 */
	public function wsi_addSplashImageWpHead() {
		
		// Chargement des données en base
		$siBean = SplashImageManager::getInstance()->get();
		
		// Si le plugin n'est pas activé dans ses options, on ne fait rien
		if($siBean->isSplash_active()!='true') return;
		
		// Si on est pas en "mode test", on effectue quelques tests supplémentaires
		if(get_option('splash_test_active')!='true') {

			// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
			if (WsiCommons::getdate_is_in_validities_dates() == "false") return;
			
 			if(WsiCommons::enough_idle_to_splash($_SESSION['last_display'])==false) {
	 			// On indique qu'un écran a été affiché par l'utilisateur et on arrete le traitement
	 			$_SESSION['last_display'] = time();
	 			return;
			}
			
		}
		
	?>
	
		<!-- WP Splash-Image -->
		<script type="text/javascript">
		var $j = jQuery.noConflict();
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
	
	<?php
	}
	
	/**
	 * Fontion utililée dans le blog (dans le footer)
	 */
	public function wsi_addSplashImageWpFooter() {
	
		// Chargement des données en base
		$siBean = SplashImageManager::getInstance()->get();
		
		// Si le plugin n'est pas activé dans ses options, on ne fait rien
		if($siBean->isSplash_active()!='true') return;
	
		// Si on est pas en "mode test", on effectue quelques tests supplémentaires
		if($siBean->isSplash_test_active()!='true') {
		
			// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
			if (WsiCommons::getdate_is_in_validities_dates() == "false") return;
	
 			if(WsiCommons::enough_idle_to_splash($_SESSION['last_display'])==false) {
 				// On indique qu'un écran a été affiché par l'utilisateur et on arrete le traitement
 				$_SESSION['last_display'] = time();
 				return;
 			}
	
		}
		
	?>	
	
		<!-- WP Splash-Image -->
		<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
		<div class="simple_overlay" style="text-align:center;color:#FFFFFF;margin-top:15px;height:<?php echo $siBean->getSplash_image_height(); ?>px;width:<?php echo $siBean->getSplash_image_width(); ?>px;" id="miesSPLASH">
			
	<?php
		switch ($siBean->getWsi_type()) {
	    case "picture": ?>
	
			<?php if($siBean->getWsi_picture_link_url()!="") { echo ('<a href="'.$siBean->getWsi_picture_link_url().'" target="_'.$siBean->getWsi_picture_link_target().'">'); } ?>
			<img style="height:<?php echo $siBean->getSplash_image_height(); ?>px;width:<?php echo $siBean->getSplash_image_width(); ?>px;" src="<?php echo $siBean->getUrl_splash_image(); ?>" />
			<?php if($siBean->getWsi_picture_link_url()!="") { echo('</a>'); } ?>
		
	    <?php break; case "youtube": ?>
	
			<object width="<?php echo $siBean->getSplash_image_width(); ?>" height="<?php echo $siBean->getSplash_image_height(); ?>">
				<param name="movie" value="http://www.youtube.com/v/<?php echo $siBean->getWsi_youtube(); ?>&hl=<?php echo get_locale(); ?>&fs=1&rel=0"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
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
				<param name="movie" value="http://www.dailymotion.com/swf/video/<?php echo $siBean->getWsi_dailymotion(); ?>"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowScriptAccess" value="always"></param>
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
		
		<?php } ?>
			
		</div>
		
		<?/* Autoclose de la Splash Image */?>
		<?php if ($siBean->getWsi_display_time() > 0) { ?>
		<script type="text/javascript">
		$j(document).ready(function () {
			setTimeout("$j('#miesSPLASH').fadeOut()",<?php echo ($siBean->getWsi_display_time()*1000); ?>);
			setTimeout("$j('#exposeMask').fadeOut()",<?php echo ($siBean->getWsi_display_time()*1000); ?>);
		});
		</script>
		<?php } ?>
		
		<?/* On masque la croix en haut à droite si besoin */?>
		<?php if($siBean->isWsi_hide_cross()=='true') { ?>
		<script type="text/javascript">
		$j(document).ready(function () {
			$j('.simple_overlay .close').css('display','none');
		});
		</script>
		<?php } ?>
		
		<?/* On masque la bordure d'ombre si besoin */?>
		<?php if($siBean->isWsi_disable_shadow_border()=='true') { ?>
		<script type="text/javascript">
		$j(document).ready(function () {
			$j('.simple_overlay').css('-moz-box-shadow','none');
			$j('.simple_overlay').css('-webkit-box-shadow','none');
			$j('.simple_overlay').css('box-shadow','none');
		});
		</script>
		<?php } ?>
		
		<!-- /WP Splash-Image -->
		
<?php 

		// On indique qu'un écran a été affiché par l'utilisateur
		$_SESSION['last_display'] = time();

	}
} 
?>