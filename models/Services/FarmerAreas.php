<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class FarmerAreaService {
    
    private $modelAppService;
    private $tableModel = 'farmer_area';

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM `".$this->tableModel."` WHERE `id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        if($res){
            $query2 = "SELECT COUNT(`id`) AS count_all,SUM(`rai`) AS sum_rai,SUM(`ngan`) AS sum_ngan,SUM(`square`) AS sum_square FROM farmer_area_sub WHERE `farmer_area_id`='".$id."' ORDER BY `id` ASC";
            $dbres2 = $this->modelAppService->fetchObject($query2);
            $res->count_all = $dbres2->count_all;
            $res->sum_rai = $dbres2->sum_rai;
            $res->sum_ngan = $dbres2->sum_ngan;
            $res->sum_square = $dbres2->sum_square;

            $query3 = "SELECT * FROM farmer_area_sub WHERE `farmer_area_id`='".$id."' ORDER BY `id` ASC";
            $dbres3 = $this->modelAppService->fetchObjectAll($query3);
            $res->subs = (!empty($dbres3))?$dbres3:array();  
        }

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

}

?>
