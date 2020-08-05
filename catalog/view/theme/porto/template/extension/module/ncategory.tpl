<div class="box">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="strip-line"></div>
	<div class="box-content box-category">
		<ul class="accordion" id="accordion-category">
		  <li class="panel"><a href="<?php echo $headlines; ?>"><?php echo $button_headlines; ?></a></li>
		  <?php if ($ncategories) { ?>
			  <?php $i = 0; foreach ($ncategories as $ncategory) { $i++; ?>
				  <li class="panel">
				    <?php if ($ncategory['ncategory_id'] == $ncategory_id) { ?>
				    		<a class="active" href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a>
				    <?php } else { ?>
				    		<a href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a>
				    <?php } ?>

				    <?php if ($ncategory['children']) { ?>
					    <span class="head"><a style="float:right;padding-right:5px" class="accordion-toggle<?php if ($ncategory['ncategory_id'] != $ncategory_id) { echo ' collapsed'; } ?>" data-toggle="collapse" data-parent="#accordion-category" href="#category<?php echo $i; ?>"><span class="plus">+</span><span class="minus">-</span></a></span>
					    <?php if(!empty($ncategory['children'])) { ?>
						    <div id="category<?php echo $i; ?>" class="panel-collapse collapse <?php if ($ncategory['ncategory_id'] == $ncategory_id) { echo 'in'; } ?>" style="clear:both">
						    	<ul>
							       <?php foreach ($ncategory['children'] as $child) { ?>
							        <li>
							         <?php if ($child['ncategory_id'] == $child_id) { ?>
							              <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
							         <?php } else { ?>
							              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
							         <?php } ?>
							        </li>
							       <?php } ?>
						        </ul>
						    </div>
					    <?php } ?>
				    <?php } ?>
				  </li>
			  <?php } ?>
		  <?php } ?>
		</ul>
    </div>
</div>