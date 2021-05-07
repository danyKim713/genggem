<?
$_GET['CID'] = $_SESSION['S_CID'];

include "include_save_header.php";

//$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

if(!$채팅내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "select count(*) as cnt from gf_chatting_history where ";
$query .= " fk_channel='{$rowChannel['pk_channel']}' ";
$query .= " and fk_member='{$rowMember['member_id']}' ";
$query .= " and 채팅내용 = '[{$rowMember['name']}]님이 입장하셨습니다.'";
$rowE = db_select($query);

if($rowE['cnt']>0 && strpos($채팅내용, "입장하셨습니다.")>-1){
	echo "ENTRANCE_AGAIN";
	exit;
}



$query = "insert into gf_chatting_history set ";
$query .= "fk_channel='{$rowChannel['pk_channel']}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "채팅내용='".strip_tags($채팅내용)."',";
$query .= "채팅일시=NOW()";

$result = db_query($query);

if($result){
	echo "SUCCESS";
}