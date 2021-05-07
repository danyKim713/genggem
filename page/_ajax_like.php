<?
include "include_save_header.php";

$query = "select count(*) as cnt from gf_page_like where ";
$query .= "fk_page_article = '{$pk_page_article}' and ";
$query .= "member_id = '{$rowMember['member_id']}'";
$rowC = db_select($query);
if($rowC['cnt']>0){
	echo "ALREADY";
	exit;
}

$query = "insert into gf_page_like set ";
$query .= "fk_page_article = '{$pk_page_article}',";
$query .= "member_id = '{$rowMember['member_id']}',";
$query .= "등록일시 = NOW()";

db_query($query);

echo "SUCCESS";
