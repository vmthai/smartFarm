<!-- modal edit process -->
<div id="md-edit-process" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Edit Process</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="frm-edit-process">
              <input type="hidden" name="id" value="">
              <input type="hidden" name="cultivation_id" value="">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group control-group">
                      <label for="name">ชื่อ</label>
                      <input type="text" class="form-control border-info" placeholder="ชื่อ" name="name" onblur="checkTrimData(this);" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group control-group">
                    <label for="yield">งบประมาณ / บาท</label>
                    <input type="text" class="form-control border-info number_decimal" placeholder="งบประมาณ" name="budget" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group control-group">
                      <label for="cost">เวลา / วัน</label>
                      <input type="text" class="form-control border-info number" placeholder="เวลา" name="period" required>                                 
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div style="margin-top:5px;">
                        <label class="radio-inline">
                            <input type="radio" class="form-radio" name="set_start" value="1" onclick="setStartPeriodEdit(this);">
                            เวลา / วัน <span id="processname_last"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 col-sm-6">
                    <div class="form-group">
                      <div style="margin-top:5px;">
                        <label class="radio-inline">
                            <input type="radio" class="form-radio" name="set_start" value="2" onclick="setStartPeriodEdit(this);">
                            เวลา / วัน กำหนดเองต่อจากวันที่
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4">
                    <div class="form-group control-group">
                      <input type="text" class="form-control border-info number" placeholder="ใส่ 0 คือ เริ่มวันแรก" id="period_start" name="period_start" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group control-group">
                      <label for="name">บันทึกข้อความ</label>
                      <textarea class="form-control" name="remark" rows="3" placeholder="บันทึกข้อความ"></textarea>
                    </div>
                  </div>
                </div> 
              </div>
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="button-edit-process">
                  <i class="icon-check2"></i> Save
              </button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<!-- modal edit Cultivation Period -->
<div id="md-edit-culti-period" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ALERT !</h4>
          </div>
          <div class="modal-body">
              <p>จำนวนวันเพาะปลูกเกิน กรุณาเพิ่ม Cultivation Period</p>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group control-group">
                    <label for="culti_period_new">Cultivation Period</label>
                    <input type="text" class="form-control number" placeholder="ระยะเวลาการเพาะปลูก" id="culti_period_new" value="" oncontextmenu="return false;">
                    </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="button-culti-period-new">
                  <i class="icon-check2"></i> Save
              </button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  function setStartPeriodEdit(obj){
    if(obj.value == 1){
      $('form#frm-edit-process #period_start').val('');
      $('form#frm-edit-process #period_start').prop('readonly', true);
    } else {
      $('form#frm-edit-process #period_start').prop('readonly', false);
      $('form#frm-edit-process #period_start').focus();
    }
  }
  function fncEditProcess(process_id){
  	urlSend = WEB_HTTP_HOST+'/<?=$page_starturl?>get-process';
  	$.ajax({
  	    url: urlSend,
  	    type: 'POST',
  	    data: {process_id: process_id},
  	    success: function(result) {
  	    	obj = JSON.parse(result);
          $('form#frm-edit-process input[name=id]').val(obj.id);
          $('form#frm-edit-process input[name=cultivation_id]').val(obj.cultivation_id);
          $('form#frm-edit-process input[name=name]').val(obj.name);
          $('form#frm-edit-process input[name=budget]').val(obj.budget);
          $('form#frm-edit-process input[name=period]').val(obj.period);
          if($.isNumeric(obj.period_start) === false){
            $('form#frm-edit-process input[name=set_start]').each(function(){
              if($(this).val() == 1){
                $(this).prop('checked', true);
              } else {
                $(this).prop('checked', false);
              }
            });
            $('form#frm-edit-process #period_start').prop('readonly', true);
          } else {
            $('form#frm-edit-process input[name=set_start]').each(function(){
              if($(this).val() == 2){
                $(this).prop('checked', true);
              } else {
                $(this).prop('checked', false);
              }
            });
            $('form#frm-edit-process #period_start').prop('readonly', false);
          }
          $('form#frm-edit-process #period_start').val(obj.period_start);
          $('form#frm-edit-process textarea[name=remark]').val(obj.remark);

          //get before process
          var process_id_before = $('input#before_process_id_'+obj.id).val();
          var text_processname = 'เริ่มจากวันแรก';
          if(process_id_before != 0){
            text_processname = 'ต่อจาก Process '+$('input#process_name_'+process_id_before).val();
          }
          $('form#frm-edit-process #processname_last').html(text_processname);
          $('#md-edit-process').modal('show');
  	    },
  	    error : function(result){
  	      $('#md-error p').text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
  	      $('#md-error').modal('show');
  	    }
  	});
  }

  $("form#frm-edit-process input,select").jqBootstrapValidation({
      preventSubmit: true,
      submitError: function($form, event, errors) {
        $('#button-edit-process').removeClass('disabled');
      },
      submitSuccess: function($form, event) {
        event.preventDefault();
        var data = $("form#frm-edit-process").serialize();
        var me = $('#button-edit-process');
        fncConfirmSaveAddProcess(me,data,"<?=$page_starturl?>save-process",$('#md-edit-process'));
      }
  });

  $('#button-edit-process').click(function(){
    var period_new = parseFloat($('form#frm-edit-process input[name=period]').val());
    if(isNaN(period_new) === true){
      period_new = 0;
    }
    //check day max
    var culti_period_max = parseFloat($('input[name=culti_period]').val());
    if(isNaN(culti_period_max) === true){
      culti_period_max = 0;
    }
    //////radio check////////
    var culti_period_remain = 0;
    if($('form#frm-edit-process input[name=set_start]:checked').val() == 1){
      var process_id = $('form#frm-edit-process input[name=id]').val();
      var process_id_before = $('input#before_process_id_'+process_id).val();
      var last_period_daytotal = $('input#period_daytotal_'+process_id_before).val();
      last_period_daytotal = parseFloat(last_period_daytotal);
      if(isNaN(last_period_daytotal) === true){
        last_period_daytotal = 0;
      }
      culti_period_remain = culti_period_max - (last_period_daytotal + period_new);
    } else if($('form#frm-edit-process input[name=set_start]:checked').val() == 2){
      var add_period_start = $('form#frm-edit-process #period_start').val();
      add_period_start = parseFloat(add_period_start);
      if(isNaN(add_period_start) === true){
        $('form#frm-edit-process #period_start').val('');
        $('form#frm-edit-process #period_start').focus();
        return false;
      }
      culti_period_remain = culti_period_max - (add_period_start + period_new);
    } else {
      alert('กรุณาเลือก เวลา / วัน ต่อจาก');
      return false;
    }
    //////////////////////////  
    if(culti_period_remain < 0){
      $('#md-edit-process').modal('hide');
      $('#md-edit-culti-period #culti_period_new').val(culti_period_max);
      $('#md-edit-culti-period').modal('show');
      $('#md-edit-culti-period').on('hidden.bs.modal', function (e) {
        $('#md-edit-process').modal('show');
        $('#md-edit-culti-period').off('hidden.bs.modal');
      });      
    } else {
      if(period_new == 0){
        $('form#frm-edit-process input[name=period]').val('');
      }
      $('#button-edit-process').addClass('disabled');
      $('form#frm-edit-process').submit();
    }
  });

  $('#button-culti-period-new').click(function(){
    if(!$('#md-edit-culti-period #culti_period_new').val() || $('#md-edit-culti-period #culti_period_new').val() <= $('form#frm-main input[name=culti_period]').val()){
      $('#md-edit-culti-period #culti_period_new').val($('form#frm-main input[name=culti_period]').val());
      $('#md-edit-culti-period #culti_period_new').select();
    } else {
      $('#button-culti-period-new').prop('disabled', true);
      urlSend = WEB_HTTP_HOST+'/<?=$page_starturl?>save-culti-period';
      $.ajax({
          url: urlSend,
          type: 'POST',
          data: {id: $('form#frm-main input[name=id]').val(),culti_period: $('#md-edit-culti-period #culti_period_new').val()},
          success: function(result_html) {
            if(!result_html) {
              alert('ไม่สามารถบันทึกข้อมูลได้');
              return false;
            } else {
              var new_culti_period = $('#md-edit-culti-period #culti_period_new').val();
              $('form#frm-main input[name=culti_period]').val(new_culti_period);
              $('span#cultiperiod_max').html(new_culti_period);

              //reload process list
              $('#process-list').html(result_html);

              $('#md-edit-culti-period').modal('hide');
            }
            $('#button-culti-period-new').prop('disabled', false);
          },
          error : function(result){
            $('#md-error p').text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
            $('#md-error').modal('show');
            $('#button-culti-period-new').prop('disabled', false);
          }
      });
    }
  });
</script>