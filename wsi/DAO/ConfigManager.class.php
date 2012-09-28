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
	private function __construct() {}
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
		global $wpdb;
		return $wpdb->prefix . "wsi_config";
	}
	
	/**
	 * @param ConfigBean $configBean
	 */
	public function save(ConfigBean $configBean) {
		global $wpdb;
		
		$success = $wpdb->update(
				$this->tableName(),
				array('value' => (($configBean->isSplash_active())?'true':'false')),
				array('param' => 'splash_active'),
				$format = null,
				$where_format = null);
		
		$success = $wpdb->update(
				$this->tableName(),
				array('value' => (($configBean->isWsi_first_load_mode_active())?'true':'false')),
				array('param' => 'wsi_first_load_mode_active'),
				$format = null,
				$where_format = null);
		
		// Update class instance
		$this->configBean = $configBean;
		
	}

	/**
	 * @return ConfigBean with "esc_attr" security on each property.
	 */
	public function get() {
	
		global $wpdb;
		if (!isset($this->configBean)) {
	
			$configBean = new ConfigBean();

			$splash_active =              $wpdb->get_var("SELECT value FROM ".$this->tableName()." WHERE param = 'splash_active'",0,0);
			$wsi_first_load_mode_active = $wpdb->get_var("SELECT value FROM ".$this->tableName()." WHERE param = 'wsi_first_load_mode_active'",0,0);
			
			$configBean->setSplash_active(              $splash_active);
			$configBean->setWsi_first_load_mode_active( $wsi_first_load_mode_active);
			
			$this->configBean = $configBean;
			
		}
		return $this->configBean;
	}
	
	/**
	 * Remise de toutes les options aux valeurs par défaut
	 */
	public function reset() {
		global $wpdb;
		$wpdb->query("DELETE FROM ".$this->tableName());
		$wpdb->insert($this->tableName(),array('param'=>'splash_active',              'value'=>'true' ));
		$wpdb->insert($this->tableName(),array('param'=>'wsi_first_load_mode_active', 'value'=>'false'));
	}
	
	/**
	 * Drop table 'wsi_config'.
	 */
	public function drop() {
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS ".$this->tableName());
	}
	
	/**
	 * @return string
	 */
	public function getInfos() {
		$result;
		$result.= "<strong>".$this->tableName().": </strong><br />";
		$result.= "splash_active: ".             (($this->configBean->isSplash_active()===true)?"true":"false")."<br />";
		$result.= "wsi_first_load_mode_active: ".(($this->configBean->isWsi_first_load_mode_active()===true)?"true":"false")."<br />";
		return $result;	
	}
	
}