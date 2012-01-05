<?php

/**
 * @author Benjamin Barbier
 *
 */
class WsiCommons {

	/**
	 * URL du plugin
	 */
	public static function getURL() {
		return WP_PLUGIN_URL.'/'.basename(dirname(__FILE__));
	}

	/**
	 * Retourne un tableau contenant la liste de toutes les options de WSI.
	 */
	public static function getOptionsList() {
		return array(
				'splash_active',
				'splash_test_active',
				'wsi_idle_time',
				'url_splash_image',
				'splash_image_width',
				'splash_image_height',
				'splash_color',
				'datepicker_start',
				'datepicker_end',
				'wsi_display_time',
				'wsi_fixed_splash',
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
	}
	
	/**
	 * Retourne une map avec en clef, les options de WSI et en valeur, les valeurs par défaut.
	 */
	public static function getDefaultValues() {
		return array(
				'splash_active'             => 'true',
				'splash_test_active'        => 'false',
				'wsi_idle_time'             => '30',
				'url_splash_image'          => '',
				'splash_image_width'        => '400',
				'splash_image_height'       => '400',
				'splash_color'              => '000000',
				'datepicker_start'          => '',
				'datepicker_end'            => '',
				'wsi_display_time'          => '5',
				'wsi_fixed_splash'          => 'true',
				'wsi_picture_link_url'      => '',
				'wsi_picture_link_target'   => '',
				'wsi_close_esc_function'    => 'false',
				'wsi_hide_cross'            => 'false',
				'wsi_disable_shadow_border' => 'false',
				'wsi_type'                  => 'picture',
				'wsi_opacity'               => '75',
				'wsi_youtube'               => '',
				'wsi_youtube_autoplay'      => 'true',
				'wsi_youtube_loop'          => 'false',
				'wsi_yahoo'                 => '',
				'wsi_dailymotion'           => '',
				'wsi_metacafe'              => '',
				'wsi_swf'                   => '',
				'wsi_html'                  => ''
		);
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
	
	/**
	 * Retourne true, si la période d'inactivité de l'utilisateur a été atteinte.
	 */
	public static function enough_idle_to_splash($lastSplash) {
		
		// Si la variable n'est pas settée, c'est que l'utilisateur vient pour la 1ere fois.
		if (!isset($lastSplash)) return true;
		
		$endIdle = $lastSplash + (get_option('wsi_idle_time') * 60);
		if (time() > $endIdle) {
			return true;
		} else {
			return false;
		}
		
	}
	
}

?>