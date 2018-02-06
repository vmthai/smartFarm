<?php
session_start();
require_once('config.php');
require_once('views/includes/php-function.php');
$request_url = (isset($_GET["request"]))?$_GET["request"]:'';
$request_url = (!empty($request_url))?explode("/", $request_url):array();
if(!empty($_SESSION) && isset($_SESSION['project_name']) && $_SESSION['project_name'] == _PROJECT_NAME_ && !empty($_SESSION['log_user'])){
	if(count($request_url) == 3){
		$st_login = '';
	} else {
		if(!empty($request_url[0]) && $request_url[0] == 'logout'){
			$st_login = 'logout';
		} else if(empty($_GET["request"])) {
			$st_login = 'home-index';
		} else {
			$st_login = 'home';
		}
	}
} else if(empty($_SESSION) && !empty($_POST['username']) && !empty($_POST['password'])){
	if(count($request_url) == 3){
		$st_login = '';
	} else {
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
		    echo 'logout';
			exit;
		} else {
			$st_login = 'logout';
		}
	}
} else {
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	    echo 'logout';
		exit;
	} else if(!empty($_SESSION)){
		$st_login = 'logout';
	} else {
		$st_login = 'login-form';
	}
}

//check Active User
if(!empty($_SESSION['user_id']) && ($st_login == '' || $st_login == 'home')){
	require_once(_DIR_HOST_.'/models/Services/AdminUsers.php');
	$modelAdminUsers = new AdminUsersService();
	$_resultActive = $modelAdminUsers->chkActiveUser($_SESSION['user_id']);
	unset($modelAdminUsers);
	if(empty($_resultActive)){
		$st_login = 'logout';
	}
}

switch ($st_login) {
	case 'login-form':
		require_once(_DIR_HOST_.'/controllers/Home/HomeController.php');
		$controller = new HomeController;
		$controller->handleRequest('index');
		break;
	case 'logout':
		require_once(_DIR_HOST_.'/controllers/Home/HomeController.php');
		$controller = new HomeController;
		$controller->handleRequest('logout');
		break;
	default:
		// $_req_url = $_GET["request"];
		// if(is_array($_GET) && count($_GET) > 1){
		// 	$value_get = $_GET;
		// 	unset($value_get['request']);
		// 	$dataget = '';
		// 	foreach ($value_get as $_keyget => $_valueget) {
		// 		$dataget .= ($dataget)?'&':'';
		// 		$dataget .= $_keyget.'='.$_valueget;
		// 	}
		// 	$_req_url .= '?'.$dataget;
		// }
		$getURL = getURLMENU($_GET["request"],_URL_REQUEST_);
		$_mainmenu = $getURL["_mainmenu"];
		$_controller = $getURL["_controller"];
		$actions = $getURL["actions"];
		$_keeplog = $getURL["_keeplog"];
		$_urlsavelog = $getURL["_urlsavelog"];

		/*เก็บ log*/
		if(!empty($_SESSION['log_user']) && $_keeplog==1){
			require_once(_DIR_HOST_.'/models/Services/LogUserLogins.php');
			$ctl_log = new LogUserLoginsService();
			$ctl_log->saveLogUser($_urlsavelog);
		}

		/*load page*/
		if(is_file(_DIR_HOST_.'/controllers/'.$_mainmenu.'/'.$_controller.'.php') === true){
			require_once(_DIR_HOST_.'/controllers/'.$_mainmenu.'/'.$_controller.'.php');
			$controller = new $_controller();
			$controller->handleRequest($actions);
		} else {
			$title = "Page not found";
			$message = "Page for operation "._HTTP_HOST_.$_SERVER['REDIRECT_URL']." was not found!";
			include _DIR_HOST_.'/views/error.php';
		}
		break;
}

?>
