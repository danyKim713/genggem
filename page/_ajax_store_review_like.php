<?
include "include_save_header.php";

$query = "select count(*) as cnt from tbl_store_review_like where ";
$query .= "review_id = '{$review_id}' and ";
$query .= "fk_member='{$rowMember['member_id']}'";
$rowC = db_select($query);
if($rowC['cnt']>0){
	echo "ALREADY";
	exit;
}

$query = "insert into tbl_store_review_like set ";
$query .= "review_id = '{$review_id}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "좋아요일시=NOW()";

$result = db_query($query);

if($result){
	echo "SUCCESS";
	exit;
}