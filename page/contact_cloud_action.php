<?
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE); 

$NO_LOGIN = true;
include  "inc_program.php"; 

if(!$이름 || !$토큰이름 || !$문의내용 || !$휴대전화){
	msg_only("Mandatory data is not input.");
}

$query = "insert into tbl_cloud_qna set ";

$query .= "member_id='{$rowMember['member_id']}',";
$query .= "이름='$이름',";
$query .= "이메일='$이메일',";
$query .= "휴대전화='$휴대전화',";
$query .= "토큰이름='$토큰이름',";
$query .= "문의내용='$문의내용',";
$query .= "아이피='{$_SERVER['REMOTE_ADDR']}',";
$query .= "문의일시=NOW(),";
$query .= "처리상태='신규접수'";

db_query($query);

msg_top_page("Thank you for your contact.","contact_cloud_view.php");