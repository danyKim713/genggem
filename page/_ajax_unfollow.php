<?
include "include_save_header.php";

$query = "delete from gf_follower where ";
$query .= "parent_member_id = '{$member_id}' and ";
$query .= "child_member_id = '{$rowMember['member_id']}'";

db_query($query);

echo "SUCCESS";
