<?
include "include_save_header.php";

if(!$channelCate || !$시도 || !$구군 || !$채널이름 || !$채널태그 || !$channelAge || !$채널설명){
	echo "MANDATORY_ERROR";
	exit;
}

function make_CID(){
	$CID_TMP = rand(1111111111,9999999999);
	$query = "select * from gf_channel where CID = '{$CID_TMP}'";
	$row = db_select($query);

	if($row['pk_channel']>0){
		return make_CID();
	}
	return $CID_TMP;
}

$CID = make_CID();

$채널연령대 = implode(",",$channelAge);

$query = "insert into gf_channel set ";
$query .= "member_id = '{$rowMember['member_id']}',";
$query .= "CID= '{$CID}',";
$query .= "채널카테고리= '{$channelCate}',";
$query .= "시도= '{$시도}',";
$query .= "구군= '{$구군}',";
$query .= "채널이름= '{$채널이름}',";
$query .= "채널배경사진= '{$채널배경사진}',";
$query .= "채널태그= '{$채널태그}',";
$query .= "채널연령대= '{$채널연령대}',";
$query .= "채널설명= '{$채널설명}',";
$query .= "생성일시= NOW(),";
$query .= "결제여부= '미결제'";

db_query($query);

$_SESSION['pk_channel_made'] = mysqli_insert_id();

echo "SUCCESS";