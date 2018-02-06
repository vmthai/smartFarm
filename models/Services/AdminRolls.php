<?php
require_once 'models/AppService.php';
require_once 'models/ValidationException.php';

class AdminRollsService {
    
    private $modelAppService;
    private $tableModel = 'admin_roll';

    public function __construct() {
        $this->modelAppService = new AppService();
    }
    public function getAll() {
        $this->modelAppService->openDb();
        $query = "SELECT * FROM ".$this->tableModel." ORDER BY `id` ASC";
        $dbres = $this->modelAppService->fetchSelectOption($query);
        $res = (!empty($dbres))?$dbres:array();
        $this->modelAppService->closeDb();
        return $res;
    }   
}

?>
