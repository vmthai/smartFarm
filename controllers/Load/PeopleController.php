<?php
require_once _DIR_HOST_.'/models/Services/Peoples.php';
require_once _DIR_HOST_.'/models/Services/Address.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class PeopleController {

    private $model = NULL;

    public function __construct() {
        $this->model = new PeoplesService();
    }    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'create' ) {
                $this->create();
            } else if ($op == 'edit' ) {
                $this->$op();
            } else if ($op == 'save' ) {
                $this->$op();
            } else if ($op == 'view' ) {
                $this->$op();
            } else if ($op == 'readonly' ) {
                $this->$op();
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
    private function create(){
        $address =  new AddressService();
        $provinces = $address->getAllProvince();

        $viewHelper = new ViewHelper();
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->display('load/people/create.php'); 
    }

    private function edit(){
        $id = $_GET['id'];
  
        $data = $this->model->getById($id);
        if(!empty($data->id_card)){
            $funService =  new FunctionService();
            $data->id_card = $funService->autoFormatCardID($data->id_card);
        }

        $address =  new AddressService();
        $provinces = $address->getAllProvince();
        $amphurs = $address->getAmphurByProvince($data->address_province_id);
        $districts = $address->getDistrictByAmphur($data->address_amphur_id);
        $contact_amphurs = $address->getAmphurByProvince($data->contact_province_id);
        $contact_districts = $address->getDistrictByAmphur($data->contact_amphur_id);

        $viewHelper = new ViewHelper();
        $viewHelper->assign('data', $data);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->assign('amphurs', $amphurs);
        $viewHelper->assign('districts', $districts);
        $viewHelper->assign('contact_amphurs', $contact_amphurs);
        $viewHelper->assign('contact_districts', $contact_districts);
        $viewHelper->display('load/people/edit.php'); 
    }

    private function save(){
        $data = $_POST;//echo '<pre>'; print_r($_POST);echo '</pre>';exit();
        // $data['birth_date'] = fncThaiDateToYmd($_POST['birth_date']);           
        if(isset($data['id_card'])){
            $data['id_card'] = str_replace(" ", "", $data['id_card']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();

        $check = $this->model->checkPeople($_POST['id'],$data['p_name']);
        
        if($check['result']==1){
            $json_data = ['result'=>'false','message'=>'ชื่อ-นามสกุล มีข้อมูลอยู่แล้ว'];
        } else {
            $checkUP = ['result'=>'true'];
            if(!empty($_FILES["fileUpload"]["name"])){
                $fncService = new FunctionService();
                $reUpImg = $fncService->fncUploadImg($_FILES["fileUpload"],"uploads/people/");
                if($reUpImg['result']=='true'){
                    $data['path_image'] = $reUpImg['name'];
                }
                $checkUP = $reUpImg;
            }
            if($checkUP['result']=='true'){
                if(!empty($_POST['use_address'])){
                    $data['contact_text'] = $data['address_text'];
                    $data['contact_province_id'] = $data['address_province_id'];
                    $data['contact_amphur_id'] = $data['address_amphur_id'];
                    $data['contact_district_id'] = $data['address_district_id'];
                    $data['contact_zipcode'] = $data['address_zipcode'];
                }
                if($_POST['id']==''){/*insert*/
                    $data['active']=1;
                    $data['created_at'] = $data['updated_at'];
                    $data['created_by'] = $data['updated_by'];
                    $data_id = $this->model->insertRecord($data);
                } else {
                    unset($data['id']);
                    $res = $this->model->updateRecord($_POST['id'],$data);
                    $data_id = ($res>0)?$_POST['id']:'';
                }

                if($data_id>0){
                    $json_data = ['result'=>'true','id'=>$data_id,'message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
                } else {
                    $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
                }
            } else {
                $json_data = $checkUP;
            }
        }

        echo json_encode($json_data);
    }


    private function view(){
        $id = $_GET['id'];

        $data = $this->model->getById($id);
        if(!empty($data->id_card)){
            $funService =  new FunctionService();
            $data->id_card = $funService->autoFormatCardID($data->id_card);
        }
        $viewHelper = new ViewHelper();
        $viewHelper->assign('data', $data);
        $viewHelper->display('load/people/view.php'); 
    }
    private function readonly(){
        $id = $_GET['id'];
        
        $data = $this->model->getById($id);
        if(!empty($data->id_card)){
            $funService =  new FunctionService();
            $data->id_card = $funService->autoFormatCardID($data->id_card);
        }
        //echo '<pre>';print_r($data);echo '</pre>';exit();
        $viewHelper = new ViewHelper();
        $viewHelper->assign('data', $data);
        $viewHelper->assign('fName',$data->p_name);
        $viewHelper->display('load/people/readonly.php'); 
    }
}
?>
