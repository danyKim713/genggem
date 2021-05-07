<?
include "include_save_header.php";

$query = "insert into tbl_store_review_reply_like set ";
$query .= "fk_store_review_reply = '{$fk_store_review_reply}',";
$query .= "member_id = '{$rowMember['member_id']}',";
$query .= "등록일시 = NOW()";

db_query($query);

echo "SUCCESS";
