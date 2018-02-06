<div class="col-md-8">
  <div class="row">
    <div class="col-md-4">ชื่อ - สกุล</div>
    <div class="col-md-6"><?=$data->p_name?></div>
<!--     <div class="col-md-2">
       <button type="button" class="btn btn-primary" onClick="fncEditPeople('<?=$data->id?>');"> EDIT</button>
    </div> -->
  </div>
  <div class="row">
    <div class="col-md-4">Sex</div>
    <div class="col-md-8"><?=($data->sex=='F')?'หญิง':(($data->sex=='M')?'ชาย':'')?></div>
  </div>
  <div class="row">
  <div class="col-md-4">เลขที่บัตรประชาชน</div>
  <div class="col-md-8"><?=$data->id_card?></div>
  </div>
  <div class="row">
    <div class="col-md-4">โทรศัพท์</div>
    <div class="col-md-8"><?=$data->phone?></div>
  </div>
  <div class="row">
    <div class="col-md-4">E-Mail</div>
    <div class="col-md-8"><?=$data->email?></div>
  </div>
</div>
<div class="col-md-2 text-center">
    <?php
    $path_image = ($data->path_image=='')?_HTTP_HOST_.'/uploads/no-image.png':_HTTP_HOST_.'/'.$data->path_image;
    ?>
  <div class="row">
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
  <div class="col-md-8">
  ที่อยู่ตามบัตรประชาชน :: <?=$address_people?>

  </div>
  <div class="col-md-2 text-center">
       <button type="button" class="btn btn-info" onClick="fncEditPeople('<?=$data->id?>');"> EDIT</button>
  </div>
  <div class="col-md-8">
  ส่งเอกสาร :: <?=$contact_people?>
  </div>
