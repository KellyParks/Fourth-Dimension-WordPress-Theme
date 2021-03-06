<?php
add_action('wp_head','swp_carou_inline_css_for_imageloaded');
function swp_carou_inline_css_for_imageloaded(){
	?>
    <style>
	.svc_post_grid_list_container{ display:none;}
	#loader {background-image: url("<?php echo plugins_url('../assets/css/loader.GIF',__FILE__);?>");}
	</style>
    <?php	
}

function swp_carou_grid_delete(){
	global $wpdb,$swp_carou_tables;
	$slider_table = $wpdb->base_prefix.$swp_carou_tables;
	$id = intval($_POST['id']);
	$wpdb->delete($slider_table,array('id'=>$id));
die();
}
add_action('wp_ajax_swp_carou_grid_delete', 'swp_carou_grid_delete' );

function wp_carousel_layout_excerpt($excerpt,$limit) {
	$excerpt = strip_tags($excerpt);
	$excerpt = explode(' ', $excerpt, $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

add_action('wp_ajax_swp_layout_carousel','swp_layout_carousel');
add_action('wp_ajax_nopriv_swp_layout_carousel','swp_layout_carousel');
function swp_layout_carousel(){
	extract($_POST);
	echo do_shortcode('[swp_carou svc_type="'.$svc_type.'" query_loop="'.$query_loop.'" grid_link_target="'.$grid_link_target.'" grid_layout_mode="'.$grid_layout_mode.'" grid_thumb_size="'.$grid_thumb_size.'" svc_excerpt_length="'.$svc_excerpt_length.'" skin_type="'.$skin_type.'" title="'.$title.'" read_more="'.$read_more.'" svc_class="'.$svc_class.'" dexcerpt="'.$dexcerpt.'" dcategory="'.$dcategory.'" dmeta_data="'.$dmeta_data.'" dsocial="'.$dsocial.'" pbgcolor="'.$pbgcolor.'" pbghcolor="'.$pbghcolor.'" tcolor="'.$tcolor.'" thcolor="'.$thcolor.'" paged="'.$paged.'" svc_grid_id="'.$svc_grid_id.'" ajax="1"]');
	die();
}

function swp_carousel_video($url,$video_height){
	$yt = swp_carousel_is_youtube($url);
	$v = swp_carousel_is_vimeo($url);
	$ov = swp_other_video_url($url);
	if($video_height == 0){ $video_height = '';}
	if($yt == 1 || $yt){
		$ytarray=explode("/", $url);
		$ytendstring=end($ytarray);
		$ytendarray=explode("?v=", $ytendstring);
		$ytendstring=end($ytendarray);
		$ytendarray=explode("&", $ytendstring);
		$ytcode=$ytendarray[0];
		return '<iframe width="100%" height="'.$video_height.'" src="http://www.youtube.com/embed/'.$ytcode.'?autohide=1" frameborder="0" allowfullscreen></iframe>';
	}
	if($v == 1 || $v){
		$varray=explode("/", $url);
		$vcode=end($varray);		
		return '<iframe src="https://player.vimeo.com/video/'.$vcode.'?color=ae8a38&title=0&byline=0&portrait=0" width="100%" height="'.$video_height.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	}
	if($ov == 1 || $ov){
		return ' <video width="100%" height="'.$video_height.'" controls>
				  <source src="'.$url.'" type="video/mp4">
				Your browser does not support the video tag.
				</video>';	
	}
}
function swp_carousel_is_youtube($url){
	return (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url));
}
function swp_carousel_is_vimeo($url){
	return (preg_match('/vimeo\.com/i', $url));
}
function swp_other_video_url($url){
	$filename = $url;
	$ext = end(explode('.', $filename));
	if($ext == 'mp4'){
		return true;	
	}
}
function swp_video_image($url){
    $image_url = parse_url($url);
    if($image_url['host'] == 'www.youtube.com' || $image_url['host'] == 'youtube.com'){
        $array = explode("&", $image_url['query']);
        return "http://img.youtube.com/vi/".substr($array[0], 2)."/0.jpg";
    } else if($image_url['host'] == 'www.vimeo.com' || $image_url['host'] == 'vimeo.com'){
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".substr($image_url['path'], 1).".php"));
		//echo "<pre>";print_r($hash);
        return $hash[0]["thumbnail_large"];
    } else{
		return plugins_url( '../addons/carousel/css/one_pix.jpg', __FILE__ );	
	}
}
?>
