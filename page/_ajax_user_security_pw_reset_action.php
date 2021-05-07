<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
@session_start();

extract($_POST);

include $_SERVER["DOCUMENT_ROOT"] . "/_PROGRAM_inc/include_default.php";

if(!$security_passwd || !$security_passwd2){
	echo "MANDATORY_ERROR";
	exit;
}

if($security_passwd != $security_passwd2){
	echo "PASSWD_NOT_SAME";
	exit;
}

//세션 체크
/*
if(!$_SESSION['_reset_email']){
	echo "CERT_ERROR";
	exit;
}
*/

//$query = "update tbl_member set security_passwd=md5('{$security_passwd}') where email='{$_SESSION['_reset_email']}'";
$query = "update tbl_member set security_passwd=md5('{$security_passwd}') where email='{$email1}'";
db_query($query);
echo "SUCCESS";
exit;