<?
include "include_save_header.php";

//$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

if(!$댓글내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "insert into gf_gallery_reply set ";
$query .= "fk_gallery='{$fk_gallery}', ";
$query .= "fk_gallery_reply='{$fk_gallery_reply}', ";
$query .= "member_id='{$rowMember['member_id']}', ";
$query .= "댓글내용='{$댓글내용}', ";
$query .= "등록일시=NOW() ";

$result = db_query($query);

$query = "select * from gf_gallery where pk_gallery = '{$fk_gallery}'";
$rowA = db_select($query);

$rowM = get_member_row($rowA['member_id']);
push_act("클럽",$rowMember['member_id'], $rowM['member_id'], "클럽 갤러리에 ".$rowMember['name']."님의 댓글이 등록되었습니다.", "channel_gallery_view.php?CID=<?=$CID?>&pk_gallery={$fk_gallery}");


if($result){
	echo "SUCCESS";
	exit;
}else{
	echo "FAIL";
}