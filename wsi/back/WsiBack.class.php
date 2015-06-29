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
		}
        return self::$_instance;
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
        load_plugin_textdomain('wp-splash-image', false, 'wsi/languages');
	
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
		wp_register_style('overlay-basic',   WsiCommons::getURL().'/style/jqueryTools/overlay-basic.css'); /*Style pour le splash screen de demo*/
		wp_register_style('wsi',             WsiCommons::getURL().'/style/wsi.css');

		wp_enqueue_style('overlay-basic');
		wp_enqueue_style('wsi');
	}

	/**
	 * Utilisation des scripts de la partie Admin
	 */
	public function enqueue_wsi_back_scripts() {
		if (isset($_GET['page']) && $_GET['page'] == 'wp_splash_image') {

			// JQuery Tools
			wp_register_script('jquery.tools.back', WsiCommons::getURL().'/js/jQueryTools/jquery.tools.min.wp-back.v'.JQUERY_TOOLS_FILES_VERSION.'.js'); /* overlay */
			wp_enqueue_script('jquery.tools.back', false, array('jquery'));

			// Keyfilter
			wp_register_script('jquery.keyfilter',  WsiCommons::getURL().'/js/jquery.keyfilter-1.7.min.js'); /* KeyFilter (for splash_color, splash_image_height, splash_image_width fields) */
			wp_enqueue_script('jquery.keyfilter',  false, array('jquery'));

            // Materialize
            wp_register_script('materialize-script', WsiCommons::getURL().'/style/materialize/js/materialize.js');
            wp_enqueue_script('materialize-script', false, array('jquery'));
            wp_register_style('materialize-style', WsiCommons::getURL().'/style/materialize/css/materialize.css');
            wp_enqueue_style('materialize-style');
            wp_register_style('materialize-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons');
            wp_enqueue_style('materialize-icons');

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

        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'update'    : require("actions/UpdateAction.inc.php");    $updated = true;     break;
                case 'reset'     : require("actions/ResetAction.inc.php");     $reseted = true;     break;
            }
        }

		// Pour le moment on ne charge que le 1er splash screen
		$configBean = ConfigManager::getInstance()->get();
		$siBean = SplashImageManager::getInstance()->get(1);

	?>

	<div class="wsi-back wrap">

		<!-- Logo Info -->
		<div id="display_info">
            <a href="https://wordpress.org/plugins/wsi/" target="_blank">
                <img id="info_img" class="tooltipped" data-position="bottom"
                     data-tooltip="<?php echo __('Infos','wp-splash-image'); ?>"
                     alt="<?php echo __('Infos','wp-splash-image'); ?>"
                     src="<?php echo WsiCommons::getURL(); ?>/style/info.png" />
            </a>
		</div>

		<!-- Logo Feedback -->
		<div id="display_feedback">
            <a target="_blank" href="https://gitter.im/ben-barbier/WP-Splash-Image">
                <img id="feedback_img" class="tooltipped" data-position="bottom"
                     data-tooltip="<?php echo __('Chat','wp-splash-image'); ?>"
                     alt="<?php echo __('Chat','wp-splash-image'); ?>"
                     src="<?php echo WsiCommons::getURL(); ?>/style/chat_logo.png" />
            </a>
		</div>

		<!-- Logo "Buy me a Beer" -->
		<div id="display_buyMeABeer">
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CKGNM6TBHU72C" target="_blank">
				<img id="buyMeABeer_img" class="tooltipped" data-position="bottom"
                     data-tooltip="<?php echo __('Buy me a Beer','wp-splash-image'); ?>"
                     alt="<?php echo __('Buy me a Beer','wp-splash-image'); ?>"
                     src="<?php echo WsiCommons::getURL(); ?>/style/beer.png" />
			</a>
		</div>

		<!-- Logo Reset -->
		<div id="display_reset" title="<?php echo __('Reset','wp-splash-image'); ?>">
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']?>" style="height:32px;">
				<?php wp_nonce_field('reset','nonce_reset_field'); ?>
				<input type="hidden" name="action" value="reset" />
				<!-- Fix old tooltip problem -->
				<input type="image" id="reset_img" class="tooltipped" data-position="bottom"
                       data-tooltip="<?php echo __('Reset original settings','wp-splash-image'); ?>"
                       src="<?php echo WsiCommons::getURL(); ?>/style/reset.png" />
			</form>
		</div>

		<!-- Logo GitHub -->
		<img id="github_img1" alt="github" src="<?php echo WsiCommons::getURL(); ?>/style/github/ForkMe_Blk.png" usemap="#github_map" />
		<img id="github_img2" alt="github" src="<?php echo WsiCommons::getURL(); ?>/style/github/ForkMe_Wht.png" usemap="#github_map" />
		<map name="github_map"><area shape="poly" id="github_area" coords="8,0,46,0,141,92,141,133" href="https://github.com/ben-barbier/WP-Splash-Image" target="_blank" /></map>

		<h2>WP Splash Image</h2>

		<!-- Information message -->
		<?php if ($updated) { WsiCommons::showMessage(__('Options Updated...','wp-splash-image')); } ?>
		<?php if (WsiCommons::has_a_new_version()) { WsiCommons::showMessage(
				__('A new version of "WP Splash Image" is out !','wp-splash-image').
				" (<a href='".WsiCommons::getUpdateURL()."'>".__('update automatically','wp-splash-image')."</a>)"
		); } ?>

		<!-- ------ -->
		<!-- Forms  -->
		<!-- ------ -->

		<?php require("forms/MainForm.inc.php"); ?>

	</div>

	<script type="text/javascript">

		jQuery(document).ready(function ($) {

			// Récupération du type de splash
			<?php if (isset($_POST['wsi_type'])) { ?>
				var wsi_type = '<?php echo $_POST['wsi_type']; ?>';
				<?php $wsi_type = $_POST['wsi_type']; ?>
			<?php } else if($siBean->getWsi_type() != "") { ?>
				var wsi_type = '<?php echo $siBean->getWsi_type(); ?>';
				<?php $wsi_type = $siBean->getWsi_type(); ?>
			<?php } else { ?>
				var wsi_type = 'picture';
				<?php $wsi_type = $siBean->getWsi_type(); ?>
			<?php } ?>

			// Gestion de l'affichage de la zone "block_splash_test_active"
			if($("#splash_active").attr("checked")=="checked") {
                $("#block_splash_test_active").css("display","table-row");
            } else {
                $("#block_splash_test_active").css("display","none");
            }
			$("#splash_active").click(function() {
				if($("#splash_active").attr("checked")=="checked") {$("#block_splash_test_active").fadeIn("slow");}
				else{$("#block_splash_test_active").fadeOut("slow");}
			});

			// Gestion de l'affichage des zones block_idle_time en fonction de "wsi_display_always"
			if($("#wsi_display_always").attr("checked")=="checked") {
				$("#block_idle_time").css("display","none");
			}else{
				$("#block_idle_time").css("display","block");
			}
			$("#wsi_display_always").click(function() {
				if($("#wsi_display_always").attr("checked")=="checked") {
					$("#block_idle_time").fadeOut("slow");
				}else{
					$("#block_idle_time").fadeIn("slow");
				}
			});

			// GitHub banner effect.
			$('#github_area').mouseover(function() {
				  $('#github_img2').fadeIn("400");
			});
			$('#github_area').mouseout(function() {
				  $('#github_img2').fadeOut("400");
			});

			// Color on select input radio
			function color_box(boxId) {
				$(".box_type").velocity({ backgroundColor: "#FFFFFF" }, 200);
				$(boxId).velocity({       backgroundColor: "#D9FFB2" }, 500);
			}

			$("#radio_picture").click(function() {     color_box("#box_picture")});
			$("#radio_youtube").click(function() {     color_box("#box_youtube")});
			$("#radio_yahoo").click(function() {       color_box("#box_yahoo")});
			$("#radio_dailymotion").click(function() { color_box("#box_dailymotion")});
			$("#radio_metacafe").click(function() {    color_box("#box_metacafe")});
			$("#radio_swf").click(function() {         color_box("#box_swf")});
			$("#radio_html").click(function() {        color_box("#box_html")});
			$("#radio_include").click(function() {     color_box("#box_include")});

			// Color on plugin init
			$("#box_<?php echo $wsi_type; ?>").velocity({ backgroundColor: "#D9FFB2" }, 500);

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
				}, function(files) {
                    $('#live_preview_div').html(files);
                });
			});

            // Materializecss
            $('.tooltipped').tooltip({delay: 10});


            var pickadateConfig = {
                format:'yyyy-mm-dd',
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5, // Creates a dropdown of 5 years to control year
                onClose: function () { // Warning sur les dates de validités

                    var startDate = datepickerStart.pickadate('picker').get('select', 'yyyymmdd');
                    var endDate = datepickerEnd.pickadate('picker').get('select', 'yyyymmdd');
                    var currentDate = getCurrentDate();

                    if (needToDisplayDateAlertMessage(startDate, endDate, currentDate)) {
                        $("#box_datepickers_warning").velocity("fadeIn", { display: "inline" });
                    } else {
                        $("#box_datepickers_warning").velocity("fadeOut");
                    }

                }
            };
            var datepickerStart = $('#datepicker_start').pickadate(pickadateConfig);
            var datepickerEnd = $('#datepicker_end').pickadate(pickadateConfig);

            function getCurrentDate() {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1; //January is 0!

                var yyyy = today.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd
                }
                if (mm < 10) {
                    mm = '0' + mm
                }
                return '' + yyyy + mm + dd;
            }

            function needToDisplayDateAlertMessage (startDate, endDate, currentDate) {
                if (startDate && startDate > currentDate) {
                    return true;
                }
                if (endDate && endDate < currentDate) {
                    return true;
                }
                return false;
            }

            $('select').material_select();
			$('.modal-trigger').leanModal();

		});
	</script>

<?php
	}
}
?>
