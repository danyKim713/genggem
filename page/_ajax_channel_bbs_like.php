<?
include "include_save_header.php";

$query = "select count(*) as cnt from gf_channel_bbs_like where ";
$query .= "fk_channel_bbs = '{$pk_channel_bbs}' and ";
$query .= "fk_member='{$rowMember['member_id']}'";
$rowC = db_select($query);
if($rowC['cnt']>0){
	echo "ALREADY";
	exit;
}

$query = "insert into gf_channel_bbs_like set ";
$query .= "fk_channel_bbs = '{$pk_channel_bbs}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "좋아요일시=NOW()";

$result = db_query($query);

if($result){
	echo "SUCCESS";
	exit;
}