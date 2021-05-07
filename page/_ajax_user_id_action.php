<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
@session_start();

extract($_POST);

include $_SERVER["DOCUMENT_ROOT"] . "/_PROGRAM_inc/include_default.php";

//이름, 휴대폰, 인증번호 등 필수 항목 체크
if(!$name || !$hp_nation || !$hp || !$cert_no){
	echo "MANDATORY_ERROR";
	exit;
}

if(substr($hp,0,1)=="0"){
	$hp = substr($hp,1);
}

//인증번호 체크
if($cert_no != $_SESSION['_sms_cert_no']){
	echo "CERT_ERROR";
	exit;
}

if($_SESSION['_cert_country_id'] != $hp_nation){
	echo "CERT_ERROR";
	exit;
}
if($_SESSION['_cert_hp'] != $hp){
	echo "CERT_ERROR";
	exit;
}

//회원존재여부
$member_cnt =  db_count("tbl_member", "replace(hp,'-','')  ='".str_replace("-","",$hp)."'  and name='$name' and country_id='$hp_nation'", "*");

if ($member_cnt == 0  ) {
	echo "NOT_EXISTS";
	exit;
}

$query = "select * from tbl_member where name='$name' and country_id='$hp_nation' and replace(hp,'-','')='".str_replace("-","",$hp)."'";
$row = db_select($query);

//마스킹처리 $len1: 남길앞자리수 , $len2 : 남길 뒷자리수
$_SESSION['_found_email'] = $row['email'];

echo "SUCCESS";
exit;