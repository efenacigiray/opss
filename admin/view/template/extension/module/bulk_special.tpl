<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
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
      <div class="panel-heading clearfix">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?> </h3>
        <a href="javascript:void(0)" id="bulk-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary pull-right"><i class="fa fa-save"></i></a>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bulk-category" class="form-horizontal">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-category"><?php echo $entry_customer_group; ?></label>
            <div class="col-sm-10">
              <select name="bulk_special_cutomer_group" class="form-control">
              <?php foreach ($customer_groups as $customer_group) { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo ($bulk_special_cutomer_group == $customer_group['customer_group_id']) ? 'selected': ''; ?> ><?php echo $customer_group['name']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-category"><?php echo $entry_category; ?></label>
            <div class="col-sm-10">
              <select name="bulk_special_category" class="form-control">
              <option value="0"><?php echo $text_all; ?></option>
              <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['category_id']; ?>" <?php echo ($bulk_special_category == $category['category_id']) ? 'selected':''; ?> ><?php echo $category['name']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-manufacturer"><?php echo $entry_manufacturer; ?></label>
            <div class="col-sm-10">
              <select name="bulk_special_manufacturer" class="form-control">
              <option value="0"><?php echo $text_all; ?></option>
              <?php foreach ($manufacturers as $manufacturer) { ?>
                <option value="<?php echo $manufacturer["manufacturer_id"]; ?>" <?php echo ($bulk_special_manufacturer == $manufacturer["manufacturer_id"]) ? 'selected':''; ?> ><?php echo $manufacturer['name']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-bulk-special-date-start"><?php echo $entry_date_start; ?></label>
            <div class="col-sm-10">
              <div class="input-group date">
                <input type="text" name="bulk_special_date_start" value="<?php echo $bulk_special_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-bulk-special-date-end"><?php echo $entry_date_end; ?></label>
            <div class="col-sm-10">
              <div class="input-group date">
                <input type="text" name="bulk_special_date_end" value="<?php echo $bulk_special_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-bulk-special-discount-type"><?php echo $entry_discount_type; ?></label>
            <div class="col-sm-10">
              <select name="bulk_special_discount_type" class="form-control">
              <?php if($bulk_special_discount_type == 'minus') { ?>
              <option value="percentage"><?php echo $text_pecentage; ?></option>
              <option value="minus" selected="selected"><?php echo $text_minus; ?></option>
              <?php } else { ?>
              <option value="percentage" selected="selected"><?php echo $text_pecentage; ?></option>
              <option value="minus"><?php echo $text_minus; ?></option>
              <?php } ?>

              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-bulk-special-price-range"><span data-toggle="tooltip" title="<?php echo $text_help_price_range; ?>"><?php echo $text_price_range; ?></span></label>
            <div class="col-sm-10">
              <div class="row">

                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-6 control-label" for="input-name-bulk-special-price-range"><?php echo $entry_price_start; ?></label>
                    <div class="col-sm-6">
                      <input type="text" name="bulk_special_price_start" value="<?php echo $bulk_special_price_start; ?>" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-6 control-label" for="input-name-bulk-special-price-range"><?php echo $entry_price_end; ?></label>
                    <div class="col-sm-6">
                      <input type="text" name="bulk_special_price_end" value="<?php echo $bulk_special_price_end; ?>" class="form-control">
                    </div>
                  </div>
                </div>

              </div>
              
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name-bulk-special-price"><span data-toggle="tooltip" title="<?php echo $text_help_delete; ?>"><?php echo $entry_dicount_value; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="bulk_special_price" value="<?php echo $bulk_special_price; ?>" class="form-control">
              
              <?php if ($error_bulk_special_price) { ?>
                <div class="text-danger"><?php echo $error_bulk_special_price; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-bulk-special-discount-previous"><?php echo $entry_discount_previous; ?></label>
            <div class="col-sm-10">
              <select name="bulk_special_discount_previous" class="form-control">
              <?php if($bulk_special_discount_previous) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>

              </select>
            </div>
          </div>
          

        </form>
        <br><br>
        <?php $special_row = 0; ?>
        <h1><?php echo $text_add_individual;?></h1>
        <form action="<?php echo $action_individual; ?>" method="post" enctype="multipart/form-data" id="form-bulk-product" class="form-horizontal">
        <table id="special" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><span data-toggle="tooltip" title="<?php echo $text_help_autocomplete; ?>"><?php echo $entry_product_name; ?></span></td>
              <td class="text-left"><?php echo $entry_customer_group; ?></td>
              <td class="text-left"><?php echo $entry_discount_type; ?></td>
              <td class="text-right"><span data-toggle="tooltip" title="<?php echo $text_help_delete; ?>"><?php echo $entry_dicount_value; ?></span></td>
              <td class="text-left"><?php echo $entry_date_start; ?></td>
              <td class="text-left"><?php echo $entry_date_end; ?></td>
              <td class="text-left"><?php echo $entry_discount_previous; ?></td>
              <td><a href="javascript:void(0)" id="individual-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary individual-product"><i class="fa fa-save"></i></a></td>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <td colspan="7"></td>
              <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
            </tr>
          </tfoot>
        </table>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
  $( document ).on( "click", "#bulk-product", function(event) {
    $("#form-bulk-category").submit();
  });
//-->
</script>
<script type="text/javascript"><!--
  $( document ).on( "click", "#individual-product", function(event) {
    event.preventDefault();
    $.ajax({
        url: 'index.php?route=extension/module/bulk_special/add_individual&user_token=<?php echo $token; ?>',
        type: 'post',
        dataType: 'json',
        data: $("#form-bulk-product").serialize(),

        success: function(json) {
          
          if(json.error) {
            alert(json.error);
          }
          if(json.success) {
            alert(json.success);
          }
        }
      });
  });
//-->
</script>
  <script type="text/javascript"><!--

// Filter
$( document ).on( "keyup", '[class*=bulk-search-]', function() {
    selected = $(this);
    $(this).autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=extension/module/bulk_special/autocomplete&user_token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['product_id'],
              price: item['price'],
            }
          }));
        }
      });
    },
    'select': function(item) {
      selected.val(item['label']);
      selected.parent().find('.product_id').val(item['value']);
      selected.parent().find('.price').val(item['price']);
    }
  });
});


$('#product-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

</script>
  
  
  <script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tr id="special-row' + special_row + '">';
   html += '  <td class="text-left"><input type="text" name="product_special[' + special_row + '][product_name]" value="" placeholder="* <?php echo $entry_product_name; ?>" class="form-control bulk-search-' + special_row + '" />';
   html += '<input type="hidden" name="product_special[' + special_row + '][product_id]" value="" class="form-control product_id" /><input type="hidden" name="product_special[' + special_row + '][price]" value="" class="form-control price" /></td>';

    html += '  <td class="text-left"><select name="product_special[' + special_row + '][bulk_special_cutomer_group]" class="form-control">';

    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
    <?php } ?>
    html += '  </select></td>';

    html += '  <td class="text-left"><select name="product_special[' + special_row + '][bulk_special_discount_type]" class="form-control">';
    html += ' <option value="percentage"><?php echo $text_pecentage; ?></option>';
    html += ' <option value="minus"><?php echo $text_minus; ?></option>';
    html += '  </select></td>';
	html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][bulk_special_price]" value="" placeholder="* <?php echo $entry_dicount_value; ?>" class="form-control" /></td>';
    html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][bulk_special_date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][bulk_special_date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left" style="width: 5%;"><select name="product_special[' + special_row + '][bulk_special_discount_previous]" class="form-control">';
    html += '<option value="1" selected="selected"><?php echo $text_yes; ?></option><option value="0"><?php echo $text_no; ?></option>';
    html += '         </select></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#special tbody').append(html);

	$('.date').datetimepicker({
		pickTime: false
	});

	special_row++;
}
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
</script>
</div>

<?php echo $footer; ?>
