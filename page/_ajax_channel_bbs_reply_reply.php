<?
include "include_save_header.php";

//$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

if(!$댓글내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "insert into gf_channel_reply set ";
$query .= "fk_channel_bbs='{$pk_channel_bbs}', ";
$query .= "fk_channel_reply='{$pk_channel_reply}', ";
$query .= "fk_member='{$rowMember['member_id']}', ";
$query .= "댓글내용='{$댓글내용}', ";
$query .= "댓글일시=NOW() ";

$result = db_query($query);


if($result){
	echo "SUCCESS";
	exit;
}else{
	echo "FAIL";
}