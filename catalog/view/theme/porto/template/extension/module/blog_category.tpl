<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
?>
<div class="box box-with-categories box-no-advanced category-box-type-2 blog-module <?php if($theme_options->get( 'category_box_style' ) == '2') { echo 'category-box-type-3'; } ?>">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="strip-line"></div>
    <div class="box-content box-category">
        <ul class="accordion" id="accordion-category">
            <?php
            $i = 0;
            foreach ($categories as $category) {
                $i++;
                ?>
                <li class="panel">
                    <?php if ($category['category_id'] == $category_id) { ?>
                        <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
                    <?php } else { ?>
                        <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                    <?php } ?>
                        <?php $categories_2 = $category['children']; ?>
                        <?php if ($categories_2) { ?>
                        <span class="head"><a style="float:right;padding-right:5px" class="accordion-toggle<?php
                                              if ($category['category_id'] != $category_id) {
                                                  echo ' collapsed';
                                              }
                                              ?>" data-toggle="collapse" data-parent="#accordion-category" href="#category<?php echo $i; ?>"><span class="plus">+</span><span class="minus">-</span></a></span>
                                <?php if (!empty($categories_2)) { ?>
                            <div id="category<?php echo $i; ?>" class="panel-collapse collapse <?php echo  ($category['category_id'] == $category_id ?'in' : '');?>" style="clear:both">
                                <ul>
                                <?php foreach($categories_2 as $child): ?>
                                    <li>
                                    <?php if ($child['category_id'] == $child_id): ?>
                                    <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
                                    <?php else: ?>
                                    <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                                    <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
        <?php } ?>
    <?php } ?>
                </li>
<?php } ?>
        </ul>
    </div>
</div>
