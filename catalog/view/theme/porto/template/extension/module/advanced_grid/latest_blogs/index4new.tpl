<h2 class="slider-title index4newposts-title">
    <span class="inline-title"><?php echo $module['content']['title']; ?></span>
</h2>

<div class="owl-carousel post-carousel index4newposts close-dots">
	<?php foreach($module['content']['articles'] as $article) { ?>
    <div class="post-item2 clearfix">
    	<div class="row">
    		<div class="col-sm-5">
		    	<div class="post-image">
		    	    <a href="<?php echo $article['href']; ?>">
		    	        <img src="<?php echo $article['thumb']; ?>" alt="Post">
		    	    </a>
		    	    
		    	    <div class="post-date">
		    	        <span class="day"><?php echo date('d', strtotime($article['date_published'])); ?></span>
		    	        <span class="month"><?php echo date('M', strtotime($article['date_published'])); ?></span>
		    	    </div><!-- end .post-date -->
		    	</div>
		    </div>
		   	
		   	<div class="col-sm-7">
		        <h4>
		            <a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a>
		        </h4>
		        <p class="post-excerpt"><?php echo ciach($article['description'], 120); ?></p>
		        <a href="<?php echo $article['href']; ?>" class="readmore"><?php if($theme_options->get( 'readmore_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'readmore_text', $config->get( 'config_language_id' ) )); } else { echo 'Read more'; } ?></a>
		    </div>
		 </div>
    </div><!-- end .post-item -->
    <?php } ?>
</div><!-- End .owl-carousel -->
<?php 
function ciach($tresc,$ile) 
{ 
    // obliczamy ilość znaków w tekscie 
    $licz = strlen($tresc); 
    // sprawdzamy, czy ilość znaków w tekscie jest większa
    // lub równa liczbie znaków po jakiej tekst ma być obcięty 
    if ($licz>=$ile) 
    { 
        // obcinamy tekst o określoną ilośc znaków 
        $tnij = substr($tresc,0,$ile); 
        // dodajemy kropeczki (...) 
        $txt = $tnij."..."; 
    } 
    else 
    { 
        // jeżeli warunek nie jest spełniony pozostawiamy tekst bez zmian 
        $txt = $tresc; 
    } 
    // zwracamy wynik działania funkcji 
    return $txt; 
} 
?>