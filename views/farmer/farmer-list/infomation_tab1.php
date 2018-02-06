
<div style="margin-left:20px; width:93%">
    <div class="row">
        <div class="col-md-6">
        <div class="row-fluid">
        <div class="form-group control-group">
            <label for="farmerGroup">ชื่อ - สกุล</label>
            <fieldset class="form-group position-relative">
                    <input type="text" id="name" class="form-control primary" name="name" value="<?=$dataPeople->p_name?>" readonly>
                        <div class="form-control-position grey" style="margin-right:10px; line-height:33px;">
                        <?=($dataPeople->sex=='F')?'ผู้หญิง':(($dataPeople->sex=='M')?'ผู้ชาย':'')?>
                        </div>
                    </fieldset>
        </div>

        <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <label for="company_name">เลขที่บัตรประชาชน</label>
            <input type="text" id="idNo" class="form-control primary" name="idNo" value="<?=$dataPeople->id_card?>" readonly>                                   
        </div>
        </div>

    </div>


        </div>
        </div>
        <div class="col-md-6 text-center">
        <div class="form-group">
            <label for="projectinput1"> รูปเกษตรกร</label>
                <?php
                    $path_image = ($dataPeople->path_image=='')?_HTTP_HOST_.'/uploads/no-image.png':_HTTP_HOST_.'/'.$dataPeople->path_image;
                ?>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 115px; height: 115px; margin-top: -5px;">
                    <img src="<?=$path_image?>" alt="Profile Avatar" />
                </div>
                </div>
        </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6">
        <div class="form-group">
            <label for="farmerGroup">โทรศัพท์</label>
            <input type="text" id="phone" class="form-control primary"  value="<?=$dataPeople->phone?>" readonly>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="UserName">E-mail</label>
            <input type="text" id="idNo" class="form-control primary" name="idNo" value="<?=$dataPeople->email?>" readonly>   
        </div>
        </div>        
    </div>



<?php
$address_people = $dataPeople->address_text.' '.(($dataPeople->district_name)?fncShowDistrict($dataPeople->address_province_id,$dataPeople->district_name):'').(($dataPeople->amphur_name)?fncShowAmphur($dataPeople->address_province_id,$dataPeople->amphur_name):'').(($dataPeople->province_name)?fncShowProvince($dataPeople->address_province_id,$dataPeople->province_name):'').$dataPeople->address_zipcode;
$contact_people = $dataPeople->contact_text.' '.(($dataPeople->contact_district_name)?fncShowDistrict($dataPeople->contact_province_id,$dataPeople->contact_district_name):'').(($dataPeople->contact_amphur_name)?fncShowAmphur($dataPeople->contact_province_id,$dataPeople->contact_amphur_name):'').(($dataPeople->contact_province_name)?fncShowProvince($dataPeople->contact_province_id,$dataPeople->contact_province_name):'').$dataPeople->contact_zipcode;

?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="UserName">ที่อยู่ตามบัตรประชาชน</label>
            <input type="text" id="mail" class="form-control primary" value=" <?=$address_people?>" readonly>  
        </div>
        </div>        
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="UserName">ที่อยู่ปัจจุบัน</label>
            <fieldset class="form-group position-relative">
            <input type="hidden" id="location" value="<?=$data->location?>">
            <input type="text" id="mail" class="form-control primary" value=" <?=$contact_people?>" readonly> 
            <div id="gps_location" class="buttonA form-control-position">
            <i class="icon-android-pin primary font-medium-4"></i>
            </div>
        </div>        
    </div>
    </div>

    </div>  

<script type="text/javascript">

function toggleMap(v){
        $("#mapP").height(space * 0.7);  
        $("#gMap_T1").height(space * 0.643);  
        
        if(v == 'show'){
        $('html, body').animate({
        scrollTop: 30
        }, 40);
        $("#mainP").hide();
        $("#mapP").show();
        
        urlLoad = WEB_HTTP_HOST+"/<?=$page_starturl?>gmaps-Show";
        $("#gMap_T1").attr("src", urlLoad);
        }else{
        $("#mainP").show();
        $("#mapP").hide();  
        $('html, body').animate({
        scrollTop: 0
        }, 40); 
        }

    }
    $('#gps_location').click(function(){
        toggleMap('show');
    });
</script>