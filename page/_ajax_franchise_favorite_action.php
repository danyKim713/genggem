<?
include "include_save_header.php";

$query = "insert into tbl_store_favorite set ";
$query .= "fk_store_id = '{$store_id}',";
$query .= "fk_member_id = '{$rowMember['member_id']}'";

db_query($query);

echo "SUCCESS";