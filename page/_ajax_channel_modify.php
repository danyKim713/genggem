<?
include "include_save_header.php";

if(!$channelCate || !$시도 || !$구군 || !$채널이름 || !$채널태그 || !$channelAge || !$채널설명){
	echo "MANDATORY_ERROR";
	exit;
}

$CID = $_SESSION['S_CID'];

$채널배경사진 = uploadFile($_FILES, "채널배경사진", $채널배경사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

$채널연령대 = implode(",",$channelAge);

$query = "update gf_channel set ";
$query .= "채널카테고리= '{$channelCate}',";
$query .= "시도= '{$시도}',";
$query .= "구군= '{$구군}',";
$query .= "채널이름= '{$채널이름}',";
if($채널배경사진){
	$query .= "채널배경사진= '{$채널배경사진}',";
}
$query .= "채널태그= '{$채널태그}',";
$query .= "채널연령대= '{$채널연령대}',";
$query .= "채널설명= '{$채널설명}',";
$query .= "최종수정일시= NOW() ";

$query .= " where member_id = '{$rowMember['member_id']}' and CID = '{$CID}'";

db_query($query);

echo "SUCCESS";