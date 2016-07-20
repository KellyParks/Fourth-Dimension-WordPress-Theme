<script type="text/javascript">
jQuery(function($){
	$('.post-list-tabs-menu li').click(function(){
		var tab = $(this).attr('data-tab-index');
		$('.post-list-tabs-menu li').removeClass('spl_active');
		$(this).addClass('spl_active');
		$('.spl_tabs').hide();
		$('#'+tab).show();
	});
	
	$('#grid_query').click(function(){
		$('#grid_query_div').slideToggle();	
	});
	
	//start media button
	var custom_uploader; 
	$('#upload_image_button').live('click', function( event ){
		event.preventDefault();
		if ( custom_uploader ) {
			custom_uploader.open();
			return;
		}
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Select Images',
			button: {text: 'Select Images',},
			multiple: true
		});

		custom_uploader.on( 'select', function() {
			var selection = custom_uploader.state().get('selection');
			selection.map( function( attachment ) {
			  attachment = attachment.toJSON();
			  if($('#carou_images').val() == ''){
				$('#carou_images').val(attachment['id']);
			  }else{
				var img_app = $('#carou_images').val();
				$('#carou_images').val(img_app+','+attachment['id'])
			  }
			});
			//attachment = file_frame.state().get('selection').first().toJSON();
			//console.log(attachment);
			//$('.read_only_path,#carou_images').val(attachment['url']);
		});
		custom_uploader.open();
	});
	//end media button
});
</script>
<style type="text/css">
.new_fields{ background:#fff; margin-top:0px; padding:5px 5px 0; border:1px solid #e7e4e4; border-top:0px;}
.widefat.dataa,.widefat.dataa td{ border:0px; box-shadow:none; cursor:move;}
.post-list-tabs-menu li {
    background: none repeat scroll 0 0 #fff;
    cursor: pointer;
    float: left;
    padding: 0.7%;
    text-align: center;
    width: 31.9%;
}
.post-list-tabs-menu li.spl_active {
    background: #002B36;
	color:#fff;
}
.post-list-tabs-menu {
    clear: both;
    list-style: none outside none;
}
.spost_button {
    background: #002b36 !important;
    border: 1px solid #002b36 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    font-size: 15px !important;
    height: 36px !important;
    line-height: 2em !important;
}
</style>

<?php 
$grid = $difault_grid_array;
if(isset($_GET['sid'])){
$id = intval($_GET['sid']);
$grid_data = $wpdb->get_row("select * from ".self::$table_prefix.self::SWP_CAROU_NAMES." where id=".$id);
$grid_ori = unserialize($grid_data->slider_params);
$grid = array_merge($difault_grid_array,$grid_ori);
}
//echo "<pre>";print_r($grid);echo "</pre>";?>
<ul class="post-list-tabs-menu">
	<li data-tab-index="general_tab" class="spl_active"><?php _e('General','swp-acco');?></li>
	<li data-tab-index="display_tab" class=""><?php _e('Display Setting','swp-acco');?></li>
	<li data-tab-index="color_tab" class=""><?php _e('Color Setting','swp-acco');?></li>
</ul>

<div id="general_tab" class="spl_tabs" style="display:block;">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="anew_slider_setting">
					<tr>
                    	<th><strong class="afl"><?php _e('Title','swp-acco');?></strong></th>
                        <td>
                            <input type="text" name="title" value="<?php echo $grid['title'];?>"/>
                            <p class="description"><?php _e('Enter Carousel title.','swp-acco');?></p>
                        </td>
                    </tr>
                    <tr>
						<th><strong class="afl"><?php _e('Carousel type','swp-acco');?> :</strong></th>	
						<td>
						<select name="svc_type" id="scarou_svc_type" data-check-depen="yes">
							<option value="post_layout" <?php selected( $grid['svc_type'], 'post_layout' ); ?>><?php _e('Post Carousel','swp-acco');?></option>
							<option value="carousel" <?php selected( $grid['svc_type'], 'carousel' ); ?>><?php _e('Image Carousel','swp-acco');?></option>
							<option value="video" <?php selected( $grid['svc_type'], 'video' ); ?>><?php _e('Video Carousel','swp-acco');?></option>
							<option value="anything" <?php selected( $grid['svc_type'], 'anything' ); ?>><?php _e('Anything HTML Carousel','swp-acco');?></option>
						</select>
						<p class="description"><?php _e('Choose Carousel type.','swp-acco');?></p>	
						</td>
					</tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Build Post Query','swp-acco');?> :</strong></th>	
						<td>
                        <input type="button" value="Build query" id="grid_query">
                        <p class="description"><?php _e('Create WordPress loop, to populate content from your site.','swp-acco');?></p>
                        <div id="grid_query_div">
                            <table style="width:86%">
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Post types','swp-acco');?></strong><br>
                                        <?php 
										$exclu_post_type = array('shop_order','shop_coupon','shop_webhook','wpcf7_contact_form','vc_grid_item');
										$args = array(
										   'public'   => true,
										   'publicly_queryable' => true
										);
										$output = 'names'; // names or objects, note names is the default
										$operator = 'and'; // 'and' or 'or'
										$post_types = get_post_types($args, $output, $operator); 
                                        foreach($post_types as $post_type){
                                        if($post_type != 'attachment' && $post_type != 'revision' && $post_type != 'nav_menu_item' && $post_type != 'product_variation' && $post_type != 'shop_order_refund'){?>
                                        <input type="checkbox" name="post_type[]" value="<?php echo $post_type;?>" <?php if(in_array( $post_type, $grid['post_type'] )){ echo 'checked';} ?>/><?php echo $post_type;?>&nbsp;
                                        <?php if($post_type == 'post'){?>
                                        <input type="checkbox" name="post_type[]" value="page" <?php if(in_array( 'page', $grid['post_type'] )){ echo 'checked';} ?>/>page&nbsp;                                        						
                                        <?php }
											}}?>	
                                    <p class="description"><?php _e('Select post types to populate posts from. Note: If no post type is selected, WordPress will use default "Post" value.','swp-acco');?></p>
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:200px;">
                                    	<strong class="afl"><?php _e('Post Count','swp-acco');?></strong><br>
                                        <input type="text" name="post_count" value="<?php echo $grid['post_count'];?>"/>					
                                    	<p class="description"><?php _e('How many teasers to show? Enter number or word "All".','swp-acco');?></p>
                                    </td>
                                    <td style="width:200px;">
                                    	<strong class="afl"><?php _e('Order By','swp-acco');?></strong><br>
                                        <select name="order_by">
                                            <option value="" <?php selected( $grid['order_by'], '' ); ?>></option>
                                            <option value="date" <?php selected( $grid['order_by'], 'date' ); ?>>Date</option>
                                            <option value="ID" <?php selected( $grid['order_by'], 'ID' ); ?>>ID</option>
                                            <option value="author" <?php selected( $grid['order_by'], 'author' ); ?>>Author</option>
                                            <option value="title" <?php selected( $grid['order_by'], 'title' ); ?>>Title</option>
                                            <option value="modified" <?php selected( $grid['order_by'], 'modified' ); ?>>Modified</option>
                                            <option value="rand" <?php selected( $grid['order_by'], 'rand' ); ?>>Random</option>
                                            <option value="comment_count" <?php selected( $grid['order_by'], 'comment_count' ); ?>>Comment count</option>
                                            <option value="menu_order" <?php selected( $grid['order_by'], 'menu_order' ); ?>>Menu order</option>            
                                        </select>					
                                    	<p class="description"><?php _e('Select how to sort retrieved posts. More at
<a target="_blank" href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters"> WordPress codex page</a>','swp-acco');?></p>
                                    </td>
                                    <td style="width:200px;">
                                    	<strong class="afl"><?php _e('Order','swp-acco');?></strong><br>
                                        <select name="order">
                                            <option value="" <?php selected( $grid['order'], '' ); ?>></option>
                                            <option value="ASC" <?php selected( $grid['order'], 'ASC' ); ?>>Ascending</option>
                                            <option value="DESC" <?php selected( $grid['order'], 'DESC' ); ?>>Descending</option>
                                        </select>					
                                    	<p class="description"><?php _e('Designates the ascending or descending order.','swp-acco');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Categories','swp-acco');?></strong><br>
                                        <input type="text" name="cat_id" value="<?php echo $grid['cat_id'];?>"/>
	                                    <p class="description"><?php _e('Filter output by posts categories, enter category ID here. if you add "-" exlude category id.each category add comma separated.eg. 1,4,-5','swp-acco');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Tags','swp-acco');?></strong><br>
                                        <input type="text" name="tag_id" value="<?php echo $grid['tag_id'];?>"/>
	                                    <p class="description"><?php _e('Filter output by posts tags, enter tag ID here. if you add "-" exlude Tag id.each Tag add comma separated.eg. 6,8,-7','swp-acco');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Taxonomies','swp-acco');?></strong><br>
                                        <input type="text" name="taxonomi_name" value="<?php echo $grid['taxonomi_name'];?>"/>
	                                    <p class="description"><?php _e('Filter output by custom taxonomies categories, enter category names here. if you add "-" exlude taxonomies. each Tag add comma separated.eg. -76,89,-5','swp-acco');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Individual Posts/Pages/Custom Post Types','swp-acco');?></strong><br>
                                        <input type="text" name="post_id" value="<?php echo $grid['post_id'];?>"/>
	                                    <p class="description"><?php _e('Only entered posts/pages will be included in the output. Note: Works in conjunction with selected "Post types".if you add "-" exlude taxonomies.each Post,page add comma separated.eg. 5,8,-1,7','swp-acco');?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">		
						<th><strong class="afl"><?php _e('Skin type','spost-grid');?>:</strong></th>	
						<td>	
							<select name="skin_type" id="scarou_skin_type" data-check-depen="yes">
                            	<option value="s1" <?php selected( $grid['skin_type'], 's1' ); ?>>Style1</option>
                                <option value="s2" <?php selected( $grid['skin_type'], 's2' ); ?>>Style2</option>
                                <option value="s3" <?php selected( $grid['skin_type'], 's3' ); ?>>Style3</option>
                                <option value="s4" <?php selected( $grid['skin_type'], 's4' ); ?>>Style4</option>
                                <option value="s5" <?php selected( $grid['skin_type'], 's5' ); ?>>Style5</option>
                                <option value="s6" <?php selected( $grid['skin_type'], 's6' ); ?>>Style6 for List View</option>
                           </select>
					<p class="description"><?php _e('Choose skin type for Carousel layout','spost-grid');?>.</p></td>	
					</tr>
					<tr data-depen-set="true" data-value="carousel" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Select Images','swp-acco');?> :</strong></th>	
						<td>	
						<input type="text" name="images_car" value="<?php echo $grid['images_car'];?>" id="carou_images">
						<input id="upload_image_button" type="button" value="Upload Loader" class="button"/>
						<p class="description"><?php _e('Choose Images for Carousel.','swp-acco');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="video" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Enter Video URL','swp-acco');?> :</strong></th>	
						<td>
						<textarea name="video_car" cols="40"><?php echo $grid['video_car'];?></textarea>
						<p class="description"><?php _e('Enter Youtube, Vimeo URL. Divide each with comma separate.
							ex : https://www.youtube.com/watch?v=BBQCHfQJLKs,https://vimeo.com/76940387,http://www.demo.comdemo.mp4','swp-acco');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="anything" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Enter HTML','swp-acco');?> :</strong></th>	
						<td>
						<?php
						if($grid_data->html == ''){
							$content = '[wp_carousel_html]Content1[/wp_carousel_html][wp_carousel_html]Content2[/wp_carousel_html][wp_carousel_html]Content3[/wp_carousel_html]';
						}else{
							$content = stripslashes_deep($grid_data->html);
						}
							$editor_id = 'anything_html';

							wp_editor( $content, $editor_id );

							?>
						<p class="description"><?php _e('Enter html','swp-acco');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="video" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Set Video Height','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['video_height'];?>" name="video_height" max="1000" min="0">
						<p class="description"><?php _e('Set Video Height. if you set height "0" then work like "auto".','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="carousel" data-id="scarou_svc_type" data-attr="select">		
						<th><strong class="afl"><?php _e('Image View','spost-grid');?>:</strong></th>	
						<td>	
							<select name="image_view">
                            	<option value="square" <?php selected( $grid['image_view'], 'square' ); ?>><?php _e('Square','spost-grid');?></option>
                                <option value="round" <?php selected( $grid['image_view'], 'round' ); ?>><?php _e('Round','spost-grid');?></option>
                           </select>
					<p class="description"><?php _e('Choose Image View','spost-grid');?>.</p></td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Items Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_display_item'];?>" name="car_display_item" max="100" min="1" id="scarou_car_display_item" data-check-depen="yes">
						<p class="description"><?php _e('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width','spost-grid');?></p>
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('items Desktop Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_desktop_display_item'];?>" name="car_desktop_display_item" max="100" min="1">
						<p class="description"><?php _e('Display items between 1199px and 979px','spost-grid');?></p>
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('items Samll Desktop Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_desktopsmall_display_item'];?>" name="car_desktopsmall_display_item" max="100" min="1">
						<p class="description"><?php _e('Display items between 979px and 768px','spost-grid');?></p>
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('items Tablet Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_tablet_display_item'];?>" name="car_tablet_display_item" max="100" min="1">
						<p class="description"><?php _e('Display items between 768px and 479px','spost-grid');?></p>
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('items Mobile Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_mobile_display_item'];?>" name="car_mobile_display_item" max="100" min="1">
						<p class="description"><?php _e('Display items between 479px and 200px','spost-grid');?></p>
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Show pagination','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_pagination" value="yes" <?php checked( $grid['car_pagination'], 'yes' ); ?> id="scarou_car_pagination" data-check-depen="yes"><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Show pagination','spost-grid');?></p>	
						</td>
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="scarou_car_pagination" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Show pagination Numbers','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_pagination_num" value="yes" <?php checked( $grid['car_pagination_num'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Show numbers inside pagination buttons.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Hide navigation','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_navigation" value="yes" <?php checked( $grid['car_navigation'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Display "next" and "prev" buttons.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('AutoPlay','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_autoplay" value="yes" <?php checked( $grid['car_autoplay'], 'yes' ); ?> id="scarou_car_autoplay" data-check-depen="yes"><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Set Slider Autoplay.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="yes" data-id="scarou_car_autoplay" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('autoPlay Time','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_autoplay_time'];?>" name="car_autoplay_time" max="100" min="1"><?php _e('seconds','spost-grid');?>
						<p class="description"><?php _e('Set Autoplay slider speed.','spost-grid');?></p>	
						</td>
					</tr>
					<tr data-depen-set="true" data-value="carousel" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('LazyLoad','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="lazyLoad" value="yes" <?php checked( $grid['lazyLoad'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Set Image Lazy load.','spost-grid');?></p>	
						</td>
					</tr>
					<tr data-depen-set="true" data-value="1" data-id="scarou_car_display_item" data-attr="number">	
						<th><strong class="afl"><?php _e('Synced Slider','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="synced" value="yes" <?php checked( $grid['synced'], 'yes' ); ?> id="scarou_synced" data-check-depen="yes"><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Set Synced Slider.see Example
<a target="_black" href="http://owlgraphic.com/owlcarousel/demos/sync.html">here</a>.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="yes" data-id="scarou_synced" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Synced Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['synced_display'];?>" name="synced_display" max="1000" min="1">
						<p class="description"><?php _e('Set Synces Slider Display elements.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">
                    	<th><strong class="afl"><?php _e('Show more','spost-grid');?></strong></th>
                        <td>
                            <input type="checkbox" value="yes" name="loadmore" <?php checked( $grid['loadmore'], 'yes' ); ?> id="scarou_loadmore" data-check-depen="yes"/><?php _e('Yes','spost-grid');?>
                            <p class="description"><?php _e('add Show more Post last element of Carousel.','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="carousel" data-value1="video" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Margin','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_margin'];?>" name="car_margin" max="1000" min="1">px
						<p class="description"><?php _e('Set Two Element Between Margin.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="1" data-id="scarou_car_display_item" data-attr="number">	
						<th><strong class="afl"><?php _e('Transition effect','spost-grid');?> :</strong></th>	
						<td>	
						<select name="car_transition">
                        	<option value="" <?php selected( $grid['car_transition'], '' ); ?>>None</option>
                            <option value="fade" <?php selected( $grid['car_transition'], 'fade' ); ?>>fade</option>
                            <option value="backSlide" <?php selected( $grid['car_transition'], 'backSlide' ); ?>>backSlide</option>
                            <option value="goDown" <?php selected( $grid['car_transition'], 'goDown' ); ?>>goDown</option>
                            <option value="scaleUp" <?php selected( $grid['car_transition'], 'scaleUp' ); ?>>scaleUp</option>
                        </select>
						<p class="description"><?php _e('Add CSS3 transition style. Works only with one item on screen.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Link target','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_link_target">
                        	<option value="sw" <?php selected( $grid['grid_link_target'], 'sw' ); ?>><?php _e('Same Window','spost-grid');?></option>
                            <option value="nw" <?php selected( $grid['grid_link_target'], 'nw' ); ?>><?php _e('New Window','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('set Link target','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Exclude taxonomies','spost-grid');?>:</strong></th>	
						<td>	
						<input type="text" name="exclude_texo" value="<?php echo $grid['exclude_texo'];?>">
						<p class="description"><?php _e('Enter Exclude taxonomies slug, Divide each with comm separate.get texonomy slug
<a target="_blank" href="http://plugin.saragna.com/vc-addon/wp-content/uploads/2015/04/slug.png">click here</a>','spost-grid');?></p>	
						</td>	
					</tr>
					<tr>
                    	<th><strong class="afl"><?php _e('Thumbnail size','spost-grid');?></strong></th>
                        <td>
							<input type="text" name="grid_thumb_size" value="<?php echo $grid['grid_thumb_size'];?>"/>
                            <p class="description"><?php _e('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="s5" data-id="scarou_skin_type" data-attr="select">
                    	<th><strong class="afl"><?php _e('Minimum Height','spost-grid');?></strong></th>
                        <td>
							<input type="number" step="1" value="<?php echo $grid['s5_min_height'];?>" name="s5_min_height" max="9000" min="0">
                            <p class="description"><?php _e('if you not set fetured image so set Minimum Height for artical.default:150px','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">
                    	<th><strong class="afl"><?php _e('Excerpt Length','spost-grid');?></strong></th>
                        <td>
							<input type="number" step="1" value="<?php echo $grid['svc_excerpt_length'];?>" name="svc_excerpt_length" max="900" min="10">
                            <p class="description"><?php _e('set excerpt length.default:20','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">
                    	<th><strong class="afl"><?php _e('Read More Translate','spost-grid');?></strong></th>
                        <td>
							<input type="text" name="read_more" value="<?php echo $grid['read_more'];?>"/>
                            <p class="description"><?php _e('set Translate for "Read More" text.default : Read More','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="yes" data-id="scarou_loadmore" data-attr="checkbox">
                    	<th><strong class="afl"><?php _e('Show more text','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="loadmore_text" value="<?php echo $grid['loadmore_text'];?>"/>
                            <p class="description"><?php _e('add Show more button text.Default:Show More','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr>
                    	<th><strong class="afl"><?php _e('Extra class name','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="svc_class" value="<?php echo $grid['svc_class'];?>"/>
                            <p class="description"><?php _e('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.','spost-grid');?></p>
                        </td>
                    </tr>
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>

<div id="display_tab" class="spl_tabs">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="anew_slider_setting">	
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Hide Excerpt','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dexcerpt" <?php checked( $grid['dexcerpt'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide Excerpt content.','spost-grid');?></p>	
						</td>	
					</tr>	
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">
						<th><strong class="afl"><?php _e('Hide Category','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dcategory" <?php checked( $grid['dcategory'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide category content.','spost-grid');?></p>	
						</td>	
					</tr>	
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Hide meta data','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dmeta_data" <?php checked( $grid['dmeta_data'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide meta content.like date,author,comment counter.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Hide Social icon','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dsocial" <?php checked( $grid['dsocial'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide social icon.','spost-grid');?></p>	
						</td>	
					</tr>
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>

<div id="color_tab" class="spl_tabs">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="vertical-top">	
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">
						<th><strong class="afl"><?php _e('Post Background Color','spost-grid');?> :</strong></th>	
						<td>	
							<input type="text" class="my-color-field" name="pbgcolor" data-default-color="" value="<?php echo $grid['pbgcolor'];?>"/>	
						<p class="description"><?php _e('set post background color.','spost-grid');?></p></td>	
					</tr>	
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Post hover Background Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="pbghcolor" data-default-color="" value="<?php echo $grid['pbghcolor'];?>"/>	
						<p class="description"><?php _e('set post hover background color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="s1" data-value1="s2" data-value2="s4" data-id="scarou_skin_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Image below / top line color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="line_color" data-default-color="" value="<?php echo $grid['line_color'];?>"/>	
						<p class="description"><?php _e('set Image below / top color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Title Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="tcolor" data-default-color="" value="<?php echo $grid['tcolor'];?>"/>	
						<p class="description"><?php _e('Set Title Color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="scarou_svc_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Title Hover Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="thcolor" data-default-color="" value="<?php echo $grid['thcolor'];?>"/>	
						<p class="description"><?php _e('Set Title Hover Color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Navigation and Pagination color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="car_navigation_color" data-default-color="" value="<?php echo $grid['car_navigation_color'];?>"/>	
						<p class="description"><?php _e('Set Navigation and Pagination color','spost-grid');?>.</p>	
						</td>	
					</tr>
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>


<?php if(isset($_GET['sid'])){?>
<input type="submit" class="button-primary spost_button" value="<?php _e('Update Setting','swp-acco');?>" name="scarou_Update_Setting" style="width:100%;">
<?php }else{?>
<input type="submit" class="button-primary spost_button" value="<?php _e('Save Setting','swp-acco');?>" name="scarou_save_Setting" style="width:100%;">
<?php }?>
