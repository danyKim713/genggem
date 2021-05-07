<?
$NO_LOGIN = "Y";

include "include_save_header.php";

extract($_POST);


//이름, 휴대폰, 인증번호 등 필수 항목 체크
if(!$name || !$email || !$cert_no){
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
$member_cnt =  db_count("tbl_member", "email='$email'  and name='$name'", "*");

if ($member_cnt == 0  ) {
	echo "NOT_EXISTS";
	exit;
}

$query = "select * from tbl_member where name='$name' and email='$email'";
$row = db_select($query);

$_SESSION['_reset_email'] = $row['email'];

echo "SUCCESS";
exit;