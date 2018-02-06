<?php
function funcUcfirst($str,$strAdd) {
    
    $ex = explode("-", $str);
    $return = '';
    for ($i = 0; $i <= (count($ex)-1); $i++) {
    	$return .= ucfirst($ex[$i]);
	}
	return $return.$strAdd;
}
function getUserLoginID() {
    $data = (isset($_SESSION['user_id']))?$_SESSION['user_id']:0;
    return $data;
}
function getLogUserID() {
    $data = (isset($_SESSION['log_user']))?$_SESSION['log_user']:0;
    return $data;
}
function getRollUserID() {
    $data = (isset($_SESSION['admin_roll_id']))?$_SESSION['admin_roll_id']:0;
    return $data;
}
function getBID() {
    $data = (isset($_SESSION['bid']))?$_SESSION['bid']:'';
    return $data;
}
function getPATHBREADCRUMBS($_req_url) {
    list($_mainmenu,$_controller,$_action_full) = explode("/", $_req_url);
    $ex_action_full = explode("?", $_action_full);
    return $_mainmenu.'-'.$_controller.'.php';
}
function getURLMENU($_req_url,$_URL_REQUEST) {
	list($_mainmenu,$_controller,$_action_full) = explode("/", $_req_url);
	$ex_action_full = explode("?", $_action_full);
	$_param = (!empty($ex_action_full[1]))?$ex_action_full[1]:'';
	$_action = (!empty($ex_action_full[0]))?$ex_action_full[0]:'';
	$_controller = funcUcfirst($_controller,'Controller');
	$_mainmenu = funcUcfirst($_mainmenu,'');
	$_chk_action = explode("-", $_action);
    $_keeplog = (strpos($_URL_REQUEST, 'keep=1') !== false)?1:0;
    $_urlsavelog = str_replace("?keep=1", "", $_URL_REQUEST);
    $_urlsavelog = str_replace("&keep=1", "", $_urlsavelog);

	$actions = '';
	if(!empty($_chk_action)){
		foreach ($_chk_action as $_key => $_value) {
			switch ($_key) {
				case 0:
					$actions .= strtolower($_value);
					break;
				
				default:
					$actions .= ucfirst($_value);
					break;
			}
		}
	}
	$return = ['_mainmenu'=>$_mainmenu,
				'_controller'=>$_controller,
				'actions'=>$actions,
                '_keeplog'=>$_keeplog,
                '_urlsavelog'=>$_urlsavelog];
    return $return;
} 

function getUrlLastForSave($url) {
    if(isset($_GET['draw'])){//check is dataTable
        $return = '';
    } else if($_SERVER['REQUEST_METHOD']=='POST'){
        $return = '';
    } else {
        $url_last = $url;//str_replace("/farcontrol/sst/","",$url);
        list($ex1,$ex2,$ex_action) = explode("/", $url_last);
        $ac_ex1 = explode(".", $ex_action);
        $chAc = explode("?", $ex_action);
        if($ex1=='assets' || $ex1=='app-assets' || $ex1=='address' || $ex1=='load' || $ex1=='uploads' || $ex1=='breadcrumbs' || $url_last=='dashboard/home/index' || $url_last=='admin/home/index'){
        	$return = '';
        } else if($chAc[0]=='find' || $chAc[0]=='find-admin' || $chAc[0]=='pdf'){
            $return = '';
        } else if(count($ac_ex1)==2){
        	$return = '';
        } else {
        	$return = $ex1.'/'.$ex2.'/'.$ex_action;
        }
    }
    return $return;
}

function funcSetButtonClass($action) {
    
    if($action==1 || getRollUserID()==1){
    	$return = '';
    } else if($action==''){
    	$return = 'hide';
    } else {
    	$return = 'hide';
    }
	return $return;
}

function SureRemoveDir($dir, $data) {
     unlink($dir.'/'.$data);
    // while ($file = readdir($dirHandle)) {
    //      if($file==$data) {
    //                 unlink($dir.'/'.$file);
    //      }
    // }
}
function fncObjDateFormatThai($obj) {
    if($obj==''){
        $return='';
    } else {
        list($yy,$mm,$dd) = explode('-', $obj);
        $return= $dd.'/'.$mm.'/'.(intval($yy)+543);
    }
    return $return;
}
function fncObjDateTimeFormatThai($obj) {
    if($obj==''){
        $return='';
    } else {
        list($date,$time) = explode(' ', $obj);
        list($yy,$mm,$dd) = explode('-', $date);
        $return= $dd.'/'.$mm.'/'.(intval($yy)+543).' '.substr($time,0,5);
    }
    return $return;
}
function fncThaiDateToYmd($obj) {
    if($obj==''){
        $return='';
    } else {
        list($dd,$mm,$yy) = explode('/', $obj);
        $return= (intval($yy)-543).'-'.$mm.'-'.$dd;
    }
    return $return;
}
function fncDateTimeToYmdHis($obj) {/*2017/12/29 00:05:54 to 2017-12-29 00:05:54*/
    if($obj==''){
        $return='';
    } else {
        list($date,$time) = explode(' ', $obj);
        list($yy,$mm,$dd) = explode('/', $date);
        $return= $yy.'-'.$mm.'-'.$dd.' '.$time;
    }
    return $return;
}
function fncDateTimeTHToYmdHis($obj) {/*2017-12-28T17:05:54.000Z to 2017-12-28 17:05:54*/
    if($obj==''){
        $return='';
    } else {
        list($date,$time) = explode('T', $obj);
        $return= $date.' '.substr($time,0,8);
    }
    return $return;
}
function fncMonthThai($mm){
    $arr_month = array(   '01'=>'มกราคม' ,
                    '02'=>'กุมภาพันธ์' , 
                    '03'=>'มีนาคม',
                    '04'=>'เมษายน',
                    '05'=>'พฤษภาคม',
                    '06'=>'มิถุนายน',
                    '07'=>'กรกฎาคม',
                    '08'=>'สิงหาคม',
                    '09'=>'กันยายน',
                    '10'=>'ตุลาคม',
                    '11'=>'พฤศจิกายน',
                    '12'=>'ธันวาคม');
    
    return $arr_month[$mm];
}
// ตัวอย่าง 18/09/2510 to 18 ตุลาคม 2510
function fncDateThToText($obj) {
    if($obj==''){
        $return='';
    } else {
        list($dd,$mm,$yy) = explode('/', $obj);
        $return= $dd.' '.fncMonthThai($mm).' '.$yy;
    }
    return $return;
}
// ตัวอย่าง 18/09/2510 to 18 เดือน ตุลาคม พ.ศ 2510
function fncDateThToTextFull($obj) {
    if($obj==''){
        $return='';
    } else {
        list($dd,$mm,$yy) = explode('/', $obj);
        $return= intval($dd).' เดือน '.fncMonthThai($mm).' พ.ศ '.$yy;
    }
    return $return;
}
// ตัวอย่าง 2017-09-04 to 04 เดือน ตุลาคม พ.ศ 2560
function fncDateToText($obj) {
    if($obj==''){
        $return='';
    } else {
        list($yy,$mm,$dd) = explode('-', $obj);
        $return= intval($dd).' '.fncMonthThai($mm).' '.($yy+543);
    }
    return $return;
}
function fncDateToTextFull($obj) {
    if($obj==''){
        $return='';
    } else {
        list($yy,$mm,$dd) = explode('-', $obj);
        $return= intval($dd).' เดือน '.fncMonthThai($mm).' พ.ศ '.($yy+543);
    }
    return $return;
}
// กรณีวันเกิดที่เ็ก็บอยู่ในรูปแบบของ date แบบมาตรฐาน คือ ปี ค.ศ.- เดือน - วันที่
// ตัวอย่าง 1990-02-14
function fncCalAge($obj) {
    if($obj==''){
        $return = '';
    } else {
        $then = strtotime($obj);
        $return = (floor((time()-$then)/31556926));        
    }
    return $return;
}

function fncShowDistrict($pid,$val) {
    $return= ($val=='')?'':(($pid=='1')?'แขวง':'ต.');
    return $return.$val;
}
function fncShowAmphur($pid,$val) {
    $return= ($val=='')?'':(($pid=='1')?'เขต':'อ.');
    return $return.$val;
}

function fncShowProvince($pid,$val) {
    $return= ($val=='')?'':(($pid=='1')?'':'จ.');
    return $return.$val;
}
?>
