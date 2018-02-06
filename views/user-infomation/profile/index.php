<section id="css-classes" class="card">

  <div class="card-body collapse in">
    <div class="card-block">
      <form class="form-horizontal" id="frm-main" novalidate>
        <div class="form-body">
          <input type="hidden" id="id" name="id" value="<?=$data->id?>">
            <div class="row">
              <label class="col-sm-2">ชื่อ-นามสกุล</label>
              <div class="col-md-6"> 
                <div class="form-group control-group">
                  <input type="text" class="form-control border-primary" placeholder="ตัวอย่าง นายสามารถ  ชาญชัย" id="name" name="name" value="<?=$data->name?>">
                </div>
              </div>
              <label class="col-sm-2">Active</label>
              <div class="col-md-4">                      
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="form-checkbox" name="active" value="1" <?=($data->active==1)?'checked':''?>>
                    </label>
                  </div>
              </div>
            </div> 
            <div class="row">
              <label class="col-sm-2">วันเกิด</label>
              <div class="col-md-4">   
                  <div class="form-group control-group">
                      <div class="input-group date">
                        <input class="form-control border-primary" type="text" placeholder="dd/mm/YY" data-provide="datepicker" data-date-language="th-th" data-date-autoclose="true" name="birth_date" value="<?=$data->birth_date_th?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div> 
                  </div>
              </div>
              <label class="col-sm-2">เพศ</label>
              <div class="col-md-4">                        
                  <div class="form-group">
                      <label class="radio-inline">
                          <input type="radio" class="form-radio" name="sex" value="F" <?=($data->sex=='F')?'checked':''?>> ชาย
                      </label>
                      <label class="radio-inline">
                          <input type="radio" class="form-radio" name="sex" value="M" <?=($data->sex=='M')?'checked':''?>> หญิง
                      </label>
                  </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2">อีเมล</label>
              <div class="col-md-4">   
                  <div class="form-group">
                      <input type="email" class="form-control border-primary" placeholder="xxxx@xxxxx.xxx" id="email" name="email" value="<?=$data->email?>">
                  </div>
              </div>
              <label class="col-sm-2">เบอร์โทรศัพท์</label>
              <div class="col-md-4">                        
                  <div class="form-group">
                      <input type="text" class="form-control border-primary" placeholder="เบอร์โทรศัพท์ (ระบุตัวเลข 0-9)" id="phone" name="phone" value="<?=$data->phone?>">
                  </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2">Username</label>
              <div class="col-md-4">   
                  <div class="form-group control-group">
                      <input type="text" class="form-control border-primary" placeholder="Username" id="username" name="username" value="<?=$data->username?>" onblur="checkTrimData(this);" required>
                  </div>
              </div>
              <label class="col-sm-2">New Password</label>
              <div class="col-md-4">                        
                  <div class="form-group">
                      <input type="text" class="form-control border-primary" placeholder="Password" id="new_password" name="new_password" maxlength="30">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 text-center">
                  <button class="btn btn-primary" id="btn-save" type="submit">Save</button>
              </div>
            </div>
        </div>
      </form>

    </div>
  </div>
</section>
<!-- jquery validate js -->
<script type="text/javascript">

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
  });

</script>