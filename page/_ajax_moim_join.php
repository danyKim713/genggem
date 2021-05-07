<?
include "include_save_header.php";

$query = "select count(*) as cnt from gf_moim_member where fk_moim = '$pk_moim' and fk_member = '{$rowMember['member_id']}'";
$rowCnt = db_select($query);

if($rowCnt['cnt']>0){
	echo "ALREADY";
	exit;
}


$query = "insert into gf_moim_member set ";
$query .= "fk_moim = '{$pk_moim}',";
$query .= "fk_member = '{$rowMember['member_id']}',";
$query .= "참여일시 = NOW()";

db_query($query);

echo "SUCCESS";