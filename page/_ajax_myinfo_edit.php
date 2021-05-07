<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
@session_start();

extract($_POST);

include "include_save_header.php";

$페이지프로필사진 = uploadFile($_FILES, "페이지프로필사진", $페이지프로필사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
//error_debug($페이지프로필사진);

//이름, 비밀번호, 안전거래 비밀번호 체크
if(!$bank_nm|| !$bank_account || !$cert_no){
	echo "MANDATORY_ERROR";
	exit;
}
if($cert_no != $_SESSION['_email_cert_no']){
	echo "CERT_NO_NOT_SAME";
	exit;
}



//db 업데이트
$query = "update tbl_member set ";
$query .= "bank_nm='$bank_nm',";
$query .= "bank_account='$bank_account',";
$query .= "bank_yegeumju='$bank_yegeumju',";
$query .= "닉네임='$닉네임'";
if($rowMember['bitkoex_email']!=$bitkoex_email){
	$query .= ",bitkoex_email='$bitkoex_email'";
	$query .= ",bitkoex_email_status='인증대기'";
}
if($페이지프로필사진){
	$query .= ",페이지프로필사진='$페이지프로필사진' ";
}
$query .= ",updt_dt = NOW() ";
$query .= ",admin_chkneed_yn = 'Y' ";
$query .= " where member_id = '{$rowMember['member_id']}'";


$result = db_query($query);
if($result){
	echo "SUCCESS";
}else{
	echo "FAIL";
}