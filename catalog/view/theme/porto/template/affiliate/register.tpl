<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); ?>

      <p><?php echo $text_account_already; ?></p>
      <p><?php echo $text_signup; ?></p>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset id="account">
          <legend><?php echo $text_your_details; ?></legend>
          <div class="form-group required" style="display: <?php if(strlen($customer_groups) > 1) { ?> block <?php } else { ?> none <?php } ?>;">
            <label class="col-sm-2 control-label"><?php echo $entry_customer_group; ?></label>
            <div class="col-sm-10"><?php foreach ($customer_groups as $customer_group) { ?>
              <?php if($customer_group['customer_group_id'] == $customer_group_id) { ?>
              <div class="radio">
                <label>
                  <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                  <?php echo $customer_group['name']; ?></label>
              </div>
              <?php } else { ?>
              <div class="radio">
                <label>
                  <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" />
                  <?php echo $customer_group['name']; ?></label>
              </div>
              <?php } ?>
              <?php } ?></div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?> </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if($error_lastname) { ?>
              <div class="text-danger"><?php echo $error_lastname; ?></div>
              <?php } ?> </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php if($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?> </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if($error_telephone) { ?>
              <div class="text-danger"><?php echo $error_telephone; ?></div>
              <?php } ?> </div>
          </div>
          <?php foreach ($custom_fields as $custom_field) { ?>
          <?php if($custom_field['location'] == 'account') { ?>
          <?php if($custom_field['type'] == 'select') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                
                
                
                
                
                
                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $register_custom_field[$test]) { ?>
                
                
                
                
                
                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                
                
                
                
                
                
                <?php } else { ?>
                
                
                
                
                
                
                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                
                
                
                
                
                
                <?php } ?>
                <?php } ?>
              
              
              
              
              
              
              </select>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'radio') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div> <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <div class="radio"> <?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $register_custom_field[$test]) { ?>
                  <label>
                    <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } else { ?>
                  <label>
                    <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } ?> </div>
                <?php } ?> </div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'checkbox') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div> <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <div class="checkbox"><?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test] && in_array($custom_field_value['custom_field_value_id'], $register_custom_field[$test])) { ?>
                  <label>
                    <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } else { ?>
                  <label>
                    <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                    <?php echo $custom_field_value['name']; ?></label>
                  <?php } ?> </div>
                <?php } ?> </div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'text') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'textarea') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <textarea name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?></textarea>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'file') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php if($register_custom_field[$test]) { ?>  <?php echo $register_custom_field[$test]; ?> <?php } ?>" />
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?></div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'date') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div class="input-group date">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'time') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div class="input-group time">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php if($custom_field['type'] == 'time') { ?>
          <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
            <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
            <div class="col-sm-10">
              <div class="input-group datetime">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
              <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
              <?php } ?> </div>
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>
        </fieldset>
        <fieldset id="affiliate">
          <legend><?php echo $text_your_affiliate; ?></legend>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-company"><?php echo $entry_company; ?></label>
            <div class="col-sm-10">
              <input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-company" class="form-control" />
            </div>
          </div>       
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-website"><?php echo $entry_website; ?></label>
            <div class="col-sm-10">
              <input type="text" name="website" value="<?php echo $website; ?>" placeholder="<?php echo $entry_website; ?>" id="input-website" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tax"><?php echo $entry_tax; ?></label>
            <div class="col-sm-10">
              <input type="text" name="tax" value="<?php echo $tax; ?>" placeholder="<?php echo $entry_tax; ?>" id="input-tax" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_payment; ?></label>
            <div class="col-sm-10">
              <div class="radio">
                <label> <?php if($payment == 'cheque') { ?>
                  <input type="radio" name="payment" value="cheque" checked="checked" />
                  <?php } else { ?>
                  <input type="radio" name="payment" value="cheque" />
                  <?php } ?>
                  <?php echo $text_cheque; ?></label>
              </div>
              <div class="radio">
                <label> <?php if($payment == 'paypal') { ?>
                  <input type="radio" name="payment" value="paypal" checked="checked" />
                  <?php } else { ?>
                  <input type="radio" name="payment" value="paypal" />
                  <?php } ?>
                  <?php echo $text_paypal; ?></label>
              </div>
              <div class="radio">
                <label> <?php if($payment == 'bank') { ?>
                  <input type="radio" name="payment" value="bank" checked="checked" />
                  <?php } else { ?>
                  <input type="radio" name="payment" value="bank" />
                  <?php } ?>
                  <?php echo $text_bank; ?></label>
              </div>
            </div>
          </div>
          <div class="form-group payment required" id="payment-cheque">
            <label class="col-sm-2 control-label" for="input-cheque"><?php echo $entry_cheque; ?></label>
            <div class="col-sm-10">
              <input type="text" name="cheque" value="<?php echo $cheque; ?>" placeholder="<?php echo $entry_cheque; ?>" id="input-cheque" class="form-control" />
              <?php if($error_cheque) { ?>
              <div class="text-danger"><?php echo $error_cheque; ?></div>
              <?php } ?> </div>
          </div>
          <div class="form-group payment required" id="payment-paypal">
            <label class="col-sm-2 control-label" for="input-paypal"><?php echo $entry_paypal; ?></label>
            <div class="col-sm-10">
              <input type="text" name="paypal" value="<?php echo $paypal; ?>" placeholder="<?php echo $entry_paypal; ?>" id="input-paypal" class="form-control" />
              <?php if($error_paypal) { ?>
              <div class="text-danger"><?php echo $error_paypal; ?></div>
              <?php } ?> </div>
          </div>
          <div class="payment" id="payment-bank">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-bank-name"><?php echo $entry_bank_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="bank_name" value="<?php echo $bank_name; ?>" placeholder="<?php echo $entry_bank_name; ?>" id="input-bank-name" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-bank-branch-number"><?php echo $entry_bank_branch_number; ?></label>
              <div class="col-sm-10">
                <input type="text" name="bank_branch_number" value="<?php echo $bank_branch_number; ?>" placeholder="<?php echo $entry_bank_branch_number; ?>" id="input-bank-branch-number" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-bank-swift-code"><?php echo $entry_bank_swift_code; ?></label>
              <div class="col-sm-10">
                <input type="text" name="bank_swift_code" value="<?php echo $bank_swift_code; ?>" placeholder="<?php echo $entry_bank_swift_code; ?>" id="input-bank-swift-code" class="form-control" />
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-bank-account-name"><?php echo $entry_bank_account_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="bank_account_name" value="<?php echo $bank_account_name; ?>" placeholder="<?php echo $entry_bank_account_name; ?>" id="input-bank-account-name" class="form-control" />
                <?php if($error_bank_account_name) { ?>
                <div class="text-danger"><?php echo $error_bank_account_name; ?></div>
                <?php } ?> </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-bank-account-number"><?php echo $entry_bank_account_number; ?></label>
              <div class="col-sm-10">
                <input type="text" name="bank_account_number" value="<?php echo $bank_account_number; ?>" placeholder="<?php echo $entry_bank_account_number; ?>" id="input-bank-account-number" class="form-control" />
                <?php if($error_bank_account_number) { ?>
                <div class="text-danger"><?php echo $error_bank_account_number; ?></div>
                <?php } ?> </div>
            </div>
            <?php foreach ($custom_fields as $custom_field) { ?>
            <?php if($custom_field['location'] == 'affiliate') { ?>
            <?php if($custom_field['type'] == 'select') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
                  <option value=""><?php echo $text_select; ?></option>
                  
                
                
                
                
                
                
                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                <?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $register_custom_field[$test]) { ?>
                
                
                
                
                
                  <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                  
                
                
                
                
                
                
                <?php } else { ?>
                
                
                
                
                
                
                
                  <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                  
                
                
                
                
                
                
                <?php } ?>
                <?php } ?>
              
              
              
              
              
              
              
                </select>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'radio') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div> <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                  <div class="radio"> <?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $register_custom_field[$test]) { ?>
                    <label>
                      <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } else { ?>
                    <label>
                      <input type="radio" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } ?> </div>
                  <?php } ?> </div>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'checkbox') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div> <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                  <div class="checkbox"> <?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test] && $custom_field_value['custom_field_value_id'] == $register_custom_field[$test]) { ?>
                    <label>
                      <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } else { ?>
                    <label>
                      <input type="checkbox" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } ?> </div>
                  <?php } ?> </div>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'text') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'textarea') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <textarea name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?></textarea>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'file') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                <input type="hidden" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>  <?php echo $register_custom_field[$test]; ?> <?php } ?>" />
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'date') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'time') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div class="input-group time">
                  <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php if($custom_field['type'] == 'time') { ?>
            <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div class="input-group datetime">
                  <input type="text" name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]" value="<?php $test = $custom_field['custom_field_id']; if($register_custom_field[$test]) { ?>?php echo $register_custom_field[$test]; ?><?php } else { ?><?php echo $custom_field['value']; ?><?php } ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                <?php $test = $custom_field['custom_field_id']; if($error_custom_field[$test]) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$test]; ?></div>
                <?php } ?> </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?> </div>
        </fieldset>
        <fieldset>
          <legend><?php echo $text_your_password; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
              <?php if($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?> </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
              <?php if($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?> </div>
          </div>
        </fieldset>
        <?php echo $captcha; ?>
        <?php if($text_agree) { ?>
        <div class="buttons clearfix">
          <div class="pull-right"><?php echo $text_agree; ?>
            <?php if($agree) { ?>
            <input type="checkbox" name="agree" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree" value="1" />
            <?php } ?>
            &nbsp;
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
        <?php } else { ?>
        <div class="buttons clearfix">
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
        <?php } ?>
      </form>

<script type="text/javascript"><!--
// Sort the custom fields
$('#account .form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#account .form-group').length) {
		$('#account .form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#account .form-group').length) {
		$('#account .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('#account .form-group').length) {
		$('#account .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#account .form-group').length) {
		$('#account .form-group:first').before(this);
	}
});

$('#affiliate .form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#affiliate .form-group').length) {
		$('#affiliate .form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#affiliate .form-group').length) {
		$('#affiliate .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('#affiliate .form-group').length) {
		$('#affiliate .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#affiliate .form-group').length) {
		$('#affiliate .form-group:first').before(this);
	}
});

$('input[name=\'customer_group_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/customfield&customer_group_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			$('.custom-field').hide();
			$('.custom-field').removeClass('required');

			for (i = 0; i < json.length; i++) {
				custom_field = json[i];

				$('#custom-field' + custom_field['custom_field_id']).show();

				if (custom_field['required']) {
					$('#custom-field' + custom_field['custom_field_id']).addClass('required');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var node = this;

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
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
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

$('.time').datetimepicker({
	language: '<?php echo $datepicker; ?>',
	pickDate: false
});

$('.datetime').datetimepicker({
	language: '<?php echo $datepicker; ?>',
	pickDate: true,
	pickTime: true
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'payment\']').on('change', function() {
	$('.payment').hide();

	$('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
//--></script> 

<?php include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>