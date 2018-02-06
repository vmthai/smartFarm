<div class="col-md-6">
    <div class="row">
    <div class="col-md-4">ชื่อ - สกุล</div>
    <div class="col-md-8">
            <input type="text" id="name" class="form-control primary" name="name" value="<?=$data->p_name?>" readonly>
        </div>
    </div>
    <div class="row" style="margin-top:5px;">
    <div class="col-md-4">เพศ</div>
        <div class="col-md-8">
            <input type="text" id="sex" class="form-control primary" name="sex" value="<?=($data->sex=='F')?'หญิง':(($data->sex=='M')?'ชาย':'')?>" readonly>
        </div>
    </div>

    <div class="row"  style="margin-top:5px;">
    <div class="col-md-4">เลขที่บัตรประชาชน</div>
        <div class="col-md-8">
            <input type="text" id="idNo" class="form-control primary" name="idNo" value="<?=$data->id_card?>" readonly>
        </div>
    </div>

    <div class="row"  style="margin-top:5px;">
    <div class="col-md-4">โทรศัพท์</div>
    <div class="col-md-8">
            <input type="text" id="phone" class="form-control primary"  value="<?=$data->phone?>" readonly>
        </div>
    </div>
    <div class="row"  style="margin-top:5px;">
    <div class="col-md-4">E-Mail</div>
    <div class="col-md-8">
            <input type="text" id="mail" class="form-control primary"  value="<?=$data->email?>" readonly>
        </div>
    </div>
</div>
<div class="col-md-6 text-center" style="margin-left:-5px;">
    <?php
    $path_image = ($data->path_image=='')?_HTTP_HOST_.'/uploads/no-image.png':_HTTP_HOST_.'/'.$data->path_image;
    ?>
    <div class="row"  style="margin-top:5px;">
    <div class="fileupload fileupload-new" data-provides="fileupload">
      <div class="fileupload-new thumbnail" style="width: 120px; height: 120px;"><img src="<?=$path_image?>" alt="Profile Avatar" />
      </div>
    </div>
</div>  

</div>

<?php

$address_people = $data->address_text.' '.(($data->district_name)?fncShowDistrict($data->address_province_id,$data->district_name):'').(($data->amphur_name)?fncShowAmphur($data->address_province_id,$data->amphur_name):'').(($data->province_name)?fncShowProvince($data->address_province_id,$data->province_name):'').$data->address_zipcode;
$contact_people = $data->contact_text.' '.(($data->contact_district_name)?fncShowDistrict($data->contact_province_id,$data->contact_district_name):'').(($data->contact_amphur_name)?fncShowAmphur($data->contact_province_id,$data->contact_amphur_name):'').(($data->contact_province_name)?fncShowProvince($data->contact_province_id,$data->contact_province_name):'').$data->contact_zipcode;

?>
<div class="row col-md-12"  style="margin-top:5px;">
    <div class="col-md-2">ที่อยู่ตามบัตรประชาชน</div>
    <div class="col-md-10">
   
        <input type="text" id="mail" class="form-control primary" style="margin-left:5px;"  value=" <?=$address_people?>" readonly>
    </div>
</div>
<div class="row col-md-12"  style="margin-top:5px;">
    <div class="col-md-2">ส่งเอกสาร</div>
    <div class="col-md-10">
   
        <input type="text" id="mail" class="form-control primary" style="margin-left:5px;" value=" <?=$contact_people?>" readonly>
    </div>
</div>

