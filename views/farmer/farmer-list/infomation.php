<div id="allContent" style="margin-top:0px;">

    <div class="content-body"><!-- Description -->
        <!-- CSS Classes -->
        <section id="basic-tag-input">
            <div class="row match-height">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body" id="tabBody">
                            <div class="card-block">
                                <ul class="nav nav-tabs" id="tabHead">
                                    <li class="nav-item">
                                        <a class="nav-link green" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">เกษตกร [ <?=$dataPeople->p_name;?> ]</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">[ พื้นที่แปลงเกษตร ]</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">[ แปลงเพาะปลูก ]</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">[ แผนการปลูก ]</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">[ Sensor Station ]</a>
                                    </li>  
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false">[ Service ]</a>
                                    </li>   
                                    <li>
                                        <span style="line-height:0rem; float:right;">
                                        <button type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>index');">
                                        <i class="icon-table2"></i>&nbsp; Farmer List
                                        </button>    
                                        </span>  
                                    </li>                                       
                                </ul>
                                
                                
                                <div class="tab-content px-1 pt-1">
                                    <!-- TAB 1 -->
                                    <div role="tabpanel" class="tab-pane " id="tab1" aria-expanded="true" aria-labelledby="base-tab1">

                                        <div id="mainP">
                                        <form id="frm-main" class="form form-horizontal" novalidate="">
                                            <h4 class="form-section green"><i class="icon-head"></i>ข้อมูลเกษตรกร</h4>
                                            <div style="margin-left:20px;">
                                                <div id="view_people">
                                                    <?php include_once 'infomation_tab1.php'; ?>
                                                </div>
                                            </div>

                                            <div style="margin-top:20px;"></div>
                                            <h4 class="form-section green"><i class="icon-users3"></i> ข้อมูลกลุ่มเกษตร</h4>
                                            <div style="margin-left:20px; width:95.5%">
        
                                                <?php include_once 'infomation_tab1-2.php'; ?>
               
                                            </div>
                                        </form>
                                        </div>
                                        <div id="mapP" style="display:none;">
                                        <form id="frm-main" class="form form-horizontal" novalidate="">
                                            <h6 class="form-section grey"><i class="icon-android-pin primary font-medium-4"></i>Farmer Location : <?=$data->location?></h6>
                                            <div id="loadMap_T1" class="col-md-12 col-sm-12 padding-0">
                                                <iframe id="gMap_T1" src="" style="border:0px; margin-left:0px;" width="98%" height="100%" frameborder="1" scrolling="no" align="middle;">
                                                </iframe> 
                                            </div>
                                        </form>
                                        </div>

                                    </div><!--CLOSE TAB1-->

                                    <!-- TAB 2 -->
                                    <div class="tab-pane" id="tab2" aria-labelledby="base-tab2"> 
                                        <?php include_once 'infomation_tab2.php'; ?>
                                    </div><!--CLOSE TAB2-->

                                    <!-- TAB 3 -->
                                    <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                        <?php include_once 'infomation_tab3.php'; ?>
                                    </div><!--CLOSE TAB3-->


                                    <!-- TAB 4 -->
                                    <div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
                                        <p>สำหรับทำ master template การเพาะปลูก เมื่อมีการสร้างรายการการเพาะปลูกลูกค้า หรือ นักวิชาการสามารถเลือกจาก template เพื่อเป็นแนวทาง ลดเวลาการทำงานไม่ต้องสร้างใหม่ และสามารถปรับแต่งเพิ่มเติมจาก template ได้</p>
                                    </div><!--CLOSE TAB4-->

                                    <!-- TAB 5 -->
                                    <div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
                                        <p>กรณีลูกค้าติดตั้งระบบ Sensor & Weather Station ลูกค้าสามารถดูสถานะ หรือข้อมูลย้อนหลัง เพื่อมาประกอบการพิจารณาดำเนินการควบคุมปัจจัยการผลิตได้จากหน้าจอนี้ </p>
                                    </div><!--CLOSE TAB5-->

                                     <!-- TAB 6 -->
                                    <div class="tab-pane" id="tab6" aria-labelledby="base-tab5">
                                        tab6
                                    </div><!--CLOSE TAB6-->

                                </div><!--CLOSE tab-content px-1 pt-1-->

                            </div><!--CLOSE card-block-->
                    </div><!--CLOSE card-->
                </div><!--CLOSE col-xl-12 col-lg-12-->
            </div><!--CLOSE row match-height-->
            
        </section>
        <!--/ CSS Classes -->
    </div>
</div> <!-- allContent -->

<div id="md-confirm-tab2" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ยืนยัน</h4>
          </div>
          <div class="modal-body">
              <p>เพิ่มพื้นที่เพาะปลูก หากยืนยันการบันทึกข้อมูล กด "ตกลง"?</p>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" id="btn-confirm-tab2-save">ตกลง</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>
 

<script type="text/javascript">
    var setH_map;
    var logLoad;
    var pageH = $("#allContent").height();
    var space =  $(document).height();
    var vTab = '<?=$tab?>';
    $(function() {
        $("#gMap_T2").height(space * 0.7);
        $("#menuMap_T2").height(space * 0.7);
        $('#base-tab'+vTab).addClass('active');
        $('#tab'+vTab).addClass('active');

        // if(vTab=='2'){/*LOAD dataTabel tab2*/
        //       var oTable = $('#plot-lists').DataTable({
        //         /*"language": {
        //           "processing": '<i class="fa fa-spinner fa-spin fa-5x"></i>'
        //         },*/
        //         "stateSave": true,
        //         "bInfo" : false,
        //         "lengthChange": true,
        //         "lengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
        //         "columnDefs": [
        //           { "searchable": false, "targets": 0 },
        //           { "searchable": false, "orderable": false, "targets": 5 },
        //           {"className": "text-center", "targets": [0,5]}, //set to center
        //         ],
        //         "order": [ 0, "asc" ],
        //         //"processing": true,//default false
        //         "serverSide": true,
        //         "ajax": "<?=_HTTP_HOST_?>/<?=$page_starturl?>find"
        //       });

        //       //key enter to search
        //       $('#plot-lists_filter input').unbind();
        //       $('#plot-lists_filter input').bind('keyup', function(e) {
        //         if(e.keyCode == 13) {
        //           oTable.search( this.value ).draw();  
        //         }
        //       }); 
        // }
    });

    function loadMap(l,v,fName){
        if(v == 'load'){
            thisLoad = l;
            $("#"+logLoad).attr("src", "");
            $("#"+thisLoad).attr("src", fName);
            logLoad = thisLoad;
        }else{
            $("#"+l).attr("src", "");
        }
        
    }

    // //---- TAB 2 function
    $('#addAGgroup').click(function(){
        $('#b2').show();
        $('#b1').hide();
        $('#agGroup_map').show();
        $('#agGroup_label').hide();
        //$("#gMap_T2").height(setH_map);
        //$("#menuMap_T2").height(setH_map);
        urlLoad = WEB_HTTP_HOST+"/<?=$page_starturl?>gmaps-farea";
        loadMap('gMap_T2','load',urlLoad);

    });
    /*เพิ่มพื้นที่เพาะปลูก START*/
    $("#tab2Form input").jqBootstrapValidation({
          preventSubmit: true,
          submitError: function($form, event, errors) {
              $('#addAGgroup_map').removeClass('disabled');
          },
          submitSuccess: function($form, event) {
              event.preventDefault();
              $('#addAGgroup_map').removeClass('disabled');
              $('#md-confirm-tab2').modal('show');
          }
    });

    $('#btn-confirm-tab2-save').off("click").click(function(e) {
      $('#addAGgroup_map').addClass('disabled');
      $('#md-confirm-tab2').modal('hide');
        var me = $(this);
        e.preventDefault();

        if ( me.data('requestRunning') ) {
            $('#addAGgroup_map').removeClass('disabled');
            return;
        }

        me.data('requestRunning', true);

        data = $("#tab2Form").serialize();
        fncConfirmSave(me,data,"farmer/farmer-list-tab2/save","<?=$page_starturl?>info?id=<?=$data->id?>&tab=2");
        e.stopPropagation();
    });
    /*CANCEL การบันทึก*/
    /*เพิ่มพื้นที่เพาะปลูก CLOSE*/
    $('#xAGgroup_map').click(function(){
        $('#b2').hide();
        $('#b1').show();
        $('#agGroup_map').hide();
        $('#agGroup_label').show();
        $('#tab2Form')[0].reset();
        loadMap('gMap_T2','unload','');  
    });


    if($("#tab<?=$tab?>").height() < (space * 0.70)){
         $("#tab<?=$tab?>").height(space * 0.68);  
                  
    } 

    $('#tabHead > li > a').click(function(){
       attr = $(this).attr("aria-controls");
       var tab_id = attr.replace("tab", "");
       fncLoadContent('<?=$page_starturl?>info?id=<?=$data->id?>&tab='+tab_id);
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
    /*พื้นที่แปลงเกษตร START*/
    function fncPlotView(id){
        $('#agGroup_label').hide();
        $('#agGroup_detail').show();
        $('#agGroup_from').hide();
        fncLoadPageTodiv('#agGroup_detail','farmer/farmer-list-tab2/info?id='+id);
    }
    function fncPlotBack(){
        $('#agGroup_label').show();
        $('#agGroup_detail').hide();
        $('#agGroup_from').hide();
    }
    
    function fncAddAreaSub(area_id){/*เพิ่มแปลงเพาะปลูก*/
        $('#agGroup_label').hide();
        $('#agGroup_detail').hide();
        $('#agGroup_from').show();
        fncLoadPageTodiv('#agGroup_from','farmer/farmer-list-tab2/crate?id='+area_id);
    }
    function fncEditAreaSub(id){/*แก้ไขแปลงเพาะปลูก*/
        $('#agGroup_label').hide();
        $('#agGroup_detail').hide();
        $('#agGroup_from').show();
        fncLoadPageTodiv('#agGroup_from','farmer/farmer-list-tab2/edit?id='+id);
    }
</script>