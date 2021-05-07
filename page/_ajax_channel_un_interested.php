<?
include "include_save_header.php";

$query = "select * from gf_channel where CID = '{$CID}'";
$rowC = db_select($query);

$query = "delete from gf_channel_interested where ";
$query .= "fk_channel = '{$rowC['pk_channel']}' and ";
$query .= "fk_member= '{$rowMember['member_id']}'";

db_query($query);

echo "SUCCESS";