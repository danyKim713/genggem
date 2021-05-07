<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
@session_start();

extract($_POST);

include "include_save_header.php";

$페이지배경사진 = uploadFile($_FILES, "페이지배경사진", $페이지배경사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
$페이지프로필사진 = uploadFile($_FILES, "페이지프로필사진", $페이지프로필사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
error_debug($페이지배경사진);
error_debug($페이지프로필사진);

if(!$페이지이름 || !$시도 || !$구군 || !$출신지역 || !$birthday || !$gender || !$공개여부){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "select * from tbl_member where 닉네임='$닉네임' and member_id != '{$rowMember['member_id']}'";
$rowM = db_select($query);

if($rowM['member_id']){
	//echo "DUP_NICKNAME";
	//exit;
}

$query = "update tbl_member set ";

if($페이지배경사진){
	$query .= "페이지배경사진='$페이지배경사진',";
}
if($페이지프로필사진){
	$query .= "페이지프로필사진='$페이지프로필사진',";
}
$query .= "페이지이름='$페이지이름',";
$query .= "닉네임='$닉네임',";
$query .= "시도='$시도',";
$query .= "구군='$구군',";
$query .= "출신지역='$출신지역',";
$query .= "birthday='$birthday',";
$query .= "gender='$gender',";
$query .= "결혼여부='$결혼여부',";
$query .= "결혼기념일='$결혼기념일',";
$query .= "출신고등학교='$출신고등학교',";
$query .= "출신대학교='$출신대학교',";
$query .= "공개여부='$공개여부'";

$query .= " where member_id = '{$rowMember['member_id']}'";

//echo $query;

$result = db_query($query);

echo "SUCCESS";
exit;