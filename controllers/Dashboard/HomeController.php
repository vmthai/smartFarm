<?php
require_once _DIR_HOST_.'/models/Services/AdminUsers.php';
require_once _DIR_HOST_.'/models/Services/AdminMenus.php';
require_once _DIR_HOST_.'/models/Services/LogUserLogins.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class HomeController {

    public function __construct() {
        $this->adminusers = new AdminUsersService();
    }
    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ($op == 'view' ) {
                $this->view();
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
        if(empty($_SESSION['log_user'])){
                $viewHelper->display('login/index.php');  
        } else {
            $loguser = new LogUserLoginsService();
            $dataLog = $loguser->getById(getLogUserID());
            $function = new FunctionService();
            $day_diff = $function->day_diff($dataLog->date_login,date('Y-m-d'));

            if($day_diff==0){
                
                $url_last = $loguser->getURLLAST();
                $menus = new AdminMenusService();
                $id_maminmenu = $menus->getIdByURL($url_last);

                $data =  $this->adminusers->getById(getUserLoginID());


                $viewHelper->assign('data', $data);
                $viewHelper->assign('url_last', $url_last);
                $viewHelper->assign('id_maminmenu', $id_maminmenu);
                $viewHelper->display('dashboard/home/index.php'); 
            } else {
                $loguserlogins = new LogUserLoginsService();
                $loguserlogins->saveTimeLogout(getUserLoginID());
                unset($_SESSION['log_user']);
                unset($_SESSION['user_id']);
                unset($_SESSION['admin_roll_id']);
                session_destroy();    
                $viewHelper->display('login/index.php');        
            }
        }

    }

    private function view(){
        $viewHelper = new ViewHelper();
        $viewHelper->display('dashboard/home/view.php');
    }
}
?>
