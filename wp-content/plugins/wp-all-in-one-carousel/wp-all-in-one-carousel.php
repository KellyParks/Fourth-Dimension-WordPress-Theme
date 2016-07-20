<?php

/**
 * Plugin Name: All in One Carousel for WordPress
 * Description: All in One Carousel for WordPress
 * Version: 1.1
 * Author: Hitesh Khunt
 * Author URI: http://www.saragna.com/Hitesh-Khunt
 * Plugin URI: http://plugin.saragna.com/vc-addon
 * Text Domain: swp-carousel
 * License: GPLv2 or later
 * 
 */

$accoVersion = "1.1";

$currentFile = __FILE__;

$currentFolder = dirname($currentFile);

$swp_carou_tables = 'swp_post_carousel';

require_once $currentFolder . '/inc/comman_class.php';
require_once $currentFolder . '/inc/admin_class.php';
require_once $currentFolder . '/inc/slider-tinymce.php';
require_once $currentFolder . '/inc/all_function.php';
require_once $currentFolder . '/inc/post-carousel-shortcode.php';

if (!class_exists('swp_Post_acco')) {

class swp_Post_carou extends swp_carou_class_grid {

	const doc_link = 'http://plugin.saragna.com/vc-addon';

	var $exclude_img = array();

	function __construct() {
		parent::__construct();
		add_action('admin_menu', array( $this, 'add_animate_setting_page'));
		add_shortcode('swp_carou_data','swp_carou_grid_shortcode');
		add_shortcode('swp_carou','swp_carou_layout_shortcode');
		add_shortcode('wp_carousel_anything','wp_carousel_anything_shortcode');
		add_shortcode('wp_carousel_html','wp_carousel_html_shortcode');		
	}

	public function add_animate_setting_page() {
			add_menu_page( 'Carousel', 'Carousel', 'manage_options', 'swp-carou', array( $this, 'my_scarou_grid_page'), self::animate_plugin_url( '../assets/image/icon.png' ), 88);

	}
	public function my_scarou_grid_page(){
	global $wpdb,$accoVersion;
		include('admin/setting.php');
	}
}
$swp_Post_carou = new swp_Post_carou();
}



add_action('init', 'do_output_buffer');

if(!function_exists('do_output_buffer')){

	function do_output_buffer() {

		ob_start();

	}

}
