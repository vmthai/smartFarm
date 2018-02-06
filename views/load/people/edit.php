<form class="form-horizontal" id="frm-people" novalidate>
  <input type="hidden" id="id" name="id" value="<?=$data->id?>">
    <div class="row">
      <div class="col-md-7">
        <div class="form-group control-group">
          <label for="p_name">ชื่อ - สกุล</label>
          <input type="text" class="form-control border-info" placeholder="Full Name" name="p_name" value="<?=$data->p_name?>" required>
        </div>
        <div class="form-group">
            <label for="farmer_pid">เลขที่บัตรประชาชน</label>
            <input type="text" id="id_card" class="form-control border-info format-idcard" placeholder="People ID" name="id_card" value="<?=$data->id_card?>" required>
        </div>
        <div class="form-group">
          <label for="phone">โทรศัพท์</label>
          <input type="text" id="phone" class="form-control border-info" placeholder="Phone No." name="phone" value="<?=$data->phone?>" required>
        </div>
        <div class="form-group">
          <label for="email">E-Mail</label>
          <input type="text" id="email" class="form-control border-info" placeholder="E-mail" name="email" value="<?=$data->email?>" required>
        </div>
      </div>

      <div class="col-md-5">
        <div class="form-group">
          <label for="sex">Sex</label>
          <div style="margin-top:5px;">
            <label class="radio-inline">
                <input type="radio" class="form-radio" name="sex" value="M" <?=($data->sex=='M')?'checked':''?> >
                 ชาย
            </label>&nbsp;
            <label class="radio-inline">
                <input type="radio" class="form-radio" name="sex" value="F" <?=($data->sex=='F')?'checked':''?>>
                 หญิง
            </label>  
          </div>                                         
        </div>
        <?php
        $path_image = ($data->path_image=='')?_HTTP_HOST_.'/uploads/no-image.png':_HTTP_HOST_.'/'.$data->path_image;
        ?>
        <div class="fileupload fileupload-new" data-provides="fileupload">
          <div class="fileupload-new thumbnail" style="width: 120px; height: 120px;"><img src="<?=$path_image?>" alt="Profile Avatar" /></div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 132px; max-height: 132px; line-height: 20px;"></div>
            <div><span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="fileUpload"/></span>
            <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
          </div>
        </div>

      </div>
    </div>
  <div class="heading">ที่อยู่ตามบัตรประชาชน</div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
          <label for="address_text">เลขที่</label>
          <input type="text" id="address_text" class="form-control border-primary" placeholder="Address" name="address_text" value="<?=$data->address_text?>">
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
              <option value="<?=$k?>" <?=($data->address_province_id==$k)?'selected':'';?>><?=$v?></option>
              <?php  } ?>
          </select> 
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
          <label for="address_amphur_id">อำเภอ/เขต</label>
          <select class="form-control" name="address_amphur_id" id="address_amphur_id">
            <option value="">---กรุณาเลือก---</option>
            <?php  foreach($amphurs as $k => $v){ ?>
            <option value="<?=$k?>" <?=($data->address_amphur_id==$k)?'selected':'';?>><?=$v?></option>
            <?php  } ?>
          </select>                                   
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
          <label for="address_district_id">ตำบล/แขวง</label>
          <select class="form-control" name="address_district_id" id="address_district_id">
            <option value="">---กรุณาเลือก---</option>
            <?php  foreach($districts as $k => $v){ ?>
            <option value="<?=$k?>" <?=($data->address_district_id==$k)?'selected':'';?>><?=$v?></option>
            <?php  } ?>
          </select> 
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="address_zipcode">รหัสไปรษณีย์</label>
        <input type="text" class="form-control number" name="address_zipcode" maxlength="5" placeholder="Postcode" value="<?=$data->address_zipcode?>">                            
      </div>
    </div>
  </div>

  <div class="heading">ส่งเอกสาร <input type="checkbox" class="form-checkbox" name="use_address" value="1" onclick="copyAddressPeople(this);" <?=($data->use_address=="1")?'checked':''?>> ใช้ที่อยู่ตามบัตรประชาชน</div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
          <label for="contact_text">เลขที่</label>
          <input type="text" id="contact_text" class="form-control border-primary" placeholder="Address" name="contact_text" value="<?=$data->contact_text?>">
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
              <option value="<?=$k?>" <?=($data->contact_province_id==$k)?'selected':'';?>><?=$v?></option>
              <?php  } ?>
          </select> 
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
          <label for="contact_amphur_id">อำเภอ/เขต</label>
          <select class="form-control" name="contact_amphur_id" id="contact_amphur_id">
           <?php  foreach($contact_amphurs as $k => $v){ ?>
            <option value="<?=$k?>" <?=($data->contact_amphur_id==$k)?'selected':'';?>><?=$v?></option>
            <?php  } ?>
          </select>                                   
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
          <label for="contact_district_id">ตำบล/แขวง</label>
          <select class="form-control" name="contact_district_id" id="contact_district_id">
            <?php  foreach($contact_districts as $k => $v){ ?>
            <option value="<?=$k?>" <?=($data->contact_district_id==$k)?'selected':'';?>><?=$v?></option>
            <?php  } ?>
          </select> 
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="contact_zipcode">รหัสไปรษณีย์</label>
        <input type="text" class="form-control number" name="contact_zipcode" maxlength="5" placeholder="Postcode" value="<?=$data->contact_zipcode?>">                            
      </div>
    </div>
  </div>

</form>
<style type="text/css">
  .datepicker.datepicker-dropdown.dropdown-menu {
    z-index: 1040!important;
  }
</style>
<script type="text/javascript">
   //##CREATE เลือกจังหวัด ที่อยู่ตามบัตร ##//
  $("#address_province_id").change(function(){        
      getAmphurJson($("#address_amphur_id"),$("#address_district_id"),$(this).val());     
  });
  $("#address_amphur_id" ).change(function(){
      getDistrictJson($("#address_district_id"),$(this).val());      
  });
   //##CREATE เลือกจังหวัด ที่ติดต่ิ ##//
  $("#contact_province_id").change(function(){        
      getAmphurJson($("#contact_amphur_id"),$("#contact_district_id"),$(this).val());       
  });
  $("#contact_amphur_id").change(function(){
      getDistrictJson($("#contact_district_id"),$(this).val());   
  });
</script>

<!-- copy address -->
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
</script>