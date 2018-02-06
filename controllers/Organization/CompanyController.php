<?php
require_once _DIR_HOST_.'/models/Services/Branchs.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class ProfileController {
    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new BranchsService();
        $this->page_name = 'Company Infomation';
        $this->page_starturl = 'organization/company/';
    }
    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ($op == 'save' ) {
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
    private function index(){
        $data =  $this->model->getById(1);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->display($this->page_starturl.'index.php'); 
    }

    private function save(){
        $data = $_POST;
        $data['birth_date'] = fncThaiDateToYmd($_POST['birth_date']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $_SESSION['user_id'];
        unset($data['menu']);

        if(!empty($_FILES["fileUpload"]["name"])){
            $fncService = new FunctionService();
            $reUpImg = $fncService->fncUploadImg($_FILES["fileUpload"],"uploads/user/");
            if($reUpImg['result']=='true'){
                $data['path_image'] = $reUpImg['name'];
            }
        }
        $check = $this->adminusers->checkUserName($_POST['id'],$_POST['username']);
        
        if($check==1){
            $json_data = ['result'=>'false','message'=>'ชื่อนี้ถูกใช้แล้ว'];
        } else {
            if($_POST['id']==''){/*insert*/
                $res = $this->adminusers->insertRecord($data);
            } else {
                $res = $this->adminusers->updateRecord($_POST['id'],$data);
            }
             if($res==1){
                $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
            } else {
                $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
            }
        }

        echo json_encode($json_data);
    }
}
?>
