<?php get_header(); ?>
<section class="whatWeDo">
	<div class="container">
		<h2>What We Do</h2>
		<p>Fourth Dimension Construction is a Fraser Valley based renovation and new construction company that has client oriented, experienced employees.</p>
		<p>With no job too big and no job too small, Fourth Dimension Construction will be able to provide complete construction services.</p>
	</div>
	<div class="dark-overlay">
		<div class="container">
		<div class="servicesContainer">
			<?php
			// Set up the objects
			$my_wp_query = new WP_Query();
			$all_wp_pages = $my_wp_query->query(array('post_type' => 'page'));

			// Get the services page as an object
			$services = get_page_by_title('Services');

			// Filter through all the service pages and find the children only
			$servicesChildPages = get_page_children($services->ID, $all_wp_pages);

			foreach($servicesChildPages as $page){
					echo '<article data-popup-target="' . $page->post_title . '">
						<h2>' . $page->post_title . '</h2>
						<p>' . $page->post_excerpt . '</p>' . 
							get_the_post_thumbnail($page->ID, array(356,192)) . 
						'</article>';
				}
			?>
		</div>
	</div>
	</div>
</section>
<section class="testimonials">
	<div class="container">
		<?php dynamic_sidebar('testimonials'); ?>
	</div>
</section>
<?php get_footer(); ?>