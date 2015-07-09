<?php

/**
 * @author Benjamin Barbier
 *
 */
class WsiCommons {

	public static $pluginMainFile = "wsi/wp-splash-image.php";

	/**
	 * URL du plugin
	 */
	public static function getURL() {
		return WP_PLUGIN_URL.'/'.basename(dirname(__FILE__));
	}

	/**
	 * Retourne un tableau contenant la liste de toutes les options propre au WSI.
	 */
	public static function getWsiOptionsList() {
		return array(
				'wsi_db_version');
	}

	/**
	 * Retourne un tableau contenant la liste de toutes les tables propre au WSI.
	 */
	public static function getWsiTablesList() {
		return array(
				ConfigManager::tableName(),
				SplashImageManager::tableName());
	}

	/**
	 * Si la Splash Image n'est pas dans sa plage de validité, on retourne false (sinon true)
	 */
	public static function getdate_is_in_validities_dates() {

		$siBean = SplashImageManager::getInstance()->get(1);

		$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

		// En cas de modication des paramètres dans la partie admin
		if (isset($_POST ['action']) && $_POST ['action'] == 'update') {
			if (isset($_POST['datepicker_start'])) {
				$dpStart = strtotime($_POST['datepicker_start']);
				if ($today < $dpStart) {
					return "false";
				}
			}
			if (isset($_POST['datepicker_end'])) {
				$dpEnd = strtotime($_POST['datepicker_end']);
				if ($today > $dpEnd) {
					return "false";
				}
			}
		// Sinon (front office)
        } else {
            if ($siBean->getDatepicker_start() != '') {
                $dpStart = strtotime($siBean->getDatepicker_start());
                if ($today < $dpStart) {
                    return "false";
                }
            }
            if ($siBean->getDatepicker_end() != '') {
                $dpEnd = strtotime($siBean->getDatepicker_end());
                if ($today > $dpEnd) {
                    return "false";
                }
            }
        }
		return "true";
	}

	/**
	 * Retourne true, si la période d'inactivité de l'utilisateur a été atteinte.
	 */
	public static function enough_idle_to_splash($lastSplash) {

		$siBean = SplashImageManager::getInstance()->get(1);

		// Si la variable n'est pas settée, c'est que l'utilisateur vient pour la 1ere fois.
		if (!isset($lastSplash)) return true;

		$endIdle = $lastSplash + ($siBean->getWsi_idle_time() * 60);
		if (time() > $endIdle) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * @return boolean, true if a new version of WSI exists
	 */
	public static function has_a_new_version() {

		$compare = version_compare(
				self::getCurrentPluginVersion(),
				self::getLastestPluginVersion());

		if ($compare == -1) {
			// Use old version
			return true;
		} else if ($compare == 0) {
			// Use last Version
			return false;
		} else if ($compare == 1) {
			// Use beta version
			return false;
		}
		return false;

	}

	/**
	 * Generic function to show a message to the user using WP's
	 * standard CSS classes to make use of the already-defined
	 * message colour scheme.
	 *
	 * @param $message The message you want to tell the user.
	 * @param $errormsg If true, the message is an error, so use
	 * the red message style. If false, the message is a status
	 * message, so use the yellow information message style.
	 */
	public static function showMessage($message, $errormsg = false) {
		if ($errormsg) {
			echo '<div id="message" class="error">';
		}
		else {
			echo '<div id="message" class="updated fade">';
		}
		echo "<p><strong>$message</strong></p></div>";
	}

	/**
	 * @return string the URL used to update the wp-splash-image plugin.
	 */
	public static function getUpdateURL() {

		$update_url = self_admin_url('update.php?action=upgrade-plugin&plugin=' . self::$pluginMainFile);
		if(function_exists('wp_nonce_url')) {
			$update_url = wp_nonce_url($update_url, 'upgrade-plugin_' . self::$pluginMainFile);
		}
		return $update_url;

	}

	/**
	 * @return string the URL used to deactivate the wp-splash-image plugin.
	 */
	public static function getDeactivateURL() {

		$deactivate_url = self_admin_url('plugins.php?action=deactivate&plugin=' . self::$pluginMainFile);
		if(function_exists('wp_nonce_url')) {
			$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_' . self::$pluginMainFile);
		}
		return $deactivate_url;

	}

	/**
	 * Returns current plugin version.
	 * The information come from the wp-splash-image.php header comment.
	 *
	 * @return string current Plugin version
	 */
    static function getCurrentPluginVersion() {

		$plugin_data = get_plugin_data( WP_PLUGIN_DIR."/wsi/wp-splash-image.php" );
		$plugin_version = $plugin_data['Version'];
		return $plugin_version;

	}

	/**
	 * Returns lastest plugin version.
	 *
	 * @return string lastest Plugin version
	 */
	static function getLastestPluginVersion() {

        if ( ! function_exists( 'plugins_api' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
        }

        $args = array(
            'slug' => 'wsi',
            'fields' => array(
                'version' => true,
                // do not load big and unused properties
                'compatibility' => false,
                'sections' => false,
                'tags' => false
            )
        );

        try {
            $call_api = plugins_api( 'plugin_information', $args );

            /** Check for Errors & Display the results */
            if ( !is_wp_error( $call_api ) ) {
                return $call_api->version;
            } else {
                return 0;
            }

        } catch (Exception $e) {
            return 0;
        }

	}

	/**
	 * @return string the name and the version of the current theme.
	 */
	public static function getCurrentTheme() {

		if (function_exists('wp_get_theme')) { //Since WP 3.4
			$currentTheme = wp_get_theme();
			return $currentTheme->get( 'Name' ) . " v" . $currentTheme->get( 'Version' );
		} else {
			$currentTheme = current_theme_info();
			return $currentTheme->name." v".$currentTheme->version;
		}

	}

}

?>
