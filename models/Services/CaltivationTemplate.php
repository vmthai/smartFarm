<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class CaltivationTemplateService {
    
    private $modelAppService;
    private $tableModel = 'cultivation';

    public function __construct() {
        $this->modelAppService = new AppService();
    }

    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT *
        FROM `".$this->tableModel."`
        WHERE `id`=$id";
        $dbres = $this->modelAppService->fetchObject($query);
        $res = (!empty($dbres))?$dbres:array(); 
        $this->modelAppService->closeDb();
        return $res;
    }

    public function insertRecord($post) {  
        $this->modelAppService->openDb();
        $data = $this->modelAppService->setDataInsert($post);
        $fields = $data['fields'];
        $values = $data['values'];        
        $query = "INSERT INTO `".$this->tableModel."` ($fields) VALUES ($values)";
        $res = $this->modelAppService->queryDB($query);
        $id = $this->modelAppService->insertID();
        $this->modelAppService->closeDb();
        return $id;
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

    public function checkDuplicate($dataArray, $id=null) {
        try {
            $where = '';
            foreach ($dataArray as $field => $value) {
                $where .= ($where)?" AND ":'';
                if(is_null($value) || empty($value)){
                    $where .= " (".$field." IS NULL OR ".$field."='".$value."') ";
                } else {
                    $where .= $field."='".trim($value)."'";
                }
            }
            $this->modelAppService->openDB();
            $dataFind =  $this->modelAppService->fetchObject("SELECT id FROM ".$this->tableModel." WHERE ".$where);
            $this->modelAppService->closeDB();
            $dbId = (!empty($dataFind))?$dataFind->id:null;
            $res = (!empty($dbId))?true:false;
            if(!empty($id) && $id == $dbId){
                $res = false;
            }
            return $res;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function insertRecordProcess($post) {  
        $this->modelAppService->openDb();
        $data = $this->modelAppService->setDataInsert($post);
        $fields = $data['fields'];
        $values = $data['values'];        
        $query = "INSERT INTO `cultivation_process` ($fields) VALUES ($values)";
        $res = $this->modelAppService->queryDB($query);
        $id = $this->modelAppService->insertID();
        $this->modelAppService->closeDb();
        return $id;
    }

    public function updateRecordProcess($id,$post) {        
        $fields = $this->modelAppService->setDataUpdate($post);
        $this->modelAppService->openDb();
        $query = "UPDATE `cultivation_process` SET $fields WHERE id=$id";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }

    public function deleteRecordProcess($id) {
        try {
            $this->modelAppService->openDB();
            $dbId = $this->modelAppService->realEscapeString($id);
            $result_bak = $this->backupFromDeleteProcess($dbId);
            $result = false;
            if(!empty($result_bak)){
                $result = $this->modelAppService->queryDB("DELETE FROM `cultivation_process` WHERE id=$dbId");
            }
            $this->modelAppService->closeDB();
            return $result;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function backupFromDeleteProcess($id) {
        $field_auto = 'id';
        $table = 'cultivation_process';
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

    public function getProcessListAllByCultivationID($cultivation_id) {
        $this->modelAppService->openDb();
        $query = "SELECT *
        FROM `cultivation_process`
        WHERE `cultivation_id`=$cultivation_id";
        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array(); 
        $this->modelAppService->closeDb();
        return $res;
    }

    public function getProcessById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT *
        FROM `cultivation_process`
        WHERE `id`=$id";
        $dbres = $this->modelAppService->fetchObject($query);
        $res = (!empty($dbres))?$dbres:array(); 
        $this->modelAppService->closeDb();
        return $res;
    }
}

?>
