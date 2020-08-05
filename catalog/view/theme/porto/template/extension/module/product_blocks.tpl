<?php if($type == 1) { echo $text; } else { ?>
<a href="javascript:openPopup('<?php echo $popup_module; ?>', '<?php echo $product_id; ?>')" class="button button-enquiry">
     <?php if($icon != '' && $icon_position == 'left') { echo '<img src="image/' . $icon. '" align="left" class="icon-enquiry" alt="Icon">'; } ?>
     <span class="text-enquiry"><?php echo $block_name; ?></span>
     <?php if($icon != '' && $icon_position == 'right') { echo '<img src="image/' . $icon. '" align="right" class="icon-enquiry" alt="Icon">'; } ?>
</a>
<?php } ?>