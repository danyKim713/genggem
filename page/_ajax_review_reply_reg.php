<?
include "include_save_header.php";

//$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

if(!$댓글내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "insert into tbl_store_review_reply set ";
$query .= "review_id='{$review_id}', ";
$query .= "fk_store_review_reply='{$fk_store_review_reply}', ";
$query .= "fk_member='{$rowMember['member_id']}', ";
$query .= "댓글내용='{$댓글내용}', ";
$query .= "댓글일시=NOW() ";

$result = db_query($query);

$query = "select * from tbl_store_review where review_id = '{$review_id}'";
$rowA = db_select($query);

$rowM = get_member_row($rowA['member_id']);

if($rowM['member_id'] != $rowMember['member_id']){
	push_act("제휴점",$rowMember['member_id'], $rowM['member_id'], "제휴점 이용후기에 ".$rowMember['name']."님의 댓글이 등록되었습니다.", "franchise_review_read.php?review_id={$review_id}");
}


if($result){
	echo "SUCCESS";
	exit;
}else{
	echo "FAIL";
}