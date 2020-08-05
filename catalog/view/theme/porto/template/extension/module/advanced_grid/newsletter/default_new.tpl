<div class="widget newsletter2-widget" id="newsletter<?php echo $id; ?>">
    <div class="row">
    	<div class="col-sm-6">
    		<h3 class="widget-title"><?php echo $module['content']['title']; ?></h3>
    		<p><?php echo $module['content']['text']; ?></p>
    	</div>
    	
    	<div class="col-sm-6">
    		<div class="overflow-inputs">
    			<input type="email" class="email" placeholder="<?php echo $module['content']['input_placeholder']; ?>">
    			<input type="submit" class="subscribe btn" value="<?php echo $module['content']['subscribe_text']; ?>">
    		</div>
    	</div>
    </div>
</div><!-- End .widget -->

<script type="text/javascript">
$(document).ready(function() {
	function Unsubscribe() {
		$.post('<?php echo $module['content']['unsubscribe_url']; ?>', 
			{ 
				email: $('#newsletter<?php echo $id; ?> .email').val() 
			}, function (e) {
				$('#newsletter<?php echo $id; ?> .email').val('');
				alert(e.message);
			}
		, 'json');
	}
	
	function Subscribe() {
		$.post('<?php echo $module['content']['subscribe_url']; ?>', 
			{ 
				email: $('#newsletter<?php echo $id; ?> .email').val() 
			}, function (e) {
				if(e.error === 1) {
					var r = confirm(e.message);
					if (r == true) {
					    $.post('<?php echo $module['content']['unsubscribe_url']; ?>', { 
					    	email: $('#newsletter<?php echo $id; ?> .email').val() 
					    }, function (e) {
					    	$('#newsletter<?php echo $id; ?> .email').val('');
					    	alert(e.message);
					    }, 'json');
					}
				} else {
					$('#newsletter<?php echo $id; ?> .email').val('');
					alert(e.message);
				}
			}
		, 'json');
	}
	
	$('#newsletter<?php echo $id; ?> .subscribe').click(Subscribe);
	$('#newsletter<?php echo $id; ?> .unsubscribe').click(Unsubscribe);
	$('#newsletter<?php echo $id; ?> .email').keypress(function (e) {
	    if (e.which == 13) {
	        Subscribe();
	    }
	});
});
</script>