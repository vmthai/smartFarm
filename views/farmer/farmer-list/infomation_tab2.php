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

                
                <form class="form" id="tab2Form" novalidate="">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="farmer_list_id" value="<?=$data->id?>">
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
                                    <input type="text" id="codename" class="form-input width-60-per mb-1" name="codename" required>
                                </div>
                                <div class="control-group">
                                <label class="width-30-per mb-0" style=" text-align:left;">Lat</label>
                                    <input type="text" id="lat_value" class="form-input width-60-per mb-1" name="lat_value" required>
                                </div>
                                <div class="control-group">
                                <label class="width-30-per mb-0" style=" text-align:left;">Long</label>
                                    <input type="text" id="lon_value" class="form-input width-60-per mb-1" name="lon_value" required>
                                </div>
                                <div class="control-group">
                                <label class="width-30-per mb-0" style=" text-align:left;">Zoom</label>
                                    <input type="text" id="zoom_value" class="form-input width-60-per mb-1" name="zoom_value" required>
                                </div>
                                <div class="control-group">
                                <label class="width-30-per" style=" text-align:left;">ตำบล</label>
                                <input type="text" id="locality" class="form-input width-60-per mb-1" name="locality" required>
                                </div>                                                                    
                                <div class="control-group">
                                <label class="width-30-per mb-0" style=" text-align:left;">อำเภอ</label>
                                    <input type="text" id="distric" class="form-input width-60-per mb-1" name="distric" required>
                                </div>
                                <div class="control-group">
                                <label class="width-30-per mb-0" style=" text-align:left;">จังหวัด</label>
                                    <input type="text" id="province" class="form-input width-60-per mb-1"  name="province" required>
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
                                <button type="submit" class="btn btn-primary" id="addAGgroup_map" style="float:right; margin-top: 0px; margin-right: 0px; margin-bottom:0px;"><i class="icon-check2"></i> Save
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
 
</div><!--CLOSE #agGroup_map--> 
                                                          
<!--#################### Label Tab2 ######################--> 

<div id="agGroup_label" class="content-header row">
    <div class="row">
        <div class="col-md-9 col-sm-12 ">
            <h4 class="card-title" id="plotsInfo">พื้นที่เพาะปลูก รวม  [ <?=$data->count_all?> แปลง ]/[ <?=$data->sum_area['rai']?> ไร่ ]</h4>
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
    </div><!--CLOSE #agGroup_label-->
    <br>

    <div id='agGroup_labelB' class="row">
        <?php
        $arr_color = ['purple','info','green','pink'];
        foreach ($data->areas as $k => $v) { ?>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card cursor-pointer" onClick="fncPlotView('<?=$v->id?>');">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-left media-middle">
                            <i class="icon-layers <?=$arr_color[($k%4)]?> font-large-2 float-xs-left"></i>
                            </div>
                            <div class="media-body text-xs-right">
                                <h3><?=$v->count_all?>-<?=$v->sum_area['rai']?> ไร่</h3>
                                <span><?=$v->codename?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

    </div><!--CLOSE #agGroup_labelB-->                                            
</div><!--CLOSE #agGroup_label-->

<!--###END Label Tab2 ####--> 


<!--#################### div ภายใต้พื้นที่เพาะปลูก ######################--> 

<div id="agGroup_detail" class="content-header row" style="display:none;">
</div>
<div id="agGroup_from" class="content-header row" style="display:none;"> 
</div>