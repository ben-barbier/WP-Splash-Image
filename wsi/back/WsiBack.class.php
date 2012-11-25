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
		
		add_action ( 'admin_init',                                       array(&$this, 'wp_splash_image_back_init' ));
		add_action ( 'admin_menu',                                       array(&$this, 'wsi_menu' ));
		add_action ( 'plugins_loaded',                                   array(&$this, 'update_db_check' )); // OK since WP 3.1
		add_filter ( 'plugin_action_links_'.WsiCommons::$pluginMainFile, array(&$this, 'wsi_filter_plugin_actions' ));
		add_filter ( 'plugin_row_meta',                                  array(&$this, 'set_plugin_meta'), 10, 2 );

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
		$links[] = '<a href="options-general.php?page=wp_splash_image">'.__('Settings','wp-splash-image').'</a>';
		return $links;
	}
	
	/**
	 * Ajoute entrée dans la page des extensions (partie droite)
	 */
	public function set_plugin_meta($links, $file) {
		
		if ( $file == WsiCommons::$pluginMainFile ) {
			$links[] = '<a target="_blank" href="http://wordpress.org/tags/wsi?forum_id=10">' . __('Get help', 'wp-splash-image') . '</a>';
			$links[] = '<a target="_blank" href="https://github.com/Agent-22/WP-Splash-Image">' . __('Fork me on Github', 'wp-splash-image') . '</a>';
			$links[] = '<a target="_blank" style="font-weight:bold;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C">'.__('Donate','wp-splash-image').'</a>';
		}
		return $links;
		
	}
	
	/**
	 * Update the database if the current version is not the last.
	 */
	function update_db_check() {
		if (MainManager::getInstance()->get_current_wsi_db_version() != WSI_DB_VERSION) {
			MainManager::getInstance()->wsi_install_db();
		}
	}
	
	/**
	 * Utilisation des styles de la partie Admin
	 */
	public function enqueue_wsi_back_styles() {
		// Déclaration des styles de la partie Admin
		wp_register_style('tabs',            WsiCommons::getURL().'/style/ui/flick/jquery-ui-1.8.16.custom.css'); /*Style pour les onglets*/
		wp_register_style('validator-error', WsiCommons::getURL().'/style/jqueryTools/validator-error.css'); /*Style pour le validator du feedback*/
		wp_register_style('overlay-basic',   WsiCommons::getURL().'/style/jqueryTools/overlay-basic.css'); /*Style pour la box de documentation + feedback*/
		wp_register_style('date-input',      WsiCommons::getURL().'/style/jqueryTools/dateinput.css'); /*Style pour les calendriers*/
		wp_register_style('range',           WsiCommons::getURL().'/style/jqueryTools/range.css'); /*Style pour le curseur de temps*/
		wp_register_style('tooltip',         WsiCommons::getURL().'/style/jqueryTools/tooltip.css'); /*Style pour le curseur de temps*/
		wp_register_style('wsi',             WsiCommons::getURL().'/style/wsi.css');
		
		wp_enqueue_style('tabs');
		wp_enqueue_style('validator-error');
		wp_enqueue_style('overlay-basic');
		wp_enqueue_style('date-input');
		wp_enqueue_style('range');
		wp_enqueue_style('tooltip');
		wp_enqueue_style('wsi');
	}
	
	/**
	 * Utilisation des scripts de la partie Admin
	 */
	public function enqueue_wsi_back_scripts() {
		if (isset($_GET['page']) && $_GET['page'] == 'wp_splash_image') {
			
			// JQuery UI Tabs (Wordpress version) -> include JQuery + JQuery UI Core + JQuery UI Widget 
			wp_enqueue_script('jquery-ui-tabs');
			
			// JQuery Tools
			wp_register_script('jquery.tools.back', WsiCommons::getURL().'/js/jQueryTools/jquery.tools.min.wp-back.v'.JQUERY_TOOLS_FILES_VERSION.'.js'); /*[overlay, overlay.apple, dateinput, rangeinput, validator, tooltip, tooltip.dynamic, tooltip.slide, toolbox.expose]*/
			wp_enqueue_script('jquery.tools.back', false, array('jquery'));
			
			// Keyfilter
			wp_register_script('jquery.keyfilter',  WsiCommons::getURL().'/js/jquery.keyfilter-1.7.min.js'); /* KeyFilter (for splash_color, splash_image_height, splash_image_width fields) */
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
		$systemInfos.= MainManager::getInstance()->getInfos();
			
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

		switch ($_POST ['action']) {
			case 'update'    : require("actions/UpdateAction.inc.php");    $updated = true;     break;
			case 'reset'     : require("actions/ResetAction.inc.php");     $reseted = true;     break;
			case 'feedback'  : require("actions/FeedbackAction.inc.php");  $feedbacked = true;  break;
		}
		
		// Pour le moment on ne charge que le 1er splash screen
		$configBean = ConfigManager::getInstance()->get();
		$siBean = SplashImageManager::getInstance()->get(1);
		
	?>
	
	<div class="wrap">
		
		<!-- Logo Info -->
		<div id="display_info">
			<img id="info_img" rel="#info" title="<?php echo __('Infos','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/info.png" />
		</div>
		
		<!-- Logo Feedback -->
		<div id="display_feedback">
			<img id="feedback_img" rel="#feedback" title="<?php echo __('Feedback','wp-splash-image'); ?>" alt="<?php echo __('Feedback','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/feedback_logo.png" />
		</div>
		
		<!-- Logo "Buy me a Beer" -->
		<div id="display_buyMeABeer">
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C" target="_blank">
				<img id="buyMeABeer_img" title="<?php echo __('Buy me a Beer','wp-splash-image'); ?>" alt="<?php echo __('Buy me a Beer','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/beer.png" />
			</a>
		</div>
		
		<!-- Logo Reset -->
		<div id="display_reset" title="<?php echo __('Reset','wp-splash-image'); ?>">
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>" style="height:32px;">
				<?php wp_nonce_field('reset','nonce_reset_field'); ?>
				<input type="hidden" name="action" value="reset" />
				<!-- Fix tooltip problem -->
				<input type="image" id="reset_img" alt="<?php echo __('Reset','wp-splash-image'); ?>" src="<?php echo WsiCommons::getURL(); ?>/style/reset.png" />
			</form>
		</div>
		
		<!-- Logo GitHub -->
		<img id="github_img1" alt="github" src="<?php echo WsiCommons::getURL(); ?>/style/github/ForkMe_Blk.png" usemap="#github_map" />
		<img id="github_img2" alt="github" src="<?php echo WsiCommons::getURL(); ?>/style/github/ForkMe_Wht.png" usemap="#github_map" />
		<map name="github_map"><area shape="poly" id="github_area" coords="8,0,46,0,141,92,141,133" href="https://github.com/Agent-22/WP-Splash-Image" target="_blank" /></map>
		
		
		
		
		
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
		
	</div>
	
	<script type="text/javascript">
	
		jQuery(document).ready(function ($) {
			
			// Chargement des calendriers
			$jwsitools("#datepicker_start").dateinput({
				format: 'yyyy-mm-dd',
				change: function() {
					var isoDate = this.getValue('yyyy-mm-dd');
					$("#datepicker_start").val(isoDate);
				}
			});
			$jwsitools("#datepicker_end").dateinput({
				format: 'yyyy-mm-dd',
				change: function() {
					var isoDate = this.getValue('yyyy-mm-dd');
					$("#datepicker_end").val(isoDate);
				}
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
			index_tab["include"]     = 3;

			// new tabs
			$(function() {$("#tabs").tabs({
				// Ouverture du bon onglet au démarrage
				selected: index_tab[wsi_type]
			});});
			
			// Gestion de l'affichage de la zone "block_splash_test_active"
			if($("#splash_active").attr("checked")=="checked") {$("#block_splash_test_active").css("display","table-row");}
			else{$("#block_splash_test_active").css("display","none");}
			$("#splash_active").click(function() {
				if($("#splash_active").attr("checked")=="checked") {$("#block_splash_test_active").fadeIn("slow");}
				else{$("#block_splash_test_active").fadeOut("slow");}
			});
			
			// Gestion de l'affichage des zones block_idle_time en fonction de "wsi_display_always"
			if($("#wsi_display_always").attr("checked")=="checked") {
				$("#block_idle_time").css("display","none");
			}else{
				$("#block_idle_time").css("display","table-row");
			}
			$("#wsi_display_always").click(function() {
				if($("#wsi_display_always").attr("checked")=="checked") {
					$("#block_idle_time").fadeOut("slow");
				}else{
					$("#block_idle_time").fadeIn("slow");
				}
			});
			
			// Activation du tooltip du feedback
			$jwsitools('#feedback_img').tooltip({effect: 'slide', offset: [10, 2]}).dynamic({ bottom: { direction: 'down', bounce: true } });
			
			// Activation du tooltip de "Info"
			$jwsitools('#info_img').tooltip({effect: 'slide', offset: [10, 2]}).dynamic({ bottom: { direction: 'down', bounce: true } });
			
			// Activation du tooltip de "Buy me a Beer"
			$jwsitools('#buyMeABeer_img').tooltip({effect: 'slide', offset: [10, 2], tipClass: 'tooltip bottom buyMeABeer'}).dynamic({ bottom: { direction: 'down', bounce: true } });
			
			// Activation du tooltip de "Reset"
			$jwsitools('#display_reset').tooltip({effect: 'slide', offset: [10, 2]}).dynamic({ bottom: { direction: 'down', bounce: true } });

			// Activation du tooltip du "first load mode" (doc)
			$jwsitools('#wsi_first_load_mode_info').tooltip({ position: "center right", effect: 'slide', offset: [0, 15]}).dynamic({ bottom: { direction: 'down', bounce: true } });

			// Activation du tooltip de l'URL Youtube (doc)
			$jwsitools('#wsi_youtube_info').tooltip({ position: "center right", effect: 'slide', offset: [-150, 15]}).dynamic({ bottom: { direction: 'down', bounce: true } });
			
			// GitHub effect.
			$('#github_area').mouseover(function() {
				  $('#github_img2').fadeIn("400");
			});
			$('#github_area').mouseout(function() {
				  $('#github_img2').fadeOut("400");
			});
			
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
			$jwsitools("#info_img[rel]").overlay({mask: '#000', effect: 'apple'});
			
			// Activation de l'overlay du feedback
			$jwsitools("#feedback_img[rel]").overlay({
				mask: '#000', 
				effect: 'apple',
				// Si on ferme l'overlay, on supprime les messages d'erreur du validator
				onClose: function() {reset_validator();}
			})
			
			// Activation du curseur pour la durée d'affichage
			$jwsitools("input[name=wsi_opacity]").rangeinput();
			
			// Color on select input radio
			function color_box(boxId) {
				$(".box_type").animate({ backgroundColor: "#FFFFFF" }, 200);
				$(boxId).animate({       backgroundColor: "#D9FFB2" }, 500);
			}
			
			$("#radio_picture").click(function() {     color_box("#box_picture")});
			$("#radio_youtube").click(function() {     color_box("#box_youtube")});
			$("#radio_yahoo").click(function() {       color_box("#box_yahoo")});
			$("#radio_dailymotion").click(function() { color_box("#box_dailymotion")});
			$("#radio_metacafe").click(function() {    color_box("#box_metacafe")});
			$("#radio_swf").click(function() {         color_box("#box_swf")});
			$("#radio_html").click(function() {        color_box("#box_html")});
			$("#radio_include").click(function() {     color_box("#box_include")});
			
			// Color au chargement du plugin
			$("#box_<?php echo $wsi_type; ?>").animate({ backgroundColor: "#D9FFB2" }, 500);
			
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

			// Live Preview
			$('#live_preview_button').click(function() {
				$.post('<?php echo WsiCommons::getURL() ?>/wsi/back/splash/demo.php', { 
					url_splash_image:            $("#url_splash_image").val(),
					splash_image_width:          $("#splash_image_width").val(),
					splash_image_height:         $("#splash_image_height").val(),
					wsi_margin_top:              $("#wsi_margin_top").val(),
					splash_color:                $('#splash_color').val(),
					wsi_display_time:            $("[name='wsi_display_time']").val(),
					wsi_fixed_splash:            $("#wsi_fixed_splash:checked").is(":checked"),
					wsi_picture_link_url:        $("#wsi_picture_link_url").val(),
					wsi_picture_link_target:     $("#wsi_picture_link_target").val(),
					wsi_include_url:             $("#wsi_include_url").val(),
					wsi_close_on_esc_function:   $("#wsi_close_on_esc_function:checked").is(":checked"),
					wsi_close_on_click_function: $("#wsi_close_on_click_function:checked").is(":checked"),
					wsi_hide_cross:              $("#wsi_hide_cross:checked").is(":checked"),
					wsi_disable_shadow_border:   $("#wsi_disable_shadow_border:checked").is(":checked"),
					wsi_type:                    $("[name='wsi_type']:checked").val(),
					wsi_opacity:                 $("[name='wsi_opacity']").val(),
					wsi_youtube:                 $("#wsi_youtube").val(),
					wsi_youtube_autoplay:        $("#wsi_youtube_autoplay:checked").is(":checked"),
					wsi_youtube_loop:            $("#wsi_youtube_loop:checked").is(":checked"),
					wsi_yahoo:                   $("#wsi_yahoo").val(),
					wsi_dailymotion:             $("#wsi_dailymotion").val(),
					wsi_metacafe:                $("#wsi_metacafe").val(),
					wsi_swf:                     $("#wsi_swf").val(),
					wsi_html:                    $("#wsi_html").val()
				}, function(files) { $('#live_preview_div').html(files); });
			});

		});
	</script>

<?php 
	}
} 
?>