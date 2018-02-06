<?php
require_once _DIR_HOST_.'/models/Services/FarmerGroups.php';
require_once _DIR_HOST_.'/models/Services/MasterGroups.php';
require_once _DIR_HOST_.'/models/Services/Address.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class FarmerGroupController {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new FarmerGroupService();
        $this->page_name = 'Farmer / Farmer Group';
        $this->page_starturl = 'farmer/farmer-group/';
    }
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'index' ) {
                $this->index();
            } else if ($op == 'create' ) {
                $this->create();
            } else if ($op == 'save' ) {
                $this->save();
            } else if ($op == 'edit' ) {
                $this->edit();
            } else if ($op == 'delete' ) {
                $this->delete();
            } else if ($op == 'find' ) {
                $this->find();
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
        $amphurs = $address->getAmphurByProvince($data->address_province_id);
        $districts = $address->getDistrictByAmphur($data->address_amphur_id);
        $contact_amphurs = $address->getAmphurByProvince($data->contact_province_id);
        $contact_districts = $address->getDistrictByAmphur($data->contact_amphur_id);

        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('groups', $groups);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->assign('amphurs', $amphurs);
        $viewHelper->assign('districts', $districts);
        $viewHelper->assign('contact_amphurs', $contact_amphurs);
        $viewHelper->assign('contact_districts', $contact_districts);
        $viewHelper->display($this->page_starturl.'edit.php');

    }
    private function save(){
        $data = $_POST;
        $data['active'] = (empty($_POST['active']))?'NULL':1;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $_SESSION['user_id'];

        $checkUP = ['result'=>'true'];
        if(!empty($_FILES["fileUpload"]["name"])){
            $fncService = new FunctionService();
            $reUpImg = $fncService->fncUploadImg($_FILES["fileUpload"],"uploads/farmer/");
            if($reUpImg['result']=='true'){
                $data['path_image'] = $reUpImg['name'];
            }
            $checkUP = $reUpImg;
        }
        
        if($checkUP['result']=='true'){
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
        $table = 'farmer_group';

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
            'db' => 'au.farmer_gname',
            'dt' => 1,
            'field' => 'farmer_gname',
            'as' => 'farmer_gname',
        );
        $columns[] = array(
            'db' => 'mg.name',
            'dt' => 2,
            'field' => 'gName',
            'as' => 'gName',
        );
        $columns[] = array(
            'db' => 'au.contact_name',
            'dt' => 3,
            'field' => 'contact_name',
            'as' => 'contact_name',
        );
        $columns[] = array(
            'db' => 'au.contact_phone',
            'dt' => 4,
            'field' => 'contact_phone',
            'as' => 'contact_phone',
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

        $joinQuery = ", mg.`name` AS gName
        FROM
        farmer_group AS au
        LEFT JOIN master_group AS mg
        ON au.master_group_id = mg.id 
        ";
        if(getRollUserID()==2){
            $extraWhere = "au.`admin_roll_id`>1 ";
        } else {
            $extraWhere = "";
        }
        
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
                <a data-action="expand" class="btn btn-sm btn-outline-primary" href="javascript:fncLoadContent(\''.$this->page_starturl.'edit?id='.$res[5].'\');"><span class="icon-pencil2"></span></a>
                <a data-action="expand" class="btn btn-sm btn-outline-danger" href="javascript:fncClickDeltete(\''.$res[5].'\',\''.$start.'\');"><span class="icon-bin2"></span></a>
            ';
            $res[5]=$html_act;

            $res[0]=(string)$start;
            $start++;
        }
        echo json_encode($result);
    }
}
?>
