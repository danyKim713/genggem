<?
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE); 

$NO_LOGIN = true;
include  "inc_program.php"; 

if(!$name || !$subject || !$message){
	msg_only("Mandatory data is not input.");
}

$query = "insert into tbl_contact set ";
$query .= "name='$name',";
$query .= "email='$email',";
$query .= "subject='$subject',";
$query .= "message='$message',";
$query .= "member_id='{$rowMember['member_id']}',";
$query .= "ip='$ip',";
$query .= "regdate=NOW(),";
$query .= "status='신규접수'";
db_query($query);

msg_top_page("감사합니다. 문의가 정상적으로 접수되었습니다.","contact.php");