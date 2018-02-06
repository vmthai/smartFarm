<section id="css-classes" class="card">

    <div class="card-body collapse in">

            <div class="card-header">
                <h4 class="card-title"> <?=$page_name?></h4>
                  <div class="heading-elements form-actions right">
                      <button id="addFGroup" type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>create');">
                          <i class="icon-database2 white"></i> New Template
                      </button>
                  </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="tb-caltivation">
                  <thead class="bg-green bg-lighten-2">
                    <tr>
                      <th class="text-center"  width="5%">ลำดับ</th>
                      <th width="20%">ชื่อแผนเพาะปลูก</th>
                      <th width="20%">ประเภทการปลูก</th>
                      <th width="20%">เมล็ดพันธ์</th>
                      <th width="10%">ระยะเวลา</th>
                      <th width="10%">ผลผลิต/ไร่</th>
                      <th>Active</th>
                      <th class="text-center" width="*"><i class="icon_cogs"></i> Action</th>
                    </tr>
                  </thead>
                  <tbody>                         
                  </tbody>
                </table>
            </div>
    </div>
</section>
<script type="text/javascript">
  var oTable = $('#tb-caltivation').DataTable({
    "stateSave": true,
    "bInfo" : false,
    "lengthChange": true,
    "lengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
    "columnDefs": [
      { "targets": 0, "searchable": false, "orderable": true, "className": "text-center" },
      { "targets": 1, "searchable": true, "orderable": false },
      { "targets": 2, "searchable": true, "orderable": false },
      { "targets": 3, "searchable": true, "orderable": false },
      { "targets": 4, "searchable": false, "orderable": false, "className": "text-right" },
      { "targets": 5, "searchable": false, "orderable": false, "className": "text-right" },
      { "targets": 6, "searchable": false, "orderable": false, "visible": false, "className": "text-center" },
      { "targets": 7, "searchable": false, "orderable": false, "className": "text-center" },
    ],
    "order": [ 0, "asc" ],
    //"processing": true,//default false
    "serverSide": true,
    "ajax": "<?=_HTTP_HOST_?>/<?=$page_starturl?>find"
  });

 

  //key enter to search
  $('#tb-caltivation_filter input').unbind();
  $('#tb-caltivation_filter input').bind('keyup', function(e) {
    if(e.keyCode == 13) {
      oTable.search( this.value ).draw();  
    }
  }); 

  $('#btn-confirm-delete').off("click").click(function(e) {
      data = $("#frm-confirm-delete").serializeArray();
      fncConfirmDelete(data,"<?=$page_starturl?>delete?bid=<?=getBID();?>","<?=$page_starturl?>index?bid=<?=getBID();?>");
  });
</script>