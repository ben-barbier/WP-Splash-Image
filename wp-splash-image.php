<?php
/*
Plugin Name: WP Splash Image
Plugin URI: http://wordpress.org/extend/plugins/wsi/
Description: WP Splash Image is a plugin for Wordpress to display an image with a lightbox type effect at the opening of the blog.
Version: 0.9
Author: Benjamin Barbier
Author URI: http://www.dark-sides.com/
*/

/**
 * Crée l'entrée dans le menu "Réglages" de la partie admin de wordpress
 */
function wsi_menu() {
	add_options_page('WP Splash Image Options', 'WP Splash Image', 'manage_options', 'wp_splash_image', 'wp_splash_image_options');
}

/**
 * Ajoute entrée dans la page des extensions
 */
function wsi_filter_plugin_actions( $links ) { 
	
	/* Donate de PayPal */
	$donate_link = '<a target="_blank" style="font-weight:bold;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C">'.__('Donate','wp-splash-image').'</a>';
	array_unshift( $links, $donate_link );
	
	/* Lien vers la partie admin */
	$settings_link = '<a href="options-general.php?page=wp_splash_image">'.__('Settings','wp-splash-image').'</a>'; 
	array_unshift( $links, $settings_link );
	
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
	$today = date('d/m/Y');
	if((get_option('datepicker_start')!='') && ($today < get_option('datepicker_start'))) return;
	if((get_option('datepicker_end')!='')   && ($today > get_option('datepicker_end')))   return;
	
	// Si la Splash image a déjà été vue, on ne fait rien (sauf si on est en mode test)
	if(($_SESSION['splash_seen']=='Yes') && (get_option('splash_test_active')!='true'))  return;
	
	$url_splash_image = get_option ('url_splash_image');
?>

	<!-- WP Splash-Image -->
	<link rel="stylesheet" type="text/css" href="<?=wsi_url()?>/style/overlay-basic.css"/> 
	<script src="<?=wsi_url()?>/js/jquery.tools.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {
		$("#splashLink").overlay({
			expose: '<?=get_option('splash_color')?>',
			load: true // Lance la Splash Image à l'ouverture
		});
	});
	</script>
	<!-- /WP Splash-Image -->

<?php
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
		$today = date('d/m/Y');
		if((get_option('datepicker_start')!='') && ($today < get_option('datepicker_start'))) return;
		if((get_option('datepicker_end')!='')   && ($today > get_option('datepicker_end')))   return;

		// Si la Splash image a déjà été vue, on ne fait rien
		if($_SESSION['splash_seen']=='Yes')  return;

	}
	
	// On indique que la Splash Image a été vue
	$_SESSION['splash_seen']='Yes';
	
	$url_splash_image = get_option('url_splash_image');
	$splash_image_height = get_option('splash_image_height');
	$splash_image_width = get_option('splash_image_width');
	$wsi_display_time = get_option('wsi_display_time');
		
?>	

	<!-- WP Splash-Image -->
	<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
	<div class="simple_overlay" style="text-align:center;color:#FFFFFF;margin-top:15px;height:<?=$splash_image_height?>px;width:<?=$splash_image_width?>px;" id="miesSPLASH">
		<img style="height:<?=$splash_image_height?>px;width:<?=$splash_image_width?>px;" src="<?=$url_splash_image?>" />
	</div>
	<?php if ($wsi_display_time > 0) { ?>
	<script type="text/javascript">
	// Autoclose de la Splash Image
	$(document).ready(function () {
		setTimeout("$('#miesSPLASH').fadeOut()",<?=($wsi_display_time*1000)?>);
		setTimeout("$('#exposeMask').fadeOut()",<?=($wsi_display_time*1000)?>);
	});
	</script>
	<? } ?>
	<!-- /WP Splash-Image -->
	
<?php
}

/**
 * Fonction utilisée dans la partie Admin (initialisation)
 */
function wp_splash_image_options_init()
{
	$wsi_plugin_dir = dirname(plugin_basename(__FILE__));
	// Chargement de l' I18n
	if (function_exists('load_plugin_textdomain')) {
		load_plugin_textdomain('wp-splash-image', PLUGINDIR.'/'.$wsi_plugin_dir.'/languages', $wsi_plugin_dir.'/languages' );
	}
}

/**
 * Fonction utilisée dans la partie Admin 
 */
function wp_splash_image_options() {
	
	// L'utilisateur a-t-il les droits suffisants pour afficher la page
	if (!current_user_can('manage_options'))  {
		wp_die( __("You do not have sufficient permissions to access this page.",'wp-splash-image') );
	}
	
?>

	<?/* Import des librairies JQuery + CSS pour la partie admin */?>
	<script type="text/javascript" src="<?=wsi_url()?>/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?=wsi_url()?>/js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="<?=wsi_url()?>/js/jquery.ui.datepicker-fr.js"></script>
	<script type="text/javascript" src="<?=wsi_url()?>/js/jquery.timer.js"></script>
	<script type="text/javascript" src="<?=wsi_url()?>/js/tooltip.jquery.js"></script>
	<script type="text/javascript" src="http://plugins.meta100.com/mcolorpicker/javascripts/mColorPicker_min.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="<?=wsi_url()?>/style/ui-lightness/jquery-ui-1.8.2.custom.css"/> 
	
	<script type="text/javascript">
	$(document).ready(function () {
		
		// Chargement des calendriers
		$("#datepicker_start").datepicker({minDate: 0, maxDate: '+1Y'},$.datepicker.regional['fr']);
		$("#datepicker_end").datepicker({minDate: 0, maxDate: '+1Y +6M'},  $.datepicker.regional['fr']);
		
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
		
		// Gestion de l'affichage de la zone "feedback"
		$("#display_feedback").click(function() {
			if($("#feedback").css("display")=="none") {
				$("#feedback").fadeIn("slow");
			}else{
				$("#feedback").fadeOut("slow");
			}
		});
		
		// Gestion du clignotement du feedback
		$(document).everyTime(1000, function(i) {
			if (i%2>0) {
				$("#feedback_img2").fadeOut(1000);
			} else {
				$("#feedback_img2").fadeIn(1000);
			}
		});
		
		// Gestion du tooltip du fidback
		$('#feedback_img2').tooltip();
		
		// Gestion du bouton "close" du feedback
		$('#close_feedback').click(function() {
			$('#feedback').fadeOut("slow");
		});
		
	});
	</script>
	
<?php
	
	// Mise à jour ?
	if ($_POST ['action'] == 'update') {
		// On met à jour la base de données (table: options) avec la fonction de wp: update_option
		if ($_POST['splash_active']) {$active='true';} else {$active='false';}
		update_option('splash_active', $active);
		if ($_POST['splash_test_active']) {$test_active='true';} else {$test_active='false';}
		update_option('splash_test_active', $test_active);
		update_option('url_splash_image',    $_POST['url_splash_image']);
		update_option('splash_image_width',  $_POST['splash_image_width']);
		update_option('splash_image_height', $_POST['splash_image_height']);
		update_option('splash_color',        $_POST['splash_color']);
		update_option('datepicker_start',    $_POST['datepicker_start']);
		update_option('datepicker_end',      $_POST['datepicker_end']);
		update_option('wsi_display_time',    $_POST['wsi_display_time']);
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
	<p>
		<?=__('For information:','wp-splash-image')?> <a target="_blank" href="http://fr.wikipedia.org/wiki/Splash_screen">Splash Screen</a>
	</p>
	<h3><?=__('Configuration','wp-splash-image')?></h3>
	<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
		<input type="hidden" name="action" value="update" />
		<table>
			<tr>
				<td><?=__('Splash image activated:','wp-splash-image')?></td>
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
			<tr>
				<td><?=__("Picture URL:",'wp-splash-image')?></td>
				<td><input 
					type="text" 
					name="url_splash_image" 
					size="120" 
					value="<?=get_option('url_splash_image')?>" /></td>
			</tr>
			<tr>
				<td><?=__("Picture height:",'wp-splash-image')?></td>
				<td><input
					type="text"
					name="splash_image_height"
					size="6"
					maxlength="3"
					value="<?=get_option('splash_image_height')?>" />&nbsp;px (min = 210px)</td>
			</tr>
			<tr>
				<td><?=__("Picture width:",'wp-splash-image')?></td>
				<td><input
					type="text"
					name="splash_image_width"
					size="6"
					maxlength="3"
					value="<?=get_option('splash_image_width')?>" />&nbsp;px</td>
			</tr>
			<tr>
				<td><?=__('Splash color:','wp-splash-image')?></td>
				<td><input
					type="color"
					name="splash_color"
					size="20"
					value="<?=get_option('splash_color')?>" /></td>
			</tr>
			<tr>
				<td><?=__('Start date:','wp-splash-image')?></td>
				<td><input 
					type="text" 
					name="datepicker_start" 
					id="datepicker_start"
					value="<?=get_option('datepicker_start')?>" />&nbsp;
					<?=__('(stay empty if not required)','wp-splash-image')?></td>
			</tr>
			<tr>
				<td><?=__('End date:','wp-splash-image')?></td>
				<td><input 
					type="text" 
					name="datepicker_end" 
					id="datepicker_end"
					value="<?=get_option('datepicker_end')?>" />&nbsp;
					<?=__('(stay empty if not required)','wp-splash-image')?></td>
			</tr>
			<tr>
				<td><?=__('Display time:','wp-splash-image')?></td>
				<td><input
					type="text"
					name="wsi_display_time"
					size="5"
					maxlength="5"
					value="<?=get_option('wsi_display_time')?>" />&nbsp;
					<?=__('seconds','wp-splash-image')?>&nbsp;
					<?=__("(0 or empty don't close automaticly the splash image)",'wp-splash-image')?></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" value="<?=__('Update Options','wp-splash-image')?>" /></p>
	</form>

	<?/* Information message */?>
	<?php if ($updated) { ?>
		<p style="color:green;"><?=__('Options Updated...','wp-splash-image')?></p>
	<?php } ?>
	<?php if ($feedbacked) { ?>
		<p style="color:green;"><?=__("Thank's for your feedback...",'wp-splash-image')?></p>
	<?php } ?>

	<br />
	<div id="display_feedback" style="float:left;margin-top:16px;">
		<img id="feedback_img1" alt="<?=__('Feedback','wp-splash-image')?>" src="<?=wsi_url()?>/style/feedback_logo_1.png" style="position:absolute;" />
		<img id="feedback_img2" alt="<?=__('Feedback','wp-splash-image')?>" src="<?=wsi_url()?>/style/feedback_logo_2.png" style="position:absolute;" />
		<!-- Tooltip FeedBack -->
		<div id="data_feedback_img2"style="display:none;"> 
			<?=__('Feedback','wp-splash-image')?>
		</div> 
	</div>
	<div id="feedback" style="display:none;margin-left:40px;">
		<fieldset style="border:1px solid black; padding:20px 20px 5px 20px; display:inline;">
			<legend style="display:block;font-size:1.17em;font-weight:bold;margin:1em 0;margin-top:22px;" >
				&nbsp;<?=__('Feedback','wp-splash-image')?>&nbsp;
			</legend>
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
				<input type="hidden" name="action" value="feedback" />
				<table>
					<tr>
						<td><?=__('Your Email:','wp-splash-image')?></td>
						<td><input type="text" name="feedback_email" size="50" /></td>
					</tr>
					<tr>
						<td><?=__('Message:','wp-splash-image')?></td>
						<td><textarea name="feedback_message" rows="10" cols="40"></textarea></td>
					</tr>
				</table>
				<p class="submit">
					<input type="button" value="<?=__('Close','wp-splash-image')?>" id="close_feedback" />
					<input type="submit" value="<?=__('Send Feedback','wp-splash-image')?>" />
				</p>
			</form>
		</fieldset>
	</div>
</div>

<?php 
}

add_action ( 'admin_menu', 'wsi_menu' );
add_action ( 'admin_init', 'wp_splash_image_options_init');
add_action ( 'wp_head',    'wsi_addSplashImageWpHead' );
add_action ( 'wp_footer',  'wsi_addSplashImageWpFooter' );
add_action ( 'template_redirect', 'wsi_init_session', 0);
add_filter ( 'plugin_action_links_'.plugin_basename(__FILE__), 'wsi_filter_plugin_actions' );