<h2 class="slider-title">
    <span class="inline-title"><?php echo $module['content']['title']; ?></span>
</h2>

<div class="owl-carousel post-carousel close-dots">
	<?php foreach($module['content']['articles'] as $article) { ?>
    <div class="post-item clearfix">
        <div class="post-date">
            <span class="day"><?php echo date('d', strtotime($article['date_published'])); ?></span>
            <span class="month"><?php echo date('M', strtotime($article['date_published'])); ?></span>
        </div><!-- end .post-date -->
        <h4>
            <a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a>
        </h4>
        <p class="post-excerpt"><?php echo ciach($article['description'], 120); ?></p>
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