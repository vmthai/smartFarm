<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class BranchsService {
    
    private $modelAppService;
    private $tableModel = 'branch';

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    public function getAll() {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM `".$this->tableModel."` WHERE `id`>1 ORDER BY `id` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }

    public function getOptionAll() {
        $this->modelAppService->openDB();
        $dbres = $this->modelAppService->fetchSelectOption("SELECT `id`,`name`
                            FROM `".$this->tableModel."`
                            WHERE `active`=1 ORDER BY `name` ASC "); 
        $this->modelAppService->closeDB();
        $return = (!empty($dbres))?$dbres:array();
        return $return;
    }
    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT b.*, ad.`district_name`, aa.`amphur_name`, ap.`province_name`
         FROM `".$this->tableModel."` AS b 
            LEFT JOIN `address_district` AS ad ON b.`address_district_id`=ad.`district_id` 
            LEFT JOIN `address_amphur` AS aa ON b.`address_amphur_id`=aa.`amphur_id` 
            LEFT JOIN `address_province` AS ap ON b.`address_province_id`=ap.`province_id`
        WHERE b.`id`=$id";
        $res = $this->modelAppService->fetchObject($query);
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

    public function getAutoCompeteAll() {
        try {
            $this->modelAppService->openDB();
            $dbres = $this->modelAppService->fetchObjectAll("SELECT `id`,`name`
                            FROM `".$this->tableModel."`
                            WHERE `active`=1 ORDER BY `name` ASC ");
            $res = (!empty($dbres))?$dbres:array();
            $this->modelAppService->closeDB();
            return $res;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /*public function getBranchsOrderByName($branchid_from, $branchid_to) {
        $this->modelAppService->openDB();
        $query_from = "SELECT `name` FROM `".$this->tableModel."` WHERE `id`='".$branchid_from."'";
        $branch_from = $this->modelAppService->fetchObject($query_from);
        $query_to = "SELECT `name` FROM `".$this->tableModel."` WHERE `id`='".$branchid_to."'";
        $branch_to = $this->modelAppService->fetchObject($query_to);
        $query = "SELECT b.`id`,b.`name`,b.`address`,b.`address_province_id`,b.`address_zipcode`,b.`phone`, ad.`district_name`, aa.`amphur_name`, ap.`province_name`
        FROM `".$this->tableModel."` b
        LEFT JOIN `address_district` AS ad ON b.`address_district_id`=ad.`district_id` 
        LEFT JOIN `address_amphur` AS aa ON b.`address_amphur_id`=aa.`amphur_id` 
        LEFT JOIN `address_province` AS ap ON b.`address_province_id`=ap.`province_id`
        WHERE b.active=1 AND b.`name` BETWEEN '".$branch_from->name."' AND '".$branch_to->name."' ORDER BY b.`name` ASC ";
        $branchs = $this->modelAppService->fetchObjectAll($query);
        $data = (!empty($branchs))?$branchs:array();
        $this->modelAppService->closeDB();
        return $data;
    }*/

    public function getBranchsOrderByCode($branchid_from, $branchid_to) {
        $this->modelAppService->openDB();
        $query_from = "SELECT `code_branch` FROM `".$this->tableModel."` WHERE `id`='".$branchid_from."'";
        $branch_from = $this->modelAppService->fetchObject($query_from);
        $query_to = "SELECT `code_branch` FROM `".$this->tableModel."` WHERE `id`='".$branchid_to."'";
        $branch_to = $this->modelAppService->fetchObject($query_to);
        $query = "SELECT b.`id`,b.`name`,b.`address`,b.`address_province_id`,b.`address_zipcode`,b.`phone`, ad.`district_name`, aa.`amphur_name`, ap.`province_name`,b.`code_branch`
        FROM `".$this->tableModel."` b
        LEFT JOIN `address_district` AS ad ON b.`address_district_id`=ad.`district_id` 
        LEFT JOIN `address_amphur` AS aa ON b.`address_amphur_id`=aa.`amphur_id` 
        LEFT JOIN `address_province` AS ap ON b.`address_province_id`=ap.`province_id`
        WHERE b.active=1 AND b.`code_branch` BETWEEN '".$branch_from->code_branch."' AND '".$branch_to->code_branch."' ORDER BY b.`code_branch` ASC ";
        $branchs = $this->modelAppService->fetchObjectAll($query);
        $data = (!empty($branchs))?$branchs:array();
        $this->modelAppService->closeDB();
        return $data;
    }

    public function getAutoCompeteAllOrderByCode() {
        try {
            $this->modelAppService->openDB();
            $dbres = $this->modelAppService->fetchObjectAll("SELECT `id`,IF(`code_branch` IS NULL,`name`,CONCAT(`code_branch`,' ',`name`)) AS name
                            FROM `".$this->tableModel."`
                            WHERE `active`=1 ORDER BY `code_branch` ASC ");
            $res = (!empty($dbres))?$dbres:array();
            $this->modelAppService->closeDB();
            return $res;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
    public function getAutoCompeteAllOrderByCodeNoSST() {
        try {
            $this->modelAppService->openDB();
            $dbres = $this->modelAppService->fetchObjectAll("SELECT `id`,IF(`code_branch` IS NULL,`name`,CONCAT(`code_branch`,' ',`name`)) AS name
                            FROM `".$this->tableModel."`
                            WHERE `id`>1 AND `active`=1 ORDER BY `code_branch` ASC ");
            $res = (!empty($dbres))?$dbres:array();
            $this->modelAppService->closeDB();
            return $res;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
    public function getBranchNameById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT `name`
         FROM `".$this->tableModel."`
         WHERE `id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        $data = (!empty($res->name))?$res->name:'';
        $this->modelAppService->closeDb();
        return $data;
    }
    public function getDataById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM `".$this->tableModel."` WHERE `id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        $this->modelAppService->closeDb();
        return $res;
    }
}

?>
