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
		global $wpdb;
		return $wpdb->prefix . "wsi_splashimage";
	}
	
	/**
	 * @param SplashImageBean $splashImageBean
	 */
	public function save(SplashImageBean $splashImageBean) {
		
		global $wpdb;
		$wpdb->update(
				$this->tableName(),
				array(
						
						'url_splash_image'        => $splashImageBean->getUrl_splash_image(),
						'splash_image_width'      => $splashImageBean->getSplash_image_width(),
						'splash_image_height'     => $splashImageBean->getSplash_image_height(),
						'wsi_margin_top'          => $splashImageBean->getWsi_margin_top(),
						'splash_color'            => $splashImageBean->getSplash_color(),
						
						'wsi_display_time'        => $splashImageBean->getWsi_display_time(),
						'wsi_picture_link_url'    => $splashImageBean->getWsi_picture_link_url(),
						'wsi_picture_link_target' => $splashImageBean->getWsi_picture_link_target(),
						'wsi_type'                => $splashImageBean->getWsi_type(),
						'wsi_opacity'             => $splashImageBean->getWsi_opacity(),
						'wsi_idle_time'           => ($splashImageBean->getWsi_idle_time()=='')?0:$splashImageBean->getWsi_idle_time(),
						
						// Dates management
						'datepicker_start'        => $splashImageBean->getDatepicker_start(),
						'datepicker_end'          => $splashImageBean->getDatepicker_end(),

						// Booleans management
						'wsi_close_on_esc_function'  => (($splashImageBean->isWsi_close_on_esc_function())?'1':'0'),
						'wsi_close_on_click_function'=> (($splashImageBean->isWsi_close_on_click_function())?'1':'0'),
						'wsi_hide_cross'             => (($splashImageBean->isWsi_hide_cross())?'1':'0'),
						'wsi_disable_shadow_border'  => (($splashImageBean->isWsi_disable_shadow_border())?'1':'0'),
						'wsi_youtube_autoplay'       => (($splashImageBean->isWsi_youtube_autoplay())?'1':'0'),
						'wsi_youtube_loop'           => (($splashImageBean->isWsi_youtube_loop())?'1':'0'),
						'wsi_fixed_splash'           => (($splashImageBean->isWsi_fixed_splash())?'1':'0'),
						'wsi_display_always'         => (($splashImageBean->isWsi_display_always())?'1':'0'),
						'wsi_hide_on_mobile_devices' => (($splashImageBean->isWsi_hide_on_mobile_devices())?'1':'0'),
						
						// Tabs values
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
		
		// Dates management
		if ($splashImageBean->getDatepicker_start()==null) {
			$query_reset_Datepicker_start = "update ".$this->tableName()." set datepicker_start = null;";
			$wpdb->query($query_reset_Datepicker_start);
		}
		if ($splashImageBean->getDatepicker_end()==null) {
			$query_reset_Datepicker_end = "update ".$this->tableName()." set datepicker_end = null;";
			$wpdb->query($query_reset_Datepicker_end);
		}
		
		// Update class instance
		$this->splashImageBean = $splashImageBean;
		
	}
	
	/**
	 * @return SplashImageBean with "esc_attr" security on each property.
	 */
	public function get($splashImageID) {
		
		global $wpdb;
		
		if (!isset($this->splashImageBean)) {
			
			$splashImageBean = new SplashImageBean();
			
			$wsi_splashimage_results = $wpdb->get_results("SELECT * FROM ".$this->tableName()." WHERE id = ".$splashImageID);
			$wsi_splashimage_row = $wsi_splashimage_results[0]; 
			
			$splashImageBean->setId(                         esc_attr($wsi_splashimage_row->id));
			
			$splashImageBean->setUrl_splash_image(           esc_attr($wsi_splashimage_row->url_splash_image));
			$splashImageBean->setSplash_image_width(         esc_attr($wsi_splashimage_row->splash_image_width));
			$splashImageBean->setSplash_image_height(        esc_attr($wsi_splashimage_row->splash_image_height));
			$splashImageBean->setWsi_margin_top(             esc_attr($wsi_splashimage_row->wsi_margin_top));
			$splashImageBean->setSplash_color(               esc_attr($wsi_splashimage_row->splash_color));
			$splashImageBean->setWsi_display_time(           esc_attr($wsi_splashimage_row->wsi_display_time));
			$splashImageBean->setWsi_picture_link_url(       esc_attr($wsi_splashimage_row->wsi_picture_link_url));
			$splashImageBean->setWsi_picture_link_target(    esc_attr($wsi_splashimage_row->wsi_picture_link_target));
			$splashImageBean->setWsi_type(                   esc_attr($wsi_splashimage_row->wsi_type));
			$splashImageBean->setWsi_opacity(                esc_attr($wsi_splashimage_row->wsi_opacity));
			$splashImageBean->setWsi_idle_time(              esc_attr($wsi_splashimage_row->wsi_idle_time));
			
			// Dates management
			$splashImageBean->setDatepicker_start(           esc_attr($wsi_splashimage_row->datepicker_start));
			$splashImageBean->setDatepicker_end(             esc_attr($wsi_splashimage_row->datepicker_end));
			
			// Booleans management
			$splashImageBean->setWsi_close_on_esc_function(  esc_attr($wsi_splashimage_row->wsi_close_on_esc_function=='1'?'true':'false'));
			$splashImageBean->setWsi_close_on_click_function(esc_attr($wsi_splashimage_row->wsi_close_on_click_function=='1'?'true':'false'));
			$splashImageBean->setWsi_hide_cross(             esc_attr($wsi_splashimage_row->wsi_hide_cross=='1'?'true':'false'));
			$splashImageBean->setWsi_disable_shadow_border(  esc_attr($wsi_splashimage_row->wsi_disable_shadow_border=='1'?'true':'false'));
			$splashImageBean->setWsi_youtube_autoplay(       esc_attr($wsi_splashimage_row->wsi_youtube_autoplay=='1'?'true':'false'));
			$splashImageBean->setWsi_youtube_loop(           esc_attr($wsi_splashimage_row->wsi_youtube_loop=='1'?'true':'false'));
			$splashImageBean->setWsi_fixed_splash(           esc_attr($wsi_splashimage_row->wsi_fixed_splash=='1'?'true':'false'));
			$splashImageBean->setWsi_display_always(         esc_attr($wsi_splashimage_row->wsi_display_always=='1'?'true':'false'));
			$splashImageBean->setWsi_hide_on_mobile_devices( esc_attr($wsi_splashimage_row->wsi_hide_on_mobile_devices=='1'?'true':'false'));

			// Valeurs des onglets
			$splashImageBean->setWsi_youtube(                esc_attr($wsi_splashimage_row->wsi_youtube));
			$splashImageBean->setWsi_yahoo(                  esc_attr($wsi_splashimage_row->wsi_yahoo));
			$splashImageBean->setWsi_dailymotion(            esc_attr($wsi_splashimage_row->wsi_dailymotion));
			$splashImageBean->setWsi_metacafe(               esc_attr($wsi_splashimage_row->wsi_metacafe));
			$splashImageBean->setWsi_swf(                    esc_attr($wsi_splashimage_row->wsi_swf));
			$splashImageBean->setWsi_include_url(            esc_attr($wsi_splashimage_row->wsi_include_url));

			//No escape for HTML values.
			$splashImageBean->setWsi_html(                   $wsi_splashimage_row->wsi_html);
			
			$this->splashImageBean = $splashImageBean;
			
		}
		return $this->splashImageBean;
	}
	
	/**
	 * Retourne une map avec en clef, les options de WSI et en valeur, les valeurs par défaut.
	 */
	private function getDefaultValues() {
		return array(
				'id'                         => 1,
				'wsi_display_always'         => 0, // false
				'wsi_hide_on_mobile_devices' => 0, // false
				'wsi_idle_time'              => '30',
				'url_splash_image'           => 'http://plugins.svn.wordpress.org/wsi/assets/banner-772x250.png',
				'splash_image_width'         => '772',
				'splash_image_height'        => '250',
				'wsi_margin_top'             => '',
				'splash_color'               => '000000',
// 				'datepicker_start'           => null,
// 				'datepicker_end'             => null,
				'wsi_display_time'           => '5',
				'wsi_fixed_splash'           => 1, // true
				'wsi_picture_link_url'       => 'http://wordpress.org/extend/plugins/wsi/',
				'wsi_picture_link_target'    => 'blank',
				'wsi_include_url'            => '',
				'wsi_close_on_esc_function'  => 1, // true
				'wsi_close_on_click_function'=> 1, // true
				'wsi_hide_cross'             => 0, // false
				'wsi_disable_shadow_border'  => 0, // false
				'wsi_type'                   => 'picture',
				'wsi_opacity'                => '75',
				'wsi_youtube'                => '',
				'wsi_youtube_autoplay'       => 1, // true
				'wsi_youtube_loop'           => 0, // false
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
	public function reset() {
		global $wpdb;
		$wpdb->query("DELETE FROM ".$this->tableName());
		$wpdb->insert( 
			$this->tableName(), 
			$this->getDefaultValues() 
		);
	}
	
	/**
	 * Delete one splashImageBean with id $id.
	 */
	public function delete($id) {
		global $wpdb;
		$wpdb->query("DELETE FROM ".$this->tableName()." WHERE id = '".$id."'");
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
		$result.= "id: ".                         $this->splashImageBean->getId()."<br />";
		$result.= "wsi_display_always: ".         $this->splashImageBean->isWsi_display_always()."<br />";
		$result.= "wsi_hide_on_mobile_devices: ". $this->splashImageBean->isWsi_hide_on_mobile_devices()."<br />";
		$result.= "wsi_idle_time: ".              $this->splashImageBean->getWsi_idle_time()."<br />";
		$result.= "url_splash_image: ".           $this->splashImageBean->getUrl_splash_image()."<br />";
		$result.= "splash_image_width: ".         $this->splashImageBean->getSplash_image_width()."<br />";
		$result.= "splash_image_height: ".        $this->splashImageBean->getSplash_image_height()."<br />";
		$result.= "wsi_margin_top: ".             $this->splashImageBean->getWsi_margin_top()."<br />";
		$result.= "splash_color: ".               $this->splashImageBean->getSplash_color()."<br />";
		$result.= "datepicker_start: ".           $this->splashImageBean->getDatepicker_start()."<br />";
		$result.= "datepicker_end: ".             $this->splashImageBean->getDatepicker_end()."<br />";
		$result.= "wsi_display_time: ".           $this->splashImageBean->getWsi_display_time()."<br />";
		$result.= "wsi_fixed_splash: ".           $this->splashImageBean->isWsi_fixed_splash()."<br />";
		$result.= "wsi_picture_link_url: ".       $this->splashImageBean->getWsi_picture_link_url()."<br />";
		$result.= "wsi_picture_link_target: ".    $this->splashImageBean->getWsi_picture_link_target()."<br />";
		$result.= "wsi_include_url: ".            $this->splashImageBean->getWsi_include_url()."<br />";
		$result.= "wsi_close_on_esc_function: ".  $this->splashImageBean->isWsi_close_on_esc_function()."<br />";
		$result.= "wsi_close_on_click_function: ".$this->splashImageBean->isWsi_close_on_click_function()."<br />";
		$result.= "wsi_hide_cross: ".             $this->splashImageBean->isWsi_hide_cross()."<br />";
		$result.= "wsi_disable_shadow_border: ".  $this->splashImageBean->isWsi_disable_shadow_border()."<br />";
		$result.= "wsi_type: ".                   $this->splashImageBean->getWsi_type()."<br />";
		$result.= "wsi_opacity: ".                $this->splashImageBean->getWsi_opacity()."<br />";
		$result.= "wsi_youtube: ".                $this->splashImageBean->getWsi_youtube()."<br />";
		$result.= "wsi_youtube_autoplay: ".       $this->splashImageBean->isWsi_youtube_autoplay()."<br />";
		$result.= "wsi_youtube_loop: ".           $this->splashImageBean->isWsi_youtube_loop()."<br />";
		$result.= "wsi_yahoo: ".                  $this->splashImageBean->getWsi_yahoo()."<br />";
		$result.= "wsi_dailymotion: ".            $this->splashImageBean->getWsi_dailymotion()."<br />";
		$result.= "wsi_metacafe: ".               $this->splashImageBean->getWsi_metacafe()."<br />";
		$result.= "wsi_swf: ".                    $this->splashImageBean->getWsi_swf()."<br />";
		$result.= "wsi_html: ".                   $this->splashImageBean->getWsi_html()."<br />";
		return $result;
	}
	
}

?>