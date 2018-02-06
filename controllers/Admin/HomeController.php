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
            } else if ( $op == 'create' ) {
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

        $viewHelper = new ViewHelper();

        $viewHelper->display('admin/home/index.php');

    }
  
}
?>