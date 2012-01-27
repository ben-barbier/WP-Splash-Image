<?php

/**
 * @author Benjamin Barbier
 *
 */
class SplashImageManager {
	
	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {}
	/**
	 * @return SplashImageManager instance
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new SplashImageManager();
		} return self::$_instance;
	}
	
	private $splashImageBean;
	
	/**
	 * @param SplashImageBean $splashImageBean
	 */
	public function save(SplashImageBean $splashImageBean) {
		
		update_option('url_splash_image',        $splashImageBean->getUrl_splash_image());
		update_option('splash_image_width',      $splashImageBean->getSplash_image_width());
		update_option('splash_image_height',     $splashImageBean->getSplash_image_height());
		update_option('splash_color',            $splashImageBean->getSplash_color());
		update_option('datepicker_start',        $splashImageBean->getDatepicker_start());
		update_option('datepicker_end',          $splashImageBean->getDatepicker_end());
		update_option('wsi_display_time',        $splashImageBean->getWsi_display_time());
		update_option('wsi_picture_link_url',    $splashImageBean->getWsi_picture_link_url());
		update_option('wsi_picture_link_target', $splashImageBean->getWsi_picture_link_target());
		update_option('wsi_include_url',         $splashImageBean->getWsi_include_url());
		update_option('wsi_type',                $splashImageBean->getWsi_type());
		update_option('wsi_opacity',             $splashImageBean->getWsi_opacity());
		update_option('wsi_idle_time',           ($splashImageBean->getWsi_idle_time()=='')?0:$splashImageBean->getWsi_idle_time());
		
		// Gestion des booleans
		update_option('splash_active',              ($splashImageBean->isSplash_active())?'true':'false');
		update_option('wsi_first_load_mode_active', ($splashImageBean->isWsi_first_load_mode_active())?'true':'false');
		update_option('splash_test_active',         ($splashImageBean->isSplash_test_active())?'true':'false');
		update_option('wsi_close_esc_function',     ($splashImageBean->isWsi_close_esc_function())?'true':'false');
		update_option('wsi_hide_cross',             ($splashImageBean->isWsi_hide_cross())?'true':'false');
		update_option('wsi_disable_shadow_border',  ($splashImageBean->isWsi_disable_shadow_border())?'true':'false');
		update_option('wsi_youtube_autoplay',       ($splashImageBean->isWsi_youtube_autoplay())?'true':'false');
		update_option('wsi_youtube_loop',           ($splashImageBean->isWsi_youtube_loop())?'true':'false');
		update_option('wsi_fixed_splash',           ($splashImageBean->isWsi_fixed_splash())?'true':'false');
		
		// Valeurs des onglets
		update_option('wsi_youtube',     $splashImageBean->getWsi_youtube());
		update_option('wsi_yahoo',       $splashImageBean->getWsi_yahoo());
		update_option('wsi_dailymotion', $splashImageBean->getWsi_dailymotion());
		update_option('wsi_metacafe',    $splashImageBean->getWsi_metacafe());
		update_option('wsi_swf',         $splashImageBean->getWsi_swf());
		update_option('wsi_html',        $splashImageBean->getWsi_html());
		
	}
	
	/**
	 * @return SplashImageBean with "esc_attr" security on each property.
	 */
	//TODO: update !
	public function get() {
		
		if (!isset($this->splashImageBean)) {
			
			$splashImageBean = new SplashImageBean();
			
			$splashImageBean->setUrl_splash_image(           esc_attr(get_option('url_splash_image')));
			$splashImageBean->setSplash_image_width(         esc_attr(get_option('splash_image_width')));
			$splashImageBean->setSplash_image_height(        esc_attr(get_option('splash_image_height')));
			$splashImageBean->setSplash_color(               esc_attr(get_option('splash_color')));
			$splashImageBean->setDatepicker_start(           esc_attr(get_option('datepicker_start')));
			$splashImageBean->setDatepicker_end(             esc_attr(get_option('datepicker_end')));
			$splashImageBean->setWsi_display_time(           esc_attr(get_option('wsi_display_time')));
			$splashImageBean->setWsi_picture_link_url(       esc_attr(get_option('wsi_picture_link_url')));
			$splashImageBean->setWsi_picture_link_target(    esc_attr(get_option('wsi_picture_link_target')));
			$splashImageBean->setWsi_include_url(            esc_attr(get_option('wsi_include_url')));
			$splashImageBean->setWsi_type(                   esc_attr(get_option('wsi_type')));
			$splashImageBean->setWsi_opacity(                esc_attr(get_option('wsi_opacity')));
			$splashImageBean->setWsi_idle_time(              esc_attr(get_option('wsi_idle_time')));
			$splashImageBean->setSplash_active(              esc_attr(get_option('splash_active')));
			$splashImageBean->setWsi_first_load_mode_active( esc_attr(get_option('wsi_first_load_mode_active')));
			$splashImageBean->setSplash_test_active(         esc_attr(get_option('splash_test_active')));
			$splashImageBean->setWsi_close_esc_function(     esc_attr(get_option('wsi_close_esc_function')));
			$splashImageBean->setWsi_hide_cross(             esc_attr(get_option('wsi_hide_cross')));
			$splashImageBean->setWsi_disable_shadow_border(  esc_attr(get_option('wsi_disable_shadow_border')));
			$splashImageBean->setWsi_youtube_autoplay(       esc_attr(get_option('wsi_youtube_autoplay')));
			$splashImageBean->setWsi_youtube_loop(           esc_attr(get_option('wsi_youtube_loop')));
			$splashImageBean->setWsi_fixed_splash(           esc_attr(get_option('wsi_fixed_splash')));
			$splashImageBean->setWsi_youtube(                esc_attr(get_option('wsi_youtube')));
			$splashImageBean->setWsi_yahoo(                  esc_attr(get_option('wsi_yahoo')));
			$splashImageBean->setWsi_dailymotion(            esc_attr(get_option('wsi_dailymotion')));
			$splashImageBean->setWsi_metacafe(               esc_attr(get_option('wsi_metacafe')));
			$splashImageBean->setWsi_swf(                    esc_attr(get_option('wsi_swf')));
			//No escape for HTML values.
			$splashImageBean->setWsi_html(                   get_option('wsi_html'));
			
			$this->splashImageBean = $splashImageBean;
			
		}
		return $this->splashImageBean;
	}
	
	/**
	 * @return string
	 */
	public function getInfos() {
		$wsiInfos;
		foreach (WsiCommons::getOptionsList() as $option) {
			$wsiInfos.= $option.": ".get_option($option)."\n";
		}
		return $wsiInfos;
	}
	
	/**
	 * Retourne une map avec en clef, les options de WSI et en valeur, les valeurs par défaut.
	 */
	private function getDefaultValues() {
		return array(
				'splash_active'              => 'true',
				'wsi_first_load_mode_active' => 'false',
				'splash_test_active'         => 'false',
				'wsi_idle_time'              => '30',
				'url_splash_image'           => 'http://plugins.svn.wordpress.org/wsi/assets/banner-772x250.png',
				'splash_image_width'         => '772',
				'splash_image_height'        => '250',
				'splash_color'               => '000000',
				'datepicker_start'           => '',
				'datepicker_end'             => '',
				'wsi_display_time'           => '5',
				'wsi_fixed_splash'           => 'true',
				'wsi_picture_link_url'       => 'http://wordpress.org/extend/plugins/wsi/',
				'wsi_picture_link_target'    => 'blank',
				'wsi_include_url'            => '',
				'wsi_close_esc_function'     => 'false',
				'wsi_hide_cross'             => 'false',
				'wsi_disable_shadow_border'  => 'false',
				'wsi_type'                   => 'picture',
				'wsi_opacity'                => '75',
				'wsi_youtube'                => '',
				'wsi_youtube_autoplay'       => 'true',
				'wsi_youtube_loop'           => 'false',
				'wsi_yahoo'                  => '',
				'wsi_dailymotion'            => '',
				'wsi_metacafe'               => '',
				'wsi_swf'                    => '',
				'wsi_html'                   => ''
		);
	}
	
	/**
	 * Remise de toutes les options aux valeurs par défaut
	 */
	//TODO: update !
	public function reset() {
		foreach ($this->getDefaultValues() as $option => $defaultValue) {
			update_option($option, $defaultValue);
		}
	}
	
	/**
	 * Delete an option if this option come from WSI.
	 * @param unknown_type $option
	 * @return bool
	 */
	//TODO: update !
	public function delete($option) {
		
		// Vérifie si l'option appartient à WSI.
		if(in_array($option, WsiCommons::getOptionsList())) {
			return delete_option($option);
		} else {
			return false;
		}
		
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
		        
		    	$table_name_splashimage = $wpdb->prefix . "wsi_splashimage";
		    	$sql_splashimage = "CREATE TABLE " . $table_name_splashimage . " (
			    	id                        MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
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
			    	UNIQUE KEY id (id)
		    	);";
		    	
		    	$table_name_config = $wpdb->prefix . "wsi_config";
		    	$sql_config = "CREATE TABLE " . $table_name_config . " (
			    	splash_active BOOLEAN,
			    	wsi_first_load_mode_active BOOLEAN,
			    	splash_test_active BOOLEAN
		    	);";
		    	
		    	echo $sql_config;
		    	echo $sql_splashimage;
		    	
		    	dbDelta($sql_config);
		    	dbDelta($sql_splashimage);
		    	
		    	$wpdb->insert( $table_name_config, array( 
		    			'splash_active'              => (get_option('splash_active')=='true'),              //boolean
		    			'wsi_first_load_mode_active' => (get_option('wsi_first_load_mode_active')=='true'), //boolean 
		    			'splash_test_active'         => (get_option('splash_test_active')=='true')          //boolean
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
		        //nothing for the moment (it is the last version)
		        
		    case "3.0":
				//do not exists
				
		}
		
		// Add or update the wsi db version.
		update_option("wsi_db_version", WSI_DB_VERSION);
	
	}
	
}

?>