<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
          <button type="submit" form="form-discount" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title_m; ?></h1>
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
          </ul>
       </div>
      </div>
      <div class="container-fluid">
      <?php if ($error_warning) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
      <?php } ?>
      <?php if ($success) { ?>
          <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
      <?php } ?>
      <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_list; ?></h3>
          </div>
          <div class="panel-body"><form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-discount" class="form-horizontal">
              <div class="form-group">
              <label class="col-sm-2 control-label" for="input-group"><?php echo $entry_customer_group; ?></label>
              <div class="col-sm-10">
                <select name="mass_discount_customer_group" class="form-control">
                  <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php if ($customer_group['customer_group_id'] == $mass_discount_customer_group) { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

		
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-discount"><?php echo $entry_discount_rate; ?></label>
          <div class="col-sm-10">
            <input placeholder="İndirim / Arttırım Oranı" type="text" name="mass_discount_rate" value="<?php echo $mass_discount_rate; ?>" size="1" class="form-control" /> 
			<?php echo $entry_discount_note; ?>
          </div>
        </div>
              <div class="form-group">
              <label class="col-sm-2 control-label" for="input-group"><?php echo $entry_options; ?></label>
              <div class="col-sm-10">
                <select name="product_options" class="form-control">
                      <option value="0" selected="selected"><?php echo $entry_options_hayir; ?></option>
                      <option value="1"><?php echo $entry_options_evet; ?></option>
                </select>
              </div>
            </div>
		<div class="form-group">
          <label class="col-sm-2 control-label" for="input-location"><?php echo $entry_manufacturer; ?></label>
          <div class="col-sm-10">

            <div id="featured-product" class="well well-sm" style="height: 150px; overflow: auto;">
              <?php $class = 'odd'; ?>
              <?php foreach ($manufacturers as $manufacturer) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                <?php if (in_array($manufacturer['manufacturer_id'], $product_manufacturer)) { ?>
                  <input type="checkbox" name="product_manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                  <?php echo $manufacturer['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="product_manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                  <?php echo $manufacturer['name']; ?>
                <?php } ?>
                </div>
              <?php } ?>
            </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a><br />
          </div>
        </div>

        
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-location"><?php echo $entry_category; ?></label>
          <div class="col-sm-10">

            <div id="featured-product" class="well well-sm" style="height: 150px; overflow: auto;">
              <?php $class = 'odd'; ?>
              <?php foreach ($categories as $category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                <?php if (in_array($category['category_id'], $product_category)) { ?>
                  <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                  <?php echo $category['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                  <?php echo $category['name']; ?>
                <?php } ?>
                </div>
              <?php } ?>
            </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a><br />
            </div>
        </div>

         
        <div class="form-group" style="display:none;">
        <label class="col-sm-2 control-label" for="input-location"><?php echo $entry_start_date; ?></label>
          <div class="col-sm-10">

            <div class="input-group date">
              <input class="form-control" type="text" data-format="YYYY-MM-DD" placeholder="Date Start" value="<?php echo $mass_discount_start_date; ?>" name="mass_discount_start_date">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
              </span>
            </div>
            

            <input type="hidden" name="mass_discount_status" value="1"> 
          </div>
        </div>

        <div class="form-group" style="display:none;">
        <label class="col-sm-2 control-label" for="input-location"><?php echo $entry_expires_date; ?></label>
          <div class="col-sm-10">

            <div class="input-group date">
              <input class="form-control" type="text" data-format="YYYY-MM-DD" placeholder="Date End" value="<?php echo $mass_discount_expires_date; ?>" name="mass_discount_expires_date">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
              </span>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script>
<?php echo $footer; ?>