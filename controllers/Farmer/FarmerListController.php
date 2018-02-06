<?php
require_once _DIR_HOST_.'/models/Services/FarmerLists.php';
require_once _DIR_HOST_.'/models/Services/FarmerGroups.php';
require_once _DIR_HOST_.'/models/Services/MasterGroups.php';
require_once _DIR_HOST_.'/models/Services/Address.php';
require_once _DIR_HOST_.'/models/Services/Peoples.php';
require_once _DIR_HOST_.'/models/Services/FarmerAreas.php';
require_once _DIR_HOST_.'/models/Services/FarmerAreaSubs.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class FarmerListController {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new FarmerListService();
        $this->page_name = 'Farmer / Farmer List';
        $this->page_starturl = 'farmer/farmer-list/';
    }
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ($op == 'create' ) {
                $this->$op();
            } else if ($op == 'save' ) {
                $this->$op();
            } else if ($op == 'info' ) {
                $this->$op();
            } else if ($op == 'edit' ) {
                $this->$op();
            } else if ($op == 'delete' ) {
                $this->$op();
            } else if ($op == 'find' ) {
                $this->$op();
            } else if ($op == 'gmapsFarea' ) {
                $this->$op();
            } else if ($op == 'gmapsFlocation' ) {
                $this->$op();
            } else if ($op == 'gmapsShow' ) {
                $this->$op();
            }else {
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

    private function info(){
        $id = $_GET['id'];
        $group =  new MasterGroupsService();
        $groups = $group->getOptionAll();
        $data = $this->model->getById($id);
        $address =  new AddressService();
        $provinces = $address->getAllProvince();
        $amphurs = $address->getAmphurByProvince($data->company_province_id);
        $districts = $address->getDistrictByAmphur($data->company_amphur_id);

        $peoples =  new PeoplesService();
        $dataPeople = $peoples->getById($id);
        $funService =  new FunctionService();
        if(!empty($dataPeople->id_card)){
            $dataPeople->id_card = $funService->autoFormatCardID($dataPeople->id_card);
        }
        $data->sum_area = $funService->fncRaiNgan($data->sum_rai,$data->sum_ngan,$data->sum_square);
        foreach ($data->areas as $k => $v) {
            $v->sum_area = $funService->fncRaiNgan($v->sum_rai,$v->sum_ngan,$v->sum_square);
        }
        
        //echo '<pre>';print_r($data);echo '</pre>';exit();
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('groups', $groups);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->assign('amphurs', $amphurs);
        $viewHelper->assign('districts', $districts);
        $viewHelper->assign('dataPeople', $dataPeople);
        $viewHelper->assign('tab', (empty($_GET['tab'])?'1':$_GET['tab']));
        $viewHelper->display($this->page_starturl.'infomation.php'); 
    }

    private function create(){
        $group =  new MasterGroupsService();
        $groups = $group->getOptionAll();
        $address =  new AddressService();
        $provinces = $address->getAllProvince();

        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('groups', $groups);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->display($this->page_starturl.'create.php'); 
    }

    private function edit(){
        $id = $_GET['id'];
        $group =  new MasterGroupsService();
        $groups = $group->getOptionAll();
        $data = $this->model->getById($id);
        $address =  new AddressService();
        $provinces = $address->getAllProvince();
        $amphurs = $address->getAmphurByProvince($data->company_province_id);
        $districts = $address->getDistrictByAmphur($data->company_amphur_id);
        
        //echo '<pre>';print_r($data);echo '</pre>';exit();
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('groups', $groups);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->assign('amphurs', $amphurs);
        $viewHelper->assign('districts', $districts);
        $viewHelper->display($this->page_starturl.'edit.php');

    }
    private function save(){
        $data = $_POST;
        $data['active'] = (empty($_POST['active']))?'NULL':1;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();

        $checkUP = ['result'=>'true'];
        if(!empty($_FILES["fileUpload"]["name"])){
            $fncService = new FunctionService();
            $reUpImg = $fncService->fncUploadImg($_FILES["fileUpload"],"uploads/user/");
            if($reUpImg['result']=='true'){
                $data['path_image'] = $reUpImg['name'];
            }
            $checkUP = $reUpImg;
        }
        
        if($checkUP['result']=='true'){
            $check = $this->model->checkPID($_POST['id'],$_POST['people_id']);

            if($check==1){
                $json_data = ['result'=>'false','message'=>'ชื่อนี้ถูกใช้แล้ว'];
            } else {
                if($_POST['id']==''){/*insert*/
                    $res = $this->model->insertRecord($data);
                } else {
                    $res = $this->model->updateRecord($_POST['id'],$data);
                }
                 if($res==1){
                    $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
                } else {
                    $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
                }
            }
        } else {
            $json_data = $checkUP;
        }

        echo json_encode($json_data);
    }

    public function delete() {
        if ($_POST['id']=='') {
            $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
        } else{
            $re = $this->model->deleteRecord($_POST['id']);
            $json_data = ['result'=>'true'];
        }
        echo json_encode($json_data);
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
        
        /*
         * DataTables example server-side processing script.
         *
         * Please note that this script is intentionally extremely simply to show how
         * server-side processing can be implemented, and probably shouldn't be used as
         * the basis for a large complex system. It is suitable for simple use cases as
         * for learning.
         *
         * See http://datatables.net/usage/server-side for full details on the server-
         * side processing requirements of DataTables.
         *
         * @license MIT - http://datatables.net/license_mit
         */

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

        // DB table to use
        $table = 'farmer_list';

        // Table's primary key
        $primaryKey = 'au.id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array();
        $columns[] = array(
            'db' => 'au.id',
            'dt' => 0,
            'field' => 'id',
            'as' => 'id',
        );
        $columns[] = array(
            'db' => 'pe.p_name',
            'dt' => 1,
            'field' => 'farmer_name',
            'as' => 'farmer_name',
        );
        $columns[] = array(
            'db' => 'fg.farmer_gname',
            'dt' => 2,
            'field' => 'gName',
            'as' => 'gName',
        );
        $columns[] = array(
            'db' => 'mg.name',
            'dt' => 3,
            'field' => 'tName',
            'as' => 'tName',
        );
        $columns[] = array(
            'db' => 'pe.phone',
            'dt' => 4,
            'field' => 'farmer_phone',
            'as' => 'farmer_phone',
        );
        $columns[] = array(
            'db' => 'au.id',
            'dt' => 5,
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

        $joinQuery = ", mg.`name` AS tName, fg.`farmer_gname` AS gName
        FROM farmer_list AS au
        LEFT JOIN people AS pe ON au.people_id = pe.id 
        LEFT JOIN master_group AS mg ON au.master_group_id = mg.id 
        LEFT JOIN farmer_group AS fg ON au.farmer_group_id = fg.id";
        $extraWhere = "";
        
        $groupBy = "";
        $having = "";

        $result = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having );

        $start=$_GET['start'];
        $start++;
        foreach($result['data'] as &$res){    
// <a data-action="expand" class="btn btn-sm btn-outline-primary" href="javascript:fncLoadContent(\''.$this->page_starturl.'pdf?id='.$res[5].'\');"><span class="icon-printer"></span></a>
//<a data-action="expand" class="btn btn-sm btn-outline-primary" href="javascript:fncLoadContent(\''.$this->page_starturl.'view?id='.$res[5].'\');"><span class="icon-search"></span></a>
            //set action
            $html_act = '';
            $html_act .= '
                <a data-action="expand" class="btn btn-sm btn-outline-info" href="javascript:fncLoadContent(\''.$this->page_starturl.'info?id='.$res[5].'\');"><span class="icon-paper"></span></a>
                <a data-action="expand" class="btn btn-sm btn-outline-primary" href="javascript:fncLoadContent(\''.$this->page_starturl.'edit?id='.$res[5].'\');"><span class="icon-pencil2"></span></a>
                <a data-action="expand" class="btn btn-sm btn-outline-danger" href="javascript:fncClickDeltete(\''.$res[5].'\',\''.$start.'\');"><span class="icon-bin2"></span></a>
            ';
            $res[5]=$html_act;

            $res[0]=(string)$start;
            $start++;
        }
        echo json_encode($result);
    }

    private function gmapsFarea(){
        $viewHelper = new ViewHelper();
        $viewHelper->display($this->page_starturl.'gmaps-Farea.php'); 
    }
    private function gmapsFlocation(){
        $viewHelper = new ViewHelper();
        $viewHelper->display($this->page_starturl.'gmaps-Flocation.php'); 
    }
    private function gmapsShow(){
        $viewHelper = new ViewHelper();
        $viewHelper->display($this->page_starturl.'gmaps-Show.php'); 
    }

}
?>
