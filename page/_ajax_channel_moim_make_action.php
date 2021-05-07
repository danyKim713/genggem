<?php
require_once "include_save_header.php";

if(!$CID || !$모임날짜시간 || !$시도|| !$구군 || !$모임장소 || !$모임제목 || !$모임설명 || ($모임참가비용 != "0" && !$모임참가비용) || !$모임정원){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "select * from gf_channel where CID = '{$CID}'";
$rowCh = db_select($query);

$시간 = explode(" / ", $모임날짜시간);
$모임날짜 = $시간[0];
$모임시간 = $시간[1];

$query = "insert into gf_moim set ";
$query .= "fk_channel = '{$rowCh['pk_channel']}',";
$query .= "member_id='{$rowMember['member_id']}',";
$query .= "모임날짜='{$모임날짜}',";
$query .= "모임시간='{$모임시간}',";
$query .= "시도='{$시도}',";
$query .= "구군='{$구군}',";
$query .= "모임장소='{$모임장소}',";
$query .= "모임제목='{$모임제목}',";
$query .= "모임설명='{$모임설명}',";
$query .= "모임참가비용='{$모임참가비용}',";
$query .= "모임정원='{$모임정원}',";
$query .= "모임개설공지여부='{$모임개설공지여부}',";
$query .= "생성일시=NOW()";

$result = db_query($query);

$fk_moim = mysqli_insert_id($conn);

/**
$query = "insert into gf_moim_member set ";
$query .= "fk_moim = '{$fk_moim}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "참여일시=NOW()";

$result = db_query($query);
**/


if($모임개설공지여부 == "Y"){
	//모든 회원들에게 푸쉬 날리기
	$query = "select * from gf_channel_member where fk_channel = '{$rowCh['pk_channel']}'";
	$result = db_query($query);

	while($row = db_fetch($result)){
		$rowM = get_member_row($row['fk_member']);

		push_act($rowCh['member_id'], $rowM['member_id'], "[".$rowCh['채널이름']."] 모임이 생성되었습니다.", "cafe.php?CID={$rowCh['CID']}");
	}

	//운영자에게 푸쉬 전송
	push_act("카페",$rowCh['member_id'], $rowCh['member_id'], "[".$rowCh['채널이름']."] 모임이 생성되었습니다.", "cafe.php?CID={$rowCh['CID']}");

}

if($result){
	echo "SUCCESS";
}else{
	echo "FAIL";
}