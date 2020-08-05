<div id="top-newsletter" style="padding-left: 15px;padding-right: 15px">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 lside">
                <span><?php echo $module['content']['title']; ?></span>
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-6 rside">
                <div class="rside-text">
                    <?php echo $module['content']['text']; ?>
                </div>
                <div class="rside-form">
                    <input type="email" class="email" placeholder="<?php echo $module['content']['input_placeholder']; ?>">
                    <button class="subscribe" type="submit"><?php echo $module['content']['subscribe_text']; ?></button>
                </div>
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div><!-- End #top-newsletter -->

<script type="text/javascript">
$(document).ready(function() {
	function Unsubscribe() {
		$.post('<?php echo $module['content']['unsubscribe_url']; ?>', 
			{ 
				email: $('#top-newsletter .email').val() 
			}, function (e) {
				$('#top-newsletter .email').val('');
				alert(e.message);
			}
		, 'json');
	}
	
	function Subscribe() {
		$.post('<?php echo $module['content']['subscribe_url']; ?>', 
			{ 
				email: $('#top-newsletter .email').val() 
			}, function (e) {
				if(e.error === 1) {
					var r = confirm(e.message);
					if (r == true) {
					    $.post('<?php echo $module['content']['unsubscribe_url']; ?>', { 
					    	email: $('#top-newsletter .email').val() 
					    }, function (e) {
					    	$('#top-newsletter .email').val('');
					    	alert(e.message);
					    }, 'json');
					}
				} else {
					$('#top-newsletter .email').val('');
					alert(e.message);
				}
			}
		, 'json');
	}
	
	$('#top-newsletter .subscribe').click(Subscribe);
	$('#top-newsletter .unsubscribe').click(Unsubscribe);
	$('#top-newsletter .email').keypress(function (e) {
	    if (e.which == 13) {
	        Subscribe();
	    }
	});
});
</script>