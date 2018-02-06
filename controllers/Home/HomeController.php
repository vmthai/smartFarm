<?php
require_once _DIR_HOST_.'/models/Services/AdminUsers.php';
require_once _DIR_HOST_.'/models/Services/LogUserLogins.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class HomeController {

    private $adminusers = NULL;

    public function __construct() {
        $this->adminusers = new AdminUsersService();
    }
    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ( $op == 'login' ) {
                $this->login();
            } else if ( $op == 'logout' ) {
                $this->logout();
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

        $viewHelper = new ViewHelper();

        $viewHelper->display('login/index.php');

    }

    private function login(){
       
        $username = (isset($_POST['username']))?$_POST['username']:'';
        $password = (isset($_POST['password']))?$_POST['password']:'';

        if($username=='' || $password==''){
           $json_data = ['result'=>'false','message'=>'ชื่อผู้ใช้ และ รหัสผ่าน'];
        } else {
            $users = new AdminUsersService();

            $data = $users->loginfind($username,$password);

            if($data){
                $loguserlogins = new LogUserLoginsService();
                $log_user_login_id = $loguserlogins->createNew(1, $data->id);
                $_SESSION['project_name'] = _PROJECT_NAME_;
                $_SESSION['log_user'] = $log_user_login_id;
                $_SESSION['user_id']  = $data->id;
                $_SESSION['admin_roll_id']=(!empty($data->admin_roll_id))?$data->admin_roll_id:'';
                $_SESSION['bid']  = $data->master_group_id;
                $url_go = 'dashboard/home/index';

                $json_data = ['result'=>'true','url'=>_HTTP_HOST_.'/'.$url_go];
            } else {
                $json_data = ['result'=>'false','message'=>'ชื่อผู้ใช้หรือ รหัสผ่าน ไม่ถูกต้อง'];
            }
         
        }
        

        echo json_encode($json_data);
        
    }
    private function logout(){
        if(isset($_SESSION['log_user'])){
            $loguserlogins = new LogUserLoginsService();
            $loguserlogins->saveTimeLogout($_SESSION['log_user']);
            unset($_SESSION['project_name']);
            unset($_SESSION['log_user']);
            unset($_SESSION['user_id']);
            unset($_SESSION['admin_roll_id']);
            unset($_SESSION['bid']);
            session_destroy();          
        }
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
            echo json_encode(['result'=>'true']);
        } else {
            $this->index();
        }
    }   
}
?>