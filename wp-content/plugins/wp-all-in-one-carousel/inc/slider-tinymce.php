<?php
/*	 TinyMCE Shortcode Custom Button Settings
 *   Author: Saragna
 *   Profile: http://codecanyon.net/user/saragna?ref=saragna
 */
/**
 * tinymce external plugin js file
 */
function swp_carou_add_tinymce_plugin($plugin_array) {
	$plugin_array['swpcaroushortcodes'] = plugins_url( ltrim( '../assets/js/slider-tinymce.js', '/' ), __FILE__ );
	return $plugin_array;
}
/**
 * tinymce add buttons
 */
function swp_carou_add_tinymce_button($buttons) {
	array_push($buttons, 'swpcaroushortcodes');
	return $buttons;
}

/**
 * Adding tinymce
 */
function swp_carou_add_tinymce() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
		return;
		
	add_filter('mce_external_plugins', 'swp_carou_add_tinymce_plugin');
	add_filter('mce_buttons', 'swp_carou_add_tinymce_button');
}
add_action('admin_head', 'swp_carou_add_tinymce');

function swp_carou_print_shortcodes_in_js() {	
	global $wpdb,$swp_carou_tables;
	$shortcodes = $wpdb->get_results("select * from ".$wpdb->prefix.$swp_carou_tables);
	?>
	<style type="text/css">.mce-i-spost-grid { background:url(<?php echo plugins_url( ltrim( '../assets/image/icon.png', '/' ), __FILE__ );?>) no-repeat !important; }</style>
	<script type="text/javascript">
		var swp_carou_shortcodes = [];
		<?php if($shortcodes) {
			$shortcode_count = 0;
			foreach($shortcodes as $shortcode) { ?>
				swp_carou_shortcodes[<?php echo $shortcode_count; ?>] = {
					'text'		: '<?php echo ($shortcode_count+1).': '.$shortcode->slider_title; ?>',
					'onclick'	: function() {
						tinymce.execCommand('mceInsertContent', false, '[swp_carou_data id="<?php echo $shortcode->id; ?>"]');
					}
				}
		<?php $shortcode_count++;
			}
		}?>
	</script>
	<?php
}
add_action('admin_head', 'swp_carou_print_shortcodes_in_js');
