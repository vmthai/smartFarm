<?php
require_once _DIR_HOST_.'/models/Services/Peoples.php';
require_once _DIR_HOST_.'/models/Services/Prefixs.php';
require_once _DIR_HOST_.'/models/Services/Branchs.php';
require_once _DIR_HOST_.'/models/Services/TypeMembers.php';
require_once _DIR_HOST_.'/models/Services/Address.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class PeopleController {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new PeoplesService();
        $this->page_name = 'ข้อมูลบุคคล';
        $this->page_starturl = 'information/people/';
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
            } else if ($op == 'view' ) {
                $this->view();
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
        #$data =  $this->model->getAll();
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        #$viewHelper->assign('data', $data);
        $viewHelper->display('information/people/index.php'); 
    }

    private function create(){
        $branch =  new BranchsService();
        $branchs = $branch->getAutoCompeteAll();
        $branchs = (!empty($branchs))?$branchs:array();
        $branchs = json_encode($branchs);
        $typemember =  new TypeMembersService();
        $typemembers = $typemember->getOptionAll();
        $prefix =  new PrefixsService();
        $prefixs = $prefix->getOptionAll();
        $address =  new AddressService();
        $provinces = $address->getAllProvince();

        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('branchs', $branchs);
        $viewHelper->assign('typemembers', $typemembers);
        $viewHelper->assign('prefixs', $prefixs);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->display('information/people/create.php'); 
    }
    
    private function edit(){
        $id = $_GET['id'];
        $data = $this->model->getById($id);
        if(!empty($data->id_card)){
            $funService =  new FunctionService();
            $data->id_card = $funService->autoFormatCardID($data->id_card);
        }
        $branch =  new BranchsService();
        $branchs = $branch->getAutoCompeteAll();
        $branchs = (!empty($branchs))?$branchs:array();
        $branchs = json_encode($branchs);
        $typemember =  new TypeMembersService();
        $typemembers = $typemember->getOptionAll();
        $prefix =  new PrefixsService();
        $prefixs = $prefix->getOptionAll();
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
        $viewHelper->assign('branchs', $branchs);
        $viewHelper->assign('typemembers', $typemembers);
        $viewHelper->assign('prefixs', $prefixs);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->assign('amphurs', $amphurs);
        $viewHelper->assign('districts', $districts);
        $viewHelper->assign('contact_amphurs', $contact_amphurs);
        $viewHelper->assign('contact_districts', $contact_districts);
        $viewHelper->display('information/people/edit.php'); 
    }
    private function save(){
        $data = $_POST;//echo '<pre>'; print_r($_POST);echo '</pre>';exit();
        if($data['birth_date']<>''){
            list($st_dd,$st_mm,$st_yy) = explode('/', $data['birth_date']);
            $data['birth_date'] = (intval($st_yy)-543).'-'.$st_mm.'-'.$st_dd;            
        }
        if($data['expired_date']<>''){
            list($ex_dd,$ex_mm,$ex_yy) = explode('/', $data['expired_date']);
            $data['expired_date'] = (intval($ex_yy)-543).'-'.$ex_mm.'-'.$ex_dd;
        }
        if(isset($data['id_card'])){
            $data['id_card'] = str_replace(" ", "", $data['id_card']);
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = getUserLoginID();

        $check = $this->model->checkPeople($_POST['id'],$data['p_name'],$data['p_surname'],$data['id_card']);
        
        if($check>0){
            $json_data = ['result'=>'false','message'=>'ชื่อ-นามสกุล และเลขที่บัตรประชาชนนี้มีข้อมูลอยุ่แล้ว'];
        } else {
            if(!empty($_POST['use_address'])){
                $data['contact_text'] = $data['address_text'];
                $data['contact_province_id'] = $data['address_province_id'];
                $data['contact_amphur_id'] = $data['address_amphur_id'];
                $data['contact_district_id'] = $data['address_district_id'];
                $data['contact_zipcode'] = $data['address_zipcode'];
            }
            if($_POST['id']==''){/*insert*/
                $data['created_at'] = $data['updated_at'];
                $data['created_by'] = $data['updated_by'];
                $data_id = $this->model->insertRecord($data);
            } else {
                $this->model->updateRecord($_POST['id'],$data);
                $data_id = $_POST['id'];
            }

            if($data_id>0){
                $json_data = ['result'=>'true','data'=>$this->model->getById($data_id),'message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
            } else {
                $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
            }
        }

        echo json_encode($json_data);
    }

    private function view(){
        $id = $_GET['id'];
        $data = $this->model->getById($id);
        if(!empty($data->id_card)){
            $funService =  new FunctionService();
            $data->id_card = $funService->autoFormatCardID($data->id_card);
        }
        $branch =  new BranchsService();
        $branchs = $branch->getOptionAll();
        $typemember =  new TypeMembersService();
        $typemembers = $typemember->getOptionAll();
        $prefix =  new PrefixsService();
        $prefixs = $prefix->getOptionAll();
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
        $viewHelper->assign('branchs', $branchs);
        $viewHelper->assign('typemembers', $typemembers);
        $viewHelper->assign('prefixs', $prefixs);
        $viewHelper->assign('provinces', $provinces);
        $viewHelper->assign('amphurs', $amphurs);
        $viewHelper->assign('districts', $districts);
        $viewHelper->assign('contact_amphurs', $contact_amphurs);
        $viewHelper->assign('contact_districts', $contact_districts);
        $viewHelper->display('information/people/view.php'); 
    }
    public function delete() {
        if ($_POST['id']=='') {
            $json_data = ['result'=>'false','message'=>'ไม่สามารถลบข้อมูลได้'];
        } else{
            $re = $this->model->deleteRecord($_POST['id']);
            if($re==true || $re>0){
                $json_data = ['result'=>'true'];
            } else {
                $json_data = ['result'=>'false','message'=>'ไม่สามารถลบข้อมูลได้ ข้อมูลบุคคลนี้ถูกใช้ในข้อมูลสมาชิก'];
            }
            
        }
        echo json_encode($json_data);
    }
    private function find(){
        $funService =  new FunctionService();
        //cut get request
        $dataGet = (!empty($_GET))?$_GET:array();
        if(isset($dataGet['request'])){
            unset($dataGet['request']);
        }

        #_print($dataGet);exit;
        // if(isset($dataGet['draw']) && $dataGet['draw'] ==1){
        //     $result = array(
        //         "draw"            => intval( $dataGet['draw'] ),
        //         "recordsTotal"    => intval( 0 ),
        //         "recordsFiltered" => intval( 0 ),
        //         "data"            => array()
        //     );
        //     echo json_encode($result);
        //     exit;
        // }


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
        $table = 'people';

        // Table's primary key
        $primaryKey = 'pe.id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array();
        $columns[] = array(
            'db' => 'pe.id',
            'dt' => 0,
            'field' => 'id',
            'as' => 'id',
        );
        $columns[] = array(
            'db' => "CONCAT(pr.name,pe.p_name,' ',pe.p_surname)",
            'dt' => 1,
            'field' => 'fullname',
            'as' => 'fullname',
        );
        $columns[] = array(
            'db' => 'pe.id_card',
            'dt' => 2,
            'field' => 'id_card',
        );
        $columns[] = array(
            'db' => "br.name",
            'dt' => 3,
            'field' => 'branch_name',
            'as' => 'branch_name',
        );
        $columns[] = array(
            'db' => "IF(pe.branch_id IS NULL OR pe.id_card IS NULL OR (LENGTH(pe.id_card)!=13) OR pe.birth_date IS NULL OR pe.expired_date IS NULL OR pe.instinct IS NULL OR pe.occupation IS NULL OR (pe.address_text IS NULL OR pe.address_district_id IS NULL OR pe.address_amphur_id IS NULL OR pe.address_province_id IS NULL) OR pe.contact_phone IS NULL,'data_null','')",
            'dt' => 4,
            'field' => 'status_data',
            'as' => 'status_data',
        );
        $columns[] = array(
            'db' => "pe.branch_id",
            'dt' => 5,
            'field' => 'branch_id',
            'as' => 'branch_id',
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

        $joinQuery = "FROM `people` AS pe 
        LEFT JOIN `prefix` AS pr ON (pe.`prefix_id`=pr.`id`)
        LEFT JOIN `branch` AS br ON pe.`branch_id`=br.`id`
        ";
        
        if(getRollUserID()==3 && getBID()>1 ){
            $extraWhere = "(`branch_id`='".getBID()."' OR `branch_id` IS NULL)";
        } else {
            $extraWhere = "";
        }

        $groupBy = "";
        $having = "";

        $result = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having );

        $start=$_GET['start'];
        $start++;
        foreach($result['data'] as &$res){
            //format show id card
            if(!empty($res[2])){
                $res[2] = $funService->autoFormatCardID($res[2]);
            }
            //ที่อยู่
            if($res[4]!='data_null'){
                $res[4] = '<button type="button" class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>';
            } else {
                $res[4] = '<button type="button" class="btn btn-xs btn-danger"><i class="fa fa-times "></i></button>';
            }            

            //set action
            $html_act = '';
            // if(getRollUserID()>2 || ($res[5]==getBID())){
            if(getBID()>1){
            $html_act .= '
            <div class="btn-group">
                <a class="btn btn-primary '.funcSetButtonClass($action_bt->edit).'" href="javascript:fncLoadContent(\''.$this->page_starturl.'edit?bid='.getBID().'&id='.$res[0].'\');"><i class="fa fa-pencil"></i></a>
                <a class="btn btn-info '.funcSetButtonClass($action_bt->view).'" href="javascript:fncLoadContent(\''.$this->page_starturl.'view?bid='.getBID().'&id='.$res[0].'\');"><i class="fa fa-search"></i></a>
            </div>
            ';
            } else {
            $html_act .= '
            <div class="btn-group">
                 <a class="btn btn-primary '.funcSetButtonClass($action_bt->edit).'" href="javascript:fncLoadContent(\''.$this->page_starturl.'edit?bid='.getBID().'&id='.$res[0].'\');"><i class="fa fa-pencil"></i></a>
                <a class="btn btn-info '.funcSetButtonClass($action_bt->view).'" href="javascript:fncLoadContent(\''.$this->page_starturl.'view?bid='.getBID().'&id='.$res[0].'\');"><i class="fa fa-search"></i></a>
                <a class="btn btn-danger '.funcSetButtonClass($action_bt->delete).'" href="javascript:fncClickDeltete(\''.$res[0].'\',\''.$start.'\');"><i class="icon_close_alt2"></i></a>
            </div>
            ';
            }
            $res[5]=$html_act;

            $res[0]=(string)$start;
            $start++;
        }
        echo json_encode($result);
    }
}
?>
