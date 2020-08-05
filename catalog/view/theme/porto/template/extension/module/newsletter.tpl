<div class="widget newsletter-widget-box" id="newsletter<?php echo $module_id; ?>">
    <div class="box-content">
        <h3 class="widget-title"><?php echo $module_title; ?></h3>
        <p><?php if($module_text != '') echo $module_text; ?></p>
        <form action="#">
            <input type="text" class="email" placeholder="<?php echo $input_placeholder; ?>" required>
            <input type="submit" class="subscribe" value="<?php echo $subscribe_text; ?>">
        </form>
    </div><!-- End .box-content -->
</div><!-- End .widget -->

<script type="text/javascript">
$(document).ready(function() {
	function Unsubscribe() {
		$.post('<?php echo $unsubscribe_url; ?>', 
			{ 
				email: $('#newsletter<?php echo $module_id; ?> .email').val() 
			}, function (e) {
				$('#newsletter<?php echo $module_id; ?> .email').val('');
				alert(e.message);
			}
		, 'json');
	}
	
	function Subscribe() {
		$.post('<?php echo $subscribe_url; ?>', 
			{ 
				email: $('#newsletter<?php echo $module_id; ?> .email').val() 
			}, function (e) {
				if(e.error === 1) {
					var r = confirm(e.message);
					if (r == true) {
					    $.post('<?php echo $unsubscribe_url; ?>', { 
					    	email: $('#newsletter<?php echo $module_id; ?> .email').val() 
					    }, function (e) {
					    	$('#newsletter<?php echo $module_id; ?> .email').val('');
					    	alert(e.message);
					    }, 'json');
					}
				} else {
					$('#newsletter<?php echo $module_id; ?> .email').val('');
					alert(e.message);
				}
			}
		, 'json');
	}
	
	$('#newsletter<?php echo $module_id; ?> .subscribe').click(Subscribe);
	$('#newsletter<?php echo $module_id; ?> .unsubscribe').click(Unsubscribe);
	$('#newsletter<?php echo $module_id; ?> .email').keypress(function (e) {
	    if (e.which == 13) {
	        Subscribe();
	    }
	});
});
</script>