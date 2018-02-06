<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class AdminUserMenusService {
    
    private $modelAppService;

    public function __construct() {
        $this->modelAppService = new AppService();
        $this->tb_main = 'admin_user_menu';
    }

    public function insertRecord($post) {
        $this->modelAppService->openDb();
        $data = $this->modelAppService->setDataInsert($post);
        $fields = $data['fields'];
        $values = $data['values'];
        $query = "INSERT INTO $this->tb_main ($fields) VALUES ($values)";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }

    public function updateRecord($id,$post) {
        $this->modelAppService->openDb();
        $fields = $this->modelAppService->setDataUpdate($post);
        $query = "UPDATE $this->tb_main SET $fields WHERE id=$id";
        $res = $this->modelAppService->queryDB($query);
        $this->modelAppService->closeDb();
        return $res;
    }

    public function deleteWhereUserId($id) {
        try {
            $this->modelAppService->openDB();
            $dbId = $this->modelAppService->realEscapeString($id);
            $result = $this->modelAppService->queryDB("DELETE FROM admin_user_menu WHERE `admin_user_id`=$dbId");
            $this->modelAppService->closeDB();
            return $result;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}

?>
