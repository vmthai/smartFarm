<section id="css-classes" class="card">

    <div class="card-body collapse in">
        <div class="card-block">
            <form id="frm-main" class="form form-horizontal" novalidate="">
              <input type="hidden" name="id" value="">
              <div class="form-body">

                <h4 class="form-section green"><i class="icon-head"></i> <?=$page_name?>
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
                      <input type="text" class="form-control border-info" placeholder="ตัวอย่าง นายสามารถ  ชาญชัย" name="name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="sex">Sex</label>
                        <div style="margin-top:5px;">
                        <label class="radio-inline">
                            <input type="radio" class="form-radio" name="sex" value="F" >
                             ชาย
                        </label>&nbsp;
                        <label class="radio-inline">
                            <input type="radio" class="form-radio" name="sex" value="M">
                             หญิง
                        </label>  
                        </div>                                         
                    </div>
                  </div>
                </div>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" id="email" class="form-control border-info" placeholder="E-mail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Contact Number</label>
                            <input type="text" class="form-control border-info" placeholder="เบอร์โทรศัพท์" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="projectinput4">Birth Date</label>
                            <input class="form-control border-info" type="text" placeholder="dd/mm/YY" data-provide="datepicker" data-date-language="th-th" data-date-autoclose="true" name="birth_date">
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
                <h4 class="form-section green"><i class="icon-cog3"></i> System Info</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group control-group">
                            <label for="projectinput1">เลื่อกกลุ่มใช้งาน</label>
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
                            <label for="projectinput1">เลื่อกสิทธิใช้งาน</label>
                            <select class="form-control border-primary" id="admin_roll_id" name="admin_roll_id" required>
                            <option value="">---กรุณาเลือก สิทธิ์การใช้---</option>
                            <?php  foreach($dataRoll as $k => $v){ ?>
                          <option value="<?=$k?>"><?=$v?></option>
                            <?php  } ?>
                        </select>                                         
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group control-group">
                          <label for="UserName">Username</label>
                          <input type="text" id="Username" class="form-control border-primary" placeholder="Username" name="username" required>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group control-group">
                        <label for="pnew_password">New Password</label>
                        <input type="text" id="new_password" class="form-control border-primary" placeholder="Password" name="new_password" required>                                    
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