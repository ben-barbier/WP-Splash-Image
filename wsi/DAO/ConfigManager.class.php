<?php

/**
 * @author Benjamin Barbier
 *
 */
class ConfigManager {
	
	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {
	}
	/**
	 * @return ConfigManager instance
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new ConfigManager();
		} return self::$_instance;
	}
	
	private $configBean;
	
	/**
	 * @return string config table name
	 */
	public static function tableName() {
		return $wpdb->prefix . "wsi_config";
	}
	
	/**
	 * @param ConfigBean $configBean
	 */
	//TODO: check !
	public function save(ConfigBean $configBean) {
		
		$wpdb->update( 
			$this->tableName(), 
			array(
					'splash_active'              => (($configBean->isSplash_active())?'1':'0'),              // boolean
					'wsi_first_load_mode_active' => (($configBean->isWsi_first_load_mode_active())?'1':'0'), // boolean
					'splash_test_active'         => (($configBean->isSplash_test_active())?'1':'0')          // boolean
			),
			$where, 
			$format = null, 
			$where_format = null );
		
		// Update class instance
		$this->configBean = $configBean;
		
	}

	/**
	 * @return ConfigBean with "esc_attr" security on each property.
	 */
	//TODO: check !
	public function get() {
	
		if (!isset($this->configBean)) {
	
			$configBean = new ConfigBean();

			$wsi_config_row = $wpdb->get_row("SELECT * FROM $this->tableName()"); // Only one row in wsi_config table
			
			$configBean->setSplash_active(              ($wsi_config_row['splash_active']=='1'?'true':'false'));
			$configBean->setWsi_first_load_mode_active( ($wsi_config_row['wsi_first_load_mode_active']=='1'?'true':'false'));
			$configBean->setSplash_test_active(         ($wsi_config_row['splash_test_active']=='1'?'true':'false'));
			
			$this->configBean = $configBean;
			
		}
		return $this->configBean;
	}
	
	//TODO: complete...
	
}