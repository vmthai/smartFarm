<table class="table table-bordered table-hover" id="tb-config-user">
  <thead>
    <tr>
      <th width="6%">ลำดับ</th>
      <th width="30%">ชื่อ-นามสกุล</th>
      <th width="20%">ศูนย์อำนวยความสะดวก</th>
      <th width="15%">โทรศัพท์</th>
      <th class="text-center" width="15%">สิทธิ์ผู้ใช้</th>
      <th class="text-center" ><i class="icon_cogs"></i> Action</th>
    </tr>
  </thead>
  <tbody>
         
  </tbody>
</table>

<script type="text/javascript">
  var oTable = $('#tb-config-user').DataTable({
    /*"language": {
      "processing": '<i class="fa fa-spinner fa-spin fa-5x"></i>'
    },*/
    "stateSave": true,
    "lengthChange": false,
    "lengthMenu": [[100, 200], [100, 200]],
    "columnDefs": [
      { "searchable": false, "targets": 0 },
      { "searchable": false, "orderable": false, "targets": 5 },
      {"className": "text-right", "targets": 0},
    ],
    "order": [ 0, "asc" ],
    //"processing": true,//default false
    "serverSide": true,
    "ajax": "<?=_HTTP_HOST_?>/config/user/find"
  });

  //key enter to search
  $('#tb-config-user_filter input').unbind();
  $('#tb-config-user_filter input').bind('keyup', function(e) {
    if(e.keyCode == 13) {
      oTable.search( this.value ).draw();  
    }
  }); 

  $('#btn-confirm-delete').off("click").click(function(e) {
      data = $("#frm-confirm-delete").serializeArray();
      fncConfirmDelete(data,"<?=$page_starturl?>delete?bid=<?=getBID();?>","<?=$page_starturl?>index?bid=<?=getBID();?>");
  });
</script>