<?
include "include_save_header.php";

//$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

if(!$댓글내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "insert into gf_page_reply set ";
$query .= "fk_page_article='{$fk_page_article}', ";
$query .= "fk_page_reply='{$fk_page_reply}', ";
$query .= "member_id='{$rowMember['member_id']}', ";
$query .= "댓글내용='{$댓글내용}', ";
$query .= "등록일시=NOW() ";

$result = db_query($query);

$query = "select * from gf_page_article where pk_page_article = '{$fk_page_article}'";
$rowA = db_select($query);

$rowM = get_member_row($rowA['member_id']);

if($rowMember['member_id'] != $rowA['member_id']){
	push_act("페이지",$rowMember['member_id'], $rowM['member_id'], "내 페이지 게시글에 ".$rowMember['name']."님의 댓글이 등록되었습니다.", "page_boardview.php?pk_page_article={$fk_page_article}");
}


if($result){
	echo "SUCCESS";
	exit;
}else{
	echo "FAIL";
}