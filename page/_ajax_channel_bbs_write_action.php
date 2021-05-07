<?
include "include_save_header.php";

$query = "select * from gf_channel where CID = '{$_SESSION['S_CID']}'";
$rowCh = db_select($query);

//$페이지배경사진 = uploadFile($_FILES, "페이지배경사진", $페이지배경사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

//error_log(print_r($이미지파일명_array, true));

if(!$내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "insert into gf_channel_bbs set ";
$query .= "fk_channel = '{$rowCh['pk_channel']}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "내용='$내용',";
$query .= "등록일시=NOW()";

$result = db_query($query);

$fk_channel_bbs = mysqli_insert_id($conn);

for ($i=0; $i<count($이미지파일명_array); $i++){
	$query = "insert into gf_channel_bbs_img set ";
	$query .= "fk_channel_bbs = '{$fk_channel_bbs}',";
	$query .= "이미지파일명 = '{$이미지파일명_array[$i]}'";

	db_query($query);
}

//개설자
push_act("모임",$rowMember['member_id'], $rowCh['member_id'],  "{$rowCh['채널이름']}에 새글이 등록되었습니다.", "cafe_view2.php?CID=".$rowCh['CID']);

$query = "select * from gf_channel_member where fk_channel = '{$rowCh['pk_channel']}' and 운영진여부='Y' and 강퇴여부='N'";
$result = db_query($query);
while($row = db_fetch($result)){
	//운영진
	push_act("모임",$rowMember['member_id'], $row['fk_member'], "{$rowCh['채널이름']}에 새글이 등록되었습니다.", "cafe_view2.php?CID=".$rowCh['CID']);
}


if($result){
	echo "SUCCESS";
	exit;
}