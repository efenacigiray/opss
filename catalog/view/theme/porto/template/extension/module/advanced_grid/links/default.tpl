<?php 
if($position == 'footer_bottom' || $position == 'footer' || $position == 'footer_top' || $position == 'footer_left' || $position == 'footer_right' || $position == 'customfooter_top' || $position == 'customfooter_bottom' || $position == 'customfooter') {
	echo '<h4>'.$module['content']['title'].'</h4>';
	echo '<div class="strip-line"></div>';
	
	$count_columns = ceil(count($module['content']['links'])/$module['content']['limit']);
	$class = 3; 
	
	if($count_columns == 1) $class = 12;
	if($count_columns == 2) $class = 6;
	if($count_columns == 3) $class = 4;
	if($count_columns == 4) $class = 3;
	if($count_columns == 5) $class = 25;
	if($count_columns == 6) $class = 2;
	
	echo '<div class="row" style="clear: both">';
	     echo '<div class="col-sm-' . $class . '">';
	          echo '<ul>';
	               $i = 0;
               	foreach($module['content']['links'] as $link) {
               	     if($module['content']['limit'] == $i) {
               	          $i = 0;
               	          echo '</ul></div><div class="col-sm-' . $class . '"><ul>';
               	     }
               	     
               	     echo '<li><a href="' . $link['url'] . '">' . $link['name'] . '</a></li>';
               	     $i++;
               	}
               echo '</ul>';
          echo '</div>';
     echo '</div>';
} else {
	echo '<div class="box">';
		echo '<div class="box-heading">';
			echo $module['content']['title'];
		echo '</div>';
		echo '<div class="strip-line"></div>';
		echo '<div class="box-content">';
			$count_columns = ceil(count($module['content']['links'])/$module['content']['limit']);
			$class = 3; 
			
			if($count_columns == 1) $class = 12;
			if($count_columns == 2) $class = 6;
			if($count_columns == 3) $class = 4;
			if($count_columns == 4) $class = 3;
			if($count_columns == 5) $class = 25;
			if($count_columns == 6) $class = 2;
			
			echo '<div class="row">';
			     echo '<div class="col-sm-' . $class . '">';
			          echo '<ul>';
			               $i = 0;
			          	foreach($module['content']['links'] as $link) {
			          	     if($module['content']['limit'] == $i) {
			          	          $i = 0;
			          	          echo '</ul></div><div class="col-sm-' . $class . '"><ul>';
			          	     }
			          	     
			          	     echo '<li><a href="' . $link['url'] . '">' . $link['name'] . '</a></li>';
			          	     $i++;
			          	}
			          echo '</ul>';
			     echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';	
} ?>