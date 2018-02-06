<?php
require_once _DIR_HOST_.'/models/Services/CaltivationTemplate.php';
require_once _DIR_HOST_.'/models/Services/PlantType.php';
require_once _DIR_HOST_.'/models/Services/SeedType.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class CaltivationTemplateController {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new CaltivationTemplateService();
        $this->page_name = 'Configutation / Cultivation Template';
        $this->page_starturl = 'config/caltivation-template/';
    }
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ($op == 'create' ) {
                $this->$op();
            } else if ($op == 'save' || $op == 'saveProcess' || $op == 'saveCultiPeriod') {
                $this->$op();
            } else if ($op == 'info' ) {
                $this->$op();
            } else if ($op == 'edit' ) {
                $this->$op();
            } else if ($op == 'delete' || $op == 'deleteProcess') {
                $this->$op();
            } else if ($op == 'find' ) {
                $this->$op();
            }  else if ($op == 'getSeed' ) {
                $this->$op();
            }  else if ($op == 'getProcess' ) {
                $this->$op();
            } else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
            // some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function showError($title, $message) {
        include 'views/error.php';
    }

    /*
    * @param  array $this->params
    * @return display
    */
    private function index(){
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->display($this->page_starturl.'index.php'); 
    }

    private function create(){
        $plantType = new PlantTypeService();
        $dataPlant = $plantType->getOptionAll();
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('dataPlant', $dataPlant);
        $viewHelper->display($this->page_starturl.'create.php'); 
    }

    private function find(){
        //cut get request
        $dataGet = (!empty($_GET))?$_GET:array();
        if(isset($dataGet['request'])){
            unset($dataGet['request']);
        }
        #_print($dataGet);exit;

        //get action button
        $acButton = new ActionButtonService();
        $action_bt = $acButton->getActionButton();
        //////////////////////////////////////////////////////////////////
        


        // DB table to use
        $table = 'cultivation';

        // Table's primary key
        $primaryKey = 'c.id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array();
        $columns[] = array(
            'db' => 'c.id',
            'dt' => 0,
            'field' => 'seq_no',
            'as' => 'seq_no',
        );
        $columns[] = array(
            'db' => 'c.template_name',
            'dt' => 1,
            'field' => 'cultivation_name',
            'as' => 'cultivation_name',
        );
        $columns[] = array(
            'db' => 'pt.name_th',
            'dt' => 2,
            'field' => 'plant_name',
            'as' => 'plant_name',
        );
        $columns[] = array(
            'db' => 'st.name_th',
            'dt' => 3,
            'field' => 'seed_name',
            'as' => 'seed_name',
        );
        $columns[] = array(
            'db' => 'c.culti_period',
            'dt' => 4,
            'field' => 'cultivation_period',
            'as' => 'cultivation_period',
        );
        $columns[] = array(
            'db' => 'c.yield',
            'dt' => 5,
            'field' => 'yield_rai',
            'as' => 'yield_rai',
        );
        $columns[] = array(
            'db' => 'c.active',
            'dt' => 6,
            'field' => 'active',
            'as' => 'active',
        );
        $columns[] = array(
            'db' => 'c.id',
            'dt' => 7,
            'field' => 'action',
            'as' => 'action',
        );

        // SQL server connection information
        $sql_details = array(
            'user' => _DB_USERNAME_,
            'pass' => _DB_PASSWORD_,
            'db'   => _DB_DATABASE_,
            'host' => _DB_HOST_
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        require_once _DIR_HOST_.'/models/datatables.class.php';

        $joinQuery = "FROM cultivation AS c
        LEFT JOIN plant_type AS pt ON pt.id = c.plant_type_id 
        LEFT JOIN seed_type AS st ON st.id = c.seed_type_id
        ";
        $extraWhere = "";
        
        $groupBy = "";
        $having = "";

        $result = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having );

        $start=$_GET['start'];
        $start++;
        foreach($result['data'] as &$res){
            //set action
            $html_act = '';
            if($res[6] == 1){
                $html_act .= '
                    <a data-action="expand" class="btn btn-sm btn-outline-info" href="javascript:fncLoadContent(\''.$this->page_starturl.'info?id='.$res[7].'\');"><span class="icon-paper"></span></a>';
            }
            $html_act .= '
                <a data-action="expand" class="btn btn-sm btn-outline-primary" href="javascript:fncLoadContent(\''.$this->page_starturl.'edit?id='.$res[7].'\');"><span class="icon-pencil2"></span></a>
                <a data-action="expand" class="btn btn-sm btn-outline-danger" href="javascript:fncClickDeltete(\''.$res[7].'\',\''.$start.'\');"><span class="icon-bin2"></span></a>
            ';
            $res[7]=$html_act;

            $res[0]=(string)$start;
            $start++;
        }
        echo json_encode($result);
    }

    private function getSeed(){
        $plant_id = $_GET['plant_id'];
        $seedType = new SeedTypeService();
        $dataSeed = $seedType->getOptionAllByPlantID($plant_id);
        echo json_encode($dataSeed);
    }

    private function edit(){
        $id = $_GET['id'];
        $data = $this->model->getById($id);
        $dataProcess = $this->model->getProcessListAllByCultivationID($data->id);
        $plantType = new PlantTypeService();
        $dataPlant = $plantType->getOptionAll();
        $seedType = new SeedTypeService();
        $dataSeed = $seedType->getOptionAllByPlantID($data->plant_type_id);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('dataProcess', $dataProcess);
        $viewHelper->assign('dataPlant', $dataPlant);
        $viewHelper->assign('dataSeed', $dataSeed);
        $viewHelper->display($this->page_starturl.'edit.php');
    }

    private function save(){
        $data = $_POST;
        $data['active'] = (empty($_POST['active']))?'NULL':1;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();
        $checkDup = array();
        $checkDup['template_name'] = $_POST['template_name'];
        $resultDup = $this->model->checkDuplicate($checkDup,$_POST['id']);
        if(!empty($resultDup)){
            $json_data = ['result'=>'false','message'=>'ชื่อ Template นี้ถูกใช้แล้ว'];
        } else {
            if($_POST['id']==''){/*insert*/
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = getUserLoginID();
                $last_id = $this->model->insertRecord($data);
                if($last_id>0){
                    $checkLastData = $this->model->getById($last_id);
                    if($checkLastData->template_name == $_POST['template_name'] && $checkLastData->created_at == $data['created_at']){
                        $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว','caltivation_id'=>$last_id];
                    } else {
                        $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว','caltivation_id'=>''];
                    }
                } else {
                    $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้','caltivation_id'=>''];
                }
            } else {
                $res = $this->model->updateRecord($_POST['id'],$data);
                if(!empty($res)){
                    $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว','caltivation_id'=>''];  
                } else {
                    $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้','caltivation_id'=>''];
                }
            }            
        }
        echo json_encode($json_data);
    }

    public function delete() {
        if ($_POST['id']=='') {
            $json_data = ['result'=>'false','message'=>'ไม่สามารถลบข้อมูลได้'];
        } else{
            $re = $this->model->deleteRecord($_POST['id']);
            //delete Record Process
            $dataProcess = $this->model->getProcessListAllByCultivationID($_POST['id']);
            if(!empty($dataProcess)){
                foreach($dataProcess as $item){
                    $this->model->deleteRecordProcess($item->id);
                }
            }
            $json_data = ['result'=>'true','message'=>'ลบข้อมูลเรียบร้อยแล้ว'];
        }
        echo json_encode($json_data);
    }

    private function info(){
        $id = $_GET['id'];
        $data = $this->model->getById($id);
        $dataProcess = $this->model->getProcessListAllByCultivationID($data->id);
        $plantType = new PlantTypeService();
        $namePlant = $plantType->getById($data->plant_type_id);
        $namePlant = $namePlant->fullname;
        $seedType = new SeedTypeService();
        $nameSeed = $seedType->getById($data->seed_type_id);
        $nameSeed = $nameSeed->fullname;
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('dataProcess', $dataProcess);
        $viewHelper->assign('namePlant', $namePlant);
        $viewHelper->assign('nameSeed', $nameSeed);
        $viewHelper->display($this->page_starturl.'information.php'); 
    }

    private function saveProcess(){
        $data = $_POST;
        //unset เวลา / วัน ต่อจาก
        if(isset($data['set_start'])){
            unset($data['set_start']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();
        if($_POST['id']==''){
            //insert
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = getUserLoginID();
            $last_id = $this->model->insertRecordProcess($data);
        } else {
            $this->model->updateRecordProcess($_POST['id'],$data);
            $last_id = $_POST['id'];
        }
        if($last_id>0){
            $culti_period_id = (!empty($data['cultivation_id']))?$data['cultivation_id']:'';
            $dataProcess = $this->model->getProcessListAllByCultivationID($culti_period_id);
            $sum_cost = 0;
            if(!empty($dataProcess)){
                foreach($dataProcess as $item){
                    $sum_cost += $item->budget;
                }
            }
            $dataUpdate = array();
            $dataUpdate['cost'] = $sum_cost;
            $dataUpdate['updated_at'] = date('Y-m-d H:i:s');
            $dataUpdate['updated_by'] = getUserLoginID();
            $this->model->updateRecord($culti_period_id,$dataUpdate);
            $this->listProcess($culti_period_id);
        }
    }

    private function saveCultiPeriod(){
        $data = array();
        $data['culti_period'] = $_POST['culti_period'];
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();
        $res = $this->model->updateRecord($_POST['id'],$data);
        if(!empty($res)){
            $this->listProcess($_POST['id']);
        }
    }

    private function listProcess($cultivation_id){
        $data = $this->model->getById($cultivation_id);
        $dataProcess = $this->model->getProcessListAllByCultivationID($cultivation_id);
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('dataProcess', $dataProcess);
        $viewHelper->display($this->page_starturl.'process-list.php'); 
    }

    public function deleteProcess() {
        if ($_POST['id']=='') {
            $json_data = ['result'=>'false','message'=>'ไม่สามารถลบข้อมูลได้'];
        } else{
            $re = $this->model->deleteRecordProcess($_POST['id']);
            $json_data = ['result'=>'true','message'=>'ลบข้อมูลเรียบร้อยแล้ว'];
        }
        echo json_encode($json_data);
    }

    private function getProcess(){
        $id = $_POST['process_id'];
        $data = $this->model->getProcessById($id);
        echo json_encode($data);
    }

}
?>
