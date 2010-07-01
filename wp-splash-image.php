<?php
/*
Plugin Name: WP Splash Image
Plugin URI: http://wordpress.org/extend/plugins/wsi/
Description: WP Splash Image is a plugin for Wordpress to display an image with a lightbox type effect at the opening of the blog.
Version: 1.0.1
Author: Benjamin Barbier
Author URI: http://www.dark-sides.com/
Donate URI: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C
*/

/**
 * Fonction utilisée dans la partie Admin (initialisation)
 */
function wp_splash_image_options_init() {
	
	// Chargement de l' I18n
	if (function_exists('load_plugin_textdomain')) {
		load_plugin_textdomain('wp-splash-image', wsi_url().'/languages', $wsi_plugin_dir.'/languages' );
	}
	
	// Déclaration des styles de la partie Admin (utilisés dans enqueue_wsi_styles)
	wp_register_style('tabs', wsi_url().'/style/tabs.css'); /*Style pour les onglets*/
	wp_register_style('validator-error', wsi_url().'/style/validator-error.css'); /*Style pour le validator du feedback*/
	wp_register_style('overlay-basic', wsi_url().'/style/overlay-basic.css'); /*Style pour la la box de documentation*/
	wp_register_style('date-input', wsi_url().'/style/dateinput.css'); /*Style pour les calendriers*/
	wp_register_style('range', wsi_url().'/style/range.css'); /*Style pour le curseur de temps*/
	wp_register_style('wsi', wsi_url().'/style/wsi.css');
	
	// Déclaration des scripts de la partie Admin (utilisés dans enqueue_wsi_scripts)
    wp_register_script('jquery142', wsi_url().'/js/jquery-1.4.2.min.js'); /*Base de JQuery*/
	wp_register_script('jquery.tools', wsi_url().'/js/jquery.tools.min.wp-back.js'); /*Overlay + apple effect + Validation + Tabs*/
	wp_register_script('jquery.tooltip', wsi_url().'/js/tooltip.jquery.js'); /*Infobulle(tooltip) pour feedback*/
	wp_register_script('mcolorpicker', 'http://plugins.meta100.com/mcolorpicker/javascripts/mColorPicker_min.js'); /*Colorpicker*/
	
}

/**
 * Crée l'entrée dans le menu "Réglages" de la partie admin de wordpress
 */
function wsi_menu() {
	$page = add_options_page('WP Splash Image Options', 'WP Splash Image', 'manage_options', 'wp_splash_image', 'wp_splash_image_options');
	
	/* Using registered $page handle to hook stylesheet loading */
    add_action('admin_print_styles-' . $page, 'enqueue_wsi_styles');
	
	/* Using registered $page handle to hook script load */
	add_action('admin_print_scripts-' . $page, 'enqueue_wsi_scripts');
}

/**
 * Utilisation des styles de la partie Admin
 */
function enqueue_wsi_styles() {
	wp_enqueue_style('tabs');
	wp_enqueue_style('validator-error');
	wp_enqueue_style('overlay-basic');
	wp_enqueue_style('date-input');
	wp_enqueue_style('range');
	wp_enqueue_style('wsi');
}

/**
 * Utilisation des scripts de la partie Admin
 */
function enqueue_wsi_scripts() {
	wp_enqueue_script('jquery142');
	wp_enqueue_script('jquery.tools');
	wp_enqueue_script('jquery.tooltip');
	wp_enqueue_script('mcolorpicker');
}

/**
 * Ajoute entrée dans la page des extensions (partie gauche)
 */
function wsi_filter_plugin_actions( $links ) { 
	
	/* Lien vers la partie admin */
	$settings_link = '<a href="options-general.php?page=wp_splash_image">'.__('Settings','wp-splash-image').'</a>'; 
	array_unshift( $links, $settings_link );
	
	return $links; 
}

/**
 * Ajoute entrée dans la page des extensions (partie droite)
 */
function set_plugin_meta($links, $file) {
 
	$plugin = plugin_basename(__FILE__);
	if ($file == $plugin) {
		return array_merge(
			$links,
			array( 
				/* Lien "Donate" de PayPal */
				'<a target="_blank" style="font-weight:bold;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C">'.__('Donate','wp-splash-image').'</a>'
				//,'un autre lien...'
	));}
	return $links;
}
 
/**
 * Fontion qui retourne l'URL du plugin
 */
function wsi_url() {
	return WP_PLUGIN_URL.'/'.basename(dirname(__FILE__));
}

/**
 * Cette fonction ouvre une session PHP si ce n'est pas déjà le cas dans le thème
 */
function wsi_init_session() {
	$session_id = session_id();
	if(empty($session_id)) {
  		session_start();
	}
}

/**
 * Fontion utililée dans le blog (dans le head)
 */
function wsi_addSplashImageWpHead() {
	
	// Si le plugin n'est pas activé dans ses options, on ne fait rien
	if(get_option('splash_active')!='true') return;
	
	// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
	if (getdate_is_in_validities_dates() == "false") return;
	
	// Si la Splash image a déjà été vue, on ne fait rien (sauf si on est en mode test)
	if(($_SESSION['splash_seen']=='Yes') && (get_option('splash_test_active')!='true'))  return;
	
	$url_splash_image = get_option ('url_splash_image');
	$wsi_close_esc_function = get_option ('wsi_close_esc_function');
	
?>

	<!-- WP Splash-Image -->
	<link rel="stylesheet" type="text/css" href="<?=wsi_url()?>/style/overlay-basic.css"/> 
	<script src="<?=wsi_url()?>/js/jquery-1.4.2.min.js"></script>
	<script src="<?=wsi_url()?>/js/jquery.tools.min.wp-front.js"></script>
	<script type="text/javascript">
	
	var $j = jQuery.noConflict();
	$j(document).ready(function () {
		$j("#splashLink").overlay({
			mask: {
				color: '<?=get_option('splash_color')?>',
				opacity: <?=(get_option('wsi_opacity')/100)?> 
			},
			<?php if ($wsi_close_esc_function=='true') { echo('closeOnClick: false,'); } ?>
			load: true // Lance la Splash Image à l'ouverture
		});
	});
	</script>
	<!-- /WP Splash-Image -->

<?php
}

/*
 * Si la Splash Image n'est pas dans sa plage de validité, on retourne false (sinon true)
 */
function getdate_is_in_validities_dates() {
	
	$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	
	// En cas de modication des paramètres dans la partie admin
	if ($_POST ['action'] == 'update') {
		if ($_POST['datepicker_start']!='') {
			$dpStart = strtotime($_POST['datepicker_start']);
			if ($today < $dpStart) {return "false";}
		}
		if ($_POST['datepicker_end']!='') {
			$dpEnd = strtotime($_POST['datepicker_end']);
			if ($today > $dpEnd) {return "false";}
		}
	// Sinon (front office)
	} else {
		if (get_option('datepicker_start')!='') {
			$dpStart = strtotime(get_option('datepicker_start'));
			if ($today < $dpStart) {return "false";}
		}
		if (get_option('datepicker_end')!='') {
			$dpEnd = strtotime(get_option('datepicker_end'));
			if ($today > $dpEnd) {return "false";}
		}
	}
	return "true";
}

/**
 * Fontion utililée dans le blog (dans le footer)
 */
function wsi_addSplashImageWpFooter() {

	// Si le plugin n'est pas activé dans ses options, on ne fait rien
	if(get_option('splash_active')!='true') return;

	// Si on est pas en "mode test", on effectue quelques tests supplémentaires
	if(get_option('splash_test_active')!='true') {
	
		// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
		if (getdate_is_in_validities_dates() == "false") return;

		// Si la Splash image a déjà été vue, on ne fait rien
		if($_SESSION['splash_seen']=='Yes')  return;

	}
	
	// On indique que la Splash Image a été vue
	$_SESSION['splash_seen']='Yes';
	
	// Chargement des données en base
	$url_splash_image = get_option('url_splash_image');
	$splash_image_height = get_option('splash_image_height');
	$splash_image_width = get_option('splash_image_width');
	$wsi_display_time = get_option('wsi_display_time');
	$wsi_picture_link_url = get_option('wsi_picture_link_url');
	$wsi_hide_cross = get_option('wsi_hide_cross');
	$wsi_type = get_option('wsi_type');
	
	$wsi_youtube = get_option('wsi_youtube');
	$wsi_yahoo = get_option('wsi_yahoo');
	$wsi_dailymotion = get_option('wsi_dailymotion');
	$wsi_metacafe = get_option('wsi_metacafe');
	$wsi_swf = get_option('wsi_swf');
	$wsi_html = get_option('wsi_html');
	
?>	

	<!-- WP Splash-Image -->
	<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
	<div class="simple_overlay" style="text-align:center;color:#FFFFFF;margin-top:15px;height:<?=$splash_image_height?>px;width:<?=$splash_image_width?>px;" id="miesSPLASH">
		
<?php
	switch ($wsi_type) {
    case "picture": ?>

		<?php if($wsi_picture_link_url!="") { echo ('<a href="'.$wsi_picture_link_url.'">'); } ?>
		<img style="height:<?=$splash_image_height?>px;width:<?=$splash_image_width?>px;" src="<?=$url_splash_image?>" />
		<?php if($wsi_picture_link_url!="") { echo('</a>'); } ?>
	
    <?php break; case "youtube": ?>

		<object width="<?=$splash_image_width?>" height="<?=$splash_image_height?>">
			<param name="movie" value="http://www.youtube.com/v/<?=$wsi_youtube?>&hl=<?=get_locale()?>&fs=1&rel=0"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowscriptaccess" value="always"></param>
			<embed src="http://www.youtube.com/v/<?=$wsi_youtube?>&hl=<?=get_locale()?>&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?=$splash_image_width?>" height="<?=$splash_image_height?>"></embed>
		</object>
		    
	<?php break; case "yahoo": ?>
	
		<object width="<?=$splash_image_width?>" height="<?=$splash_image_height?>"><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" />
			<param name="allowFullScreen" value="true" />
			<param name="AllowScriptAccess" VALUE="always" />
			<param name="bgcolor" value="#000000" />
			<param name="flashVars" value="id=20476969&vid=<?=$wsi_yahoo?>&lang=<?=get_locale()?>&embed=1" />
			<embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" type="application/x-shockwave-flash" width="<?=$splash_image_width?>" height="<?=$splash_image_height?>" allowFullScreen="true" AllowScriptAccess="always" bgcolor="#000000" flashVars="id=20476969&vid=<?=$wsi_yahoo?>&lang=<?=get_locale()?>&embed=1" ></embed>
		</object>
	
	<?php break; case "dailymotion": ?>
	
		<object width="<?=$splash_image_width?>" height="<?=$splash_image_height?>">
			<param name="movie" value="http://www.dailymotion.com/swf/video/<?=$wsi_dailymotion?>"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowScriptAccess" value="always"></param>
			<embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/<?=$wsi_dailymotion?>" width="<?=$splash_image_width?>" height="<?=$splash_image_height?>" allowfullscreen="true" allowscriptaccess="always"></embed>
		</object>
		
	<?php break; case "metacafe": ?>
			
		<embed 
			src="http://www.metacafe.com/fplayer/<?=$wsi_metacafe?>/.swf" 
			width="<?=$splash_image_width?>" 
			height="<?=$splash_image_height?>" 
			wmode="transparent" 
			pluginspage="http://www.macromedia.com/go/getflashplayer" 
			type="application/x-shockwave-flash" 
			allowFullScreen="true" 
			allowScriptAccess="always" 
			name="Metacafe_<?=$wsi_metacafe?>"></embed>
	
	<?php break; case "swf": ?>
		
		<object id='player' name='player' width='<?=$splash_image_width?>' height='<?=$splash_image_height?>' >
			<param name='FileName' value='<?=$wsi_swf?>'> 
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
				src='<?=$wsi_swf?>' 
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
				width='<?=$splash_image_width?>' 
				height='<?=$splash_image_height?>' 
				enablefullscreencontrols='1'> 
			</embed> 
		</object>
		
	<?php break; case "html": ?>
	
		<?=$wsi_html?>
	
	<? } ?>
		
	</div>
	
	<?/* Autoclose de la Splash Image */?>
	<?php if ($wsi_display_time > 0) { ?>
	<script type="text/javascript">
	$(document).ready(function () {
		setTimeout("$('#miesSPLASH').fadeOut()",<?=($wsi_display_time*1000)?>);
		setTimeout("$('#exposeMask').fadeOut()",<?=($wsi_display_time*1000)?>);
	});
	</script>
	<? } ?>
	
	<?/* On masque la croix en haut à droite si besoin */?>
	<?php if($wsi_hide_cross=='true') { ?>
	<script type="text/javascript">
	$(document).ready(function () {
		$('.simple_overlay .close').css('display','none');
	});
	</script>
	<? } ?>
	
	<!-- /WP Splash-Image -->
	
<?php
}

/**
 * Fonction utilisée dans la partie Admin 
 */
function wp_splash_image_options() {
	
	// L'utilisateur a-t-il les droits suffisants pour afficher la page
	if (!current_user_can('manage_options'))  {
		wp_die( __("You do not have sufficient permissions to access this page.",'wp-splash-image') );
	}
	
	// Mise à jour ?
	if ($_POST ['action'] == 'update') {
		// On met à jour la base de données (table: options) avec la fonction de wp: update_option
		if ($_POST['splash_active']) {$active='true';} else {$active='false';}
		update_option('splash_active', $active);
		if ($_POST['splash_test_active']) {$test_active='true';} else {$test_active='false';}
		update_option('splash_test_active', $test_active);
		update_option('url_splash_image',     $_POST['url_splash_image']);
		update_option('splash_image_width',   $_POST['splash_image_width']);
		update_option('splash_image_height',  $_POST['splash_image_height']);
		update_option('splash_color',         $_POST['splash_color']);
		update_option('datepicker_start',     $_POST['datepicker_start']);
		update_option('datepicker_end',       $_POST['datepicker_end']);
		update_option('wsi_display_time',     $_POST['wsi_display_time']);
		update_option('wsi_picture_link_url', $_POST['wsi_picture_link_url']);
		if ($_POST['wsi_close_esc_function']) {$wsi_close_esc_function='true';} else {$wsi_close_esc_function='false';}
		update_option('wsi_close_esc_function', $wsi_close_esc_function);
		if ($_POST['wsi_hide_cross']) {$wsi_hide_cross='true';} else {$wsi_hide_cross='false';}
		update_option('wsi_hide_cross', $wsi_hide_cross);
		update_option('wsi_type',     $_POST['wsi_type']);
		update_option('wsi_opacity',     $_POST['wsi_opacity']);
		
		// Valeurs des onglets
		update_option('wsi_youtube',     $_POST['wsi_youtube']);
		update_option('wsi_yahoo',       $_POST['wsi_yahoo']);
		update_option('wsi_dailymotion', $_POST['wsi_dailymotion']);
		update_option('wsi_metacafe',    $_POST['wsi_metacafe']);
		update_option('wsi_swf',         $_POST['wsi_swf']);
		update_option('wsi_html',        $_POST['wsi_html']);
		
		$updated = true;
	} else {
		$updated = false;
	}

	// Send Feedback ?
	if ($_POST ['action'] == 'feedback') {
		
		//Send feedback by mail
		$to      = 'feedback@dark-sides.com';
		$subject = 'Feedback WSI';
		$message = $_POST['feedback_message'];
		$headers = 'From: '.$_POST['feedback_email'];
		mail($to, $subject, $message, $headers);
		$feedbacked = true;
	} else {
		$feedbacked = false;
	}
	
?>

<div class="wrap">

	<h2>WP Splash Image</h2>
	
	<?/* Logo Info */?>
	<div id="display_info" style="float:left;margin-top:-35px;margin-left:200px;">
		<img id="info_img" rel="#info" src="<?=wsi_url()?>/style/info.png" />
		<!-- Tooltip Info -->
		<div id="data_info_img"style="display:none;"> 
			<?=__('Infos','wp-splash-image')?>
		</div>
	</div>
	
	<?/* Logo Feedback */?>
	<div id="display_feedback" style="float:left;margin-top:-35px;margin-left:240px;">
		<img id="feedback_img" rel="#feedback" alt="<?=__('Feedback','wp-splash-image')?>" src="<?=wsi_url()?>/style/feedback_logo.png" />
		<!-- Tooltip FeedBack -->
		<div id="data_feedback_img" style="display:none;"> 
			<?=__('Feedback','wp-splash-image')?>
		</div>
	</div>
	
	<?/* Information message */?>
	<?php if ($feedbacked) { ?>
		<p style="color:green;float:left;margin-top:-28px;margin-left:290px;"><?=__("Thank's for your feedback...",'wp-splash-image')?></p>
	<?php } ?>
	
	<p>
		<?=__('For information:','wp-splash-image')?> <a target="_blank" href="http://fr.wikipedia.org/wiki/Splash_screen">Splash Screen</a>
	</p>
	<h3><?=__('Configuration','wp-splash-image')?></h3>
	<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
		<input type="hidden" name="action" value="update" />
		<table>
			<tr>
				<td><?=__('Splash image activated','wp-splash-image')?>:</td>
				<td><input 
					type="checkbox" 
					name="splash_active" 
					id="splash_active" 
					<?php if(get_option('splash_active')=='true') {echo("checked='checked'");} ?> /></td>
			</tr>
			<tr id="block_splash_test_active">
				<td><?=__('Test mode activated:','wp-splash-image')?></td>
				<td><input 
					type="checkbox" 
					name="splash_test_active" 
					id="splash_test_active" 
					<?php if(get_option('splash_test_active')=='true') {echo("checked='checked'");} ?> />
					<?=__('(for tests only, open splash image whenever)','wp-splash-image')?></td>
			</tr>
		</table>	
		<br />
		<!-- Tabs --> 
		<div style="width:850px;">
			<!-- the tabs --> 
			<ul class="tabs"> 
				<li><a href="#"><?=__('Picture')?></a></li> 
				<li><a href="#"><?=__('Video')?></a></li> 
				<li><a href="#"><?=__('HTML')?></a></li> 
			</ul> 
			<!-- tab "panes" --> 
			<div class="panes">
				<div id="tab_picture">
					<table id="box_picture" class="box_type">
						<tr>
							<td><input type="radio" id="radio_picture" name="wsi_type" value="picture" <? if(get_option('wsi_type')=="picture") echo('checked="checked"') ?> /></td>
							<td><?=__("Picture URL:",'wp-splash-image')?></td>
							<td><input 
								type="text" 
								name="url_splash_image" 
								size="100" 
								value="<?=get_option('url_splash_image')?>" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td style="vertical-align:top;"><?=__("Picture link URL",'wp-splash-image')?>:</td>
							<td><input 
								type="text" 
								name="wsi_picture_link_url" 
								size="100" 
								value="<?=get_option('wsi_picture_link_url')?>" /><br />
								<?=__('(stay empty if not required)','wp-splash-image')?></td>
						</tr>
					</table>
				</div> 
				<div id="tab_video">
					<table>
						<tr id="box_youtube" class="box_type">
							<td><input type="radio" id="radio_youtube" name="wsi_type" value="youtube" <? if(get_option('wsi_type')=="youtube") echo('checked="checked"') ?> /></td>
							<td><img src="<?=wsi_url()?>/style/youtube.png" alt="" /></td>
							<td><span><?=__('Youtube code')?>:</span></td>
							<td><input type="text" name="wsi_youtube" value="<?=get_option('wsi_youtube')?>" /></td>
						</tr>
						<tr id="box_yahoo" class="box_type">
							<td><input type="radio" id="radio_yahoo" name="wsi_type" value="yahoo" <? if(get_option('wsi_type')=="yahoo") echo('checked="checked"') ?> /></td>
							<td><img src="<?=wsi_url()?>/style/yahoo.png" alt="" /></td>
							<td><span><?=__('Yahoo video code')?>:</span></td>
							<td><input type="text" name="wsi_yahoo" value="<?=get_option('wsi_yahoo')?>" /></td>
						</tr>
						<tr id="box_dailymotion" class="box_type">
							<td><input type="radio" id="radio_dailymotion" name="wsi_type" value="dailymotion" <? if(get_option('wsi_type')=="dailymotion") echo('checked="checked"') ?> /></td>
							<td><img src="<?=wsi_url()?>/style/dailymotion.png" alt="" /></td>
							<td><span><?=__('Dailymotion code')?>:</span></td>
							<td><input type="text" name="wsi_dailymotion" value="<?=get_option('wsi_dailymotion')?>" /></td>
						</tr>
						<tr id="box_metacafe" class="box_type">
							<td><input type="radio" id="radio_metacafe" name="wsi_type" value="metacafe" <? if(get_option('wsi_type')=="metacafe") echo('checked="checked"') ?> /></td>
							<td><img src="<?=wsi_url()?>/style/metacafe.png" alt="" /></td>
							<td><span><?=__('Metacafe code')?>:</span></td>
							<td><input type="text" name="wsi_metacafe" value="<?=get_option('wsi_metacafe')?>" /></td>
						</tr>
						<tr id="box_swf" class="box_type">
							<td><input type="radio" id="radio_swf" name="wsi_type" value="swf" <? if(get_option('wsi_type')=="swf") echo('checked="checked"') ?> /></td>
							<td><img src="<?=wsi_url()?>/style/swf.png" alt="" /></td>
							<td><span><?=__('Video Flash (URL)')?>:</span></td>
							<td><input size="80" type="text" name="wsi_swf" value="<?=get_option('wsi_swf')?>" /></td>
						</tr>
					</table>
				</div> 
				<div id="tab_HTML">
					<span>
						<table>
						<tr id="box_html" class="box_type" style="height:220px;">
						<td><input type="radio" id="radio_html" name="wsi_type" value="html" <? if(get_option('wsi_type')=="html") echo('checked="checked"') ?> /></td>
						<td style="padding-left: 15px; width: 590px;"><textarea cols="75" rows="10" name="wsi_html"><?=get_option('wsi_html')?></textarea></td>
						</tr>
						</table
					</span>
				</div> 
			</div>
		</div>
		<!-- /Tabs --> 
		<br />
		<table>
			<tr>
				<td><?=__('Close esc function','wp-splash-image')?>:</td>
				<td><input 
					type="checkbox" 
					name="wsi_close_esc_function" 
					<?php if(get_option('wsi_close_esc_function')=='true') {echo("checked='checked'");} ?> />
					(<?=__('if you click on background','wp-splash-image')?>)</td>
			</tr>
			<tr>
				<td><?=__('Hide','wp-splash-image')?>&nbsp;<img src="<?=wsi_url()?>/style/close.png" class="little_cross" />&nbsp;:</td>
				<td><input 
					type="checkbox" 
					name="wsi_hide_cross" 
					<?php if(get_option('wsi_hide_cross')=='true') {echo("checked='checked'");} ?> /></td>
			</tr>
			<tr>
				<td><?=__("Splash height",'wp-splash-image')?>:</td>
				<td><input
					type="text"
					name="splash_image_height"
					size="6"
					maxlength="3"
					value="<?=get_option('splash_image_height')?>" />&nbsp;px (min = 210px)</td>
			</tr>
			<tr>
				<td><?=__("Splash width",'wp-splash-image')?>:</td>
				<td><input
					type="text"
					name="splash_image_width"
					size="6"
					maxlength="3"
					value="<?=get_option('splash_image_width')?>" />&nbsp;px</td>
			</tr>
			<tr>
				<td><?=__('Background color','wp-splash-image')?>:</td>
				<td><input
					type="color"
					name="splash_color"
					size="20"
					value="<?=get_option('splash_color')?>" /></td>
			</tr>
			<tr>
				<td><?=__('Background opacity','wp-splash-image')?>:</td>
				<td colspan="3">
					<input type="range" name="wsi_opacity" min="0" max="100" value="<?=get_option('wsi_opacity')?>" />&nbsp;%
				</td>
			</tr>
			<tr>
				<td><?=__('Start date','wp-splash-image')?>:</td>
				<td><input 
					type="date" 
					name="datepicker_start" 
					id="datepicker_start" 
					value="<?=get_option('datepicker_start')?>" />&nbsp;
					<?=__('(stay empty if not required)','wp-splash-image')?></td>
				<td style="width:15px;"></td>
				<td rowspan="2" style="padding:10px;border:2px solid #FF0000;display:none;background-color:#ff8b88" id="box_datepickers_warning">
					<?=__('Warning: WSI does not currently work.','wp-splash-image')?><br />
					<?=__('Check if dates are OK.','wp-splash-image')?>
				</td>
			</tr>
			<tr>
				<td><?=__('End date','wp-splash-image')?>:</td>
				<td><input 
					type="date" 
					name="datepicker_end" 
					id="datepicker_end" 
					value="<?=get_option('datepicker_end')?>" />&nbsp;
					<?=__('(stay empty if not required)','wp-splash-image')?></td>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td><?=__('Display time','wp-splash-image')?>:</td>
				<td colspan="3">
					<input type="range" name="wsi_display_time" min="0" max="30" value="<?=get_option('wsi_display_time')?>" />&nbsp;
					<?=__('seconds','wp-splash-image')?>&nbsp;
					<?=__("(0 don't close automaticly the splash image)",'wp-splash-image')?>
				</td>
			</tr>
		</table>
		<p class="submit"><input type="submit" value="<?=__('Update Options','wp-splash-image')?>" /></p>
	</form>

	<?/* Information message */?>
	<?php if ($updated) { ?>
		<p style="color:green;"><?=__('Options Updated...','wp-splash-image')?></p>
	<?php } ?>

	<!-- -------------- -->
	<!-- Feedback Form  -->
	<!-- -------------- -->
	
	<div id="feedback" class="overlay" style="display:none;background-image:url(<?=wsi_url()?>/style/petrol.png);color:#fff;width:500px;margin:40px;">
		<fieldset style="border:1px solid black; padding:20px 20px 5px 20px; display:inline;">
			<legend style="display:block;font-size:1.17em;font-weight:bold;margin:1em 0;margin-top:22px;" >
				&nbsp;<?=__('Feedback','wp-splash-image')?>&nbsp;
			</legend>
			<form method="post" id="feedback_form" action="<?php echo $_SERVER ['REQUEST_URI']?>">
				<input type="hidden" name="action" value="feedback" />
				<table>
					<tr>
						<td><?=__('Your Email:','wp-splash-image')?></td>
						<td><input type="email" required="required" name="feedback_email" size="50" /></td>
					</tr>
					<tr>
						<td><?=__('Message:','wp-splash-image')?></td>
						<td><textarea name="feedback_message" required="required" rows="10" cols="40"></textarea></td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" value="<?=__('Send Feedback','wp-splash-image')?>" />
				</p>
			</form>
		</fieldset>
	</div>
	
	<!-- ------------------- -->
	<!-- Documentation Form  -->
	<!-- ------------------- -->
	
	<div id="info" class="overlay" style="display:none;background-image:url(<?=wsi_url()?>/style/petrol.png);color:#fff;width:620px;height:530px;margin:40px;">
		<div style="font-weight:bold;font-size:20px;margin-bottom:10px;">Infos :</div>
		<img src="<?=wsi_url()?>/style/info_legende.jpg" style="float:left;margin-right:15px;" />
		WP Splash Image display picture if 3 conditions are OK: <br />
		<ul style="list-style-type:disc;list-style-position:inside;">
			<li><span class="plugin_title"><?=__('Splash image activated','wp-splash-image')?></span> is checked</li>
			<li>Current date is less than or equal to <span class="plugin_title"><?=__('End date','wp-splash-image')?></span>.</li>
			<li>Current date is greater than or equal to <span class="plugin_title"><?=__('Start date','wp-splash-image')?></span>.</li>
		</ul>
		<span class="plugin_number">1)</span>
		We can change the <span class="plugin_title"><?=__('Background color','wp-splash-image')?></span> with the colorpicker.<br />
		If you click on the background, you'll quit the splash image except if <span class="plugin_title"><?=__('Close esc function','wp-splash-image')?></span> is checked.
		<br /><br />
		<span class="plugin_number">2)</span>
		The <img src="<?=wsi_url()?>/style/close.png" class="little_cross" /> can be <span class="plugin_title"><?=__('Hide','wp-splash-image')?></span>.
		We can use this option with :
		<ul style="list-style-type:disc;list-style-position:inside;">
			<li><span class="plugin_title"><?=__('Close esc function','wp-splash-image')?></span></li>
			<li><span class="plugin_title"><?=__("Picture link URL",'wp-splash-image')?></span></li>
		</ul>
		for advertisment for exemple.
		<br />
		<span class="plugin_number">3)</span>
		For the picture, we can specify the
		<span class="plugin_title"><?=__("Picture height",'wp-splash-image')?></span>
		and the
		<span class="plugin_title"><?=__("Picture width",'wp-splash-image')?></span>.
		<br />
		If we fill the <span class="plugin_title"><?=__('Display time','wp-splash-image')?></span> field, the splash screen disappear after this value (in second).
		<br />
	</div>
	
	<!-- ----------------------------------------------------------------------------- --> 
	
</div>

<script type="text/javascript">

	$(document).ready(function () {
		
		// Chargement des calendriers
		$(":date").dateinput({
			format: 'dd mmm yyyy'/*,
			// Affichage de la box indiquant un pb en live
			change: function() {
				// OK sous FF mais KO sous chrome
				// TODO: Chrome fix...
				var today = new Date();
				if (today < $('#datepicker_start').data("dateinput").getValue()) {
					alert("1");
					$("#box_datepickers_warning").fadeIn("slow");
				} else if (today > $('#datepicker_end').data("dateinput").getValue()) {
					alert("2");
					$("#box_datepickers_warning").fadeIn("slow");
				} else {
					alert("3");
					$("#box_datepickers_warning").fadeOut("slow");
				}
			}*/
		});
				
		// Récupération du type de splash
		<? if ($_POST['wsi_type'] != "") { ?>
			var wsi_type = '<?=$_POST['wsi_type']?>';
			<? $wsi_type = $_POST['wsi_type']; ?>
		<? } else if(get_option('wsi_type') != "") { ?>	
			var wsi_type = '<?=get_option('wsi_type')?>';
			<? $wsi_type = get_option('wsi_type'); ?>
		<? } else { ?>
			var wsi_type = 'picture';
			<? $wsi_type = get_option('wsi_type'); ?>
		<? } ?>
		
		// Chargement des onglets
		var index_tab = new Array() ;
		index_tab["picture"]     = 0;
		index_tab["youtube"]     = 1;
		index_tab["yahoo"]       = 1;
		index_tab["dailymotion"] = 1;
		index_tab["metacafe"]    = 1;
		index_tab["swf"]         = 1;
		index_tab["html"]        = 2;
		
		$("ul.tabs").tabs("div.panes > div", {
		// Ouverture du bon onglet au démarrage
			effect: 'default', //TODO: Make my own effect : http://flowplayer.org/tools/tabs/index.html#effects
			initialIndex: index_tab[wsi_type]
		});
		
		// Gestion de l'affichage de la zone "block_splash_test_active"
		if($("#splash_active").attr("checked")==true) {
			$("#block_splash_test_active").css("display","table-row");
		}else{
			$("#block_splash_test_active").css("display","none");
		}
		$("#splash_active").click(function() {
			if($("#splash_active").attr("checked")==true) {
				$("#block_splash_test_active").fadeIn("slow");
			}else{
				$("#block_splash_test_active").fadeOut("slow");
			}
		});
		
		// Activation du tooltip du feedback
		$('#feedback_img').tooltip();
		
		// Activation du tooltip de "Info"
		$('#info_img').tooltip();
		
		function reset_validator() {
			// Activation du validator du formulaire de feedback
			return validator = $('#feedback_form').validator({
				position: 'center right',
				offset: [0, -30],
			// Désactivation du bouton d'envoi de feedback après envoi
			}).submit(function(e) {
				// Validation OK.
				if (!e.isDefaultPrevented()) {
					$("#feedback_img[rel]").overlay().close();
				}
			});
		}
		reset_validator();
		
		// Activation de l'overlay de l'info
		$("#info_img[rel]").overlay({mask: '#000', effect: 'apple'});
		
		// Activation de l'overlay du feedback
		$("#feedback_img[rel]").overlay({
			mask: '#000', 
			effect: 'apple',
			// Si on ferme l'overlay, on supprime les messages d'erreur du validator
			onClose: function() {reset_validator();}
		})
		
		// Activation du curseur pour la durée d'affichage
		$(":range").rangeinput();
		
		// Color on select input radio
		function color_box(boxId) {
			$(".box_type").animate({ backgroundColor: "#FFFFFF" }, 200);
			$(boxId).animate({       backgroundColor: "#7FFF00" }, 500);
		}
		
		$("#radio_picture").click(function() {     color_box("#box_picture")});
		$("#radio_youtube").click(function() {     color_box("#box_youtube")});
		$("#radio_yahoo").click(function() {       color_box("#box_yahoo")});
		$("#radio_dailymotion").click(function() { color_box("#box_dailymotion")});
		$("#radio_metacafe").click(function() {    color_box("#box_metacafe")});
		$("#radio_swf").click(function() {         color_box("#box_swf")});
		$("#radio_html").click(function() {        color_box("#box_html")});
		
		// Color au chargement du plugin
		$("#box_<?=$wsi_type?>").animate({ backgroundColor: "#7FFF00" }, 500);
		
		// Warning sur les dates de validités
		if ("<?=getdate_is_in_validities_dates()?>"=="false") {$("#box_datepickers_warning").fadeIn("slow");}
	
	});
</script>

<?php 
}

add_action ( 'admin_init', 'wp_splash_image_options_init' );
add_action ( 'admin_menu', 'wsi_menu' );
add_action ( 'wp_head',    'wsi_addSplashImageWpHead' );
add_action ( 'wp_footer',  'wsi_addSplashImageWpFooter' );
add_action ( 'template_redirect', 'wsi_init_session', 0 );
add_filter ( 'plugin_action_links_'.plugin_basename(__FILE__), 'wsi_filter_plugin_actions' );
add_filter ( 'plugin_row_meta',  'set_plugin_meta', 10, 2 );
add_action ( 'wp_print_scripts', 'enqueue_wsi_scripts' );
add_action ( 'wp_print_styles',  'enqueue_wsi_styles' );