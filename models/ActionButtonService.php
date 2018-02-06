<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class ActionButtonService {
    
    private $modelAppService;

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    
    public function getActionButton() {
        $url = (!empty($_GET["request"]))?$_GET["request"]:'';
        $return = new \stdClass;
        /*ใส่ Manual ไปก่อน*/
        $return->add = 1;
        $return->edit = 1;
        $return->view = 1;
        $return->delete = 1;

        // $return->add = NULL;
        // $return->edit = NULL;
        // $return->view = NULL;
        // $return->delete = NULL;
        // if(getRollUserID()==1){/*Super Admin*/
        //     $return->add = 1;
        //     $return->edit = 1;
        //     $return->view = 1;
        //     $return->delete = 1;
        // } else if(getRollUserID()>1){

        //     $this->modelAppService->openDb();
        //     $url = str_replace("/sst/","",$_GET["request"]);
        //     list($ex1,$ex2,$ex_action) = explode("/", $url);
        //     $search = $ex1.'/'.$ex2.'/';
        //     $query = "SELECT um.* 
        //              FROM admin_user_menu AS um
        //              LEFT JOIN admin_menu AS am ON um.`admin_menu_id`=am.`id`
        //              WHERE um.`admin_user_id`='".getUserLoginID()."' 
        //              AND am.`url` LIKE '".$search."%'";
        //     $res = $this->modelAppService->fetchObject($query);
    
        //     if($res){
        //         $return->add = $res->add;
        //         $return->edit = $res->edit;
        //         $return->view = $res->view;
        //         $return->delete = $res->delete ;
        //     }
        //     $this->modelAppService->closeDb();            
        // }

        return $return;
    }

}

?>
