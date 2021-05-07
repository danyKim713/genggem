<?
include "include_save_header.php";

$query = "select count(*) as cnt from gf_channel_reply_like where ";
$query .= "fk_channel_reply = '{$pk_channel_reply}' and ";
$query .= "fk_member='{$rowMember['member_id']}'";

$rowC = db_select($query);
if($rowC['cnt']>0){
	echo "ALREADY";
	exit;
}

$query = "insert into gf_channel_reply_like set ";
$query .= "fk_channel_reply = '{$pk_channel_reply}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "좋아요일시=NOW()";

$result = db_query($query);

if($result){
	echo "SUCCESS";
	exit;
}