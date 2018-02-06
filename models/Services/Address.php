<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class AddressService {
    
    private $modelAppService;

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    
    public function getAllProvince() {
        $this->modelAppService->openDb();
        $query = "SELECT `province_id` AS `id`,`province_name` AS `name` FROM address_province ORDER BY `province_name` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }
    public function getAmphurByProvince($id) {
        $this->modelAppService->openDb();
        $query = "SELECT `amphur_id` AS `id`,`amphur_name` AS `name` FROM address_amphur WHERE `province_id`='$id' ORDER BY `amphur_name` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }
    public function getDistrictByAmphur($id) {
        $this->modelAppService->openDb();
        $query = "SELECT `district_id` AS `id`,`district_name` AS `name` FROM address_district WHERE `amphur_id`='$id' ORDER BY `district_name` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }

    public function getZipCodeByDistrict($id) {
        $this->modelAppService->openDb();
        $query = "SELECT `zipcode_id` AS `id`,`zipcode` AS `name` FROM address_zipcode WHERE `district_id`='$id' ORDER BY `zipcode` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    } 
}

?>
