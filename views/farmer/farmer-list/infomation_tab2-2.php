    <div class="row text-center">

        <div class="col-md-12 width-100-per" style="text-align:center; margin-top: -15px;">
        <table class="table borderless" style="border: hidden;">
        <thead class="">
            <tr>
                <th width="15%">
                    <button type="button" class="btn btn-secondary primary" onClick="fncPlotBack();" style="float:left; margin-top: 0px; margin-left: -12px; margin-bottom:0px;" >
                        <i class="icon-rewind"></i> Back
                    </button>                    
                </th>
                <th width="*" style="text-align: center;">
                <h5 class=""><?=$data->codename?> [<?=$data->count_all?> แปลง] / [<?=$data->sum_area['rai']?> ไร่]</h5>
                </th>
                <th width="15%">                
                    <button type="button" class="btn btn-secondary primary" onClick="fncAddAreaSub('<?=$data->id?>');" style="float:right; margin-top: 0px; margin-right: -12px; margin-bottom:0px;" >
                    <i class="icon-layers"></i>&nbsp; เพิ่มแปลงเพาะปลูก
                    </button>
                </th>
            </tr>
        </thead>
        </table>
        </div>
        </div>

    <div class="row text-center">
    <div class="col-md-12 width-100-per" style="margin-top: -15px;">
        <div class="table-responsive width-100-per" style="">
            <table class="table table-striped" id="plot-lists">
                <thead class="bg-green bg-lighten-2">
                    <tr>
                    <th class="text-center" width="6%">ลำดับ</th>
                    <th class="text-center" width="20%">Code Name</th>
                    <th class="text-center" width="20%">ขนาดพื้นที่</th>
                    <th class="text-center" width="20%">ภาพถ่ายทางอากาศ</th>
                    <th class="text-center" width="20%">ขอบเขตแปลง</th>
                    <th class="text-center" width="*"><i class="icon_cogs"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data->subs as $k => $v) { ?>
                <tr>
                    <td class="text-right"><?=$k+1?></td>
                    <td class="text-left"><?=$v->codename?></td>
                    <td class="text-left"><?=$v->rai?> ไร่ <?=$v->ngan?> งาน <?=$v->square?> ตารางวา</td>
                    <td class="text-left"><?=$v->path_file?></td>
                    <td class="text-left">lat <?=$v->lat_value?> lon <?=$v->lon_value?></td>
                    <td class="text-center">
                    <a data-action="expand" class="btn btn-sm btn-outline-primary" href="javascript:fncEditAreaSub('<?=$v->id?>');"><span class="icon-pencil2"></span></a>
                    <a data-action="expand" class="btn btn-sm btn-outline-danger" href="javascript:fncAreaSubClickDeltete('<?=$v->id?>','<?=$k+1?>');"><span class="icon-bin2"></span></a>

                    </td>
                </tr>
                <?php } ?>
                        
                </tbody>
            </table>      
        </div> 
    </div>
    </div>

<div id="md-areasub-confirm-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ยืนยันการลบข้อมูล!</h4>
          </div>
          <div class="modal-body">
              <p>ท่านต้องการทำการลบข้อมูลรายการที่ <span id="areasub-span-number"></span> นี้ใช่หรือไม่?</p>
              <form class="form-horizontal" id="frm-areasub-confirm-delete">
                <input type="hidden" name="id">
              </form>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" type="button" id="btn-areasub-confirm-delete">ลบรายการ</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  function fncAreaSubClickDeltete(id,number){
      $('#md-areasub-confirm-delete').modal('show');
      $('#areasub-span-number').text(number);console.log('id',id);
      $('#frm-areasub-confirm-delete input[name=id]').val(id);
  }

  $('#btn-areasub-confirm-delete').off("click").click(function(e) {
    
    $('#md-areasub-confirm-delete').modal('hide');
    $.ajax({
        url: WEB_HTTP_HOST+'/'+'farmer/farmer-list-tab2/delete',
        type: 'POST',
        data: $("#frm-areasub-confirm-delete").serializeArray(),
        success: function(result) {
              obj = JSON.parse(result); 
              $('#md-error p' ).text(obj.message);
              $('#md-error').modal('show');           
              if(obj.result=='true') {console.log('true');
                    $('#md-error').on('hidden.bs.modal', function (e) {
                        fncLoadContent('farmer/farmer-list/info?id=<?=$data->farmer_list_id?>&tab=2');
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
