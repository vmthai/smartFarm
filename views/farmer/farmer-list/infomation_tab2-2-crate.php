<div class="row text-center">
  <div class="col-md-12 width-100-per" style="text-align:center; margin-top: -15px;">
      <table class="table borderless" style="border: hidden;">
      <thead class="">
          <tr>
              <th width="15%">
                  <button type="button" class="btn btn-secondary primary" onClick="fncPlotView('<?=$data->farmer_list_id?>');" style="float:left; margin-top: 0px; margin-left: -12px; margin-bottom:0px;" >
                      <i class="icon-rewind"></i> Back
                  </button>                    
              </th>
              <th width="*" style="text-align: center;">
              <h5 class=""><?=$data->codename?> [<?=$data->count_all?> แปลง] / [<?=$data->sum_area['rai']?> ไร่]</h5>
              </th>
              <th width="15%">&nbsp;</th>
          </tr>
      </thead>
      </table>
  </div>
</div>
<div id="agGroup_create_iframe_row" class="row">
    <div class="col-md-9 col-sm-12 padding-0">
      <iframe id="agGroup_create_iframe" src="" style="border:0px; margin-left:-12px;" width="102%" height="100%" frameborder="1" scrolling="no" align="middle;">
      </iframe>
    </div>
    <div class="col-md-3 col-sm-12 text-xs-center bg-grey bg-lighten-2">
        <!-- ***************************************************** -->
        <div class="row match-height" style="margin-top:10px;">

            
            <form class="form" id="tab2FormSub" novalidate="">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="farmer_area_id" value="<?=$data->id?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="control-group">
                                <label style="width:91.5%; text-align:center; margin-top:10px;">
                                    <!-- <h5>ข้อมูลพื้นที่เพาะปลูก</h5> -->
                                    <fieldset class="form-group position-relative" style="text-align-center">
                                            <input type="text" id="namePlace" class="form-control" placeholder="ค้นหาจังหวัด / อำเภอ" name="name_place">
                                            <div class="form-control-position">
                                            <i id="SearchPlace" class="buttonA icon-search primary lighten-2 font-medium-4"></i>
                                            </div>                                                         
                                            </fieldset> 
                                </label>
                                
                            </div>
                            <hr style="margin-top:-5px;">
                            <div class="control-group">
                                <label class="width-30-per" style=" text-align:left;">Code</label>
                                <input type="text" class="form-input width-60-per mb-1" name="codename" required>
                            </div>
                            <div class="control-group">
                            <label class="width-30-per mb-0" style=" text-align:left;">Lat</label>
                                <input type="text" class="form-input width-60-per mb-1" name="lat_value" required>
                            </div>
                            <div class="control-group">
                            <label class="width-30-per mb-0" style=" text-align:left;">Long</label>
                                <input type="text" class="form-input width-60-per mb-1" name="lon_value" required>
                            </div>
                            <div class="control-group">
                            <label class="width-30-per mb-0" style=" text-align:left;">Zoom</label>
                                <input type="text" class="form-input width-60-per mb-1" name="zoom_value" required>
                            </div>
                            <div class="control-group">
                            <label class="width-30-per" style=" text-align:left;">พื้นที่</label>
                            <input type="text" class="form-input width-20-per mb-1" name="rai" placeholder="ไร่" maxlength="6" required>
                            <input type="text" class="form-input width-20-per mb-1" name="ngan" placeholder="งาน" maxlength="3" required>
                            <input type="text" class="form-input width-20-per mb-1" name="square" placeholder="ตารางวา" maxlength="3" required>
                            </div>                                                                    
                            <div class="control-group">
                            <label class="width-30-per mb-0" style=" text-align:left;">ไฟล์</label>
                                <input type="file" class="form-input width-60-per mb-1" name="fileUpload">
                            </div>
                            <div class="control-group">
                              <label class="width-30-per mb-0" style=" text-align:left;">brownerly</label>
                              <input type="text" class="form-input width-60-per mb-1">
                            </div>
                        
                        </div>
                    </div>

                </div>

                <hr>

                <div class="col-md-12 col-sm-12 text-xs-center" style="margin-top:13px;">
                    <div class="heading-elements">
                        <ul class="list-inline mb-0" style="text-align:center;">
                            <li>
                                <button type="button" class="btn btn-warning" id="xAGgroup_map" style="float:right; margin-top: 0px; margin-right: 0px; margin-bottom:0px;"><i class="icon-undo"></i> Back
                                </button>
                            </li>
                            <li>
                            <button type="submit" class="btn btn-primary" id="add_aresub" style="float:right; margin-top: 0px; margin-right: 0px; margin-bottom:0px;"><i class="icon-check2"></i> Save
                            </button>
                            </li>
                        </ul>
                    </div>
                </div>                              
            </form> 

        </div>
        <!-- ***************************************************** -->
    </div>
</div>

<div id="md-areasub-confirm-save" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ยืนยันการบันทึกข้อมูล!</h4>
          </div>
          <div class="modal-body">
              <p>กรุณาตรวจสอบข้อมูล หากยืนยันการบันทึกข้อมูล กด "ตกลง"?</p>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" type="button" id="btn-areasub-confirm-save">บันทึก</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $('#agGroup_create_iframe').height($('#agGroup_create_iframe_row').height());
    $("#agGroup_create_iframe").attr("src", WEB_HTTP_HOST+"/farmer/farmer-list/gmaps-farea");
  });
  
  // $('#add_aresub').off("click").click(function(e) {
  //   $('#md-areasub-confirm-save').modal('show');
  // });
  /*เพิ่มพื้นที่เพาะปลูก START*/
  $("#tab2FormSub input").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function($form, event, errors) {
            $('#add_aresub').removeClass('disabled');
        },
        submitSuccess: function($form, event) {
            event.preventDefault();
            $('#add_aresub').removeClass('disabled');
            $('#md-areasub-confirm-save').modal('show');
        }
  });
  $('#btn-areasub-confirm-save').off("click").click(function(e) {
    
    $('#md-areasub-confirm-save').modal('hide');
    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        url: WEB_HTTP_HOST+'/'+'farmer/farmer-list-tab2/save',
        type: 'POST',
        data: new FormData($("#tab2FormSub")[0]),
        success: function(result) {
              obj = JSON.parse(result); 
              $('#md-error p' ).text(obj.message);
              $('#md-error').modal('show');           
              if(obj.result=='true') {console.log('true');
                    $('#md-error').on('hidden.bs.modal', function (e) {
                        fncPlotView('<?=$data->farmer_list_id?>');
                        $('#md-error').off('hidden.bs.modal');
                    });  
              }
        },
        error : function(result){
             $('#md-error p' ).text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
             $('#md-error').modal('show');
        }
    });
  });

</script>
