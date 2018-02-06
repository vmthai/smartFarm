<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class AdminUsersService {
    
    private $modelAppService;

    public function __construct() {
        $this->modelAppService = new AppService();
    }

    
    public function getEditUserById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT u. *, ar.`name` AS roll_name
                            FROM admin_user AS u 
                            LEFT JOIN admin_roll AS ar ON u.`admin_roll_id`=ar.`id`
                            WHERE u.`id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        if($res){
            if($res->birth_date){
                list($st_yy,$st_mm,$st_dd) = explode('-', $res->birth_date);
                $res->birth_date_th = $st_dd.'/'.$st_mm.'/'.(intval($st_yy)+543);
            } else {
                $res->birth_date_th='';
            }
        }

        $this->modelAppService->closeDb();
        return $res;
    }

    /*Config MENU จาก Table admin_menu และ admin_user_menu */
    public function getMenuByIdUserAndRoll($uid,$rollid) {
         $query = "SELECT mn.* ,um.`add`,um.`edit`,um.`view`,um.`delete` FROM admin_menu AS mn LEFT JOIN admin_user_menu AS um ON (mn.`id`=um.`admin_menu_id` AND um.`admin_user_id`=$uid) WHERE mn.`parent_id` IS NULL ";
        if($rollid==2){/*admin*/
            $query .= "AND mn.`is_admin`=1 ";  
        } else  if($rollid==3){/*staff*/
            $query .= "AND mn.`is_staff`=1 ";  
        }
            $query .= "ORDER BY mn.`id` ASC";

        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $return = array();
        foreach ($res as $key => $obj) {
            $query2 = "SELECT mn.* ,um.`add`,um.`edit`,um.`view`,um.`delete` FROM admin_menu AS mn LEFT JOIN admin_user_menu AS um ON (mn.`id`=um.`admin_menu_id` AND um.`admin_user_id`=$uid) WHERE mn.`parent_id` IS NOT NULL AND mn.`parent_id`='$obj->id' ";
            if($rollid==2){
                $query2.="AND `is_admin`=1 "; 
            }else  if($rollid==3){
                $query2.= "AND `is_staff`=1 ";  
            }
                $query2 .= "ORDER BY mn.`id` ASC";

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
        return $return;
    }
    /*Config MENU จาก manual */
    public function getMenuByManual($uid,$rollid) {

        if($rollid==1){/*getById*/
            $query = "SELECT * FROM admin_menu WHERE `is_admin`=1 AND `parent_id` IS NULL  ORDER BY `order` ASC";  
        } else {
            $query = "SELECT * FROM admin_menu WHERE `is_staff`=1 AND `parent_id` IS NULL  ORDER BY `order` ASC";  
        }

        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $return = array();
        foreach ($res as $key => $obj) {
            if($rollid==1){
                $query2 = "SELECT * FROM admin_menu WHERE `is_admin`=1 AND `parent_id`='$obj->id' AND `parent_id` IS NOT NULL"; 
            } else {
                $query2 = "SELECT * FROM admin_menu WHERE `is_staff`=1 AND `parent_id`='$obj->id' AND `parent_id` IS NOT NULL";  
            }
            $query2 .= " ORDER BY `order` ASC";
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

        return $return;
    }

    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT u. *, ar.`name` AS roll_name
                            FROM admin_user AS u 
                            LEFT JOIN admin_roll AS ar ON u.`admin_roll_id`=ar.`id`
                            WHERE u.`id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        if($res){
            if($res->birth_date){
                list($st_yy,$st_mm,$st_dd) = explode('-', $res->birth_date);
                $res->birth_date_th = $st_dd.'/'.$st_mm.'/'.(intval($st_yy)+543);
            } else {
                $res->birth_date_th='';
            }
            $res->menu = $this->getMenuByManual($res->id,$res->admin_roll_id);
        }

        $this->modelAppService->closeDb();
        return $res;
    }
    public function newCode() {

        $query = "SELECT `code` FROM admin_user ORDER BY `code` DESC LIMIT 1";
        $row1 = $this->modelAppService->fetchAssoc($query);

        if (empty($row1['code'])) {
            $code = '00001';
        } else {
            $code = sprintf("%'.05d", (intval($row1['code'])+1));   
        }
        return $code;
    }     
    public function insertRecord($post) {
        $this->modelAppService->openDb();
        if($post['new_password']!=''){
            $post['password'] = $this->modelAppService->fncConvertPassword($post['new_password']);            
        }
        unset($post['new_password']);
        $post['code'] = $this->newCode();
        $data = $this->modelAppService->setDataInsert($post);
        $fields = $data['fields'];
        $values = $data['values'];
        $query = "INSERT INTO admin_user ($fields) VALUES ($values)";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }

    public function updateRecord($id,$post) {
        $this->modelAppService->openDb();
        if($post['new_password']<>''){
            if($post['new_password']!=''){
                $post['password'] = $this->modelAppService->fncConvertPassword($post['new_password']);            
            } 
        }
        unset($post['new_password']);
        $fields = $this->modelAppService->setDataUpdate($post);
        $query = "UPDATE admin_user SET $fields WHERE id=$id";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }

    public function deleteRecord($id) {
        try {
            $this->modelAppService->openDB();
            $dbId = $this->modelAppService->realEscapeString($id);
            $result_bak = $this->backupFromDelete($dbId);
            $result = false;
            if(!empty($result_bak)){
                $result = $this->modelAppService->queryDB("DELETE FROM admin_user WHERE id=$dbId");
            }
            $this->modelAppService->closeDB();
            return $result;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function backupFromDelete($id) {
        $field_auto = 'id';
        $table = 'admin_user';
        $field_auto_log = 'log_id';
        $table_log = 'log_'.$table;
        $field_last = 'updated_by';
        $row_chk = $this->modelAppService->fetchRow("SHOW TABLES LIKE '".$table_log."'");
        if(empty($row_chk[0])){
            $row_create = $this->modelAppService->fetchRow("SHOW CREATE TABLE `".$table."`");
            $sql_create = (!empty($row_create[1]))?$row_create[1]:'';
            $sql_create = str_replace("`".$table."`", "`".$table_log."`", $sql_create);
            $this->modelAppService->queryDB($sql_create);
            $this->modelAppService->queryDB("ALTER TABLE `".$table_log."` CHANGE `".$field_auto."` `".$field_auto."` BIGINT(20) NOT NULL");
            $this->modelAppService->queryDB("ALTER TABLE `".$table_log."` DROP PRIMARY KEY");
            $this->modelAppService->queryDB("ALTER TABLE `".$table_log."` ADD `".$field_auto_log."` BIGINT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`".$field_auto_log."`)");
            $this->modelAppService->queryDB("ALTER TABLE `".$table_log."` ADD `deleted_by` BIGINT NOT NULL COMMENT 'user login delete' AFTER `".$field_last."`, ADD `deleted_date` DATETIME NOT NULL COMMENT 'วันที่ delete' AFTER `deleted_by`");
        }
        $row_column = $this->modelAppService->fetchAssocAll("SHOW COLUMNS FROM `".$table."`");
        $result_bak = false;
        if(!empty($row_column)){
            $field_column = array();
            foreach ($row_column as $item) {
                $field_column[] = $item['Field'];
            }
            $sql_insertbak = "
                INSERT INTO `".$table_log."` (`".implode("`,`", $field_column)."`,`deleted_by`,`deleted_date`)
                SELECT `".implode("`,`", $field_column)."`, CONCAT('".getUserLoginID()."') AS deleted_by, NOW() AS deleted_date FROM `".$table."` WHERE `".$field_auto."`=".$id."
            ";
            $result_bak = $this->modelAppService->queryDB($sql_insertbak);
        }
        return $result_bak;
    }

    public function loginfind($username, $password) {
        $this->modelAppService->openDb();
        $pass = $this->modelAppService->fncConvertPassword($password);
        $query = "SELECT * FROM admin_user WHERE username='$username' AND password='$pass' AND active=1";
        $res = $this->modelAppService->fetchObject($query);
        $this->modelAppService->closeDb();
        return $res;
    }
    public function checkUserName($id,$var) {
        $this->modelAppService->openDb();
        if($id==''){
            $query = "SELECT * FROM admin_user WHERE `username`='$var'";
        } else {
            $query = "SELECT * FROM admin_user WHERE `id`!='$id' AND `username`='$var'";
        }
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        $num = $res->num_rows;

        if ($num>0) {
            $return = 1;
        } else {
            $return = 0;   
        }
        return $return;   
    }
    public function checkMail($id,$email) {
        $this->modelAppService->openDb();
        if($id==''){
            $query = "SELECT * FROM admin_user WHERE `email`='$email'";
        } else {
            $query = "SELECT * FROM admin_user WHERE `id`!='$id' AND `email`='$email'";
        }
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        $num = $res->num_rows;

        if ($num>0) {
            $return = 1;
        } else {
            $return = 0;   
        }
        return $return;   
    }

    public function chkActiveUser($id) {
        try {
            $this->modelAppService->openDB();
            $dbId = $this->modelAppService->realEscapeString($id);
            $return = $this->modelAppService->fetchObject("SELECT `active`
                                FROM admin_user
                                WHERE `id`=$dbId");
            $this->modelAppService->closeDB();
            $result = (!empty($return->active))?true:false;
            return $result;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
    public function randomPassword($len) {
      srand((double)microtime()*10000000);
      $chars = "0123456789";
      $ret_str = "";
      $num = strlen($chars);
      for($i = 0; $i < $len; $i++)
      {
        $ret_str.= $chars[rand()%$num];
        $ret_str.="";
      }
      return $ret_str;
    }
    public function createUserByBranch() {
        try {
            $this->modelAppService->openDB();
            $query = "SELECT `id`,`code_branch`,`code_branch_old`,`name` FROM `branch` WHERE `code_branch` IS NULL AND id>1 ORDER BY `id` ASC";
            $dbres = $this->modelAppService->fetchObjectAll($query);
            $res = (!empty($dbres))?$dbres:array();
            foreach ($res as $k => $v) {
                    $user = $this->randomPassword(6);
               for ($i=1; $i <= 3; $i++) { 
                    $passs = $this->randomPassword(6);
                    $in_data = ['name'=>$v->name.' '.$i,
                                'active'=>1,
                                'admin_roll_id'=>3,
                                'branch_id'=>$v->id,
                                'username'=>$user.$i,
                                'new_password'=>$passs,
                                'pass'=>$passs];
                   $in_res = $this->insertRecord($in_data);
                    echo '<pre>'.$v->id.$i.'=='.$in_res.'</pre>';
               }
            }

            $this->modelAppService->closeDB();
            $result = true;
            return $result;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
    public function printBy() {
        $this->modelAppService->openDb();
        $query = "SELECT `username` FROM admin_user WHERE `id`='".getUserLoginID()."'";
        $res = $this->modelAppService->fetchObject($query);
        if($res){
            $return = $res->username;
        } else {
            $return = "";
        }

        $this->modelAppService->closeDb();
        return $return;
    }

    public function getUsernamePassByBranchFix($branch_id) {
        $this->modelAppService->openDb();
        $query = "SELECT `username`,`pass` FROM `admin_user` WHERE `branch_id`='".$branch_id."' ORDER BY `username` ASC LIMIT 0,3 ";
        $res = $this->modelAppService->fetchObjectAll($query);
        $data = (!empty($res))?$res:array();
        $this->modelAppService->closeDb();
        return $data;
    }
}

?>
