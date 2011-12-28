<?php

class WsiCommons {

	/**
	 * URL du plugin
	 */
	public static function getURL() {
		return WP_PLUGIN_URL.'/'.basename(dirname(__FILE__));
	}

	/**
	 * Si la Splash Image n'est pas dans sa plage de validité, on retourne false (sinon true)
	 */
	public static function getdate_is_in_validities_dates() {
	
		$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	
		// En cas de modication des paramètres dans la partie admin
		if ($_POST ['action'] == 'update') {
			if ($_POST['datepicker_start']!='') {
				$dpStart = strtotime($_POST['datepicker_start']);
				if ($today < $dpStart) {
					return "false";
				}
			}
			if ($_POST['datepicker_end']!='') {
				$dpEnd = strtotime($_POST['datepicker_end']);
				if ($today > $dpEnd) {
					return "false";
				}
			}
		// Sinon (front office)
		} else {
			if (get_option('datepicker_start')!='') {
				$dpStart = strtotime(get_option('datepicker_start'));
				if ($today < $dpStart) {
					return "false";
				}
			}
			if (get_option('datepicker_end')!='') {
				$dpEnd = strtotime(get_option('datepicker_end'));
				if ($today > $dpEnd) {
					return "false";
				}
			}
		}
		return "true";
	}
	
}

?>