<?php
/**
 * 
 * Security check. No one can access without Wordpress itself
 * 
 * */
defined('ABSPATH') or die();

?>

<div class='bootstart-admin-footer'>
	
	<ul>
		
		<li><a href='http://www.giribaz.com/support/' target='blank'>Support</a></li>
		<li><a href='https://wordpress.org/support/view/plugin-reviews/file-manager?rate=5#postform' target='blank'>Review</a></li>
		
	</ul>
	
	<?php if(!defined('FILE_MANAGER_PREMIUM')): ?>
	<div class="fm_permission_system_advert">
		
		<span>
			
			<strong>Extend</strong> File Manager for <strong>frontend</strong>. Enable your <strong>users</strong> to upload files with full <strong>control</strong> of what they can upload and download. And many more features. <a style='color:#31A6CB;' href='http://www.giribaz.com?referral=from_dashboard_link'>Take a look</a>
			
		</span>
		
		<a target='bland' data-lightbox="image-1" data-title="My caption" href='<?php echo $this->url('/img/permission-system-backend.png'); ?>' ><img data-lightbox="image-1" data-title="My caption" src='<?php echo $this->url('/img/permission-system-backend.png'); ?>' /></a>
		
	</div>
	<?php endif; ?>
	
</div>

<?php if(!defined('FILE_MANAGER_PREMIUM')): ?>
<div class='footer-sticky-button'>
	<a href='http://www.giribaz.com/' target='blank'>Get File Manager Pro</a>
</div>
<?php endif; ?>
