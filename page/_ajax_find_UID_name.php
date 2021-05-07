<?
include "include_save_header.php";

@session_start();

extract($_POST);

$query = "select * from tbl_member where UID='$UID'";
$rowM = db_select($query);

if($rowM['name']){
	echo "수신자 성명 : ".$rowM['name'];
	exit;
}

echo "잘못된 UID입니다.";