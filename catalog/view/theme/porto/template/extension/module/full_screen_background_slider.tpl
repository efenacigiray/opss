<script type="text/javascript">
	$.vegas('slideshow', {
	  delay: 8000,
	  backgrounds:[
	  	<?php foreach($slider['content'] as $sliders) {
	  		if($sliders[$language_id]['status'] == 1) { 
	  			echo "{src : 'image/" . $sliders[$language_id]['slider'] . "', fade: 500},";
	  		}
	  	}
	  	?>
	  ]
	})('overlay');
</script>