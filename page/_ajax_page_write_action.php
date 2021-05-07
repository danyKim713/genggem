<?
include "include_save_header.php";

//$페이지배경사진 = uploadFile($_FILES, "페이지배경사진", $페이지배경사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

//error_log(print_r($이미지파일명_array, true));

if(!$내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "insert into gf_page_article set ";
$query .= "member_id='{$rowMember['member_id']}',";
$query .= "내용='$내용',";
$query .= "등록일시=NOW()";

$result = db_query($query);

$fk_page_article = mysqli_insert_id($conn);

for ($i=0; $i<count($이미지파일명_array); $i++){
	$query = "insert into gf_page_photo set ";
	$query .= "fk_page_article = '{$fk_page_article}',";
	$query .= "이미지파일명 = '{$이미지파일명_array[$i]}'";

	db_query($query);
}

$query = "select friend_member_id as member_id from gf_friends where origin_member_id = '{$rowMember['member_id']}' and 진행상태 = '친구수락' 

	UNION

	select origin_member_id as member_id from gf_friends where friend_member_id = '{$rowMember['member_id']}' and 진행상태 = '친구수락'

	UNION

	select child_member_id as member_id from gf_follower where parent_member_id = '{$rowMember['member_id']}'";

$resultf = mysqli_query($conn, $query);

while($rowf = db_fetch($resultf)){

	push_act("페이지",$rowMember['member_id'], $rowf['member_id'], "{$rowMember['닉네임']}님의 페이지에 새글이 등록되었습니다.", "page_board.php");

}

if($result){
	echo "SUCCESS";
	exit;
}