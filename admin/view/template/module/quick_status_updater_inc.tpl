<?php if ($gkd_snippet == 'barcode_button') { ?>
  <?php if($qosu_barcode) { ?>
  <button id="qosuBarcodeButton" data-toggle="tooltip" data-placement="left" class="btn pull-right" title="<?php echo $text_qosu_barcode; ?>"/><i class="fa fa-barcode"></i></button>
  <?php } ?>
<?php } else if ($gkd_snippet == 'button') { ?>
  <button id="btn-qosu-multiple" data-toggle="tooltip" title="<?php echo $text_qosu_add_history; ?>" class="btn btn-warning quick-update-multiple"><i class="fa fa-toggle-right"></i></button>
<?php } else if ($gkd_snippet == 'tracking_col') { ?>
<?php if (!empty($qosu_tracking_column)) { ?><td><?php echo $text_qosu_column_tracking;?></td><?php } ?>
<?php } else if ($gkd_snippet == 'dialog_div') { ?>
  <?php if (version_compare(VERSION, '2', '>=')) { ?>
    <div class="modal fade" id="quick-status-dialog" tabindex="-1" role="dialog"><span class="modalContent"></span></div>
  <?php } else { ?>
    <div id="quick-status-dialog" title="<?php echo $text_qosu_add_history; ?>" style="display:none"><span class="modalContent"></span></div>
  <?php }  ?>
<?php } else if ($gkd_snippet == 'scripts') { ?>
<script type="text/javascript"><!--
// global var definition for later use
var current_order_ids = [];

// highlight method
jQuery.fn.qosu_highlight = function () {
    $(this).each(function () {
        var el = $(this);
        $("<div/>")
        .width(el.outerWidth())
        .height(el.outerHeight())
        .css({
            "position": "absolute",
            "left": el.offset().left,
            "top": el.offset().top,
            "background-color": "#ffff99",
            "opacity": ".7",
            "z-index": "999"
        }).appendTo('body').fadeOut(2000).queue(function () { $(this).remove(); });
    });
}

$(document).ready(function() {
 //draggable modal
 var qosu_modal = {isMouseDown: false, mouseOffset: {} };
  $('body').on('mousedown', '.modal-header', function(event) {
    qosu_modal.isMouseDown = true;
    var dialogOffset = $('#quick-status-dialog .modal-dialog').offset();
    qosu_modal.mouseOffset = {
      top: event.clientY - dialogOffset.top,
      left: event.clientX - dialogOffset.left
    };
    $('body').on('mousemove', '#quick-status-dialog', function(event) {
      if (!qosu_modal.isMouseDown) { return; }
      $('#quick-status-dialog .modal-dialog').offset({
        top: event.clientY - qosu_modal.mouseOffset.top,
        left: event.clientX - qosu_modal.mouseOffset.left
      });
    });
  });
  $('body').on('mouseup', '#quick-status-dialog', function(event) {
    qosu_modal.isMouseDown = false;
     $('body').off('mousemove', '#quick-status-dialog');
  });
 // end - draggable modal
  
  $('body').on('click', '#qosuSubmit', function() {
    quickStatusUpdate();
  });
  
  $('body').on('click', '#qosuSubmitClose', function() {
    quickStatusUpdate(1);
  });
  
  $('body').on('click', '#history .pagination a', function() {
    $('#history').load(this.href);
    return false;
  });
  
  $('body').on('hidden.bs.modal', '#quick-status-dialog', function () {
    current_order_ids = [];
  });
  
  // barcode handler
  <?php if($qosu_barcode) { ?>
  var barcode_id = '';
  var barcode_is_tracking = false;
  
  $('#qosuBarcodeButton').on('click', function(event) {
    $(this).toggleClass('enabled');
    if ($(this).hasClass('enabled')) {
      $('body').on('keypress', function(e) {
        if (jQuery.inArray( e.which-48, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] )  !== -1) {
          barcode_id += e.which-48;
        } else if (e.which == 13) {
          <?php if (0) { ?>
          if(barcode_id != '') {
            e.preventDefault();
            current_order_ids.push(barcode_id);
            barcode_id = '';
            $('body').trigger('qosuPopup');
          }
          <?php } else { ?>
          if (!barcode_is_tracking) {
            if (barcode_id != '') {
              e.preventDefault();
              current_order_ids.push(barcode_id);
              barcode_id = '';
              $('body').trigger('qosuPopup');
              barcode_is_tracking = !barcode_is_tracking;
            }
          } else {
            barcode_is_tracking = !barcode_is_tracking;
            barcode_id = '';
            $('input[name^=tracking_no]').blur();
          }
          return false;
          <?php } ?>
        }
      });
    } else {
      $('body').off('keypress');
    }
  });
  <?php if($qosu_barcode_enabled) { ?>
     $('#qosuBarcodeButton').trigger('click');
  <?php }} ?>
  // end - barcode handler

  $('input[name^=tracking_no]').on('keypress',function(e){
    if(e.keyCode == 13){
      e.preventDefault(); return false;
    }
  });
  
  $('body').on('click', '.modalContent', function(e) {
    if ($(e.target).attr('class') == 'modalContent') {
      $('#quick-status-dialog').modal('hide');
    }
  });
  
  $('body').on('click', '.quick-update-multiple, .qosu-cell', function(e) {
    current_order_ids = [];
    
    if ($(this).attr('order_id')) {
      current_order_ids.push($(this).attr('order_id'));
    } else if ($("input[name='selected[]']:checked").length == 1) {
      current_order_ids.push($("input[name='selected[]']:checked").first().val());
    } else if (!$("input[name='selected[]']:checked").length && <?php echo (int) (substr(VERSION, 0, 1) != 2); ?>) {
      return alert('<?php echo $text_qosu_select_checkbox; ?>');
    } else {
      $("input[name='selected[]']:checked").each(function() {
        current_order_ids.push($(this).val());
      });
    }
    
    $('body').trigger('qosuPopup');
  });
  
  $('body').on('qosuPopup', function(e) {
    if (!current_order_ids) alert('No order selected');
    
    var current_track_values = [];
    
    $('input[name^=tracking_no]').each(function(){
      current_track_values.push($(this).val());
    });
    
    $('#quick-status-dialog .modalContent').html('<div style="text-align:center"><img src="<?php echo defined('_JEXEC') ? 'admin/' : ''; ?>view/quick_status_updater/img/loader.gif" alt=""/></div>');
    
    <?php if (version_compare(VERSION, '2', '>=')) { ?>
      $('#quick-status-dialog').modal({});
    <?php } else { ?>
      $('#quick-status-dialog').dialog({
      width:830,
      close: function(e) {
        current_order_ids = [];
      }
      });
    <?php } ?>
    
    
    
    if (current_order_ids.length == 1) {
       $('#quick-status-dialog .modalContent').load('index.php?route=module/quick_status_updater/multiple_form&<?php echo $full_token; ?>', {'selected': current_order_ids, 'tracking': current_track_values}, function(){
        $('#history').load('index.php?route=sale/order/history&reverse&<?php echo $full_token; ?>&order_id='+current_order_ids[0]);
        orderStatusChange();
        setTimeout(function(){$('#quick-status-dialog .modalContent input[name^=tracking_no]:first').focus();}, 100);
      });
    } else {
      $('#quick-status-dialog .modalContent').load('index.php?route=module/quick_status_updater/multiple_form&<?php echo $full_token; ?>', {'selected': current_order_ids, 'tracking': current_track_values}, function(){
        orderStatusChange();
        setTimeout(function(){$('#quick-status-dialog .modalContent input[name^=tracking_no]:first').focus();}, 100);
      });
    }
  });
});

// submit form
function quickStatusUpdate(close) {
  close || (close = 0);
  if(typeof verifyStatusChange == 'function'){
    if(verifyStatusChange() == false){
      return false;
    }else{
      addOrderInfo();
    }
  }else{
    addOrderInfo();
  }

  $.ajax({
    url: 'index.php?route=module/quick_status_updater/update_status&<?php echo $full_token; ?>&api_key=<?php echo (isset($api_key) ? $api_key : ''); ?>',
    type: 'post',
    dataType: 'json',
    data: $('form#qosu_form').serialize(),
    beforeSend: function() {
      $('.success, .warning').remove();
      $('#button-history').attr('disabled', true);
      $('#history').html('<div style="text-align:center"><img src="<?php echo defined('_JEXEC') ? 'admin/' : ''; ?>view/quick_status_updater/img/loader.gif" alt=""/></div>');
    },
    complete: function() {
      $('#button-history').attr('disabled', false);
      $('.attention').remove();
    },
    error: function(req, error) {
      $('#history').html(error + '<br/>' + req.responseText);
     },
    success: function(json) {
      if (json.error) {
              $('#history').html(json.error);
        //alert(json.error);
      } else {
        //$('#history').html(html);
        
        //$('textarea[name=\'comment\']').val('');
        
        var order_id;
        
        $.each(json.order_id, function(i, v){
          if(json.bg_mode == 'row') {
            $('td.qosu-cell[order_id="'+v+'"]').html($('select[name=\'order_status_id\'] option:selected').text());
            if (json.color != '#000000') {
            $('td.qosu-cell[order_id="'+v+'"]').parent().css('background', json.color);
            }
            $('td.qosu-cell[order_id="'+v+'"]').parent().qosu_highlight(1000);
          } else if(json.bg_mode == 'label') {
            $('td.qosu-cell[order_id="'+v+'"] span').html($('select[name=\'order_status_id\'] option:selected').text().toUpperCase());
            if (json.color != '#000000') {
              $('td.qosu-cell[order_id="'+v+'"] span').css('background', json.color);
            } else {
              $('td.qosu-cell[order_id="'+v+'"] span').css('background', '#555');
            }
            $('td.qosu-cell[order_id="'+v+'"] span').qosu_highlight(1000);
          } else if(json.bg_mode == 'cell') {
            $('td.qosu-cell[order_id="'+v+'"]').html($('select[name=\'order_status_id\'] option:selected').text());
            if (json.color != '#000000') {
            $('td.qosu-cell[order_id="'+v+'"]').css('background', json.color);
            }
            $('td.qosu-cell[order_id="'+v+'"]').qosu_highlight(1000);
          } else {
            $('td.qosu-cell[order_id="'+v+'"]').html('<span style="color:'+ json.color +'">' + $('select[name=\'order_status_id\'] option:selected').text() + ' </span>');
            $('td.qosu-cell[order_id="'+v+'"]').qosu_highlight(1000);
          }
          $('td.qosu-cell[order_id="'+v+'"]').qosu_highlight(1000);
          order_id = v;
        });
        
        // update tracking no column
        if (json.tracking_no) {
          $.each(json.tracking_no, function(i, v) {
            if (v) {
              $('td[data-tracking="'+i+'"]').html(v).qosu_highlight(1000);
            }
          });
        }
        
        if (close) {
          current_order_ids = [];
          <?php if (version_compare(VERSION, '2', '>=')) { ?>
            $('#quick-status-dialog').modal('hide');
          <?php } else { ?>
          $('#quick-status-dialog').dialog('close');
          <?php } ?>
        } else {
          if (json.order_id.length > 1) {
            $('#history').html('');
          } else {
            $('#history').load('index.php?route=sale/order/history&reverse&<?php echo $full_token; ?>&order_id='+order_id);
          }
        }
      }
    }
  });
}

function orderStatusChange(){
  var status_id = $('select[name="order_status_id"]').val();
  
  // quick status updater
  $.ajax({
    url: 'index.php?route=module/quick_status_updater/getDefaultComment&<?php echo $full_token; ?>&status_id='+status_id,
    type: 'post',
    dataType: 'json',
    beforeSend: function(){},
    success: function(json) {
      $.each(json, function(i, v){
        $('#quick-status-dialog textarea[name="comment['+ i +']"]').html(v);
      });
    },
    failure: function(){},
    error: function(){}
  });
  
  $.ajax({
    url: 'index.php?route=module/quick_status_updater/getNotifyStatus&<?php echo $full_token; ?>&status_id='+status_id,
    type: 'post',
    dataType: 'text',
    beforeSend: function(){},
    success: function(v) {
      $('#quick-status-dialog input[name="notify"]').prop('checked', v);
    },
    failure: function(){},
    error: function(){}
  });
  
  <?php if (!empty($qosu_openbay)) { ?>
  // openbay support, only if 1 order
  if (current_order_ids.length == 1) {
    $('#openbay-info').remove();

    $.ajax({
      <?php if (version_compare(VERSION, '2', '>=')) { ?>
      url: 'index.php?route=extension/openbay/getorderinfo&<?php echo $full_token; ?>&order_id='+current_order_ids[0]+'&status_id='+status_id,
      <?php } else { ?>
      url: 'index.php?route=extension/openbay/ajaxOrderInfo&<?php echo $full_token; ?>&order_id='+current_order_ids[0]+'&status_id='+status_id,
      <?php } ?>
      dataType: 'html',
      success: function(html) {
        $('#history').after(html);
      }
    });
  }
  <?php } ?>
}

function addOrderInfo(){
  var status_id = $('select[name="order_status_id"]').val();
  var old_status_id = $('#old_order_status_id').val();

  $('#old_order_status_id').val(status_id);
  
  <?php if (!empty($qosu_openbay)) { ?>
  // openbay handling
  if (current_order_ids.length == 1) {
  $.ajax({
  <?php if (version_compare(VERSION, '2', '>=')) { ?>
    url: 'index.php?route=extension/openbay/addorderinfo&<?php echo $full_token; ?>&order_id='+$('#quick-status-dialog input[name=\'order_id\']').val()+'&status_id='+status_id,
  <?php } else { ?>
    url: 'index.php?route=extension/openbay/ajaxAddOrderInfo&<?php echo $full_token; ?>&order_id='+$('#quick-status-dialog input[name=\'order_id\']').val()+'&status_id='+status_id+'&old_status_id='+old_status_id,
  <?php } ?>
    type: 'post',
    dataType: 'html',
      data: $(".openbayData").serialize()
  });
  }
  <?php } ?>
}

$('body').on('change', 'select[name="order_status_id"]', function(){orderStatusChange();});
//--></script>
<style type="text/css">
<?php if ($qosu_bg_mode == 'row') { ?>
.table.table-bordered{color:#333;}
.list tbody td{background-color:transparent;}
<?php } else if ($qosu_bg_mode == 'label') { ?>
.table > tbody > tr > td.qosu-label-cell{width:1%; padding: 0 22px<?php if ($_GET['route'] != 'sale/order') { ?> 0 7px<?php } ?>; text-align:center;}
.qosu-label{min-width: 130px; display: inline-block; padding: 6px;}
<?php } ?>
@media (min-width: 768px) {
.qosuDualRow{padding-right:0}
.qosuDualRow .col-sm-8{padding-right:5px}
.qosuDualRow .col-sm-4{padding:0}
}
.qosu-cell{cursor:pointer; font-weight:bold; color:#333;}
td.qosu-cell:hover{background-image:url(<?php echo defined('_JEXEC') ? 'admin/' : ''; ?>view/quick_status_updater/img/update.png); background-position:98%; background-repeat:no-repeat;}
[dir="rtl"] td.qosu-cell:hover{background-position:10%;}
.ui-dialog .ui-dialog-buttonpane{position: absolute; top: 30px; right:10px; background:transparent; border:0;}
.ui-dialog .ui-dialog-titlebar{margin-bottom: 5px;}
#qosuBarcodeButton{background:#ddd; border:1px solid #ccc; color:#333; outline:0;}
a#qosuBarcodeButton{margin-left:30px; margin-top:5px;}
button#qosuBarcodeButton{margin-top:-6px; padding: 6px 10px;}
button#qosuBarcodeButton i{font-size:14px;}
#qosuBarcodeButton.enabled, #qosuBarcodeButton:hover{background:#9FB9C4; border:1px solid #7CA0AF;}
#qosuBarcodeButton.enabled:hover{background:#9FB9C4; border:1px solid #7CA0AF;}
#qosuBarcodeButton:hover{background:#ccc; border:1px solid #bbb;}
#qosuBarcodeButton:active, #qosuBarcodeButton.enabled:active{background:#87B4C6; border:1px solid #77A7BA;}
</style>
<?php } ?>