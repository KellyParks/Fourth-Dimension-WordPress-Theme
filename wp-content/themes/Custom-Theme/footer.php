<footer role="contentinfo" id="contact" class="remodal-bg">
	<div class="container">
		<div class="far-left-container">
			<?php dynamic_sidebar('footer-logo-and-contact-info'); ?>
		</div>
		<?php dynamic_sidebar('footer-form'); ?>
		<?php dynamic_sidebar('footer-map'); ?>
	</div>
	<p>&#9400; <?php echo date("Y"); ?> Fourth Dimension Construction Ltd.</p>
</footer>
<?php wp_footer(); ?>
<script>
  var nav = responsiveNav(".nav-collapse", {
  	closeOnNavClick: true
  });
</script>
<script>
$(document).ready(function(){

	$('article').on('click', function(){
		var id = $(this).data('popup-target');
		$('html, body').animate({scrollTop: 0}, 500);
		$('.popup-container').addClass('hide');
		$('div#' + id).removeClass('hide');
	});
	
	$('.closepopup').on('click', function(){
		$('.popup-container').addClass('hide');
		window.location.hash="";
		
	});
	
	$("a[href$='contact']").on('click', function(){
		$('.popup-container').addClass('hide');
	});
	
	function showModal(elem) {
        	elem.removeClass('hide');
    	}

    	function hideOpenModals() {
        	$('.popup-container').addClass('hide');
    	}

	function handleHashChangeEvent() {
    		var id = location.hash.replace('#', '');
    		var instance;
    		var $elem;

    		if (!id) {
    			hideOpenModals();
    		} else {

      // Catch syntax error if your hash is bad

      			try {
      				$elem = $('div#' + id);
      			} catch (err) {
      			}
      		
      			if ($elem && $elem.length) {
          			hideOpenModals();
          			showModal($elem);
      			}

    		}

  	}

        $(window).on('hashchange', handleHashChangeEvent);

        handleHashChangeEvent();

});
</script>
</body>
</html>
