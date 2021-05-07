<?
include "include_save_header.php";

$query = "select * from gf_channel where CID = '{$CID}'";
$rowC = db_select($query);

$query = "select count(*) as cnt from gf_channel_interested where fk_channel = '{$rowC['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowCnt = db_select($query);

if($rowCnt['cnt']>0){
	echo "ALREADY";
	exit;
}


$query = "insert into gf_channel_interested set ";
$query .= "fk_channel = '{$rowC['pk_channel']}',";
$query .= "fk_member= '{$rowMember['member_id']}',";
$query .= "관심일시= NOW()";

db_query($query);

echo "SUCCESS";