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
	 * @return string splashimage table name
	 */
	public static function tableName() {
		return $wpdb->prefix . "wsi_splashimage";
	}
	
	/**
	 * @param SplashImageBean $splashImageBean
	 */
	public function save(SplashImageBean $splashImageBean) {
		
		$wpdb->update(
				$this->tableName(),
				array(
						
						'url_splash_image'        => $splashImageBean->getUrl_splash_image(),
						'splash_image_width'      => $splashImageBean->getSplash_image_width(),
						'splash_image_height'     => $splashImageBean->getSplash_image_height(),
						'splash_color'            => $splashImageBean->getSplash_color(),
						'datepicker_start'        => $splashImageBean->getDatepicker_start(),
						'datepicker_end'          => $splashImageBean->getDatepicker_end(),
						'wsi_display_time'        => $splashImageBean->getWsi_display_time(),
						'wsi_picture_link_url'    => $splashImageBean->getWsi_picture_link_url(),
						'wsi_picture_link_target' => $splashImageBean->getWsi_picture_link_target(),
						'wsi_type'                => $splashImageBean->getWsi_type(),
						'wsi_opacity'             => $splashImageBean->getWsi_opacity(),
						'wsi_idle_time'           => ($splashImageBean->getWsi_idle_time()=='')?0:$splashImageBean->getWsi_idle_time(),
						
						// Gestion des booleans
						'wsi_close_esc_function'    => (($splashImageBean->isWsi_close_esc_function())?'1':'0'),
						'wsi_hide_cross'            => (($splashImageBean->isWsi_hide_cross())?'1':'0'),
						'wsi_disable_shadow_border' => (($splashImageBean->isWsi_disable_shadow_border())?'1':'0'),
						'wsi_youtube_autoplay'      => (($splashImageBean->isWsi_youtube_autoplay())?'1':'0'),
						'wsi_youtube_loop'          => (($splashImageBean->isWsi_youtube_loop())?'1':'0'),
						'wsi_fixed_splash'          => (($splashImageBean->isWsi_fixed_splash())?'1':'0'),
						
						// Valeurs des onglets
						'wsi_youtube'     => $splashImageBean->getWsi_youtube(),
						'wsi_yahoo'       => $splashImageBean->getWsi_yahoo(),
						'wsi_dailymotion' => $splashImageBean->getWsi_dailymotion(),
						'wsi_metacafe'    => $splashImageBean->getWsi_metacafe(),
						'wsi_swf'         => $splashImageBean->getWsi_swf(),
						'wsi_html'        => $splashImageBean->getWsi_html(),
						'wsi_include_url' => $splashImageBean->getWsi_include_url()
						
				),
				array( 'id' => $splashImageBean->getId() ),
				$format = null,
				$where_format = null );
		
		// Update class instance
		$this->splashImageBean = $splashImageBean;
		
	}
	
	/**
	 * @return SplashImageBean with "esc_attr" security on each property.
	 */
	//TODO: update !
	public function get($splashImageID) {
		
		if (!isset($this->splashImageBean)) {
			
			$splashImageBean = new SplashImageBean();
			
			$wsi_splashimage_row = $wpdb->get_row("SELECT * FROM $this->tableName() WHERE id = $splashImageID");
			
			$splashImageBean->setUrl_splash_image(           esc_attr($wsi_splashimage_row['url_splash_image']));
			$splashImageBean->setSplash_image_width(         esc_attr($wsi_splashimage_row['splash_image_width']));
			$splashImageBean->setSplash_image_height(        esc_attr($wsi_splashimage_row['splash_image_height']));
			$splashImageBean->setSplash_color(               esc_attr($wsi_splashimage_row['splash_color']));
			$splashImageBean->setDatepicker_start(           esc_attr($wsi_splashimage_row['datepicker_start']));
			$splashImageBean->setDatepicker_end(             esc_attr($wsi_splashimage_row['datepicker_end']));
			$splashImageBean->setWsi_display_time(           esc_attr($wsi_splashimage_row['wsi_display_time']));
			$splashImageBean->setWsi_picture_link_url(       esc_attr($wsi_splashimage_row['wsi_picture_link_url']));
			$splashImageBean->setWsi_picture_link_target(    esc_attr($wsi_splashimage_row['wsi_picture_link_target']));
			$splashImageBean->setWsi_type(                   esc_attr($wsi_splashimage_row['wsi_type']));
			$splashImageBean->setWsi_opacity(                esc_attr($wsi_splashimage_row['wsi_opacity']));
			$splashImageBean->setWsi_idle_time(              esc_attr($wsi_splashimage_row['wsi_idle_time']));

			$splashImageBean->setWsi_close_esc_function(     esc_attr($wsi_splashimage_row['wsi_close_esc_function']=='1'?'true':'false'));
			$splashImageBean->setWsi_hide_cross(             esc_attr($wsi_splashimage_row['wsi_hide_cross']=='1'?'true':'false'));
			$splashImageBean->setWsi_disable_shadow_border(  esc_attr($wsi_splashimage_row['wsi_disable_shadow_border']=='1'?'true':'false'));
			$splashImageBean->setWsi_youtube_autoplay(       esc_attr($wsi_splashimage_row['wsi_youtube_autoplay']=='1'?'true':'false'));
			$splashImageBean->setWsi_youtube_loop(           esc_attr($wsi_splashimage_row['wsi_youtube_loop']=='1'?'true':'false'));
			$splashImageBean->setWsi_fixed_splash(           esc_attr($wsi_splashimage_row['wsi_fixed_splash']=='1'?'true':'false'));

			$splashImageBean->setWsi_youtube(                esc_attr($wsi_splashimage_row['wsi_youtube']));
			$splashImageBean->setWsi_yahoo(                  esc_attr($wsi_splashimage_row['wsi_yahoo']));
			$splashImageBean->setWsi_dailymotion(            esc_attr($wsi_splashimage_row['wsi_dailymotion']));
			$splashImageBean->setWsi_metacafe(               esc_attr($wsi_splashimage_row['wsi_metacafe']));
			$splashImageBean->setWsi_swf(                    esc_attr($wsi_splashimage_row['wsi_swf']));
			$splashImageBean->setWsi_include_url(            esc_attr($wsi_splashimage_row['wsi_include_url']));

			//No escape for HTML values.
			$splashImageBean->setWsi_html(                   $wsi_splashimage_row['wsi_html']);
			
			$this->splashImageBean = $splashImageBean;
			
		}
		return $this->splashImageBean;
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
	
}

?>