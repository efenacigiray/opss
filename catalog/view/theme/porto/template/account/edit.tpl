<?php echo $header;
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <?php if (!$information_verified) { ?>
        <div class="alert alert-danger"><?php echo $error_verify_info; ?></div>
        <?php } ?>
        <fieldset>
          <legend><?php echo $text_your_details; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?> </label>
            <div class="col-sm-10">
              <input type="text" name="firstname" readonly value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="lastname" readonly value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if($error_lastname) { ?>
              <div class="text-danger"><?php echo $error_lastname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-class">Sınıf </label>
            <div class="col-sm-10">
                <?php if ($class_verified){ ?>
              <input type="text" name="class" readonly value="<?php echo $class['name']; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-class" class="form-control" />
              <input type="hidden" value="<?php echo $class['class_id']?>" name="class_id">
                <?php if($error_firstname) { ?>
                <div class="text-danger"><?php echo $error_firstname; ?></div>
                <?php } ?>
              <?php } else { ?>
              <select name="class_id">
                <?php foreach($classes as $c) ?>
                <option value="<?php echo $class[class_id] ?>"><?php echo $class[name] ?></option>
                <?php ?>
              </select>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php if($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-10">
              <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if($error_telephone) { ?>
              <div class="text-danger"><?php echo $error_telephone; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php foreach ($custom_fields as $custom_field) { ?>
          <?php if($custom_field['type'] == 'select') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $account_custom_field[$test]) { ?>
                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'radio') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div>
                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <div class="radio">
                  <?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $account_custom_field[$test]) { ?>
                  <label>
                    <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } else { ?>
                  <label>
                    <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'checkbox') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div>
                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <div class="checkbox">
                 <?php $test = $custom_field['custom_field_id']; if($affiliate_custom_field[$test] && in_array($custom_field_value['custom_field_value_id'], $affiliate_custom_field[$test])) { ?>
                  <label>
                    <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } else { ?>
                  <label>
                    <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'text') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test]) { ?><?php echo $account_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" <?php echo $custom_field['custom_field_id'] == 1 ? "readonly" : ""; ?> />
              <?php $test = $custom_field['custom_field_id']; if(isset($error_custom_field[$test]) && $error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'textarea') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <textarea name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test]) { ?><?php echo $account_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?></textarea>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'file') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test]) { ?><?php echo $account_custom_field[$test]; ?> <?php } ?>" />
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'date') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div class="input-group date">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test]) { ?><?php echo $account_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'time') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div class="input-group time">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test]) { ?><?php echo $account_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'time') { ?>
          <div class="form-group<?php if($custom_field['required']) { ?> required <?php } ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div class="input-group datetime">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($account_custom_field[$test]) { ?><?php echo $account_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php } ?>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
            <?php if (!$information_verified) { ?>
            <input type="submit" value="Onayla" class="btn btn-success" />
            <input type="hidden" name="to_package" value="1">
            <?php } ?>
            <?php if ($information_verified) { ?>
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
            <?php } ?>
          </div>
        </div>
      </form>

<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length) {
		$('.form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length) {
		$('.form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var element = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(element).button('loading');
				},
				complete: function() {
					$(element).button('reset');
				},
				success: function(json) {
					$(element).parent().find('.text-danger').remove();

					if (json['error']) {
						$(element).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(element).parent().find('input').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	language: '<?php echo $datepicker; ?>',
	pickTime: false
});

$('.datetime').datetimepicker({
	language: '<?php echo $datepicker; ?>',
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	language: '<?php echo $datepicker; ?>',
	pickDate: false
});
//--></script>

<?php include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>