<section id="css-classes" class="card">

  <div class="card-body collapse in">
      <div class="card-block">
          <form id="frm-main" class="form form-horizontal" novalidate="">
            <input type="hidden" name="id" value="">
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
                    <input type="text" class="form-control border-info" placeholder="Exp - สุพรรณบุรี 1" name="template_name" onblur="checkTrimData(this);" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group control-group">
                    <label for="plantType">Plant Type</label>
                    <select class="form-control border-info" id="plant_type_id" name="plant_type_id" required>
                          <option value="">---เลือก ประเภทการเพาะปลูก---</option>
                          <?php  foreach($dataPlant as $k => $v){ ?>
                        <option value="<?=$k?>"><?=$v?></option>
                          <?php  } ?>
                    </select>                                         
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                  <label for="seedType">Seed Type</label>
                  <select class="form-control border-info" id="seed_type_id" name="seed_type_id" required>
                  <option value="">---เลือก เมล็ดพันธุ์เพาะปลูก---</option>
                  </select>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group control-group">
                    <label for="culti_period">Cultivation Period</label>
                    <input type="text" class="form-control border-info number" placeholder="ระยะเวลาการเพาะปลูก" name="culti_period" required>                                   
                    </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                  <label for="yield">Yield / Rai</label>
                  <input type="text" class="form-control border-info number_decimal" placeholder="ผลผลิต / ไร่" name="yield">
                  </div>
                </div>
                <?php /* ?>
                <div class="col-md-6">
                    <div class="form-group control-group">
                    <label for="cost">Cost / Rai</label>
                    <input type="text" class="form-control border-info number_decimal" placeholder="ต้นทุน / ไร่" name="cost">                                 
                    </div>
                </div>
                <?php */ ?>
              </div> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                  <label for="active">Active : </label>&nbsp;&nbsp;
                  <input type="checkbox" class="form-checkbox" name="active" value="1" checked> 
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group control-group" style="float: right;">
                    <button type="button" class="btn btn-warning mr-1" onClick="fncLoadContent('<?=$page_starturl?>index');">
                      <i class="icon-cross2"></i> Cancel
                  </button>
                  <button type="submit" class="btn btn-primary">
                      <i class="icon-check2"></i> Save
                  </button>
                    </div>
                </div>
              </div> 
            </div><?php //close <div class="form-body"> ?>  
          </form>
      </div><?php //close <div class="card-block"> ?>
  </div>

</section>
<script type="text/javascript">
  function fncConfirmSaveCaltivation(bt,data,url,urlRefresh) {
      urlSend = WEB_HTTP_HOST+'/'+url;
      $.ajax({
          url: urlSend,
          type: 'POST',
          data: data,
          success: function(result) {
            obj = JSON.parse(result);  
              $('#md-error p' ).text(obj.message);
              $('#md-error').modal('show');         
              if(obj.result=='true') {
                  $('#md-error').on('hidden.bs.modal', function (e) {
                    if(obj.caltivation_id==''){
                      fncLoadContent(urlRefresh);
                      $('#md-error').off('hidden.bs.modal');
                    } else {
                      fncLoadContent('<?=$page_starturl?>info?id='+obj.caltivation_id);
                      $('#md-error').off('hidden.bs.modal');
                    }
                  });
              }
              $('#btn-save').removeClass('disabled');
              bt.data('requestRunning', false);
          },
          error : function(result){
            $('#md-error p' ).text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
            $('#md-error').modal('show');
            bt.data('requestRunning', false);
          }
      });
  }

  $("#frm-main input,select").jqBootstrapValidation({
      preventSubmit: true,
      submitError: function($form, event, errors) {
          $('#btn-save').removeClass('disabled');
      },
      submitSuccess: function($form, event) {
          event.preventDefault();
          $('#btn-save').removeClass('disabled');
          $('#md-confirm').modal('show');
      }
  });
  $('#btn-save').click(function(e) {
      $('#btn-save').addClass('disabled');      
  });
  $('#btn-confirm-save').off("click").click(function(e) {
      $('#btn-save').addClass('disabled');
      $('#md-confirm').modal('hide');
        var me = $(this);
        e.preventDefault();

        if ( me.data('requestRunning') ) {
            $('#btn-save').removeClass('disabled');
            return;
        }

        me.data('requestRunning', true);

        var data = $("#frm-main").serialize();
        fncConfirmSaveCaltivation(me,data,"<?=$page_starturl?>save","<?=$page_starturl?>index");
        e.stopPropagation();
  });

  //เลือก Plant Type
  $('#plant_type_id').change(function(){
    var val_plant = $(this).val();
    var html_opt = '<option value="">---เลือก เมล็ดพันธุ์เพาะปลูก---</option>';
    if(!val_plant){
      $('#seed_type_id').html(html_opt);
    } else {
      $.getJSON(WEB_HTTP_HOST+"/<?=$page_starturl?>get-seed?plant_id="+val_plant, function(jsonData){
          $.each(jsonData, function(id,name)
          {
              html_opt +='<option value="'+id+'">'+name+'</option>';
          });
          $('#seed_type_id').html(html_opt);
      });
    }
  });
</script>