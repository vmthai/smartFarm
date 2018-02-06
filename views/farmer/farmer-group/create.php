<section id="css-classes" class="card">

  <div class="card-body collapse in">
      <div class="card-block">
          <form id="frm-main" class="form form-horizontal" novalidate="">
            <input type="hidden" name="id" value="">
            <div class="form-body">

              <h4 class="form-section green"><i class="icon-head"></i>ข้อมูลผู้ประสานงาน
                <span style="float:right; line-height:0rem;">
                <button type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>index');">
                <i class="icon-rewind"></i>Back
                </button>    
                </span>                    
              </h4>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control border-info" placeholder="ตัวอย่าง นายสามารถ  ชาญชัย" name="contact_name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="sex">Sex</label>
                    <div style="margin-top:5px;">
                      <label class="radio-inline">
                          <input type="radio" class="form-radio" name="contact_sex" value="F" >
                           ชาย
                      </label>&nbsp;
                      <label class="radio-inline">
                          <input type="radio" class="form-radio" name="contact_sex" value="M">
                           หญิง
                      </label>  
                    </div>                                         
                  </div>
                </div>
              </div>
              <div class="row">         
                  <div class="col-md-6">
                      <div class="form-group control-group">
                          <label for="email">E-mail</label>
                          <input type="email" id="contact_email" class="form-control border-info" placeholder="E-mail" name="contact_email">
                      </div>
                      <div class="form-group">
                          <label for="phone">Contact Number</label>
                          <input type="text" class="form-control border-info" placeholder="เบอร์โทรศัพท์" name="contact_phone">
                      </div>
                      <div class="form-group">
                          <label for="projectinput4">Position</label>
                          <input type="text" class="form-control border-info" placeholder="ตำแหน่งในองค์กร" name="contact_position">
                      </div>
                  </div>   
                  <div class="row col-md-6">
                      <div class="col-md-12">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                          <div class="fileupload-new thumbnail" style="width: 120px; height: 120px;"><img src="<?=_HTTP_HOST_?>/uploads/no-image.png" alt="Profile Avatar" /></div>
                          <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 132px; max-height: 132px; line-height: 20px;"></div>
                          <div>
                          <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="fileUpload"/></span>
                          <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                          </div>
                      </div>   
                      </div>   
                      
                      <div class="card-block col-md-12" style="margin-top:6px;">
                      <label for="projectinput4">Active : </label>&nbsp;&nbsp;
                      <input type="checkbox" class="form-checkbox" name="active" value="1" checked>
                      </div>
                  </div>
              </div>
              <h4 class="form-section green"><i class="icon-cog3"></i>ข้อมูลกลุ่มเกษตรกร</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                      <label for="GroupName">ชื่อกลุ่ม</label>
                      <input type="text" id="farmer_gname" class="form-control border-primary" placeholder="Groupname" name="farmer_gname" required>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group control-group">
                        <label for="CompanyName">ชื่อบริษัทฯ</label>
                        <input type="text" id="companyName" class="form-control border-primary" placeholder="companyName" name="company_name" required>                                    
                    </div>
                </div>
              </div> 
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group control-group">
                          <label for="projectinput1">ประเภทกลุ่มเพาะปลูก</label>
                          <select class="form-control border-primary" id="master_group_id" name="master_group_id" required>
                          <option value="">---กรุณาเลือก กลุ่มเกษตกร---</option>
                          <?php  foreach($groups as $k => $v){ ?>
                        <option value="<?=$k?>"><?=$v?></option>
                          <?php  } ?>
                          </select> 
                      </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group control-group">
                          <label for="UserName">เลขทะเบียนการค้า/เลขผู้เสียภาษี</label>
                          <input type="text" id="company_tax" class="form-control border-primary" placeholder="Tax ID" name="company_tax" required>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group control-group">
                      <label for="UserName">โทรศัพท์</label>
                      <input type="text" id="company_phone" class="form-control border-primary" placeholder="Phome" name="company_phone" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group control-group">
                      <label for="emailAddress">Email</label>
                      <input type="email" id="company_email" class="form-control border-primary" placeholder="Email Address" name="company_email" required>                                    
                  </div>
                </div>
              </div>
              <div class="heading">ที่ตั้งบริษัทฯ</div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="address_text">เลขที่</label>
                      <input type="text" id="address_text" class="form-control border-primary" placeholder="Address" name="address_text" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="address_province_id">จังหวัด</label>
                      <select class="form-control" name="address_province_id" id="address_province_id">
                          <option value="">---กรุณาเลือก จังหวัด---</option>
                          <?php  foreach($provinces as $k => $v){ ?>
                          <option value="<?=$k?>"><?=$v?></option>
                          <?php  } ?>
                      </select> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="address_amphur_id">อำเภอ/เขต</label>
                     <select class="form-control" name="address_amphur_id" id="address_amphur_id">
                        <option value="">---กรุณาเลือก อำเภอ/เขต---</option>
                      </select>                                   
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="address_district_id">ตำบล/แขวง</label>
                      <select class="form-control" name="address_district_id" id="address_district_id">
                        <option value="">---กรุณาเลือก ตำบล/แขวง---</option>
                      </select> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address_zipcode">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control number" name="address_zipcode" maxlength="5" placeholder="Postcode" >                            
                  </div>
                </div>
              </div>

              <div class="heading">ส่งเอกสาร</div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>
                        <input type="checkbox" class="form-checkbox" name="use_address" value="1" onclick="copyAddressPeople(this);"> ใช้ตามที่ตั้งบริษัทฯ
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="contact_text">เลขที่</label>
                      <input type="text" id="contact_text" class="form-control border-primary" placeholder="Address" name="contact_text" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="contact_province_id">จังหวัด</label>
                      <select class="form-control" name="contact_province_id" id="contact_province_id">
                          <option value="">---กรุณาเลือก จังหวัด---</option>
                          <?php  foreach($provinces as $k => $v){ ?>
                          <option value="<?=$k?>"><?=$v?></option>
                          <?php  } ?>
                      </select> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="contact_amphur_id">อำเภอ/เขต</label>
                     <select class="form-control" name="contact_amphur_id" id="contact_amphur_id">
                        <option value="">---กรุณาเลือก อำเภอ/เขต---</option>
                      </select>                                   
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="contact_district_id">ตำบล/แขวง</label>
                      <select class="form-control" name="contact_district_id" id="contact_district_id">
                        <option value="">---กรุณาเลือก ตำบล/แขวง---</option>
                      </select> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_zipcode">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control number" name="contact_zipcode" maxlength="5" placeholder="Postcode" >                            
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
<script type="text/javascript">
  function copyAddressPeople(obj){
    if($(obj).prop('checked') == true){
      $('input[name=contact_text]').val($('input[name=address_text]').val());
      $('input[name=contact_zipcode]').val($('input[name=address_zipcode]').val());
      var address_province = $('#address_province_id').val();
      var address_amphur = $('#address_amphur_id').val();
      var address_district = $('#address_district_id').val();
      $('#contact_province_id').val(address_province);
      $.getJSON(WEB_HTTP_HOST+"/address/data/amphur?id="+address_province, function(jsonData){
          select = '<option value="">--กรุณาเลือก--</option>';
          $.each(jsonData, function(id,name)
          {
              select +='<option value="'+id+'">'+name+'</option>';
          });
          select += '</select>';
          /*--Set Aumphoe--*/
          $('#contact_amphur_id').html(select);
          $('#contact_amphur_id').val(address_amphur);
      });
      $.getJSON(WEB_HTTP_HOST+"/address/data/district?id="+address_amphur, function(jsonData){
          select = '<option value="">--กรุณาเลือก--</option>';
            $.each(jsonData, function(id,name)
            {
                 select +='<option value="'+id+'">'+name+'</option>';
             });
          select += '</select>';
          $('#contact_district_id').html(select);
          $('#contact_district_id').val(address_district);
      });
    }
  }

   //## เลือกจังหวัด ที่อยู่ตามบัตร ##//
  $("select[id=address_province_id]").change(function(){        
      getAmphurJson($("select[id=address_amphur_id]"),$("select[id=address_district_id]"),$(this).val());     
  });
  $("select[id=address_amphur_id]" ).change(function(){
      getDistrictJson($("select[id=address_district_id]"),$(this).val());      
  });

   //## เลือกจังหวัด ที่ติดต่ิ ##//
  $("select[id=contact_province_id]").change(function(){        
      getAmphurJson($("select[id=contact_amphur_id]"),$("select[id=contact_district_id]"),$(this).val());       
  });
  $("select[id=contact_amphur_id]").change(function(){
      getDistrictJson($("select[id=contact_district_id]"),$(this).val());   
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

        data = new FormData($("#frm-main")[0]);
        fncConfirmSaveFile(me,data,"<?=$page_starturl?>save","<?=$page_starturl?>index");
        e.stopPropagation();
  });
</script>