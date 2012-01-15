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
	/**
	 * @return WsiBack
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new WsiBack();
		} return self::$_instance;
	}
	
	/**
	 * Plug : Hooks functions to actions and filters.
	 * This is the only function to use to set up the back.
	 */
	public function plug() {
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
	 * Utilisation des styles de la partie Admin
	 */
	public function enqueue_wsi_back_styles() {
		// Déclaration des styles de la partie Admin
		wp_register_style('tabs',            WsiCommons::getURL().'/style/ui/flick/jquery-ui-1.8.16.custom.css'); /*Style pour les onglets*/
		wp_register_style('validator-error', WsiCommons::getURL().'/style/validator-error.css'); /*Style pour le validator du feedback*/
		wp_register_style('overlay-basic',   WsiCommons::getURL().'/style/overlay-basic.css'); /*Style pour la box de documentation + feedback*/
		wp_register_style('date-input',      WsiCommons::getURL().'/style/dateinput.css'); /*Style pour les calendriers*/
		wp_register_style('range',           WsiCommons::getURL().'/style/range.css'); /*Style pour le curseur de temps*/
		wp_register_style('wsi',             WsiCommons::getURL().'/style/wsi.css');
		
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
			wp_register_script('jquery.tools.back', WsiCommons::getURL().'/js/jquery.tools.min.wp-back.js'); /*[overlay, overlay.apple, dateinput, rangeinput, validator]*/
			wp_register_script('jquery.tooltip',    WsiCommons::getURL().'/js/tooltip.jquery.js'); /*Infobulle(tooltip) pour feedback*/
			wp_register_script('jquery.keyfilter',  WsiCommons::getURL().'/js/jquery.keyfilter-1.7.min.js'); /* KeyFilter (for splash_color, splash_image_height, splash_image_width fields) */
			
			// JQuery (wordpress version)
			wp_enqueue_script('jquery');
			
			// JQuery UI (wordpress version)
			wp_enqueue_script('jquery-ui-tabs');
			
			// JQuery Tools
			wp_enqueue_script('jquery.tools.back', false, array('jquery'));
			
			// JQuery Plugins
			wp_enqueue_script('jquery.tooltip',    false, array('jquery'));
			wp_enqueue_script('jquery.keyfilter',  false, array('jquery'));

		}
	}
	
	/**
	 * Retourne un maximum d'infos pour aider à la 
	 * correction du problème rencontré par l'utilisateur (format HTML).
	 */
	private function get_system_info() {
		
		$systemInfos = "<pre style='background-color: #FFFF99;padding: 10px;width: 98%;border: 1px black dashed;'>";
		$systemInfos.= "-----------------------\n";
		$systemInfos.= "-- WSI - System Info --\n";
		$systemInfos.= "-----------------------\n\n";
		$systemInfos.= get_bloginfo('name')." -> ".get_bloginfo('url')."\n";
		$systemInfos.= get_bloginfo('description')."\n\n";
		$systemInfos.= "-- Wordpress Info --\n";
		$systemInfos.= "Version: ".get_bloginfo('version')."\n\n";
		
		$systemInfos.= "-- Plugins actifs --\n";
		foreach (get_plugins() as $plugin_file => $plugin_data) {
			if (is_plugin_active($plugin_file)) {
				$systemInfos.= $plugin_data['Name'];
				$systemInfos.= " (".$plugin_data['Version'].")";
				$systemInfos.= " - ".$plugin_data['PluginURI'];
				$systemInfos.= "\n";
			}
		}
		$systemInfos.= "\n";
		$systemInfos.= "-- Plugins inactifs --\n";
		foreach (get_plugins() as $plugin_file => $plugin_data) {
			if (is_plugin_inactive($plugin_file)) {
				$systemInfos.= $plugin_data['Name'];
				$systemInfos.= " (".$plugin_data['Version'].")";
				$systemInfos.= " - ".$plugin_data['PluginURI'];
				$systemInfos.= "\n";
			}
		}
		$systemInfos.= "\n";
		$systemInfos.= "-- Paramétrage WSI --\n";
		$systemInfos.= SplashImageManager::getInstance()->getInfos();
			
		$systemInfos.= "</pre>";
		return $systemInfos; 
	}
	
	/**
	 * Fonction utilisée dans la partie Admin 
	 */
	public function wp_splash_image_options() {
		
		// L'utilisateur a-t-il les droits suffisants pour afficher la page
		if (!current_user_can('manage_options'))  {
			wp_die( __("You do not have sufficient permissions to access this page.",'wp-splash-image') );
		}
		
		$updated = false;
		$reseted = false;
		$feedbacked = false;
		$uninstalled = false;

		switch ($_POST ['action']) {
			case 'update'    : require("actions/UpdateAction.inc.php");    $updated = true;     break;
			case 'reset'     : require("actions/ResetAction.inc.php");     $reseted = true;     break;
			case 'feedback'  : require("actions/FeedbackAction.inc.php");  $feedbacked = true;  break;
			case 'uninstall' : require("actions/UninstallAction.inc.php"); $uninstalled = true; break;
		}
		
		$siBean = SplashImageManager::getInstance()->get();
		
	?>
	
	<div class="wrap">
		
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

		<!-- Logo Reset -->
		<div id="display_reset">
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>">
				<?php wp_nonce_field('reset','nonce_reset_field'); ?>
				<input type="hidden" name="action" value="reset" />
				<input type="image" id="reset_img" rel="#reset" alt="<?php echo __('Reset','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/reset.png" />
			</form>
			<!-- Tooltip FeedBack -->
			<div id="data_reset_img" style="display:none;"> 
				<?php echo __('Reset','wp-splash-image'); ?>
			</div>
		</div>
		
		<!-- Logo GitHub -->
		<a href="https://github.com/Agent-22/WP-Splash-Image" target="_blank">
			<img id="github_img1" rel="#github" alt="github" src="<?php echo WsiCommons::getURL(); ?>/style/github/ForkMe_Blk.png" />
			<img id="github_img2" rel="#github" alt="github" src="<?php echo WsiCommons::getURL(); ?>/style/github/ForkMe_Wht.png" />
		</a>
		
		
		
		<h2>WP Splash Image</h2>
		
		<!-- Information message -->
		<?php if ($feedbacked) { WsiCommons::showMessage(__("Thank's for your feedback...",'wp-splash-image')); } ?>
		<?php if ($updated) { WsiCommons::showMessage(__('Options Updated...','wp-splash-image')); } ?>
		<?php if (WsiCommons::has_a_new_version()) { WsiCommons::showMessage(
				__('A new version of "WP Splash Image" is out !','wp-splash-image').
				" (<a href='".WsiCommons::getUpdateURL()."'>".__('update automatically','wp-splash-image')."</a>)"
		); } ?>
	
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
	
		jQuery(document).ready(function ($) {
			
			// Chargement des calendriers
			$(":date").dateinput({
				format: 'dd mmm yyyy'
			});
					
			// Récupération du type de splash
			<?php if ($_POST['wsi_type'] != "") { ?>
				var wsi_type = '<?php echo $_POST['wsi_type']; ?>';
				<?php $wsi_type = $_POST['wsi_type']; ?>
			<?php } else if($siBean->getWsi_type() != "") { ?>	
				var wsi_type = '<?php echo $siBean->getWsi_type(); ?>';
				<?php $wsi_type = $siBean->getWsi_type(); ?>
			<?php } else { ?>
				var wsi_type = 'picture';
				<?php $wsi_type = $siBean->getWsi_type(); ?>
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
			if($("#splash_active").attr("checked")=="checked") {$("#block_splash_test_active").css("display","table-row");}
			else{$("#block_splash_test_active").css("display","none");}
			$("#splash_active").click(function() {
				if($("#splash_active").attr("checked")=="checked") {$("#block_splash_test_active").fadeIn("slow");}
				else{$("#block_splash_test_active").fadeOut("slow");}
			});

			// Gestion de l'affichage des zones "block_start_date", "block_end_date" et "block_idle_time"
			// En fonction de "splash_test_active"
			if($("#splash_test_active").attr("checked")=="checked") {
				$("#block_start_date").css("display","none");
				$("#block_end_date").css("display","none");
				$("#block_idle_time").css("display","none");
			}else{
				$("#block_start_date").css("display","table-row");
				$("#block_end_date").css("display","table-row");
				$("#block_idle_time").css("display","table-row");
			}
			$("#splash_test_active").click(function() {
				if($("#splash_test_active").attr("checked")=="checked") {
					$("#block_start_date").fadeOut("slow");
					$("#block_end_date").fadeOut("slow");
					$("#block_idle_time").fadeOut("slow");
				}else{
					$("#block_start_date").fadeIn("slow");
					$("#block_end_date").fadeIn("slow");
					$("#block_idle_time").fadeIn("slow");
				}
			});
			
			// Activation du tooltip du feedback
			$('#feedback_img').tooltip();
			
			// Activation du tooltip de "Info"
			$('#info_img').tooltip();
			
			// Activation du tooltip de "Uninstall"
			$('#uninstall_img').tooltip();

			// GitHub effect.
			$('#github_img1').mouseover(function() {
				  $('#github_img2').fadeIn("400");
			});
			$('#github_img2').mouseout(function() {
				  $('#github_img2').fadeOut("400");
			});
			
			// Activation du tooltip de "Reset"
			$('#reset_img').tooltip();
			
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
				$("#splash_image_height").val($("#img_splash_image").height());
				$("#splash_image_width").val($("#img_splash_image").width());
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

			// new tabs
			$(function() {$("#tabs").tabs();});
			
		});
	</script>

<?php 
	}
} 
?>