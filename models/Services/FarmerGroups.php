<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class FarmerGroupService {
    
    private $modelAppService;
    private $tableModel = 'farmer_group';

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    public function genNextCode($code) {
        $textFirst = 'G-';
        if($code==''){
            $next_code   = $textFirst.'001';
        } else {
            $numOldNo       = intval(substr($code, 3, 3));
            $number_code    = sprintf("%'.03d", ($numOldNo+1));
            $next_code      = $textFirst.$number_code;     
        }
        return $next_code;
    }

    public function checkDuplicateCode($next_no) {
        $query = "SELECT code FROM `".$this->tableModel."` WHERE `code`='".$next_no."'";
        $res = $this->modelAppService->fetchObject($query);
        if(!empty($res->code)){
            $next_code_no = $this->genNextCode($next_no);
            $next_no = $this->checkDuplicateCode($next_code_no);
        }
        return $next_no;
    }


    public function newCodeNo() {
        $query = "SELECT next_farmer_group_code FROM `organize` WHERE `id`='1'";
        $row = $this->modelAppService->fetchAssoc($query);
        $next_code = (!empty($row['next_farmer_group_code']))?$row['next_farmer_group_code']:$this->genNextCode('');
        //check duplicate
        $next_code = $this->checkDuplicateCode($next_code);

        return $next_code;
    }

    public function updateNextCode($code) {
        $next_code =$this->genNextCode($code);
        $query = "UPDATE `organize` SET next_farmer_group_code='".$next_code."' WHERE id='1'";
        $res = $this->modelAppService->queryDB($query);
        return $res;
    }
    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM `".$this->tableModel."` WHERE `id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        $this->modelAppService->closeDb();
        return $res;
    }
    public function insertRecord($post) {  
        $this->modelAppService->openDb();
        $next_code = $this->newCodeNo();
        $post['code'] = $next_code;    
        $data = $this->modelAppService->setDataInsert($post);
        $fields = $data['fields'];
        $values = $data['values'];
        
        $query = "INSERT INTO `".$this->tableModel."` ($fields) VALUES ($values)";
        $res = $this->modelAppService->queryDB($query);
        //update next member no
        if($res==1 || $res==true){
            $this->updateNextCode($next_code);
        }
        $this->modelAppService->closeDb();
        return $res;
    }

    public function updateRecord($id,$post) {        
        $fields = $this->modelAppService->setDataUpdate($post);
        $this->modelAppService->openDb();
        $query = "UPDATE `".$this->tableModel."` SET $fields WHERE id=$id";
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
                $result = $this->modelAppService->queryDB("DELETE FROM `".$this->tableModel."` WHERE id=$dbId");
            }
            $this->modelAppService->closeDB();
            return $result;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function backupFromDelete($id) {
        $field_auto = 'id';
        $table = $this->tableModel;
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


    public function autocomplete($var) {
        $this->modelAppService->openDb();
        $query = "SELECT `id`,`farmer_gname` AS name FROM `".$this->tableModel."`  
            WHERE `farmer_gname` LIKE '%".$var."%'  ORDER BY `farmer_gname` ASC LIMIT 0,20";
        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }

}

?>
