<?php
require_once _DIR_HOST_.'/models/Services/Trackers.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class TrackerController {

    private $page_name = '';
    private $page_starturl = '';
    private $model = NULL;

    public function __construct() {
        $this->model = new TrackerService();
        $this->page_name = 'Tracker';
        $this->page_starturl = 'out-system/tracker/';
    }
    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'get' ) {
                $this->get();
            } else if ($op == 'save' ) {
                $this->save();
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
    private function get(){
        $arrGet = [];
        foreach ($_GET as $key => $value) {
           if($key<>'request'){ 
                if($key=='start_datetime' || $key=='stop_datetime'){
                    $arrGet[$key] = fncDateTimeTHToYmdHis($value); 
                } else if($key=='start_datetime_th' || $key=='stop_datetime_th'){
                    $arrGet[$key] = fncDateTimeToYmdHis($value); 
                } else {
                    $arrGet[$key]=$value; 
                }
                
           }
        }
        $data =  $this->model->getWhere($arrGet);
        echo json_encode($data); 
    }

    private function save(){
        // foreach ($_POST['positions'] as $key => $value) {
        //     $dataAdd = $value;
        //     unset($dataAdd['_id']);
        //     $dataAdd['inserted'] = fncDateTimeTHToYmdHis($value['inserted']);
        //     $dataAdd['datetime_utc'] = fncDateTimeToYmdHis($value['datetime_utc']);
        //     $dataAdd['datetime_th'] = fncDateTimeToYmdHis($value['datetime_th']);
        //     $dataAdd['datetime'] = fncDateTimeTHToYmdHis($value['datetime']);
        //     $this->model->insertRecord($dataAdd);
        // } 

        if(COUNT($_POST)==0){
            $json_data = ['result'=>'false','message'=>'ไม่พบข้อมูลที่ส่งมาด้วย'];
        } else {
            $data = $_POST;//echo '<pre>'; print_r($_POST);echo '</pre>';exit();
            $data['inserted'] = fncDateTimeTHToYmdHis($_POST['inserted']);
            $data['datetime_utc'] = fncDateTimeToYmdHis($_POST['datetime_utc']);
            $data['datetime_th'] = fncDateTimeToYmdHis($_POST['datetime_th']);
            $data['datetime'] = fncDateTimeTHToYmdHis($_POST['datetime']);

            if(empty($_POST['_id'])){/*insert*/
                $data_id = $this->model->insertRecord($data);
            } else {
                $this->model->updateRecord($_POST['_id'],$data);
                $data_id = $_POST['_id'];
            } 
            if($data_id>0){
                $json_data = ['result'=>'true','message'=>'บันทึกข้อมูลเรียบร้อยแล้ว'];  
            } else {
                $json_data = ['result'=>'false','message'=>'ไม่สามารถบันทึกข้อมูลได้'];
            }

        }

        echo json_encode($json_data);
    }


}
?>
