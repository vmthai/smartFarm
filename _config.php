<?php
$_isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $_isSecure = true;
} elseif ((!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')) {
    $_isSecure = true;
}

define('_PROJECT_NAME_','farc');
$_REQUEST_PROTOCOL = ($_isSecure) ? 'https' : 'http';
define('_HTTP_SSL_',$_REQUEST_PROTOCOL.'://');//check http or https
define('_PATH_HOST_', dirname($_SERVER['PHP_SELF']));//current directory
define('_HTTP_HOST_',_HTTP_SSL_.$_SERVER['HTTP_HOST']._PATH_HOST_);//url host
$_REDIRECT_URL = (isset($_SERVER['REQUEST_URI']))?$_SERVER['REQUEST_URI']:'';
define('_URL_REQUEST_',str_replace(_PATH_HOST_.'/','',$_REDIRECT_URL));//url host

define('_DIR_HOST_', dirname(__FILE__));//file of directory
define('_TITLE_SITE_','Smart Farm');
date_default_timezone_set('Asia/Bangkok');

/*--Connect Database--*/
if($_SERVER['SERVER_NAME'] == 'localhost'){
	define('_DB_HOST_','localhost');
	define('_DB_DATABASE_','far_control');
	define('_DB_USERNAME_','root');
	define('_DB_PASSWORD_','');
} else {
	define('_DB_HOST_','localhost');
	define('_DB_DATABASE_','bsiamtech_farcontrol');
	define('_DB_USERNAME_','bsiamtech');
	define('_DB_PASSWORD_','KGYbp5');
}

?>