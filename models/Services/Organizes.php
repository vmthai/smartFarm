<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class OrganizesService {
    
    private $modelAppService;
    private $tableModel = 'organize';

    public function __construct() {
        $this->modelAppService = new AppService();
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

}

?>
