<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
include "include_save_header.php";

extract($_POST);

//이름, 휴대폰, 인증번호 등 필수 항목 체크
if(!$name || !$emai1 || !$cert_no){
	echo "MANDATORY_ERROR";
	exit;
}

//인증번호 체크
if($cert_no != $_SESSION['_email_cert_no']){
	echo "CERT_ERROR";
	exit;
}

if($_SESSION['_cert_email'] != $email){
	echo "CERT_ERROR";
	exit;
}

//회원존재여부
$member_cnt =  db_count("gf_member", "이메일='$email1'  and 이름='$name1'", "*");

if ($member_cnt == 0  ) {
	echo "NOT_EXISTS";
	exit;
}

$query = "select * from gf_member where 이름='$name' and 이메일='$email'";
$row = db_select($query);

$_SESSION['_reset_security_password_email'] = $row['email'];

echo "SUCCESS";
exit;