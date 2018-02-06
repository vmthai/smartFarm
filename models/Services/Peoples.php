<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class PeoplesService {
    
    private $modelAppService;
    private $tableModel = 'people';

    public function __construct() {
        $this->modelAppService = new AppService();
    }


    public function getById($id) {
        $this->modelAppService->openDb();
        $query = "SELECT pe.*, ad.`district_name`, aa.`amphur_name`, ap.`province_name`, cad.`district_name` AS contact_district_name, caa.`amphur_name` AS contact_amphur_name, cap.`province_name` AS contact_province_name
            FROM `".$this->tableModel."` AS pe 
            LEFT JOIN `address_district` AS ad ON pe.`address_district_id`=ad.`district_id` 
            LEFT JOIN `address_amphur` AS aa ON pe.`address_amphur_id`=aa.`amphur_id` 
            LEFT JOIN `address_province` AS ap ON pe.`address_province_id`=ap.`province_id`
            LEFT JOIN `address_district` AS cad ON pe.`contact_district_id`=cad.`district_id` 
            LEFT JOIN `address_amphur` AS caa ON pe.`contact_amphur_id`=caa.`amphur_id` 
            LEFT JOIN `address_province` AS cap ON pe.`contact_province_id`=cap.`province_id` 
                    WHERE pe.`id`=$id";
        $res = $this->modelAppService->fetchObject($query);
        if($res->birth_date){
            $res->birth_date_th = fncObjDateFormatThai($res->birth_date);
        }
        $this->modelAppService->closeDb();
        return $res;
    }

    public function checkPeople($id,$p_name) {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM `".$this->tableModel."` WHERE `p_name`='$p_name'";
        if($id<>''){
            $query .= " AND `id`!='$id'";
        }

        $res = $this->modelAppService->queryDB($query);
        $num = $res->num_rows;

        if ($num>0) {
            $return = ['result'=>1]; 
        } else {
            $return = ['result'=>0]; 
        }
        $this->modelAppService->closeDb();
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
        $query = "SELECT pe.`id`,pe.`p_name` AS name,pe.`id_card`
            FROM `".$this->tableModel."` AS pe 
            WHERE (pe.`p_name` LIKE '%".$var."%' OR pe.`id_card` LIKE '%".$var."%')
            ORDER BY pe.`p_name` ASC LIMIT 0,20";
        $dbres = $this->modelAppService->fetchObjectAll($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }

}

?>
