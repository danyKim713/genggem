<?
include "include_save_header.php";

$query = "delete from tbl_store_favorite where ";
$query .= "fk_store_id = '{$store_id}' and ";
$query .= "fk_member_id = '{$rowMember['member_id']}'";

db_query($query);

echo "SUCCESS";