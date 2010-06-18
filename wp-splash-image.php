<?php
/*
Plugin Name: WP Splash Image
Plugin URI: http://wordpress.org/extend/plugins/wsi/
Description: WP Splash Image est un plugin pour Wordpress permettant d'afficher une image avec un effet de type Lightbox à l'ouverture du blog.
Version: 0.5
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
	$(function() {
		$("#splashLink").overlay({
			expose: '<?=get_option('splash_color')?>'
		});
	});
	$(document).ready(function () {
		$("#splashLink").click();
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
	
	// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
	$today = date('d/m/Y');
	if((get_option('datepicker_start')!='') && ($today < get_option('datepicker_start'))) return;
	if((get_option('datepicker_end')!='')   && ($today > get_option('datepicker_end')))   return;

	// Si la Splash image a déjà été vue, on ne fait rien (sauf si on est en mode test)
	if(($_SESSION['splash_seen']=='Yes') && (get_option('splash_test_active')!='true'))  return;

	// On indique que la Splash Image a été vue
	$_SESSION['splash_seen']='Yes';
	
	$url_splash_image = get_option ('url_splash_image');
?>	

	<!-- WP Splash-Image -->
	<a style="display:none;" id="splashLink" href="#" rel="#miesSPLASH"></a>
	<div class="simple_overlay" style="text-align:center;color:#FFFFFF;margin-top:15px;height:<?=get_option('splash_image_height')?>px;width:<?=get_option('splash_image_width')?>px;" id="miesSPLASH">
		<img style="height:<?=get_option('splash_image_height')?>px;width:<?=get_option('splash_image_width')?>px;" src="<?=$url_splash_image?>" />
	</div> 
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
	<script type="text/javascript" src="http://plugins.meta100.com/mcolorpicker/javascripts/mColorPicker_min.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="<?=wsi_url()?>/style/ui-lightness/jquery-ui-1.8.2.custom.css"/> 
	
	<script type="text/javascript">
	$(document).ready(function () {
		// Chargement des calendriers
		$("#datepicker_start").datepicker($.datepicker.regional['fr']);
		$("#datepicker_end").datepicker($.datepicker.regional['fr']);
		
		// Gestion de l'affichage de la zone "block_splash_test_active"
		if($("#splash_active").attr("checked")==true) {
			$("#block_splash_test_active").css("display","block");
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
		$updated = true;
	} else {
		$updated = false;
	}

?>

<div class="wrap">
	<h2>WP Splash Image</h2>
	<p>
		<?=__('For information:','wp-splash-image')?> <a target="_blank" href="http://fr.wikipedia.org/wiki/Splash_screen">Splash Screen</a>
	</p>
	<h3>Configuration</h3>
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
					size="10"
					value="<?=get_option('splash_image_height')?>" />px (min = 210px)</td>
			</tr>
			<tr>
				<td><?=__("Picture width:",'wp-splash-image')?></td>
				<td><input
					type="text"
					name="splash_image_width"
					size="10"
					value="<?=get_option('splash_image_width')?>" />px</td>
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
					value="<?=get_option('datepicker_start')?>" /> <?=__('(stay empty if not required)','wp-splash-image')?></td>
			</tr>
			<tr>
				<td><?=__('End date:','wp-splash-image')?></td>
				<td><input 
					type="text" 
					name="datepicker_end" 
					id="datepicker_end"
					value="<?=get_option('datepicker_end')?>" /> <?=__('(stay empty if not required)','wp-splash-image')?></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" value="<?=__('Update Options','wp-splash-image')?>" /></p>
	</form>
	<?php if ($updated) { ?>
		<p style="color:green;"><?=__('Options Updated...','wp-splash-image')?></p>
	<?php } ?>
	<br />
</div>

<?php 
}

add_action ( 'admin_menu', 'wsi_menu' );
add_action ( 'admin_init', 'wp_splash_image_options_init');
add_action ( 'wp_head',    'wsi_addSplashImageWpHead' );
add_action ( 'wp_footer',  'wsi_addSplashImageWpFooter' );
add_action ( 'template_redirect', 'wsi_init_session', 0);