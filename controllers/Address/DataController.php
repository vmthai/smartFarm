<?php
require_once _DIR_HOST_.'/models/Services/Address.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class DataController {

    public function __construct() {
        $this->address = new AddressService();
    }
    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'amphur' ) {
                $this->amphur();
            } else if ($op == 'district' ) {
                $this->district();
            } else if ($op == 'zipcode' ) {
            $this->zipcode();
            } else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
            // some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function showError($title, $message) {
        include 'views/error.php';
    }

    /*
    * @param  array $this->params
    * @return display
    */
    private function amphur(){
       $data =  $this->address->getAmphurByProvince($_GET['id']);
        echo json_encode($data);
    }

    private function district(){
       $data =  $this->address->getDistrictByAmphur($_GET['id']);
        echo json_encode($data);
    }

    private function zipcode(){
       $data =  $this->address->getZipCodeByDistrict($_GET['id']);
        echo json_encode($data);
    }

}
?>
