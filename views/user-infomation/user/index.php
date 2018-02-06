<section id="css-classes" class="card">

    <div class="card-body collapse in">

            <div class="card-header">
                <h4 class="card-title">  <?=$page_name?></h4>
                  <div class="heading-elements form-actions right">
                      <button id="addUser" type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>create');">
                          <i class="icon-database2 white"></i> New User
                      </button>
                  </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" style="width:98.4%;" id="tb-user-infomation">
                  <thead class="bg-green bg-lighten-2">
                    <tr>
                      <th class="text-center" width="5%">ลำดับ</th>
                      <th width="30%">ชื่อ-นามสกุล</th>
                      <th width="20%">กลุ่มเกษตกร</th>
                      <th width="15%">โทรศัพท์</th>
                      <th width="15%">สิทธิ์ผู้ใช้</th>
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
  var oTable = $('#tb-user-infomation').DataTable({
    /*"language": {
      "processing": '<i class="fa fa-spinner fa-spin fa-5x"></i>'
    },*/
    "stateSave": true,
    "bInfo" : false,
    "lengthChange": true,
    "lengthMenu": [[10, 15, 20], [10, 15, 20]],
    "columnDefs": [
      { "searchable": false, "targets": 0 },
      { "searchable": false, "orderable": false, "targets": 5 },
      {"className": "text-center", "targets": [0,5]}, //set to center
    ],
    "order": [ 0, "asc" ],
    //"processing": true,//default false
    "serverSide": true,
    "ajax": "<?=_HTTP_HOST_?>/<?=$page_starturl?>find"
  });

  // var htmlfilter = '';
  // htmlfilter += '<button type="button" class="btn btn-primary" onClick="fncLoadContent(\'<?=$page_starturl?>create\');"><i class="icon-database2 white"></i> New User</button>';
  // $("label.div_dataTables_btn").prepend(htmlfilter);

  //key enter to search
  $('#tb-user-infomation_filter input').unbind();
  $('#tb-user-infomation_filter input').bind('keyup', function(e) {
    if(e.keyCode == 13) {
      oTable.search( this.value ).draw();  
    }
  }); 

  $('#btn-confirm-delete').off("click").click(function(e) {
      data = $("#frm-confirm-delete").serializeArray();
      fncConfirmDelete(data,"<?=$page_starturl?>delete?bid=<?=getBID();?>","<?=$page_starturl?>index?bid=<?=getBID();?>");
  });
</script>