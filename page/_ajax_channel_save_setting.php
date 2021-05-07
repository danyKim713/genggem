<?
include "include_save_header.php";

$query = "update tbl_member set ";
$query .= "채널관심주제 = '".implode("/",$채널관심주제)."',";
$query .= "채팅글알림사용여부= '".($채팅글알림사용여부=="Y"?"Y":"N")."}',";
$query .= "메시지알림사용여부= '".($메시지알림사용여부=="Y"?"Y":"N")."}' ";

$query .= " where member_id = '{$rowMember['member_id']}'";

db_query($query);

echo "SUCCESS";