<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class LogUserLoginsService {
    
    private $modelAppService;

    public function __construct() {
        $this->modelAppService = new AppService();
    }


    public function getAll() {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM log_user_login ORDER BY id ASC";
        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }
    
    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM log_user_login WHERE id=$id";
        $res = $this->modelAppService->fetchObject($query);
        return $res;
    }
    
    private function validateCreateNewParams($type,$admin_user_id) {
        $errors = array();
        if ($type=='' || $admin_user_id=='') {
            $errors[] = 'Name is required';
        }
        if ( empty($errors) ) {
            return;
        }
        throw new ValidationException($errors);
    }
    
    public function createNew($type, $admin_user_id) {
        $this->modelAppService->openDb();
        $type = ($type != NULL)?$type:'NULL';
        $admin_user_id = trim($admin_user_id);
        $url = $_GET["request"];
        $date = date("Y-m-d"); 
        $time_login = date("H:i:s");
        $query = "INSERT INTO log_user_login (`type_user`, `admin_user_id`, `date_login`, `time_login`,`url_last`) VALUES ('$type', '$admin_user_id', '$date', '$time_login','$url')";
        $res = $this->modelAppService->queryDB($query);
        $return = ($res==1)?$this->modelAppService->insertID():'';
        $this->modelAppService->closeDb();
        return $return;
    }
    
    public function delete( $id ) {
        $this->modelAppService->openDb();
        $query = "DELETE FROM log_user_login WHERE id=$id";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }
    public function saveLogUser($urlsave) {
        $this->modelAppService->openDb();
        $log_user = getLogUserID();
        $dataLog = $this->getById($log_user);
        if($urlsave<>''){
            $urllast = str_replace("?keep=1", "",$urlsave);
            $urllastsave = str_replace("&keep=1", "",$urllast);
            $date = date("Y-m-d");
            $time_login = date("H:i:s");
            $query = "UPDATE log_user_login SET url_after2='$dataLog->url_after',url_after='$dataLog->url_last',url_last='$urllastsave',url_last_time='$time_login' WHERE id=$log_user";
            $res = $this->modelAppService->queryDB($query); 
        }
        $this->modelAppService->closeDb();
        return $log_user;
    }    
    // public function saveLogUser($url) {

    //     $log_user = getLogUserID();
    //     $urlsave = getUrlLastForSave($url);
    //     $dataLog = $this->getById($log_user);
    //     if($urlsave<>''){
    //         $date = date("Y-m-d");
    //         $time_login = date("H:i:s");
    //         $this->modelAppService->openDb();
    //         $query = "UPDATE log_user_login SET url_after2='$dataLog->url_after',url_after='$dataLog->url_last',url_last='$urlsave',url_last_time='$time_login' WHERE id=$log_user";
    //         $res = $this->modelAppService->queryDB($query);
    //         $this->modelAppService->closeDb();
            
    //     }
    //     return $log_user;
    // }
    public function saveTimeLogout($log_user) {
        $date = date("Y-m-d"); 
        $time_logout = date("H:i:s");
        $this->modelAppService->openDb();
        $query = "UPDATE log_user_login SET time_logout='$time_logout' WHERE id=$log_user";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    } 

    public function getURLLAST() {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM log_user_login WHERE id='".getLogUserID()."'";
        $res = $this->modelAppService->fetchObject($query);
        if($res){
            list($ex1,$ex2,$ex_action) = explode("/", $res->url_last);
            if($ex_action=='save' || $ex_action=='delete'){
                $url_last = $ex1.'/'.$ex2.'/index';
            } else if($res->url_last=='home/home/login' || $res->url_last=='dashboard/home/index'){
                if(getRollUserID()==1){/*admin*/
                    $url_last = 'admin/home/index';
                } else {
                    $url_last = 'dashboard/home/view';
                }
                
            } else {
                $url_last = $res->url_last;
            }
        } else {
                if(getRollUserID()==1){/*admin*/
                    $url_last = 'admin/home/index';
                } else {
                    $url_last = 'dashboard/home/view';
                }
        }

        return $url_last;
    }  
}

?>
