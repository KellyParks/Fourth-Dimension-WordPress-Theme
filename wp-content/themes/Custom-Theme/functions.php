<?php

//add your css to the page
//this function needs wp_head(); in the layout's head section in order to output the css to the browser

if(!function_exists('load_styles_and_scripts')){

	function load_styles_and_scripts(){
		wp_enqueue_style('remodal.css', get_stylesheet_directory_uri() . '/css/remodal.css');
		wp_enqueue_style('responsive-nav.css', get_stylesheet_directory_uri() . '/css/responsive-nav.css');
		wp_enqueue_style('remodal-default-theme.css', get_stylesheet_directory_uri() . '/css/remodal-default-theme.css');
		wp_enqueue_script('jquery.js', get_template_directory_uri() . '/js/jquery.js', null, false, true);
		wp_enqueue_script('flexibility.js', get_template_directory_uri() . '/js/flexibility.js', array('jquery.js'), false, true);
		wp_enqueue_script('responsive-nav.js', get_template_directory_uri() . '/js/responsive-nav.js', array('jquery.js'), false, true);
	}

}

add_action('wp_enqueue_scripts', 'load_styles_and_scripts');

function add_custom_styles() {
	wp_enqueue_style( 'style.css', get_stylesheet_directory_uri() .'/style.css', array('contact-form-7', 
'file-manager__front-style','media-views', 'imgareaselect', 'svc-awesome-css', 'testimonial-rotator-style', 'font-awesome', 'remodal.css', 'remodal-default-theme.css') );
}

add_action('init', 'add_custom_styles', 99);

//adds the ability to allow the user to add or change the logo through WP's Customizer on the admin panel
//needs the_custom_logo(); in the place you want the logo to appear

if(!function_exists('add_logo')) {

 	function add_logo() {
     	add_theme_support( 'custom-logo', array(
         'height'      => 106,
         'width'       => 303,
         'flex-height' => true,));
 	}

 }

add_action( 'after_setup_theme', 'add_logo' );

add_theme_support( 'post-thumbnails', array( 'page' ) );

add_action( 'init', 'my_add_excerpts_to_pages' );

function my_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

//register menus so t

function register_menu() {

  register_nav_menu('header-menu',__('Header Menu'));

}

add_action('init', 'register_menu');


//In order to add widgets for the site, you'll need to 'register' the widget

if(!function_exists('register_widget_areas')){

	function register_widget_areas() {
 
    	// First footer widget area, located in the footer. Empty by default.
		register_sidebar( array(
	        'name' => __('Header: Hours of Operation and Contact'),
	        'id' => 'Header-Hours-of-operation-and-contact',
	        'description' => __('The logo section of the footer'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        // 'before_title' => '<h3 class="widget-title">',
	        // 'after_title' => '</h3>',
	    ) );

	    register_sidebar( array(
	        'name' => __('Testimonials'),
	        'id' => 'testimonials',
	        'description' => __('Testimonials section on homepage'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        // 'before_title' => '<h3 class="widget-title">',
	        // 'after_title' => '</h3>',
	    ) );

    	register_sidebar( array(
	        'name' => __('Footer Logo and Contact Info'),
	        'id' => 'footer-logo-and-contact-info',
	        'description' => __('The logo section of the footer'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h3 class="widget-title">',
	        'after_title' => '</h3>',
	    ) );

	    register_sidebar( array(
	        'name' => __('Footer Form'),
	        'id' => 'footer-form',
	        'description' => __('The form section of the footer'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h3 class="widget-title">',
	        'after_title' => '</h3>',
	    ) );

	    register_sidebar( array(
	        'name' => __('Footer Map'),
	        'id' => 'footer-map',
	        'description' => __('The map section of the footer'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h3 class="widget-title">',
	        'after_title' => '</h3>',
	    ));
	    
	    register_sidebar( array(
	        'name' => __('Popup Logo and Contact Info'),
	        'id' => 'popup-logo-and-contact-info',
	        'description' => __('The logo section of the popup'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h3 class="widget-title">',
	        'after_title' => '</h3>',
	    ) );
	    
	     register_sidebar( array(
	        'name' => __('Popup Form'),
	        'id' => 'popup-form',
	        'description' => __('The form section of the popup'),
	        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h3 class="widget-title">',
	        'after_title' => '</h3>',
	    ));
	
	}

}

add_action('widgets_init', 'register_widget_areas');

add_image_size( 'popup-thumbs', 355, 192 );
add_theme_support( 'title-tag' );