<?php
require_once _DIR_HOST_.'/models/Services/AdminUsers.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class ProfileController {

    public function __construct() {
        $this->adminusers = new AdminUsersService();
    }
    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ($op == 'save' ) {
                $this->save();
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
        $data =  $this->adminusers->getById($_SESSION['user_id']);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('data', $data);
        $viewHelper->display('dashboard/profile/index.php'); 
    }

    private function save(){
        $data = $_POST;
        list($st_dd,$st_mm,$st_yy) = explode('/', $_POST['birth_date']);
        $data['birth_date'] = (intval($st_yy)-543).'-'.$st_mm.'-'.$st_dd;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $_SESSION['user_id'];

        if(!empty($_FILES["fileUpload"]["name"])){
            $fncService = new FunctionService();
            $reUpImg = $fncService->fncUploadImg($_FILES["fileUpload"],"uploads/user/");
            if($reUpImg['result']=='true'){
                $data['path_image'] = $reUpImg['name'];
            }
        }
        $check = $this->adminusers->checkMail($_POST['id'],$_POST['email']);
        $checkuser = $this->adminusers->checkUserName($_POST['id'],$_POST['username']);
        
        if(!empty($_POST['email']) && $check==1){
            $json_data = ['result'=>'false','message'=>'อีเมลนี้มีอยู่แล้ว'];
        } else if($checkuser==1){
            $json_data = ['result'=>'false','message'=>'Username นี้มีอยู่แล้ว'];
        } else {
            $data_id = $this->adminusers->updateRecord($_POST['id'],$data);

             if($data_id>0){
                $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
            } else {
                $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
            }
        }

        echo json_encode($json_data);
    }

}
?>
