<script type="text/javascript">
jQuery(function($){
	$('.delete_level').click(function(){
		var r = confirm("Confirm Delete this Carousel!");
		if (r == true) {
			var id = $(this).attr('id');
			$.ajax({
				type:'POST',
				url: "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php",
				data: "action=swp_carou_grid_delete&id="+id,
				success: function(m){
					$('#field_id_'+id).slideUp().remove();
				}
			});
		}
	});
});
</script>

<?php 

$res = $wpdb->get_results("select * from ".self::$table_prefix.self::SWP_CAROU_NAMES);

	if(count($res) > 0 ){?>
		<a href="<?php echo self::plugin_root_url();?>&amp;view=setting" class="button-primary afr" style="margin-bottom:10px;">Create New Carousel</a>
		<table class="widefat">
			<thead>
				<tr>
					<th>No.</th>
					<th>Carousel Name</th>
					<th>Shortcode</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php $i = 1;
			foreach($res as $slider){
			$levels = $wpdb->get_results("select * from ".self::$table_prefix.self::SWP_CAROU_NAMES." where id=".$slider->id);?>
			   <tr id="field_id_<?php echo $slider->id;?>">
				 <td><?php echo $i;?></td>
				 <td><?php echo $slider->slider_title;?></td>
				 <td><?php echo '[swp_carou_data id="'.$slider->id.'"]';?></td>
				 <td><a href="<?php echo self::plugin_root_url();?>&amp;view=setting&amp;sid=<?php echo $slider->id;?>" class="edit_layers">Settings</a>
				 <a href="javascript:;" id="<?php echo $slider->id;?>" class="delete_level">Delete Carousel</a>
				 </td>
			   </tr>
			<?php $i++;}?>
			</tbody>
		</table>
	<?php }else{?>
	<div align="center">
		<p>No Carousel Found</p>
		<a href="<?php echo self::plugin_root_url();?>&amp;view=setting" class="button-primary">Create New Carousel</a>	
	</div>
<?php }?>
