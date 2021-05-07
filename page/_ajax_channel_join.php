<?
include "include_save_header.php";

$query = "select count(*) as cnt from gf_channel_member where fk_channel='{$pk_channel}' and fk_member = '{$rowMember['member_id']}' and 강퇴여부 = 'Y'";
$rowG = db_select($query);

if($rowG['cnt']>0){
	echo "OUT_ALREADY";
	exit;
}


$query = "insert into gf_channel_member set ";
$query .= "fk_channel = '{$pk_channel}',";
$query .= "fk_member = '{$rowMember['member_id']}',";
$query .= "운영진여부 = 'N',";
$query .= "강퇴여부 = 'N',";
$query .= "가입일시 = NOW()";
db_query($query);

$query = "select * from gf_channel where pk_channel = '{$pk_channel}'";
$rowCh = db_select($query);

//개설자
push_act("카페",$rowMember['member_id'], $rowCh['member_id'], "{$rowMember['name']}님이 카페에 가입하셨습니다.", "cafe.php?CID=".$rowCh['CID']);

$query = "select * from gf_channel_member where fk_channel = '{$pk_channel}' and 운영진여부='Y' and 강퇴여부='N'";
$result = db_query($query);
while($row = db_fetch($result)){
	//운영진
	push_act("카페",$rowMember['member_id'], $row['fk_member'], "{$rowMember['name']}님이 카페에 가입하셨습니다.", "cafe.php?CID=".$rowCh['CID']);
}

echo "SUCCESS";