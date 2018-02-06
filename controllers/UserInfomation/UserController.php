<?php
require_once _DIR_HOST_.'/models/Services/AdminUsers.php';
require_once _DIR_HOST_.'/models/Services/AdminRolls.php';
require_once _DIR_HOST_.'/models/Services/AdminMenus.php';
require_once _DIR_HOST_.'/models/Services/AdminUserMenus.php';
require_once _DIR_HOST_.'/models/Services/MasterGroups.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class UserController {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new AdminUsersService();
        $this->page_name = 'User / User Infomation';
        $this->page_starturl = 'user-infomation/user/';
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
        $adminroll =  new AdminRollsService();
        $dataRoll = $adminroll->getAll();

        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('groups', $groups);
        $viewHelper->assign('dataRoll', $dataRoll);
        $viewHelper->display($this->page_starturl.'create.php'); 
    }

    private function edit(){
        $id = $_GET['id'];
        $group =  new MasterGroupsService();
        $groups = $group->getOptionAll();
        $data = $this->model->getById($id);
        $adminroll =  new AdminRollsService();
        $dataRoll = $adminroll->getAll();
        $adminmenus =  new AdminMenusService();
        $dataMenu =  $adminmenus->getByAdminRoll($data->admin_roll_id);
        //echo '<pre>';print_r($data);echo '</pre>';exit();
        $viewHelper = new ViewHelper();
        $viewHelper->assign('page_name', $this->page_name);
        $viewHelper->assign('page_starturl', $this->page_starturl);
        $viewHelper->assign('data', $data);
        $viewHelper->assign('groups', $groups);
        $viewHelper->assign('dataRoll', $dataRoll);
        $viewHelper->assign('dataMenu', $dataMenu);
        $viewHelper->display($this->page_starturl.'edit.php');

    }
    private function save(){
        $data = $_POST;
        $data['active'] = (empty($_POST['active']))?'NULL':1;
        $data['birth_date'] = fncThaiDateToYmd($_POST['birth_date']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $_SESSION['user_id'];
        unset($data['menu']);

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
            $check = $this->model->checkUserName($_POST['id'],$_POST['username']);

            if($check==1){
                $json_data = ['result'=>'false','message'=>'ชื่อนี้ถูกใช้แล้ว'];
            } else {
                if($_POST['id']==''){/*insert*/
                    $res = $this->model->insertRecord($data);
                } else {
                    $res = $this->model->updateRecord($_POST['id'],$data);
                    $usermenus = new AdminUserMenusService();
                    $usermenus->deleteWhereUserId($_POST['id']);
                    if(!empty($_POST['menu'])){
                        foreach ($_POST['menu'] as $k => $v) {
                            $valUserMenu['admin_user_id'] = $_POST['id'];
                            $valUserMenu['admin_menu_id'] = $k;
                            $valUserMenu['add'] = empty($v['add'])?NULL:$v['add'];
                            $valUserMenu['edit'] = empty($v['edit'])?NULL:$v['edit'];
                            $valUserMenu['view'] = empty($v['view'])?NULL:$v['view'];
                            $valUserMenu['delete'] = empty($v['delete'])?NULL:$v['delete'];
                            $valUserMenu['updated_at'] = date('Y-m-d H:i:s');
                            $valUserMenu['updated_by'] = $_SESSION['user_id'];
                            $usermenus->insertRecord($valUserMenu);
                        }
                    }

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
        $table = 'admin_user';

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
            'db' => 'au.name',
            'dt' => 1,
            'field' => 'name',
            'as' => 'name',
        );
        $columns[] = array(
            'db' => 'mg.name',
            'dt' => 2,
            'field' => 'group_name',
            'as' => 'group_name',
        );
        $columns[] = array(
            'db' => 'au.phone',
            'dt' => 3,
            'field' => 'phone',
            'as' => 'phone',
        );
        $columns[] = array(
            'db' => 'ar.name',
            'dt' => 4,
            'field' => 'roll_name',
            'as' => 'roll_name',
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

        $joinQuery = "FROM `admin_user` AS au 
        LEFT JOIN `master_group` AS mg ON (au.`master_group_id`=mg.`id`)
        LEFT JOIN `admin_roll` AS ar ON (au.`admin_roll_id`=ar.`id`)
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
