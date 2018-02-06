<section id="css-classes" class="card">

  <div class="card-body collapse in">
      <div class="card-block">
          <form id="frm-main" class="form form-horizontal" novalidate="">
            <input type="hidden" name="id" value="<?=$data->id;?>">
            <div class="form-body">

              <h4 class="form-section green"><i class="icon-stackoverflow"></i>Template Infomation
                <span style="float:right; line-height:0rem;">
                <button type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>index');">
                <i class="icon-rewind"></i>Back
                </button>    
                </span>                    
              </h4>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                    <label for="name">Template Name</label>
                    <input type="text" class="form-control border-info" name="template_name" value="<?=$data->template_name;?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="plantType">Plant Type</label>
                    <input type="text" class="form-control" name="plant_type_id" value="<?=$namePlant;?>" readonly>                                        
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                  <label for="seedType">Seed Type</label>
                  <input type="text" class="form-control" name="seed_type_id" value="<?=$nameSeed;?>" readonly>  
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group control-group">
                    <label for="culti_period">Cultivation Period</label>
                    <input type="text" class="form-control" placeholder="ระยะเวลาการเพาะปลูก" name="culti_period" value="<?=$data->culti_period;?>" readonly>                                   
                    </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                  <label for="yield">Yield / Rai</label>
                  <input type="text" class="form-control" placeholder="ผลผลิต / ไร่" name="yield" value="<?=$data->yield;?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group control-group">
                    <label for="cost">Cost / Rai</label>
                    <input type="text" class="form-control" placeholder="ต้นทุน / ไร่" name="cost" value="<?=$data->cost;?>" readonly>                                 
                    </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                  <label for="active">Active : </label>&nbsp;&nbsp;
                  <input type="checkbox" class="form-checkbox" name="active" value="1" <?=(!empty($data->active))?'checked':'';?> disabled> 
                  </div>
                </div>  
              </div>
            </div><?php //close <div class="form-body"> ?>
          </form>
          <hr>
          <form id="frm-cultivation-process" class="form form-horizontal" novalidate="">
            <div class="form-body">
              <h4 class="form-section green"><i class="icon-list-numbered"></i>Cultivation Process
                <span style="float:right; line-height:0rem;">
                  <button type="button" class="btn btn-primary" onClick="formAddProcess();">
                  <i class="icon-plus4"></i>Add Process
                  </button>    
                  </span>   
              </h4>
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                        <th class="text-center" width="5%">ลำดับ</th>
                        <th class="text-center" width="25%">ชื่อ</th>
                        <th class="text-center" width="10%">งบประมาณ</th>
                        <th class="text-center" width="10%">เวลา</th>
                        <th class="text-center">ระยะเวลาเพาะปลูก <span id="cultiperiod_max"><?=$data->culti_period;?></span> วัน</th>
                        <th class="text-center" width="8%">Action</th>
                    </tr>
                  </thead>
                  <tbody id="process-list">
                    <?php include_once 'process-list.php'; ?>
                  </tbody>
                </table>
              </div>
            </div><?php //close <div class="form-body"> ?>
          </form>
      </div><?php //close <div class="card-block"> ?>
  </div>
</section>

<!-- modal add process -->
<div id="md-add-process" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Add Process</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="frm-add-process">
              <input type="hidden" name="id" value="">
              <input type="hidden" name="cultivation_id" value="<?=$data->id;?>">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
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
                            <input type="radio" class="form-radio" name="set_start" value="1" onclick="setStartPeriod(this);" checked>
                            เวลา / วัน ต่อจาก Process <span id="processname_last"></span>
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
                            <input type="radio" class="form-radio" name="set_start" value="2" onclick="setStartPeriod(this);">
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
              <button type="button" class="btn btn-primary" id="button-add-process">
                  <i class="icon-check2"></i> Save
              </button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  function formAddProcess(){
    $('form#frm-add-process')[0].reset();
    var processname_last = $('input[id^=process_name_]').last().val();
    $('form#frm-add-process #processname_last').html(processname_last);
    $('#md-add-process').modal('show');
  }

  function setStartPeriod(obj){
    if(obj.value == 1){
      $('form#frm-add-process #period_start').val('');
      $('form#frm-add-process #period_start').prop('readonly', true);
    } else {
      $('form#frm-add-process #period_start').prop('readonly', false);
      $('form#frm-add-process #period_start').focus();
    }
  }

  function fncConfirmSaveAddProcess(bt,data,url,md_form) {
      urlSend = WEB_HTTP_HOST+'/'+url;
      $.ajax({
          url: urlSend,
          type: 'POST',
          data: data,
          success: function(result_html) {
            md_form.modal('hide');
            if(result_html==''){
              $('#md-error p').text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
              $('#md-error').modal('show');
            } else {
              $('#process-list').html(result_html);
              //total cost
              setTimeout(function(){
                $('form#frm-main input[name=cost]').val($('#total_processbudget').val());
              }, 500);              
            }
            bt.data('requestRunning', false);
            bt.removeClass('disabled');
          },
          error : function(result){
            md_form.modal('hide');
            $('#md-error p').text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
            $('#md-error').modal('show');
            bt.data('requestRunning', false);
            bt.removeClass('disabled');
          }
      });
  }

  $("form#frm-add-process input,select").jqBootstrapValidation({
      preventSubmit: true,
      submitError: function($form, event, errors) {
        $('#button-add-process').removeClass('disabled');
      },
      submitSuccess: function($form, event) {
        event.preventDefault();
        var data = $("form#frm-add-process").serialize();
        var me = $('#button-add-process');
        fncConfirmSaveAddProcess(me,data,"<?=$page_starturl?>save-process",$('#md-add-process'));
      }
  });

  $('#button-add-process').click(function(){
    var period_new = parseFloat($('form#frm-add-process input[name=period]').val());
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
    if($('form#frm-add-process input[name=set_start]:checked').val() == 1){
      var last_period_daytotal = $('input[id^=period_daytotal_]').last().val();
      last_period_daytotal = parseFloat(last_period_daytotal);
      if(isNaN(last_period_daytotal) === true){
        last_period_daytotal = 0;
      }
      culti_period_remain = culti_period_max - (last_period_daytotal + period_new);
    } else if($('form#frm-add-process input[name=set_start]:checked').val() == 2){
      var add_period_start = $('form#frm-add-process #period_start').val();
      add_period_start = parseFloat(add_period_start);
      if(isNaN(add_period_start) === true){
        $('form#frm-add-process #period_start').val('');
        $('form#frm-add-process #period_start').focus();
        return false;
      }
      culti_period_remain = culti_period_max - (add_period_start + period_new);
    } else {
      alert('กรุณาเลือก เวลา / วัน ต่อจาก');
      return false;
    }
    //////////////////////////    
    if(culti_period_remain < 0){
      $('#md-add-process').modal('hide');
      $('#md-error p').text('จำนวนวันเพาะปลูกเกินไม่สามารถทำรายการได้');
      $('#md-error').modal('show');
      $('#md-error').on('hidden.bs.modal', function (e) {
        $('#md-add-process').modal('show');
      });      
    } else {
      if(period_new == 0){
        $('form#frm-add-process input[name=period]').val('');
      }
      $('#md-error').off('hidden.bs.modal');
      $('#button-add-process').addClass('disabled');
      $('form#frm-add-process').submit();
    }
  });

  //delete process
  $('#btn-confirm-delete').off("click").click(function(e) {
      data = $("#frm-confirm-delete").serializeArray();
      fncConfirmDelete(data,"<?=$page_starturl?>delete-process","<?=$page_starturl?>info?id=<?=$data->id;?>");
  });
</script>

<!-- form Edit -->
<?php include_once 'process-edit.php'; ?>