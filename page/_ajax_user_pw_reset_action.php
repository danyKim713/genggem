<?
$NO_LOGIN = "Y";

include "include_save_header.php";

extract($_POST);
/**
**/

if(!$passwd || !$passwd2){
	echo "MANDATORY_ERROR";
	exit;
}

if($passwd != $passwd2){
	echo "PASSWD_NOT_SAME";
	exit;
}

//세션 체크
if(!$_SESSION['_reset_email']){
	echo "CERT_ERROR";
	exit;
}

$query = "update tbl_member set passwd=md5('{$passwd}') where email='{$_SESSION['_reset_email']}'";
db_query($query);

echo "SUCCESS";
exit;