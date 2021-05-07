<?
include "include_save_header.php";

$query = "insert into gf_page_reply_like set ";
$query .= "fk_page_reply = '{$pk_page_reply}',";
$query .= "member_id = '{$rowMember['member_id']}',";
$query .= "등록일시 = NOW()";

db_query($query);

echo "SUCCESS";
