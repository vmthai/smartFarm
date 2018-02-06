<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class AdminMenusService {
    
    private $modelAppService;

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    public function getAll() {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM admin_menu WHERE `parent_id` IS NULL  ORDER BY `id` ASC";
        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $return = array();
        foreach ($res as $key => $obj) {
            $p_dbres = $this->modelAppService->fetchObjectAll("SELECT * FROM admin_menu WHERE `parent_id`='$obj->id' AND `parent_id` IS NOT NULL");
            $p_res = (!empty($p_dbres))?$p_dbres:array();
            $parent = array();
            foreach ($p_res as $k => $v) {
                $parent[] = $v;
            }

            $obj->have_parent = (count($parent)==0)?0:1;
            $obj->parent = $parent;
            $return[] = $obj;
        }
        $this->modelAppService->closeDb();
        return $return;
    }
    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM admin_menu WHERE id=$id";
        $res = $this->modelAppService->fetchObject($query);
        if($res){
            $p_obj = $this->modelAppService->fetchObject("SELECT * FROM admin_menu WHERE `parent_id`='$res->id' AND `parent_id` IS NOT NULL");
  
            $res->parent = $p_obj;
        }
        $this->modelAppService->closeDb();
        return $res;
    }
    
    public function insertRecord($post) {
        $this->modelAppService->openDb();
        $data = $this->modelAppService->setDataInsert($post);
        $fields = $data['fields'];
        $values = $data['values'];
        $query = "INSERT INTO admin_menu ($fields) VALUES ($values)";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }

    public function updateRecord($id,$post) {
        $this->modelAppService->openDb();
        $fields = $this->modelAppService->setDataUpdate($post);
        $query = "UPDATE admin_menu SET $fields WHERE id=$id";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }
    public function updateMenuAdmin($arr,$updated_at,$updated_by) {
        $this->modelAppService->openDb();
        $this->modelAppService->queryDB("UPDATE admin_menu SET `is_admin`=NULL");
        $i=0;
        foreach ($arr as $key => $value) {
            $i++;
            $query = "UPDATE admin_menu SET `is_admin`='$value',`updated_at`='$updated_at', `updated_by`='$updated_by'  WHERE id=$key";
            $res = $this->modelAppService->queryDB($query);
        }
        $this->modelAppService->closeDb();
        return $i;
    }
    public function updateMenuStaff($arr,$updated_at,$updated_by) {
        $this->modelAppService->openDb();
        $this->modelAppService->queryDB("UPDATE admin_menu SET `is_staff`=NULL");
        $i=0;
        foreach ($arr as $key => $value) {
            $i++;
            $query = "UPDATE admin_menu SET `is_staff`='$value',`updated_at`='$updated_at', `updated_by`='$updated_by'  WHERE id=$key";
            $res = $this->modelAppService->queryDB($query);
        }
        $this->modelAppService->closeDb();
        return $i;
    }
    public function deleteRecord($id) {
        $this->modelAppService->openDb();
        $query = "DELETE FROM admin_menu WHERE id=$id";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }
    public function getManuByRoll($id) {

        if($id==1){
            $return = $this->getAll();
        } else {
            $this->modelAppService->openDb();
            $query = "SELECT * FROM admin_menu WHERE `parent_id` IS NULL AND `is_staff`=1 ORDER BY `id` ASC";
            $dbres = $this->modelAppService->fetchObjectAll($query);
            $res = (!empty($dbres))?$dbres:array();
            $return = array();
            foreach ($res as $key => $obj) {
                $p_dbres = $this->modelAppService->fetchObjectAll("SELECT * FROM admin_menu WHERE `parent_id`='$obj->id' AND `parent_id` IS NOT NULL AND `is_staff`=1");
                $p_res = (!empty($p_dbres))?$p_dbres:array();
                $parent = array();
                foreach ($p_res as $k => $v) {
                    $parent[] = $v;
                }
  
                $obj->have_parent = (count($parent)==0)?0:1;
                $obj->parent = $parent;
                $return[] = $obj;
            }
            $this->modelAppService->closeDb();

        }
        return $return; 
    }

    public function getByAdminRoll($id) {
        $this->modelAppService->openDb();
        if($id==1){/*Super admin*/
            $query = "SELECT * FROM admin_menu WHERE `parent_id` IS NULL  ORDER BY `id` ASC";
        } else if($id==2){/*admin*/
            $query = "SELECT * FROM admin_menu WHERE `is_admin`=1 AND `parent_id` IS NULL  ORDER BY `id` ASC";  
        } else {
            $query = "SELECT * FROM admin_menu WHERE `is_staff`=1 AND `parent_id` IS NULL  ORDER BY `id` ASC";  
        }

        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $return = array();
        foreach ($res as $key => $obj) {
            if($id==1){
                $query2 = "SELECT * FROM admin_menu WHERE `parent_id`='$obj->id' AND `parent_id` IS NOT NULL";
            } else if($id==2){
                $query2 = "SELECT * FROM admin_menu WHERE `is_admin`=1 AND `parent_id`='$obj->id' AND `parent_id` IS NOT NULL"; 
            } else {
                $query2 = "SELECT * FROM admin_menu WHERE `is_staff`=1 AND `parent_id`='$obj->id' AND `parent_id` IS NOT NULL";  
            }
            $p_dbres = $this->modelAppService->fetchObjectAll($query2);
            $p_res = (!empty($p_dbres))?$p_dbres:array();
            $parent = array();
            foreach ($p_res as $k => $v) {
                $parent[] = $v;
            }

            $obj->have_parent = (count($parent)==0)?0:1;
            $obj->parent = $parent;
            $return[] = $obj;
        }
        $this->modelAppService->closeDb();
        return $return;
    }

    public function getIdByURL($urlsend) {
        $this->modelAppService->openDb();
        $url_ex = explode("/", $urlsend);
        $url_like =$url_ex[0].'/'.$url_ex[1].'/';
        $query = "SELECT * FROM admin_menu WHERE `url` LIKE '".$url_like."%'";
        $res = $this->modelAppService->fetchObject($query);
        $return = '';
        if($res){
            $return = ($res->parent_id=='')?'':$res->parent_id;
        }
        $this->modelAppService->closeDb();
        return $return;
    }
}

?>
