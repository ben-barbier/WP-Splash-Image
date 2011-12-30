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
			wp_register_script('jquery.keyfilter', WsiCommons::getURL().'/js/jquery.keyfilter-1.7.min.js'); /* KeyFilter (for splash_color, splash_image_height, splash_image_width fields) */
			
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery.tools.back', false, array('jquery'));
			wp_enqueue_script('jquery.tooltip',    false, array('jquery'));
			wp_enqueue_script('jquery.keyfilter',  false, array('jquery'));
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
			'wsi_youtube_autoplay',
			'wsi_youtube_loop',
			'wsi_yahoo',
			'wsi_dailymotion',
			'wsi_metacafe',
			'wsi_swf',
			'wsi_html');
			
		// Mise à jour ?
		if ($_POST ['action'] == 'update') {
			
			// Vérification du token de sécurité.
			check_admin_referer('update','nonce_update_field');
			
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
			if ($_POST['wsi_youtube_autoplay']) {$wsi_youtube_autoplay='true';} else {$wsi_youtube_autoplay='false';}
			update_option('wsi_youtube_autoplay', $wsi_youtube_autoplay);
			if ($_POST['wsi_youtube_loop']) {$wsi_youtube_loop='true';} else {$wsi_youtube_loop='false';}
			update_option('wsi_youtube_loop', $wsi_youtube_loop);
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
			
			// Vérification du token de sécurité.
			check_admin_referer('feedback','nonce_feedback_field');
			
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
			
			// Vérification du token de sécurité.
			check_admin_referer('uninstall','nonce_uninstall_field');
			
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
		
		<!-- Logo Info -->
		<div id="display_info">
			<img id="info_img" rel="#info" src="<?php echo WsiCommons::getURL(); ?>/style/info.png" />
			<!-- Tooltip Info -->
			<div id="data_info_img"style="display:none;"> 
				<?php echo __('Infos','wp-splash-image'); ?>
			</div>
		</div>
		
		<!-- Logo Feedback -->
		<div id="display_feedback">
			<img id="feedback_img" rel="#feedback" alt="<?php echo __('Feedback','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/feedback_logo.png" />
			<!-- Tooltip FeedBack -->
			<div id="data_feedback_img" style="display:none;"> 
				<?php echo __('Feedback','wp-splash-image'); ?>
			</div>
		</div>
		
		<!-- Logo Uninstall -->
		<div id="display_uninstall">
			<img id="uninstall_img" rel="#uninstall" alt="<?php echo __('Uninstall','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/uninstall.png" />
			<!-- Tooltip FeedBack -->
			<div id="data_uninstall_img" style="display:none;"> 
				<?php echo __('Uninstall','wp-splash-image'); ?>
			</div>
		</div>
		
		<!-- Information message -->
		<?php if ($feedbacked) { ?>
			<div id="message" class="updated fade" style="color:green;"><?php echo __("Thank's for your feedback...",'wp-splash-image'); ?></div>
		<?php } else if ($updated) { ?>
			<div id="message" class="updated fade" style="color:green;"><?php echo __('Options Updated...','wp-splash-image'); ?></div>
		<?php } ?>
	
		<!-- ------ -->
		<!-- Forms  -->
		<!-- ------ -->
		
		<?php require("forms/MainForm.inc.php"); ?>
		<?php require("forms/FeedbackForm.inc.php"); ?>
		<?php require("forms/DocumentationForm.inc.php"); ?>
		<?php require("forms/UninstallForm.inc.php"); ?>
		<?php if ($uninstalled) { require("forms/UninstallConfirmForm.inc.php"); } ?>
		
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
			<?php if ($_POST['wsi_type'] != "") { ?>
				var wsi_type = '<?php echo $_POST['wsi_type']; ?>';
				<?php $wsi_type = $_POST['wsi_type']; ?>
			<?php } else if(get_option('wsi_type') != "") { ?>	
				var wsi_type = '<?php echo esc_attr(get_option('wsi_type')); ?>';
				<?php $wsi_type = esc_attr(get_option('wsi_type')); ?>
			<?php } else { ?>
				var wsi_type = 'picture';
				<?php $wsi_type = esc_attr(get_option('wsi_type')); ?>
			<?php } ?>
			
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
			$("#box_<?php echo $wsi_type; ?>").animate({ backgroundColor: "#7FFF00" }, 500);
			
			// Warning sur les dates de validités
			if ("<?php echo WsiCommons::getdate_is_in_validities_dates(); ?>"=="false") {$("#box_datepickers_warning").fadeIn("slow");}

			// Fill Picture size
			$("#fill_picture_size_button").click(function() {
				$("#img_splash_image").attr("src", $("#url_splash_image").val());
				$("#splash_image_height").val($("#img_splash_image").attr("height"));
				$("#splash_image_width").val($("#img_splash_image").attr("width"));
			});

			// Splash Color field management
			$("#splash_color_demo").css("background-color", "#"+$("#splash_color").val());
			$("#splash_color").keyup(function() {
				$("#splash_color_demo").css("background-color", "#"+$("#splash_color").val());
			});

			// Fields filters
			$('#splash_color').keyfilter(/[0-9a-f]/i);
			$('#splash_image_height').keyfilter(/[\d\.]/);
			$('#splash_image_width').keyfilter(/[\d\.]/);
			
		});
	</script>

<?php 
	}
} 
?>