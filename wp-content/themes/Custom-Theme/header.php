<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php wp_title(' '); ?><?php if(wp_title(' ', false)) { echo ' -'; } ?> <?php bloginfo('name'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body>
<nav>
<div class="topBarBackground">
	<div class="container">
		<div class="logo-container">
			<?php the_custom_logo(); ?>
	      		<?php dynamic_sidebar('Header-Hours-of-operation-and-contact'); ?>
	      	</div>
	      		<?php wp_nav_menu(array('theme_location' => 'header-menu', 'menu_class' => 'nav-collapse')); ?>
	</div>
</div>
</nav>
<?php
	// Set up the objects
	$my_wp_query = new WP_Query();
	$all_wp_pages = $my_wp_query->query(array('post_type' => 'page'));

	// Get the services page as an object
	$services = get_page_by_title('Services');

	// Filter through all the service pages and find the children only
	$servicesChildPages = get_page_children($services->ID, $all_wp_pages);
	
	foreach($servicesChildPages as $page){
		echo '<div class="popup-container hide" id="' . $page->post_title . '">
			<div class="popup-content">
				<button type="button" class="closepopup">X</button>
				<h2 id="' . $page->ID . '">' . $page->post_title . '</h2>
				<p>' . wpautop($page->post_content) . '</p>
				<h2>Some of our work:</h2>';
				
				if($page->post_title == "Residential"){
					echo do_shortcode('[swp_carou_data id="1"]');
				} elseif ($page->post_title == "Agricultural"){
					echo do_shortcode('[swp_carou_data id="2"]');
				} elseif ($page->post_title == "Commercial"){
					echo do_shortcode('[swp_carou_data id="3"]');
				} else {
				
				}
		echo '<div class="container">
			<div class="far-left-container">';
				dynamic_sidebar('popup-logo-and-contact-info');
		echo '</div>';
				dynamic_sidebar('popup-form');
		echo '</div></div></div>';
				
		
	}
?>
<header role="banner">
	<div class="heroImg remodal-bg">
		<div class="container">
		<p>Welcome to Fourth Dimension Construction</p>
		<img src="<?php echo get_bloginfo('template_directory');?>/img/lines-top2.svg" alt="" class="lines">
		<h1>Concept <span>to Quality</span> Completion.</h1>
		<img src="<?php echo get_bloginfo('template_directory');?>/img/lines-bottom2.svg" alt="" class="lines">
		<p>Contact us today to tell us about your next project!</p>
	</div>
	</div>
</header>