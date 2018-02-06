
<div style="margin-left:20px; width:95.5%">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group control-group">
            <label for="farmerGroup">กลุ่มเกษตกร</label>
            <input type="text" id="search_farmer_group_id" class="form-control primary" placeholder="Group Name" value="<?=$data->farmer_gname?>" readonly>
            <input type="hidden" id="farmer_group_id" name="farmer_group_id" value="<?=$data->farmer_group_id?>"  required>
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
            <label for="company_name">กรณีเกษตกรเป็นบริษัทฯ</label>
            <input type="text" id="company_name" class="form-control primary" placeholder="company Name" name="company_name" value="<?=$data->company_name?>" readonly>                                    
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="UserName">เลขทะเบียนการค้า/เลขผู้เสียภาษี</label>
            <input type="text" id="company_tax" class="form-control primary" placeholder="Tax ID" name="company_tax" value="<?=$data->company_tax?>" readonly>
        </div>
        </div>
    </div>

    <div class="row">


    </div>
<?php

$address_company = $data->company_address.' '.(($data->district_name)?fncShowDistrict($data->company_province_id,$data->district_name):'').(($data->amphur_name)?fncShowAmphur($data->company_province_id,$data->amphur_name):'').(($data->province_name)?fncShowProvince($data->company_province_id,$data->province_name):'').$data->company_zipcode;
?>
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <label for="company_address">ที่ตั้งบริษัทฯ</label>
            <input type="text" class="form-control primary" value="<?=$address_company?>" readonly>
        </div>
        </div>
    </div>

    </div>   