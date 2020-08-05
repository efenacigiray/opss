<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); ?>

<?php if ($orders) { ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-right"><?php echo $column_order_id; ?></td>
        <td class="text-left"><?php echo $column_customer; ?></td>
        <td class="text-right"><?php echo $column_product; ?></td>
        <td class="text-left"><?php echo $column_status; ?></td>
        <td class="text-right"><?php echo $column_total; ?></td>
        <td class="text-left"><?php echo $column_date_added; ?></td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order) { ?>
      <tr>
        <td class="text-right">#<?php echo $order['order_id']; ?></td>
        <td class="text-left"><?php echo $order['name']; ?></td>
        <td class="text-right"><?php echo $order['products']; ?></td>
        <td class="text-left"><?php echo $order['status']; ?></td>
        <td class="text-right"><?php echo $order['total']; ?></td>
        <td class="text-left"><?php echo $order['date_added']; ?></td>
        <td class="text-right"><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>
<?php } else { ?>
<p><?php echo $text_empty; ?></p>
<?php } ?>
<div class="buttons clearfix">
  <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
</div>
  
<?php include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>