<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class TrackerService {
    
    private $modelAppService;
    private $tableModel = 'tracker';

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    public function getAll() {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM `".$this->tableModel."` ORDER BY `id` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }

    public function getWhere($arrGet) {
        $limit = empty($arrGet['limit'])?20:$arrGet['limit'];
        $start = empty($arrGet['start'])?0:$arrGet['start'];
        $start_datetime = empty($arrGet['start_datetime'])?'':$arrGet['start_datetime'];
        $stop_datetime = empty($arrGet['stop_datetime'])?'':$arrGet['stop_datetime'];
        $start_datetime_th = empty($arrGet['start_datetime_th'])?'':$arrGet['start_datetime_th']; 
        $stop_datetime_th = empty($arrGet['stop_datetime_th'])?'':$arrGet['stop_datetime_th'];

        $query = "SELECT * FROM `".$this->tableModel."` WHERE `id`>0";
        if($start_datetime!='' && $stop_datetime!=''){
            $query .= " AND (`datetime` between '".$start_datetime."' and '".$stop_datetime."')";
        } else if($start_datetime_th!='' && $stop_datetime_th!=''){
            $query .= " AND (`datetime_th` between '".$start_datetime_th."' and '".$stop_datetime_th."')";
        }
        $this->modelAppService->openDb();
        $query .= " ORDER BY `id` ASC LIMIT $start, $limit";
        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        $return = ['total'=>COUNT($res),"limit"=>20,"start"=>0,"data"=>$res];
        return $return;
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
        $field_last = 'availability';
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


}

?>
