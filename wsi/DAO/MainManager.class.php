<?php

/**
 * @author Benjamin Barbier
 *
 */
class MainManager {
	
	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {
	}
	/**
	 * @return MainManager instance
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new MainManager();
		} return self::$_instance;
	}
	
	/**
	 * @return string
	 */
	public function getInfos() {
		$wsiInfos;
		$wsiInfos.=ConfigManager::getInstance()->getInfos();
		$wsiInfos.=SplashImageManager::getInstance()->getInfos();
		return $wsiInfos;
	}
	
	/**
	 * Remise de toutes les options aux valeurs par défaut
	 */
	public function reset() {
		ConfigManager::getInstance()->reset();
		SplashImageManager::getInstance()->reset();
	}
	
	/**
	 * Return the option value of 'wsi_db_version'.
	 * If the value is not set, return '1.0'.
	 */
	public function get_current_wsi_db_version() {
		$wsi_db_version = get_site_option('wsi_db_version');
		if ($wsi_db_version=="") $wsi_db_version = "1.0";
		return $wsi_db_version;
	}
	
	/**
	 * Install the database of WSI
	 */
	public function wsi_install_db() {
	
		global $wpdb;
		global $wsi_db_version;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
		switch ($this->get_current_wsi_db_version()) {
	
			case "1.0": //write here, what is nececery to go to the next version (2.0)
	
				$table_name_splashimage = SplashImageManager::tableName();
				$sql_splashimage = "CREATE TABLE " . $table_name_splashimage . " (
					id                        MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
					wsi_display_always        BOOLEAN,
					wsi_idle_time             INT,
					url_splash_image          VARCHAR(255),
					splash_image_width        INT,
					splash_image_height       INT,
					splash_color              VARCHAR(6),
					datepicker_start          DATETIME,
					datepicker_end            DATETIME,
					wsi_display_time          INT,
					wsi_fixed_splash          BOOLEAN,
					wsi_picture_link_url      VARCHAR(255),
					wsi_picture_link_target   VARCHAR(255),
					wsi_include_url           VARCHAR(255),
					wsi_close_esc_function    BOOLEAN,
					wsi_hide_cross            BOOLEAN,
					wsi_disable_shadow_border BOOLEAN,
					wsi_type                  VARCHAR(20),
					wsi_opacity               INT,
					wsi_youtube               VARCHAR(255),
					wsi_youtube_autoplay      BOOLEAN,
					wsi_youtube_loop          BOOLEAN,
					wsi_yahoo                 VARCHAR(255),
					wsi_dailymotion           VARCHAR(255),
					wsi_metacafe              VARCHAR(255),
					wsi_swf                   VARCHAR(255),
					wsi_html                  VARCHAR(255),
					PRIMARY KEY id (id)
				);";
	
				$table_name_config = ConfigManager::tableName();
				$sql_config = "CREATE TABLE " . $table_name_config . " (
					param VARCHAR(255),
					value VARCHAR(255),
					PRIMARY KEY id (param)
				);";
	
				dbDelta($sql_config);
				dbDelta($sql_splashimage);
	
				$wpdb->insert( $table_name_config, array(
						'param' => 'splash_active',
						'value' => (get_option('splash_active')=='true')              //boolean
				));
				$wpdb->insert( $table_name_config, array(
						'param' => 'wsi_first_load_mode_active',
						'value' => (get_option('wsi_first_load_mode_active')=='true') //boolean
				));

				
				$wpdb->insert( $table_name_splashimage, array(
	
						'url_splash_image' =>          get_option('url_splash_image'),
						'splash_image_width' =>        get_option('splash_image_width'),
						'splash_image_height' =>       get_option('splash_image_height'),
						'splash_color' =>              get_option('splash_color'),
						'datepicker_start' =>          get_option('datepicker_start'),
						'datepicker_end' =>            get_option('datepicker_end'),
						'wsi_display_time' =>          get_option('wsi_display_time'),
						'wsi_picture_link_url' =>      get_option('wsi_picture_link_url'),
						'wsi_picture_link_target' =>   get_option('wsi_picture_link_target'),
						'wsi_include_url' =>           get_option('wsi_include_url'),
						'wsi_type' =>                  get_option('wsi_type'),
						'wsi_opacity' =>               get_option('wsi_opacity'),
						'wsi_idle_time' =>             get_option('wsi_idle_time'),
						'wsi_close_esc_function' =>    (get_option('wsi_close_esc_function')=='true'),    //boolean
						'wsi_hide_cross' =>            (get_option('wsi_hide_cross')=='true'),            //boolean
						'wsi_disable_shadow_border' => (get_option('wsi_disable_shadow_border')=='true'), //boolean
						'wsi_youtube_autoplay' =>      (get_option('wsi_youtube_autoplay')=='true'),      //boolean
						'wsi_youtube_loop' =>          (get_option('wsi_youtube_loop')=='true'),          //boolean
						'wsi_fixed_splash' =>          (get_option('wsi_fixed_splash')=='true'),          //boolean
						'wsi_display_always' =>        (get_option('splash_test_active')=='true'),        //boolean
						'wsi_youtube' =>               get_option('wsi_youtube'),
						'wsi_yahoo' =>                 get_option('wsi_yahoo'),
						'wsi_dailymotion' =>           get_option('wsi_dailymotion'),
						'wsi_metacafe' =>              get_option('wsi_metacafe'),
						'wsi_swf' =>                   get_option('wsi_swf'),
						'wsi_html' =>                  get_option('wsi_html'),
	
				));
	
				// Delete old options...
				delete_option('splash_active');
				delete_option('wsi_first_load_mode_active');
				delete_option('splash_test_active');
				delete_option('url_splash_image');
				delete_option('splash_image_width');
				delete_option('splash_image_height');
				delete_option('splash_color');
				delete_option('datepicker_start');
				delete_option('datepicker_end');
				delete_option('wsi_display_time');
				delete_option('wsi_picture_link_url');
				delete_option('wsi_picture_link_target');
				delete_option('wsi_include_url');
				delete_option('wsi_type');
				delete_option('wsi_opacity');
				delete_option('wsi_idle_time');
				delete_option('wsi_close_esc_function');
				delete_option('wsi_hide_cross');
				delete_option('wsi_disable_shadow_border');
				delete_option('wsi_youtube_autoplay');
				delete_option('wsi_youtube_loop');
				delete_option('wsi_fixed_splash');
				delete_option('wsi_youtube');
				delete_option('wsi_yahoo');
				delete_option('wsi_dailymotion');
				delete_option('wsi_metacafe');
				delete_option('wsi_swf');
				delete_option('wsi_html');
	
				//no break, because if the last version is 3.0, we must run this step and the next...
	
			case "2.0":
				
				$table_name_splashimage = SplashImageManager::tableName();
				$sql_update_wsi_html = "ALTER TABLE " . $table_name_splashimage .  
				" MODIFY wsi_html LONGTEXT NULL;";
				$wpdb->query($sql_update_wsi_html);
				
			case "2.1":
				
				$table_name_splashimage = SplashImageManager::tableName();
				$sql_update = "ALTER TABLE " . $table_name_splashimage . 
				" ADD COLUMN wsi_margin_top INT NULL;";
				$wpdb->query($sql_update);
				
			case "2.2":
				
				$table_name_splashimage = SplashImageManager::tableName();
				$sql_alter = "ALTER TABLE " . $table_name_splashimage . 
				" ADD COLUMN wsi_hide_on_mobile_devices BOOLEAN NULL;";
				$wpdb->query($sql_alter);
				
				$sql_update = "UPDATE " . $table_name_splashimage .
				" SET wsi_hide_on_mobile_devices = 0;";
				$wpdb->query($sql_update);
				
			case "2.3":

				$table_name_splashimage = SplashImageManager::tableName();
				$wpdb->query("ALTER TABLE ".$table_name_splashimage." ADD COLUMN wsi_close_on_click_function BOOLEAN NULL;");
				$wpdb->query("UPDATE ".     $table_name_splashimage." SET wsi_close_on_click_function = 0;");
				$wpdb->query("ALTER TABLE ".$table_name_splashimage." DROP wsi_close_esc_function;");
				$wpdb->query("ALTER TABLE ".$table_name_splashimage." ADD COLUMN wsi_close_on_esc_function BOOLEAN NULL;");
				$wpdb->query("UPDATE ".     $table_name_splashimage." SET wsi_close_on_esc_function = 0;");
				
			case "2.4":
				//nothing for the moment (it is the current version)
					
			case "3.0":
				//do not exists
	
		}
	
		// Add or update the wsi db version.
		update_option("wsi_db_version", WSI_DB_VERSION);
	
	}
	
	/**
	 * Drop WSI table
	 * @return true if drop is OK, false in other cases
	 */
	public function drop_wsi_table($wsi_table_name) {
		
		global $wpdb;

		$wsi_tables_list = WsiCommons::getWsiTablesList(); 
		if (!in_array($wsi_table_name, $wsi_tables_list)) {
			return false;
		}
		
		$sql = "DROP TABLE $wsi_table_name;";
		$result = $wpdb->query($sql);
		if (!$result) {
			return false;
		}
		return true;
	}

	/**
	 * Delete WSI option
	 * @return true if option is deleted, false in other cases
	 */
	public function delete_wsi_option($wsi_option_name) {
		
		$wsi_tables_list = WsiCommons::getWsiOptionsList(); 
		if (!in_array($wsi_option_name, $wsi_tables_list)) {
			return false;
		}
		
		return delete_option($wsi_option_name);
	}
	
}