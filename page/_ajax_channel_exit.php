<?
include "include_save_header.php";

$query = "delete from gf_channel_member where fk_member = '{$rowMember['member_id']}' and fk_channel = '{$pk_channel}'";
db_query($query);

echo "SUCCESS";