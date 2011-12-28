<?php

/**
 * @author Benjamin Barbier
 *
 */
class WsiBack {

	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {}
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new WsiBack();
		} return self::$_instance;
	}
	
	/**
	 * Plug : Hooks functions to actions and filters.
	 * This is the only function to use to set up the back.
	 */
	function plug() {
		add_action ( 'admin_init',                                     array(&$this, 'wp_splash_image_back_init' ));
		add_action ( 'admin_menu',                                     array(&$this, 'wsi_menu' ));
		add_filter ( 'plugin_action_links_'.plugin_basename(__FILE__), array(&$this, 'wsi_filter_plugin_actions' ));
		add_filter ( 'plugin_row_meta',                                array(&$this, 'set_plugin_meta'), 10, 2 );
	}
	
	/**
	 * Init de la partie Admin
	 */
	public function wp_splash_image_back_init() {
	
		// Chargement de l' I18n
		if (function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('wp-splash-image', WsiCommons::getURL().'/languages', $wsi_plugin_dir.'/languages' );
		}
	
	}
	
	/**
	 * Crée l'entrée dans le menu "Réglages" de la partie admin de wordpress
	 */
	public function wsi_menu() {
		
		$page = add_options_page(
				'WP Splash Image Options', 
				'WP Splash Image', 
				'manage_options', 
				'wp_splash_image', 
				array(&$this, 'wp_splash_image_options'));
	
		/* Using registered $page handle to hook stylesheet loading */
		add_action('admin_print_styles-' . $page, array(&$this, 'enqueue_wsi_back_styles'));
	
		/* Using registered $page handle to hook script load */
		add_action('admin_print_scripts-' . $page, array(&$this, 'enqueue_wsi_back_scripts'));
		
	}
	
	/**
	 * Utilisation des styles de la partie Admin
	 */
	public function enqueue_wsi_back_styles() {
		// Déclaration des styles de la partie Admin
		wp_register_style('tabs', WsiCommons::getURL().'/style/tabs.css'); /*Style pour les onglets*/
		wp_register_style('validator-error', WsiCommons::getURL().'/style/validator-error.css'); /*Style pour le validator du feedback*/
		wp_register_style('overlay-basic', WsiCommons::getURL().'/style/overlay-basic.css'); /*Style pour la box de documentation + feedback*/
		wp_register_style('date-input', WsiCommons::getURL().'/style/dateinput.css'); /*Style pour les calendriers*/
		wp_register_style('range', WsiCommons::getURL().'/style/range.css'); /*Style pour le curseur de temps*/
		wp_register_style('wsi', WsiCommons::getURL().'/style/wsi.css');
		
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
	public function enqueue_wsi_back_scripts() {
		if (isset($_GET['page']) && $_GET['page'] == 'wp_splash_image') {
			
			// Déclaration des scripts de la partie Admin
			wp_register_script('jquery.tools.back', WsiCommons::getURL().'/js/jquery.tools.min.wp-back.js'); /*[tabs, overlay, overlay.apple, dateinput, rangeinput, validator]*/
			wp_register_script('jquery.tooltip', WsiCommons::getURL().'/js/tooltip.jquery.js'); /*Infobulle(tooltip) pour feedback*/
			wp_register_script('mcolorpicker', 'http://plugins.meta100.com/mcolorpicker/javascripts/mColorPicker_min.js'); /*Colorpicker*/
			
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery.tools.back', false, array('jquery'));
			wp_enqueue_script('jquery.tooltip',    false, array('jquery'));
			wp_enqueue_script('mcolorpicker',      false, array('jquery'));
		}
	}
	
	/**
	 * Ajoute entrée dans la page des extensions (partie gauche)
	 */
	public function wsi_filter_plugin_actions( $links ) {
	
		/* Lien vers la partie admin */
		$settings_link = '<a href="options-general.php?page=wp_splash_image">'.__('Settings','wp-splash-image').'</a>';
		array_unshift( $links, $settings_link );
	
		return $links;
	}
	
	/**
	 * Ajoute entrée dans la page des extensions (partie droite)
	 */
	public function set_plugin_meta($links, $file) {
	
		$plugin = plugin_basename(__FILE__);
		if ($file == $plugin) {
			return array_merge(
					$links,
					array(
					/* Lien "Donate" de PayPal */
							'<a target="_blank" style="font-weight:bold;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C">'.__('Donate','wp-splash-image').'</a>'
							//,'un autre lien...'
					));
		}
		return $links;
	}
	
	/**
	 * Fonction utilisée dans la partie Admin 
	 */
	public function wp_splash_image_options() {
		
		// L'utilisateur a-t-il les droits suffisants pour afficher la page
		if (!current_user_can('manage_options'))  {
			wp_die( __("You do not have sufficient permissions to access this page.",'wp-splash-image') );
		}
		
		// Liste des options qui apparait dans le formulaire "uninstall" (et qui sont supprimées)
		$list_options = array(
			'splash_active', 
			'splash_test_active', 
			'url_splash_image', 
			'splash_image_width',
			'splash_image_height',
			'splash_color',
			'datepicker_start',
			'datepicker_end',
			'wsi_display_time',
			'wsi_picture_link_url',
			'wsi_picture_link_target',
			'wsi_close_esc_function',
			'wsi_hide_cross',
			'wsi_disable_shadow_border',
			'wsi_type',
			'wsi_opacity',
			'wsi_youtube',
			'wsi_yahoo',
			'wsi_dailymotion',
			'wsi_metacafe',
			'wsi_swf',
			'wsi_html');
			
		// Mise à jour ?
		if ($_POST ['action'] == 'update') {
			// On met à jour la base de données (table: options) avec la fonction de wp: update_option
			if ($_POST['splash_active']) {$active='true';} else {$active='false';}
			update_option('splash_active', $active);
			if ($_POST['splash_test_active']) {$test_active='true';} else {$test_active='false';}
			update_option('splash_test_active', $test_active);
			update_option('url_splash_image',        $_POST['url_splash_image']);
			update_option('splash_image_width',      $_POST['splash_image_width']);
			update_option('splash_image_height',     $_POST['splash_image_height']);
			update_option('splash_color',            $_POST['splash_color']);
			update_option('datepicker_start',        $_POST['datepicker_start']);
			update_option('datepicker_end',          $_POST['datepicker_end']);
			update_option('wsi_display_time',        $_POST['wsi_display_time']);
			update_option('wsi_picture_link_url',    $_POST['wsi_picture_link_url']);
			update_option('wsi_picture_link_target', $_POST['wsi_picture_link_target']);
			if ($_POST['wsi_close_esc_function']) {$wsi_close_esc_function='true';} else {$wsi_close_esc_function='false';}
			update_option('wsi_close_esc_function', $wsi_close_esc_function);
			if ($_POST['wsi_hide_cross']) {$wsi_hide_cross='true';} else {$wsi_hide_cross='false';}
			update_option('wsi_hide_cross', $wsi_hide_cross);
			if ($_POST['wsi_disable_shadow_border']) {$wsi_disable_shadow_border='true';} else {$wsi_disable_shadow_border='false';}
			update_option('wsi_disable_shadow_border', $wsi_disable_shadow_border);
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
		
		// Uninstall ?
		if ($_POST ['action'] == 'uninstall') {
			$uninstalled_message .= '<p>';
			foreach($list_options as $option) {
				$delete_option = delete_option($option);
				if($delete_option) {
					$uninstalled_message .= '<font color="green">';
					$uninstalled_message .= sprintf(__('Setting Key \'%s\' has been deleted.', 'wp-splash-image'), "<strong><em>{$option}</em></strong>");
					$uninstalled_message .= '</font><br />';
				} else {
					$uninstalled_message .= '<font color="red">';
					$uninstalled_message .= sprintf(__('Error deleting Setting Key \'%s\'.', 'wp-splash-image'), "<strong><em>{$option}</em></strong>");
					$uninstalled_message .= '</font><br />';
				}
			}
			$uninstalled_message .= '</p>';
			
			// Find uninstall URL
			$deactivate_url = 'plugins.php?action=deactivate&plugin=wsi%2Fwp-splash-image.php&plugin_status=all&paged=1';
			if(function_exists('wp_nonce_url')) { 
				$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_wsi/wp-splash-image.php');
			}
			
			$uninstalled = true;		
		} else {
			$uninstalled = false;
		}
		
	?>
	
	<div class="wrap">
	
		<h2>WP Splash Image</h2>
		
		<?/* Logo Info */?>
		<div id="display_info" style="float:left;margin-top:-35px;margin-left:200px;">
			<img id="info_img" rel="#info" src="<?=WsiCommons::getURL()?>/style/info.png" />
			<!-- Tooltip Info -->
			<div id="data_info_img"style="display:none;"> 
				<?=__('Infos','wp-splash-image')?>
			</div>
		</div>
		
		<?/* Logo Feedback */?>
		<div id="display_feedback" style="float:left;margin-top:-35px;margin-left:240px;">
			<img id="feedback_img" rel="#feedback" alt="<?=__('Feedback','wp-splash-image')?>" src="<?=WsiCommons::getURL()?>/style/feedback_logo.png" />
			<!-- Tooltip FeedBack -->
			<div id="data_feedback_img" style="display:none;"> 
				<?=__('Feedback','wp-splash-image')?>
			</div>
		</div>
		
		<?/* Logo Uninstall */?>
		<div id="display_uninstall" style="float:left;margin-top:-35px;margin-left:283px;">
			<img id="uninstall_img" rel="#uninstall" alt="<?=__('Uninstall','wp-splash-image')?>" src="<?=WsiCommons::getURL()?>/style/uninstall.png" />
			<!-- Tooltip FeedBack -->
			<div id="data_uninstall_img" style="display:none;"> 
				<?=__('Uninstall','wp-splash-image')?>
			</div>
		</div>
		
		
		<?/* Information message */?>
		<?php if ($feedbacked) { ?>
			<div id="message" class="updated fade" style="color:green;"><?=__("Thank's for your feedback...",'wp-splash-image')?></div>
		<?php } else if ($updated) { ?>
			<div id="message" class="updated fade" style="color:green;"><?=__('Options Updated...','wp-splash-image')?></div>
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
									size="90" 
									value="<?=get_option('url_splash_image')?>" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="vertical-align:top;"><?=__("Picture link URL",'wp-splash-image')?>:</td>
								<td><input 
									type="text" 
									name="wsi_picture_link_url" 
									size="90" 
									value="<?=get_option('wsi_picture_link_url')?>" /><br />
									<?=__('(stay empty if not required)','wp-splash-image')?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="vertical-align:top;"><?=__("Picture link target",'wp-splash-image')?>:</td>
								<td>
									<select name="wsi_picture_link_target" value="<?=get_option('wsi_picture_link_target')?>">
										<option value="self">Self</option>
										<option value="blank">Blank</option>
									</select>
								</td>
							</tr>
						</table>
					</div> 
					<div id="tab_video">
						<table>
							<tr id="box_youtube" class="box_type">
								<td><input type="radio" id="radio_youtube" name="wsi_type" value="youtube" <? if(get_option('wsi_type')=="youtube") echo('checked="checked"') ?> /></td>
								<td><img src="<?=WsiCommons::getURL()?>/style/youtube.png" alt="" /></td>
								<td><span><?=__('Youtube code')?>:</span></td>
								<td><input type="text" name="wsi_youtube" value="<?=get_option('wsi_youtube')?>" /></td>
							</tr>
							<tr id="box_yahoo" class="box_type">
								<td><input type="radio" id="radio_yahoo" name="wsi_type" value="yahoo" <? if(get_option('wsi_type')=="yahoo") echo('checked="checked"') ?> /></td>
								<td><img src="<?=WsiCommons::getURL()?>/style/yahoo.png" alt="" /></td>
								<td><span><?=__('Yahoo video code')?>:</span></td>
								<td><input type="text" name="wsi_yahoo" value="<?=get_option('wsi_yahoo')?>" /></td>
							</tr>
							<tr id="box_dailymotion" class="box_type">
								<td><input type="radio" id="radio_dailymotion" name="wsi_type" value="dailymotion" <? if(get_option('wsi_type')=="dailymotion") echo('checked="checked"') ?> /></td>
								<td><img src="<?=WsiCommons::getURL()?>/style/dailymotion.png" alt="" /></td>
								<td><span><?=__('Dailymotion code')?>:</span></td>
								<td><input type="text" name="wsi_dailymotion" value="<?=get_option('wsi_dailymotion')?>" /></td>
							</tr>
							<tr id="box_metacafe" class="box_type">
								<td><input type="radio" id="radio_metacafe" name="wsi_type" value="metacafe" <? if(get_option('wsi_type')=="metacafe") echo('checked="checked"') ?> /></td>
								<td><img src="<?=WsiCommons::getURL()?>/style/metacafe.png" alt="" /></td>
								<td><span><?=__('Metacafe code')?>:</span></td>
								<td><input type="text" name="wsi_metacafe" value="<?=get_option('wsi_metacafe')?>" /></td>
							</tr>
							<tr id="box_swf" class="box_type">
								<td><input type="radio" id="radio_swf" name="wsi_type" value="swf" <? if(get_option('wsi_type')=="swf") echo('checked="checked"') ?> /></td>
								<td><img src="<?=WsiCommons::getURL()?>/style/swf.png" alt="" /></td>
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
							<td style="padding-left: 15px; width: 590px;"><textarea cols="75" rows="10" name="wsi_html"><?=stripslashes(get_option('wsi_html'))?></textarea></td>
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
					<td><?=__('Hide','wp-splash-image')?>&nbsp;<img src="<?=WsiCommons::getURL()?>/style/close.png" class="little_cross" />&nbsp;:</td>
					<td><input 
						type="checkbox" 
						name="wsi_hide_cross" 
						<?php if(get_option('wsi_hide_cross')=='true') {echo("checked='checked'");} ?> /></td>
				</tr>
				<tr>
					<td><?=__('Disable shadow border','wp-splash-image')?>:</td>
					<td><input
						type="checkbox" 
						name="wsi_disable_shadow_border" 
						<?php if(get_option('wsi_disable_shadow_border')=='true') {echo("checked='checked'");} ?> />
						(<?=__('useful for images with transparent edges','wp-splash-image')?>)</td>
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
					<td colspan="3" style="white-space: nowrap;">
						<input type="range" name="wsi_display_time" min="0" max="30" value="<?=get_option('wsi_display_time')?>" />&nbsp;
						<?=__('seconds','wp-splash-image')?>&nbsp;
						<?=__("(0 don't close automaticly the splash image)",'wp-splash-image')?>
					</td>
				</tr>
			</table>
			<p class="submit"><input type="submit" value="<?=__('Update Options','wp-splash-image')?>" /></p>
		</form>
	
		<!-- --------------- -->
		<!-- Uninstall Form  -->
		<!-- --------------- -->
		
		<div id="uninstall" class="overlay" style="display:none;background-image:url(<?=WsiCommons::getURL()?>/style/petrol.png);color:#fff;width:620px;height:530px;margin:40px;">
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
				<input type="hidden" name="action" value="uninstall" />
				<div class="wrap"> 
					<h3><?=__('Uninstall WP-Splash-Image', 'wp-splash-image'); ?></h3>
					<p><?=__('Deactivating WP-Splash-Image plugin does not remove any data that may have been created, such as the stats options. To completely remove this plugin, you can uninstall it here.', 'wp-splash-image'); ?></p>
					<p style="color: red">
						<strong><?=__('WARNING:', 'wp-splash-image'); ?></strong><br />
						<?=__('Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.', 'wp-splash-image'); ?>
					</p>
					<p style="color: red"><strong><?=__('The following WordPress Options will be DELETED:', 'wp-splash-image'); ?></strong><br /></p>
					<table class="widefat">
						<thead><tr><th><?=__('WordPress Options', 'wp-splash-image'); ?></th></tr></thead>
						<tr>
							<td valign="top" style="color: black;">
								<ol style="height:200px;overflow:auto;padding-left:40px">
								<?php
									foreach($list_options as $option) {
										echo '<li>'.$option.'</li>'."\n";
									}
								?>
								</ol>
							</td>
						</tr>
					</table>
					<br />
					<p style="text-align: center;">
						<input type="submit" class="button"
							value="<?=__('UNINSTALL WP-Splash Image', 'wp-splash-image'); ?>" 
							onclick="return confirm('<?=__('You Are About To Uninstall WP-Splash-Image From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.', 'wp-splash-image'); ?>')" />
					</p>
				</div> 
			</form>
		</div>
		
		<!-- ----------------------- -->
		<!-- Uninstall Confirm Form  -->
		<!-- ----------------------- -->
		
		<?php if ($uninstalled) { ?>
			
			<a style="display:none;" id="uninstall_confirm_link" href="#" rel="#uninstall_confirm"></a>
			<div id="uninstall_confirm" class="overlay" style="display:none;background-image:url(<?=WsiCommons::getURL()?>/style/petrol.png);color:#fff;width:595px;height:465px;padding:30px;z-index:2">
			<div class="close" style="right:5px;top:5px;"></div>
			
				<h3 style="margin-left:15px;"><?=__('Uninstall WP-Splash-Image', 'wp-splash-image'); ?></h3>
				<div class="uninstallCheckList"><?=$uninstalled_message?></div>
				<br />
				<p style="text-align:center;">
					<strong><?=__('To finish the uninstallation and deactivate automatically WP-Splash-Image :', 'wp-splash-image')?></strong>
					<br /><br /><br />
					<input type="button" class="button" 
						value="<?=__('Click Here', 'wp-splash-image')?>" 
						onClick="javascript:window.open('<?=$deactivate_url?>','_self');" />
				</p>
				
			</div>
			<script type="text/javascript">
				$(document).ready(function (){$("#uninstall_confirm_link").overlay({load:true});});
			</script>
			
		<?php } ?>
		
		<!-- -------------- -->
		<!-- Feedback Form  -->
		<!-- -------------- -->
		
		<div id="feedback" class="overlay" style="display:none;background-image:url(<?=WsiCommons::getURL()?>/style/petrol.png);color:#fff;width:500px;margin:40px;">
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
		
		<div id="info" class="overlay" style="display:none;background-image:url(<?=WsiCommons::getURL()?>/style/petrol.png);color:#fff;width:620px;height:530px;margin:40px;">
			<div style="font-weight:bold;font-size:20px;margin-bottom:10px;">Infos :</div>
			<img src="<?=WsiCommons::getURL()?>/style/info_legende.jpg" style="float:left;margin-right:15px;" />
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
			The <img src="<?=WsiCommons::getURL()?>/style/close.png" class="little_cross" /> can be <span class="plugin_title"><?=__('Hide','wp-splash-image')?></span>.
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
			
			// Activation du tooltip de "Uninstall"
			$('#uninstall_img').tooltip();
			
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
			
			// Activation de l'overlay du "Uninstall"
			$("#uninstall_img[rel]").overlay({mask: '#000', effect: 'apple'});
			
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
			if ("<?=WsiCommons::getdate_is_in_validities_dates()?>"=="false") {$("#box_datepickers_warning").fadeIn("slow");}
		
		});
	</script>

<?php 
	}
} 
?>