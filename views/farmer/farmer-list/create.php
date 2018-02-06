<section id="css-classes" class="card">

  <div class="card-body collapse in">

      <div class="card-block">
          <form id="frm-main" class="form form-horizontal" novalidate="">
          <input type="hidden" name="id" value="">
          <input type="hidden" name="active" value="1">
            <div class="form-body">

              <h4 class="form-section green"><i class="icon-head"></i>ข้อมูลเกษตรกร
                  <span style="float:right; line-height:0rem;">
                  <button type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>index');">
                  <i class="icon-rewind"></i>Back
                  </button>    
                  </span>                    
              </h4>
       
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                    <label for="farmer_name">ชื่อ - สกุล</label>
                    <input type="hidden" id="people_id" name="people_id" value=""  required>
                    <fieldset class="form-group position-relative">
                      <input type="text" id="search_people_id" class="form-control border-primary" placeholder="Farmer Name" autocomplete="off" required>
                      <div class="form-control-position">
                        <i class="icon-search primary lighten-2 font-medium-4"></i>
                      </div>
                    </fieldset>
                  </div>
                </div>
                <div class="col-md-6" style="margin-top: 26px;">
                    <button type="button" class="btn btn-info" onClick="fncCreatePeople();">
                          <i class="icon-database2 white"></i> New People
                    </button>
                </div>
              </div>
              <div class="row" id="view_people"></div>

              <h4 class="form-section green"><i class="icon-users3"></i> ข้อมูลกลุ่มเกษตร</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                    <label for="farmerGroup">กลุ่มเกษตกร</label>
                    <fieldset class="form-group position-relative">
                      <input type="text" id="search_farmer_group_id" class="form-control border-primary" placeholder="Group Name" >
                      <input type="hidden" id="farmer_group_id" name="farmer_group_id" value=""  required>
                      <div class="form-control-position">
                        <i class="icon-search primary lighten-2 font-medium-4"></i>
                      </div>
                    </fieldset>
                  </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company_name">กรณีเกษตกรเป็นบริษัทฯ</label>
                    <input type="text" id="company_name" class="form-control border-primary" placeholder="company Name" name="company_name" required>                                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="projectinput1">ประเภทกลุ่มเพาะปลูก</label>
                    <select class="form-control border-primary" id="master_group_id" name="master_group_id" required>
                    <option value="">---กรุณาเลือก กลุ่มเกษตกร---</option>
                    <?php  foreach($groups as $k => $v){ ?>
                  <option value="<?=$k?>"><?=$v?></option>
                    <?php  } ?>
                    </select> 
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="UserName">เลขทะเบียนการค้า/เลขผู้เสียภาษี</label>
                    <input type="text" id="company_tax" class="form-control border-primary" placeholder="Tax ID" name="company_tax" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="farmerGroup">ตำแหน่ง PGS</label>
                      <fieldset class="form-group position-relative">
                      <input type="text" id="location" class="form-control border-primary" placeholder="GPS Location" name="location">
                      <div class="form-control-position">
                      <i class="icon-map1 primary font-medium-4"></i>
                      </div>
                      </fieldset>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="company_address">ที่ตั้งบริษัทฯ</label>
                      <input type="text" id="company_address" class="form-control border-primary" placeholder="Address" name="company_address">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="company_province_id">จังหวัด</label>
                      <select class="form-control" name="company_province_id" id="company_province_id">
                          <option value="">---กรุณาเลือก จังหวัด---</option>
                          <?php  foreach($provinces as $k => $v){ ?>
                          <option value="<?=$k?>"><?=$v?></option>
                          <?php  } ?>
                      </select> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="company_amphur_id">อำเภอ/เขต</label>
                     <select class="form-control" name="company_amphur_id" id="company_amphur_id">
                        <option value="">---กรุณาเลือก อำเภอ/เขต---</option>
                      </select>                                   
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="company_district_id">ตำบล/แขวง</label>
                      <select class="form-control" name="company_district_id" id="company_district_id">
                        <option value="">---กรุณาเลือก ตำบล/แขวง---</option>
                      </select> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company_zipcode">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control number" name="company_zipcode" maxlength="5" placeholder="Postcode" >                            
                  </div>
                </div>
              </div>
                        
              <div class="form-actions right">
                  <button type="button" class="btn btn-warning mr-1" onClick="fncLoadContent('<?=$page_starturl?>index');">
                      <i class="icon-cross2"></i> Cancel
                  </button>
                  <button type="submit" class="btn btn-primary">
                      <i class="icon-check2"></i> Save
                  </button>
              </div>
            </div>
          </form>
      </div>
  </div>
</section>

<div aria-hidden="true" role="dialog" tabindex="-1" id="md-create-people" class="modal fade">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">เพิ่มข้อมูลบุคคล</h4>
          </div>
          <div class="modal-body">
              <div id="div-create-people"></div>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" onclick="fncSavePeople();">บันทึกข้อมูล</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<div aria-hidden="true" role="dialog" tabindex="-1" id="md-create-people-confirm" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ยืนยัน</h4>
          </div>
          <div class="modal-body">
              <p>ยืนยันการบันทึกข้อมูลบุคคล?</p>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" id="btn-create-people-confirm">ตกลง</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  //##ที่ตั้งบริษัทฯ เลือกจังหวัด ##//
  $("#company_province_id").change(function(){        
      getAmphurJson($("#company_amphur_id"),$("#company_district_id"),$(this).val());     
  });
  $("#company_amphur_id" ).change(function(){
      getDistrictJson($("#company_district_id"),$(this).val());      
  });

  function fncCreatePeople(){
    urlSend = WEB_HTTP_HOST+'/load/people/create';
    $('#div-create-people').load(urlSend, function(responseTxt, statusTxt, xhr){

      if ( statusTxt == "error" ) {
          var msg = "Sorry but there was an error: ";
              $('#md-error p' ).text(msg + xhr.status + " " + xhr.statusText);
              $('#md-error').modal('show');
          return false;
      } else {
        $('#md-create-people').modal('show');
      }
     });
  }
  function fncEditPeople(id){
    urlSend = WEB_HTTP_HOST+'/load/people/edit?id='+id;
    $('#div-create-people').load(urlSend, function(responseTxt, statusTxt, xhr){

      if ( statusTxt == "error" ) {
          var msg = "Sorry but there was an error: ";
              $('#md-error p' ).text(msg + xhr.status + " " + xhr.statusText);
              $('#md-error').modal('show');
          return false;
      } else {
        $('#md-create-people').modal('show');
      }
     });
  }
  function fncLoadViewPeople(id){
    urlSend = WEB_HTTP_HOST+'/load/people/view?id='+id;
    $('#view_people').load(urlSend, function(responseTxt, statusTxt, xhr){

      if ( statusTxt == "error" ) {
          var msg = "Sorry but there was an error: ";
              $('#md-error p' ).text(msg + xhr.status + " " + xhr.statusText);
              $('#md-error').modal('show');
          return false;
      }
     });
  }
   //##บันทึกการสร้างข้อมูล##//
  function fncSavePeople(){
    if($("#frm-people input[name=people_name]").val()==""){
          $('#md-error p' ).text('กรุณากรอกชื่อ-นามสกุล');
          $('#md-error').modal('show');
    } else {
      $('#md-create-people').modal('hide'); 
      $('#md-create-people-confirm').modal('show');      
    }

  }

  $('#btn-create-people-confirm').off("click").click(function(e) {
      $('#btn-create-people-confirm').addClass('disabled');
      $('#md-create-people-confirm').modal('hide');

      $.ajax({
          url: WEB_HTTP_HOST+'/load/people/save',
          cache: false,
          contentType: false,
          processData: false,                       
          type: 'POST',
          data: new FormData($("#frm-people")[0]),
          success: function(rs) {
              $('#btn-create-people-confirm').removeClass('disabled');
              obj = JSON.parse(rs); 
              if(obj.result=='false'){
                  $('#md-error p' ).text(obj.message);
                  $('#md-error').modal('show');  
              } else {
                  $('#md-error p' ).text('บันทึกข้อมูลเรียบร้อยแล้ว');
                  $('#md-error').modal('show');
                  fncLoadViewPeople(obj.id);                  
              }
          },
          error : function(rs){
              $('#btn-create-people-confirm').removeClass('disabled');
              $('#md-error p' ).text('!!!Server Error');
              $('#md-error').modal('show');
          }
      });
  });

  /*ข้อมูลเกษตรกร :: ชื่อ - สกุล*/
  $('#search_people_id').typeahead({
      hint: true,
      highlight: true,
      minLength: 2,
      displayKey: 'name',
      limit: 20,
      source:  function (query, process) {
        $('#view_people').empty();
        return $.get(WEB_HTTP_HOST+'/load/autocomplete/people', {query:query}, function (data) {
            data = $.parseJSON(data);
              return process(data);
          });
      },
      afterSelect :function (item){
        $('#people_id').val(item.id);
        fncLoadViewPeople(item.id);
      }
  });

  /*กลุ่มเกษตกร*/
  $('#search_farmer_group_id').typeahead({
      hint: true,
      highlight: true,
      minLength: 2,
      displayKey: 'name',
      limit: 20,
      source:  function (query, process) {
        $('#view_people').empty();
        return $.get(WEB_HTTP_HOST+'/load/autocomplete/farmer-group', {query:query}, function (data) {
            data = $.parseJSON(data);
              return process(data);
          });
      },
      afterSelect :function (item){
        $('#farmer_group_id').val(item.id);
      }
  });
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

        data = $("#frm-main").serialize();
        fncConfirmSave(me,data,"<?=$page_starturl?>save","<?=$page_starturl?>index");
        e.stopPropagation();
  });
</script>