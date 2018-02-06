<?php
require_once _DIR_HOST_.'/models/Services/FarmerAreas.php';
require_once _DIR_HOST_.'/models/Services/FarmerAreaSubs.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class FarmerListTab2Controller {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new FarmerAreaSubsService();
        $this->page_name = 'Farmer / Farmer List';
        $this->page_starturl = 'farmer/farmer-list/';
    }
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'info' ) {
                $this->$op();
            } else if ($op == 'crate' ) {
                $this->$op();
            } else if ($op == 'edit' ) {
                $this->$op();
            } else if ($op == 'save' ) {
                $this->$op();
            } else if ($op == 'delete' ) {
                $this->$op();
            }else {
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

    private function info(){
        $id = $_GET['id'];
        $farmerArea = new FarmerAreaService();
        $data = $farmerArea->getById($id);
        $funService =  new FunctionService();
        $data->sum_area = $funService->fncRaiNgan($data->sum_rai,$data->sum_ngan,$data->sum_square);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('data', $data);
        $viewHelper->display($this->page_starturl.'infomation_tab2-2.php');

    }

    private function crate(){
        $id = $_GET['id'];
        $farmerArea = new FarmerAreaService();
        $data = $farmerArea->getById($id);
        $funService =  new FunctionService();
        $data->sum_area = $funService->fncRaiNgan($data->sum_rai,$data->sum_ngan,$data->sum_square);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('data', $data);
        $viewHelper->display($this->page_starturl.'infomation_tab2-2-crate.php');

    }

    private function edit(){
        $id = $_GET['id'];
        $farmerArea = new FarmerAreaService();
        $dataArea = $farmerArea->getById($id);
        $data = $this->model->getById($id);
        $funService =  new FunctionService();
        $dataArea->sum_area = $funService->fncRaiNgan($dataArea->sum_rai,$dataArea->sum_ngan,$dataArea->sum_square);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('dataArea', $dataArea);
        $viewHelper->assign('data', $data);
        $viewHelper->display($this->page_starturl.'infomation_tab2-2-edit.php');

    }
    private function save(){
        $data = $_POST;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();

        if(!empty($_FILES["fileUpload"]["name"])){
            $fncService = new FunctionService();
            $reUpImg = $fncService->fncUploadFileAddKey($data['farmer_area_id'],$_FILES["fileUpload"]["name"],$_FILES["fileUpload"]["tmp_name"],"uploads/area/");
            if($reUpImg['result']=='true'){
                $data['path_file'] = $reUpImg['name'];
            }
        }

        if($_POST['id']==''){/*insert*/
            $res = $this->model->insertRecord($data);
        } else {
            $res = $this->model->updateRecord($_POST['id'],$data);
        }

        if($res==1){
            $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
        } else {
            $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
        }

        echo json_encode($json_data);
    }

    private function delete(){
        if ($_POST['id']=='') {
            $json_data = ['result'=>'false','message'=>'ไม่สามารถลบข้อมูลได้'];
        } else{
            $fareasub = new FarmerAreaSubsService();
            $re = $fareasub->deleteRecord($_POST['id']);
            $json_data = ['result'=>'true','message'=>'ลบข้อมูลเรียบร้อยแล้ว'];
        }
        echo json_encode($json_data);

    }

}
?>
