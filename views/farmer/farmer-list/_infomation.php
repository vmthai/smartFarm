<div id="allContent" style="margin-top:0px;">
<!-- <div class="content-header row">
    <div id="f_nameH" class="content-header-left col-md-6 col-xs-12 mb-1" style="margin-top:10px;">
        <h4 class="content-header-title">เกษตกร : <?=$dataPeople->p_name;?></h4>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
        <div class="breadcrumb-wrapper col-xs-13">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <span style="line-height:0rem;">
                    <button type="button" class="btn btn-primary" onClick="fncLoadContent('<?=$page_starturl?>index');">
                    <i class="icon-rewind"></i>Back
                    </button>    
                    </span>  
                </li>
            </ol>
        </div>
    </div>

</div> -->





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
                                            <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">เกษตกร [ <?=$dataPeople->p_name;?> ]</a>
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
                                            <i class="icon-rewind"></i>Back
                                            </button>    
                                            </span>  
                                            <!-- <a class="nav-link" id="base-tab6" data-toggle="" aria-controls="tab6" href="#" aria-expanded="false"> << BACK</a> -->
                                        </li>                                       
                                    </ul>
                                    
                                    <!-- TAB 1 -->
                                    <div class="tab-content px-1 pt-1">
                                        <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
   

                                       <form id="frm-main" class="form form-horizontal" novalidate="">
                                            <input type="hidden" name="id" value="">
                                            <div class="form-body">

                                            <h4 class="form-section green"><i class="icon-head"></i>ข้อมูลเกษตรกร</h4>
                                            <div style="margin-left:20px;">
                                                <div class="row">
                                                    <div class="col-md-8"></div>
                                                    <div class="col-md-2 text-center">
<!--                                                     <div class="form-group">
                                                        <input type="hidden" id="people_id" name="people_id" value="<?=$data->people_id?>">
                                                        <label for="projectinput4">Active : </label>&nbsp;&nbsp;
                                                        <input type="checkbox" class="form-checkbox" name="active" value="1" <?=($data->active=='1')?'checked':''?> disabled="disabled">
                                                    </div> -->
                                                    </div>
                                                </div>
                                                <div class="row" id="view_people">
                                                    <?php
                                                    include_once 'infomation_tab1.php'; 
                                                    ?>
                                                </div>
                                            </div>

                                            <div style="margin-top:20px;"></div>
                                            <h4 class="form-section green"><i class="icon-users3"></i> ข้อมูลกลุ่มเกษตร</h4>
                                
                                            <div style="margin-left:20px; width:95.5%">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group control-group">
                                                    <label for="farmerGroup">กลุ่มเกษตกร</label>
                                                    <input type="text" id="search_farmer_group_id" class="form-control primary" placeholder="Group Name" value="<?=$data->farmer_gname?>" readonly>
                                                    <input type="hidden" id="farmer_group_id" name="farmer_group_id" value="<?=$data->farmer_group_id?>"  required>
                                                </div>
                                                </div>
                                            </div> 

                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_name">กรณีเกษตกรเป็นบริษัทฯ</label>
                                                    <input type="text" id="company_name" class="form-control primary" placeholder="company Name" name="company_name" value="<?=$data->company_name?>" readonly>                                    
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">ประเภทกลุ่มเพาะปลูก</label>
                                                    <?php  
                                                        $a = '';
                                                        foreach($groups as $k => $v){ 
                                                            if($data->master_group_id==$k){
                                                                $a = $v;
                                                            }
                                                        }
                                                    ?>
                                                    <input type="text" id="farmType" class="form-control primary" placeholder="company Name" name="company_name" value="<?=$a?>" readonly>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="UserName">เลขทะเบียนการค้า/เลขผู้เสียภาษี</label>
                                                    <input type="text" id="company_tax" class="form-control primary" placeholder="Tax ID" name="company_tax" value="<?=$data->company_tax?>" readonly>
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="farmerGroup">ตำแหน่ง PGS</label>
                                                    <fieldset class="form-group position-relative">
                                                    <input type="text" id="location" class="form-control primary" placeholder="GPS Location" name="location" value="<?=$data->location?>" readonly>
                                                    <div class="form-control-position">
                                                    <i class="icon-android-pin primary font-medium-4"></i>
                                                    </div>
                                                    </fieldset>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="company_address">ที่ตั้งบริษัทฯ</label>
                                                    <input type="text" id="company_address" class="form-control primary" placeholder="Address" name="company_address" value="<?=$data->company_address?>" readonly>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_province_id">จังหวัด</label>
                                                    <?php  
                                                        $b = '';
                                                        foreach($provinces as $k => $v){ 
                                                            if($data->company_province_id==$k){
                                                                $b = $v;
                                                            }
                                                        }
                                                    ?>
                                                    <input type="text" id="company_province" class="form-control primary" placeholder="company Name" name="company_name" value="<?=$b?>" readonly>
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_amphur_id">อำเภอ/เขต</label>                                                  
                                                    <?php  
                                                        $c = '';
                                                        foreach($amphurs as $k => $v){ 
                                                            if($data->company_amphur_id==$k){
                                                                $c = $v;
                                                            }
                                                        }
                                                    ?>
                                                    <input type="text" id="company_amphur_id" class="form-control primary" placeholder="company Name" name="company_name" value="<?=$c?>" readonly>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_district_id">ตำบล/แขวง</label>
                                                    <?php  
                                                        $d = '';
                                                        foreach($districts as $k => $v){ 
                                                            if($data->company_district_id==$k){
                                                                $d = $v;
                                                            }
                                                        }
                                                    ?>
                                                    <input type="text" id="company_amphur_id" class="form-control primary" placeholder="company Name" name="company_name" value="<?=$d?>" readonly>
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_zipcode">รหัสไปรษณีย์</label>
                                                    <input type="text" class="form-control number primary" name="company_zipcode" maxlength="5" placeholder="Postcode" value="<?=$data->company_zipcode?>" readonly>                            
                                                </div>
                                                </div>
                                            </div>
                                            </div>                                                   
                                            </div>


                                    </div>


<script type="text/javascript">
  //fncLoadViewPeople(<?=$data->people_id?>);
  //##ที่ตั้งบริษัทฯ เลือกจังหวัด ##//
  $("#company_province_id").change(function(){        
      getAmphurJson($("#company_amphur_id"),$("#company_district_id"),$(this).val());     
  });
  $("#company_amphur_id" ).change(function(){
      getDistrictJson($("#company_district_id"),$(this).val());      
  });


  /*function fncLoadViewPeople(id,v){
    urlSend = WEB_HTTP_HOST+'/load/people/readonly?id='+id;
    $('#view_people').load(urlSend, function(responseTxt, statusTxt, xhr){
      if ( statusTxt == "error" ) {
          var msg = "Sorry but there was an error: ";
              $('#md-error p' ).text(msg + xhr.status + " " + xhr.statusText);
              $('#md-error').modal('show');
          return false;
      }
     });
  }*/
 
</script> 

                                    <!-- TAB 2 -->

                                    <div class="tab-pane" id="tab2" aria-labelledby="base-tab2"> 

                                    <style>





.buttonA{
    cursor:pointer;  
}
</style>
               <!-- MAP Tab2 --> 
                                        <div id="agGroup_map" class="card-body collapse in" style="display:none;">
                

                                            <div class="row">
                                                <div id="loadMap_T2" class="col-md-9 col-sm-12 padding-0">
                                                    
                                                <iframe id="gMap_T2" src="" style="border:0px; margin-left:-12px;" width="102%" height="100%" frameborder="1" scrolling="no" align="middle;">
                                                </iframe> 
                                                </div>
                                                <div id="menuMap_T2" class="col-md-3 col-sm-12 text-xs-center bg-grey bg-lighten-2">
<!-- ***************************************************** -->
                                                <div class="row match-height" style="margin-top:10px;">

                                                    
                                                    <form class="form" id="tab2Form">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-body">
                                                                    <div>
                                                                        <label style="width:91.5%; text-align:center; margin-top:10px;">
                                                                            <!-- <h5>ข้อมูลพื้นที่เพาะปลูก</h5> -->
                                                                            <fieldset class="form-group position-relative" style="text-align-center">
                                                                                    <input type="text" id="namePlace" class="form-control" placeholder="ค้นหาจังหวัด / อำเภอ" name="namePlace">
                                                                                    <div class="form-control-position">
                                                                                    <i id="SearchPlace" class="buttonA icon-search primary lighten-2 font-medium-4"></i>
                                                                                    </div>                                                         
                                                                                    </fieldset> 
                                                                        </label>
                                                                        
                                                                    </div>
                                                                    <hr style="margin-top:-5px;">
                                                                    <div>
                                                                        <label class="width-30-per" style=" text-align:left;">Code</label>
                                                                        <input type="text" id="eventInput1" class="width-60-per mb-1" name="codename">
                                                                    </div>
                                                                    <div>
                                                                    <label class="width-30-per mb-0" style=" text-align:left;">Lat</label>
                                                                        <input type="text" id="lat_value" class="width-60-per mb-1"  name="lat_value">
                                                                    </div>
                                                                    <div>
                                                                    <label class="width-30-per mb-0" style=" text-align:left;">Long</label>
                                                                        <input type="text" id="lon_value" class="width-60-per mb-1"  name="lon_value">
                                                                    </div>
                                                                    <div>
                                                                    <label class="width-30-per mb-0" style=" text-align:left;">Zoom</label>
                                                                        <input type="text" id="zoom_value" class="width-60-per mb-1"  name="zoom_value">
                                                                    </div>
                                                                    <div>
                                                                    <label class="width-30-per" style=" text-align:left;">ตำบล</label>
                                                                    <input type="text" id="locality" class="width-60-per mb-1" placeholder="" name="locality">
                                                                    </div>                                                                    
                                                                    <div>
                                                                    <label class="width-30-per mb-0" style=" text-align:left;">อำเภอ</label>
                                                                        <input type="text" id="distric" class="width-60-per mb-1"  name="distric">
                                                                    </div>
                                                                    <div>
                                                                    <label class="width-30-per mb-0" style=" text-align:left;">จังหวัด</label>
                                                                        <input type="text" id="province" class="width-60-per mb-1"  name="province">
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
                                                                                <button type="button" class="btn btn-primary" id="addAGgroup_map" style="float:right; margin-top: 0px; margin-right: 0px; margin-bottom:0px;"><i class="icon-check2"></i> Save
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
                                         
                                        </div>
                                            

                                            

                                                                     
                <!--#################### Label Tab2 ######################--> 
                                        
                                        <div id="agGroup_label" class="content-header row">
                                        <div class="row">
                                                <div class="col-md-9 col-sm-12 ">
                                                <h4 class="card-title" id="plotsInfo">พื้นที่เพาะปลูก รวม  60/2803 ไร่</h4>
                                                </div>
                                                <div class="col-md-3 col-sm-12 right">
                                                <div class="heading-elements">
                                                <ul class="list-inline mb-0" style="float:right; margin-right:-15px;">
                                                    <li>
                                                    <button type="button" class="btn btn-secondary primary" id="addAGgroup" style="float:right; margin-top: 0px; margin-right: 15px; margin-bottom:5px;" >
                                                        <i class="icon-layers"></i> เพิ่มพื้นที่เพาะปลูก
                                                    </button>
                                                    </li>
                                                </ul>
                                                </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div id='agGroup_labelB' class="row">
                                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                                <div class="card buttonA" onClick="agGroup_btn('aaaa');">
                                                    <div class="card-body">
                                                        <div class="card-block">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                <i class="icon-layers purple font-large-2 float-xs-left"></i>
                                                                </div>
                                                                <div class="media-body text-xs-right">
                                                                    <h3>42/2300 ไร่</h3>
                                                                    <span>นครสรรค์ B2</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                                <div class="card buttonA">
                                                    <div class="card-body">
                                                        <div class="card-block">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                <i class="icon-layers info font-large-2 float-xs-left"></i>
                                                                </div>
                                                                <div class="media-body text-xs-right">
                                                                    <h3>1/83 ไร่</h3>
                                                                    <span>ชัยนาท B1</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                                <div class="card buttonA">
                                                    <div class="card-body">
                                                        <div class="card-block">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                <i class="icon-layers green font-large-2 float-xs-left"></i>
                                                                </div>
                                                                <div class="media-body text-xs-right">
                                                                    <h3>14/320 ไร่</h3>
                                                                    <span>ปทุมธานี A2</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                                <div class="card buttonA">
                                                    <div class="card-body">
                                                        <div class="card-block">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <i class="icon-layers pink font-large-2 float-xs-left"></i>
                                                                </div>
                                                                <div class="media-body text-xs-right">
                                                                    <h3>3/100 ไร่</h3>
                                                                    <span>ปทุมธานี A1</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                            
                                        </div>                                      

                                        <!--###END Label Tab2 ####--> 
                                        <!--#################### END Label Tab2 ######################--> 
                                        <div id="agGroup_info" class="content-header row" style="display:none;">
                                        <div class="row">
                                                <div class="col-md-9 col-sm-12 ">
                                                    <h4 class="card-title" id="plotsInfo">ข้อมูลกลุ่มเพาะปลูก Code Name</h4>
                                                </div>
                                                <div class="col-md-3 col-sm-12 right">
                                                    <div class="heading-elements">
                                                    <ul class="list-inline mb-0" style="float:right; margin-right:-15px;">
                                                        <li>
                                                        <button type="button" class="btn btn-secondary primary" id="addAGgroup" style="float:right; margin-top: 0px; margin-right: 15px; margin-bottom:5px;" >
                                                            <i class="icon-layers"></i> เพิ่มแปลงเพาะปลูก
                                                        </button>
                                                        </li>
                                                    </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>


                                       
                                        </div>





                                    </div>                                                        

<!-- TAB 3 -->

                                    <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                    <div class="card-body collapse in">
                                        <div id="agGroup_label" class="content-header row">
                                            <div class="row">
                                                    <div class="col-md-9 col-sm-12 ">
                                                    <h4 class="card-title"> ข้อมูลแปลงเพาะปลูก</h4>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 right" style="">
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0" style="float:right; margin-right:-15px;">
                                                                <li>
                                                                <button type="button" class="btn btn-secondary primary" id="addAGplot" style="float:right; margin-top: 0px; margin-right: 15px; margin-bottom:5px;">
                                                                    <i class="icon-flag3"></i> เพิ่มแปลงเพาะปลูก
                                                                </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive" style="margin-top:-20px;">
                                                        <table class="table table-striped" width="98.43%" id="plot-lists">
                                                        <thead class="bg-green bg-lighten-2">
                                                            <tr>
                                                            <th class="text-center"  width="6%">ลำดับ</th>
                                                            <th width="30%">Code</th>
                                                            <th width="20%">กลุ่มเพาะปลูก</th>
                                                            <th width="15%">พื้นที่</th>
                                                            <th width="15%">ประเภทเพาะปลูก</th>
                                                            <th class="text-center" width="*"><i class="icon_cogs"></i> Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                
                                                        </tbody>
                                                        </table>      
                                                </div><!-- table -->   
                                            </div><!-- row -->
                                     
                                        </div>
                                    </div>



<script type="text/javascript">
  var oTable = $('#plot-lists').DataTable({
    /*"language": {
      "processing": '<i class="fa fa-spinner fa-spin fa-5x"></i>'
    },*/
    "stateSave": true,
    "bInfo" : false,
    "lengthChange": true,
    "lengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
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


  //key enter to search
  $('#plot-lists_filter input').unbind();
  $('#plot-lists_filter input').bind('keyup', function(e) {
    if(e.keyCode == 13) {
      oTable.search( this.value ).draw();  
    }
  }); 

  $('#btn-confirm-delete').off("click").click(function(e) {
      data = $("#frm-confirm-delete").serializeArray();
      fncConfirmDelete(data,"<?=$page_starturl?>delete?bid=<?=getBID();?>","<?=$page_starturl?>index?bid=<?=getBID();?>");
  });
</script>                                        

							        </div>

<!-- TAB 4 -->

                                    <div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
								        <p>สำหรับทำ master template การเพาะปลูก เมื่อมีการสร้างรายการการเพาะปลูกลูกค้า หรือ นักวิชาการสามารถเลือกจาก template เพื่อเป็นแนวทาง ลดเวลาการทำงานไม่ต้องสร้างใหม่ และสามารถปรับแต่งเพิ่มเติมจาก template ได้</p>
							        </div>

<!-- TAB 5 -->

                                    <div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
								        <p>กรณีลูกค้าติดตั้งระบบ Sensor & Weather Station ลูกค้าสามารถดูสถานะ หรือข้อมูลย้อนหลัง เพื่อมาประกอบการพิจารณาดำเนินการควบคุมปัจจัยการผลิตได้จากหน้าจอนี้ </p>
							        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
            <!--/ CSS Classes -->
        </div>
</div> <!-- allContent -->

 

<script type="text/javascript">
        var setH_map;
        var logLoad;
        var pageH = $("#allContent").height();
        var space =  $(document).height();
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


/*         function toggleMap(v){
            if(v == 't'){
                $("#tableTab3").show();
                $("#mapTab3").hide(); 
                //Un Load map from div
                loadMap('gMap','unload');  
            }else{
                $("#tableTab3").hide();
                $("#mapTab3").show();    
                //Load map to div      
                loadMap('gMap','load');        
            }
 
        } */

        // //---- TAB 2 function
        $('#addAGgroup').click(function(){
            $('#b2').show();
            $('#b1').hide();
            $('#agGroup_map').show();
            $('#agGroup_label').hide();
            $("#gMap_T2").height(setH_map);
            $("#menuMap_T2").height(setH_map);
            urlLoad = WEB_HTTP_HOST+"/<?=$page_starturl?>gmaps-farea";
            loadMap('gMap_T2','load',urlLoad);

        });
        $('#addAGgroup_map').click(function(){
            $('#b2').hide();
            $('#b1').show();
            $('#agGroup_map').hide();
            $('#agGroup_label').show();
            $('#tab2Form')[0].reset();
            loadMap('gMap_T2','unload','');  

        });
        $('#xAGgroup_map').click(function(){
            $('#b2').hide();
            $('#b1').show();
            $('#agGroup_map').hide();
            $('#agGroup_label').show();
            $('#tab2Form')[0].reset();
            loadMap('gMap_T2','unload','');  
        });
        // $('#agGroup_label').click(function(){
        //     $('#b2').show();
        //     $('#b1').hide();
        //     $('#agGroup_map').show();
        //     $('#agGroup_label').hide();
        //     loadMap('gMap_T2','load');  
        // });
        // //---- TAB 3 function
        // $('#addItem').click(function(){
        //     toggleMap('m');    
        // });
        // $('#save').click(function(){

        //     leftMclick('Mcontent', 'farmerAdmin.php');    
        // });
        // $('#addArea').click(function(){
        //     toggleMap('t');
        // });
        // $('#cancelArea').click(function(){
        //     toggleMap('t');  
        // });

     

        if($("#tab1").height() < (space * 0.4)){
             $("#tab1").height(space * 0.41);            
        } 

        $('#tabHead > li > a').click(function(){
           $('#tabHead > li > a').removeClass('active');
           attr = $(this).attr("aria-controls");
           $(this).addClass('active');

           getH = $("#"+attr).height();
           setH_map = (space * 0.41);

           console.log(space +" : "+ getH +" : "+ setH_map);
           if(getH < (space * 0.4)){
                $("#"+attr).height((space * 0.41));
           }
 
           //console.log(pageH +" : "+getH);
/*            $("#tabBody").height(getH + 70);
           if(getH < space0){
                $("#tabBody").height(space0 - 73);
                setH_map = (space0 - 160);
                $("#loadMap").height(setH_map);
                $("#menuMap").height(setH_map);
                $("#gMap").height(setH_map);
                $("#gMap_T2").height(setH_map);
                $("#menuMap_T2").height(setH_map);
           } */

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

/*   function areaGroup_btn('code'){
        alert(code);
  } */
</script>